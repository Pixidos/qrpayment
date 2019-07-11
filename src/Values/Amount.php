<?php


namespace Pixidos\QRPayment\Values;


use Pixidos\QRPayment\Exceptions\InvalidValueException;

/**
 * Class Amount
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
class Amount implements ValueInterface
{
    /**
     * Minimum size of amount
     */
    private const MIN_SIZE = 0.01;
    /**
     * Maximum size of amount
     */
    private const MAX_SIZE = 9999999.99;
    
    /**
     * @var string
     */
    private $amount;
    
    /**
     * Amount constructor.
     *
     * @param float $amount max is 9999999.99 with precision 2 (will be rounded)
     *
     * @throws InvalidValueException
     */
    public function __construct(float $amount)
    {
        $amount = round($amount, 2);
        if ($amount > static::MAX_SIZE) {
            throw new InvalidValueException(sprintf('Amount: "%s" is invalid. Must be in range: "%s - %s"', $amount, self::MIN_SIZE, self::MAX_SIZE));
        }
        $this->amount = number_format($amount, 2, '.', '');
    }
    
    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }
    
    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return 'AM';
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getPrefix() . ':' . $this->amount . '*';
    }
}
