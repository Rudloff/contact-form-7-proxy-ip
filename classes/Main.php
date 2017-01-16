<?php

namespace ContactFormProxyIp;

class Main
{
    /**
     * Add a new _forwarded_ip tag
     * @param string $output HTML output
     * @param string $name   Tag name
     * @return string
     */
    public static function addSpecialTags($output, $name)
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
