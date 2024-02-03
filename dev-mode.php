<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('dd')) {
    function dd($data)
    {
        ini_set("highlight.comment", "#969896; font-style: italic");
        ini_set("highlight.default", "#FFFFFF");
        ini_set("highlight.html", "#D16568");
        ini_set("highlight.keyword", "#7FA3BC; font-weight: bold");
        ini_set("highlight.string", "#F2C47E");
        $output = highlight_string("<?php\n\n" . var_export($data, true), true);
        echo "<div style=\"background-color: #1C1E21; padding: 1rem\">{$output}</div>";
        die();
    }
}

if (!function_exists('write_log')) {

    function write_log($log)
    {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
                return;
            }

            error_log($log);
        }
    }
}


/**
 * Mailtrap
 *
 * @param PHPMailer $phpmailer
 * @return void
 */
if (!function_exists('mailtrap')) {
    function mailtrap($phpmailer)
    {
        $phpmailer->isSMTP();
        $phpmailer->Host     = $_ENV['SMTP_HOST'];
        $phpmailer->SMTPAuth = $_ENV['SMTP_AUTH'];
        $phpmailer->Port     = $_ENV['SMTP_PORT'];
        $phpmailer->Username = $_ENV['SMTP_USERNAME'];
        $phpmailer->Password = $_ENV['SMTP_PASSWORD'];
    }
    add_action('phpmailer_init', 'mailtrap');
}
