<?php

// jCart v1.3
// http://conceptlogic.com/jcart/

//error_reporting(E_ALL);

// Cart logic based on Webforce Cart: http://www.webforcecart.com/
class Jcart {

	public $config            = array();
	private $items            = array();
	private $names            = array();
	private $prices           = array();
	private $qtys             = array();
	private $urls             = array();
	private $subtotal         = 0;
	private $itemCount        = 0;
	private $shipping         = 0;
	private $shippingMethod   = 0; // 0 - MexPost, 1 - Estafeta

	function __construct() {

		// Get $config array
		include_once('config-loader.php');
		$this->config = $config;

	}

	/**
	* Get cart contents
	*
	* @return array
	*/
	public function get_contents() {
		$items = array();
		foreach($this->items as $tmpItem) {
			$item = null;
			$item['id']       = $tmpItem;
			$item['name']     = $this->names[$tmpItem];
			$item['price']    = $this->prices[$tmpItem];
			$item['qty']      = $this->qtys[$tmpItem];
			$item['url']      = $this->urls[$tmpItem];
			$item['subtotal'] = $item['price'] * $item['qty'];
			$items[]          = $item;
		}
		return $items;
	}

	/**
	* Add an item to the cart
	*
	* @param string $id
	* @param string $name
	* @param float $price
	* @param mixed $qty
	* @param string $url
	*
	* @return mixed
	*/
	private function add_item($id, $name, $price, $qty = 1, $url) {

		$validPrice = false;
		$validQty = false;

		// Verify the price is numeric
		if (is_numeric($price)) {
			$validPrice = true;
		}

		// If decimal quantities are enabled, verify the quantity is a positive float
		if ($this->config['decimalQtys'] === true && filter_var($qty, FILTER_VALIDATE_FLOAT) && $qty > 0) {
			$validQty = true;
		}
		// By default, verify the quantity is a positive integer
		elseif (filter_var($qty, FILTER_VALIDATE_INT) && $qty > 0) {
			$validQty = true;
		}

		// Add the item
		if ($validPrice !== false && $validQty !== false) {

			// If the item is already in the cart, increase its quantity
			if($this->qtys[$id] > 0) {
				$this->qtys[$id] += $qty;
				$this->update_subtotal();
			}
			// This is a new item
			else {
				$this->items[]     = $id;
				$this->names[$id]  = $name;
				$this->prices[$id] = $price;
				$this->qtys[$id]   = $qty;
				$this->urls[$id]   = $url;
			}
			$this->update_subtotal();
			return true;
		}
		elseif ($validPrice !== true) {
			$errorType = 'price';
			return $errorType;
		}
		elseif ($validQty !== true) {
			$errorType = 'qty';
			return $errorType;
		}
	}

	/**
	* Update an item in the cart
	*
	* @param string $id
	* @param mixed $qty
	*
	* @return boolean
	*/
	private function update_item($id, $qty) {

		// If the quantity is zero, no futher validation is required
		if ((int) $qty === 0) {
			$validQty = true;
		}
		// If decimal quantities are enabled, verify it's a float
		elseif ($this->config['decimalQtys'] === true && filter_var($qty, FILTER_VALIDATE_FLOAT)) {
			$validQty = true;
		}
		// By default, verify the quantity is an integer
		elseif (filter_var($qty, FILTER_VALIDATE_INT))	{
			$validQty = true;
		}

		// If it's a valid quantity, remove or update as necessary
		if ($validQty === true) {
			if($qty < 1) {
				$this->remove_item($id);
			}
			else {
				$this->qtys[$id] = $qty;
			}
			$this->update_subtotal();
			return true;
		}

	}

	private function update_shipping($shippingMethod) {
		$this->shippingMethod = $shippingMethod;
		$this->update_subtotal();

		return true;
	}


	/* Using post vars to remove items doesn't work because we have to pass the
	id of the item to be removed as the value of the button. If using an input
	with type submit, all browsers display the item id, instead of allowing for
	user-friendly text. If using an input with type image, IE does not submit
	the	value, only x and y coordinates where button was clicked. Can't use a
	hidden input either since the cart form has to encompass all items to
	recalculate	subtotal when a quantity is changed, which means there are
	multiple remove	buttons and no way to associate them with the correct
	hidden input. */

	/**
	* Reamove an item from the cart
	*
	* @param string $id	*
	*/
	private function remove_item($id) {
		$tmpItems = array();

		unset($this->names[$id]);
		unset($this->prices[$id]);
		unset($this->qtys[$id]);
		unset($this->urls[$id]);

		// Rebuild the items array, excluding the id we just removed
		foreach($this->items as $item) {
			if($item != $id) {
				$tmpItems[] = $item;
			}
		}
		$this->items = $tmpItems;
		$this->update_subtotal();
	}

