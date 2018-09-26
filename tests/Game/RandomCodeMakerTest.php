<?php declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\CodeMaker;
use App\Game\RandomCodeMaker;

class RandomCodeMakerTest extends CodeMakerTestCase
{
    protected function createCodeMaker(): CodeMaker
    {
        return new RandomCodeMaker();
    }
}
