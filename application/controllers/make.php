<?php

class Make extends CI_Controller {

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
		$user = $this->user->get_main_user();
		$post = $this->input->post();
		$name = $post['game_name'];
		$can_use = $this->game->check_gamename_can_regist($name);
		if (!$can_use) {
			echo 'e:1';
			exit;
		}
		$game = new Gameobj();
		$game->name = $name;
		$game->description = $post['game_description'];
		$game->user_id = $user->id_user;
		$game->word_unit = $post['words_unit'];
		foreach (explode(',', $post['words_list_text']) as $word_text) {
			$word = new Wordobj();
			$word->text = $word_text;
			$game->word_list[] = $word;
		}
		$game->words_num = count($game->word_list);
		$game_id = $this->game->regist_game($game);
		$this->session->set_userdata('alert', '新しい言えるかなを作成しました！削除したくなった場合はこのページの最下部を見てください'); // outpput plain text
		echo 's:' . $game_id;
	}

	public function check() {
		$post = $this->input->post();
		$name = $post['name'];
		if ($this->game->check_gamename_can_regist($name)) {
			echo 's';
		} else {
			echo 'e';
		}
		exit;
	}

	public function update() {
	}

}
