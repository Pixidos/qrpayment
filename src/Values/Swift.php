<?php


namespace Pixidos\QRPayment\Values;


use Pixidos\QRPayment\Exceptions\InvalidSwiftException;

/**
 * Class Swift
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
class Swift
{
    /**
     * @var string
     */
    private $swift;
    /**
     * @var string
     */
    private $countryCode;
    
    private const PATTERN = '/(?P<bankCode>([A-Z]){4})(?P<countryCode>([A-Z]){2})(?P<locationCode>([0-9A-Z]){2})(?P<branchCode>([0-9A-Z]{3})?)$/';
    
    /**
     * Swift constructor.
     *
     * @param string $swift
     */
    public function __construct(string $swift)
    {
        $converted = strtoupper($swift);
        if (!preg_match(self::PATTERN, $converted, $matches)) {
            throw new InvalidSwiftException("Swift: '{$swift}' is invalid");
        }
        $this->swift = $converted;
        $this->countryCode = (string)$matches['countryCode'];
    }
    
    /**
     * @return string
     */
    public function getSwift(): string
    {
        return $this->swift;
    }
    
    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getSwift();
    }
    
}
