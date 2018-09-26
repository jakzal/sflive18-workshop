<?php
declare(strict_types=1);

namespace App\Adapters\Web\Controller;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Adapters\Web\Form\GuessForm;
use App\Game\DecodingBoard;
use App\Game\GameUuid;
use App\UseCase\MakeGuessUseCase;
use App\UseCase\ViewDecodingBoardUseCase;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment as Twig;

class DecodingBoardController
{
    /**
     * @var Twig
     */
    private $twig;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var ViewDecodingBoardUseCase
     */
    private $viewDecodingBoardUseCase;

    /**
     * @var MakeGuessUseCase
     */
    private $makeGuessUseCase;

    public function __construct(
        Twig $twig,
        FormFactoryInterface $formFactory,
        ViewDecodingBoardUseCase $viewDecodingBoardUseCase,
        MakeGuessUseCase $makeGuessUseCase
    ) {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->viewDecodingBoardUseCase = $viewDecodingBoardUseCase;
        $this->makeGuessUseCase = $makeGuessUseCase;
    }

    /**
     * @Route("/games/{uuid}", methods={"GET", "POST"}, name="mastermind.board")
     */
    public function boardAction(string $uuid, Request $request)
    {
        $gameUuid = GameUuid::existing($uuid);
        $board = $this->viewDecodingBoardUseCase->execute($gameUuid);

        $form = $this->createForm($board);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $board = $this->makeGuessUseCase->execute($gameUuid, $form->getData());
        }

        return new Response($this->twig->render('game/board.html.twig', ['form' => $form->createView(), 'board' => $board]));
    }

    private function createForm(DecodingBoard $board): FormInterface
    {
        return $this->formFactory->create(GuessForm::class, null, ['number_of_pegs' => $board->numberOfPegs()]);
    }
}
