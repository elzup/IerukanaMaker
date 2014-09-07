<?php

class Category extends CI_Controller
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
		$hot_games = $this->game->search_games(NULL, SORT_HOT);
		$new_games = $this->game->search_games(NULL, SORT_NEW);

		$tags = $this->game->get_hot_tags(10);

		$recent_games = $this->game->get_recent_games(20);

		$messages = array();
		if (($posted = $this->session->userdata('alert'))) {
			$this->session->unset_userdata('alert');
			$messages[] = $posted;
		}


		$meta = new Metaobj();
		$meta->setup_top();
		$this->load->view('head', array('meta' => $meta, 'user' => $user));
		$this->load->view('bodywrapper_head');
		$this->load->view('navbar');
		$this->load->view('alert', array('messages' => $messages));
		$this->load->view('toppage', array('hot_games' => $hot_games, 'new_games' => $new_games, 'recent_games' => $recent_games, 'tags' => $tags));
		$this->load->view('bodywrapper_foot');
		$this->load->view('footer');
		$this->load->view('foot');
	}

	public function view($category_code) {
	}

}


