# Disposable Email Checker

![GitHub release (latest by date)](https://img.shields.io/github/v/release/crisnao2/disposable-email?label=version)
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/crisnao2/disposable-email/php.yml?label=tests)

### Status by version PHP
![PHP 7.4](https://img.shields.io/github/actions/workflow/status/crisnao2/disposable-email/php.yml?label=PHP%207.4)
![PHP 8.0](https://img.shields.io/github/actions/workflow/status/crisnao2/disposable-email/php.yml?label=PHP%208.0)
![PHP 8.1](https://img.shields.io/github/actions/workflow/status/crisnao2/disposable-email/php.yml?label=PHP%208.1)
![PHP 8.2](https://img.shields.io/github/actions/workflow/status/crisnao2/disposable-email/php.yml?label=PHP%208.2)
![PHP 8.3](https://img.shields.io/github/actions/workflow/status/crisnao2/disposable-email/php.yml?label=PHP%208.3)
![PHP 8.4](https://img.shields.io/github/actions/workflow/status/crisnao2/disposable-email/php.yml?label=PHP%208.4)

## Description

This package helps determine if a given email address belongs to a disposable email provider. It can be used to prevent users from registering with temporary or throwaway email services, improving the quality of collected email addresses.

## Features

- Check if an email address is from a disposable email provider
- Regularly updated list of disposable email domains
- Caching mechanism to improve performance
- Easy to integrate into existing projects

## Requirements

- PHP 7.4 or higher
- Composer for dependency management

## Installation

You can install this package via Composer. Run the following command in your project root:

```bash
composer require crisnao2/disposable-email
```

## Usage

Here's a basic example of how to use the Disposable Email Checker:

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Crisnao2\DisposableEmail\Check;

$email = 'test@example.com';
$isDisposable = Check::isDisposableEmail($email);

if ($isDisposable) {
    echo "This email is from a disposable email provider.";
} else {
    echo "This email is not from a known disposable email provider.";
}
```

## How It Works

1. The package maintains a list of known disposable email domains.
2. When checking an email, it extracts the domain and compares it against this list.
3. The list is cached to improve performance and reduce API calls.
4. The cached list is automatically updated every 30 days.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the GPL-3.0 License.

## Author

Cristiano Soares
- Website: [comerciobr.com](https://comerciobr.com)

## Support

If you encounter any problems or have any questions, please open an issue on the GitHub repository.

## Acknowledgements

This package uses the disposable email domains list maintained by the community at [disposable-email-domains/disposable-email-domains](https://github.com/disposable-email-domains/disposable-email-domains).