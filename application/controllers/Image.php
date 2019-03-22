<?php

class Image extends Base_Controller
{
    /**
     * 图片上传
     */
    public function upload()
    {
        $strFolder = $this->generateFolderPath();

        $arrConfig['file_name'] = $this->generateFileName();
        // 文件上传路径
        $arrConfig['upload_path'] = $strFolder;
        // 允许上传的文件类型
        $arrConfig['allowed_types'] = 'gif|jpg|png|jpeg|doc|docx|pdf|txt|xls|xlsx|rar|zip|gz|bmp|html|ppt|pptx';
        // 文件上传允许的最大大小，单位KB
        $arrConfig['max_size'] = 21504;

        if (!file_exists($arrConfig['upload_path'])) {
            @mkdir($arrConfig['upload_path'], 0755, true);
        }

        $this->load->library('upload', $arrConfig);

        if (!$this->upload->do_upload('file')) {
            $arrData = ['error' => $this->upload->display_errors()];
            $intErrno = Statuscode::FAIL;
            log_message('error', 'upload image error . output:['.json_encode($arrData).']');
        } else {
            $arrUploadData = $this->upload->data();
            $arrData = [
                'url' => 'http://vue-admin.com/'.$strFolder.'/'.$arrUploadData['file_name'],
                'image_width' => $arrUploadData['image_width'],
                'image_height' => $arrUploadData['image_height'],
                'image_type' => $arrUploadData['image_type'],
            ];
            $intErrno = Statuscode::SUCCESS;
        }

        return $this->returnJson($intErrno, $arrData);
    }

    /**
     * 生成文件名
     */
    private function generateFileName()
    {
        $strRandomPost = random_int(10000, 99999);

        return time().$strRandomPost;
    }

    /**
     * 文件路径
     */
    private function generateFolderPath()
    {
        return './upload/'.date('Y/m/d');
    }
}
