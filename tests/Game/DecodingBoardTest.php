<?php declare(strict_types=1);

namespace Game;

use App\Game\Code;
use App\Game\DecodingBoard;
use App\Game\Feedback;
use App\Game\GameUuid;
use PHPUnit\Framework\TestCase;

class DecodingBoardTest extends TestCase
{
    const NUMBER_OF_ATTEMPTS = 8;

    public function test_makeGuess_gives_feedback_on_the_guess()
    {
        $uuid = GameUuid::existing('547bf8e4-1a9c-492e-a0cf-165b809585a2');
        $expectedFeedback = $this->prophesize(Feedback::class)->reveal();
        $guessCode = $this->prophesize(Code::class);
        $secretCode = $this->prophesize(Code::class);
        $secretCode->match($guessCode)->willReturn($expectedFeedback);

        $board = new DecodingBoard($uuid, $secretCode->reveal(), self::NUMBER_OF_ATTEMPTS);
        $feedback = $board->makeGuess($guessCode->reveal());

        $this->assertSame($expectedFeedback, $feedback);
    }
}
