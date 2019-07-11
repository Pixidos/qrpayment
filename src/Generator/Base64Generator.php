<?php


namespace Pixidos\QRPayment\Generator;


use Endroid\QrCode\QrCode;
use LogicException;
use Pixidos\QRPayment\PaymentOptions;

class Base64Generator
{
    /**
     * @var GeneratorOptions
     */
    private $generatorOptions;
    
    public function __construct(GeneratorOptions $options)
    {
        $this->generatorOptions = $options;
    }
    
    public function generate(PaymentOptions $options): string
    {
        $path = $this->generatorOptions->getPath(getmyuid().'.svg');
        $qrCode = new QrCode((string)$options);
        $qrCode->setSize($this->generatorOptions->getSize());
        // Set advanced options
        $qrCode->setWriterByName($this->generatorOptions->getWriter());
        $qrCode->setMargin($this->generatorOptions->getMargin());
        $qrCode->setEncoding($this->generatorOptions->getEncoding());
    
        $qrCode->writeFile($path);
        if (!file_exists($path)) {
            throw new \RuntimeException('some problem');
        }
        
        return 'data:' . mime_content_type($path) . ';base64,' . base64_encode((string)file_get_contents($path));
    }
}
