<?php
declare(strict_types=1);

namespace App\Tests\Adapters\Web\Form;

use App\Adapters\Web\Form\GuessForm;
use Symfony\Component\Form\Test\TypeTestCase;
use App\Game\Code;

class GuessFormTest extends TypeTestCase
{
    public function test_submit_creates_code()
    {
        $formData = [
            'peg_1' => 'Red',
            'peg_2' => 'Green',
            'peg_3' => 'Yellow',
            'peg_4' => 'Blue',
        ];

        $form = $this->factory->create(GuessForm::class, null, ['number_of_pegs' => 4]);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals(Code::fromColours(array_values($formData)), $form->getData());
    }
}
