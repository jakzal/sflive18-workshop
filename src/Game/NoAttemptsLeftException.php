<?php
declare(strict_types = 1);

namespace App\Game;

use RuntimeException;

class NoAttemptsLeftException extends RuntimeException implements Exception
{
    public function __construct(int $numberOfAttempts)
    {
        parent::__construct(sprintf('All of the %d attempts were already used.', $numberOfAttempts));
    }
}
