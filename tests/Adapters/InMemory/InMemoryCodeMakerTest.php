<?php declare(strict_types=1);

namespace App\Tests\Adapters\InMemory;

use App\Adapters\InMemory\InMemoryCodeMaker;
use App\Game\Code;
use App\Game\CodeMaker;
use App\Tests\Game\CodeMakerTestCase;
use PHPUnit\Framework\TestCase;

class InMemoryCodeMakerTest extends CodeMakerTestCase
{
    /**
     * @var Code
     */
    private $code;

    /**
     * @before
     */
    protected function createCode()
    {
        $this->code = Code::fromString('Red Green Blue');
    }

    protected function createCodeMaker(): CodeMaker
    {
        return new InMemoryCodeMaker($this->code);
    }

    public function test_it_returns_a_previously_defined_code()
    {
        $code = $this->codeMaker->newCode($this->code->length());

        $this->assertSame($this->code, $code);
    }
}
