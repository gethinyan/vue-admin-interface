<?php

class Base_Service
{
    public function __construct()
    {
    }

    public function __get($key)
    {
        return get_instance()->$key;
    }
}
