<?php

namespace Pixidos\QRPayment\Tests\Values;

use Generator;
use PHPUnit\Framework\ExpectationFailedException;
use Pixidos\QRPayment\Exceptions\InvalidSwiftException;
use Pixidos\QRPayment\Values\Swift;
use PHPUnit\Framework\TestCase;

class SwiftTest extends TestCase
{
    /**
     * @dataProvider getSwift
     *
     * @param string $data
     * @throws ExpectationFailedException
     * @throws InvalidSwiftException
     */
    public function testSuccessCreated(string $data): void
    {
        $swift = new Swift($data);
        $this->assertSame($data, (string)$swift);
    }
    
    
    /**
     * @throws ExpectationFailedException
     * @throws InvalidSwiftException
     */
    public function testGetCountryCode(): void
    {
        $swift = new Swift('GIBACZPX');
        $this->assertSame('CZ', $swift->getCountryCode());
        $this->assertSame('GIBACZPX', $swift->getSwift());
    }
    
    /**
     * @return Generator
     */
    public function getSwift(): Generator
    {
        $swifts = require __DIR__ . '/_data/switfs.php';
        yield from $swifts;
    }
    
}
