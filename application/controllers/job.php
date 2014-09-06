<?php

class Job extends CI_Controller {
	/** @var Game_model */
	public $game;

	public function __construct() {
		parent::__construct();
		$this->load->model('Game_model', 'game', TRUE);
	}

	public function index() {
		$keys_config = $this->config->item('CHECK_KEYS');
		$key = $this->input->get(@$keys_config['get_param']);
		if (empty($key) || $key != $keys_config['tweet_post_key']) {
			show_404();
		}
		$game = $this->game->get_game_tweet();
		$this->_post_tweet($game);
	}

	private function _post_tweet(Gameobj $game) {
		$twitter_config = $this->config->item('TWITTER_BOT');
		$connection = new TwitterOAuth($twitter_config['consumer_key'], $twitter_config['consumer_secret'], $twitter_config['token_key'], $twitter_config['token_secret']);
		$url = 'statuses/update';
		$text = $game->get_full_title() . ' ' . $game->get_link();
		$parameters = array(
			'status' => $text,
		);
		$connection->post($url, $parameters);
	}
}
