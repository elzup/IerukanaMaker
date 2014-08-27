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

	public function play($game_id, $rank = NULL) {
		if ($rank == "rank") {
			$this->rank($game_id);
		}
		$user = $this->user->get_main_user();
		$game = $this->game->get_game($game_id);

		$messages = array();
		if (($posted = $this->session->userdata('alert'))) {
			$this->session->unset_userdata('alert');
			$messages[] = $posted;
		}

		if (empty($game)) {
			$this->session->set_userdata('alert', 'お探しの言えるかな？は存在しません。消去された可能性があります');
			jump(base_url());
		}

		$is_owner = isset($user) && $user->id_user == $game->user_id;

		$meta = new Metaobj();
		$meta->setup_game($game);
		$this->load->view('head', array('meta' => $meta, 'user' => $user));
		$this->load->view('bodywrapper_head');
		$this->load->view('navbar');
		$this->load->view('alert', array('messages' => $messages));
		$this->load->view('gamepage', array('game' => $game, 'is_owner' => $is_owner));
		$this->load->view('bodywrapper_foot');
		$this->load->view('foot');
	}

	public function rank($game_id) {
		$user = $this->user->get_main_user();
		$game = $this->game->get_game($game_id);

		$messages = array();
		if (($posted = $this->session->userdata('alert'))) {
			$this->session->unset_userdata('alert');
			$messages[] = $posted;
		}

		if (empty($game)) {
			$this->session->set_userdata('alert', 'お探しの言えるかな？は存在しません。消去された可能性があります');
			jump(base_url());
		}
		$is_owner = isset($user) && $user->id_user == $game->user_id;

		$meta = new Metaobj();
		$meta->setup_game($game);
		$this->load->view('head', array('meta' => $meta, 'user' => $user));
		$this->load->view('bodywrapper_head');
		$this->load->view('navbar');
		$this->load->view('alert', array('messages' => $messages));
		$this->load->view('rankpage', array('game' => $game, 'is_owner' => $is_owner));
		$this->load->view('bodywrapper_foot');
		$this->load->view('foot');
	}

	private function _no_game($user) {
		$meta = new Metaobj();
		$meta->no_meta = TRUE;
		$meta->set_title("言えるかな？がみつかりません");
		$meta->description = "この言えるかなは存在しません";
		$this->load->view('head', array('meta' => $meta, 'user' => $user));
		$this->load->view('bodywrapper_head');
		$this->load->view('navbar');
		$this->load->view('title', array('title' => $meta->get_title()));
		$this->load->view('nogamepage');
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
		$this->game->increment_play_count($game_id);
		$this->game->log_points($game_id, $active_points, $negative_points);
		$this->game->close();
		echo "result logged!";
	}

	public function delete($game_id) {
		$user = $this->user->get_main_user();
		$game = $this->game->get_game($game_id);
		if (empty($user) || empty($game) || $user->id_user != $game->user_id) {
			// TODO: error処理
			jump(base_url());
		}
		$this->game->remove_game($game_id);
		$this->session->set_userdata('alert', '「' . $game->get_full_title() . '」を削除しました');
		jump(base_url());
	}

	public static function get_game_id($url) {
		preg_match('#.*/(?<id>[0-9]+)\??.*#', $url, $m);
		return $m['id'];
	}

}
