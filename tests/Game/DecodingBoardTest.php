<?php declare(strict_types=1);

namespace Game;

use App\Game\Code;
use App\Game\DecodingBoard;
use App\Game\Feedback;
use App\Game\GameUuid;
use App\Game\NoAttemptsLeftException;
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

    public function test_makeGuess_throws_a_NoAttemptsLeftException_if_number_of_attempts_is_exceeded()
    {
        $this->expectException(NoAttemptsLeftException::class);
        $this->expectExceptionMessage(sprintf('All of the %d attempts were already used.', self::NUMBER_OF_ATTEMPTS));

        for ($i = 0; $i <= self::NUMBER_OF_ATTEMPTS; $i++) {
            $this->board->makeGuess($this->guessCode->reveal());
        }
    }

    public function test_allFeedback_exposes_all_past_feedback()
    {
        $code1 = $this->prophesize(Code::class)->reveal();
        $code2 = $this->prophesize(Code::class)->reveal();

        $feedback1 = $this->prophesize(Feedback::class)->reveal();
        $feedback2 = $this->prophesize(Feedback::class)->reveal();

        $this->secretCode->match($code1)->willReturn($feedback1);
        $this->secretCode->match($code2)->willReturn($feedback2);

        $this->board->makeGuess($code1);
        $this->board->makeGuess($code2);

        $allFeedback = $this->board->allFeedback();

        $this->assertContainsOnly(Feedback::class, $allFeedback);
        $this->assertCount(2, $allFeedback);
        $this->assertSame([$feedback1, $feedback2], $allFeedback);
    }

    public function test_lastFeedback_exposes_the_last_feedback()
    {
        $code1 = $this->prophesize(Code::class)->reveal();
        $code2 = $this->prophesize(Code::class)->reveal();

        $feedback1 = $this->prophesize(Feedback::class)->reveal();
        $feedback2 = $this->prophesize(Feedback::class)->reveal();

        $this->secretCode->match($code1)->willReturn($feedback1);
        $this->secretCode->match($code2)->willReturn($feedback2);

        $this->board->makeGuess($code1);
        $this->board->makeGuess($code2);

        $lastFeedback = $this->board->lastFeedback();

        $this->assertInstanceOf(Feedback::class, $lastFeedback);
        $this->assertSame($feedback2, $lastFeedback);
    }

    public function test_lastFeedback_returns_null_for_last_feedback_if_there_was_no_guess_attempt_yet()
    {
        $this->assertNull($this->board->lastFeedback());
    }
}
