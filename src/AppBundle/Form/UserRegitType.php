<?php
/**
 * Created by PhpStorm.
 * User: nima
 * Date: 25.12.16
 * Time: 14:35.
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\User;

class UserRegitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('name')
            //->add('save', SubmitType::class)

            ->add('login', TextType::class, [
                'required' => false,
                'label' => 'login',
                'attr' => ['class' => 'test col-xs-3'],
            ])

            ->add('firstName', TextType::class, [
                'required' => false,
                'label' => 'firstName',
                'attr' => ['class' => 'test col-xs-6'],
            ])
            ->add('lastName', TextType::class, [
                'required' => false,
                'label' => 'lastName',
                'attr' => ['class' => 'test col-xs-6'],
            ])
                      ->add('email', TextType::class, [
                    'required' => false,
                    'label' => 'email',
                    'attr' => ['class' => 'test col-xs-3'],
              ])

          ->add('city', TextType::class, [
           'required' => false,
           'label' => 'city',
           'attr' => ['class' => 'test col-xs-6'],
           ])
         ->add('address', TextType::class, [
        'required' => false,
        'label' => 'address',
        'attr' => ['class' => 'test col-xs-6'],
    ])

          ->add('password', TextType::class, [
                'required' => false,
                'label' => 'password',
                'attr' => ['class' => 'test col-xs-6'],
            ])

    ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User\User',
            'em' => null,
        ));
        $resolver->addAllowedTypes('em', [ObjectManager::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_userRegit';
    }
}
