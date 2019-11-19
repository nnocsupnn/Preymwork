<?php


namespace App\Kernel\Interfaces;
/**
 * Interface View
 * @package App\Kernel\Interfaces
 */
interface View {
    public function render ($view, $data = []);
    public function header($headers = []);
    public function viewChecker($file, $data = []);
    public function show();
}