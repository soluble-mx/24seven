
/****************************************
 * 24SEVEN SUNGLASSES WEB
 * seven.js
 * Controlador principal del
 * client-side.
 *
 * SolubleMX, diseño y desarrollo.
 * Copyright 2014
 ***************************************/

// VARIABLES GLOBALES

// Slider de fotos
var animacionSliderTimer = undefined;
var index_foto = 0;

// Modelo
var indexModelo = -1;

// Total de imagenes en el intro
var totalImagenesIntro = 6;

// Configuracion del carrito
var config = undefined;

/**
 * configuraHashtags:
 *   Configura el direccionamiento y carga de las secciones
 *  de la página con JQueryAddress basado en hashtags.
 *
 */
function configuraHashtags() {

	$.address.wrap( true );
	$.address.change( function( event ) {
		// Si no tiene valor es porque es de la introduccion
		if ( event.value == "" ) {
			$.address.value( "intro" );
		}

		// Obtenemos los parametros necesarios para cargar contenido
		var id = "#" + event.value;
		var archivoHTML = $( id ).attr( "archivo" );
		var altura = parseInt( $( id ).attr( "altura" ) );

		// Dependiendo del valor redireccionamos
		if ( event.value == "intro" ) {
			cargarContenidoIntro( archivoHTML, altura );

		} else if ( event.value == "sunglasses" || event.value == "sunrise" ||
					event.value == "noon"       || event.value == "sunset"  ||
					event.value == "dusk"       || event.value == "night"   ||
					event.value == "dawn" ) {
			cargarContenidoMosaico( archivoHTML, altura );

		} else if( parseInt( event.value ) > 0 ) {
			indexModelo = event.value;
			cargarContenidoModelo( "modelo.html", 640, event.value );

		} else {
			cargarContenido(archivoHTML, altura);

		}

		// Carrito
		$("#jcart_bkg").css({"height" : $("#pagina_completa").height()  + "px"});
		$("#jcart").hide();
		$("#jcart").html("");
		$("#jcart_bkg").hide();
	});

}

/**
 * setIntro:
 *   Configura todo lo necesario en la pantalla de inicio.
 */
