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
        $matches = 0;

        foreach ($this->codePegs as $position => $peg) {
            foreach ($anotherCode->codePegs as $anotherPosition => $anotherPeg) {
                if ($anotherPosition !== $position && $peg->equals($anotherPeg)) {
                    $matches++;
                }
            }
        }

        return $matches;
    }

    private function pegsWithExactMatches(Code $anotherCode): array
    {
        return \array_filter($this->codePegs, [$anotherCode, 'hasSamePegOnPosition'], ARRAY_FILTER_USE_BOTH);
    }

    private function hasSamePegOnPosition(CodePeg $peg, int $position): bool
    {
        return $peg->equals($this->codePegs[$position]);
    }
}