<?php
require_once '../phpdocx/classes/CreateDocx.php'; 
include("../conexioncert.php"); 
include("../conexionli.php"); 

if(isset($_GET['CodCertificado'])) 	{ $CodCertificado 	= $_GET['CodCertificado']; 	};
$fechaHoy 	= date('Y-m-d');
$fd = explode('-', $fechaHoy);
$fechaHoy = $fd[2].'-'.$fd['1'].'-'.$fd[0];

$docx = new CreateDocx();
 
$docx->setLanguage('es-ES');
$docx->modifyPageLayout('letter'); 
$docx = new CreateDocxFromTemplate('certificadoconformidad.docx');


$linkc=ConectarseCert();
$link=Conectarse();
$bd = $linkc->query("SELECT * FROM certificado Where CodCertificado = '".$CodCertificado."'");
if($rs=mysqli_fetch_array($bd)){
    $bdcl = $linkc->query("SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'");
    if($rscl=mysqli_fetch_array($bdcl)){

        $fechaCertificado = $rs['fechaCertificado'];
        $fd = explode('-', $fechaCertificado);
        $fechaCertificado = $fd[2].'-'.$fd['1'].'-'.$fd[0];

        $bdpr = $linkc->query("SELECT * FROM tipoproductos Where nProducto = '".$rs['nProducto']."'");
        if($rspr=mysqli_fetch_array($bdpr)){

        }
        $bdac = $linkc->query("SELECT * FROM tipoaceros Where nAcero = '".$rs['nAcero']."'");
        if($rsac=mysqli_fetch_array($bdac)){

        }
        $bdi = $link->query("SELECT * FROM aminformes Where CodInforme = '".$rs['CodInforme']."'");
        if($rsi=mysqli_fetch_array($bdi)){

        }
        $bdmm = $link->query("SELECT * FROM ammuestras Where CodInforme = '".$rs['CodInforme']."'");
        if($rsmm=mysqli_fetch_array($bdmm)){

        }

        $far = explode('-',$CodCertificado);
        $ar = $far[0].'-'.$far[1];
        $bdar = $linkc->query("SELECT * FROM ar Where ar = '".$ar."'");
        if($rsar=mysqli_fetch_array($bdar)){
            $fechaInspeccion = $rsar['fechaInspeccion'];
            $fd = explode('-', $fechaInspeccion);
            $fechaInspeccion = $fd[2].'-'.$fd['1'].'-'.$fd[0];

        }
        $Inspector = 'Dr. Ing. Alfredo Artigas A.';
        $usrInspector = 'DPG'; // Ver esto
        //$bdus = $link->query("SELECT * FROM usuarios Where usr = '".$rsar['usrInspector']."'");
        if($rsar['usrInspector'] == $usrInspector){
            $Inspector = 'Dr. Ing. Alfredo Artigas A.';
        }else{
            $bdus = $link->query("SELECT * FROM usuarios Where usr = '".$usrInspector."'");
            if($rsus=mysqli_fetch_array($bdus)){
                $Inspector = $rsus['usuario'];
            }
        }

        $options = array(
            'target' 		=> 'header',
            'firstMatch' 	=> false,
            );
        
        $docx->replaceVariableByText(array(
            'CodCertificado' 	=> $CodCertificado,
            'CLIENTE' 	        => $rscl['Cliente'],
            ), $options
        );
        $resultadoCertificacion = '';
        if($rs['resultadoCertificacion'] == 'R'){
            $resultadoCertificacion = 'RECHAZADO';
        }
        if($rs['resultadoCertificacion'] == 'A'){
            $resultadoCertificacion = 'ACEPTADO';
        }
        $docx->replaceVariableByText(array(
            'CodCertificado' 	=> $CodCertificado,
            //'fechaHoy' 	        => $fechaHoy,
            'Cliente' 	        => $rscl['Cliente'],
            'Direccion' 	    => $rscl['Direccion'],
            'Contacto' 	        => $rsar['Contacto'],
            'CodCertificado' 	=> $rs['CodCertificado'],
            'Dimension' 	    => $rs['Dimension'],
            'Peso' 	            => $rs['Peso'],
            'CodInforme' 	    => $rsi['CodInforme'],
            'VerInfAm' 	        => $rsi['CodigoVerificacion'],
            'VerInfAr' 	        => $rs['CodigoVerificacion'],
            'idMuestra' 	    => $rsmm['idMuestra'],
            'LOTE' 	            => $rs['Lote'],
            'Producto' 	        => $rspr['Producto'],
            'Acero' 	        => $rsac['Acero'],
            'Inspector' 	    => $Inspector,
            'fechaHoy' 	        => $fechaCertificado,
            'fechaInspeccion' 	=> $fechaInspeccion,
            'RESULTADO' 	    => $resultadoCertificacion,
            )
        );



        
        $data = array(); 
        $bdr=$linkc->query("SELECT * FROM normarefcert Where CodCertificado = '$CodCertificado' Order By nNorma");
        while($rsr=mysqli_fetch_array($bdr)){
            $bdn=$linkc->query("SELECT * FROM normas Where nNorma = '".$rsr['nNorma']."'");
            if($rsn=mysqli_fetch_array($bdn)){
                $Norma = $rsn['Norma'];
                $data[] = $Norma;
            }
        }        
        $docx->replaceListVariable('Referencia',$data);

        $data = array(); 
        $bdr=$linkc->query("SELECT * FROM normaacre Where CodCertificado = '$CodCertificado' Order By nNorma");
        while($rsr=mysqli_fetch_array($bdr)){
            $bdn=$linkc->query("SELECT * FROM normas Where nNorma = '".$rsr['nNorma']."'");
            if($rsn=mysqli_fetch_array($bdn)){
                $NormaAc = $rsn['Norma'];
                $data[] = $NormaAc;
            }
        }        

        $docx->replaceListVariable('Respectivas',$data);

        $data = array(); 
        $bdo=$linkc->query("SELECT * FROM observaciones Where CodCertificado = '$CodCertificado' Order By nObservacion");
        while($rso=mysqli_fetch_array($bdo)){
            $bdobs=$linkc->query("SELECT * FROM observacionescertificados Where nObservacion = '".$rso['nObservacion']."'");
            if($rsobs=mysqli_fetch_array($bdobs)){
                $Obs = $rsobs['Observacion'];
                $data[] = $Obs;
            }
        }        

        $docx->replaceListVariable('Observaciones',$data);

        $paragraphOptions = array(
            'font' 		=> 'Arial',
            'fontSize'	=> 12,
            'textAlign'	=> 'center',
        );

              
        if($rsar['usrInspector'] != 'DPG'){
            $firma = new WordFragment($docx);
            $options = array(
                'src' 			=> '../ft/'.$rsus['firmaUsr'],
                'imageAlign' 	=> 'center',
                'scaling' 		=> 100,
                'spacingTop' 	=> 0,
                'spacingBottom' => 0,
                'spacingLeft' 	=> 0,
                'spacingRight'	=> 0,
                'textWrap' 		=> 0,
            );
            $docx->addImage($options);

            $text = "Firma Inspector";
            $docx->addText($text, $paragraphOptions);
        }
        
        if($rsi['imgQR']){
            $qram = new WordFragment($docx);
            $options = array(
                'src' 			=> '../codigoqr/phpqrcode/temp/'.$rsi['imgQR'],
                'imageAlign' 	=> 'center',
                // 'scaling' 		=> 100,
                'width' 	    => 94,
                'height' 	    => 94,
                'spacingTop' 	=> 0,
                'spacingBottom' => 0,
                'spacingLeft' 	=> 0,
                'spacingRight'	=> 0,
                'textWrap' 		=> 0,
            );
            $docx->addImage($options);

            $text = "QR INFORME".$rsi['CodInforme'];
            $docx->addText($text, $paragraphOptions);

        }

        $qrar = new WordFragment($docx);
        $options = array(
            'src' 			=> '../codigoqr/phpqrcode/temp/'.$CodCertificado.'.png',
            'imageAlign' 	=> 'center',
            // 'scaling' 		=> 50,
            'width' 	    => 94,
            'height' 	    => 94,
            'spacingTop' 	=> 0,
            'spacingBottom' => 0,
            'spacingLeft' 	=> 0,
            'spacingRight'	=> 0,
            'textWrap' 		=> 0,
        );
        $docx->addImage($options);

        $text = "QR CERTIFICADO DE CONFORMIDAD ".$CodCertificado;
        $docx->addText($text, $paragraphOptions);

        

        $informe = 'Certificados/'.$CodCertificado;
        $docx->createDocxAndDownload($informe);

    }

}
$linkc->close();
$link->close();

?>