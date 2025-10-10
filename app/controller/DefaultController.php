<?php

namespace Paprika\controller;

class DefaultController extends BaseController
{
    public function show(): void {}
    public function create(): void {}
    public function do_create($data): void {}
    public function update($id): void {}
    public function do_update($data): void {}
    public function delete($id): void {}
    public function do_delete($id): void {}

    public function index() {
        echo "Bienvenue sur la page par défaut !";
    }

    public function detail($id): void
    {
        // TODO: Implement detail() method.
    }
}