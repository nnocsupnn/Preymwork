<?php

defined('PATH') or die('Please contact service.');
// Global functions
use Symfony\Component\Dotenv\Dotenv;
use DebugBar\StandardDebugBar;

CONST DS = DIRECTORY_SEPARATOR;
$GLOBALS['debugbar'] = new StandardDebugBar;

function initEnvironmentConfig () {
    (new Dotenv)->load(dirname(dirname(__DIR__)) . DS . '.env');
    if (getenv('DEBUG') == 'true') {
        ini_set('display_errors', '1');
        error_reporting(E_ALL);
    }
}


function cleanPath ($view, $extension = '.html') {
    return str_replace('.', '/', $view) . $extension;
}

function staticFiles ($files = [], $type = 'js') {
    $string = "";
    switch ($type) {
        case 'js':
            foreach ($files as $k => $file) {
                if (is_array($file) && !empty($file)) {
                    $string .= "<script src='" . $file['src'] . "'></script>";
                } else {
                    $string .= "<script src='js/" . $file . "'></script>";
                }
            };
            break;

        case 'css':
            foreach ($files as $k => $file) {
                if (is_array($file) && !empty($file)) {
                    $string .= "<link rel='stylesheet' href='" . $file['src'] . "'/>";
                } else {
                    $string .= "<link rel='stylesheet' href='css/" . $file . "'/>";
                }
            };
            break;
    }

    return $string ? $string : "";
}


function debugbar($msg = null, $type = 'messages') {
    $renderer = $GLOBALS['debugbar']->getJavascriptRenderer();
    if (getenv('DEBUG') == 'true') {
        return [
            'head' => "
                <link rel=\"stylesheet\" type=\"text/css\" href=\"/css/debugbar/font-awesome.min.css\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"/css/debugbar/github.css\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"/css/debugbar/debugbar.css\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"/css/debugbar/widgets.css\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"/css/debugbar/openhandler.css\">
                <script type=\"text/javascript\" src=\"/js/debugbar/jquery.min.js\"></script>
                <script type=\"text/javascript\" src=\"/js/debugbar/highlight.pack.js\"></script>
                <script type=\"text/javascript\" src=\"/js/debugbar/debugbar.js\"></script>
                <script type=\"text/javascript\" src=\"/js/debugbar/widgets.js\"></script>
                <script type=\"text/javascript\" src=\"/js/debugbar/openhandler.js\"></script>",
            'footer' => $renderer->render()
        ];
    } else {
        return [];
    }
}


function validateMethod ($request, $required) {
    if (!in_array($required, [$request['REQUEST_METHOD']])) return false;
    return true;
}
