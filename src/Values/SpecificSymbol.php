<?php


namespace Pixidos\QRPayment\Values;


/**
 * Class SpecificSymbol
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
class SpecificSymbol extends AbstractSymbol
{
    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return 'X-SS';
    }
}
