<?php

namespace Pixidos\QRPayment;

use RuntimeException;
use Transliterator;

/**
 * @param string $value
 * @param bool   $allowStar
 *
 * @return string
 * @throws RuntimeException
 */
function removeIlegalCharacters(string $value, $allowStar = false): string
{
    $transliterator = Transliterator::createFromRules(':: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;', Transliterator::FORWARD);
    if (null === $transliterator) {
        throw new RuntimeException('Create Transliterator failed');
    }
    
    $value = (string)$transliterator->transliterate($value);
    $pattern = '/[^a-zA-Z\$%\+\-,\.\/: ]/i';
    if ($allowStar) {
        $pattern = '/[^a-zA-Z\$%\+\-,\.\/:\* ]/i';
    }
    $value = (string)preg_replace($pattern, '', $value);
    
    return $value;
}
