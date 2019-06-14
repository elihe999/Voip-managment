<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReturnView extends CI_Controller {

    // no login is fine
    public function __construct()
    {
        $this->need_login = FALSE;
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
	 * @api {get} /ReturnView/get_page_class/type/user/page/limit/rowtitle/order/:keyword Get page
	 * @apiName Getpagintor
	 * @apiGroup View
	 * 
     * @apiDescription IT IS ROUTER PARAM
     * @apiParam {String} type Test suite or Test case (ROUTER)
     * @apiParam {String} user User name (ROUTER)
     * @apiParam {String} page Page number (ROUTER)
     * @apiParam {String} limit Number of cases for each page (ROUTER)
     * @apiParam {String} rowtitle Row title on MySql table (ROUTER)
     * @apiParam {String} order Order the data by ASC or DESC (ROUTER)
     * @apiParam {String} [keyword] Keyword to search on mysql (ROUTER)
     * @apiParamExample {String} Request-Example:
     *  {
     *      /case/ylhe/1/10/name/0
     *  }
     * 
	 * @apiSuccess {String} name String of the case name
	 * @apiSuccess {String} numc String of the number
	 * @apiSuccess {String} loopc String of the loop number
	 * @apiSuccess {String} result String of the result
	 * @apiSuccess {String} path String of the folder
	 * @apiSuccess {String} time String of the time stamp hh:mm:ss:mms
	 * @apiSuccess {String} date String of the date -unix
	 * @apiSuccess {String} fail_res String of the failed reason
	 * @apiSuccess {String} fail_act String of the failed action
	 * @apiSuccess {String} username String of the user name who run the test case
	 * 
	 * @apiSuccessExample Success-Response:
	 * 	HTTP/1.1 200 OK 
	 *  {
     *      "list":[{
     *          "name": "Attend_transfer",
	 *	        "numc": "1",
	 *	        "loopc": "1",
	 *	        "result": "FAILED",
	 *	        "path": "..\/History\/ylhe\/2019\/05\/09\/suite_182854\/",
	 *	        "time": "00:00:54:958",
	 *	        "date": "1557397789",
	 *	        "fail_res": "test",
	 *	        "fail_act": "trs",
	 *	        "username": "ylhe"
     *      },{
     *          "name": "Attend_transfer",
	 *	        "numc": "1",
	 *	        "loopc": "2",
	 *	        "result": "FAILED",
	 *	        "path": "..\/History\/ylhe\/2019\/05\/09\/suite_182854\/",
	 *	        "time": "00:00:54:958",
	 *	        "date": "1557397789",
	 *	        "fail_res": "test",
	 *	        "fail_act": "trs",
	 *	        "username": "ylhe"
     *      }]
     *  }
     * 
     * @apiError ParameterNotFound The parameter was not found.
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "error":"router parameter error"
     * }
	 * @apiVersion 0.0.2
	 */
	public function get_page_class()
    {
        /* **
         * type     :   case / suite
         * default  :   10      
         * * **/
        $per_page = 10;
        $error_array = array("error" => "router parameter error");
        $failed_flag = false;
        /* **
         * filter   : value, page
         * **/
        if ( null !== $this->uri->segment(6) && null !== $this->uri->segment(3) && 
                null !== $this->uri->segment(4) && null !== $this->uri->segment(5) )
        {
            $per_page = $this->uri->segment(6);
            $db_type = $this->uri->segment(3);
            $username = $this->uri->segment(4);
            $page_number = $this->uri->segment(5);
        }
        else
        {
            $failed_flag = true;
        }

        $order_list = null;
        $filter_list = isset($_GET['filter']) ? $_GET['filter'] : null;
        if ( null !== $this->uri->segment(7) )
        {
            $order_list = $this->uri->segment(7);
            if ($db_type == "case")
            {
                $case_key = array("name", "numc", "loopc", "result", "path", "time", "date", "fail_res", "fail_act", "username");
                if (!in_array($order_list, $case_key))
                    $failed_flag = true;
            }
            else if ($db_type == "suite")
            {
                $suite_key = array("path", "passnum", "failnum", "warnnum", "totalnum", "time", "username");
                if (!in_array($order_list, $suite_key))
                    $failed_flag = true;
            }
        }
        else
        {
            $failed_flag = true;
        }

        if ($failed_flag)
        {
            header("HTTP/1.1 404 Not Found");
            $this->output->set_content_type('application/json')->set_output(json_encode($error_array));
            exit(json_encode($error_array));
        }

        $search_value = $this->uri->segment(9);
        if ($order_list != null)
        {
            if ('0' === $this->uri->segment(8))
                $order_sql_key = 'ASC';
            else if ('1' === $this->url->segment(8))
                $order_sql_key = 'DESC';
            else if ($this->uri->segment(9) === null)
            {
                $order_sql_key = "ASC";
                $search_value = $this->uri->segment(8);
            }
            else
                $order_sql_key = "ASC";
        }
        else
        {
            $order_sql_key = 'DESC';
        }

        $this->config->load('ate_setting', TRUE);
        $base_setting = $this->config->item('ate_setting');
        $this->load->database();                                                    // desc table name
        $start_page = ($page_number - 1) * $per_page;
        $limit_sql = ' LIMIT ' . $start_page . ',' . $per_page;                      // select type // change sql filter // search keyword
        if ( $db_type == 'case' )
        {
            $db_name = $base_setting['base_setting']['case_history'];
            $order_sql = ' ORDER BY ' . $order_list . " " . $order_sql_key;
            if ( null !== $this->uri->segment(9) )
            {
                $search_key = '"%' . $search_value . '%"';
                if ( null == $filter_list )
                {
                    $search_sql =  ' AND ' . '(name LIKE '. $search_key . ' OR ' . 'loopc LIKE "' . $search_value . '" OR ' . 'numc LIKE "' . $search_value . '" OR ' . 'result LIKE ' . $search_key . ' OR ' . 'path LIKE ' . $search_key . ' OR ' . ' fail_res LIKE ' . $search_key . ' OR ' . ' fail_act LIKE ' . $search_key . ") ";
                    $where_sql = ' WHERE username="' . $username . '" ' . $search_sql . " " . $order_sql . $limit_sql;
                    if ($username == "admin")
                    {
                        $where_sql = $search_sql . $limit_sql;
                    }
                }
                else
                {
                    $search_sql =  ' AND ' . '(name LIKE '. $search_key . ' OR ' . 'loopc LIKE "' . $search_value . '" OR ' . 'numc LIKE "' . $search_value . '" OR ' . 'result LIKE ' . $search_key . ' OR ' . 'path LIKE ' . $search_key . ' OR ' . ' fail_res LIKE ' . $search_key . ' OR ' . ' fail_act LIKE ' . $search_key . ") ";
                    $where_sql = ' WHERE username="' . $username . '" ' . $search_sql . " " . $order_sql . $limit_sql;
                    if ($username == "admin")
                    {
                        $where_sql = $search_sql . $limit_sql;
                    }
                }
            }
            else
            {
                $where_sql = ' where username="' . $username . '" ' . $order_sql . $limit_sql;
                if ($username == "admin")
                {
                    $where_sql = $order_sql . $limit_sql;
                }
            }
            $sql_search = 'select * from ' . $db_name . $where_sql;
            $result = array('list'=>$this->db->query($sql_search)->result('array'));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
        else if ( $db_type == 'suite')
        {
            $db_name = $base_setting['base_setting']['suite_history'];
            $order_sql = ' ORDER BY ' . $order_list . " " . $order_sql_key;                         // sql order
            $user_where_sql = ' WHERE username="' . $username . '"';
            $sql_search = 'select path, passnum, totalnum from ' . $db_name . $user_where_sql;
            $result = $this->db->query($sql_search)->result('array');
            if ( null !== $this->uri->segment(9) )
            {
                $search_key = '"%' . $search_value . '%"';
                if ( null == $filter_list )
                {
                    $search_sql =  ' AND ' . '(path LIKE '. $search_key . ' or ' . 'passnum LIKE "' . $search_value . '" or ' . 'failnum LIKE "' . $search_value . '" or ' . 'warnnum LIKE "' . $search_value . '" or ' . ' totalnum like "' . $search_value . '") ';
                    $where_sql = ' where username="' . $username . '" ' . $search_sql . " " . $order_sql . $limit_sql;
                    if ($username == "admin")
                    {
                        $where_sql = $search_sql . $limit_sql;
                    }
                }
                else
                {
                    $search_sql =  ' AND ' . '(path LIKE '. $search_key . ' or ' . 'passnum LIKE "' . $search_value . '" or ' . 'failnum LIKE "' . $search_value . '" or ' . 'warnnum LIKE "' . $search_value . '" or ' . ' totalnum LIKE "' . $search_value . '") ';
                    $where_sql = ' where username="' . $username . '" ' . $search_sql . " " . $order_sql . $limit_sql;
                    if ($username == "admin")
                    {
                        $where_sql = $search_sql . $limit_sql;
                    }
                }
            }
            else
            {
                $where_sql = ' where username="' . $username . '" ' . $order_sql . $limit_sql;
                if ($username == "admin")
                {
                    $where_sql =  $order_sql . $limit_sql;
                }
            }
            $sql_search = 'select * from ' . $db_name . $where_sql;
            $result = array('list'=>$this->db->query($sql_search)->result('array'));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    /**
	 * @api {get} /ReturnView/get_local_case/case/suite_year/suite_mon/suite_day/suite/suite_num/loop/user Get case result
	 * @apiName GetCaseDetail
     * @apiDescription Return the local test case result on JSON, inline function :read_result()
	 * @apiGroup View
	 * 
     * @apiParam {String} case Case name
     * @apiParam {String} suite_year Year folder
     * @apiParam {String} suite_mon Mouth folder
     * @apiParam {String} suite_day Day folder
     * @apiParam {String} suite Suitename
     * @apiParam {String} suite_num Number inside Suite folder
     * @apiParam {String} loop loop number
     * @apiParam {String} user User name
     * 
     * @apiSuccess {json} list type/desc/info/details/status/time
     * @apiSuccess {String[]} type String of type, tell the type of result
	 * @apiSuccess {String[]} desc String of the description, depend on sipp
	 * @apiSuccess {String[]} info String of the infomation, depend on sipp
	 * @apiSuccess {String[]} details String of the details, depend on sipp
	 * @apiSuccess {String[]} status String of the status, OKAY/WARNING/FAILED
	 * @apiSuccess {String[]} time String of the timestamp
     * @apiSuccess {boolen} response Read file: success or failed
	 * 
     * @apiSuccessExample Success-Response:
	 * 	HTTP/1.1 200 OK 
	 *  {
     *      "list":[
     *          {
     *              "type":"Run",
     *              "desc":"",
     *              "info":"script ->  \"..\/lib\/initialize\" deviceList",
     *              "details":"",
     *              "status":"OKAY",
     *              "time":"00:00:00:001"
     *          },{
     *              "type":"API",
     *              "desc":"",
     *              "info":"temp -> Init",
     *              "details":"http:\/\/192.168.92.30\/cgi-bin\/api-request_init_phone_status?passcode=123456",
     *              "status":"OKAY",
     *              "time":"00:00:00:138"
     *          },{
     *              "type":"API",
     *              "desc":"",
     *              "info":"temp -> Init",
     *              "details":"http:\/\/192.168.92.80\/cgi-bin\/api-request_init_phone_status?passcode=123456",
     *              "status":"OKAY",
     *              "time":"00:00:00:225"
     *          }
     *      ],
     *      "response": true
     *  }
     * 
     * @apiError FileNotFound The case folder was not found
	 * @apiErrorExample {json} Error-Response
     *  HTTP/1.1 404 Not Found
     *  {
     *      "error": "FileNotFound"
     *  }
     * @apiVersion 0.0.2
	 */

    public function get_local_case()
    {
        $data['case'] = $this->uri->segment(3);
        $data['suite_year'] = $this->uri->segment(4);
        $data['suite_mon'] = $this->uri->segment(5);
        $data['suite_day'] = $this->uri->segment(6);
        $data['suite'] = $this->uri->segment(7);
        $data['suite_num'] = $this->uri->segment(8);
        $data['loop'] = $this->uri->segment(9);
        $data['user'] = $this->uri->segment(10);
        $this->config->load('ate_setting', TRUE);
        $base_setting = $this->config->item('ate_setting');
        $history_path = $base_setting['base_setting']['wwwDir'] . '/public/' . $base_setting['base_setting']['sipp_history'];
        $case_path = $history_path . "/" . $data['user'] . "/" . $data['suite_year'] . "/" . $data['suite_mon'] . "/" . $data['suite_day'] . "/" . $data['suite'] . "/" . $data['case'] . "@" . $data['suite_num'] . "/" . $data['loop'];
        if ( !is_dir($case_path) && !file_exist($case_path."/Result"))
        {
            header("HTTP/1.1 404 Not Found");
            $result = array("error"=>"fileNotExist");
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
        else
        {
            $target_file = $case_path . "/Result";
            $suite_path = '/History/' . $data['user'] . '/' . $data['suite_year'] . "/" . $data['suite_mon'] . "/" . $data['suite_day'] . '/' . $data['suite'];
            $this->read_result($target_file, $suite_path, $data['case'], $data['suite_num'], $data['loop']);
        }
    }

    private function read_result($target_file, $suite_path, $casename, $suitenumber, $loopnumber)
    {
        $fp = @fopen($target_file, "r");
        $str = "";
        $table_msg = array();
        if ($fp)
        {
            while ($str = fgets($fp, 1024))
            {
                if ($str == "\n")
                    break;
                if ( strpos($str, "PASS") !== 0 && strpos($str, 'Pause') !== 0 && strpos($str, 'FAILED') !== 0 )
                {
                    $json_obj = json_decode($str);
                    if ($json_obj->type == "Screenshot")
                    {
                        $web_access = '/public';
                        $img_path = $web_access . $suite_path . '/' . $casename . '@' . $suitenumber . '/' . $loopnumber . '/' . $json_obj->details;
                        if ($json_obj->desc == "")
                            $json_obj = array("type"=>"Screenshot", "desc"=>"", "info"=>$img_path, "time"=>$json_obj->time, "status"=>$json_obj->status, "imgdesc"=>$json_obj->info);
                        else
                            $json_obj = array("type"=>"Screenshot", "desc"=>$json_obj->desc, "info"=>$img_path, "time"=>$json_obj->time, "status"=>$json_obj->status, "imgdesc"=>$json_obj->info);
                        array_push($table_msg, $json_obj);
                    }
                    else
                    {
                        array_push($table_msg, $json_obj);
                    }
                }
                else if ( strpos($str, "PASS") == 0 || strpos($str, "FAILED") == 0 || strpos($str, "Pause") == 0 )
                {
                    $str_arr = explode("\n", $str);
                    $str_arr = explode(" ", $str_arr[0]);
                    if ( $str_arr[0] == "PASS" || $str_arr[0] == "FAILED")
                    {
                        $json_obj = array("type"=>"RESULT", "result"=>$str_arr[0], "time"=>$str_arr[1]);
                        array_push($table_msg, $json_obj);
                    }
                    else
                    {
                        $json_obj = array("type"=>$str_arr[0], "delay"=>$str_arr[1], "start"=>$str_arr[2], "time"=>$str_arr[3]);
                        array_push($table_msg, $json_obj);
                    }
                }
            }
            fclose($fp);
            $this->output->set_content_type('application/json')->set_output(json_encode(array("list" => $table_msg, "response" => true)));
        }
        else
        {
            $this->output->set_content_type('application/json')->set_output(json_encode(array("list" => [], "response" => false)));
        }
    }
}
