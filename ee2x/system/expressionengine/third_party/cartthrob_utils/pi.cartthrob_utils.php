<?php
/*
==========================================================
	This software package is intended for use with 
	ExpressionEngine.	ExpressionEngine is Copyright © 
	2002-2011 EllisLab, Inc. 
	http://ellislab.com/
==========================================================
	THIS IS COPYRIGHTED SOFTWARE, All RIGHTS RESERVED.
	Written by: Louis Dekeister
	Copyright (c) 2015 Hop Studios
	http://www.hopstudios.com/software/
--------------------------------------------------------
	Please do not distribute this software without written
	consent from the author.
==========================================================
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once PATH_THIRD."cartthrob_utils/config.php";

$plugin_info = array(
	'pi_name'			=> 'Cartthrob Utils',
	'pi_version'		=> CARTTHROB_UTILS_VERSION,
	'pi_author' 		=> 'Louis Dekeister (Hop Studios)',
	'pi_author_url' 	=> 'http://www.hopstudios.com/software/',
	'pi_description' 	=> 'Some utilities for Cartthrob',
	'pi_usage'			=> Cartthrob_utils::usage()
);

class Cartthrob_utils
{
	private $params;
	private $c_settings;
	private $c_session;
	private $c_cart;
	
	public function __construct()
	{
		ee()->load->model('ip_to_nation_data', 'ip_data');
		
		// Load cartthrob stuff because we'll need some pieces of them 
		ee()->load->add_package_path(PATH_THIRD.'cartthrob/');
		ee()->load->add_package_path(PATH_THIRD.'cartthrob_multi_location/');
		$this->params = array(
			'module_name'	=> 'cartthrob_multi_location',
		); 
 		ee()->load->library('mbr_addon_builder');
		ee()->mbr_addon_builder->initialize($this->params);
		
		ee()->load->library('get_settings');
		// $this->settings = ee()->get_settings->settings('cartthrob_multi_location');
		$this->c_settings = ee()->get_settings->settings('cartthrob');
		
		$this->c_session = ee()->cartthrob_session->to_array();
		
		$this->c_cart = ee()->cartthrob->cart->to_array();
	}
	
	
	/**
	 * Display current currency symbol
	 * @return string [description]
	 */
	function currency()
	{
		// print_r($this->c_cart);
		$cart_conf = $this->c_cart['config'];
		return $cart_conf['number_format_defaults_prefix'];
	}
	
	/**
	 * Display current currency code (USD, CAD, EUR...)
	 * @return string [description]
	 */
	function currency_code()
	{
		// print_r($this->settings);
		$cart_conf = $this->c_cart['config'];
		return $cart_conf['number_format_defaults_currency_code'];
	}
	
	public static function usage()
	{
	ob_start(); 
	?>
		--- Some utilities for Cartthrob ---
		
		
		
		Display current currency
		---------------------------------
		Displays the currency symbol ($, €, ¥, £...)
		
		{exp:cartthrob_utils:currency}
		
		
		Display current currency code
		-------------------------------------
		Displays the currency code (USD, EUR, CAD...)
		
		{exp:cartthrob_utils:currency_code}
		 
	<?php
		$buffer = ob_get_contents();
	
		ob_end_clean(); 

		return $buffer;
	}
}
