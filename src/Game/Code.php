<?php declare(strict_types=1);

namespace App\Game;

class Code
{
    private $codePegs;

    /**
     * @param CodePeg[] $codePegs
     */
    private function __construct(array $codePegs)
    {
        $this->codePegs = $codePegs;
    }

    public static function fromString(string $colourString): self
    {
        return self::fromColours(explode(' ', $colourString));
    }

    public static function fromColours(array $colours): self
    {
        return new self(
            array_map(
                function (string $colour) {
                    return new CodePeg($colour);
                },
                $colours
            )
        );
    }

    /**
     * @return CodePeg[]
     */
    public function pegs(): array
    {
        return $this->codePegs;
    }

    public function match(Code $anotherCode): Feedback
    {
        $exactMatches = 0;

        foreach ($this->codePegs as $position => $peg) {
            if ($anotherCode->hasSamePegOnPosition($position, $peg)) {
                $exactMatches++;
            }
        }

        return new Feedback($anotherCode, $exactMatches, 0);
    }

    private function hasSamePegOnPosition(int $position, CodePeg $peg): bool
    {
        return $peg->equals($this->codePegs[$position]);
    }
}