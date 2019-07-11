<?php


namespace Pixidos\QRPayment\Values;


use Pixidos\QRPayment\Exceptions\InvalidValueException;

/**
 * Class ReferenceNumber
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
class ReferenceNumber implements ValueInterface
{
    /**
     * Pattern for Reference number
     */
    private const PATTERN = '/^[1-9]\d{0,15}$/';
    /**
     * @var string
     */
    private $referenceNumber;
    
    /**
     * ReferenceNumber constructor.
     *
     * @param string $referenceNumber can contains only max 16 number and can not start with 0
     *
     * @throws InvalidValueException
     */
    public function __construct(string $referenceNumber)
    {
        if (!preg_match(static::PATTERN, $referenceNumber)) {
            throw new InvalidValueException('Invalid reference number');
        }
        
        $this->referenceNumber = $referenceNumber;
    }
    
    /**
     * @return string
     */
    public function getReferenceNumber(): string
    {
        return $this->referenceNumber;
    }
    
    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return 'RF';
    }
    
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getPrefix() . ':' . $this->referenceNumber . '*';
    }
}