	/**
	* Empty the cart
	*/
	public function empty_cart() {
		$this->items      = array();
		$this->names      = array();
		$this->prices     = array();
		$this->qtys       = array();
		$this->urls       = array();
		$this->subtotal   = 0;
		$this->itemCount  = 0;
	}

	/**
	* Update the entire cart
	*/
	public function update_cart() {

		// Post value is an array of all item quantities in the cart
		// Treat array as a string for validation
		if (is_array($_POST['jcartItemQty'])) {
			$qtys = implode($_POST['jcartItemQty']);
		}

		// If no item ids, the cart is empty
		if ($_POST['jcartItemId']) {

			$validQtys = false;

			// If decimal quantities are enabled, verify the combined string only contain digits and decimal points
			if ($this->config['decimalQtys'] === true && preg_match("/^[0-9.]+$/i", $qtys)) {
				$validQtys = true;
			}
			// By default, verify the string only contains integers
			elseif (filter_var($qtys, FILTER_VALIDATE_INT) || $qtys == '') {
				$validQtys = true;
			}

			if ($validQtys === true) {

				// The item index
				$count = 0;

				// For each item in the cart, remove or update as necessary
				foreach ($_POST['jcartItemId'] as $id) {

					$qty = $_POST['jcartItemQty'][$count];

					if($qty < 1) {
						$this->remove_item($id);
					}
					else {
						$this->update_item($id, $qty);
					}

					// Increment index for the next item
					$count++;
				}

				return true;
			}
		}

		// If no items in the cart, return true to prevent unnecssary error message
		elseif (!$_POST['jcartItemId']) {
			return true;
		}
	}

	/**
	* Recalculate subtotal
	*/
	private function update_subtotal() {
		$this->itemCount  = 0;
		$this->subtotal   = 0;
		$this->shipping   = 0;

		if(sizeof($this->items > 0)) {
			foreach($this->items as $item) {
				$this->subtotal += ($this->qtys[$item] * $this->prices[$item]);

				// Total number of items
				$this->itemCount += $this->qtys[$item];
			}
		}

		// Si es de estafeta
		if($this->shippingMethod == 1) {

			// Cada 8 productos es un paquete
			$packages = ceil($this->itemCount / 8);

			// Cada paquete cuesta 119.48
			$this->shipping = $packages * 119.48;
		}

		// Lo sumamos al subtotal
		$this->subtotal += $this->shipping;
	}

	public function get_shipping_method() {
		return $this->shippingMethod;
	}

	public function get_shipping_amount() {
		$this->update_subtotal();
		return $this->shipping;
	}

