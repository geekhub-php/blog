<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class PostType extends AbstractType
{
    /**
     * @var AuthorizationChecker
     */
    private $authorizationChecker;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->authorizationChecker = $options['authorizationChecker'];

        $builder
            ->add('title')
            ->add('content', TextareaType::class, array(
                'attr' => array('rows' => '10')
            ))
            ->add('category', EntityType::class, array(
                'class' => 'AppBundle:Category',
                'choice_label' => 'name',
            ))
            ->add('tags', EntityType::class, array(
                'class' => 'AppBundle:Tag',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ));

        if (isset($this->authorizationChecker) && $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $builder->add('user', EntityType::class, array(
                'class' => 'AppBundle:User',
                'choice_label' => 'userProfile.displayName',
                'label' => 'Author',
            ));
        }

        $builder->add('save', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'           => 'AppBundle\Entity\Post',
            'attr'                 => array('novalidate' => 'novalidate'),
            'authorizationChecker' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_post';
    }
}
