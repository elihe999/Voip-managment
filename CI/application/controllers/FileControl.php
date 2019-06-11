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

    public function download()
    {
        $this->load->library('zip');
        $name = "/var/www/dphp/baphp/public/History/ylhe/2019/06/11/suite_153957/Attend_transfer@1/1/";
        // $name = $_POST('fld');
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
    }

}
