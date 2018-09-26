<?php
declare(strict_types=1);

namespace App\Tests\Adapters\Web;

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class WebIntegrationTest extends WebTestCase
{
    protected static $class = Kernel::class;

    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = self::createClient();
        $this->client->followRedirects();
    }

    public function test_play_the_game()
    {
        $this->startNewGame();
        $this->makeGuess(['Red', 'Green', 'Blue', 'Yellow']);
        $this->makeGuess(['Green', 'Green', 'Purple', 'Purple']);
        $this->verifyGuesses([
            ['Red', 'Green', 'Blue', 'Yellow'],
            ['Green', 'Green', 'Purple', 'Purple'],
        ]);
    }

    private function startNewGame()
    {
        try {
            $crawler = $this->client->request('GET', '/');

            $this->client->submit($crawler->selectButton('Start a new game')->form());

            $this->assertResponseSuccess();
        } catch (\InvalidArgumentException $e) {
            $this->handleException($e);
        }
    }

    private function makeGuess(array $colours)
    {
        try {
            $crawler = $this->client->getCrawler();

            $form = $crawler->selectButton('Break the code!')->form();
            foreach ($colours as $i => $colour) {
                $field = sprintf('guess_form[peg_%d]', $i + 1);
                $form[$field]->select($colour);
            }

            $this->client->submit($form);

            $this->assertResponseSuccess();
        } catch (\InvalidArgumentException $e) {
            $this->handleException($e);
        }
    }

    private function verifyGuesses(array $expectedGuesses)
    {
        try {
            $guesses = $this->client->getCrawler()->filter('ul.decoding-board li')->each(function (Crawler $crawler) {
                return $crawler->filter('button.guess')->each(function (Crawler $crawler) {
                    return (string) $crawler->attr('data-colour');
                });
            });
            $this->assertSame($expectedGuesses, $guesses);
        } catch (\InvalidArgumentException $e) {
            $this->handleException($e);
        }
    }

    private function assertResponseSuccess()
    {
        $this->assertSame(200, $this->client->getResponse()->getStatusCode(), $this->extractLastResponseTitle());
    }

    private function extractLastResponseTitle(): string
    {
        return html_entity_decode(
            (string)preg_replace(
                '#.*?<title>(.*?)</title>.*#smi',
                '$1',
                $this->client->getResponse()->getContent()
            )
        );
    }

    private function handleException(\Throwable $e)
    {
        $message = $this->extractLastResponseTitle();

        if (empty($message)) {
            $message = sprintf('Got a %d response.', $this->client->getResponse()->getStatusCode());
        }

        if (preg_match('/The current node list is empty/i', $e->getMessage())) {
            $message .= ' Failed to find expected elements on the page.';
        }

        throw new \RuntimeException($message, 0, $e);
    }
}
