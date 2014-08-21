<?php

class Game_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function regist_game(Gameobj $game) {
		$this->insert_game($game);
	}

	function insert_game(Gameobj $game) {
		$this->db->set(DB_CN_GAMES_USER_ID, $game->user_id);
		$this->db->set(DB_CN_GAMES_NAME, $game->name);
		$this->db->set(DB_CN_GAMES_DESCRIPTION, $game->description);
		$this->db->set(DB_CN_GAMES_WORDS_NUM, $game->get_words_num());
		$this->db->insert(DB_TN_GAMES);
		return $this->db->insert_id();

	}

	/**
	 * 
	 * @param int $game_id
	 * @param Wordobj[] $word_list
	 */
	function insert_words($game_id, array $word_list) {
		$data = array();
		foreach ($word_list as $word) {
			$data[] = array(
				DB_CN_WORDS_GAME_ID => $game_id,
				DB_CN_WORDS_TEXT => $word->text,
			);
		}
		$this->db->insert_batch(DB_TN_WORDS, $data);
	}

	/**
	 * 既に登録されている名前の確認
	 */
	function check_game_name_registed($name) {

	}

	function increment_play_count($game_id) {
		// TODO: create
	}

	function update_point_negative($game_id, $word_id, $point_add) {
		// TODO: create
	}

	/**
	 * 
	 * @param int $game_id
	 * @return null|\Gameobj
	 */
	function get_game($game_id) {
		if (!$game_res = $this->select_game($game_id)) {
			return NULL;
		}
		$game = new Gameobj($game_res);
		$game->word_list = $this->select_words($game_id);
		return $game;
	}

	function select_game($game_id) {
		$this->db->where(DB_CN_GAMES_ID, $game_id);
		$query = $this->db->get(DB_TN_USERS);
		$result = $query->result();
		return @$result[0] ? : NULL;
	}

	function select_words($game_id) {
		$this->db->where(DB_CN_WORDS_GAME_ID, $game_id);
		$query = $this->db->get(DB_TN_USERS);
		$result = $query->result();
		return $result;
	}

	/**
	 * 
	 * @param int $id twitterid
	 */
	function check_register($id_twitter) {
		$this->db->where(DB_CN_USERS_TWITTER_USER_ID, $id_twitter);
		$query = $this->db->get(DB_TN_USERS);
		$result = $query->result();
		return @$result[0] ? : FALSE;
	}

	function register($id_twitter) {
		$this->db->set(DB_CN_USERS_TWITTER_USER_ID, $id_twitter);
		$this->db->insert(DB_TN_USERS);
		return $this->db->insert_id();
	}

}
