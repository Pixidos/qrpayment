<?php

namespace Pixidos\QRPayment\Tests\Values;

use PHPUnit\Framework\TestCase;
use Pixidos\QRPayment\Exceptions\InvalidValueException;
use Pixidos\QRPayment\Values\Account;
use Pixidos\QRPayment\Values\Iban;
use Pixidos\QRPayment\Values\Swift;

class AccountTest extends TestCase
{
    
    /***/
    public function testCreated()
    {
        $account = new Account(new Iban('CZ06 3500 0000 0010 0047 2301'), new Swift('GIBACZPX'));
        $this->assertSame('CZ0635000000001000472301+GIBACZPX', $account->getFormatedString());
        $this->assertSame('ACC:CZ0635000000001000472301+GIBACZPX*', (string)$account);
    }
    
    /***/
    public function testIbanAndSwiftNotCorrespondExceptions()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage('IBAN (CZ) and SWIFT (DE) country code not coresponding.');
        $account = new Account(new Iban('CZ06 3500 0000 0010 0047 2301'), new Swift('GIBADEPX'));
    }
}
