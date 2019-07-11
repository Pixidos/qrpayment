<?php


namespace Pixidos\QRPayment\Values;


use Pixidos\QRPayment\Exceptions\InvalidValueException;

/**
 * Class AbstractSymbol
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
abstract class AbstractSymbol implements ValueInterface
{
    /**
     * @var string
     */
    protected $symbol;
    /**
     *
     */
    protected const PATTERN = '/^[1-9]\d{0,9}$/';
    
    /**
     * AbstractSymbol constructor.
     *
     * @param string $symbol
     *
     * @throws InvalidValueException
     */
    public function __construct(string $symbol)
    {
        if (!preg_match(static::PATTERN, $symbol)) {
            throw new InvalidValueException('Invalid symbol number');
        }
        $this->symbol = $symbol;
    }
    
    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getPrefix() . ':' . $this->symbol . '*';
    }
}
