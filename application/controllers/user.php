<?php

class User extends CI_Controller
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
		$games_maked = $this->game->get_games_owner($user->id_user);

		$meta = new Metaobj();
		$meta->setup_user($user);
		$this->load->view('head', array('meta' => $meta, 'user' => $user));
		$this->load->view('bodywrapper_head');
		$this->load->view('navbar');
		$this->load->view('title', array('title' => '@' . $user->screen_name . ' - ' .$meta->get_title()));
		$this->load->view('userpage', array('games_maked' => $games_maked));
		$this->load->view('bodywrapper_foot');
		$this->load->view('foot');
	}

}

