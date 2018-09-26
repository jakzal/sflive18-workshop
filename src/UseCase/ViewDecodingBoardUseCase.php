<?php declare(strict_types=1);

namespace App\UseCase;

use App\Game\DecodingBoard;
use App\Game\DecodingBoards;
use App\Game\GameUuid;

class ViewDecodingBoardUseCase
{
    private $boards;

    public function __construct(DecodingBoards $boards)
    {
        $this->boards = $boards;
    }

    public function execute(GameUuid $uuid): DecodingBoard
    {
        return $this->boards->get($uuid);
    }
}