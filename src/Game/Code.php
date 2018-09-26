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
        return new self(
            array_map(
                function (string $colour) {
                    return new CodePeg($colour);
                },
                explode(' ', $colourString)
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
}