<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\TblPerfil;

class TblUsuariosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('usuario')
        ->add('nombreusuario')
        ->add('password', 'password')
        ->add('vigencia')
        ->add('estatus')
        ->add('fechaalta', DateType::class, array('widget' => 'single_text',
                // do not render as type="date", to avoid HTML5 date pickers
            'html5' => false,
                // add a class that can eb selected in JavaScript
            'attr' => ['class' => 'calendario form-control']))
        ->add('fechaestatus')


        ->add('idperfil', EntityType::class, array(
            // query choices from this entity
            'class' => 'AppBundle:TblPerfil',
            // use the User.username property as the visible option string
            'choice_label' => 'nombreperfil',
            // used to render a select box, check boxes or radios
             'multiple' => true,
             'expanded' => true,
            ))

        //->add('idperfil')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TblUsuarios'
        ));
    }
}
