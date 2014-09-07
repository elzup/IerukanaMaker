<?php
/* @var $games_hot Gameobj[] */
/* @var $games_new Gameobj[] */
/* @var $games_recent Gameobj[] */
/* @var $word Word */
/* @var $tags string[] */
?>

<div class="row">
	<div class="col-md-7 col-md-offset-1 topmain-list">
		<?php
		$this->load->view('listparts', array('games' => $games_hot, 'title' => '人気の言えるかな？', 'icon' => 'fire'));
		$this->load->view('listparts', array('games' => $games_new, 'title' => '新着の言えるかな？', 'icon' => 'leaf'));
		$this->load->view('listparts', array('games' => $games_recent, 'title' => 'おすすめの言えるかな？', 'icon' => 'bullhorn'));
		?>
	</div>
	<div class="col-md-3">
		<?php
		$this->load->view('tagpane', array('tags' => $tags));

		$words_games_positive = array();
		foreach (array(1, 3, 5, 7, 9) as $i) {
			$words_games_positive[] = $games_recent[$i];
		}
		$this->load->view('wordslistpane', array('title' => '最近の人気ワード', 'games' => $words_games_positive, 'icon' => 'sort-by-attributes-alt'));
		$words_games_negative = array();
		foreach (array(0, 2, 4, 6, 8) as $i) {
			$words_games_negative[] = $games_recent[$i];
		}
		$this->load->view('wordslistpane', array('title' => '最近忘れられたワード', 'games' => $words_games_negative, 'icon' => 'sort-by-attributes'));
		?>
	</div>
</div>