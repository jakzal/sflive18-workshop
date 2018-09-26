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
        return new Feedback($anotherCode, $this->exactMatches($anotherCode), $this->nearMatches($anotherCode));
    }

    private function exactMatches(Code $anotherCode): int
    {
        return \count($this->pegsWithExactMatches($anotherCode));
    }

    private function nearMatches(Code $anotherCode): int
    {
        $positionsCounted = [];

        foreach ($this->pegsWithNoExactMatches($anotherCode) as $codePeg) {
            foreach ($anotherCode->pegsWithNoExactMatches($this) as $position => $anotherCodePeg) {
                if ($codePeg->equals($anotherCodePeg) && !isset($positionsCounted[$position])) {
                    $positionsCounted[$position] = true;

                    break;
                }
            }
        }

        return \count($positionsCounted);
    }

    private function pegsWithExactMatches(Code $anotherCode): array
    {
        return \array_filter($this->codePegs, [$anotherCode, 'hasSamePegOnPosition'], ARRAY_FILTER_USE_BOTH);
    }

    private function pegsWithNoExactMatches(Code $anotherCode): array
    {
        return \array_filter(
            $this->codePegs,
            function (CodePeg $peg, int $position) use ($anotherCode) {
                return !$anotherCode->hasSamePegOnPosition($peg, $position);
            },
            ARRAY_FILTER_USE_BOTH
        );
    }

    private function hasSamePegOnPosition(CodePeg $peg, int $position): bool
    {
        return $peg->equals($this->codePegs[$position]);
    }

    public function length(): int
    {
        return \count($this->codePegs);
    }
}