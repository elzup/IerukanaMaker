<?php

class Game_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function regist_game(Gameobj $game) {
		$game_id = $this->insert_game($game);
		$this->insert_words($game_id, $game->word_list);
		if (!empty($game->tags)) {
			$this->insert_tags($game_id, $game->tags);
		}
		return $game_id;
	}

	function insert_game(Gameobj $game) {
		$this->db->set(DB_CN_GAMES_USER_ID, $game->user_id);
		$this->db->set(DB_CN_GAMES_NAME, $game->name);
		$this->db->set(DB_CN_GAMES_DESCRIPTION, $game->description);
		$this->db->set(DB_CN_GAMES_WORDS_UNIT, $game->word_unit);
		$this->db->set(DB_CN_GAMES_WORDS_NUM, $game->words_num);
		$this->db->set(DB_CN_GAMES_CREATED_AT, date(MYSQL_TIMESTAMP));
		$this->db->set(DB_CN_GAMES_UPDATED_AT, date(MYSQL_TIMESTAMP, strtotime('-1 day')));
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
				DB_CN_WORDS_POINT_NEGATIVE => $word->point_negative,
				DB_CN_WORDS_POINT_POSITIVE => $word->point_positive,
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
	function get_game($game_id, $user_id = NULL) {
		if (!$game_res = $this->select_game($game_id)) {
			return NULL;
		}
		$game = new Gameobj($game_res);
		$game->set_word_list($this->to_wordobjs($this->select_words($game_id)));
		$game->tags = $this->get_tags($game_id);
		if ($user_id) {
			$game->is_favorited = $this->is_favorite($user_id, $game_id);
		}
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

	function to_gameobjs($rows, $set_words = FALSE, $set_tags = FALSE) {
		$games = array();
		foreach ($rows as $row) {
			$game = new Gameobj($row);
			if ($set_words) {
				$game->set_word_list($this->get_words($game->id));
			}
			if ($set_tags) {
				$game->tags = $this->get_tags($game->id);
			}
			$games[] = $game;
		}
		return $games;
	}

	function get_words($game_id) {
		return $this->to_wordobjs($this->select_words($game_id));
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
			case SORT_NEW:
				$order_by = DB_CN_GAMES_UPDATED_AT;
				$order_asc = 'DESC';
				break;
			default :
				return NULL;
		}
		$rows = $this->get_games($q, $order_by, $order_asc, $limit, $offset);
		return $this->to_gameobjs($rows);
	}

	/**
	 * 
	 * @param string|null $q
	 * @param string $order_by
	 * @param string $order_asc
	 * @param inteter $limit
	 * @param teterype $offset
	 * @return Gameobj[]
	 */
	public function get_games($q, $order_by, $order_asc, $limit, $offset) {
		$this->db->select('*');
		$this->db->from(DB_TN_GAMES);
		if (isset($q)) {
			$this->db->like(DB_CN_GAMES_NAME, $q);
			$this->db->or_like(DB_CN_GAMES_DESCRIPTION, $q);
		}
		$this->db->order_by($order_by, $order_asc);
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	public function get_games_tag($tag, $limit, $offset) {
		$ids = $this->get_ids_tag($tag);
		if (empty($ids)) {
			return array();
		}
		$this->db->where_in(DB_CN_GAMES_ID, $ids);
		$this->db->order_by(DB_CN_GAMES_PLAY_COUNT, 'DESC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get(DB_TN_GAMES);
		$result = $query->result();
		return $this->to_gameobjs($result);
	}

	public function get_recent_games($num = 20) {
		return $this->to_gameobjs($this->get_games(NULL, DB_CN_GAMES_UPDATED_AT, 'DESC', $num, 0), TRUE);
	}

	public static function to_sql_points(Gameobj $game, $active_points, $negative_points) {
		$data = array();
		$max = count($active_points) < 100 ? count($active_points) : 100;
		foreach ($active_points as $i => $p) {
			if (is_null($p) || "" === $p) {
				continue;
			}
			$data[] = array(
				DB_CN_WORDS_ID => $p,
				DB_CN_WORDS_POINT_POSITIVE => $game->word_list[$p]->point_positive + ($max - $i),
			);
		}
		foreach ($negative_points as $i => $p) {
			if (is_null($p) || "" === $p) {
				continue;
			}
			$data[] = array(
				DB_CN_WORDS_ID => $p,
				DB_CN_WORDS_POINT_NEGATIVE => $game->word_list[$p]->point_negative + 1,
			);
		}
		return $data;
	}

	public function remove_game($game_id) {
//		$this->delete_words($game_id);
//		$this->delete_tags($game_id);
		$this->delete_game($game_id);
	}

	public function delete_words($game_id) {
		$this->db->where(DB_CN_GAMES_ID, $game_id);
		$this->db->delete(DB_TN_WORDS);
	}

	public function delete_game($game_id) {
		$this->db->where(DB_CN_GAMES_ID, $game_id);
		$this->db->delete(DB_TN_GAMES);
	}

	public function update_game(Gameobj $game) {
		$this->_update_game($game);
		$this->delete_words($game->id);
		$this->insert_words($game->id, $game->word_list);
		$this->delete_tags($game->id);
		$this->insert_tags($game->id, $game->tags);
	}

	private function _update_game($game) {
		$this->db->where(DB_CN_GAMES_ID, $game->id);
		$this->db->set(DB_CN_GAMES_DESCRIPTION, $game->description);
		$this->db->set(DB_CN_GAMES_WORDS_UNIT, $game->word_unit);
		$this->db->set(DB_CN_GAMES_WORDS_NUM, $game->words_num);
		$this->db->update(DB_TN_GAMES);
	}

	function insert_tags($game_id, array $tags) {
		$data = array();
		foreach ($tags as $tag) {
			$data[] = array(
				DB_CN_TAGS_GAME_ID => $game_id,
				DB_CN_TAGS_TEXT => $tag
			);
		}
		$this->db->insert_batch(DB_TN_TAGS, $data);
	}

	function get_tags($game_id) {
		$rows = $this->select_tags($game_id);
		$tags = array();
		foreach ($rows as $row) {
			$tags[] = $row->{DB_CN_TAGS_TEXT};
		}
		return $tags;
	}

	function get_ids_tag($tag_text) {
		$rows = $this->select_tags_id($tag_text);
		$ids = array();
		foreach ($rows as $row) {
			$ids[] = $row->{DB_CN_TAGS_GAME_ID};
		}
		return $ids;
	}

	function select_tags($game_id) {
		$this->db->where(DB_CN_TAGS_GAME_ID, $game_id);
		return $this->db->get(DB_TN_TAGS)->result();
	}

	function select_tags_id($tag_text) {
		$this->db->where(DB_CN_TAGS_TEXT, $tag_text);
		return $this->db->get(DB_TN_TAGS)->result();
	}

	function delete_tags($game_id) {
		$this->db->where(DB_CN_TAGS_GAME_ID, $game_id);
		$this->db->delete(DB_TN_TAGS);
	}

	function get_hot_tags($limit) {
		$query = $this->db->query('SELECT distinct ' . DB_CN_TAGS_TEXT . ' FROM ie_' . DB_TN_TAGS . ' WHERE (' . DB_CN_TAGS_GAME_ID . ') in (select ' . DB_CN_GAMES_ID . ' from ie_' . DB_TN_GAMES . ' order by ' . DB_CN_GAMES_UPDATED_AT . ') limit ' . $limit);
		$result = $query->result();
		$tags = array();
		foreach ($result as $row) {
			$tags[] = $row->{DB_CN_TAGS_TEXT};
		}
		return $tags;
	}

	function get_tag_count($tag_text) {
		$this->db->where(DB_CN_TAGS_TEXT, $tag_text);
		return $this->db->count_all_results(DB_TN_TAGS);
	}

	function get_games_owner($user_id) {
		$this->db->where(DB_CN_USERS_ID, $user_id);
		$this->db->order_by(DB_CN_GAMES_CREATED_AT, 'DESC');
		$query = $this->db->get(DB_TN_GAMES);
		$result = $query->result();
		return $this->to_gameobjs($result, FALSE, TRUE);
	}

	function favorite_toggle($user_id, $game_id, $is_regist = NULL) {
		if (!isset($is_regist)) {
			$this->favorite_toggle($user_id, $game_id, !$this->is_favorite($user_id, $game_id));
			return;
		}
		echo $is_regist;
		if ($is_regist) {
			// お気に入り登録
			echo "regist";
			$this->insert_favorite($user_id, $game_id);
		} else {
			// お気に入り解除
			echo "delete";
			$this->delete_favorite($user_id, $game_id);
		}
	}

	function delete_favorite($user_id, $game_id) {
		$this->db->where(DB_CN_FAVORITES_USER_ID, $user_id);
		$this->db->where(DB_CN_FAVORITES_GAME_ID, $game_id);
		$this->db->delete(DB_TN_FAVORITES);
		echo $this->db->last_query();
	}

	function insert_favorite($user_id, $game_id) {
		$this->db->set(DB_CN_FAVORITES_USER_ID, $user_id);
		$this->db->set(DB_CN_FAVORITES_GAME_ID, $game_id);
		$this->db->insert(DB_TN_FAVORITES);
	}

	function is_favorite($user_id, $game_id) {
		$this->db->where(DB_CN_FAVORITES_USER_ID, $user_id);
		$this->db->where(DB_CN_FAVORITES_GAME_ID, $game_id);
		$query = $this->db->get(DB_TN_FAVORITES);
		$result = $query->result();
		return !empty($result[0]);
	}

	function select_favorite_user($user_id) {
		$this->db->where(DB_CN_FAVORITES_USER_ID, $user_id);
		$query = $this->db->get(DB_TN_FAVORITES);
		return $query->result();
	}

}
