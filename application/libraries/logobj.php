<?php

class Logobj {

	public $user_id;
	public $game_id;
	public $point;
	public $time;
	public $timestamp;

	public function __construct($obj = NULL) {
		if (is_null($obj)) {
			return;
		}
		$this->user_id = $obj->{DB_CN_LOG_USER_ID};
		$this->game_id = $obj->{DB_CN_LOG_GAME_ID};
		$this->point = $obj->{DB_CN_LOG_POINT};
		$this->time = $obj->{DB_CN_LOG_TIME};
		$this->timestamp = time($obj->{DB_CN_LOG_LOGGED_AT});
	}

}
