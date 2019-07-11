<?php

namespace Pixidos\QRPayment\Tests\Values;

use PHPUnit\Framework\TestCase;
use Pixidos\QRPayment\Exceptions\InvalidValueException;
use Pixidos\QRPayment\Values\Message;

class MessageTest extends TestCase
{
    /***/
    public function testCreate()
    {
        $message = new Message('Nějaká platba za něco');
        $this->assertSame('Nejaka platba za neco', $message->getMessage());
        $this->assertSame('MSG:Nejaka platba za neco*', (string)$message);
    }
    
    /***/
    public function testMessageIsTooLongExeptions()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage('Message is too long. Max is 60 chars');
        new Message('Nějaká platba za něco Nějaká platba za něco Nějaká platba za něco Nějaká platba za něco');
    }
}
