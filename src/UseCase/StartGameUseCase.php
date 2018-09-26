<?php declare(strict_types=1);

namespace App\UseCase;

use App\Game\CodeMaker;
use App\Game\DecodingBoard;
use App\Game\DecodingBoards;
use App\Game\GameUuid;

class StartGameUseCase
{
    private $boards;
    private $codeMaker;
    private $numberOfAttempts;

    public function __construct(DecodingBoards $boards, CodeMaker $codeMaker, int $numberOfAttempts)
    {
        $this->boards = $boards;
        $this->codeMaker = $codeMaker;
        $this->numberOfAttempts = $numberOfAttempts;
    }

    public function execute(GameUuid $uuid, int $codeLength): void
    {
        $secretCode = $this->codeMaker->newCode($codeLength);

        $this->boards->put(new DecodingBoard($uuid, $secretCode, $this->numberOfAttempts));
    }
}