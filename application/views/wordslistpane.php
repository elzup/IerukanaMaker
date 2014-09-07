<?php
/* @var $games Gameobj[] */
/* @var $title string */
/* @var $icon string */
?>
<div class="words-list-pane plate plate-left">
	<p class="sub-title">
		<?php
		if (isset($icon)) {
			echo tag_icon($icon);
		}
		?>
		<?= $title ?>
	</p>
	<ul class="words-list">
		<?php
		foreach ($games as $game) {
			$words = $game->get_words_popular();
			list($k, $word) = each($words);
			?>
			<li>
				<p class="word" data-toggle="tooltip" title="<?= $game->get_full_title(TRUE) ?>"><a href="<?= $game->get_link() ?>"><?= $word->text ?></a></p>
			</li>
			<?php
		}
		?>
	</ul>
</div>
