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
        yield ['Red Green Yellow Blue', 'Purple Purple Purple Purple', 0, 0];
        yield ['Red Green Yellow Blue', 'Red Purple Purple Purple', 1, 0];
        yield ['Red Green Yellow Blue', 'Red Green Purple Purple', 2, 0];
        yield ['Red Green Yellow Blue', 'Red Green Yellow Blue', 4, 0];
        yield ['Red Green Yellow Blue', 'Purple Red Purple Purple', 0, 1];
        yield ['Red Green Yellow Blue', 'Red Red Purple Purple', 1, 0];
        yield ['Red Green Yellow Blue', 'Green Red Purple Purple', 0, 2];
        yield ['Red Green Yellow Blue', 'Purple Red Red Red', 0, 1];
        yield ['Red Red Red Yellow', 'Red Green Purple Purple', 1, 0];
        yield ['Red Red Blue Yellow', 'Purple Purple Red Red', 0, 2];
        yield ['Yellow Red Red Red', 'Purple Purple Purple Red', 1, 0];
        yield ['Red Red Blue Yellow', 'Purple Purple Red Purple', 0, 1];
    }

    public function test_length_returns_the_number_of_pegs()
    {
        $code = Code::fromString('Red Purple Green Yellow Green');

        $this->assertSame(5, $code->length());
    }
}
