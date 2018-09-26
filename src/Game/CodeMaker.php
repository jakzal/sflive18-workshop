<?php declare(strict_types = 1);

namespace App\Game;

interface CodeMaker
{
    public function newCode(int $length): Code;
}