	/**
	* Process and display cart
	*/
	public function display_cart() {

		$config = $this->config;
		$errorMessage = null;

		// Simplify some config variables
		$checkout = $config['checkoutPath'];
		$priceFormat = $config['priceFormat'];

		$id    = $config['item']['id'];
		$name  = $config['item']['name'];
		$price = $config['item']['price'];
		$qty   = $config['item']['qty'];
		$url   = $config['item']['url'];
		$add   = $config['item']['add'];

		// Use config values as literal indices for incoming POST values
		// Values are the HTML name attributes set in config.json
		$id    = $_POST[$id];
		$name  = $_POST[$name];
		$price = $_POST[$price];
		$qty   = $_POST[$qty];
		$url   = $_POST[$url];

		// Optional CSRF protection, see: http://conceptlogic.com/jcart/security.php
		$jcartToken = $_POST['jcartToken'];

		// Only generate unique token once per session
		if(!$_SESSION['jcartToken']){
			$_SESSION['jcartToken'] = md5(session_id() . time() . $_SERVER['HTTP_USER_AGENT']);
		}
		// If enabled, check submitted token against session token for POST requests
		if ($config['csrfToken'] === 'true' && $_POST && $jcartToken != $_SESSION['jcartToken']) {
			$errorMessage = 'Invalid token!' . $jcartToken . ' / ' . $_SESSION['jcartToken'];
		}

		// Sanitize values for output in the browser
		$id    = filter_var($id, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
		$name  = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
		$url   = filter_var($url, FILTER_SANITIZE_URL);

		// Round the quantity if necessary
		if($config['decimalPlaces'] === true) {
			$qty = round($qty, $config['decimalPlaces']);
		}

		// Add an item
		if ($_POST[$add]) {
			$itemAdded = $this->add_item($id, $name, $price, $qty, $url);
			// If not true the add item function returns the error type
			if ($itemAdded !== true) {
				$errorType = $itemAdded;
				switch($errorType) {
					case 'qty':
						$errorMessage = $config['text']['quantityError'];
						break;
					case 'price':
						$errorMessage = $config['text']['priceError'];
						break;
				}
			}
		}

		// Update a single item
		if ($_POST['jcartUpdate']) {

			// Update the shipping
			if (isset($_POST['jcartShipping'])) {
				$cartUpdated = $this->update_shipping($_POST['jcartShipping']);
				if ($cartUpdated !== true)	{
					$errorMessage = $config['text']['quantityError'];
				}
			}
			else {
				$itemUpdated = $this->update_item($_POST['itemId'], $_POST['itemQty']);
				if ($itemUpdated !== true)	{
					$errorMessage = $config['text']['quantityError'];
				}
			}
		}

		// Update all items in the cart
		if ($_POST['jcartUpdateCart'] || $_POST['jcartCheckout']) {
			$cartUpdated = $this->update_cart();
			if ($cartUpdated !== true)	{
				$errorMessage = $config['text']['quantityError'];
			}
		}

		// Remove an item
		/* After an item is removed, its id stays set in the query string,
		preventing the same item from being added back to the cart in
		subsequent POST requests.  As result, it's not enough to check for
		GET before deleting the item, must also check that this isn't a POST
		request. */
		if($_GET['jcartRemove'] && !$_POST) {
			$this->remove_item($_GET['jcartRemove']);
		}

		// Empty the cart
		if($_POST['jcartEmpty']) {
			$this->empty_cart();
		}

		// Determine which text to use for the number of items in the cart
		$itemsText = $config['text']['multipleItems'];
		if ($this->itemCount == 1) {
			$itemsText = $config['text']['singleItem'];
		}

		// Determine if this is the checkout page
		/* First we check the request uri against the config checkout (set when
		the visitor first clicks checkout), then check for the hidden input
		sent with Ajax request (set when visitor has javascript enabled and
		updates an item quantity). */
		$isCheckout = strpos(request_uri(), $checkout);
		if ($isCheckout !== false || $_REQUEST['jcartIsCheckout'] == 'true') {
			$isCheckout = true;
		}
		else {
			$isCheckout = false;
		}

		// Overwrite the form action to post to gateway.php instead of posting back to checkout page
		if ($isCheckout === true) {

			// Sanititze config path
			$path = filter_var($config['jcartPath'], FILTER_SANITIZE_URL);

			// Trim trailing slash if necessary
			$path = rtrim($path, '/');

			$checkout = $path . '/gateway.php';
		}

		// Default input type
		// Overridden if using button images in config.php
		$inputType = 'submit';

		// If this error is true the visitor updated the cart from the checkout page using an invalid price format
		// Passed as a session var since the checkout page uses a header redirect
		// If passed via GET the query string stays set even after subsequent POST requests
		if ($_SESSION['quantityError'] === true) {
			$errorMessage = $config['text']['quantityError'];
			unset($_SESSION['quantityError']);
		}

		// Set currency symbol based on config currency code
		$currencyCode = trim(strtoupper($config['currencyCode']));
		switch($currencyCode) {
			case 'EUR':
				$currencySymbol = '&#128;';
				break;
			case 'GBP':
				$currencySymbol = '&#163;';
				break;
			case 'JPY':
				$currencySymbol = '&#165;';
				break;
			case 'CHF':
				$currencySymbol = 'CHF&nbsp;';
				break;
			case 'SEK':
			case 'DKK':
			case 'NOK':
				$currencySymbol = 'Kr&nbsp;';
				break;
			case 'PLN':
				$currencySymbol = 'z&#322;&nbsp;';
				break;
			case 'HUF':
				$currencySymbol = 'Ft&nbsp;';
				break;
			case 'CZK':
				$currencySymbol = 'K&#269;&nbsp;';
				break;
			case 'ILS':
				$currencySymbol = '&#8362;&nbsp;';
				break;
			case 'TWD':
				$currencySymbol = 'NT$';
				break;
			case 'THB':
				$currencySymbol = '&#3647;';
				break;
			case 'MYR':
				$currencySymbol = 'RM';
				break;
			case 'PHP':
				$currencySymbol = 'Php';
				break;
			case 'BRL':
				$currencySymbol = 'R$';
				break;
			case 'USD':
			default:
				$currencySymbol = '$';
				break;
		}

		////////////////////////////////////////////////////////////////////////
		// Output the cart

		// If there's an error message wrap it in some HTML
		if ($errorMessage)	{
			$errorMessage = "<p id='jcart-error'>$errorMessage</p>";
		}

		// Display the cart header
		echo "$errorMessage";
		echo "<div class='jcart_aux' style='display: none;'></div>";
		echo "<form method='post' action='$checkout'>";
		echo "<fieldset>";
		echo "<input type='hidden' name='jcartToken' value='{$_SESSION['jcartToken']}' />";

		echo "<div id='carrito_checkout'>";
		echo "<div class='datagrid'>";

		// Tabla de los productos
		echo "<table>";

		// Cabecera de tabla
		echo "<thead>";
		echo "<tr>";
		echo "<th style='width:40%'>MODELO</th>";
		echo "<th style='width:16.67%'>CANTIDAD</th>";
		echo "<th style='width:16.67%'>PRECIO UNITARIO</th>";
		echo "<th style='width:16.67%'>TOTAL UNITARIO</th>";
		echo "<th style='width:10%; text-align:center'></th>";
		echo "</tr>";
		echo "</thead>";

		// Footer
		echo "<tfoot>";

		// Metodos de pago
		echo "<tr>";
		echo "<td></td>";

		if ($isCheckout == true) {
			echo "<td class='ref_cantidad'>MÉTODO DE ENVÍO</td>";

			// Metodo 1
			/*if($this->shippingMethod == 1) {
				echo "<td><img src='images/logo_estafeta.png'/><span>Entrega día siguiente.<br>Costo por cada 8 productos.</span></td>";
				echo "<td class='ref_total_unit'>$119.48</td>";
			} else {
				echo "<td> <img src='images/logo_mexpost.png'/></br><span>Entrega 3 días</span></td>";
				echo "<td class='ref_total_unit'>Gratis</td>";
			}*/
			
			echo "<td> <img src='images/logo_mexpost.png'/></br><span>Entrega 3 días</span></td>";
			echo "<td class='ref_total_unit'>Gratis</td>";
		} else {
			//echo "<td class='ref_cantidad'>ELIGE EL MÉTODO DE ENVÍO</td>";
			echo "<td class='ref_cantidad'>MÉTODO DE ENVÍO</td>";

			//echo "<td><img src='images/logo_estafeta.png'/><span>Entrega día siguiente.<br>Costo por cada 8 productos.</span></td>";
			//echo "<td class='ref_total_unit'>$119.48</td>";

			// Metodo 1
			/*if($this->shippingMethod == 1) {
				echo "<td><div id='metodo1' class='checks check_select' onclick='selectShipping(this, event);'>";
				echo "<i class='fa fa-circle'></i></div></td>";
			} else {
				echo "<td><div id='metodo1' class='checks' onclick='selectShipping(this, event);'>";
				echo "<i class='fa fa-circle-o'></i></div></td>";
			}*/

			echo "</tr>";
			echo "<tr>";
			echo "<td colspan='2'></td>";
			echo "<td> <img src='images/logo_mexpost.png'/></br><span>Entrega 3 días</span></td>";
			echo "<td class='ref_total_unit'>Gratis</td>";

			// Metodo2
			if($this->shippingMethod == 0) {
				echo "<td><div id='metodo2' class='checks check_select' onclick='selectShipping(this, event);'>";
				echo "<i class='fa fa-circle'></i></div></td>";
			} else {
				echo "<td><div id='metodo2' class='checks' onclick='selectShipping(this, event);'>";
				echo "<i class='fa fa-circle-o'></i></div></td>";
			}
		}
		
		
		echo "</tr>";

		// Total, comprar y seguir comprando
		echo "<tr>";
		if ($isCheckout == true) {
			echo "<td colspan='2'><a id='b_atras_link' href='index.php'><div id='b_atras'>Seguir comprando</div></a></td>";
		} else {
			echo "<td colspan='2'><div id='b_atras'>Seguir comprando</div></td>";
		}

		echo "<td class='t_total'>TOTAL</td>";
		echo "<td class='ref_total'>";
		echo "<strong>$currencySymbol";
		echo number_format($this->subtotal, $priceFormat['decimals'], $priceFormat['dec_point'], $priceFormat['thousands_sep']) . "</strong>";
		echo "</td>";

		// If this is the checkout hide the cart checkout button
		if ($isCheckout !== true) {

			// Boton comprar
			if ($config['button']['checkout']) {
				$inputType = "image";
				$src = " src='{$config['button']['checkout']}' alt='{$config['text']['checkout']}' title='' ";
			}

			echo "<td><div>";
			echo "<input type='$inputType' $src id='b_compra_paypal' name='jcartCheckout' class='jcart-button' value='{$config['text']['checkout']}' />\n";
			echo "</div></td>";

		}

		// If this is the checkout display the PayPal checkout button
		if ($isCheckout === true) {
			// Hidden input allows us to determine if we're on the checkout page
			// We normally check against request uri but ajax update sets value to relay.php
			echo "<input type='hidden' id='jcart-is-checkout' name='jcartIsCheckout' value='true' />";

			// PayPal checkout button
			if ($config['button']['checkout'])	{
				$inputType = "image";
				$src = " src='{$config['button']['checkout']}' alt='{$config['text']['checkoutPaypal']}' title='' ";
			}

			if($this->itemCount <= 0) {
				$disablePaypalCheckout = " disabled='disabled'";
			}			

			echo "<td><div>";
			echo "<input type='$inputType' $src id='b_compra_paypal' class='jcart-button' name='jcartPaypalCheckout' value='{$config['text']['checkoutPaypal']}' $disablePaypalCheckout />";
			echo "</div></td>";
		}
		
		echo "</tr>";
		echo "</tfoot>";

		// El cuerpo de la tabla
		echo "<tbody>";

		// If any items in the cart
		if($this->itemCount > 0) {

			// Display line items
			foreach($this->get_contents() as $item)	{
				//echo json_encode($item);

				echo "<tr>";

				// Descripcion del modelo
				echo "<td class='ref_modelo'>";
				// URL DE LA FOTO
				if ($item['url']) {
					echo "<img class='carrito_thumbnail' src='{$item['url']}'>";
				}
				echo "<span>{$item['name']}</span></td>";
				echo "<input name='jcartItemName[]' type='hidden' value='{$item['name']}' />";
				echo "</td>";

				// Cantidad de producto
				echo "<td class='ref_cantidad'>";
				echo "<input name='jcartItemId[]' type='hidden' value='{$item['id']}' />";
				if ($isCheckout == true) {
					echo "<input id='jcartItemQty-{$item['id']}' name='jcartItemQty[]' size='2' type='hidden' value='{$item['qty']}' max='100' />";
					echo "<div style='font-family: Oxygen Mono; font-size: 12px;'>{$item['qty']}</div>";
				} else {
					echo "<input id='jcartItemQty-{$item['id']}' name='jcartItemQty[]' size='2' type='number' value='{$item['qty']}' max='100' />";
				}
				echo "</td>";

				// Precio unitario
				echo "<td class='ref_costo_unit'>";
				echo "$currencySymbol";
				echo number_format($item['price'], $priceFormat['decimals'], $priceFormat['dec_point'], $priceFormat['thousands_sep']);
				echo "</td>";

				// Precio total unitario
				echo "<td class='ref_total_unit'>";
				echo "$currencySymbol";
				echo number_format($item['subtotal'], $priceFormat['decimals'], $priceFormat['dec_point'], $priceFormat['thousands_sep']);
				echo "<input name='jcartItemPrice[]' type='hidden' value='{$item['price']}' />";
				echo "</td>";

				// Para eliminar
				echo "<td>";
				if ($isCheckout !== true) {
					echo "<div class='b_eliminar' item_id='{$item['id']}'><i class='fa fa-minus-circle'></i></div>";
				}
				echo "</td>";

				echo "</tr>";
			}
		}

		// The cart is empty
		else {
			echo "<tr><td id='jcart-empty' colspan='3'>{$config['text']['emptyMessage']}</td></tr>";
		}

		echo "</tbody>";

		echo "</table>";
		echo "</div>";
		echo "</div>";
		echo "</fieldset>";
		echo "</form>";
		
	}
}

// Start a new session in case it hasn't already been started on the including page
@session_start();

// Initialize jcart after session start
$jcart = $_SESSION['seven_cart'];
if(!is_object($jcart)) {
	$jcart = $_SESSION['seven_cart'] = new Jcart();
}

// Enable request_uri for non-Apache environments
// See: http://api.drupal.org/api/function/request_uri/7
if (!function_exists('request_uri')) {
	function request_uri() {
		if (isset($_SERVER['REQUEST_URI'])) {
			$uri = $_SERVER['REQUEST_URI'];
		}
		else {
			if (isset($_SERVER['argv'])) {
				$uri = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['argv'][0];
			}
			elseif (isset($_SERVER['QUERY_STRING'])) {
				$uri = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING'];
			}
			else {
				$uri = $_SERVER['SCRIPT_NAME'];
			}
		}
		$uri = '/' . ltrim($uri, '/');
		return $uri;
	}
}
?>