function setIntro() {

	// Inicializa el timer del slider de fotos
	animacionSliderTimer = $.timer( function() {
		index_foto += 1;
		if (index_foto == 6) {
			index_foto = 0;
			$( "#tira_fotos" ).animate({
				left: "0px",
			}, 500, function() {});

		} else {
			$( "#tira_fotos" ).animate({
				left: "-=800",
			}, 500, function() {});
		}

		resetIconosIntro();
		$( ".icono_intro" ).eq( index_foto ).attr( "src", "images/icono_reloj_solar/" + $( ".icono_intro" ).eq( index_foto ).attr( "on" ) );
	}, 3000, true);

	// Posicionamos a las imagenes
	for( var i = 0; i < totalImagenesIntro; i++ ) {
		var posleft = (i * 800);
		$( "#tira_fotos img" ).eq( i ).css( "left", posleft + "px" );
	}

	// Hover sobre las flechas
	$( "#flecha_izquierda, #tira_fotos, #flecha_derecha" ).hover( function() {
		animacionSliderTimer.pause();
	}, function() {
		animacionSliderTimer.play( true );
	});

	// Click flecha izquierda
	$( "#flecha_izquierda" ).click( function() {
		if ( index_foto > 0 ) {
			index_foto -= 1;
			
			resetIconosIntro();
			$(".icono_intro").eq( index_foto ).attr( "src", "images/icono_reloj_solar/" + $( ".icono_intro" ).eq( index_foto ).attr( "on" ) );

			$( "#tira_fotos" ).animate({
			   left: "+=800",
			}, 500, function() {});

		} else if( index_foto == 0 ) {
			index_foto = totalImagenesIntro - 1;
			
			resetIconosIntro();
			$(".icono_intro").eq( index_foto ).attr( "src", "images/icono_reloj_solar/" + $( ".icono_intro" ).eq( index_foto ).attr( "on" ) );

			$( "#tira_fotos" ).animate({
				left: "-=4000",
			}, 500, function() {});
		}
	});

	// Click flecha derecha
	$( "#flecha_derecha" ).click( function() {
		if ( index_foto < totalImagenesIntro - 1 ) {
			index_foto += 1;

			resetIconosIntro();
			$(".icono_intro").eq( index_foto ).attr( "src", "images/icono_reloj_solar/" + $( ".icono_intro" ).eq( index_foto ).attr( "on" ) );

			$( "#tira_fotos" ).animate({
				left: "-=800",
			}, 500, function() {});

		}  else if( index_foto == totalImagenesIntro - 1 ) {
			index_foto = 0;

			resetIconosIntro();
			$(".icono_intro").eq( index_foto ).attr( "src", "images/icono_reloj_solar/" + $( ".icono_intro" ).eq( index_foto ).attr( "on" ) );

			$( "#tira_fotos" ).animate({
			   left: "0",
			}, 500, function() {});
		}
	});

	// Clicks iconos lentes
	var clickIconoLentes = function( elem, index, url_img ) {
		if ( $( elem ).attr( "seleccionado" ) == "false" ) {

			resetIconosIntro();
			index_foto = index;

			$( elem ).attr( "seleccionado", "true" );
			$( elem ).attr( "src", url_img );
		} 

		var posleft = -1 * index_foto * 800;
		$( "#tira_fotos" ).animate({
		   left: posleft + "px",
		}, 500, function() {});

	};

	$(  "#icono_sunrise" ).click( function() {
		clickIconoLentes(this, 0, "images/icono_reloj_solar/sunrise_click.jpg");
	});

	$( "#icono_noon" ).click( function() {
		clickIconoLentes(this, 1, "images/icono_reloj_solar/noon_click.jpg");
	});

	$( "#icono_sunset" ).click( function() {
		clickIconoLentes(this, 2, "images/icono_reloj_solar/sunset_click.jpg");
	});

	$( "#icono_dusk" ).click( function() {
		clickIconoLentes(this, 3, "images/icono_reloj_solar/dusk_click.jpg");
	});

	$( "#icono_night" ).click( function() {
		clickIconoLentes(this, 4, "images/icono_reloj_solar/night_click.jpg");
	});

	$( "#icono_dawn" ).click( function() {
		clickIconoLentes(this, 5, "images/icono_reloj_solar/dawn_click.jpg");
	});
}

/**
 * configuraRedesSociales:
 *   Configura los clicks de los botones de las redes
 *  sociales.
 */
function configuraRedesSociales() {

	// Facebook
	$( ".facebook" ).click( function() {
		postToFeed("http://www.lentes24seven.com.mx/#" + indexModelo);
		return false;
	});
	
	// Twitter
	$( ".twitter" ).click( function() {
		window.open("https://twitter.com/Lentes24seven");
	});

	// Tumblr
	$( ".tumblr" ).click( function() {
		window.open("http://lentes24seven.tumblr.com/");
	});

	// Google+
	$( ".googlemas" ).click( function() {
		window.open("https://plus.google.com/+Lentes24seven");
	});

	// Pinterest
	$( ".pinterest" ).click( function() {
		window.open("http://www.pinterest.com/lentes24seven/");
	});

	// Instagram
	$( ".instagram" ).click( function() {
		window.open("http://instagram.com/lentes24seven");
	});

}

/**
 * buscarSitio:
 *   TODO
 *
 * @param patron - 
 */
function buscarSitio( patron ) {
	// TODO
}

/**
 * agregarMail:
 *   TODO
 *
 * @param email - 
 */
function agregarMail( email ) {
	var acepta_politica_privacidad = $( "#campo_dos" ).attr( "aceptado" );

	// TODO
}

/**
 * setModelo:
 *   Configura la pagina de modelo.html con la informacion de
 *  un modelo.
 *
 * @param indexModelo - indice del modelo en el arreglo de la base de datos
 */
