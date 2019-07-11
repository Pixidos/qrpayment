<?php

namespace Pixidos\QRPayment;

use Pixidos\QRPayment\Exceptions\InvalidPaymentOptionException;
use Pixidos\QRPayment\Values\ValueInterface;

/**
 * Class PaymentOptions
 * @package Pixidos\QRPayment
 * @author Ondra Votava <ondrej.votava@mediafactory.cz>
 */
class PaymentOptions
{
    private $values = [];
    
    private $version = '1.0';
    
    /**
     * PaymentOptions constructor.
     * One of value must have prefix "ACC"
     *
     * @param ValueInterface ...$values
     *
     * @throws InvalidPaymentOptionException
     */
    public function __construct(ValueInterface ...$values)
    {
        foreach ($values as $value) {
            $this->addValue($value);
        }
        
        if (!array_key_exists('ACC', $this->values)) {
            throw new InvalidPaymentOptionException('You must set value with "ACC" prefix.');
        }
    }
    
    public function addValue(ValueInterface $value): self
    {
        $this->values[$value->getPrefix()] = $value;
        
        return $this;
    }
    
    public function string(): string
    {
        $string = 'SPD*' . $this->version . '*';
        foreach ($this->values as $value) {
            $string .= $value;
        }
        
        return rtrim($string, '*');
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->string();
    }
    
    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }
    
    /**
     * @param string $version
     *
     * @throws InvalidPaymentOptionException
     */
    public function setVersion(string $version): void
    {
        if (!preg_match('/^[1-9](\d+)?\.\d+/', $version)) {
            throw new InvalidPaymentOptionException('Version can contains only number character and dot. For example: XXX.YY where XXX can not start with 0');
        }
        
        $this->version = $version;
    }
}
