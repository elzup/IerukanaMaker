<?php

class Itemobj {

	public $title;
	public $link;
	public $description;
	public $author;
	public $category;
	public $pub_date;
	public $guid;

	public function __construct(Gameobj $game = NULL) {
		if (!isset($game)) {
			return ;
		}
		$this->title = $game->get_full_title(TRUE);
		$this->link = $game->get_link();
		$this->description = $game->get_full_title(TRUE) . 'に挑戦しよう。' .  $game->description;
		if ($tag_text = $game->get_tags_text()) {
			$this->description .= '[' . $tag_text . ']';
		}
		$this->author = AUTHOR_MAIL . ' (' . AUTHOR_NAME . ')';
		$this->category = str_replace('・', ' ', $game->get_category_str());
		$this->pub_date = date(DATE_RFC2822, $game->timestamp);
		$this->guid = $game->get_guid();
	}

	/**
	 * 
	 * @param Gameobj[] $games
	 */
	public static function to_items(array $games) {
		$items = array();
		foreach ($games as $game) {
			$items[] = new Itemobj($game);
		}
		return $items;
	}
	
}