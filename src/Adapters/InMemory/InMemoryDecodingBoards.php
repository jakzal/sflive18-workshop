<?php declare(strict_types=1);

namespace App\Adapters\InMemory;

use App\Game\DecodingBoard;
use App\Game\DecodingBoardNotFoundException;
use App\Game\DecodingBoards;
use App\Game\GameUuid;

final class InMemoryDecodingBoards implements DecodingBoards
{
    /**
     * @var DecodingBoard[]
     */
    private $boards = [];

    /**
     * @throws DecodingBoardNotFoundException
     */
    public function get(GameUuid $uuid): DecodingBoard
    {
        if (!isset($this->boards[(string) $uuid])) {
            throw new DecodingBoardNotFoundException($uuid);
        }

        return $this->boards[(string) $uuid];
    }

    public function put(DecodingBoard $decodingBoard)
    {
        $this->boards[(string) $decodingBoard->gameUuid()] = $decodingBoard;
    }
}