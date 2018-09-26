<?php declare(strict_types=1);

namespace App\UseCase;

use App\Game\Code;
use App\Game\DecodingBoards;
use App\Game\GameUuid;

class MakeGuessUseCase
{
    private $boards;

    public function __construct(DecodingBoards $boards)
    {
        $this->boards = $boards;
    }

    public function execute(GameUuid $uuid, Code $guessCode)
    {
        $board = $this->boards->get($uuid);
        $board->makeGuess($guessCode);

        return $board;
    }
}