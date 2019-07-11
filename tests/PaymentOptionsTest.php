<?php

namespace Pixidos\QRPayment\Tests;

use Generator;
use PHPUnit\Framework\ExpectationFailedException;
use Pixidos\QRPayment\Exceptions\InvalidIbanException;
use Pixidos\QRPayment\Exceptions\InvalidPaymentOptionException;
use Pixidos\QRPayment\Exceptions\InvalidSwiftException;
use Pixidos\QRPayment\Exceptions\InvalidValueException;
use Pixidos\QRPayment\PaymentOptions;
use PHPUnit\Framework\TestCase;
use Pixidos\QRPayment\Values\Account;
use Pixidos\QRPayment\Values\Amount;
use Pixidos\QRPayment\Values\ConstantSymbol;
use Pixidos\QRPayment\Values\CurencyCode;
use Pixidos\QRPayment\Values\Iban;
use Pixidos\QRPayment\Values\Swift;

/**
 * Class PaymentOptionsTest
 * @package Pixidos\QRPayment\Tests
 * @author Ondra Votava <ondra@votava.it>
 */
class PaymentOptionsTest extends TestCase
{
    /**
     * @throws InvalidPaymentOptionException
     * @throws ExpectationFailedException
     * @throws InvalidIbanException
     * @throws InvalidSwiftException
     * @throws InvalidValueException
     */
    public function testSuccessCreated(): void
    {
        $options = new PaymentOptions(
            new Account(new Iban('CZ06 3500 0000 0010 0047 2301'), new Swift('GIBACZPX')),
            new Amount(9999.99),
            new CurencyCode(CurencyCode::CZK),
            new ConstantSymbol('1234567890')
        );
    
        $this->assertSame('SPD*1.0*ACC:CZ0635000000001000472301+GIBACZPX*AM:9999.99*CC:CZK*X-KS:1234567890', (string)$options);
    }
    
    /**
     * @throws InvalidPaymentOptionException
     * @throws ExpectationFailedException
     * @throws InvalidIbanException
     * @throws InvalidSwiftException
     * @throws InvalidValueException
     */
    public function testAddValue(): void
    {
        $options = new PaymentOptions(
            new Account(new Iban('CZ06 3500 0000 0010 0047 2301'), new Swift('GIBACZPX'))
        );
        $options
            ->addValue(new Amount(9999.99))
            ->addValue(new CurencyCode(CurencyCode::CZK))
            ->addValue(new ConstantSymbol('1234567890'));
        $this->assertSame('SPD*1.0*ACC:CZ0635000000001000472301+GIBACZPX*AM:9999.99*CC:CZK*X-KS:1234567890', (string)$options);
    }
    
    
    /**
     * @throws InvalidPaymentOptionException
     * @throws ExpectationFailedException
     * @throws InvalidIbanException
     * @throws InvalidSwiftException
     * @throws InvalidValueException
     */
    public function testRewriteValue(): void
    {
        $options = new PaymentOptions(
            new Account(new Iban('CZ06 3500 0000 0010 0047 2301'), new Swift('GIBACZPX'))
        );
        $options
            ->addValue(new Amount(9999.99))
            ->addValue(new CurencyCode(CurencyCode::CZK))
            ->addValue(new ConstantSymbol('1234567890'));
        $options->addValue(new Amount(1000.00));
        
        $this->assertSame('SPD*1.0*ACC:CZ0635000000001000472301+GIBACZPX*AM:1000.00*CC:CZK*X-KS:1234567890', (string)$options);
    }
    
    /**
     * @throws InvalidPaymentOptionException
     * @throws InvalidValueException
     */
    public function testConstructWithnotAccException(): void
    {
        $this->expectException(InvalidPaymentOptionException::class);
        $this->expectExceptionMessage('You must set value with "ACC" prefix.');
    
        new PaymentOptions(new Amount(9999.99));
    }
    
    /**
     * @throws InvalidPaymentOptionException
     * @throws ExpectationFailedException
     * @throws InvalidIbanException
     * @throws InvalidSwiftException
     * @throws InvalidValueException
     */
    public function test_setVersion(): void
    {
        $options = new PaymentOptions(
            new Account(new Iban('CZ06 3500 0000 0010 0047 2301'), new Swift('GIBACZPX'))
        );
        $options->setVersion('2.0');
        
        $this->assertSame('SPD*2.0*ACC:CZ0635000000001000472301+GIBACZPX', (string)$options);
    }
    
    /**
     * @dataProvider getInvalidVersions
     *
     * @param string $version
     *
     * @throws InvalidPaymentOptionException
     * @throws InvalidIbanException
     * @throws InvalidSwiftException
     * @throws InvalidValueException
     */
    public function testInvalidVersionException(string $version): void
    {
        $this->expectException(InvalidPaymentOptionException::class);
        $this->expectExceptionMessage('Version can contains only number character and dot. For example: XXX.YY where XXX can not start with 0');
    
        $options = new PaymentOptions(
            new Account(new Iban('CZ06 3500 0000 0010 0047 2301'), new Swift('GIBACZPX'))
        );
        $options->setVersion($version);
    
    }
    
    /**
     * @return Generator
     */
    public function getInvalidVersions(): Generator
    {
        $versions = [
            ['2.A'],
            ['0.1'],
            ['2'],
            [''],
            ['A.B'],
        ];
        yield from $versions;
    }
}
