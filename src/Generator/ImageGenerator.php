<?php


namespace Pixidos\QRPayment\Generator;


use Endroid\QrCode\QrCode;
use LogicException;
use Pixidos\QRPayment\PaymentOptions;

class ImageGenerator
{
    
    
    public const PNG_WRITER = 'png';
    public const SVG_WRITER = 'svg';
    public const EPS_WRITER = 'eps';
    
    private const AVAILABLE_WRITERS = [
        self::PNG_WRITER,
        self::SVG_WRITER,
        self::EPS_WRITER,
    ];
    
    /**
     * @var string|null
     */
    private $path;
    
    private $writer = self::PNG_WRITER;
    
    public function __construct(?string $path = null)
    {
        $this->path = $path;
    }
    
    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }
    
    public function setWriter(string $writer): void
    {
        $writer = strtolower($writer);
        if (!in_array($writer, static::AVAILABLE_WRITERS, true)) {
            throw new LogicException(sprintf('Writer: "%s" is not allowed. Please choose one of: "%s"', $writer, implode(', ', static::AVAILABLE_WRITERS)));
        }
        
        $this->writer = $writer;
    }
    
    public function generate(PaymentOptions $options, ?string $path = null): string
    {
        $path = $path ?: $this->path;
        if (null === $path) {
            throw new LogicException('You must set path for image save first');
        }
        $qrCode = new QrCode((string)$options);
        $qrCode->setSize(300);
        // Set advanced options
        $qrCode->setWriterByName('png');
        $qrCode->setMargin(10);
        $qrCode->setEncoding('UTF-8');
    
        $qrCode->writeFile($path);
    
        return $path;
    }
}
