<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set("America/Santiago");

$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php");  

if($dato->accion == "rescataFacturas"){
    $outp = "";
    $link=Conectarse();  
    $RutCli = '';
    $bdc=$link->query("SELECT * FROM clientes Where Cliente Like '%$dato->Cliente%'");
    if ($rsc=mysqli_fetch_array($bdc)){
        $RutCli = $rsc['RutCli'];
    }

    //$sql = "SELECT * FROM Cotizaciones Where RutCli = '".$RutCli."' and Estado = 'T' and Archivo != 'on' and nSolicitud > 0 Order By Facturacion, Archivo, informeUp, fechaTermino Desc";
    $sql = "SELECT * FROM Cotizaciones Where RutCli = '".$RutCli."' and Estado = 'T' and Archivo != 'on' Order By nSolicitud, Facturacion, Archivo, informeUp, fechaTermino Desc";
    $bd=$link->query($sql);
    while($rs = mysqli_fetch_array($bd)){
        $Saldo = 0;
        $brutoUF = 0;
        $Bruto = 0;
        $Estado = 0;
        $nomContacto = '';
        $sqls = "SELECT * FROM solfactura Where nSolicitud = '".$rs["nSolicitud"]."'";
        $bds=$link->query($sqls);
        if($rss = mysqli_fetch_array($bds)){
            $sqlc = "SELECT * FROM contactoscli Where RutCli = '".$RutCli."' and nContacto = '".$rs["nContacto"]."'";
            $bdc=$link->query($sqlc);
            if($rsc = mysqli_fetch_array($bdc)){
                $nomContacto = $rsc['Contacto'];
            }
            if($dato->Contacto){
                if($dato->Contacto == $nomContacto){
                    $Saldo = $rss['Saldo'];
                    $brutoUF = $rss['brutoUF'];
                    $Bruto = $rss['Bruto'];
                    $Abono = $rss['Abono'];
                    if($Saldo > 0) {$Estado = 'Vigente'; }
                    if($Saldo == 0) {$Estado = 'Cancelado'; }
                    if ($outp != "") {$outp .= ",";}
                    $outp.= '{"RutCli":"'.		    $rs["RutCli"].				'",';
                    $outp.= '"CAM":"'.				$rs["CAM"].					'",';
                    $outp.= '"RAM":"'.				$rs["RAM"].					'",';
                    $outp.= '"Fan":"'.				$rs["Fan"].					'",';
                    $outp.= '"nOC":"'.				$rs["nOC"].					'",';
                    $outp.= '"HES":"'.				$rs["HES"].					'",';
                    $outp.= '"nContacto":"'.		$rs["nContacto"].			'",';
                    $outp.= '"fechaCotizacion":"'.	$rs["fechaCotizacion"].		'",';
                    $outp.= '"nSolicitud":"'.	    $rs["nSolicitud"].		    '",';
                    $outp.= '"nFactura":"'.	        $rs["nFactura"].		    '",';
                    $outp.= '"fechaPago":"'.	    $rss["fechaPago"].		    '",';
                    $outp.= '"infoNumero":"'.	    $rs["infoNumero"].		    '",';
                    $outp.= '"infoSubidos":"'.	    $rs["infoSubidos"].		    '",';
                    $outp.= '"NetoUF":"'.	        $rs["NetoUF"].		        '",';
                    $outp.= '"NetoUF":"'.	        $rs["NetoUF"].		        '",';
                    $outp.= '"Neto":"'.	            $rs["Neto"].		        '",';
                    $outp.= '"Saldo":"'.	        $Saldo.		                '",';
                    $outp.= '"brutoUF":"'.	        $brutoUF.		            '",';
                    $outp.= '"Bruto":"'.	        $Bruto.		                '",';
                    $outp.= '"Estado":"'.	        $Estado.		            '",';
                    $outp.= '"nomContacto":"'.	    $nomContacto.		        '",';
                    $outp.= '"nInforme":"'.			$rs["nInforme"].			'"}';      
                }
            }else{
                $Saldo = $rss['Saldo'];
                $brutoUF = $rss['brutoUF'];
                $Bruto = $rss['Bruto'];
                $Abono = $rss['Abono'];
                if($Saldo > 0) {$Estado = 'Vigente'; }
                if($Saldo == 0) {$Estado = 'Cancelado'; }
                if ($outp != "") {$outp .= ",";}
                $outp.= '{"RutCli":"'.		    $rs["RutCli"].				'",';
                $outp.= '"CAM":"'.				$rs["CAM"].					'",';
                $outp.= '"RAM":"'.				$rs["RAM"].					'",';
                $outp.= '"Fan":"'.				$rs["Fan"].					'",';
                $outp.= '"nOC":"'.				$rs["nOC"].					'",';
                $outp.= '"HES":"'.				$rs["HES"].					'",';
                $outp.= '"nContacto":"'.		$rs["nContacto"].			'",';
                $outp.= '"fechaCotizacion":"'.	$rs["fechaCotizacion"].		'",';
                $outp.= '"nSolicitud":"'.	    $rs["nSolicitud"].		    '",';
                $outp.= '"nFactura":"'.	        $rs["nFactura"].		    '",';
                $outp.= '"fechaPago":"'.	    $rss["fechaPago"].		    '",';
                $outp.= '"infoNumero":"'.	    $rs["infoNumero"].		    '",';
                $outp.= '"infoSubidos":"'.	    $rs["infoSubidos"].		    '",';
                $outp.= '"NetoUF":"'.	        $rs["NetoUF"].		        '",';
                $outp.= '"NetoUF":"'.	        $rs["NetoUF"].		        '",';
                $outp.= '"Neto":"'.	            $rs["Neto"].		        '",';
                $outp.= '"Saldo":"'.	        $Saldo.		                '",';
                $outp.= '"brutoUF":"'.	        $brutoUF.		            '",';
                $outp.= '"Bruto":"'.	        $Bruto.		                '",';
                $outp.= '"Estado":"'.	        $Estado.		            '",';
                $outp.= '"nomContacto":"'.	    $nomContacto.		        '",';
                $outp.= '"nInforme":"'.			$rs["nInforme"].			'"}';    
            }
        }else{
            $sqlc = "SELECT * FROM contactoscli Where RutCli = '".$RutCli."' and nContacto = '".$rs["nContacto"]."'";
            $bdc=$link->query($sqlc);
            if($rsc = mysqli_fetch_array($bdc)){
                $nomContacto = $rsc['Contacto'];
            }
                $Saldo = 0;
                $brutoUF = $rs['BrutoUF'];
                $Bruto = $rs['Bruto'];
                $Abono = 0;
                $Estado = 'SIN OC';
                if ($outp != "") {$outp .= ",";}
                $outp.= '{"RutCli":"'.		    $rs["RutCli"].				'",';
                $outp.= '"CAM":"'.				$rs["CAM"].					'",';
                $outp.= '"RAM":"'.				$rs["RAM"].					'",';
                $outp.= '"Fan":"'.				$rs["Fan"].					'",';
                $outp.= '"nOC":"'.				$rs["nOC"].					'",';
                $outp.= '"HES":"'.				$rs["HES"].					'",';
                $outp.= '"nContacto":"'.		$rs["nContacto"].			'",';
                $outp.= '"fechaCotizacion":"'.	$rs["fechaCotizacion"].		'",';
                $outp.= '"nSolicitud":"'.	    $rs["nSolicitud"].		    '",';
                $outp.= '"nFactura":"'.	        $rs["nFactura"].		    '",';
                //$outp.= '"fechaPago":"'.	    $rss["fechaPago"].		    '",';
                $outp.= '"infoNumero":"'.	    $rs["infoNumero"].		    '",';
                $outp.= '"infoSubidos":"'.	    $rs["infoSubidos"].		    '",';
                $outp.= '"NetoUF":"'.	        $rs["NetoUF"].		        '",';
                $outp.= '"NetoUF":"'.	        $rs["NetoUF"].		        '",';
                $outp.= '"Neto":"'.	            $rs["Neto"].		        '",';
                $outp.= '"Saldo":"'.	        $Saldo.		                '",';
                $outp.= '"brutoUF":"'.	        $brutoUF.		            '",';
                $outp.= '"Bruto":"'.	        $Bruto.		                '",';
                $outp.= '"Estado":"'.	        $Estado.		            '",';
                $outp.= '"nomContacto":"'.	    $nomContacto.		        '",';
                $outp.= '"nInforme":"'.			$rs["nInforme"].			'"}';    
        }
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
    
}


?>