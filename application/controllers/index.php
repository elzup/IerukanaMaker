<?php

class Index extends CI_Controller
{

	/** @var User_model */
	public $user;
	/** @var Game_model */
	public $game;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model', 'user', TRUE);
		$this->load->model('Game_model', 'game', TRUE);
	}

	public function index()
	{
		$user = $this->user->get_main_user();

		$meta = new Metaobj();
		$meta->setup_top();
		$this->load->view('head', array('meta' => $meta, 'user' => $user));
		$this->load->view('bodywrapper_head');
		$this->load->view('navbar');
		$this->load->view('toppage');
		$this->load->view('bodywrapper_foot');
		$this->load->view('foot');
	}

}

