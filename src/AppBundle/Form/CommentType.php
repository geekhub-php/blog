<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', TextareaType::class, array(
            'label' => 'Текст комментария:',
            'attr' => ['cols' => '75', 'rows' => '7']
        ))
        ->add('createdAt', DateTimeType::class, array(
            'label' => 'Дата:',
        ))
        ->add('author', EntityType::class, array(
            'label' => 'Автор:',
            'class' => 'AppBundle:Author',
            'choice_label' => 'lastName',
        ))
        ->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event) {
            $comment = $event->getData();
            $form = $event->getForm();

            /*if ($comment) {
                $form->add('imageFile', FileType::class, array(
                    'mapped' => false
                ));
            }*/
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Comment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'comment';
    }


}
