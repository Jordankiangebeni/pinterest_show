<?php

namespace App\Form;


use App\Entity\Pin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class PinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    
        $builder

        ->add('title', TextType::class, [
            'attr' => ['class' => 'form-control'],
        ])
        ->add('description', TextareaType::class, [
            'attr' => ['class' => 'form-control'],
        ])
        ->add('imageFile', VichFileType::class, [
            'required' => false,
            'allow_delete' => true,
            'delete_label' => '',
            'download_uri' => 'download',
            'download_label' => 'download',
            'asset_helper' => true,
            'attr' => ['class' => 'form-control-file custom-file-input'],
        ]);
    
           
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pin::class,
        ]);
    }
}
