<?php

namespace Paprika\controller;

/**
 *
 */
abstract class BaseController
{

    public function __construct()
    {

    }

    public abstract function show($id) : void ;
    public abstract function create() : string ;
    public abstract function do_create($data) : void ;
    public abstract function update($id) : void ;
    public abstract function do_update($data) : void ;
    public abstract function delete($id) : void ;
    public abstract function do_delete($id) : void ;
}