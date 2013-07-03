<?php

namespace Aleste\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/demo", name="demo")
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
    public function exportExcel()
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
    public function exportPdf()
    {

        $contenedor = $this->container;
        $pdf = $contenedor->get("white_october.tcpdf")->create('p');
        $pdf->addPage();

        $engine = $this->container->get('templating');
        $content = $engine->render('AlesteDemoBundle:Default:exportpdf.html.twig');

        $htmlOpen = <<<EOD
<h1>Proyecto Base</h1>
<i>Demo export a Pdf</i><hr />
<table><tr><td width="180"><b>Titulo</b></td><td width="280"><b>Descripcion</b></td></tr>
EOD;

    $htmlClose = '</table>';
    $htmlContent = '';
    $pdf->SetFont('helvetica', '', 8);

    $em = $this->getDoctrine()->getManager();
    $posts = $this->getDoctrine()->getRepository('AlesteDemoBundle:Post')->findAll();
    foreach ($posts as $data) {
        $htmlContent .= '<tr><td>'.strtoupper($data->getTitle()).'</td><td>'.strtoupper($data->getDescription()).'</td></tr>';
    }

    $htmlExport = $htmlOpen.$htmlContent.$htmlClose;

    $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $htmlExport , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    $pdf->Output('demo_pdf.pdf', 'D');
    }
}
