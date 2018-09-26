<?php
declare(strict_types=1);

namespace App\Adapters\Database;

use Doctrine\Common\Persistence\ObjectManager;
use App\Game\DecodingBoard;
use App\Game\DecodingBoardNotFoundException;
use App\Game\DecodingBoards;
use App\Game\GameUuid;

final class DoctrineDecodingBoards implements DecodingBoards
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @throws DecodingBoardNotFoundException
     */
    public function get(GameUuid $uuid): DecodingBoard
    {
        $board = $this->objectManager->find(DecodingBoard::class, (string) $uuid);

        if (!$board instanceof DecodingBoard) {
            throw new DecodingBoardNotFoundException($uuid);
        }

        return $board;
    }

    public function put(DecodingBoard $decodingBoard)
    {
        $this->objectManager->persist($decodingBoard);
        $this->objectManager->flush();
    }
}
