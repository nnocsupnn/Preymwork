<?php


namespace App\Kernel\Interfaces;

interface View {
    public function render ($view, $data = []);
    public function header($headers = []);
    public function show();
}