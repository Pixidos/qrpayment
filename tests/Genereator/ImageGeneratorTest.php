<?php

namespace Pixidos\QRPayment\Tests\Generator;

use Pixidos\QRPayment\Generator\ImageGenerator;
use PHPUnit\Framework\TestCase;
use Pixidos\QRPayment\PaymentOptions;
use Pixidos\QRPayment\Values\Account;
use Pixidos\QRPayment\Values\Amount;
use Pixidos\QRPayment\Values\ConstantSymbol;
use Pixidos\QRPayment\Values\CurencyCode;
use Pixidos\QRPayment\Values\Iban;
use Pixidos\QRPayment\Values\Swift;

class ImageGeneratorTest extends TestCase
{
    /***/
    public function testGenerate()
    {
        $path = __DIR__ . '/temp/qrcode.png';
        if (!mkdir($path, 0777) && !is_dir($path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
        if (file_exists($path)) {
            unlink($path);
        }
    
        $options = new PaymentOptions(
            new Account(new Iban('CZ06 3500 0000 0010 0047 2301'), new Swift('GIBACZPX')),
            new Amount(9999.99),
            new CurencyCode(CurencyCode::CZK),
            new ConstantSymbol('1234567890')
        );
        $generator = new ImageGenerator($path);
        $image = $generator->generate($options);
    
        $this->assertFileExists($image);
    }
}