function setModelo( indexModelo ) {
	
	configuraRedesSociales();

	var modeloElegido = DATOS_MODELOS[indexModelo];

	// Fotos
	$( "#fotoGrande" ).attr( "src", "images/fotos/" + modeloElegido.frontal );
	$( "#fotoChicaDer" ).attr( "src", "images/fotos/" + modeloElegido.lateral );
	$( "#fotoChicaCentro" ).attr( "src", "images/fotos/" + modeloElegido.frontal );
	$( "#fotoChicaIzq" ).attr( "src", "images/fotos/" + modeloElegido.diagonal );

	// Descripcion
	$( "#nombre" ).html( modeloElegido.nombre );
	$( "#descripcion" ).html( modeloElegido.descripcion );
	$( "#caracteristicas" ).html( modeloElegido.caracteristicas );
	$( "#precio" ).html( "$ " + modeloElegido.precio );
	$( "#icono_coleccion" ).attr( "src", "images/icono_reloj_solar/" + modeloElegido.icono_coleccion );
	$( "#contenedor_cara_2" ).empty();
	$( "#powered_by_paypal" ).attr( "modelo", indexModelo );

	// Formulario PayPal
	var form = document.createElement("form");
	$( form ).attr("id", "form_cart");
	$( form ).attr("method", "post");
	$( form ).attr("action", "");
	$( form ).attr("class", "jcart");

	var fieldset = document.createElement("fieldset");

	var input_token = document.createElement("input");
	$(input_token).attr("type", "hidden");
	$(input_token).attr("name", "jcartToken");
	$(input_token).val("");

	var input_id = document.createElement("input");
	$( input_id ).attr("type", "hidden");
	$( input_id ).attr("name", "item-id");
	$( input_id ).val( indexModelo );

	var input_name = document.createElement("input");
	$( input_name ).attr("type", "hidden");
	$( input_name ).attr("name", "item-name");
	$( input_name ).val( $( "#nombre" ).html() );

	var input_price = document.createElement("input");
	$( input_price ).attr("type", "hidden");
	$( input_price ).attr("name", "item-price");
	$( input_price ).val( modeloElegido.precio );

	var input_qty = document.createElement("input");
	$( input_qty ).attr("type", "hidden");
	$( input_qty ).attr("name", "item-qty");
	$( input_qty ).val("1");

	var input_img = document.createElement("input");
	$( input_img ).attr("type", "hidden");
	$( input_img ).attr("name", "item-url");
	$( input_img ).val( "images/fotos/" + modeloElegido.frontal );

	$( fieldset ).append(input_token);
	$( fieldset ).append(input_id);
	$( fieldset ).append(input_name);
	$( fieldset ).append(input_price);
	$( fieldset ).append(input_qty);
	$( fieldset ).append(input_img);

	$( form ).append(fieldset);

	$( "#columna_derecha" ).append(form);

	for(var i = 0; i < modeloElegido.forma_ideal.length; i++) {
		$("#contenedor_cara_2").append('<img id="icono_' + modeloElegido.forma_ideal[i] + '" src="images/' + modeloElegido.forma_ideal[i] + '.png" />');
	}
	$( "#estandar_calidad" ).html( '<img src="images/' + modeloElegido.medidas + '" />' );

	$( ".fotosMod" ).click(function() {
		var fotoAmplia = "images/fotos/" + modeloElegido[ $(this).attr("tipo") ];
		var tipoAmplia = $( this ).attr( "tipo" );
		$( "#fotoGrande" ).attr( "tipo", tipoAmplia );
		$( "#fotoGrande" ).attr( "src", fotoAmplia );
	});
	
	$( "#ver_descripcion" ).click( function() {
		if ( $( "#descripcion" ).attr("posicion") == "dentro" ) {
			$( "#descripcion" ).attr("posicion", "fuera");

			$( "#descripcion" ).stop().animate({
				top: "0px",
			}, 500, function() {
				$( "#caracteristicas, #estandar_calidad" ).attr("posicion", "dentro");
				$( "#caracteristicas, #estandar_calidad" ).stop().animate({
					top: "-316px",
				}, 500);
			});

		} else {
			$( "#descripcion" ).attr( "posicion", "dentro" );
			$( "#descripcion" ).stop().animate({
				top: "-316px",
			}, 500, function() {});
		}
	});

	$("#ver_caracteristicas").click(function() {
		if ( $( "#caracteristicas" ).attr( "posicion" ) == "dentro" ) {
			$( "#caracteristicas" ).attr( "posicion", "fuera" );
			$( "#caracteristicas" ).stop().animate({
				top: "0px",
			}, 500, function() {
				$( "#descripcion, #estandar_calidad" ).attr("posicion", "dentro");
				$( "#descripcion, #estandar_calidad" ).stop().animate({
					top: "-316px",
				}, 500);
			});
		} else {
			$( "#caracteristicas" ).attr("posicion", "dentro")
			$( "#caracteristicas" ).stop().animate({
				top: "-316px",
			}, 500, function() {});
		}
	});

	$("#ver_estandar_calidad").click(function() {

		if ( $( "#estandar_calidad" ).attr("posicion") == "dentro" ) {
			$("#contenedor_estandar_calidad").css("z-index","4");
			$( "#estandar_calidad" ).attr("posicion", "fuera")
			$( "#estandar_calidad" ).stop().animate({
				top: "0px",
			}, 500, function() {
				// Animation complete.
				$( "#caracteristicas, #descripcion" ).attr("posicion", "dentro");
					$( "#caracteristicas, #descripcion" ).stop().animate({
						top: "-316px",
				}, 500);
			});
		} else {

			$( "#estandar_calidad" ).attr("posicion", "dentro")
			$( "#estandar_calidad" ).stop().animate({
				top: "-316px",
			}, 500, function() {
				$("#contenedor_estandar_calidad").css("z-index","0");
			});
		}
		
	});

	$(".forma_ideal_click").click(function() {
		$.address.value("#forma_ideal")
	});

	$("#powered_by_paypal").click(function() {
		$( form ).submit();
	});

	initJcart();

	// FB INIT
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '486444471487514',
			xfbml      : true,
			version    : 'v2.0',
			status     : true,
			cookie     : true
		});
	};

	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/es_LA/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	} (document, 'script', 'facebook-jssdk'));

}

