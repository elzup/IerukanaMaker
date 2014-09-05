<?php
/* @var $games Gameobj[] */
/* @var $title string */
/* @var $col int */
/* @var $num int */
if (!isset($num)) {
	$num = 5;
}
if (!isset($col)) {
	$col = 6;
}

?>

<div class="col-md-<?= $col ?>">
	<div class="plate plate-wide">
		<?= $title ?>
		<ul class="list-min">
			<?php
			foreach ($games as $i => $game) {
				echo '<li>';
				echo '<p><a href="' . base_url(PATH_GAME . $game->id) . '">' . $game->get_full_title() . '</a></p>';
				if ($i == $num - 1) {
					break;
				}
			}
			?>
		</ul>
	</div>
</div>