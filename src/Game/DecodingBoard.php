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
        if ($this->hasAnyAttemptsLeft()) {
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

    private function hasAnyAttemptsLeft(): bool
    {
        return count($this->feedback) >= $this->numberOfAttempts;
    }

    public function lastFeedback(): ?Feedback
    {
        return \end($this->feedback) ?: null;
    }

    public function isGameWon(): bool
    {
        return null !== $this->lastFeedback() && $this->lastFeedback()->exactMatches() === $this->secretCode->length();
    }

    public function isGameLost(): bool
    {
        return $this->hasAnyAttemptsLeft() && !$this->isGameWon();
    }

    public function isGameFinished(): bool
    {
        return $this->hasAnyAttemptsLeft() || $this->isGameWon();
    }

    public function gameUuid(): GameUuid
    {
        return $this->gameUuid;
    }
}