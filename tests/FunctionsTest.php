<?php

namespace Pixidos\QRPayment\Tests;

use PHPUnit\Framework\TestCase;
use function Pixidos\QRPayment\removeIlegalCharacters;

class FunctionsTest extends TestCase
{
    /***/
    public function test_removeIlegalCharacters()
    {
        $value = removeIlegalCharacters('Ondřej .*-=$%+./,:()Votava');
        $this->assertSame('Ondrej .-$%+./,:Votava', $value);
    }
    
    public function test_removeIlegalCharactersAllowStars()
    {
        $value = removeIlegalCharacters('Ondřej .*-=$%+./,:()Votava', true);
        $this->assertSame('Ondrej .*-$%+./,:Votava', $value);
    }
}
