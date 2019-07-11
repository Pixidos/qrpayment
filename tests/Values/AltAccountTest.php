<?php

namespace Pixidos\QRPayment\Tests\Values;

use PHPUnit\Framework\TestCase;
use Pixidos\QRPayment\Exceptions\InvalidValueException;
use Pixidos\QRPayment\Values\Account;
use Pixidos\QRPayment\Values\AltAccount;
use Pixidos\QRPayment\Values\Iban;
use Pixidos\QRPayment\Values\Swift;

class AltAccountTest extends TestCase
{
    
    /***/
    public function testCreatedSingleAlt()
    {
        $altAccount = new AltAccount(
            new Account(new Iban('CZ06 3500 0000 0010 0047 2301'), new Swift('GIBACZPX'))
        );
        $this->assertSame('ALT-ACC:CZ0635000000001000472301+GIBACZPX*', (string)$altAccount);
    }
    
    
    public function testCreatedTwoAlt()
    {
        $altAccount = new AltAccount(
            new Account(new Iban('CZ06 3500 0000 0010 0047 2301'), new Swift('GIBACZPX')),
            new Account(new Iban('CZ06 3500 0000 0010 0047 2301'), new Swift('GIBACZPX'))
        );
        $this->assertSame('ALT-ACC:CZ0635000000001000472301+GIBACZPX,CZ0635000000001000472301+GIBACZPX*', (string)$altAccount);
    }
    
    public function testThreeAltFailed()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage('You can set max two accounts as alt accounts');
        new AltAccount(
            new Account(new Iban('CZ06 3500 0000 0010 0047 2301'), new Swift('GIBACZPX')),
            new Account(new Iban('CZ06 3500 0000 0010 0047 2301'), new Swift('GIBACZPX')),
            new Account(new Iban('CZ06 3500 0000 0010 0047 2301'), new Swift('GIBACZPX'))
        );
    }
}
