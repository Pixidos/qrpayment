<?php


namespace Pixidos\QRPayment\Values;


use Pixidos\QRPayment\Exceptions\InvalidValueException;

/**
 * Class CurencyCode
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
class CurencyCode implements ValueInterface
{
    /**
     *
     */
    public const CZK = 'CZK';
    
    /**
     *
     */
    private const CURENCY_CODES = [
        self::CZK,
    ];
    
    /**
     * @var string
     */
    private $currencyCode;
    
    /**
     * CurencyCode constructor.
     *
     * @param string $currencyCode
     *
     * @throws InvalidValueException
     */
    public function __construct(string $currencyCode)
    {
        $currencyCode = strtoupper($currencyCode);
        if (!in_array($currencyCode, self::CURENCY_CODES, true)) {
            throw new InvalidValueException("Code '{$currencyCode}'for currency is invalid. Possible codes: '" . implode(', ', self::CURENCY_CODES) . "'");
        }
        
        $this->currencyCode = $currencyCode;
    }
    
    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getPrefix() . ':' . $this->currencyCode . '*';
    }
    
    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return 'CC';
    }
    
}
