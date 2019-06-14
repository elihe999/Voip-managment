<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FileControl extends CI_Controller {

    public function index()
    {
        Header("Location:/index");
    }

    private function list_dir($dir)
    {
        $result = array();
        if (is_dir($dir))
        {
            $file_dir = scandir($dir);
            foreach($file_dir as $file)
            {
                if ($file == '.' || $file == '..')
                {
                    continue;
                }
                else if (is_dir($dir.'/'.$file))
                {
                    $result = array_merge($result, list_dir($dir.'/'.$file.'/'));
                }
                else
                {
                    array_push($result, $dir.'/'.$file);
                }
            }
        }
        return $result;
    }

    /**
     * @api {post} /FileControl/download/:folder Download folder as Zip
     * @apiName Download zip
     * @apiParam {String} folder Target result folder
     * @apiGroup User
     * @apiVersion 0.0.1
     * 
     * @apiError TargetNotFound The target folder was not found
     * @apiErrorExample {json} Error-Response
     * HTTP/1.1 404 Not Found
     *  {"reason":"Not a folder"}
     */
    public function download()
    {
        $this->load->library('zip');
        // $name = "/var/www/dphp/baphp/public/History/ylhe/2019/06/11/suite_153957/Attend_transfer@1/1/";
        $name = $this->input->get('fld');
        // var_dump($name);exit();
        $datalist = $this->list_dir($name);
        
        // CI memory exhausted
        if (is_dir($name))
        {
            foreach ($datalist as $filename)
            {
                $this->zip->read_file($filename);
            }
            $this->zip->download(strval(date('m_d')).'result.zip');
        }
        else
        {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('reason' => 'Not a folder')));
        }
    }

}
