<?php declare(strict_types=1);

namespace App\Tests\Adapters\Session;

use App\Adapters\Session\SessionDecodingBoards;
use App\Game\DecodingBoards;
use App\Tests\Game\DecodingBoardsTestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class SessionDecodingBoardsTest extends DecodingBoardsTestCase
{
    protected function createDecodingBoards(): DecodingBoards
    {
        return new SessionDecodingBoards(new Session(new MockArraySessionStorage()));
    }
}
