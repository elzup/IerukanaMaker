<?php

class Wordobj {
	public $id;
	public $text;
	public $point_positive;
	public $point_negative;

	public function __construct($obj = NULL) {
		if (is_null($obj)) {
			return;
		}
		$this->id = $obj->{DB_CN_WORDS_ID};
		$this->text = $obj->{DB_CN_WORDS_TEXT};
		$this->point_positive = $obj->{DB_CN_WORDS_POINT_POSITIVE};
		$this->point_negative = $obj->{DB_CN_WORDS_POINT_NEGATIVE};
	}
}

