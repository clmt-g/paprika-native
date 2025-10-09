<?php

namespace Paprika\controller;

class DefaultController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        // ...
    }

    public function index()
    {

    }

    public function show($id): string
    {
        // TODO: Implement show() method.
        return '';
    }

    public function create(): string
    {
        // TODO: Implement create() method.
        return '';
    }

    public function do_create($data): void
    {
        // TODO: Implement do_create() method.
    }

    public function update($id): void
    {
        // TODO: Implement update() method.
    }

    public function do_update($data): void
    {
        // TODO: Implement do_update() method.
    }

    public function delete($id): void
    {
        // TODO: Implement delete() method.
    }

    public function do_delete($id): void
    {
        // TODO: Implement do_delete() method.
    }
}