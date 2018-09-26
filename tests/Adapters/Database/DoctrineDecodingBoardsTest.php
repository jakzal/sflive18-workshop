<?php
declare(strict_types=1);

namespace App\Tests\Adapters\Database;

use App\Adapters\Database\DoctrineDecodingBoards;
use App\Game\Code;
use App\Game\DecodingBoard;
use App\Game\DecodingBoards;
use App\Game\GameUuid;
use App\Tests\Game\DecodingBoardsTestCase;

class DoctrineDecodingBoardsTest extends DecodingBoardsTestCase
{
    use Doctrine;
    use SymfonyKernel;

    protected function createDecodingBoards(): DecodingBoards
    {
        return new DoctrineDecodingBoards($this->manager);
    }

    public function test_stored_board_is_fully_restored()
    {
        $uuid = GameUuid::existing(self::UUID);
        $secretCode = Code::fromString('Red Blue');
        $board = new DecodingBoard($uuid, $secretCode, 12);
        $board->makeGuess(Code::fromString('Red Red'));

        $this->decodingBoards->put($board);

        // clear the manager to make sure the object is fetched from the database
        $this->manager->clear();

        $foundBoard = $this->decodingBoards->get($uuid);

        $this->assertEquals($board, $foundBoard);
    }
}
