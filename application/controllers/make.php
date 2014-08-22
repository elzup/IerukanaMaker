<?php

class Make extends CI_Controller
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
		$meta->setup_make();
		$this->load->view('head', array('meta' => $meta, 'user' => $user));
		$this->load->view('bodywrapper_head');
		$this->load->view('navbar');
		$this->load->view('title', array('title' => $meta->get_title()));
		$this->load->view('makepage', array('user', $user));
		$this->load->view('bodywrapper_foot');
		$this->load->view('foot');
	}

	public function post() {
		echo 'header("Content-type: text/plain; charset=utf-8");';
		$post = $this->input->post();
		$game = new Gameobj();
		$game->name = $post['game_name'];
		$game->description = $post['game_description'];
		$game->name = $post['game_name'];
		// TODO: game name check
		// TODO: value rechecks
		var_dump($post);
	}

}

