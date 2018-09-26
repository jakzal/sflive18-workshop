<?php
declare(strict_types=1);

namespace App\Adapters\Web\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Game\Code;
use App\Game\CodePeg;

class GuessForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $numberOfPegs = $options['number_of_pegs'];

        for ($i = 1; $i <= $numberOfPegs; $i++) {
            $builder->add(
                'peg_' . $i,
                ChoiceType::class,
                [
                    'choices' => array_combine(CodePeg::AVAILABLE_COLOURS, CodePeg::AVAILABLE_COLOURS),
                ]
            );
        }
        $builder->add('submit', SubmitType::class, ['label' => 'Break the code!']);
        $builder->addModelTransformer(
            new CallbackTransformer(
                function () {},
                function ($colourArray) {
                    return Code::fromColours(array_values($colourArray));
                }
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['number_of_pegs']);
    }
}
