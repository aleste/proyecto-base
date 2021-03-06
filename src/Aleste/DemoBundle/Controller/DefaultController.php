<?php

namespace Aleste\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Aleste\DemoBundle\Entity\Post;

/**
 * Default demo controller.
 *
 * @Route("/demo")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="demo")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * Genera y descarga un excel
     * @Route("/excel", name="excel")
     */
    public function exportExcelAction()
    {
        $contenedor =  $this->container;

        $xlsExport    = $contenedor->get('xls.service_xls2007');

        $xlsExport->excelObj->getProperties()->setCreator("Proyecto Base")
                            ->setLastModifiedBy("Proyecto Base")
                            ->setTitle("Demo Excel")
                            ->setSubject("Demo Excel")
                            ->setDescription("Demo Excel")
                            ->setKeywords("demo excel proyecto base")
                            ->setCategory("demo");

        $xlsExport->excelObj->setActiveSheetIndex(0)
                    ->setCellValue('A2', 'Título Columna 1')
                    ->setCellValue('B2', 'Título Columna 2');

        $xlsExport->excelObj->setActiveSheetIndex(0)
                ->setCellValue('A1', "Este el el valor de la celda")
                ->setCellValue('B1', "Otro valor");

        $xlsExport->excelObj->getActiveSheet()->setTitle("Demo");

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $xlsExport->excelObj->setActiveSheetIndex(0);

        //create the response
        $response = $xlsExport->getResponse();
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=demo_excel.xls');

        // If you are using a https connection, you have to set those two headers for compatibility with IE <9
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;
    }

    /**
     * Genera y descarga un pdf
     * @Route("/pdf", name="pdf")
     */
    public function exportPdfAction()
    {

        $contenedor = $this->container;

        $pdf = $contenedor->get("white_october.tcpdf")->create('p');
        $pdf->addPage();

        $engine = $this->container->get('templating');

        $pdf->SetFont('helvetica', '', 8);

        $posts   = $this->getDoctrine()->getRepository('AlesteDemoBundle:Post')->findAll();
        $content = $engine->render('AlesteDemoBundle:Default:exportpdf.html.twig', array('posts' => $posts));


        $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $content , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
        $pdf->Output('demo_pdf.pdf', 'D');
    }


    /**
     * @Route("/version/{id}", name="versiones")
     * @Template()
     */

    public function mostrarVersionesAction(Post $post){

         $em        = $this->getDoctrine()->getManager();
         $repo      = $em->getRepository('Gedmo\Loggable\Entity\LogEntry');
         $versiones = $repo->getLogEntries($post);

        return $this->render('AlesteDemoBundle:Default:versiones.html.twig',
            array('post' => $post, 'versiones' => $versiones));
    }

    /**
     * @Route("/listar", name="listar")
     * @Template()
     */

    public function listarAction() {

        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('ideup.simple_paginator');

        $posts = $paginator->paginate($em->getRepository('AlesteDemoBundle:Post')->queryGetPosts())->getResult();

        return  array('posts' => $posts);
  }

    /**
    * @Route("/ajax", name="ajax", options={"expose"=true})
    * @Template()
    */
    public function ajaxAction()
    {
        return array();
    }

}
