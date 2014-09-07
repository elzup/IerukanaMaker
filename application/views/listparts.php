<?php
/* @var $games Gameobj[] */
/* @var $title string */
/* @var $col int */
/* @var $num int */
/* @var $icon string */
if (!isset($num)) {
	$num = 5;
}
?>

<?php
if (isset($col)) {
	echo '<div class="col-md-' . $col . '">';
}
?>
<div class="plate plate-wide">
	<p class="sub-title">
		<?php
		if (isset($icon)) {
			echo tag_icon($icon);
		}
		?>
		<?= $title ?>
	</p>
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
<?php
if (isset($col)) {
	echo '</div>';
}
?>
