<?php

class Base_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function returnJson($statuscode, $data = [], $message = false)
    {
        $message = $message ? $message : StatusCode::getMessage($statuscode);
        $arr = [
            'statuscode' => $statuscode,
            'message' => $message,
            'data' => $data,
        ];

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($arr));
    }

    public function getGetData($param = '')
    {
        $data = $this->input->get();
        if ($param) {
            return $data[$param];
        }

        return $data;
    }

    public function getPostData($param = '')
    {
        $data__ = file_get_contents('php://input');
        $data = json_decode($data__, true);
        if (0 == count($data)) {
            $data = $this->input->post();
        }
        if ($param) {
            $data = $data[$param];
        }

        return $data;
    }

    public function getPutData($param = '')
    {
        $data__ = file_get_contents('php://input');
        $data = json_decode($data__, true);
        if (0 == count($data)) {
            $data = $this->input->post();
        }
        if ($param) {
            $data = $data[$param];
        }

        return $data;
    }

    public function getDeleteData($param = '')
    {
        $data = $this->input->get();
        if ($param) {
            $data = $data[$param];
        }

        return $data;
    }
}
