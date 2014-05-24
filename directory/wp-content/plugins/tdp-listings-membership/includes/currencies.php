<?php
	//thanks jigoshop
	global $tdp_currencies, $tdp_default_currency;
	$tdp_default_currency = apply_filters("tdp_default_currency", "USD");
	
	$tdp_currencies = array( 
			'ZAR' => __('South African Rand (R)', 'tdp'),
			'USD' => __('US Dollars (&#36;)', 'tdp'),
			'EUR' => __('Euros (&euro;)', 'tdp'),
			'EGP' => __('Egyptian Pound (E£)','tdp'),
			'GBP' => __('Pounds Sterling (&pound;)', 'tdp'),
			'AUD' => __('Australian Dollars (&#36;)', 'tdp'),
			'BRL' => __('Brazilian Real (&#36;)', 'tdp'),
			'CAD' => __('Canadian Dollars (&#36;)', 'tdp'),
			'CZK' => __('Czech Koruna', 'tdp'),
			'DKK' => __('Danish Krone', 'tdp'),
			'HKD' => __('Hong Kong Dollar (&#36;)', 'tdp'),
			'HUF' => __('Hungarian Forint', 'tdp'),
			'ILS' => __('Israeli Shekel', 'tdp'),
			'JPY' => __('Japanese Yen (&yen;)', 'tdp'),
			'MYR' => __('Malaysian Ringgits', 'tdp'),
			'MXN' => __('Mexican Peso (&#36;)', 'tdp'),
			'NZD' => __('New Zealand Dollar (&#36;)', 'tdp'),
			'NOK' => __('Norwegian Krone', 'tdp'),
			'PHP' => __('Philippine Pesos', 'tdp'),
			'PLN' => __('Polish Zloty', 'tdp'),
			'RUB' => __('Russian Ruble', 'tdp'),
			'SGD' => __('Singapore Dollar (&#36;)', 'tdp'),
			'SEK' => __('Swedish Krona', 'tdp'),
			'CHF' => __('Swiss Franc', 'tdp'),
			'TWD' => __('Taiwan New Dollars', 'tdp'),
			'THB' => __('Thai Baht', 'tdp') 
			);
	
	$tdp_currencies = apply_filters("tdp_currencies", $tdp_currencies);
	
	//stripe only supports a few
	global $tdp_stripe_currencies;
	$tdp_stripe_currencies = array(
			'USD' => __('US Dollars (&#36;)', 'tdp'),			
			'CAD' => __('Canadian Dollars (&#36;)', 'tdp'),
			'GBP' => __('Pounds Sterling (&pound;)', 'tdp'),
			'EUR' => __('Euros (&euro;)', 'tdp')
	);
?>