<?php
namespace Crisnao2\DisposableEmail;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use GuzzleHttp\Exception\TransferException;
use Exception;

/**
 * Class to check if an email address is disposable
 * 
 * @author Cristiano Soares
 * @site comerciobr.com
 * @version 1.0
 */
class Check
{
    /**
     * Cache expiration time for the disposable email domains list.
     *
     * This variable defines how long the cached list of disposable email domains
     * should be considered valid before a refresh is needed.
     * 
     * The value is calculated as follows:
     * 60 seconds * 60 minutes * 24 hours * 30 days = 2,592,000 seconds
     * 
     * Current setting: 30 days
     *
     * @var int Expiration time in seconds
     */
    private static int $cacheListExpireDays = 60 * 60 * 24 * 30; // 30 days

    /**
     * URL for the list of disposable email domains.
     *
     * This URL points to a configuration file on GitHub that contains
     * an up-to-date list of disposable email domains. The list is
     * community-maintained and regularly updated.
     *
     * @var string
     */
    private static string $urlListDisposableDomains = 'https://raw.githubusercontent.com/disposable-email-domains/disposable-email-domains/refs/heads/main/disposable_email_blocklist.conf';

    /**
     * Retrieves a list of disposable email domains.
     *
     * This function attempts to fetch a list of disposable email domains from a cache file.
     * If the cache is not available or has expired, it fetches the list from a remote URL.
     * The fetched list is then cached for future use.
     *
     * @throws Exception If there's an error in fetching or processing the domain list.
     *
     * @return array An array of disposable email domains.
     */
    private static function listDisposableDomains(): array
    {
        $cache_dir = str_replace('\\', '/', realpath(dirname(__FILE__) . '/../') . '/') . 'cache';
        $use_cache = is_writable($cache_dir);

        if (!$use_cache) {
            $cache_dir = sys_get_temp_dir();

            $use_cache = is_writable($cache_dir);
        }

        if ($use_cache) {
            $files = glob($cache_dir . '/disposable_domains.cache.*');

            if ($files) {
                $time = substr(strrchr($files[0], '.'), 1);

                if ($time < time()) {
                    @unlink($files[0]);
                } else {
                    return json_decode(file_get_contents($files[0]), true);
                }
            }
        }

        try {
            $response = (new Client())->get(self::$urlListDisposableDomains);
            $domains = array_filter(explode("\n", $response->getBody()->getContents()));

            if ($use_cache) {
                file_put_contents($cache_dir. '/disposable_domains.cache.'. (time() + (int)self::$cacheListExpireDays), json_encode($domains));
            }

            return $domains;
        } catch (RequestException $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode(), $ex);
        } catch (ConnectException $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode(), $ex);
        } catch (TooManyRedirectsException $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode(), $ex);
        } catch (TransferException $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode(), $ex);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Check if the given email address is disposable
     *
     * @param string $email The email address to check
     * @return bool True if the email is disposable, false otherwise
     */
    public static function isDisposableEmail(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return true;
        }

        $disposableDomains = self::listDisposableDomains();

        // Extract the domain from the email address
        $domain = substr(strrchr($email, "@"), 1);

        // Check if the domain is in the list of disposable domains
        return in_array(strtolower($domain), $disposableDomains);
    }
}