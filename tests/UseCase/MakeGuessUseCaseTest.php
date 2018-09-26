<?php declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Game\Code;
use App\Game\DecodingBoard;
use App\Game\DecodingBoards;
use App\Game\Feedback;
use App\Game\GameUuid;
use App\UseCase\MakeGuessUseCase;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class MakeGuessUseCaseTest extends TestCase
{
    const GAME_UUID = '32915568-55ac-48d1-b817-9d8fa9cdff6b';

    /**
     * @var MakeGuessUseCase
     */
    private $useCase;

    /**
     * @var DecodingBoards|ObjectProphecy
     */
    private $boards;

    /**
     * @var DecodingBoard|ObjectProphecy
     */
    private $board;

    /**
     * @var Feedback|ObjectProphecy
     */
    private $feedback;

    /**
     * @var GameUuid
     */
    private $uuid;

    protected function setUp()
    {
        $this->board = $this->prophesize(DecodingBoard::class);
        $this->uuid = GameUuid::existing(self::GAME_UUID);
        $this->feedback = $this->prophesize(Feedback::class);
        $this->boards = $this->prophesize(DecodingBoards::class);

        $this->boards->put(Argument::any())->willReturn();

        $this->useCase = new MakeGuessUseCase($this->boards->reveal());
    }

    public function test_it_makes_a_guess()
    {
        $code = $this->code();

        $this->board->makeGuess($code)->willReturn($this->feedback);
        $this->boards->get($this->uuid)->willReturn($this->board);

        $this->useCase->execute($this->uuid, $code);

        $this->board->makeGuess($code)->shouldHaveBeenCalled();
    }

    public function test_it_returns_the_board_after_making_a_guess()
    {
        $code = $this->code();

        $this->board->makeGuess($code)->willReturn($this->feedback);
        $this->boards->get($this->uuid)->willReturn($this->board);

        $returnedBoard = $this->useCase->execute($this->uuid, $code);

        $this->assertSame($this->board->reveal(), $returnedBoard);
    }


    public function test_it_puts_the_board_into_repository_after_making_a_guess()
    {
        $code = $this->code();

        $this->board->makeGuess($code)->willReturn($this->feedback);
        $this->boards->get($this->uuid)->willReturn($this->board);

        $this->useCase->execute($this->uuid, $code);

        $this->boards->put($this->board)->shouldHaveBeenCalled();
    }

    private function code(): Code
    {
        return $this->prophesize(Code::class)->reveal();
    }
}
