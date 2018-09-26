<?php declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\CodePeg;
use PHPUnit\Framework\TestCase;

class CodePegTest extends TestCase
{
    public function test_it_can_be_cast_to_string()
    {
        $codePeg = new CodePeg('Red');

        $this->assertSame('Red', (string) $codePeg);
    }
}
