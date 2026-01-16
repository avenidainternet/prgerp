<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>

<link href="styles.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<style type="text/css">
<!--
body {
	
	margin-top: 0px;
	margin-bottom: 0px;
	background: url(../gastos/imagenes/Usac.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	max-width:100%;
	width:100%;
	margin-left:auto;
	margin-right:auto;	

	
}
-->
</style>

</head>

<body>
	<?php include('head.php'); ?>
    <div id="icons1">
		<div class="icons img">
			<div id="icons">
    			<a href="URL AL DAR CLICK" target="_self">
					<img src="../gastos/imagenes/room_32.png" border="0" width="20" height="20"><small>Texto al pasar el mouse por arriba </small></a>
    			<a href="URL AL DAR CLICK" target="_self">
					<img src="URL DE LA IMAGEN" border="0">
					<small>Texto al pasar el mouse por arriba </small>
				</a>
    			<a href="URL AL DAR CLICK" target="_self"><img src="URL DE LA IMAGEN" border="0"><small>Texto al pasar el mouse por arriba </small></a>
    			<a href="URL AL DAR CLICK" target="_self"><img src="URL DE LA IMAGEN" border="0"><small>Texto al pasar el mouse por arriba </small></a>
    		</div>
		</div>
	</div>
	
	
	<div id="linea"></div>
	<div id="Cuerpo">
		<?php //include('menulateral.php'); ?>
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/room_32.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Módulo de Sueldos
				</strong>
				<?php include('barramenu.php'); ?>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../gastos/plataformaintranet.php" title="Módulo Gastos">
						<img src="../gastos/imagenes/group_48.png" width="28" height="28">
					</a>
				</div>
			</div>
		</div>
		<div style="clear:both;"></div>

<div style="position: absolute; top: 7; left: 98; width: 748; height: 11">
<h3 align="center"><font color="#DFB6DA">tuto de efecto sombra</font></h3>
</div>
<div style="position: absolute; top: 6; left: 94; width: 748; height: 25">
<h3 align="center"><font color="#FE01DC">tuto de efecto sombra</font></h3>
</div>

<p style="FILTER: alpha(finishopacity=0, style=1); WIDTH: 120px; COLOR:#040"
align="middle" width="120">Texto de ejemplo 1</p>

<style type="text/css">

.picshow { z-index:444; position:relative; background-color:#ffffff; width: 100%; height: 135px}

.picshow_main { position: relative; width: 180px; height: 135px}

.picshow_main .imgbig { filter: progid:dximagetransform.microsoft.wipe(gradientsize=1.0,wipestyle=4, motion=forward); width: 180px; height: 135px}

.picshow_change {position: absolute; text-align: left; bottom: 0px; height: 30px; right: 0px; left: 100px;}

.picshow_change img {width:15px; height: 15px}

.picshow_change a { border: 1px solid; display: block; float: left; margin-right: 5px; -display: inline}

a.axx { border-color: #555}

a.axx:hover {border-color: #000}

a.axx img { filter: alpha(opacity=40); opacity: 0.4; -moz-opacity: 0.4}

a.axx:hover img {filter: alpha(opacity=100); opacity: 1.0; -moz-opacity: 1.0}

a.bxx { border-color: #000}

a.bxx:hover {border-color: #000}

img{

border:0px}

</style>

<SCRIPT language=javascript>

var counts = 3;

img1 = new Image();

img1.src = '../gastos/imagenes/group_48.png';

img2 = new Image();

img2.src = 'http://blogs.ideal.es/abocajarro/files/2011/09/alaya2.jpg';

img3 = new Image();

img3.src = 'http://URL DE LA 3RA IMAGEN.jpg';



var smallImg = new Array();

smallImg[0] = 'http://i60.servimg.com/u/f60/12/10/25/45/index_10.gif';

smallImg[1] = 'http://i60.servimg.com/u/f60/12/10/25/45/index_11.gif';

smallImg[2] = 'http://i60.servimg.com/u/f60/12/10/25/45/index_12.gif';



url1 = 'http://URL DEL TEMA 1';

url2 = 'http://URL DEL TEMA 2';

url3 = 'http://URL DEL TEMA 3';



alt1 = new Image();

alt1.alt = 'TITULO DEL TEMA 1';

alt2 = new Image();

alt2.alt = 'TITULO DEL TEMA 2';

alt3 = new Image();

alt3.alt = 'TITULO DEL TEMA 3';

var nn = 1;

var key = 0;

function change_img() {

if (key == 0) {

key = 1;

} else if (document.all) {

document.getElementById("pic").filters[0].Apply();

document.getElementById("pic").filters[0].Play(duration = 2);

}

eval('document.getElementById("pic").src=img' + nn + '.src');

eval('document.getElementById("url_theme").href=url' + nn);

eval('document.getElementById("pic").alt=alt' + nn + '.alt');

if (nn == 1) {

document.getElementById("url_theme").target = "_blank";

document.getElementById("url_theme").style.cursor = "pointer";

} else {

document.getElementById("url_theme").target = "_blank"

document.getElementById("url_theme").style.cursor = "pointer"

}



for ( var i = 1; i <= counts; i++) {

document.getElementById("xxjdjj" + i).className = 'axx';

}

document.getElementById("xxjdjj" + nn).className = 'bxx';

nn++;

if (nn > counts) {

nn = 1;

}

tt = setTimeout('change_img()', 7000);

}

function changeimg(n) {

nn = n;

window.clearInterval(tt);

change_img();

}

function ImageShow() {

document.write('<div class="picshow_main">');

document.write('<div><a id="url_theme"><img id="pic" class="imgbig" /></a></div>');

document.write('<div class="picshow_change">');

for ( var i = 0; i < counts; i++) {

document.write('<a href="javascript:changeimg(' + (i + 1)

+ ');" id="xxjdjj' + (i + 1)

+ '" class="axx" target="_self"><img src="' + smallImg[i]

+ '"></a>');

}

document.write('</div></div>');

change_img();

}

</SCRIPT>

<SCRIPT language="javascript" type="text/javascript">

ImageShow();

</SCRIPT>



		<div style="margin:10px;">
			<iframe scrolling="no" frameborder="0" marginheight="0" src="resumensueldos.php" width="264" height="245"></iframe>
		</div>

    <br><br><span class="zonadesc"> <img src="http://url de la imagen.png" align="left" style="padding-right: 4px;"> <div style="height:90px; overflow: auto; padding-left: 10px; border-left: 10px solid #B404AE;">

    <BR>TEXTO
    </div></span>

    <form action="/login.forum" method="post"><table cellspacing="1" cellpadding="3" border="0"><tbody><tr><td width="45%" align="right"> Usuario:</td><td><input type="text" name="username" size="25" maxlength="40" /></td></tr><tr><td align="right">Contraseña:</td><td><input type="password" name="password" size="25" maxlength="32" /></td></tr><tr align="center"><td colspan="2">Entrar automaticamente en cada visita: <input type="checkbox" name="autologin" checked="true" /></td></tr><tr align="center"><td colspan="2"><input type="submit" class="mainoption" name="login" value="Log in" /></td></tr></tbody></table></form>	

    <div id="leyend0"><div id="grupos1">
    <h8>
    <span style="color: #código color;">Titulo</span>
    </h8><div class="descript02">
    Texto
    </div>
    </div><div id="grupos1">
    <h8>
    <span style="#código color;">Titulo</span>
    </h8><div class="descript02">
    Texto
    </div>
    </div><div id="grupos1">
    <h8>
    <span style="color: #código color;">Titulo</span>
    </h8><div class="descript02">
    Texto
    </div>
    </div><div id="grupos1">
    <h8>
    <span style="color: #código color;">Titulo</span>
    </h8><div class="descript02">
    Texto
    </div>
    </div>
    </div></div>	

				
	</div>
	<br>
	
	
</body>
</html>
