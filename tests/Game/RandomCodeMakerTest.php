<?php declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\CodeMaker;
use App\Game\RandomCodeMaker;
use PHPUnit\Framework\TestCase;

class RandomCodeMakerTest extends TestCase
{
    public function test_it_is_a_code_maker()
    {
        $this->assertInstanceOf(CodeMaker::class, new RandomCodeMaker());
    }
}
