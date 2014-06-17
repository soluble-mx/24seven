
<!--
 24SEVEN SUNGLASSES WEB
 checkout.php
 Resumen de compra

 SolubleMX, diseño y desarrollo.
 Copyright 2014
-->

<?php

	include_once('jcart/jcart.php');

	session_start();

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>24SEVEN sunglasses</title>
		<meta charset="utf-8">

		<!-- ICON -->
		<link rel="shortcut icon" href="images/lentes24seven.ico" type="image/x-icon" />

		<!-- DESCRIPTIONS -->
		
		<!-- for Google -->
		<meta name="description" content="Lentes de sol originales con gran diseño y calidad, diseñadas en España. Diferénciate y reivindica tu estilo. 24seven Sunglasses, Why not?">
		<meta name="keywords" content="lentes sol, 24seven, lentes 24seven, lentes baratos, lentes colores, lentes polarizados, lentes espejo, lentes retro, lentes moda, lentes hipster">
		
		<!-- for Facebook -->
		<meta property="og:title" content="24SEVEN sunglasses" />
		<meta property="og:type" content="article" />
		<meta property="og:url" content="http://www.lentes24seven.com.mx/#intro" />
		<meta property="og:description" content="Lentes de sol originales con gran diseño y calidad, diseñadas en España. Diferénciate y reivindica tu estilo. 24seven Sunglasses, Why not?" />

		<!-- for Twitter -->
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:title" content="24SEVEN sunglasses" />
		<meta name="twitter:description" content="Lentes de sol originales con gran diseño y calidad, diseñadas en España. Diferénciate y reivindica tu estilo. 24seven Sunglasses, Why not?" />

		<!-- STYLESHEETS -->
		<!-- import fonts -->
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Oxygen+Mono">
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Alegreya+Sans:100,300,400,500,900,300italic%27%20rel=%27stylesheet">
		<link rel="stylesheet" type="text/css" href='http://fonts.googleapis.com/css?family=Source+Code+Pro:200,400,500'>
		<link rel="stylesheet" type="text/css" href='http://fonts.googleapis.com/css?family=Carrois+Gothic+SC'>
		<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">

		<link rel="stylesheet" type="text/css" href="css/reset.css">
		<link rel="stylesheet" type="text/css" href="css/seven.css">
		<link rel="stylesheet" type="text/css" media="screen, projection" href="jcart/css/jcart.css">

	</head>
	<body>

		<!-- PAGINA COMPLETA -->
		<div id="pagina_completa"><!-- Inicia pagina_completa -->

			<!-- BLOQUE SUPERIOR -->
			<header id="bloque_superior"><!-- Inicia bloque superior -->
				<img id="intro" class="intro cargaHTML" src="images/logo.png" archivo="intro.html" altura="664" funcion="setIntro()" />

				<div id="social_network">
					<img class="facebook" src="images/iconos_redes/facebook.png" />
					<img class="twitter" src="images/iconos_redes/twitter.png" />
					<img class="tumblr" src="images/iconos_redes/tumblr.png" />
					<a href="https://plus.google.com/+Lentes24seven" rel="publisher"><img class="googlemas" src="images/iconos_redes/google.png" /></a>
					<img class="pinterest" src="images/iconos_redes/pinterest.png" />
					<img class="instagram" src="images/iconos_redes/instagram.png" />
				</div>

			</header>

			<!-- BLOQUE INTERMEDIO -->
			<section id="bloque_intermedio" align="center" style="height: auto; margin-top: -130px;">
				<div id="jcart" align="left" style="width: 100%;"><?php $jcart->display_cart();?></div>

				<?php
					//echo '<pre>';
					//var_dump($_SESSION['seven_cart']);
					//echo '</pre>';
				?>
			</section>

			<!-- BLOQUE INFERIOR -->
			<footer id="bloque_inferior"><!-- Inicia bloque inferior -->
				
				<div id="social_network_inferior">
					<div id="siguenos">Síguenos...</div>
					<br>

					<img class="facebook" src="images/iconos_redes/facebook.png" />
					<img class="twitter" src="images/iconos_redes/twitter.png" />
					<img class="tumblr" src="images/iconos_redes/tumblr.png" />

					<br>
					<img class="googlemas" src="images/iconos_redes/google.png" />
					<img class="pinterest" src="images/iconos_redes/pinterest.png" />
					<img class="instagram" src="images/iconos_redes/instagram.png" />
				</div>

				<div id="logo_inferior">
					<img class="intro carga_contenido" src="images/logo_24_seven_inferior.png" />
				</div>

				<div id="menu_inferior" >
					<div id="atm">
						<div id="atencion_al_cliente">ATENCIÓN AL CLIENTE</div>
						<h3 id="contacto" class="cargaHTML" archivo="contacto.html" altura="404" >Contacto</h3>
						<h3 id="estandar_calidad_mdebajo" class="cargaHTML"	archivo="estandar_de_calidad.html" altura="607" >Est&aacute;ndar de calidad</h3>
					</div>

					<div id="sobre_veinticuatro">
						<div id="veinticuatro_seven_acerca">24 SEVEN</div>
						<h3 id="veinticuatro_seven">24/7</h3>
						<h3 id="showroom" class="showroom" >Showroom</h3>
					</div>

					<div id="compra">
						<div id="compra_text">COMPRA</div>
						<h3 id="pasos_y_pago" class="cargaHTML" archivo="pagos_envios.html" altura="804" >Pasos de pago <br/>y envío</h3>
					</div>

					<div id="condiciones_legales">
						<div id="condiciones_legales_text">CONDICIONES LEGALES</div>
						<h3 id="aviso_legal" class="cargaHTML" archivo="aviso_legal.html" altura="1384" >Aviso legal</h3>
					</div>

					<div id="colecciones">
						<div id="colecciones_text">COLECCIONES</div>
						<h3 id="reloj_de_sol" class="cargaHTML" archivo="reloj_de_sol.html" altura="300" >Reloj de sol</h3>
					</div>	
				</div>

				<div id="copyright">© 2014 SG LENTES INTERNACIONAL, S.L.</div>
			</footer><!-- Termina bloque inferior -->

		</div>
	</body>
</html>