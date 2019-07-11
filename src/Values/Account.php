<?php

namespace Pixidos\QRPayment\Values;

use Pixidos\QRPayment\Exceptions\InvalidValueException;

/**
 * Class Account
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
class Account implements ValueInterface
{
    /**
     * @var Iban
     */
    private $iban;
    /**
     * @var Swift
     */
    private $swift;
    /**
     * @var string
     */
    private $string;
    
    /**
     * Account constructor.
     *
     * @param Iban  $iban
     * @param Swift $swift
     * @throws InvalidValueException
     */
    public function __construct(Iban $iban, Swift $swift)
    {
        if ($iban->getCountryCode() !== $swift->getCountryCode()) {
            throw new InvalidValueException("IBAN ({$iban->getCountryCode()}) and SWIFT ({$swift->getCountryCode()}) country code not coresponding.");
        }
        $this->iban = $iban;
        $this->swift = $swift;
        $this->setUpString();
    }
    
    /**
     * @return Iban
     */
    public function getIban(): Iban
    {
        return $this->iban;
    }
    
    /**
     * @return Swift
     */
    public function getSwift(): Swift
    {
        return $this->swift;
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->string;
    }
    
    /**
     * @param string $glue
     *
     * @return string
     */
    public function getFormatedString(string $glue = '+'): string
    {
        return $this->iban . $glue . $this->swift;
    }
    
    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return 'ACC';
    }
    
    /**
     *
     */
    private function setUpString(): void
    {
        $this->string = $this->getPrefix() . ':' . $this->iban . '+' . $this->swift . '*';
    }
    
    
}
