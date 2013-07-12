<?php

namespace Aleste\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aleste\DemoBundle\Entity\Post;
use Aleste\DemoBundle\Form\PostType;
use Aleste\DemoBundle\Form\PostFilterType;
use Symfony\Component\Security\Core\SecurityContext;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Post controller.
 *
 * @Route("/post")
 */
class PostController extends Controller
{

    /**
     * Lists all Post entities.
     *
     * @Route("/", name="post")
     * @Method({"GET", "POST"})
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em             = $this->getDoctrine()->getManager();
        $paginator      = $this->get('ideup.simple_paginator');
        $formFilter     = $this->get('form.factory')->create(new PostFilterType());

        $formFilter->bind($request);
        // initliaze a query builder        
        $filterBuilder  = $em->getRepository('AlesteDemoBundle:Post')->createQueryBuilder('p');
        // build the query from the given form object
        $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($formFilter, $filterBuilder);    
        $queryFilter    = $em->createQuery($filterBuilder->getDql());
        $entities       = $paginator->paginate($queryFilter)->getResult();

        $filtrosActivos =array();
        foreach ($request->query->all() as $key => $value) {
            if($key != "page"){
                $filtrosActivos = array( $key => $value );
            }
        }

        return array(
            'formFilter'        => $formFilter->createView(),
            'filtrosActivos'    => $filtrosActivos,
            'entities'          => $entities
        );
    }
    
    /**
     * Creates a new Post entity.
     *
     * @Route("/", name="post_create")
     * @Method("POST")
     * @Template("AlesteDemoBundle:Post:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Post();
        $form = $this->createForm(new PostType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->clear();
            $this->get('session')->getFlashBag()->add('success', 'base.create.success');
            return $this->redirect($this->generateUrl('post_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Post entity.
     *
     * @Route("/new", name="post_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Post();
        $form   = $this->createForm(new PostType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/{id}/mostrar", name="post_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AlesteDemoBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id}/edit", name="post_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AlesteDemoBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $editForm = $this->createForm(new PostType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Post entity.
     *
     * @Route("/{id}", name="post_update")
     * @Method("PUT")
     * @Template("AlesteDemoBundle:Post:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AlesteDemoBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PostType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();


            $this->get('session')->getFlashBag()->clear();
            $this->get('session')->getFlashBag()->add('success', 'base.edit.success');
            return $this->redirect($this->generateUrl('post_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Post entity.
     *
     * @Route("/{id}", name="post_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AlesteDemoBundle:Post')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->clear();
            $this->get('session')->getFlashBag()->add('success', 'base.delete.success');
        }

        return $this->redirect($this->generateUrl('post'));
    }

    /**
     * Creates a form to delete a Post entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Lists all Post entities with filters
     *
     * @Route("/filter/", name="post_filter")
     * @Method("GET")     
     * @Template()
     */    

    public function testFilterAction(Request $request)
    {
        $form = $this->get('form.factory')->create(new PostFilterType());

        if ($this->get('request')->query->has('submit-filter')) {
            // bind values from the request
            
            $form->bind($request);

            // initliaze a query builder
            $filterBuilder = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AlesteDemoBundle:Post')
                ->createQueryBuilder('e');

            // build the query from the given form object
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

            // now look at the DQL =)
            var_dump($filterBuilder->getDql());
        }

        return array(            
            'form'   => $form->createView(),
        );

    }

}
