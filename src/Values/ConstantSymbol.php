<?php


namespace Pixidos\QRPayment\Values;


/**
 * Class ConstantSymbol
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
class ConstantSymbol extends AbstractSymbol
{
    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return 'X-KS';
    }
}
