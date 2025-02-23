<?php

namespace Crisnao2\DisposableEmail\Tests;

use PHPUnit\Framework\TestCase;
use Crisnao2\DisposableEmail\Check;

class CheckTest extends TestCase
{
    /**
    * Tests that the isDisposableEmail method returns true for an invalid email format.
    *
    * This test case verifies that the Check::isDisposableEmail method correctly identifies
    * an invalid email format and returns true, indicating it should be treated as disposable.
    *
    * @return void
    **/
    public function testIsDisposableEmailReturnsTrueForInvalidEmailFormat()
    {
        $invalidEmail = 'invalid-email';
        $result = Check::isDisposableEmail($invalidEmail);
        $this->assertTrue($result);
    }

    /**
     * Tests that the isDisposableEmail method returns false for a valid non-disposable email address.
     *
     * This test case verifies that the Check::isDisposableEmail method correctly identifies
     * a legitimate, non-disposable email address and returns false.
     *
     * @return void
     */
    public function testIsDisposableEmailReturnsFalseForValidNonDisposableEmail()
    {
        $validEmail = 'user@example.com';
        $result = Check::isDisposableEmail($validEmail);
        $this->assertFalse($result);
    }

    /**
     * Tests that the isDisposableEmail method returns true for a valid disposable email address.
     *
     * This test case verifies that the Check::isDisposableEmail method correctly identifies
     * a valid email address from a known disposable email domain and returns true.
     *
     * @return void
     */
    public function testIsDisposableEmailReturnsTrueForValidDisposableEmail()
    {
        $validEmail = 'user@0-mail.com';
        $result = Check::isDisposableEmail($validEmail);
        $this->assertTrue($result);
    }
}
