<?php

namespace Pixidos\QRPayment\Tests\Values;

use Pixidos\QRPayment\Exceptions\InvalidValueException;
use Pixidos\QRPayment\Values\ReceiveName;
use PHPUnit\Framework\TestCase;

class ReceiveNameTest extends TestCase
{
    
    /***/
    public function testCreate()
    {
        $receiveName = new ReceiveName('Ondřej .*-=$%+./,:()Votava');
        $this->assertSame('RN:ONDREJ .-$%+./,:VOTAVA*', (string)$receiveName);
        $this->assertSame('ONDREJ .-$%+./,:VOTAVA', $receiveName->getName());
    }
    
    /***/
    public function testMaxLongException()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage('Receive name can be only max 35 chars long');
        new ReceiveName('Příliš žluťoučký kůň úpěl ďábelské ódy.');
    }
}
