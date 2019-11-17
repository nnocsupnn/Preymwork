<?php

defined('PATH') or die('Please contact service.');
// Global functions
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment as TwigInstance;
use Twig\Loader\FilesystemLoader;

CONST DS = DIRECTORY_SEPARATOR;


function initEnvironmentConfig () {
    (new Dotenv)->load(dirname(dirname(__DIR__)) . DS . '.env');
    if (getenv('DEBUG') == 'true') {
        ini_set('display_errors', '1');
        error_reporting(E_ALL);
    }
}

function twigInstance () {
    $loader = new FilesystemLoader(PATH);
    $is_caching = [];
    if (getenv('TWIG_CACHING') == 'true') $is_caching = [
        'cache' => '../cache',
    ];

    return new TwigInstance($loader, $is_caching);
}


function render ($file, $data = []) {
    if (!file_exists(PATH . DS . cleanPath($file))) {
        print(twigInstance()->render(cleanPath('errors.404'), []));
        exit;
    }

    $file = viewChecker($file, $data);
    $out = twigInstance()->render(cleanPath($file), $data);
    print($out);
    exit;
}


function cleanPath ($view, $extension = '.html') {
    return str_replace('.', '/', $view) . $extension;
}


function viewChecker($file, $data) {
    if (empty($data['js']) && !in_array($file, ['errors.404'])) {
        $file = cleanPath($file);
        $out = twigInstance()->render(cleanPath('errors.404'), $data);
        print($out);
        exit;
    } 

    return $file;
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
