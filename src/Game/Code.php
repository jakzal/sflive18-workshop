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

    public static function fromString(string $string)
    {
        return new Code(
            array_map(
                function (string $colour) {
                    return new CodePeg($colour);
                },
                explode(' ', $string)
            )
        );
    }

    public function pegs()
    {
        return $this->codePegs;
    }
}