
<!--
 24SEVEN SUNGLASSES WEB
 index.php
 La pagina principal

 SolubleMX, diseño y desarrollo.
 Copyright 2014
-->

<?php
	include_once('jcart/jcart.php');
	require_once('Mobile_Detect.php');

	$detect = new Mobile_Detect;
	if ( $detect->isMobile() ) {
		header("Location: http://www.mobile.lentes24seven.com.mx/");
		die();
	} else {
		session_start();
	}

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

		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/24seven_logo_b.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/24seven_logo_n.jpg">
		
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunrise_1_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunrise_2_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunrise_3_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunrise_4_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunrise_5_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunrise_1_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunrise_2_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunrise_3_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunrise_4_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunrise_5_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/noon_1_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/noon_2_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/noon_3_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/noon_4_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/noon_5_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/noon_6_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/noon_7_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/noon_8_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/noon_9_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/noon_10_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/noon_11_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/noon_12_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/noon_13_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunset_1_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunset_2_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunset_3_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunset_4_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunset_5_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunset_6_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunset_7_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/sunset_8_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/dusk_1_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/dusk_2_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/dusk_3_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/dusk_4_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/dusk_5_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/dusk_6_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/dusk_7_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/dusk_8_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/night_1_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/night_2_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/night_3_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/night_4_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/night_5_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/night_6_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/night_7_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/night_8_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/dawn_1_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/dawn_2_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/dawn_3_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/dawn_4_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/dawn_5_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/dawn_6_f.jpg">
		<meta property="og:image" content="http://www.lentes24seven.com.mx/images/fotos/noon_14_f.jpg">
		<meta property="og:image:type" content="image/jpg" />

		<meta property="og:type" content="article" />
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

		<!-- JAVASCRIPT -->
		<script type="text/javascript" src="js/jquery-1.8.1.min.js" ></script>
		<script type="text/javascript" src="js/jquery.address-1.5.js?strict=false&wrap=true"></script>
		<script type="text/javascript" src="js/jquery.timer.js"></script>

		<script type="text/javascript" src="jcart/js/jcart.js"></script>
		<script type="text/javascript" src="js/modelo.js"></script>
		<script type="text/javascript" src="js/seven.js"></script>
	</head>

	<body>

		<!-- FACEBOOK ROOT -->
		<div id="fb-root"></div>

		<div id="jcart_bkg" align="center">
			<div id="jcart" align="left"></div>
		</div>

		<!-- PAGINA COMPLETA -->
		<div id="pagina_completa"><!-- Inicia pagina_completa -->

			<!-- BLOQUE SUPERIOR -->
			<header id="bloque_superior"><!-- Inicia bloque superior -->
				<img id="intro" class="intro cargaHTML" src="images/logo.png" archivo="intro.html" altura="664" funcion="setIntro()" />

				<nav id="menu_superior">
					<span id="carrito">CARRITO</span>
					<span id="acerca_de">ACERCA DE</span>
					<div id="linea2" ></div>
				</nav>

				<nav id="menu_terciario">
					<div id="showroom_superior" class="abreURL showroom" direccion="http://lentes24seven.tumblr.com/" >showroom</div>
					<div id="prensa" class="cargaHTML" archivo="prensa.html" altura="520" >prensa</div>
					<div id="forma_ideal" class="cargaHTML" archivo="forma_ideal.html" altura="884" >forma ideal</div>
				</nav>

				<nav id="menu_principal">

					<h1 id="sunglasses" class="mp_modelos cargaHTML" archivo="mosaico_sunglasses.html" altura="3600" >SUNGLASSES</h1>
					<div id="lv1"></div>
					<h2 id="sunrise" class="mp_modelos cargaHTML" archivo="mosaico_sunrise.html" altura="780" alt="Lentes de sol aviator" >SUNRISE</h2>
					<div id="lv2"></div>
					<h2 id="noon" class="mp_modelos cargaHTML" archivo="mosaico_noon.html" altura="928" >NOON</h2>
					<div id="lv3"></div>
					<h2 id="sunset" class="mp_modelos cargaHTML" archivo="mosaico_sunset.html" altura="534" >SUNSET</h2>
					<div id="lv4"></div>
					<h2 id="dusk" class="mp_modelos cargaHTML" archivo="mosaico_dusk.html" altura="534" >DUSK</h2>
					<div id="lv5"></div>
					<h2 id="night" class="mp_modelos cargaHTML" archivo="mosaico_night.html" altura="534" >NIGHT</h2>
					<div id="lv6"></div>
					<h2 id="dawn" class="mp_modelos cargaHTML" archivo="mosaico_dawn.html" altura="534" >DAWN</h2>
				</nav>

				<div id="social_network">
					<img class="facebook" src="images/iconos_redes/facebook.png" />
					<img class="twitter" src="images/iconos_redes/twitter.png" />
					<img class="tumblr" src="images/iconos_redes/tumblr.png" />
					<a href="https://plus.google.com/+Lentes24seven" rel="publisher"><img class="googlemas" src="images/iconos_redes/google.png" /></a>
					<img class="pinterest" src="images/iconos_redes/pinterest.png" />
					<img class="instagram" src="images/iconos_redes/instagram.png" />
				</div>
			</header><!-- Acaba bloque superior -->

			<!-- BLOQUE INTERMEDIO -->
			<section id="bloque_intermedio"></section>

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
						<h3 id="pasos_y_pago" class="cargaHTML" archivo="pagos_envios.html" altura="900" >Pasos de pago <br/>y envío</h3>
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

		</div><!-- Termina pagina_completa -->

	</body>
</html>
