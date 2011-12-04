<?php
/**
 * User: matteo
 * Date: 05/12/11
 * Time: 0.21
 *
 * Just for fun...
 */

namespace Sonata\DoctrineORMAdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;

abstract class NestedSetAdmin extends Admin
{
    protected $maxPerPage = 0;

    private $list;

    /**
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     */
    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);
    }

    /**
     * Returns a list depend on the given $object
     *
     * @return \Sonata\AdminBundle\Admin\FieldDescriptionCollection
     */
    public function getList()
    {
        $this->buildList();

        return $this->list;
    }

    /**
     * build the list FieldDescription array
     *
     * @return void
     */
    protected function buildList()
    {
        if ($this->list) {
            return;
        }

        $this->list = $this->getListBuilder()->getBaseList();

        $mapper = new ListMapper($this->getListBuilder(), $this->list, $this);

        if (count($this->getBatchActions()) > 0) {
            $fieldDescription = $this->getModelManager()->getNewFieldDescriptionInstance($this->getClass(), 'batch', array(
                'label'    => 'batch',
                'code'     => '_batch',
                'sortable' => false
            ));

            $fieldDescription->setAdmin($this);
            $fieldDescription->setTemplate('SonataAdminBundle:CRUD:list__batch.html.twig');

            $mapper->add($fieldDescription, 'batch');
        }

        $this->configureListFields($mapper);

        foreach($this->extensions as $extension) {
            $extension->configureListFields($mapper);
        }
    }
}
