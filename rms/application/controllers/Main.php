<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{

		$data["content"] = "main/home";
		$this->load->view('main/includes/template', $data);
	}
}

