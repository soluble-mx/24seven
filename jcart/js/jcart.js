// This script sends Ajax requests to config-loader.php and relay.php using the path below
// We assume these files are in the 'jcart' directory, one level above this script
// Edit as needed if using a different directory structure

var path = "jcart";
var container = undefined;
var token = undefined;
var isCheckout = undefined;

function setupRequests() {

	// Remove the update and empty buttons since they're only used when javascript is disabled
	$('#jcart-buttons').remove();

	// Default settings for Ajax requests
	$.ajaxSetup({
		type: "POST",
		url: path + '/relay.php',
		success: function(response) {

			if( response.indexOf("<div class='jcart_aux'") == 0 ) {
				$("#jcart_bkg").css({ "height" : $("#pagina_completa").height()  + "px" });
				container.html(response);
				container.show();
				$("#jcart_bkg").show();
				$('#jcart-buttons').remove();
			} else {
				container.empty();
				container.hide();
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
}

function add(form) {
	// Input values for use in Ajax post
	var itemQty = form.find('[name=' + config.item.qty + ']'),
		itemAdd = form.find('[name=' + config.item.add + ']');

	// Add the item and refresh cart display
	$.ajax({
		data: form.serialize() + '&' + config.item.add + '=' + itemAdd.val(),
		success: function(response) {

			if( response.indexOf("<div class='jcart_aux'") == 0 ) {
				$("#jcart_bkg").css({"height" : $("#pagina_completa").height()  + "px"});
				container.html(response);
				container.show();
				$("#jcart_bkg").show();
				$('#jcart-buttons').remove();
			} else {
				container.empty();
				container.hide();
				$("#jcart_bkg").hide();
			}

		}
	});
}

function update(input, shippingOption) {

	// The id of the item to update
	var updateId = input.parent().find('[name="jcartItemId[]"]').val();

	// The new quantity
	var newQty = input.val();

	// As long as the visitor has entered a quantity
	if (newQty) {

		if (shippingOption != -1) {
			
			// Update the cart one second after keyup
			var updateTimer = window.setTimeout(function() {

				// Update the item and refresh cart display
				$.ajax({
					data: {
						"jcartUpdate": 1, // Only the name in this pair is used in jcart.php, but IE chokes on empty values
						"itemId": updateId,
						"itemQty": newQty,
						"jcartShipping": shippingOption,
						"jcartIsCheckout": isCheckout,
						"jcartToken": token,
					}
				});

			}, 750);

		} else {
			// Update the cart one second after keyup
			var updateTimer = window.setTimeout(function() {

				// Update the item and refresh cart display
				$.ajax({
					data: {
						"jcartUpdate": 1, // Only the name in this pair is used in jcart.php, but IE chokes on empty values
						"itemId": updateId,
						"itemQty": newQty,
						"jcartIsCheckout": isCheckout,
						"jcartToken": token,
					}
				});

			}, 750);
		}
	}

	// If the visitor presses another key before the timer has expired, clear the timer and start over
	// If the timer expires before the visitor presses another key, update the item
	input.keydown(function(e) {
		if (e.which !== 9) {
			window.clearTimeout(updateTimer);
		}
	});
}

function remove(removeId) {

	// Remove the item and refresh cart display
	$.ajax({
		type: 'GET',
		data: {
			"jcartRemove": removeId,
			"jcartIsCheckout": isCheckout
		}
	});
}

function selectShipping(div_elem) {

	if( $(".check_select").length > 0 ) {
		
		$(".check_select").find("i").removeClass("fa-circle");
		$(".check_select").find("i").addClass("fa-circle-o");

		$(".check_select").removeClass( "check_select" );
	}

	$( div_elem ).addClass( "check_select" );
	$( div_elem ).find("i").removeClass("fa-circle-o");
	$( div_elem ).find("i").addClass("fa-circle");

	var shipping = $( div_elem ).first().attr( "id" ) == "metodo1" ? 1 : 0;

	update( $('[name="jcartItemQty[]"]'), shipping );
}

function initJcart() {
	container = $('#jcart');
	token = $('[name=jcartToken]').val();

	// Load config if is necessary
	if(config == null || config == undefined) {
		$.ajax({
			url: path + "/config-loader.php",
			data: {
				"ajax": "true"
			},
			dataType: "json",
			async: false,
			success: function(response) {
				config = response;
			},
			error: function() {
				alert('Ajax error: Edit the path in jcart.js to fix.');
			}
		});
	}

	// Setup all ajax requests
	setupRequests();

	// Check hidden input value
	// Sent via Ajax request to jcart.php which decides whether to display the cart checkout button or the PayPal checkout button based on its value
	// We normally check against request uri but Ajax update sets value to relay.php

	// If this is not the checkout the hidden input doesn't exist and no value is set
	isCheckout = $('#jcart-is-checkout').val();

	/*** EVENT HANDLERS ***/

	// Add an item to the cart
	$('.jcart').submit(function(e) {
		add($(this));
		e.preventDefault();
	});

	// Prevent enter key from submitting the cart
	container.keydown(function(e) {
		if(e.which === 13) {
			e.preventDefault();
		}
	});

	// Update an item in the cart
	container.delegate('[name="jcartItemQty[]"]', 'keyup', function() {
		update($(this), -1);
	});

	// Remove an item from the cart
	container.delegate('.b_eliminar', 'click', function(e) {
		var id_item = $(this).attr("item_id");
		remove(id_item);
		e.preventDefault();
	});

	container.delegate('#b_atras', 'click', function(e) {
		container.hide();
		container.empty();
		$("#jcart_bkg").hide();
		e.preventDefault();
	});

}
