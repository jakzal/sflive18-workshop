<?php declare(strict_types=1);

namespace Game;

use App\Game\Code;
use App\Game\DecodingBoard;
use App\Game\Feedback;
use App\Game\GameUuid;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class DecodingBoardTest extends TestCase
{
    const NUMBER_OF_ATTEMPTS = 8;

    /**
     * @var DecodingBoard
     */
    private $board;

    /**
     * @var GameUuid
     */
    private $uuid;

    /**
     * @var Feedback
     */
    private $feedback;

    /**
     * @var Code|ObjectProphecy
     */
    private $guessCode;

    /**
     * @var Code|ObjectProphecy
     */
    private $secretCode;

    protected function setUp()
    {
        $this->uuid = GameUuid::existing('547bf8e4-1a9c-492e-a0cf-165b809585a2');
        $this->feedback = $this->prophesize(Feedback::class)->reveal();
        $this->guessCode = $this->prophesize(Code::class);
        $this->secretCode = $this->prophesize(Code::class);

        $this->secretCode->match($this->guessCode)->willReturn($this->feedback);

        $this->board = new DecodingBoard($this->uuid, $this->secretCode->reveal(), self::NUMBER_OF_ATTEMPTS);
    }

    public function test_makeGuess_gives_feedback_on_the_guess()
    {
        $this->secretCode->match($this->guessCode)->willReturn($this->feedback);

        $feedback = $this->board->makeGuess($this->guessCode->reveal());

        $this->assertSame($this->feedback, $feedback);
    }
}
