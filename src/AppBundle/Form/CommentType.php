<?php
/**
 * Created by PhpStorm.
 * User: nima
 * Date: 25.12.16
 * Time: 14:35
 */

namespace AppBundle\Form;

use AppBundle\Entity\Category\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\User;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('name')
            //->add('save', SubmitType::class)
            ->add('text', TextType::class,[
                'required' => false,
                'label' => 'text',
                'attr' => ['class' => 'test col-xs-6']
            ])
            /*->add('post', TextType::class,[
                'required' => false,
                'label' => 'post',
                'attr' => ['class' => 'test col-xs-6']
            ])
            */
            ->add('user', EntityType::class, array(
                'class' => 'AppBundle\\Entity\\User\\User',
                'choice_label' => 'lastName',
            ))
            ->add('date', TextType::class,[
                'required' => false,
                'label' => 'date',
                'attr' => ['class' => 'test col-xs-6']
            ])
            ->add('enabled', TextType::class,[
        'required' => false,
        'label' => 'enabled',
        'attr' => ['class' => 'test col-xs-6']
    ])
    ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Comment\Comment',
            'em' => null
        ));
        $resolver->addAllowedTypes('em', [ObjectManager::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_comment';
    }



}