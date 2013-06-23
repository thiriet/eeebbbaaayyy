<?php
/**
 * Created by JetBrains PhpStorm.
 * User: raphaelthiriet
 * Date: 27/05/13
 * Time: 23:06
 * To change this template use File | Settings | File Templates.
 */

namespace Raph\EbayparserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class ProductAdmin extends Admin {
// setup the defaut sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'created_at'
    );


    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('productCountry')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('productCountry')
            ->add('price')
            ->add('currency')
            ->add('description')
            ->add('endDate')
            ->add('bidAmount')
            ->add('keyword')
        ;
    }
}