<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {

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
	 * @api {get} /Message/sendEmail Send Email
	 * @apiName SendEmail
	 * @apiGroup User
	 * 
	 * @apiVersion 0.0.1
	 * 
	 */
	public function sendEmail()
	{
		$this->load->library('mailer');
		$this->mailer->sendMail();
	}

	public function updateBroadcast()
	{

	}
}
