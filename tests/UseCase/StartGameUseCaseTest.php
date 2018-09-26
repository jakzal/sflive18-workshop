<?php declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Game\Code;
use App\Game\CodeMaker;
use App\Game\DecodingBoard;
use App\Game\DecodingBoards;
use App\Game\GameUuid;
use App\UseCase\StartGameUseCase;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class StartGameUseCaseTest extends TestCase
{
    private const NUMBER_OF_ATTEMPTS = 8;
    private const CODE_LENGTH = 4;

    /**
     * @var StartGameUseCase
     */
    private $useCase;

    /**
     * @var DecodingBoards|ObjectProphecy
     */
    private $boards;

    /**
     * @var CodeMaker|ObjectProphecy
     */
    private $codeMaker;

    protected function setUp()
    {
        $this->boards = $this->prophesize(DecodingBoards::class);
        $this->codeMaker = $this->prophesize(CodeMaker::class);
        $this->useCase = new StartGameUseCase(
            $this->boards->reveal(),
            $this->codeMaker->reveal(),
            self::NUMBER_OF_ATTEMPTS
        );
    }

    public function test_it_stores_a_new_decoding_board()
    {
        $uuid = GameUuid::existing('4a8d9e6e-d5ee-4b41-9f8f-d4f0fc325604');
        $code = $this->code();

        $this->codeMaker->newCode(self::CODE_LENGTH)->willReturn($code);

        $this->useCase->execute($uuid, self::CODE_LENGTH);

        $this->boards->put(new DecodingBoard($uuid, $code, self::NUMBER_OF_ATTEMPTS))->shouldHaveBeenCalled();
    }

    private function code(): Code
    {
        return $this->prophesize(Code::class)->reveal();
    }
}