function postToFeed(url) {

	FB.ui({
		method: 'share',
		href: url,
	}, function(response) {
		console.log(response);
	});

}

/**
 * resetIconosIntro:
 *   Resetea todos los iconos de la introduccion
 *
 * @param email - 
 */
function resetIconosIntro() {
	$( ".icono_intro" ).attr( "seleccionado", "false");
	$( "#icono_sunrise" ).attr( "src", "images/icono_reloj_solar/icono_sunrise.png" );
	$( "#icono_noon" ).attr( "src", "images/icono_reloj_solar/icono_noon.png" );
	$( "#icono_sunset" ).attr( "src", "images/icono_reloj_solar/icono_sunset.png" );
	$( "#icono_dusk" ).attr( "src", "images/icono_reloj_solar/icono_dusk.png" );
	$( "#icono_night" ).attr( "src", "images/icono_reloj_solar/icono_night.png" );
	$( "#icono_dawn" ).attr( "src", "images/icono_reloj_solar/icono_dawn.png" );
}

/**
 * cargarContenidoMosaico:
 *   Carga el contenido del mosaico de lentes
 *
 * @param archivo - el nombre del archivo html a poner.
 * @param altura  - la altura que se debe redimensionar el bloque intermedio.
 */
function cargarContenidoMosaico( archivo, altura ) {
	$( "#bloque_intermedio" ).load( archivo, function() {
		
		$( "#bloque_intermedio" ).css( "height", altura + "px");
		$(".mostrarModelo").click( function() {
			console.log(this);
			indexModelo = parseInt( $( this ).attr( "modelo" ) );
			$.address.value( indexModelo );
		});

	});
}

/**
 * cargarContenidoModelo:
 *   Carga el contenido de un modelo de lentes
 *
 * @param archivo	 - el nombre del archivo html a poner.
 * @param altura	  - la altura que se debe redimensionar el bloque intermedio.
 * @param indexModelo - indice del modelo en el arreglo de la base de datos
 */
