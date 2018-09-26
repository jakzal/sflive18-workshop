<?php declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Game\DecodingBoard;
use App\Game\DecodingBoards;
use App\Game\GameUuid;
use App\UseCase\ViewDecodingBoardUseCase;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class ViewDecodingBoardUseCaseTest extends TestCase
{
    const GAME_UUID = '32915568-55ac-48d1-b817-9d8fa9cdff6b';

    /**
     * @var ViewDecodingBoardUseCase
     */
    private $useCase;

    /**
     * @var DecodingBoards|ObjectProphecy
     */
    private $boards;

    protected function setUp()
    {
        $this->boards = $this->prophesize(DecodingBoards::class);
        $this->useCase = new ViewDecodingBoardUseCase($this->boards->reveal());
    }

    public function test_it_gets_an_existing_game_from_the_decoding_boards_repository()
    {
        $uuid = GameUuid::existing(self::GAME_UUID);
        $decodingBoard = $this->prophesize(DecodingBoard::class)->reveal();

        $this->boards->get($uuid)->willReturn($decodingBoard);

        $this->assertSame($decodingBoard, $this->useCase->execute($uuid));
    }
}
