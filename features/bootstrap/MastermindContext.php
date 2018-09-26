<?php declare(strict_types=1);

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use App\Adapters\InMemory\InMemoryCodeMaker;
use App\Adapters\InMemory\InMemoryDecodingBoards;
use App\Game\Code;
use App\Game\DecodingBoards;
use App\Game\Feedback;
use App\Game\GameUuid;
use App\UseCase\MakeGuessUseCase;
use App\UseCase\StartGameUseCase;
use App\UseCase\ViewDecodingBoardUseCase;

class MastermindContext implements Context
{
    private const INVALID_PATTERN = 'Purple Purple Purple Purple';

    /**
     * @var int
     */
    private $numberOfAttempts = 12;

    /**
     * @var GameUuid
     */
    private $gameUuid;

    /**
     * @var Code
     */
    private $secretCode;

    /**
     * @var DecodingBoards
     */
    private $decodingBoards;

    public function __construct()
    {
        $this->decodingBoards = new InMemoryDecodingBoards();
    }

    /**
     * @Given a decoding board of :numberOfAttempts attempts
     */
    public function aDecodingBoardOfGuesses($numberOfAttempts)
    {
        $this->numberOfAttempts = (int)$numberOfAttempts;
    }

    /**
     * @Given the code maker placed the :code pattern on the board
     */
    public function theCodeMakerPlacedThePatternOnTheBoard(Code $code)
    {
        $this->gameUuid = GameUuid::generated();
        $this->secretCode = $code;

        $this->startGameUseCase($this->secretCode)->execute($this->gameUuid, $code->length());
    }

    /**
     * @When I try to break the code with :code
     */
    public function iTryToBreakTheCodeWith(Code $code)
    {
        $this->makeGuessUseCase()->execute($this->gameUuid, $code);
    }

    /**
     * @Then the code maker should give me :feedback feedback on my guess
     */
    public function theCodeMakerShouldGiveMeFeedbackOnMyGuess($feedback)
    {
        $board = $this->viewDecodingBoardUseCase()->execute($this->gameUuid);

        Assert::assertInstanceOf(Feedback::class, $board->lastFeedback(), 'Feedback on the last guess attempt was given.');
        Assert::assertSame(substr_count($feedback, 'X'), $board->lastFeedback()->exactMatches());
        Assert::assertSame(substr_count($feedback, 'O'), $board->lastFeedback()->nearMatches());
    }

    /**
     * @When I try to break the code with an invalid pattern :number times
     */
    public function iTryToBreakTheCodeWithAnInvalidPatternTimes($number)
    {
        for ($i = 0; $i < $number; $i++) {
            $this->iTryToBreakTheCodeWith(Code::fromString(self::INVALID_PATTERN));
        }
    }

    /**
     * @When I break the code in the final guess
     */
    public function iBreakTheCodeInTheFinalGuess()
    {
        $this->iTryToBreakTheCodeWith($this->secretCode);
    }

    /**
     * @Then I should win the game
     */
    public function iShouldWinTheGame()
    {
        $board = $this->viewDecodingBoardUseCase()->execute($this->gameUuid);

        Assert::assertTrue($board->isGameWon());
    }

    /**
     * @Then I should loose the game
     */
    public function iShouldLooseTheGame()
    {
        $board = $this->viewDecodingBoardUseCase()->execute($this->gameUuid);

        Assert::assertTrue($board->isGameLost());
    }

    /**
     * @Transform :code
     */
    public function transformCodeStringToCode(string $code)
    {
        return Code::fromString($code);
    }

    private function startGameUseCase(Code $code): StartGameUseCase
    {
        return new StartGameUseCase($this->decodingBoards, new InMemoryCodeMaker($code), $this->numberOfAttempts);
    }

    private function makeGuessUseCase(): MakeGuessUseCase
    {
        return new MakeGuessUseCase($this->decodingBoards);
    }

    private function viewDecodingBoardUseCase(): ViewDecodingBoardUseCase
    {
        return new ViewDecodingBoardUseCase($this->decodingBoards);
    }
}
