<?php
/* @var $games Gameobj[] */
/* @var $title string */
?>

<div class="col-md-6">
	<div class="plate plate-wide">
		<?= $title ?>
		<ul class="list-min">
			<?php
			foreach ($games as $i => $game) {
				echo '<li>';
				echo '<p><a href="' . base_url(PATH_GAME . $game->id) . '">' . $game->get_full_title() . '</a></p>';
			}
			?>
		</ul>
	</div>
</div>