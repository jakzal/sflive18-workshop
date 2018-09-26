<?php declare(strict_types=1);

namespace App\Game;

class CodePeg
{
    private $colour;

    public function __construct(string $colour)
    {
        $this->colour = $colour;
    }

    public function __toString(): string
    {
        return $this->colour;
    }

    public function equals(CodePeg $anotherCodePeg)
    {
        return true;
    }
}