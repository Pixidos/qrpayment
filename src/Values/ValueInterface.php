<?php


namespace Pixidos\QRPayment\Values;


/**
 * Interface ValueInterface
 * @package Pixidos\QRPayment\Values
 */
interface ValueInterface
{
    /**
     * Return key for symbol. For example: X-VS without ":"
     * @return string
     */
    public function getPrefix(): string;
    
    /**
     * Return formated string: Prefix:Value* example: ACC:CZ5855000000001265098001+RZBCCZPP*
     * @return string
     */
    public function __toString(): string;
}
