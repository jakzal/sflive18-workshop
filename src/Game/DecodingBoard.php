<?php declare(strict_types=1);

namespace App\Game;

class DecodingBoard
{
    private $gameUuid;
    private $secretCode;
    private $numberOfAttempts;
    private $feedback = [];

    public function __construct(GameUuid $gameUuid, Code $secretCode, int $numberOfAttempts)
    {
        $this->gameUuid = $gameUuid;
        $this->secretCode = $secretCode;
        $this->numberOfAttempts = $numberOfAttempts;
    }

    public function makeGuess(Code $guessCode): Feedback
    {
        if (count($this->feedback) >= $this->numberOfAttempts) {
            throw new NoAttemptsLeftException($this->numberOfAttempts);
        }

        return $this->feedback[] = $this->secretCode->match($guessCode);
    }

    /**
     * @return Feedback[]
     */
    public function allFeedback(): array
    {
        return $this->feedback;
    }
}