<?php

namespace Paprika\controller;

use Paprika\utils\Renderer;

class DefaultController extends BaseController
{
    public function index() : void {
        echo Renderer::render('home');
    }

    public function show(): void {}
    public function create(): void {}
    public function do_create($data): void {}
    public function update($id): void {}
    public function do_update($data): void {}
    public function delete($id): void {}
    public function do_delete($id): void {}
    public function detail($id): void {}
}