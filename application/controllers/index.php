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
		$new_games = $this->game->get_new_games(NUM_GAME_PAR_TOPPAGE);
		$hot_games = $this->game->get_top_games(NUM_GAME_PAR_TOPPAGE);

		$meta = new Metaobj();
		$meta->setup_top();
		$this->load->view('head', array('meta' => $meta, 'user' => $user));
		$this->load->view('bodywrapper_head');
		$this->load->view('navbar');
		$this->load->view('toppage', array('hot_games' => $hot_games, 'new_games' => $new_games));
		$this->load->view('bodywrapper_foot');
		$this->load->view('foot');
	}

}

