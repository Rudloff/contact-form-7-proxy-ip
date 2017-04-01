<?php
/*
Plugin Name: Contact Form 7 Proxy IP
Plugin URI: https://github.com/Rudloff/contact-form-7-proxy-ip
Description:  Use HTTP_X_FORWARDED_FOR in Contact Form 7 e-mails
Author: Pierre Rudloff
Version: 0.1.0
Author URI: https://www.rudloff.pro/
*/

use ContactFormProxyIp\Main;

require_once __DIR__.'/vendor/autoload.php';

add_filter('wpcf7_special_mail_tags', [Main::class, 'addSpecialTags'], 10, 3);
