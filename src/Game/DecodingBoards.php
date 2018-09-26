<?php declare(strict_types = 1);

namespace App\Game;

interface DecodingBoards
{
    /**
     * @throws DecodingBoardNotFoundException
     */
    public function get(GameUuid $uuid): DecodingBoard;

    public function put(DecodingBoard $decodingBoard);
}
