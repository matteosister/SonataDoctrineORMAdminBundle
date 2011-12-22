<?php
/**
 * User: matteo
 * Date: 06/12/11
 * Time: 22.06
 *
 * Just for fun...
 */

namespace Sonata\DoctrineORMAdminBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TreeController extends CRUDController
{
    /**
     * return the Response object associated to the list action
     *
     * @return Response
     */
    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        //$datagrid = $this->admin->getDatagrid();
        //$formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        //$this->get('twig')->getExtension('form')->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getListTemplate(), array(
            'action'   => 'list',
            //'form'     => $formView,
            //'datagrid' => $datagrid,
            'roots'    => $this->get('doctrine')->getRepository($this->admin->getClass())->getRootNodes()
        ));
    }


    public function moveAction()
    {

    }
}
