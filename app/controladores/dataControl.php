<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("conexionli.php");

if($dato->accion == 'loadProveedores'){
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM proveedores Order By Proveedor";
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
		$outp .= '{"RutProv":"'             . $rs["RutProv"]. 				    '",';
        $outp .= '"Proveedor":"'            . $rs["Proveedor"]. 				'",';
        $outp .= '"Contacto":"'             . $rs["Contacto"]. 				    '",';
        $outp .= '"productoServicio":"'     . $rs["productoServicio"]. 		    '",';
        $outp .= '"tpDocumentoEmite":"'     . $rs["tpDocumentoEmite"]. 		    '",';
	    $outp .= '"Telefono":"'             . $rs["Telefono"]. 			        '"}';    
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}

if($dato->accion == 'loadUnidadMedida'){
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM unidadmedida Order By nUnidad";
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
		$outp .= '{"nUnidad":"'             . $rs["nUnidad"]. 				    '",';
        $outp .= '"idUnidad":"'             . $rs["idUnidad"]. 				    '",';
	    $outp .= '"Unidad":"'               . $rs["Unidad"]. 			        '"}';    
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}

if($dato->accion == 'loadInventario'){
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM articulos Order By nArticulo";
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        $Dependencia = '';
        $SQLd = "SELECT * FROM dependencias Where nDependencia = '".$rs['idDependencia']."'";
        $bdd=$link->query($SQLd);
        while($rsd=mysqli_fetch_array($bdd)){
            $Dependencia = $rsd['Dependencia'];
        }
        if ($outp != "") {$outp .= ",";}
		$outp .= '{"nArticulo":"'                       . $rs["nArticulo"]. 				    '",';
		$outp .= '"nItem":"'                            . $rs["nItem"]. 				        '",';
		$outp .= '"idDependencia":"'                    . $rs["idDependencia"]. 		        '",';
		$outp .= '"Dependencia":"'                      . $Dependencia. 		                '",';
		$outp .= '"Articulo":"'                         . $rs["Articulo"]. 				        '",';
		$outp .= '"Serial":"'                           . $rs["Serial"]. 		                '",';
		$outp .= '"idUnidad":"'                         . $rs["idUnidad"]. 		                '",';
		$outp .= '"cantidadXUnidad":"'                  . $rs["cantidadXUnidad"]. 		        '",';
		$outp .= '"nUnidades":"'                        . $rs["nUnidades"]. 		            '",';
		$outp .= '"Stock":"'                            . $rs["Stock"]. 		                '",';
		$outp .= '"Salida":"'                           . $rs["Salida"]. 		                '",';
		$outp .= '"stockActual":"'                      . $rs["stockActual"]. 		            '",';
	    $outp .= '"stockCritico":"'                     . $rs["stockCritico"]. 			        '"}';    
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}


if($dato->accion == 'loadClasificacion'){
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM itemsinventario Order By nItem";
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
		$outp .= '{"nItem":"'               . $rs["nItem"]. 				    '",';
	    $outp .= '"Items":"'                . $rs["Items"]. 			        '"}';    
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}


if($dato->accion == 'cargarDependencias'){ 
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM Dependencias Order By nDependencia";
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
		$outp .= '{"nDependencia":"'        . $rs["nDependencia"]. 				'",';
        $outp .= '"Dependencia":"'          . $rs["Dependencia"]. 				'",';
	    $outp .= '"usrResponsable":"'       . $rs["usrResponsable"]. 			'"}';    
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}

