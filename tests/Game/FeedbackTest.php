<?php declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\Code;
use App\Game\Feedback;
use PHPUnit\Framework\TestCase;

class FeedbackTest extends TestCase
{
    public function test_it_exposes_guess_code_and_matches()
    {
        $guessCode = $this->prophesize(Code::class)->reveal();
        $exactMatches = 2;
        $nearMatches = 1;

        $feedback = new Feedback($guessCode, $exactMatches, $nearMatches);

        $this->assertSame($guessCode, $feedback->guessCode());
        $this->assertSame($exactMatches, $feedback->exactMatches());
        $this->assertSame($nearMatches, $feedback->nearMatches());
    }
}
