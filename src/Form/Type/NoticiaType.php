<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class NoticiaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titular', TextType::class)
            ->add('imagen', FileType::class, ['mapped' => false, 'required' => false])
            ->add('resumen', TextareaType::class)
            ->add('contenido', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Enviar']);
    }
}