function cargarContenidoModelo( archivo, altura, indexModelo ) {
	$( "#bloque_intermedio" ).load( archivo, function() {
		$( "#bloque_intermedio" ).css( "height", altura + "px" );
		setModelo( indexModelo );
	});
}

/**
 * cargarContenidoIntro:
 *   Carga el contenido de la introduccion
 *
 * @param archivo	 - el nombre del archivo html a poner.
 * @param altura	  - la altura que se debe redimensionar el bloque intermedio.
 */
function cargarContenidoIntro( archivo, altura ) {
	$( "#bloque_intermedio" ).load( archivo, function() {
		$( "#bloque_intermedio" ).css( "height", altura + "px" );
		setIntro();
	});
}

/**
 * cargarContenido:
 *   Carga el contenido
 *
 * @param archivo	 - el nombre del archivo html a poner.
 * @param altura	  - la altura que se debe redimensionar el bloque intermedio.
 */
function cargarContenido(archivo, altura) {
	$( "#bloque_intermedio" ).load( archivo, function() {
		$( "#bloque_intermedio" ).css( "height", altura + "px" );
	});
}

///////////////////////////////////
//			M A I N				//
//////////////////////////////////

$( document ).ready( function() {

	// Configuramos las secciones
	configuraHashtags();

	/*** MANEJO DE EVENTOS ***/

	// En secciones
	$( ".cargaHTML" ).click( function() {
		var hashTag = $( this ).attr( "id" );
		$.address.value(hashTag);
	});

	// Ver carrito
	$( "#carrito" ).click( function() {
		
		initJcart();

		// Mandamos a traer el carrito
		$.ajax({
		
			type: "POST",
			url: path + '/relay.php',
			success: function(response) {

				if( response.indexOf("<div class='jcart_aux'") == 0 ) {
					$("#jcart_bkg").css({"height" : $("#pagina_completa").height()  + "px"});
					$("#jcart").html(response);
					$("#jcart").show();
					$("#jcart_bkg").show();
					$('#jcart-buttons').remove();

					$("#b_atras").click(function(e) {
						$("#jcart").hide();
						$("#jcart").empty();
						$("#jcart_bkg").hide();
						e.preventDefault();
					});

				} else {
					$("#jcart").empty();
					$("#jcart").hide();
					$("#jcart_bkg").hide();
				}

			},
			error: function(x, e) {
				var s = x.status, 
					m = 'Ajax error: ' ; 
				if (s === 0) {
					m += 'Check your network connection.';
				}
				if (s === 404 || s === 500) {
					m += s;
				}
				if (e === 'parsererror' || e === 'timeout') {
					m += e;
				}
				alert(m);
			}
		});

	});

	// Acerca de
	$( "#acerca_de" ).click( function() {
		window.open( "http://lentes24seven.com/quienes-somos/" );
	});

	// Tendencias
	$( "#veinticuatro_seven" ).click( function() {
		window.open("http://lentes24seven.com/category/tendencias-24seven/");
	});

	// Showroom
	$( ".showroom" ).click( function() {
		window.open("http://lentes24seven.tumblr.com/");
	});

	// Campo dos
	$( "#campo_dos" ).click( function() {
		if ( $( this ).attr( "aceptado" ) == "false" ) {
			$( this ).attr( "aceptado", "true" );
			$( this ).css( "background-color", "#000000" );
		} else {
			$( this ).attr( "aceptado", "false" );
			$( this ).css( "background-color", "#ffffff" );
		}
	});

	$( "#lupa" ).click( function() {
		buscarSitio( $("#buscar_sitio").val() );
	});

	$( "#buscar_sitio" ).keypress( function( event ) {
		if ( event.which == 13 ) {
			event.preventDefault();
			buscarSitio( $( "#buscar_sitio" ).val() );
		}
	});

	$( "#icono_mail" ).click( function() {
		agregarMail( $( "#correo_electronico" ).val() );
	});

	$( "#correo_electronico" ).keypress( function( event ) {
		if ( event.which == 13 ) {
			event.preventDefault();
			agregarMail( $("#correo_electronico").val() );
		}
	});

	// Redes sociales
	configuraRedesSociales();

});
