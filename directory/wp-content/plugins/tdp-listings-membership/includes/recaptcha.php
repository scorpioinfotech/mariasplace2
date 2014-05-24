<?php
function tdp_init_recaptcha()
{
	//don't load in admin
	if(is_admin())
		return;
	
	//use recaptcha?
	global $recaptcha;
	$recaptcha = tdp_getOption("recaptcha");
	if($recaptcha)
	{
		global $recaptcha_publickey, $recaptcha_privatekey;
		if(!function_exists("recaptcha_get_html"))
		{
			require_once(TDP_DIR . "/includes/lib/recaptchalib.php");
		}
		$recaptcha_publickey = tdp_getOption("recaptcha_publickey");
		$recaptcha_privatekey = tdp_getOption("recaptcha_privatekey");
	}
}
add_action("init", "tdp_init_recaptcha", 20);
