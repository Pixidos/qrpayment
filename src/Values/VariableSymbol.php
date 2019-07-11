<?php


namespace Pixidos\QRPayment\Values;


/**
 * Class VariableSymbol
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
final class VariableSymbol extends AbstractSymbol
{
    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return 'X-VS';
    }
    
}
