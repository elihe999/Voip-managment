<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	 * @api {get} /ReturnView/page_class/:type/:user/:page/:limit/:keyword/:order Get fail chart
	 * @apiName GetSimpleChart
	 * @apiGroup View
	 * 
     * @apiParam {String} type Test suite or Test case
     * @apiParam {String} user User name
     * @apiParam {String} page Page number
     * @apiParam {String} keyword Keyword to search on mysql
     * @apiParam {String} order Order the data
     * 
	 * @apiSuccess {String} failnum String of the failed case number
	 * @apiSuccess {String} totalnum String of the total case
	 * @apiSuccess {String} time String of timestamp -unix
	 * 
	 * @apiSuccessExample Success-Response:
	 * 	HTTP/1.1 200 OK 
	 * 	{"list":[
	 * 		{"failnum":"1","totalnum":"2","time":"1559786074"},
	 * 		{"failnum":"0","totalnum":"1","time":"1559786715"},
	 * 		{"failnum":"1","totalnum":"1","time":"1560158422"},
	 * 		{"failnum":"1","totalnum":"3","time":"1560238799"}]
	 * 	}
	 *
	 * @apiVersion 0.0.1
	 */
	public function page_class()
    {
        /* **
         * type     :   case / suite
         * default  :   10      
         * * **/
        $per_page = 10;
        $db_type = $this->uri->segment(3);
        $username = $this->uri->segment(4);
        $page_number = $this->uri->segment(5);
        /* **
         * filter   : value, page
         * **/
        if ( null !== $this->uri->segment(6) )
        {
            $per_page = $this->uri->segment(6);
        }
        $order_list = null;
        $filter_list = isset($_GET['filter']) ? $_GET['filter'] : null;
        if ( null !== $this->uri->segment(7) )
        {
            $order_list = $this->uri->segment(7);
        }

        if ($order_list != null)
        {

            $order_sql_key = $this->uri->segment(8) == '0' ? 'ASC' : 'DESC';
        }
        else
        {
            $order_sql_key = 'DESC';
        }
        //
        $this->config->load('ate_setting', TRUE);
        $base_setting = $this->config->item('ate_setting');
        // desc table name
        $this->load->database();
        $start_page = ($page_number - 1) * $per_page;
        // select type // change sql filter // search keyword
        $limit_sql = ' LIMIT ' . $start_page . ',' . $per_page;
        if ( $db_type == 'case' )
        {
            $db_name = $base_setting['base_setting']['case_history'];
            $order_sql = ' ORDER BY ' . $order_list . " " . $order_sql_key;
            if ( null !== $this->uri->segment(9) )
            {
                $search_value = $this->uri->segment(9);
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
            $result = $this->db->query($sql_search)->result('array');
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
                $search_value = $this->uri->segment(9);
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
            $result = $this->db->query($sql_search)->result('array');
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
}
