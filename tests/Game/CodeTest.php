<?php declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\Code;
use App\Game\CodePeg;
use PHPUnit\Framework\TestCase;

class CodeTest extends TestCase
{
    public function test_it_is_created_from_a_string_of_code_pegs()
    {
        $code = Code::fromString('Red Green Blue');

        $this->assertInstanceOf(Code::class, $code);
        $this->assertEquals(
            [
                new CodePeg('Red'),
                new CodePeg('Green'),
                new CodePeg('Blue'),
            ],
            $code->pegs()
        );
    }

    public function test_it_is_created_from_an_array_of_code_peg_strings()
    {
        $code = Code::fromColours(['Red', 'Green', 'Blue']);

        $this->assertInstanceOf(Code::class, $code);
        $this->assertEquals(
            [
                new CodePeg('Red'),
                new CodePeg('Green'),
                new CodePeg('Blue'),
            ],
            $code->pegs()
        );
    }

    /**
     * @dataProvider provideExactAndNearMatches
     */
    public function test_match_gives_feedback_on_exact_and_near_matches(string $codeString, string $anotherCodeString, int $expectedExactMatches, int $expectedNearMatches)
    {
        $code = Code::fromString($codeString);
        $anotherCode = Code::fromString($anotherCodeString);

        $feedback = $code->match($anotherCode);

        $this->assertSame($anotherCode, $feedback->guessCode());
        $this->assertSame($expectedExactMatches, $feedback->exactMatches());
        $this->assertSame($expectedNearMatches, $feedback->nearMatches());
    }

    public function provideExactAndNearMatches()
    {
        return [
            [
                'Red Green Yellow Blue',
                'Purple Purple Purple Purple',
                0,
                0,
            ],
            [
                'Red Green Yellow Blue',
                'Red Purple Purple Purple',
                1,
                0,
            ],
            [
                'Red Green Yellow Blue',
                'Red Green Purple Purple',
                2,
                0,
            ],
            [
                'Red Green Yellow Blue',
                'Red Green Yellow Blue',
                4,
                0,
            ],
        ];
    }
}