if($dato->accion == 'grabarArticulo'){
    $link=Conectarse();
    $SQL = "SELECT * FROM articulos Where nArticulo = '$dato->nArticulo'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $actSQL="UPDATE articulos SET ";
        $actSQL.="Articulo	            ='".$dato->Articulo.	    "',";
        $actSQL.="Serial                ='".$dato->Serial.	        "',";
        $actSQL.="nItem                 ='".$dato->nItem.           "',";
        $actSQL.="idDependencia         ='".$dato->idDependencia.   "',";
        $actSQL.="idUnidad              ='".$dato->idUnidad.	    "',";
        $actSQL.="cantidadXUnidad       ='".$dato->cantidadXUnidad.	"',";
        $actSQL.="nUnidades             ='".$dato->nUnidades.	    "',";
        $actSQL.="stockCritico	        ='".$dato->stockCritico.	"'";
        $actSQL.="WHERE nArticulo	    = '$dato->nArticulo'";
        $bdCot=$link->query($actSQL);
    }else{
        $link->query("insert into articulos(	nArticulo,
                                                Articulo,
                                                Serial,
                                                nItem,
                                                idDependencia,
                                                idUnidad,
                                                cantidadXUnidad,
                                                nUnidades,
                                                stockCritico
                                            ) 
                                    values 	(	'$dato->nArticulo',
                                                '$dato->Articulo',
                                                '$dato->Serial',
                                                '$dato->nItem',
                                                '$dato->idDependencia',
                                                '$dato->idUnidad',
                                                '$dato->cantidadXUnidad',
                                                '$dato->nUnidades',
                                                '$dato->stockCritico'
        )");
    }

    $link->close();
}

if($dato->accion == 'grabarProveedor'){
    $link=Conectarse();
    $SQL = "SELECT * FROM proveedores Where RutProv = '$dato->RutProv'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $actSQL="UPDATE proveedores SET ";
        $actSQL.="Proveedor	            ='".$dato->Proveedor.	    "',";
        $actSQL.="Direccion             ='".$dato->Direccion.	    "',";
        $actSQL.="productoServicio      ='".$dato->productoServicio."',";
        $actSQL.="tpDocumentoEmite      ='".$dato->tpDocumentoEmite."',";
        $actSQL.="Contacto              ='".$dato->Contacto.	    "',";
        $actSQL.="Telefono              ='".$dato->Telefono.	    "',";
        $actSQL.="Celular               ='".$dato->Celular.	        "',";
        $actSQL.="Email                 ='".$dato->Email.	        "',";
        $actSQL.="TpCta                 ='".$dato->TpCta.	        "',";
        $actSQL.="NumCta                ='".$dato->NumCta.	        "',";
        $actSQL.="stockCritico	                ='".$dato->Banco.	        "'";
        $actSQL.="WHERE RutProv	= '$dato->RutProv'";
        $bdCot=$link->query($actSQL);
    }else{
        $link->query("insert into proveedores(	RutProv,
                                                Proveedor,
                                                productoServicio,
                                                tpDocumentoEmite,
                                                Direccion,
                                                Contacto,
                                                Telefono,
                                                Celular,
                                                Email,
                                                TpCta,
                                                NumCta,
                                                Banco
                                            ) 
                                    values 	(	'$dato->RutProv',
                                                '$dato->Proveedor',
                                                '$dato->productoServicio',
                                                '$dato->tpDocumentoEmite',
                                                '$dato->Direccion',
                                                '$dato->Contacto',
                                                '$dato->Telefono',
                                                '$dato->Celular',
                                                '$dato->Email',
                                                '$dato->TpCta',
                                                '$dato->NumCta',
                                                '$dato->usrResponsable'
        )");
    }

    $link->close();
}

if($dato->accion == 'grabarClasificacion'){
    $link=Conectarse();
    $SQL = "SELECT * FROM itemsinventario Where nItem = '$dato->nItem'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $actSQL="UPDATE itemsinventario SET ";
        $actSQL.="nItem	            = '".$dato->nItem.	        "',";
        $actSQL.="Items	            = '".$dato->Items.	        "'";
        $actSQL.="WHERE nItem	    = '$dato->nItem'";
        $bdCot=$link->query($actSQL);
    }else{
        $link->query("insert into itemsinventario(	nItem,
                                                    Items
                                            ) 
                                    values 	(	'$dato->nItem',
                                                '$dato->Items'
        )");
    }

    $link->close();
}

