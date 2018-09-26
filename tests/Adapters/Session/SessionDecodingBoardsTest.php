<?php declare(strict_types=1);

namespace App\Tests\Adapters\Session;

use App\Adapters\Session\SessionDecodingBoards;
use App\Game\DecodingBoards;
use PHPUnit\Framework\TestCase;

class SessionDecodingBoardsTest extends TestCase
{
    public function test_it_is_a_decoding_boards_repository()
    {
        $this->assertInstanceOf(DecodingBoards::class, new SessionDecodingBoards());
    }
}
