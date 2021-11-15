<?php

use PHPMailer\PHPMailer\PHPMailer;

require('../../fpdf/fpdf.php');
require_once('../../fpdf/PHPMailer.php');
require_once('../../fpdf/Exception.php');
require_once('../../fpdf/SMTP.php');




if (isset($_GET['id'])){
    $id_orden=$_GET['id'];
}


 $listacorreos=[];
class PDF extends FPDF{    
    
function Header(){
    
    $this->Image('logopdf.jpg',58,12,100);
    
        
    $this->SetFont('Arial', 'B', 7);
    $y = $this->GetY()+17;
    
    $this->setTextColor(13,26,97);
    $this->SetXY(80, $y);
    $this->MultiCell(79, 3, utf8_decode("SOLUCIONES INTEGRALES PARA LA INDUSTRIA"), 0, 'L');
   
    $this->setTextColor(0);
    $this->SetFont('Arial', 'I', 8);
    $this->SetXY(53, $y+8);
    $this->MultiCell(160, 5, utf8_decode(" ZONA INDUSTRIAL LOS PINOS N° H-5 CAR. PANAMERICANA NORTE-CHIMBOTE "), 0, 'L');

    $this->SetXY(92, $y+2);
    $this->MultiCell(79, 25, utf8_decode("RUC: 20600884361"), 0, 'L');
    


$this->setTextColor(0);


}
     
