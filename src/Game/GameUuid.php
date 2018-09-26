<?php declare(strict_types=1);

namespace App\Game;

class GameUuid
{
    /**
     * @var string
     */
    private $uuid;

    private function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function existing(string $uuid): self
    {
        return new self($uuid);
    }

    public static function generated(): self
    {
        return new self('');
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
