<?php
/* @var $games Gameobj[] */
/* @var $title string */
/* @var $col int */
/* @var $num int */
/* @var $icon string */
/* @var $more_link string */
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
	<?php if (isset($more_link)) { ?>
	<div class="pull-right btn-more-wrap">
		<!--<div class="btn-ribbon-head"> </div>-->
		<a href="<?= $more_link ?>" class="btn btn-default btn-ribbon">もっと見る</a>
	</div>
	<?php } ?>
</div>
<?php
if (isset($col)) {
	echo '</div>';
}