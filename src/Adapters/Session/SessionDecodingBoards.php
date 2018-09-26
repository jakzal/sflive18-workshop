<?php declare(strict_types=1);

namespace App\Adapters\Session;

use App\Game\DecodingBoard;
use App\Game\DecodingBoardNotFoundException;
use App\Game\DecodingBoards;
use App\Game\GameUuid;

final class SessionDecodingBoards implements DecodingBoards
{
    /**
     * @throws DecodingBoardNotFoundException
     */
    public function get(GameUuid $uuid): DecodingBoard
    {
        throw new DecodingBoardNotFoundException($uuid);
    }

    public function put(DecodingBoard $decodingBoard)
    {
    }
}