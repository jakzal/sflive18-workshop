<?php declare(strict_types=1);

namespace App\Game;

class Feedback
{
    private $guessCode;
    private $exactMatches;
    private $nearMatches;

    public function __construct(Code $guessCode, int $exactMatches, int $nearMatches)
    {
        $this->guessCode = $guessCode;
        $this->exactMatches = $exactMatches;
        $this->nearMatches = $nearMatches;
    }

    public function guessCode(): Code
    {
        return $this->guessCode;
    }

    public function exactMatches(): int
    {
        return $this->exactMatches;
    }

    public function nearMatches(): int
    {
        return $this->nearMatches;
    }
}