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

	public function return_test()
	{
		// require 'vendor/autoload.php';
		$this->load->database();
		$seven_days_stamp = time() - (7 * 24 * 60 * 60);
		$sql = "SELECT failnum, totalnum, time FROM suite_history_tb WHERE time>" . $seven_days_stamp . ";";
		$query = $this->db->query($sql);
		// dump($query->result('array'));
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('list'=>$query->result('array'))));
	}
}
