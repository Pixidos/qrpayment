<?php


namespace Pixidos\QRPayment\Generator;


use Endroid\QrCode\ErrorCorrectionLevel;
use RuntimeException;
use UnexpectedValueException;

class GeneratorOptions
{
    private $path;
    private $writer = 'png';
    private $size = 300;
    private $encoding = 'UTF-8';
    private $errorCorrectionLevel;
    private $foregroundColor = ['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0];
    private $backgroundColor = ['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0];
    private $roundBlockSize = true;
    private $validateResult = false;
    private $margin = 10;
    private $writerOptions = [];
    private $fontPath;
    private $fontSize;
    private $labelAligment;
    
    /**
     * GeneratorOptions constructor.
     *
     * @param string|null $path
     *
     * @throws RuntimeException
     * @throws UnexpectedValueException
     */
    public function __construct(?string $path = null)
    {
        $this->path = $path ?: __DIR__ . '/tmp';
        if (@!mkdir($this->path, 0777) && !is_dir($this->path)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $this->path));
        }
        $this->errorCorrectionLevel = new ErrorCorrectionLevel(ErrorCorrectionLevel::HIGH);
    }
    
    /**
     * @param string $filename
     *
     * @return string
     */
    public function getPath(string $filename): string
    {
        $ext = substr($filename,strpos($filename, '.') + 1);
        $this->writer = strtolower($ext);
        return rtrim($this->path, '/') . DIRECTORY_SEPARATOR . $filename;
    }
    
    /**
     * @return string
     */
    public function getWriter(): string
    {
        return $this->writer;
    }
    
    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }
    
    /**
     * @return string
     */
    public function getEncoding(): string
    {
        return $this->encoding;
    }
    
    /**
     * @return ErrorCorrectionLevel
     */
    public function getErrorCorrectionLevel(): ErrorCorrectionLevel
    {
        return $this->errorCorrectionLevel;
    }
    
    /**
     * @return array
     */
    public function getForegroundColor(): array
    {
        return $this->foregroundColor;
    }
    
    /**
     * @return array
     */
    public function getBackgroundColor(): array
    {
        return $this->backgroundColor;
    }
    
    /**
     * @return bool
     */
    public function isRoundBlockSize(): bool
    {
        return $this->roundBlockSize;
    }
    
    /**
     * @return bool
     */
    public function isValidateResult(): bool
    {
        return $this->validateResult;
    }
    
    /**
     * @return int
     */
    public function getMargin(): int
    {
        return $this->margin;
    }
    
    
    
}
