<?php
/**
 * Created by JetBrains PhpStorm.
 * User: raphaelthiriet
 * Date: 27/05/13
 * Time: 22:29
 * To change this template use File | Settings | File Templates.
 */

namespace Raph\EbayparserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class KeywordAdmin extends Admin {
    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'name'
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('keyword')
            ->add('category')
            ->add('active','checkbox',array('required' => false))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('keyword')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('keyword')
            ->add('active')
            ->addIdentifier('category')
        ;
    }

}