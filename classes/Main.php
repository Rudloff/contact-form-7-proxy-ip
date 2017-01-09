<?php

namespace ContactFormProxyIp;

class Main
{
    public static function addSpecialTags($output, $name, $html)
    {
        $submission = \WPCF7_Submission::get_instance();

        if (!$submission) {
            return $output;
        }

        if ('_forwarded_ip' == $name) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif ($remote_ip = $submission->get_meta('remote_ip')) {
                return $remote_ip;
            } else {
                return '';
            }
        }
    }
}
