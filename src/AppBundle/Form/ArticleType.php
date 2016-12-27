<?php
namespace AppBundle\Form;


use AppBundle\Entity\Article;
use Symfony\Component\Form\AbstractType;
use AppBundle\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextareaType::class, array(
                'required' => true,
                'label' => 'title'
            ))
            ->add('content', TextareaType::class, array(
                'required' => true,
                'label' => 'content'
            ))
            ->add('tags', TextareaType::class, array(
                'required' => false,
                'label' => 'tags'
            ))
            ->add('publishedAt', DateTimeType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Article::class,
        ));
    }

}