<?php

namespace Pixidos\QRPayment\Tests\Values;

use DateTime;
use DateTimeImmutable;
use Pixidos\QRPayment\Values\TransactionDate;
use PHPUnit\Framework\TestCase;

class TransactionDateTest extends TestCase
{
    /***/
    public function testCreated()
    {
        $date = new TransactionDate(new DateTimeImmutable('2019-09-08'));
        $this->assertSame('20190908', $date->getTransactionDate());
        $this->assertSame('DT:20190908', (string)$date);
    
        $date = new TransactionDate(new DateTime('2019-09-08'));
        $this->assertSame('20190908', $date->getTransactionDate());
        $this->assertSame('DT:20190908', (string)$date);
    }
}
