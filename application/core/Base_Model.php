<?php

class Base_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return 'test';
    }
}
