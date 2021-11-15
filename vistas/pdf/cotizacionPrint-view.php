<?php

use PHPMailer\PHPMailer\PHPMailer;

require('../../fpdf/fpdf.php');
require_once('../../fpdf/PHPMailer.php');
require_once('../../fpdf/Exception.php');
require_once('../../fpdf/SMTP.php');



if (isset($_GET['id'])){
    $id_cotizacion=$_GET['id'];
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
         
        $this->SetFont('helvetica', 'B', 12); //Asignar la fuente, el estilo de la fuente (negrita) y el tamaño de la fuente
        $this->SetXY(0, $y + $yy); //Ubicación según coordenadas X, Y. X=0 porque empezará desde el borde izquierdo de la página
       
        
        if (isset($_GET['id'])){
            $id_cotizacion=$_GET['id'];
        }
        
        $this->SetFont('arial', 'B', 15);
        $this->SetXY(55, 38);
         $this->Cell(100, 40,utf8_decode("COTIZACION"), 0, 1, 'C');

         $this->SetFont('arial', '', 9);
         $this->SetXY(55, 45);
          $this->Cell(100, 40,utf8_decode($id_cotizacion), 0, 1, 'C');

        $this->SetFont('arial', '', 8);
        
        if (isset($_GET['id'])){
            $id_cotizacion=$_GET['id'];
        }
        $pdf=true;
        require_once "./../../core/mainModel.php";
        $result = mainModel::ejecutar_consulta_simple("SELECT fecha_cotcli FROM cotizacioncliente WHERE id_cotcli='$id_cotizacion'  ");
        
        while ($row= $result->fetch()) {
          $fecha=$row["fecha_cotcli"];

        } 
        $y = $this->GetY()-20;
        $this->SetFont('helvetica', 'B', 8);
        $this->SetXY(25, $y);
        $fecha=substr(utf8_decode($fecha),0,10);
        $this->MultiCell(160,14, 'Chimbote '.$fecha,0, 'R');
         
        
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
            $id_cotizacion=$_GET['id'];
        }
        $pdf=true;
        require_once "./../../core/mainModel.php";
        $result = mainModel::ejecutar_consulta_simple("SELECT co.cod_cot,pe.razon_social,pe.representante,pe.ruc,pe.telefono FROM cotizacioncliente co INNER JOIN persona pe on co.id_persona=pe.id_persona  WHERE co.id_cotcli='$id_cotizacion'  ");
        $numero=0;
        while ($row= $result->fetch()) {
            $razon_social=$row["razon_social"];
            $representante=$row["representante"];
            $ruc=$row["ruc"];
            $telefono=$row["telefono"];
            $codigo_req=$row["cod_cot"];

        
        }
        $this->SetXY($posicion_MulticeldaDX,$posicion_MulticeldaDY); //Aquí le indicas la posición de la esquina superior izquierda para el primer multicell que envuelve toda la tabla o recuadro
        $this->MultiCell(137,25,'',0);
        $this->SetXY($posicion_MulticeldaDX,$posicion_MulticeldaDY); // Esto posiciona cada etiqueta en base a la posición de la esquina
        $this->SetFont('arial', 'B', 8);
        
        $this->SetTextColor(1); 
        $this->Cell(137,10,'SRES.', 0,1,'L');
        $this->SetXY($posicion_MulticeldaDX+26,$posicion_MulticeldaDY+0);
        $this->SetFont('arial', '', 8);
        $this->Cell(80,10,utf8_decode(": ".$razon_social),0,1,'L',0);
        $this->SetXY($posicion_MulticeldaDX,$posicion_MulticeldaDY+5);
        $this->SetFont('arial', 'B', 8);
        $this->Cell(137,10,'RUC', 0,1,'L');
        $this->SetXY($posicion_MulticeldaDX+26,$posicion_MulticeldaDY+5);
        $this->SetFont('arial', '', 8);
        $this->Cell(80,10,utf8_decode(": ".$ruc) ,0,1,'L',0);
        $this->SetXY($posicion_MulticeldaDX,$posicion_MulticeldaDY+10);
        $this->SetFont('arial', 'B', 8);
        $this->Cell(137,10,'USUARIO', 0,1,'L');
        $this->SetXY($posicion_MulticeldaDX+26,$posicion_MulticeldaDY+10);
        $this->SetFont('arial', '', 8);
        $this->Cell(80,10,utf8_decode(": ".$representante ),0,1,'L',0);
        $this->SetXY($posicion_MulticeldaDX,$posicion_MulticeldaDY+15);
        $this->SetFont('arial', 'B', 8);
        $this->Cell(137,10,'NRO REQ/SOLPED', 0,1,'L');
        $this->SetXY($posicion_MulticeldaDX+26,$posicion_MulticeldaDY+15);
        $this->SetFont('arial', '', 8);
        $this->Cell(80,10,utf8_decode(": ".$codigo_req),0,1,'L',0);
        $this->Ln();  // Termina seccion de multicelda de datos de dependencia
        $this->SetFont('','B');
        
        
        
        
        // $this->SetFont('helvetica', 'B', 12); //Asignar la fuente, el estilo de la fuente (subrayado) y el tamaño de la fuente
        // $y = $this->GetY(); 
        // $this->SetXY(25, $y); //Ubicación según coordenadas X, Y. X=0 porque empezará desde el borde izquierdo de la página
        // $this->Cell(120, 10, "DATOS DE CLIENTE", 0, 10, 'L');

        
         
        // $this->SetFont('arial', '', 9);
        // $y = $this->GetY() ;
        
        // $this->SetXY(25, $y);
        // $this->Cell(190, 10, utf8_decode('Razon Social: '.$razon_social), 0, 1, 'L');
        // $this->SetXY(25, $y);
        // $this->Cell(190, 20, utf8_decode('Representante: '.$representante), 0, 1, 'L');
        // $this->SetXY(25, $y);
        // $this->Cell(190, 30, utf8_decode('RUC: '.$ruc), 0, 1, 'L'); 
        // $this->SetXY(25, $y);
        // $this->Cell(190, 40, utf8_decode('Teléfono: '.$telefono), 0, 1, 'L'); 
        // //ESTO ES PARA EL ARREGLO (ARRAY ) DE CORREOS 
        // if (isset($_GET['id_email'])){
        //     $id_email=$_GET['id_email'];
        // }
        
        // require_once "./../../core/mainModel.php";
        // $tmp=mainModel::array_recibe($id_email);



        // $espacio=40;
        // $contador=0;
       
        //     for ($j=0; $j < count($tmp); $j++) { 
        //         $espacio=$espacio+10;
        //         $contador++;
        //         $pdf=true;
        //         require_once "./../../core/mainModel.php";
        //         $id=$tmp[$j];
        //         $result = mainModel::ejecutar_consulta_simple("SELECT email FROM Email WHERE id_email='$id'; ");
               
        //         while ($row= $result->fetch()) {
        //         $this->SetXY(25, $y);
        //         $this->Cell(190, $espacio, utf8_decode('Correo '.$contador.':  '.$row["email"]), 0, 1, 'L'); 
            
        
                
        //         }  
        //     }
        
         //Asignar la fuente, el estilo de la fuente (subrayado) y el tamaño de la fuente
        $y = $this->GetY()-7; 
        
        $this->SetFont('arial', '', 8);   
        $this->SetFillColor(61,70,255);
        $this->setTextColor(255,255,255);
        $this->SetDrawColor(61,70,255);
         
        $this->SetXY(25, $y);
        $this->MultiCell(15, 8, utf8_decode("ITEM"), 1, 'C',1); 
        $this->SetXY(40, $y);
        $this->MultiCell(15, 8, utf8_decode("UNIDAD"), 1, 'C',1);   //Utilizamos el utf8_decode para evitar código basura o ilegible
        $this->SetXY(55, $y);
        $this->MultiCell(20, 8, utf8_decode("CANTIDAD"), 1, 'C',1);
        $this->SetXY(75, $y); //El resultado 22 es la suma de la posición 10 y el tamaño del MultiCell de 12.
        $this->MultiCell(90, 8, utf8_decode("DESCRIPCION"), 1, 'C',1);   //Utilizamos el utf8_decode para evitar código basura o ilegible
        $this->SetXY(165, $y);
        $this->MultiCell(25, 8, utf8_decode("PRECIO"), 1, 'C',1);  
        $this->setTextColor(0,0,0);   
        $n = 1;

        $pdf=true;
        
        if (isset($_GET['id'])){
        $id_cotizacion=$_GET['id'];
        }
        require_once "./../../core/mainModel.php";
        $result = mainModel::ejecutar_consulta_simple("SELECT * FROM cotizacioncliente co INNER JOIN detallecotizacioncliente de ON co.id_cotcli=de.id_cotcli WHERE co.id_cotcli='$id_cotizacion' ORDER BY desc_det_cotcli ASC ");
        $numero=0;
        $total=0;
        $subtotal=0;
        $cantidadDefilas=$result->rowCount();
        while ($row= $result->fetch()) {
        $total=mainModel::moneyFormat($row['total_cotcli'],"USD");
        $subtotal=mainModel::moneyFormat($row['subtotal_cotcli'],"USD");
        $numero++;
        $y = $this->GetY();
        $cadena=$row['desc_det_cotcli'];
        $contarLetras=$contarLetras+strlen($cadena);
        $longitud=strlen($cadena);
        $m=0;
        
        $Caracteres = strlen($row['desc_det_cotcli']);

     //Dividimos los caracteres entre los que caben en una columna
     $Tot = $Caracteres/56;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                

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

        $this->SetXY(25, $y);
        $this->MultiCell(15, $m, utf8_decode($numero), 1, 'C',1); 
        $this->SetXY(40, $y);
        $this->MultiCell(15, $m, utf8_decode($row['unidad_det_cotcli']), 1, 'C',1); //Utilizamos el utf8_decode para evitar código basura o ilegible
        $this->SetXY(55, $y);
        $this->MultiCell(20, $m, utf8_decode($row['cantidad_det_cotcli']), 1, 'C',1); 
        $this->SetXY(75, $y); 
        $this->MultiCell(90, 8, utf8_decode($row['desc_det_cotcli']), 1, 'C',1);
        $this->SetXY(165, $y);
        require_once "./../../core/mainModel.php";
        $this->MultiCell(25, $m, utf8_decode("S/ ".mainModel::moneyFormat($row['precio_det_cotcli'],"USD")), 1, 'C',1);  
        
        if ($numero == $cantidadDefilas)
        {
            $this->SetFillColor(61,70,255);
            $this->setTextColor(255,255,255);
            $this->SetDrawColor(255,255,255);
            $y = $this->GetY()+5;
            $this->SetXY(145, $y);
            $this->MultiCell(20, 8, utf8_decode("SUBTOTAL"), 1, 'C',1);  
            
            $this->setTextColor(0);
            $this->SetDrawColor(255,255,255);
            $this->SetFillColor(217,220,255);
            $this->SetXY(165, $y);
            $this->MultiCell(25, 8, 'S/ '.utf8_decode($subtotal), 1, 'C',1);  
            $y = $this->GetY();
            $this->SetXY(145, $y);
            
            
            require_once "./../../core/mainModel.php";
            $result = mainModel::ejecutar_consulta_simple("SELECT igv_cotcli FROM cotizacioncliente WHERE id_cotcli='$id_cotizacion'  ");
            $igv_monto=0;
            while ($row6= $result->fetch()) {
                $igv_monto=$row6["igv_cotcli"];
            }
    
            if ($igv_monto>0) {
                
            $this->SetFillColor(61,70,255);
            $this->setTextColor(255,255,255);
            $this->SetDrawColor(255,255,255);
            $this->MultiCell(20, 8, utf8_decode("IGV"), 1, 'C',1);
            $this->setTextColor(0); 
            $this->SetDrawColor(255,255,255);
            $this->SetXY(165, $y);
            $this->MultiCell(25, 6, 'S/ '.utf8_decode(mainModel::moneyFormat($total-$subtotal,"USD")), 1, 'C');   
            
            $y = $this->GetY();
            $this->SetXY(145, $y);
            
            $this->SetFillColor(61,70,255);
            $this->setTextColor(255,255,255);
            $this->SetDrawColor(255,255,255);
            $this->MultiCell(20, 8, utf8_decode("TOTAL"), 1, 'C',1);  
            $this->SetXY(165, $y);
            $this->setTextColor(0);
            $this->SetDrawColor(217,220,255);
            $this->SetFillColor(217,220,255);
            $this->MultiCell(25, 8, 'S/ '.utf8_decode($total), 1, 'C',1);  
            } 
        }
        if($contarLetras>=400){

            $contarLetras=0;
            $this->AddPage(); // page break. 
            $this->Cell(100,8,'','',2); 
            $y = $this->GetY()+10; 
        }
        }
        
        
        
    
        $this->Ln(25);
        $y = $this->GetY();
        if (isset($_GET['id'])){
        $id_cotizacion=$_GET['id'];
        }
        $pdf=true;
        require_once "./../../core/mainModel.php";
        $result = mainModel::ejecutar_consulta_simple("SELECT nota_cotcli FROM cotizacioncliente WHERE id_cotcli='$id_cotizacion'  ");
        $numero=0;
        while ($row= $result->fetch()) {
        $this->SetXY(24, $y);      
        $this->SetFillColor(255,255,255);
        $this->SetFont('Arial','B',8);
        $this->MultiCell(100, 4, utf8_decode('TERMINOS Y CONDICIONES'), 0, 1, 'L');
        
        $this->SetXY(24, $y+5); 
        $this->SetFont('arial', '', 8);
        $this->MultiCell(100, 4, utf8_decode($row["nota_cotcli"]), 0, 1, 'L');

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
        $pdf=true;
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
$pdf->Output('cotizacionesClientes/'.$id_cotizacion.'.pdf','F',false); //El primer parámetro es para colocar el nombre del archivo al momento de ser descargado y el segundo parámetro es para abrir el archivo en el navegador con la opción para poder ser descargado
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


 

 $phpMailer->AddStringAttachment($pdf->Output('','S'), 'cotizacionesClientes/'.$id_cotizacion.'.pdf', 'base64', 'application/pdf');
   

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


readfile('cotizacionesClientes/'.$id_cotizacion.'.pdf');

?>  

