<?php declare(strict_types=1);

namespace App\Tests\Adapters\Session;

use App\Adapters\Session\SessionDecodingBoards;
use App\Game\Code;
use App\Game\DecodingBoard;
use App\Game\DecodingBoardNotFoundException;
use App\Game\DecodingBoards;
use App\Game\GameUuid;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class SessionDecodingBoardsTest extends TestCase
{
    private const UUID = 'd97f4f5d-2f38-459e-a08d-3b950200ba25';
    private const INVALID_UUID = '027808e1-7f0f-46d0-8b68-9b69eb100c4d';

    /**
     * @var DecodingBoards
     */
    private $decodingBoards;

    protected function setUp()
    {
        $this->decodingBoards = new SessionDecodingBoards(new Session(new MockArraySessionStorage()));
    }

    public function test_it_is_a_decoding_boards_repository()
    {
        $this->assertInstanceOf(DecodingBoards::class, $this->decodingBoards);
    }

    public function test_it_throws_no_board_found_exception_if_no_board_was_found()
    {
        $this->expectException(DecodingBoardNotFoundException::class);

        $uuid = GameUuid::existing(self::INVALID_UUID);
        $board = new DecodingBoard($uuid, Code::fromString('Red Blue'), 12);

        $this->decodingBoards->put($board);
        $this->decodingBoards->get(GameUuid::existing(self::UUID));
    }

    public function test_it_gets_the_previously_added_decoding_board()
    {
        $uuid = GameUuid::existing(self::UUID);
        $board = new DecodingBoard($uuid, Code::fromString('Red Blue'), 12);

        $this->decodingBoards->put($board);
        $foundBoard = $this->decodingBoards->get(GameUuid::existing(self::UUID));

        $this->assertEquals($board, $foundBoard);
    }
}
