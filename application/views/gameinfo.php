<?php
/* @var $game Gameobj */
/* @var $page string */
?>
<div id="game-info" class="plate">
	<div class="row">
		<div class="col-md-8">
			<h1 class="page-title"><?= $game->get_full_title(TRUE) ?></h1>
		</div>
		<div class="col-md-2">
			<?php
			if ($page == 'game') {
				echo '<a class="btn btn-default" href="' . base_url(PATH_RANK . $game->id) . '">単語ランキング</a>';
			} else {
				echo '<a class="btn btn-default" href="' . base_url(PATH_GAME . $game->id) . '">ゲームページヘ</a>';
			}
			?>
		</div>
	</div>
	<div class="description">
		<p><?= $game->get_wraped_description() ?></p>
		<?php
		echo '<div>';
		$text = $game->get_full_title(TRUE);
		sharebtn_twitter($text, base_url(PATH_GAME . $game->id), 'tweet');
		echo '</div>';
		?>
	</div>
	<div class="tag-box">
		<?php
		foreach ($game->tags as $tag) {
			echo '<span class="tag">';
			echo wrap_taglink_only($tag);
			echo '</span>';
		}
		?>
	</div>
</div>
