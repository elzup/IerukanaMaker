<?php

class Game extends CI_Controller {

	/** @var User_model */
	public $user;

	/** @var Game_model */
	public $game;

	public function __construct() {
		parent::__construct();
		$this->load->model('User_model', 'user', TRUE);
		$this->load->model('Game_model', 'game', TRUE);
	}

	public function index() {
		
	}

	public function play($game_id) {
		$user = $this->user->get_main_user();
		$game = $this->game->get_game($game_id);

		$messages = array();
		if (($posted = $this->session->userdata('alert'))) {
			$this->session->unset_userdata('alert');
			$messages[] = $posted;
		}

		$meta = new Metaobj();
		$meta->setup_game($game);
		$this->load->view('head', array('meta' => $meta, 'user' => $user));
		$this->load->view('bodywrapper_head');
		$this->load->view('navbar');
		$this->load->view('title', array('title' => $meta->get_title()));
		$this->load->view('alert', array('messages' => $messages));
		$this->load->view('gamepage', array('game' => $game));
		$this->load->view('bodywrapper_foot');
		$this->load->view('foot');
	}

	public function result($game_id = NULL) {
		$post = $this->input->post();
		$active_points = explode(',', $post['start_ids']);
		$negative_points = explode(',', $post['ng_ids']);
		if ($this->agent->is_referral()) {
			$game_id_check = Game::get_game_id($this->agent->referrer());
		}
		if (is_null($game_id) || is_null($game_id_check) || $game_id != $game_id_check) {
			echo 'e:0';
			return;
		}
		$this->game->log_points($game_id, $active_points, $negative_points);
		$this->game->close();
		echo "result logged!";
	}

	public static function get_game_id($url) {
		preg_match('#.*/(?<id>[0-9]+)\??.*#', $url, $m);
		return $m['id'];
	}

}