    function Body() {
        $yy = 51; //Variable auxiliar para desplazarse 40 puntos del borde superior hacia abajo en la coordenada de las Y para evitar que el título este al nivel de la cabecera.
        $y = $this->GetY(); 
        $x = 12;
        $this->AddPage($this->CurOrientation);
         
        $this->SetFont('helvetica', 'B', 20); //Asignar la fuente, el estilo de la fuente (negrita) y el tamaño de la fuente
        $this->SetXY(0, $y + $yy); //Ubicación según coordenadas X, Y. X=0 porque empezará desde el borde izquierdo de la página
        
      

        if (isset($_GET['id'])){
            $id_orden=$_GET['id'];
        }
        
        $this->SetFont('arial', 'B', 15);
        $this->SetXY(55, 38);
         $this->Cell(100, 40,utf8_decode("ORDEN DE COMPRA"), 0, 1, 'C');

         $this->SetFont('arial', '', 9);
         $this->SetXY(55, 45);
          $this->Cell(100, 40,utf8_decode($id_orden), 0, 1, 'C');

        $this->SetFont('arial', '', 8);
        if (isset($_GET['id'])){
            $id_orden=$_GET['id'];
        }
        $pdf=true;
        require_once "./../../core/mainModel.php";
        $result = mainModel::ejecutar_consulta_simple("SELECT fecha_ord FROM ordencompra WHERE id_orden='$id_orden'  ");
        
        while ($row= $result->fetch()) {
          $fecha=$row["fecha_ord"];

        } 
        $y = $this->GetY()-20;
        $this->SetFont('helvetica', 'B', 8);
        $this->SetXY(25, $y);
        
        $fecha=substr(utf8_decode($fecha),0,10);
        $this->MultiCell(160,14, 'Chimbote '.$fecha,0, 'R');
         
        $this->SetFont('courier', 'U', 15); 

        
         
        
        $y = $this->GetY();
        $this->SetXY(25, $y);
        $this->SetFont('','B');
        $fill = True;
        $posicion_MulticeldaDX= $this->GetX();//Aquí inicializo donde va a comenzar el primer recuadro en la posición X
        $posicion_MulticeldaDY= $this->GetY();//Aquí inicializo donde va a comenzar el primer recuadro en la posición Y
        //Estas lineas comentadas las ocupo para verificar la posición, imprime la posición de cada eje//
        //$this->Cell(50,5,utf8_decode('Posicion X'  ." " .$posicion_MulticeldaDX),1,0,'C');
        //$this->Cell(50,5,utf8_decode('Posicion Y'  ." " .$posicion_MulticeldaDY),1,0,'C');
  //-------------------------------------------------------------------------//
//**************************************************************************//
      // Estas lineas son para asignar relleno, color del texto y color de lineas de contorno si mal no recuerdo //
        

        $this->SetFont('arial', '', 8);   
//*************************************************************************//
        if (isset($_GET['id'])){
            $id_orden=$_GET['id'];
        }
        $pdf=true;
        require_once "./../../core/mainModel.php";
        $result = mainModel::ejecutar_consulta_simple("SELECT pe.razon_social,pe.representante,pe.ruc,pe.telefono FROM ordencompra ord INNER JOIN detalleorden de on ord.id_orden=de.id_orden INNER JOIN persona pe on de.id_persona=pe.id_persona  WHERE ord.id_orden='$id_orden'");
        $numero=0;
        while ($row= $result->fetch()) {
            $razon_social=$row["razon_social"];
            $representante=$row["representante"];
            $ruc=$row["ruc"];
            $telefono=$row["telefono"];

        
        }
        
        
        $this->SetXY($posicion_MulticeldaDX,$posicion_MulticeldaDY); //Aquí le indicas la posición de la esquina superior izquierda para el primer multicell que envuelve toda la tabla o recuadro
        $this->MultiCell(137,25,'',0);
        $this->SetXY($posicion_MulticeldaDX,$posicion_MulticeldaDY); // Esto posiciona cada etiqueta en base a la posición de la esquina
        $this->SetFont('arial', 'B', 8);
        
        $this->SetTextColor(1); 
        $this->Cell(137,5,'RAZON SOCIAL', 0,1,'L');
        $this->SetXY($posicion_MulticeldaDX+35,$posicion_MulticeldaDY+0);
        $this->SetFont('arial', '', 8);
        $this->Cell(80,5,utf8_decode(": ".$razon_social),0,1,'L',0);
        $this->SetXY($posicion_MulticeldaDX,$posicion_MulticeldaDY+5);
        $this->SetFont('arial', 'B', 8);
        $this->Cell(137,5,'RUC:', 0,1,'L');
        $this->SetXY($posicion_MulticeldaDX+35,$posicion_MulticeldaDY+5);
        $this->SetFont('arial', '', 8);
        $this->Cell(80,5,utf8_decode(": ".$ruc) ,0,1,'L',0);
        $this->SetXY($posicion_MulticeldaDX,$posicion_MulticeldaDY+10);
        $this->SetFont('arial', 'B', 8);
        $this->Cell(137,5,'USUARIO', 0,1,'L');
        $this->SetXY($posicion_MulticeldaDX+35,$posicion_MulticeldaDY+10);
        $this->SetFont('arial', '', 8);
        $this->Cell(80,5,utf8_decode(": ".$representante ),0,1,'L',0);
        $this->SetXY($posicion_MulticeldaDX,$posicion_MulticeldaDY+15);
        $this->Ln();  // Termina seccion de multicelda de datos de dependencia
        $this->SetFont('','B');
        
        
        $this->SetFont('courier', 'U', 15); //Asignar la fuente, el estilo de la fuente (subrayado) y el tamaño de la fuente
        $y = $this->GetY(); 
        
        $this->SetFont('arial', '', 8);   
        $this->SetFillColor(61,70,255);
        $this->setTextColor(255,255,255);
        $this->SetDrawColor(61,70,255);

        $this->SetXY(10, $y);
        $this->MultiCell(15, 4, utf8_decode("ITEM"), 1, 'C',1); //Utilizamos el utf8_decode para evitar código basura o ilegible
        $this->SetXY(25, $y); //El resultado 22 es la suma de la posición 10 y el tamaño del MultiCell de 12.
        $this->MultiCell(85, 4, utf8_decode("DESCRIPCION"), 1, 'C',1);
        $this->SetXY(110, $y);
        $this->MultiCell(20, 4, utf8_decode("UNIDAD"), 1, 'C',1);
        $this->SetXY(130, $y);
        $this->MultiCell(18, 4, utf8_decode("CANTIDAD"), 1, 'C',1);
        $this->SetXY(148, $y);
        $this->MultiCell(25, 4, utf8_decode("PRECIO/UNIDAD"), 1, 'C',1);  
        $this->SetXY(173, $y);
        $this->MultiCell(27, 4, utf8_decode("PRECIO/TOTAL"), 1, 'C',1);      
        $this->setTextColor(0,0,0);      
        $n = 1;

        $pdf=true;
        
        if (isset($_GET['id'])){
        $id=$_GET['id'];
        }
        require_once "./../../core/mainModel.php";
        $result = mainModel::ejecutar_consulta_simple("SELECT subtotal_ord,igv_ord,total_ord,de.desc_ord,de.unidad_ord,de.cantidad_ord,de.precio_uni,de.precio_total FROM `ordencompra` ord INNER JOIN detalleorden de ON ord.id_orden=de.id_orden WHERE ord.id_orden='$id_orden' ORDER BY de.desc_ord ASC");
        $numero=0;
        $subtotal=0;
        $igv=0;
        $total=0;
        while ($row= $result->fetch()) {
        $numero++;
        $subtotal=$row['subtotal_ord'];
        $igv=$row['igv_ord'];
        $total=$row['total_ord'];
        $y = $this->GetY(); //Utilizamos el utf8_decode para evitar código basura o ilegible
         //El resultado 22 es la suma de la posición 10 y el tamaño del MultiCell de 12.
        
        $cadena=$row['desc_ord'];
        $contarLetras=$contarLetras+strlen($cadena);
        $longitud=strlen($cadena);
        $m=0;

        $Caracteres = strlen($row['desc_ord']);

     //Dividimos los caracteres entre los que caben en una columna
     $Tot = $Caracteres/65;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                

     //Redondeamos el resultado y lo multiplicamos por el alto de las filas
        $Filas = ceil($Tot);
        $m = ($Filas == 0)? 4 : $Filas * 8;
        $this->SetDrawColor(255,255,255);

        $dividir = $numero / 2;
        $partes = explode(".", $dividir);
        if (isset($partes[1])) {

            $this->SetFillColor(217,220,255);
        } else {
            
        $this->SetFillColor(255,255,255);
        }

        $this->SetXY(10, $y);
        $this->MultiCell(15, $m, utf8_decode($numero), 1, 'C',1);
        $this->SetXY(25, $y); //El resultado 22 es la suma de la posición 10 y el tamaño del MultiCell de 12.
        $this->MultiCell(85, 8, utf8_decode($row['desc_ord']), 1, 'C',1);
        $this->SetXY(110, $y);
        $this->MultiCell(20, $m, utf8_decode($row['unidad_ord']), 1, 'C',1);
        $this->SetXY(130, $y);
        $this->MultiCell(18, $m, utf8_decode($row['cantidad_ord']), 1, 'C',1);
        $this->SetXY(148, $y);
        $this->MultiCell(25, $m, 'S/ '.utf8_decode(mainModel::moneyFormat($row['precio_uni'],"USD") ), 1, 'C',1);  
        $this->SetXY(173, $y);
        $this->MultiCell(27, $m, 'S/ '.utf8_decode(mainModel::moneyFormat( $row['precio_total'],"USD")), 1, 'C',1);      
        
        

        if($contarLetras>700){

            $contarLetras=0;
            $this->AddPage(); // page break. 
            $this->Cell(100,8,'','B',2); 
            $y = $this->GetY()+10; 
        }
        }
        
        $y = $this->GetY();
        $this->SetXY(148, $y);
        $this->SetFillColor(61,70,255);
        $this->setTextColor(255,255,255);
        $this->SetDrawColor(255,255,255);
        $this->MultiCell(25, 6, utf8_decode("SUB TOTAL"), 1, 'C',1);  
        
        $this->setTextColor(0);
        $this->SetDrawColor(217,220,255);
        $this->SetFillColor(217,220,255);
        $this->SetXY(173, $y);

        
        $this->MultiCell(27, 6, 'S/ '.utf8_decode(mainModel::moneyFormat($subtotal,"USD")), 1, 'C',1);   
        $y = $this->GetY();
        $this->SetXY(148, $y);

        
        //IGV
        if ($igv!=0) {
            
        $this->SetFillColor(61,70,255);
        $this->setTextColor(255,255,255);
        $this->SetDrawColor(255,255,255);
        $this->MultiCell(25, 6, utf8_decode("MONTO IGV"), 1, 'C',1);  
        $this->setTextColor(0);
        $this->SetDrawColor(217,220,255);
        $this->SetFillColor(217,220,255);


        $this->SetXY(173, $y);
        $this->MultiCell(27, 6, 'S/ '.utf8_decode(mainModel::moneyFormat($igv,"USD")), 1, 'C',1);   
        $y = $this->GetY();
        $this->SetXY(148, $y);


        $this->SetFillColor(61,70,255);
        $this->setTextColor(255,255,255);
        $this->SetDrawColor(255,255,255);
        $this->MultiCell(25, 6, utf8_decode("TOTAL"), 1, 'C',1);  
        $this->setTextColor(0);
        $this->SetDrawColor(217,220,255);
        $this->SetFillColor(217,220,255);


        $this->SetXY(173, $y);
        $this->MultiCell(27, 6, 'S/ '.utf8_decode(mainModel::moneyFormat($total,"USD")), 1, 'C',1);  
        }

 
        

        $this->Ln(25);
        $y = $this->GetY();
        if (isset($_GET['id'])){
        $id_orden=$_GET['id'];
        }
        $pdf=true;
        require_once "./../../core/mainModel.php";
        $result = mainModel::ejecutar_consulta_simple("SELECT nota_ord FROM ordencompra WHERE id_orden='$id_orden'  ");
        $numero=0;
        while ($row= $result->fetch()) {
        $this->SetXY(24, $y);      
        $this->SetFillColor(255,255,255);
        $this->SetFont('Arial','B',8);
        $this->MultiCell(100, 4, utf8_decode('TERMINOS Y CONDICIONES'), 0, 1, 'L');
        
        $this->SetXY(24, $y+5); 
        $this->SetFont('arial', '', 8);
        $this->MultiCell(100, 4, utf8_decode($row["nota_ord"]), 0, 1, 'L');

        }

        $this->Image('homologaciones/hodelpe.png',110,210,40);
        $this->Image('homologaciones/sgs.png',150,210,60);
        
    }

    
    function Footer()
    {
        
        $this->SetDrawColor(61,70,255);

        
        $this->Image('iconospdf/navegador.png',39,258,4);
        $this->Image('iconospdf/email.png',89,258,4);
        $this->Image('iconospdf/telefono.png',142,258,4);
        
        $this->SetXY(10, 254);
        $this->Cell(190, 12 , utf8_decode("      www.semmar-manufacturing.com          semmarmanufacturing@gmail.com            +51 925 924 181"), 1, 1, 'C');
         
        $this->SetXY(24, 275);
        $this->MultiCell(160, 1, utf8_decode("DOM. FISCAL: PJ MARTIR JOSE OLAYA N° 129 , INT. 1905 URB. CERCADO DE MIRAFLORES - LIMA"), 0, 'C');

    }


}