if($dato->accion == 'grabarUnidadMedida'){
    $link=Conectarse();
    $SQL = "SELECT * FROM unidadmedida Where nUnidad = '$dato->nUnidad'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $actSQL="UPDATE unidadmedida SET ";
        $actSQL.="nUnidad	        ='".$dato->nUnidad.	        "',";
        $actSQL.="idUnidad          ='".$dato->idUnidad.	    "',";
        $actSQL.="Unidad	        ='".$dato->Unidad.	        "'";
        $actSQL.="WHERE nUnidad	= '$dato->nUnidad'";
        $bdCot=$link->query($actSQL);
    }else{
        $link->query("insert into unidadmedida(	nUnidad,
                                                idUnidad,
                                                Unidad
                                            ) 
                                    values 	(	'$dato->nUnidad',
                                                '$dato->idUnidad',
                                                '$dato->Unidad'
        )");
    }

    $link->close();
}

if($dato->accion == 'grabarDependencia'){
    $link=Conectarse();
    $SQL = "SELECT * FROM Dependencias Where nDependencia = '$dato->nDependencia'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $actSQL="UPDATE Dependencias SET ";
        $actSQL.="nDependencia	        ='".$dato->nDependencia.	"',";
        $actSQL.="Dependencia           ='".$dato->Dependencia.	    "',";
        $actSQL.="usrResponsable	    ='".$dato->usrResponsable.	"'";
        $actSQL.="WHERE nDependencia	= '$dato->nDependencia'";
        $bdCot=$link->query($actSQL);
    }else{
        $link->query("insert into Dependencias(	nDependencia,
                                                Dependencia,
                                                usrResponsable
                                            ) 
                                    values 	(	'$dato->nDependencia',
                                                '$dato->Dependencia',
                                                '$dato->usrResponsable'
        )");
    }

    $link->close();
}

if($dato->accion == 'editarInventario'){
    $res = '';
    
    $link=Conectarse();
    $SQL = "SELECT * FROM articulos Where nArticulo = '$dato->nArticulo'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $res.= '{"Articulo":"'           .	$rs['Articulo']         .   '",';
        $res.= '"nArticulo":"'          .	$rs['nArticulo']        .   '",';
        $res.= '"nItem":"'              .	$rs['nItem']            .   '",';
        $res.= '"idDependencia":"'      .	$rs['idDependencia']    .   '",';
        $res.= '"Serial":"'             .	$rs['Serial']           .   '",';
        $res.= '"idUnidad":"'           .	$rs['idUnidad']         .   '",';
        $res.= '"cantidadXUnidad":"'    .	$rs['cantidadXUnidad']  .   '",';
        $res.= '"nUnidades":"'          .	$rs['nUnidades']        .   '",';
        $res.= '"Stock":"'              .	$rs['Stock']            .   '",';
        $res.= '"Salida":"'             .	$rs['Salida']           .   '",';
        $res.= '"stockActual":"'        .	$rs['stockActual']      .   '",';
        $res.= '"stockCritico":"'       .	$rs['stockCritico']     .   '"}';
    }

    $link->close();
    echo $res;

}

if($dato->accion == 'editarProveedor'){
    $res = '';
    
    $link=Conectarse();
    $SQL = "SELECT * FROM proveedores Where RutProv = '$dato->RutProv'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $res.= '{"RutProv":"'           .	$rs['RutProv']          .   '",';
        $res.= '"Proveedor":"'          .	$rs['Proveedor']        .   '",';
        $res.= '"productoServicio":"'   .	$rs['productoServicio'] .   '",';
        $res.= '"tpDocumentoEmite":"'   .	$rs['tpDocumentoEmite'] .   '",';
        $res.= '"Direccion":"'          .	$rs['Direccion']        .   '",';
        $res.= '"Contacto":"'           .	$rs['Contacto']         .   '",';
        $res.= '"Telefono":"'           .	$rs['Telefono']         .   '",';
        $res.= '"Celular":"'            .	$rs['Celular']          .   '",';
        $res.= '"Email":"'              .	$rs['Email']            .   '",';
        $res.= '"TpCta":"'              .	$rs['TpCta']            .   '",';
        $res.= '"NumCta":"'             .	$rs['NumCta']           .   '",';
        $res.= '"Banco":"'              .	$rs['Banco']            .   '"}';
    }

    $link->close();
    echo $res;

}

