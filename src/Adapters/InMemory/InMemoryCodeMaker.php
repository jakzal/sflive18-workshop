<?php declare(strict_types=1);

namespace App\Adapters\InMemory;

use App\Game\Code;
use App\Game\CodeMaker;

final class InMemoryCodeMaker implements CodeMaker
{
    /**
     * @var Code
     */
    private $code;

    public function __construct(Code $code)
    {
        $this->code = $code;
    }

    public function newCode(int $length): Code
    {
        return $this->code;
    }
}