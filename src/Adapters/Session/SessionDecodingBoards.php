<?php declare(strict_types=1);

namespace App\Adapters\Session;

use App\Game\DecodingBoard;
use App\Game\DecodingBoardNotFoundException;
use App\Game\DecodingBoards;
use App\Game\GameUuid;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionDecodingBoards implements DecodingBoards
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @throws DecodingBoardNotFoundException
     */
    public function get(GameUuid $uuid): DecodingBoard
    {
        $board = $this->session->get((string) $uuid);

        if (!$board instanceof DecodingBoard) {
            throw new DecodingBoardNotFoundException($uuid);
        }

        return $board;
    }

    public function put(DecodingBoard $decodingBoard)
    {
        $this->session->set((string) $decodingBoard->gameUuid(), $decodingBoard);
    }
}