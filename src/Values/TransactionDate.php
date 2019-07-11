<?php


namespace Pixidos\QRPayment\Values;


use DateTimeInterface;

/**
 * Class TransactionDate
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
class TransactionDate implements ValueInterface
{
    private const DATE_8601 = 'Ymd';
    /**
     * @var string
     */
    private $transactionDate;
    
    /**
     * TransactionDate constructor.
     *
     * @param DateTimeInterface $dateTime
     */
    public function __construct(DateTimeInterface $dateTime)
    {
        $this->transactionDate = $dateTime->format(static::DATE_8601);
    }
    
    /**
     * @return string
     */
    public function getTransactionDate(): string
    {
        return $this->transactionDate;
    }
    
    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return 'DT';
    }
    
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getPrefix() . ':' . $this->transactionDate;
    }
}
