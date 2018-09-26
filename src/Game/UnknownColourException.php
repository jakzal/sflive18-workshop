<?php declare(strict_types=1);

namespace App\Game;

use InvalidArgumentException;

class UnknownColourException extends InvalidArgumentException implements Exception
{
    public function __construct(string $colour, array $supportedColours)
    {
        parent::__construct(
            sprintf(
                'Unknown colour "%s", the only supported colours are: "%s".',
                $colour,
                implode(', ', $supportedColours)
            )
        );
    }
}
