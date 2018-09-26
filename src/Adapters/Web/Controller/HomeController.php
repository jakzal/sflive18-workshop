<?php
declare(strict_types=1);

namespace App\Adapters\Web\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment as Twig;

class HomeController
{
    /**
     * @var Twig
     */
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function homeAction()
    {
        return new Response($this->twig->render('game/home.html.twig'));
    }
}
