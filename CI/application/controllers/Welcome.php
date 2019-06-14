<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct()
    {
        $this->need_login = false;
        parent::__construct();
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		Header("Location:/index"); 
	}

	/**
	 * @api {get} /Welcome/simplechart Get fail chart
	 * @apiName GetSimpleChart
	 * @apiGroup View
	 * 
	 * @apiSuccess {String} failnum String of the failed case number
	 * @apiSuccess {String} totalnum String of the total case
	 * @apiSuccess {String} time String of timestamp -unix
	 * 
	 * @apiSuccessExample Success-Response:
	 * 	HTTP/1.1 200 OK 
	 * 	{
     *      "list": [
	 * 		    {"failnum":"1","totalnum":"2","time":"1559786074"},
	 * 		    {"failnum":"0","totalnum":"1","time":"1559786715"},
	 * 		    {"failnum":"1","totalnum":"1","time":"1560158422"},
	 * 		    {"failnum":"1","totalnum":"3","time":"1560238799"}
     *      ]
	 * 	}
	 *
	 * @apiVersion 0.0.1
	 */
	public function simplechart()
	{
		// require 'vendor/autoload.php';
		$this->load->database();
		$seven_days_stamp = time() - (7 * 24 * 60 * 60);
		$sql = "SELECT failnum, totalnum, time FROM suite_history_tb WHERE time>" . $seven_days_stamp . ";";
		$query = $this->db->query($sql);
		// dump($query->result('array'));
		header("Access-Control-Allow-Origin: * "); 
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('list'=>$query->result('array'))));
	}

	/**
	 * @api {post} /Welcome/check_userlist/:name/:pass Get user list from mysql
	 * @apiName CheckUserList
	 * @apiGroup User
	 * 
     * @apiParam (User) name
     * @apiParam (User) pass
     * @apiDescription Set session with user name, also create the setting file
     * 
     * @apiError Unauthorized The user or password is wrong
     * @apiError Bad_Request The user or password is wrong
     * 
	 * @apiVersion 0.0.1
	 */
	public function check_userlist()
    {
        $login_success = FALSE;													// defalut
        $request_target = $this->input->post('name', TRUE);
        $password = $this->input->post('pass', TRUE);
        $this->load->database();
        $sql = 'select * from user_tb where username="' . $request_target . '" and password="' . $password . '"';
        $data = $this->db->query($sql)->result('array');
        if (false == $data)
        {
            echo $request_target . "FAIL";
            header("HTTP/1.1 401 Unauthorized");
            exit();
        }
        $login_success = FALSE;
        if (count($data[0], COUNT_NORMAL) > 0)
        {
            $login_success = TRUE;
        }
        $this->config->load('ate_setting', TRUE);
        $base_setting = $this->config->item('ate_setting');
        //todo
        $dir = $base_setting['base_setting']['sipp_log'] . '/' . $base_setting['base_setting']['neo_user'] . '/' . $request_target;
        $setting_file = $dir . '/ate_setting';
        $sip_setting_file = $dir . '/settings';
        if ( !file_exists($dir) )
        {
            mkdir ($dir, 0777, true);
        }
        if ( !file_exists($setting_file) )
        {
            touch ($setting_file);
            @chmod ($setting_file, 0777);
            $this->init_setting($setting_file, 'ate_setting');
        }
        if ( !file_exists($sip_setting_file) )
        {
            touch ($sip_setting_file);
            @chmod ($sip_setting_file, 0777);
            $this->init_setting($sip_setting_file, 'settings');
        }
        if ( TRUE == $login_success )                                   // Useless
        {
            // $this->session->set_userdata('user', $request_target);
            $_SESSION['user'] = $request_target;
            header("HTTP/1.1 200 OK");
            echo $_SESSION['user'];
        }
        else
        {
            unset($_SESSION['user']);
            header("HTTP/1.1 400 Bad Request");
            echo "Failed";
        }
    }

	/**
	 * @api {get} /Welcome/signup_user/:name/:pass Signup
	 * @apiName signup
	 * @apiDescription Sign up new user if it is not exist
	 * @apiGroup User
	 * 
	 * @apiParam {String} name Username
	 * @apiParam {String} pass User Password
	 * @apiVersion 0.0.1
	 * 
	 * @apiSuccess (200) {String[]} result Answer from server
	 * @apiSuccess (200) {String[]} ask Answer from server
	 */
    public function signup_user()
    {
        $request_name = $this->input->get('name');
        $request_pass = $this->input->get('pass');
        // setting
        $this->load->database();
        $this->config->load('ate_setting', TRUE);
        $base_setting = $this->config->item('ate_setting');
        $sql = 'select * from user_tb where username="' . $request_name . '"';
        $data = $this->db->query($sql)->result('array');
        // always build dir
        $dir = $base_setting['base_setting']['sipp_log'] . '/' . $base_setting['base_setting']['neo_user'] . '/' . $request_name;
        $setting_file = $dir . '/ate_setting';
        $sip_setting_file = $dir . '/settings';
        $custom_class_file = $dir . '/case_list.txt';
        if ( !file_exists($dir) )
        {
            // mkdir ($dir, 0777, true);
            mkdir ($dir);
            chmod ($dir, 0777);
        }
        if ( !file_exists($setting_file) )
        {
            touch ($setting_file);
            @chmod ($setting_file, 0777);
            $this->init_setting($setting_file, 'ate_setting');
        }
        if ( !file_exists($sip_setting_file) )
        {
            touch ($sip_setting_file);
            @chmod ($sip_setting_file, 0777);
            $this->init_setting($sip_setting_file, 'settings');
        }
        if ( !file_exists($custom_class_file) )
        {
            touch ($custom_class_file);
            @chmod ($custom_class_file, 0777);
        }
        if ($data != Null)
        {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('result' => 'exist')));
        }
        else
        {
            $insert_sql = 'INSERT INTO user_tb (username, password) VALUES ("' . $request_name . '", "' . $request_pass . '");';
            $data = $this->db->query($insert_sql);
            header("HTTP/1.1 200 OK");
            $this->output->set_content_type('application/json')->set_output(json_encode(array('result' => 'ok', 'ask' => $data)));
        }
    }

    public function clean()
    {
        unset($_SESSION['user']);
    }

    // Create setting file
    public function init_setting($setting_file, $type)
    {
        $fp = fopen($setting_file, 'w');
        $this->config->load('ate_setting', TRUE);
        $init_set = $this->config->item('ate_setting');
        if ( 'settings' == $type )
        {
            $str = $init_set['init_file_setting']['interface'] . "\n";
            fwrite($fp, $str);
            $str = $init_set['init_file_setting']['timeout'] . "\n";
            fwrite($fp, $str);
            $str = $init_set['init_file_setting']['server'] . "\n";
            fwrite($fp, $str);
            $str = $init_set['init_file_setting']['serverUrl'] . "\n";
            fwrite($fp, $str);
        }
        else if ( 'ate_setting' == $type )
        {
            $fp = fopen($setting_file, 'w');
            fwrite($fp, "");
        }
        fclose($fp);
    }

    // set language on cookie
    // ignore this function, the VUE i18n will process the language now
    public function set_lang()
    {
        $type = $this->input->get('lang');
        $this->load->helper('cookie');
        if ( $type == "chinese")
        {
            if ( isset($_COOKIE['language']) && ($_COOKIE['language'] !== "chinese") )
            {
                setcookie('language', 'chinese', time()+3600*12, '/');
            }
            else
            {
                setcookie('language', 'chinese', time()+3600*12, '/');
            }
        }
        else if ( $type == "english")
        {
            if ( isset($_COOKIE['language']) && ($_COOKIE['language'] !== "english") )
            {
                setcookie('language', 'english', time()+3600*12, '/');
            }
            else
            {
                setcookie('language', 'english', time()+3600*12, '/');
            }
        }
        else
        {
            echo "error";
        }
    }
}
