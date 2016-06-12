<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TblActividadesDetalleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idactividadesdetalle')
            ->add('dia',DateType::class, array('widget' => 'single_text',
                // do not render as type="date", to avoid HTML5 date pickers
                'html5' => false,
                // add a class that can eb selected in JavaScript
                'attr' => ['class' => 'calendario form-control']))
            ->add('horainicio')
            ->add('horafin')
            ->add('estado')
            ->add('correlativo')
            ->add('idestadoactdet')
            ->add('idactividad')
            ->add('idaula')
            ->add('fechainicio',DateType::class, array('widget' => 'single_text',
                // do not render as type="date", to avoid HTML5 date pickers
                'html5' => false,
                // add a class that can eb selected in JavaScript
                'attr' => ['class' => 'calendario form-control']))
            ->add('fechafin',DateType::class, array('widget' => 'single_text',
                // do not render as type="date", to avoid HTML5 date pickers
                'html5' => false,
                // add a class that can eb selected in JavaScript
                'attr' => ['class' => 'calendario form-control']))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TblActividadesDetalle'
        ));
    }
}
