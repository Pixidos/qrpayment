<?php

namespace Pixidos\QRPayment;

use Transliterator;

/**
 * @param string $value
 * @param bool   $allowStar
 *
 * @return string
 */
function removeIlegalCharacters(string $value, $allowStar = false): string
{
    $transliterator = Transliterator::createFromRules(':: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;', Transliterator::FORWARD);
    
    $value = $transliterator->transliterate($value);
    $pattern = '/[^a-zA-Z\$%\+\-,\.\/: ]/i';
    if ($allowStar) {
        $pattern = '/[^a-zA-Z\$%\+\-,\.\/:\* ]/i';
    }
    $value = preg_replace($pattern, '', $value);
    
    return $value;
}
