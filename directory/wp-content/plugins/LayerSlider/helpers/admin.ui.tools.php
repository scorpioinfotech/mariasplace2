<?php

function lsGetInput($default, $current, $attrs = array()) {

	// Markup
	$el = str_get_html('<td><input></td>')->find('input', 0);
	$el->type = is_string($default['value']) ? 'text' : 'number';
	$el->name = $name = is_string($default['keys']) ? $default['keys'] : $default['keys'][0];
	$el->value = $default['value'];

	// Attributes
	$attrs = isset($default['attrs']) ? array_merge($default['attrs'], $attrs) : $attrs;
	if(isset($attrs) && is_array($attrs)) {
		foreach($attrs as $attr => $val) {
			$el->$attr = $val;
		}
	}

	// Tooltip
	if(isset($default['tooltip'])) {
		$el->{'data-help'} = $default['tooltip'];
	}

	// Override the default
	if(isset($current[$name]) && $current[$name] !== '') {
		$el->value = stripslashes($current[$name]);
	}

	echo $el;
}

function lsGetCheckbox($default, $current, $attrs = array()) {

	// Markup
	$el = str_get_html('<td><input></td>')->find('input', 0);
	$el->type = 'checkbox';
	$el->name = $name = is_string($default['keys']) ? $default['keys'] : $default['keys'][0];

	// Attributes
	$attrs = isset($default['attrs']) ? array_merge($default['attrs'], $attrs) : $attrs;
	if(isset($attrs) && is_array($attrs)) {
		foreach($attrs as $attr => $val) {
			$el->$attr = $val;
		}
	}

	// Checked?
	if($default['value'] === true && count($current) < 3) {
		$el->checked = 'checked';
	} elseif(isset($current[$name]) && $current[$name] != false && $current[$name] !== 'false') {
		$el->checked = 'checked';
	}

	echo $el;
}

function lsGetSelect($default, $current, $attrs = array()) {

	// Var to hold data to print
	$el = str_get_html('<td><select></select></td>')->find('select', 0);
	$el->name = $name = is_string($default['keys']) ? $default['keys'] : $default['keys'][0];
	$value = $default['value'];
	$options = array();

	// Attributes
	$attrs = isset($default['attrs']) ? array_merge($default['attrs'], $attrs) : $attrs;
	if(isset($attrs) && is_array($attrs)) {
		foreach($attrs as $attr => $val) {
			if(!is_array($val)) {
				$el->$attr = $val;
			}
		}
	}

	// Get options
	if(isset($default['options']) && is_array($default['options'])) {
		$options = $default['options'];
	} elseif(isset($attrs['options']) && is_array($attrs['options'])) {
		$options = $attrs['options'];
	}

	// Override the default
	if(isset($current[$name]) && $current[$name] !== '') {
		$value = $current[$name];
	}

	// Tooltip
	if(isset($default['tooltip'])) {
		$el->{'data-help'} = $default['tooltip'];
	}

	// Add options
	foreach($options as $name => $val) {
		$name = is_string($name) ? $name : $val;
		$checked = ($name == $value) ? ' selected="selected"' : '';
		$el->innertext = $el->innertext . "<option value=\"$name\" $checked>$val</option>";
	}

	echo $el;
}

?>
