<?php
declare(strict_types=1);

namespace App\Adapters\Web\Controller;

use App\Game\GameUuid;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use App\UseCase\StartGameUseCase;

class StartGameController
{
    const DEFAULT_CODE_LENGTH = 4;

    /**
     * @var StartGameUseCase
     */
    private $useCase;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(StartGameUseCase $useCase, RouterInterface $router)
    {
        $this->useCase = $useCase;
        $this->router = $router;
    }

    /**
     * @Route("/games", methods={"POST"}, name="mastermind.new_game")
     */
    public function newGameAction()
    {
        $gameUuid= GameUuid::generated();

        $this->useCase->execute($gameUuid, self::DEFAULT_CODE_LENGTH);

        return new RedirectResponse($this->router->generate('mastermind.board', ['uuid' => (string)$gameUuid]));
    }
}
