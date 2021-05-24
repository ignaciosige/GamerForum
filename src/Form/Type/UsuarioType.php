<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('nombreUsuario', TextType::class)
            ->add('fechaNacimiento', DateType::class, [
                'days' => range(1,31),
                'months' => range(1,12),
                'years' => range(1920,2021),
                'format' => "dd--MM--yyyy"
            ])
            ->add('save', SubmitType::class, ['label' => 'Enviar']);
    }
}