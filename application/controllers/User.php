<?php

class User extends Base_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('user_service');
    }

    public function index()
    {
        echo $this->user_service->index();
    }
}
