<?php

class Itemobj {

	public $title;
	public $link;
	public $description;
	public $author;
	public $category;

	public function __construct(Gameobj $game) {
		$this->title = $game->get_full_title();
		$this->link = $game->get_link();
		$this->description = $game->get_full_title(TRUE) . 'に挑戦しよう。' .  $game->description .  '[' . implode(',', $game->tags) . ']';
		$this->author = AUTHOR_NAME;
		$this->category = "";
	}
}