if($dato->accion == 'editarDependencia'){
    $res = '';
    
    $link=Conectarse();
    $SQL = "SELECT * FROM Dependencias Where nDependencia = '$dato->nDependencia'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $res.= '{"nDependencia":"'      .	$rs['nDependencia'].	'",';
        $res.= '"Dependencia":"'        .	$rs['Dependencia'].	    '",';
        $res.= '"usrResponsable":"'     .	$rs['usrResponsable'].	'"}';
    }

    $link->close();
    echo $res;

}

if($dato->accion == 'editarUnidadMedida'){
    $res = '';
    
    $link=Conectarse();
    $SQL = "SELECT * FROM unidadmedida Where nUnidad = '$dato->nUnidad'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $res.= '{"nUnidad":"'           .	$rs['nUnidad'].	        '",';
        $res.= '"idUnidad":"'           .	$rs['idUnidad'].	    '",';
        $res.= '"Unidad":"'             .	$rs['Unidad'].	        '"}';
    }

    $link->close();
    echo $res;

}

if($dato->accion == 'editarClasificacion'){
    $res = '';
    
    $link=Conectarse();
    $SQL = "SELECT * FROM itemsinventario Where nItem = '$dato->nItem'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $res.= '{"nItem":"'             .	$rs['nItem'].	        '",';
        $res.= '"Items":"'              .	$rs['Items'].	        '"}';
    }

    $link->close();
    echo $res;

}

if($dato->accion == 'agregarArticulo'){
    $res = '';
    $nArticulo = 0;
    $link=Conectarse();
    $SQL = "SELECT * FROM articulos Order By nArticulo Desc"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $nArticulo = $rs['nArticulo'] + 1; 
        $res.= '{"nArticulo":"' .	$nArticulo.	'"}';
    }else{
        $nArticulo = 1; 
        $res.= '{"nArticulo":"' .	$nArticulo.	'"}';
    }

    $link->close();
    echo $res;

}

if($dato->accion == 'agregarUnidadMedida'){
    $res = '';
    $nUnidad = 0;
    $link=Conectarse();
    $SQL = "SELECT * FROM unidadmedida Order By nUnidad Desc"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $nUnidad = $rs['nUnidad'] + 1; 
        $res.= '{"nUnidad":"' .	$nUnidad.	'"}';
    }else{
        $nUnidad = 1; 
        $res.= '{"nUnidad":"' .	$nUnidad.	'"}';
    }

    $link->close();
    echo $res;

}

if($dato->accion == 'agregarClasificacion'){
    $res = '';
    $nUnidad = 0;
    $link=Conectarse();
    $SQL = "SELECT * FROM itemsinventario Order By nItem Desc"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $nItem = $rs['nItem'] + 1; 
        $res.= '{"nItem":"' .	$nItem.	'"}';
    }else{
        $nItem = 1; 
        $res.= '{"nItem":"' .	$nItem.	'"}';
    }

    $link->close();
    echo $res;

}

if($dato->accion == 'agregarDependencia'){
    $res = '';
    
    $link=Conectarse();
    $SQL = "SELECT * FROM Dependencias Order By nDependencia Desc"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $nDependencia = $rs['nDependencia'] + 1; 
        $res.= '{"nDependencia":"' .	$nDependencia.	'"}';
    }else{
        $nDependencia = 1; 
        $res.= '{"nDependencia":"' .	$nDependencia.	'"}';
    }

    $link->close();
    echo $res;

}


?>