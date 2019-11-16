<?php


require_once('tcpdf_include.php');
///--------------------------

class MYPDF extends TCPDF {

    //Page header
     public function Header() {
        $bMargin = $this->getBreakMargin();
        $auto_page_break = $this->AutoPageBreak;
        $this->SetAutoPageBreak(false, 0);
        $img_file = K_PATH_IMAGES."tec.jpg";
        $this->Image($img_file, 0, 0, 200, 280, '', '', '', false, 500, '', false, false, 0);
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        $this->setPageMark();
        $image_file = K_PATH_IMAGES."logo2.jpg";
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 0, '<<Proyecto RuTicas>>', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Image($image_file, 160, -10, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
$autores= <<<EOD
Creado por: Paolo Blanco, Gabriel Solórzano, Carlos Gómez
EOD;
        $this->writeHTMLCell(0, 5, '', '', $autores, 0, 1, 0, true, '', true);
        $this->Cell(0, 7, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

//Creación del PDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


//Configuración del pdf
$creador = "Gabriel Solórzano, Paolo Blanco, Carlos Gómez";
$proyecto = "Proyecto RuTicas";
$logo = "logo2.jpg";
$pdf->SetCreator($creador);
$pdf->SetAuthor('TEC');
$pdf->SetTitle('Informe de consulta');
$pdf->SetSubject('Consulta');
$pdf->SetKeywords('Ruticas, PDF, Consulta,Información');
$pdf->SetHeaderData($logo, 20, $proyecto,$creador , array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
$pdf->setFontSubsetting(true);
$pdf->SetFont('dejavusans', '', 11, '', true);
$pdf->AddPage();
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
// --------------------------------------

//Fecha
$mydate=getdate(date("U"));

//Ejemplo se puede jalar desde el session


$myfile = fopen("consulta.txt", "r") or die("Unable to open file!");
$notificaciones = fread($myfile,filesize("consulta.txt"));
fclose($myfile);

$foto = $_POST["foto"];

$imgdata = base64_decode($foto);

/*Información de la notificacion */
$intro = <<<EOD
<h1>Informe de Notificaciones</h1>
<i>El presente documento brinda la información de las notificaciones de las paradas generadas en el sistema Ruticas el día : </i> $mydate[mday] / $mydate[mon] / $mydate[year] <br>
EOD;


$infoConsulta = <<<EOD
<br><p>$notificaciones</p>

EOD;


//Inserción del texto
$pdf->writeHTMLCell(0, 0, '', '', $intro, 0, 1, 0, true, '', true);
//$pdf->Image('@'.$imgdata ,50, 60, 120);
$pdf->writeHTMLCell(0, 0, '', '', $infoConsulta, 0, 1, 0, true, '', true);
//$pdf->Image('images/image_demo.png', 40, 190, 140, 70, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);

// ---------------------------------------------------------

// Abrir el pdf
$pdf->Output('consulta.pdf', 'I');



//============================================================+
//Fin de la creación 
//============================================================+