$listacorreos=[];

    if (isset($_GET['id_email'])){
        $id_email=$_GET['id_email'];
    }
        $pdf=true;
        require_once "./../../core/mainModel.php";
        $tmp=mainModel::array_recibe($id_email);



   
        for ($j=0; $j < count($tmp); $j++) { 
            require_once "./../../core/mainModel.php";
            $id=$tmp[$j];
            $result = mainModel::ejecutar_consulta_simple("SELECT email FROM email WHERE id_email='$id'; ");
           
            while ($row= $result->fetch()) {
            
                array_push($listacorreos, $row["email"]);
            
            }  
            
        }
        
        
 
$pdf = new PDF();
$pdf->pagina = 0;
$pdf->AliasNbPages(); //Permitir el conteo de la cantidad de páginas existentes {nb}
$pdf->Body(); //Llamada a la función Body para generar el PDF
$pdf->Footer(); //Llamada a la función Body para generar el PDF
$pdf->Output('orden/'.$id_orden.'.pdf','F',false); //El primer parámetro es para colocar el nombre del archivo al momento de ser descargado y el segundo parámetro es para abrir el archivo en el navegador con la opción para poder ser descargado
header("Content-type:application/pdf");



try {
$phpMailer = new PHPMailer();
    $phpMailer->setFrom("ventas@semmar-manufacturing.com", "SEMMAR MANUFACTURING"); # Correo y nombre del remitente
    
    $phpMailer->Subject = "Archivo adjunto"; # Asunto
    $phpMailer->Body = "Hola, amigo. Estamos probando los archivos adjuntos."; # Cuerpo en texto plano
    // Aquí la magia:


 # El destinatario

 if (isset($_GET['cant'])){
     $cantidadCorreos=$_GET['cant'];
 }
 for ($i=0; $i < $cantidadCorreos; $i++) { 
    
 $phpMailer->addAddress($listacorreos[$i]);
 }


 

 $phpMailer->AddStringAttachment($pdf->Output('','S'), 'orden/'.$id_cotizacion.'.pdf', 'base64', 'application/pdf');
   

    if (!$phpMailer->send()) {
        echo "Error enviando correo: " . $phpMailer->ErrorInfo;
    }
    # Opcionalmente podrías eliminar el archivo después de enviarlo, si quieres
    // if (file_exists($nombreDelDocumento)) {
    // unlink($nombreDelDocumento);
    // }
    echo "Enviado correctamente";
} catch (Exception $e) {
    echo "Excepción: " . $e->getMessage();
}



readfile('orden/'.$id_orden.'.pdf');
