<?php

require('TCPDF/tcpdf.php');

class InformePDF extends TCPDF {
    public $titulo;
    // Load table data from file
    public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }
    /*
    //Page header
    public function Header() {
        // Logo
        $image_file = __DIR__.'/../logo.png';
        //$this->Image($image_file, 10, 10, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(100, 0, $this->titulo, 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->Cell(100, 0, $this->titulo, 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Image($image_file, 15, 2, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

    }*/

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    // Colored table
    public function generar($header,$data) {
        
        // Colors, line width and bold font
        $this->SetFillColor(200, 200, 200);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.01);
        $this->SetFont('', 'B');
        
        // Header
        $t=$this->getPageWidth()-$this->getOriginalMargins()['left']-$this->getOriginalMargins()['right'];
        
        foreach($header as $h)
        {
            $this->Cell($h['w']*$t/100, 5, $h['t'], 1, 0, 'C', 1);        
        }
        $this->Ln();
        
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {
            foreach($header as $h)
            {
              $align=isset($h['a']) ? $h['a'] : (is_numeric($row[$h['k']]) ? 'R' : 'L');
              $this->Cell($h['w']*$t/100  , 5, $row[$h['k']], 'LR', 0, $align, $fill);            
            }
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell($t, 0, '', 'T');
        
      // close and output PDF document
      $this->Output('listado.pdf', 'I');
    }
}

function generar_informe($datos, $cabecera, $titulo='Informe')
{
  // create new PDF document
  $pdf = new InformePDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf->titulo=$titulo;

  // set document information

  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Nicola Asuni');
  $pdf->SetTitle($titulo);
  $pdf->SetSubject('TCPDF Tutorial');
  $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

  // set header and footer fonts
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
  // set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
  $pdf->setHeaderData('logo.png', 18, 'Informe', $titulo);
  
  // set margins
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-2, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER+5);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

  // set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  // set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
  // ---------------------------------------------------------

  // set font
  $pdf->SetFont('helvetica', '', 10);

  // add a page
  $pdf->AddPage();


  // print colored table
  $pdf->generar($cabecera,$datos);
}

function crear_html_plantilla($plantilla, $datos)
{
    extract($datos);
    ob_start();
    include $plantilla;
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}

function generar_codigo_barras($tipo, $datos, $opciones=null)
{
  require('librerias/barcode.php');
  $generator = new barcode_generator();
  $image = $generator->render_image($tipo, $datos, $opciones);
  ob_start();
  imagepng($image);
  $codigo_barras = base64_encode(ob_get_contents());
  ob_end_clean();
  imagedestroy($image);
  
  return $codigo_barras;
}

function generar_qr($datos)
{
  require('librerias/TCPDF/tcpdf_barcodes_2d.php');
  $barcode = new TCPDF2DBarcode($datos, 'QRCODE,H');
  return base64_encode($barcode->getBarcodePngData(3, 3, array(0,0,0)));
}

function generar_codigo_barras_tcpdf($tipo, $datos, $opciones=null)
{
  require('librerias/TCPDF/tcpdf_barcodes_1d.php');

  // Crear objeto de código de barras
  $barcode = new TCPDFBarcode($datos, $tipo);

  // Generar los datos del código de barras en formato PNG
  $png_data = $barcode->getBarcodePngData(1, 20, array(0,0,0)); // ancho_barra, alto, color (RGB)
  return base64_encode($png_data);

}

function generar_pdf($plantilla, $titulo, $datos=[])
{
  // create new PDF document
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  // set document information
  $pdf->setCreator(PDF_CREATOR);
  $pdf->setAuthor('Nicola Asuni');
  $pdf->setTitle($titulo);
  $pdf->setSubject('TCPDF Tutorial');
  $pdf->setKeywords('TCPDF, PDF, example, test, guide');
  
  $pdf->setPrintHeader(false);
  $pdf->setPrintFooter(false);

  // set default header data
  //$pdf->setHeaderData('logo.png', 25, $titulo, PDF_HEADER_STRING, array(0,0,0), array(0,64,128));
  //$pdf->setFooterData(array(0,64,0), array(0,64,128));

  // set header and footer fonts
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

  // set default monospaced font
  $pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  // set margins
  $pdf->setMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
  //$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
  //$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

  // set auto page breaks
  $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  // set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

  // set default font subsetting mode
  $pdf->setFontSubsetting(true);

  // Set font
  // dejavusans is a UTF-8 Unicode font, if you only need to
  // print standard ASCII chars, you can use core fonts like
  // helvetica or times to reduce file size.
  $pdf->setFont('dejavusans', '', 14, '', true);

  // Add a page
  // This method has several options, check the source code documentation for more information.
  $pdf->AddPage();

  // set text shadow effect
  $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

  // Set some content to print
  $html = crear_html_plantilla($plantilla, $datos);

  // Print text using writeHTMLCell()
  $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

  $pdf->Output($titulo.'.pdf', 'I');
}

