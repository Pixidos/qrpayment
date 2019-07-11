<?php


namespace Pixidos\QRPayment\Values;


use Pixidos\QRPayment\Exceptions\InvalidValueException;

/**
 * Class AltAccount
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
class AltAccount implements ValueInterface
{
    /**
     * @var Account[]
     */
    private $accounts;
    
    /**
     * AltAccount constructor.
     *
     * @param Account ...$accounts
     * @throws InvalidValueException
     */
    public function __construct(Account...$accounts)
    {
        if (count($accounts) > 2) {
            throw new InvalidValueException('You can set max two accounts as alt accounts');
        }
        $this->accounts = $accounts;
    }
    
    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return 'ALT-ACC';
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        $value = $this->getPrefix() . ':';
        foreach ($this->accounts as $account) {
            $value .= $account->getFormatedString() . ',';
        }
        return rtrim($value, ',') . '*';
    }
}
