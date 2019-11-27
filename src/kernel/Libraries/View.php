<?php

namespace App\Kernel\Libraries;

use App\Kernel\Interfaces\View as ViewInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use App\Kernel\Libraries\DebugingBar;

/**
 * Class View
 * @package App\Kernel\Libraries
 */
class View implements ViewInterface
{
    /**
     * @var Environment
     */
    protected $twig;
    private $out;
    private $debug;
    private $headers = [
        'Content-Type' => 'text/html'
    ];


    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->debug = new DebugingBar();
        $loader = new FilesystemLoader(PATH);
        $is_caching = [];
        if (getenv('TWIG_CACHING') == 'true') $is_caching = [
            'cache' => ROOT_PATH . '/cache',
        ];

        $this->twig = new Environment($loader, $is_caching);
        return $this;
    }


    /**
     * @param $file
     * @param array $data
     * @return $this
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render($file, $data = []):?self
    {
        $data['debugbar'] =  $this->debug->init();
        if (!file_exists(PATH . DS . cleanPath($file))) {
            $this->twig->render(cleanPath('errors.404'), []);
        }

        $file = $this->viewChecker($file, $data);
        $this->out = $this->twig->render(cleanPath($file), $data);
        return $this;
    }


    /**
     * @param array $headers
     * @return $this
     */
    public function header($headers = []):?self
    {
        if (empty($headers)) return $this;
        foreach ($headers as $header => $value) {
            if ($this->headers[$header]) {
                $this->headers[$header] = $value;
                header("$header: $value");
            }
        }

        return $this;
    }


    /**
     * @param $file
     * @param array $data
     * @return string
     */
    public function viewChecker($file, $data = []):string {
        if (!file_exists(PATH . DS . $file . '.html')) {
            $file = cleanPath($file);
            try {
                $out = $this->twig->render(cleanPath('errors.404'), $data);
                $this->show($out);
            } catch (LoaderError $e) {
                $this->debug->console($e->getMessage(), 'error');
            } catch (RuntimeError $e) {
                $this->debug->console($e->getMessage(), 'error');
            } catch (SyntaxError $e) {
                $this->debug->console($e->getMessage(), 'error');
            }
        }

        return $file;
    }


    /**
     * Print
     */
    public function show($out = null):void
    {
        if ($out == null) {
            print($this->out);
        } else {
            print($out);
        }
        exit;
    }
}