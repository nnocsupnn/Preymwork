<?php


namespace App\Kernel\Libraries;

use App\Kernel\Interfaces\View as ViewInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View implements ViewInterface
{
    protected $twig;
    private $out;

    public function __construct()
    {
        $loader = new FilesystemLoader(PATH);
        $is_caching = [];
        if (getenv('TWIG_CACHING') == 'true') $is_caching = [
            'cache' => '../cache',
        ];

        $this->twig = new Environment($loader, $is_caching);
        return $this;
    }

    public function render($file, $data = [])
    {
        if (!file_exists(PATH . DS . cleanPath($file))) {
            $this->twig->render(cleanPath('errors.404'), []);
        }
        
        $this->out = $this->twig->render(cleanPath($file), $data);

        return $this;
    }

    public function header($headers = [])
    {
        foreach ($headers as $header => $value) header($header, $value);
        return $this;
    }

    public function show()
    {
        print($this->out);
        exit;
    }
}