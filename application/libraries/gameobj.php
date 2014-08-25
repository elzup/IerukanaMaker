<?php

class Gameobj {
	public $id;
	public $user_id;
	public $name;
	public $description;
	public $word_unit;
	public $words_num;
	public $play_count;
	public $timestamp;
	/**
	 * ワードリスト
	 * @var Wordobj[]
	 */
	public $word_list;

	public function __construct($obj = NULL) {
		$this->word_list = array();
		if (is_null($obj)) {
			return;
		}
		$this->id = $obj->{DB_CN_GAMES_ID};
		$this->user_id = $obj->{DB_CN_GAMES_USER_ID};
		$this->name = $obj->{DB_CN_GAMES_NAME};
		$this->description = $obj->{DB_CN_GAMES_DESCRIPTION};
		$this->word_unit = $obj->{DB_CN_GAMES_WORDS_UNIT};
		$this->words_num = $obj->{DB_CN_GAMES_WORDS_NUM};
		$this->play_count = $obj->{DB_CN_GAMES_PLAY_COUNT};
		$this->timestamp = strtotime($obj->{DB_CN_GAMES_TIMESTAMP});
	}

	public function get_words_num() {
		return $this->words_num;
	}

	public function get_full_title() {
		return $this->name . $this->get_words_num() . $this->word_unit . '言えるかな';
	}

}

