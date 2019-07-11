<?php

namespace Pixidos\QRPayment\Tests\Values;

use Pixidos\QRPayment\Values\Swift;
use PHPUnit\Framework\TestCase;

class SwiftTest extends TestCase
{
    /**
     * @dataProvider getSwift
     * @param $data
     */
    public function testSuccessCreated($data)
    {
        $swift = new Swift($data);
        $this->assertSame($data, (string)$swift);
    }
    
    
    public function testGetCountryCode()
    {
        $swift = new Swift('GIBACZPX');
        $this->assertSame('CZ', $swift->getCountryCode());
        $this->assertSame('GIBACZPX', $swift->getSwift());
    }
    
    public function getSwift()
    {
        $swifts = require __DIR__ . '/_data/switfs.php';
        yield from $swifts;
    }
    
}
