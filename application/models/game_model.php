<?php

class Game_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function regist_game() {

	}
	function insert_game() {

	}
	function insert_words() {

	}

	/**
	 * 既に登録されている名前の確認
	 */
	function check_game_name_registed($name) {

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
