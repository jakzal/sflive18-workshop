<?php declare(strict_types=1);

namespace App\Tests\Adapters\InMemory;

use App\Adapters\InMemory\InMemoryDecodingBoards;
use App\Game\DecodingBoards;
use App\Tests\Game\DecodingBoardsTestCase;
use PHPUnit\Framework\TestCase;

class InMemoryDecodingBoardsTest extends DecodingBoardsTestCase
{
    protected function createDecodingBoards(): DecodingBoards
    {
        return new InMemoryDecodingBoards();
    }
}
