<?php declare(strict_types=1);

namespace Game;

use App\Game\GameUuid;
use PHPUnit\Framework\TestCase;

class GameUuidTest extends TestCase
{
    public function test_it_instantiates_an_existing_uuid()
    {
        $uuid = GameUuid::existing('ecd7d239-4943-48f1-9c5e-48a964d4cdf0');

        $this->assertInstanceOf(GameUuid::class, $uuid);
        $this->assertSame('ecd7d239-4943-48f1-9c5e-48a964d4cdf0', (string) $uuid);
    }
}
