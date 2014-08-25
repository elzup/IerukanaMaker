<?php

class Game_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function regist_game(Gameobj $game) {
		$game_id = $this->insert_game($game);
		$this->insert_words($game_id, $game->word_list);
		return $game_id;
	}

	function insert_game(Gameobj $game) {
		$this->db->set(DB_CN_GAMES_USER_ID, $game->user_id);
		$this->db->set(DB_CN_GAMES_NAME, $game->name);
		$this->db->set(DB_CN_GAMES_DESCRIPTION, $game->description);
		$this->db->set(DB_CN_GAMES_WORDS_UNIT, $game->word_unit);
		$this->db->set(DB_CN_GAMES_WORDS_NUM, $game->words_num);
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
	function check_gamename_can_regist($name) {
		$this->db->where(DB_CN_GAMES_NAME, $name);
		$query = $this->db->get(DB_TN_GAMES);
		$result = $query->result();
		return empty($result[0]);
	}

	function increment_play_count($game_id) {
		// TODO: create
		$this->db->where(DB_CN_GAMES_ID, $game_id);
		$this->db->set(DB_CN_GAMES_PLAY_COUNT, DB_CN_GAMES_PLAY_COUNT . ' + 1', FALSE);
		$this->db->set(DB_CN_GAMES_TIMESTAMP, DB_CN_GAMES_TIMESTAMP, FALSE);
		$this->db->update(DB_TN_GAMES);
	}

	public function log_points($game_id, $active_points, $negative_points) {
		$game = $this->get_game($game_id);
		$data = Game_model::to_sql_points($game, $active_points, $negative_points);
		$this->update_points($game_id, $data);
	}

	public function close() {
		$this->db->close();
	}

	function update_points($game_id, $data) {
		$this->db->where(DB_CN_WORDS_GAME_ID, $game_id);
		$this->db->update_batch(DB_TN_WORDS, $data, DB_CN_WORDS_ID);
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
		$game->set_word_list($this->to_wordobjs($this->select_words($game_id)));
		return $game;
	}

	function select_game($game_id) {
		$this->db->where(DB_CN_GAMES_ID, $game_id);
		$query = $this->db->get(DB_TN_GAMES);
		$result = $query->result();
		return @$result[0] ? : NULL;
	}

	function select_words($game_id) {
		$this->db->where(DB_CN_WORDS_GAME_ID, $game_id);
		$query = $this->db->get(DB_TN_WORDS);
		$result = $query->result();
		return $result;
	}

	function to_wordobjs($rows) {
		$words = array();
		foreach ($rows as $row) {
			$words[$row->{DB_CN_WORDS_ID}] = new Wordobj($row);
		}
		return $words;
	}

	function to_gameobjs($rows) {
		$games = array();
		foreach ($rows as $row) {
			$games[] = new Gameobj($row);
		}
		return $games;
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

	public function get_top_games($limit = 20, $start = 0) {
		return $this->search_games(NULL, SORT_HOT, $limit, $start);
	}

	public function get_new_games($limit = 20, $start = 0) {
		return $this->search_games(NULL, SORT_NEW, $limit, $start);
	}

	public function search_games($q = NULL, $sort = SORT_HOT, $limit = 20, $offset = 0) {
		switch ($sort) {
			case SORT_HOT:
				$order_by = DB_CN_GAMES_PLAY_COUNT;
				$order_asc = 'DESC';
				break;
			case SORT_HOT:
				$order_by = DB_CN_GAMES_TIMESTAMP;
				$order_asc = 'DESC';
				break;
		}
		$rows = $this->get_games($q, $order_by, $order_asc, $limit, $offset);
		return $this->to_gameobjs($rows);
		}

	public function get_games($q, $order_by, $order_asc, $limit, $offset) {
		if (isset($q)) {
			$this->db->like(DB_CN_GAMES_NAME, $q);
		}
		$this->db->order_by($order_by, $order_asc);
		$this->db->limit($limit, $offset);
		$query = $this->db->get(DB_TN_GAMES);
		$result = $query->result();
		return $result;
	}

	public function get_recent_aborted_chars() {
		
	}

	public static function to_sql_points(Gameobj $game, $active_points, $negative_points) {
		$data = array();
		foreach ($active_points as $i => $p) {
			if ($i > 10) {
				break;
			}
			$data[] = array(
				DB_CN_WORDS_ID => $p,
				DB_CN_WORDS_POINT_POSITIVE => $game->word_list[$p]->point_positive + (10 - $i),
			);
		}
		foreach ($negative_points as $i => $p) {
			$data[] = array(
				DB_CN_WORDS_ID => $p,
				DB_CN_WORDS_POINT_NEGATIVE => $game->word_list[$p]->point_negative + 1,
			);
		}
		return $data;
	}

}
