<?php
/* @var $games Gameobj[] */
/* @var $page_index integer */
$is_nogame = count($games) < 1;
$is_startpage = $page_index == 0;

function tag_pager($is_startpage, $is_nogame, $page_index) {
	?>
	<ul class="pager">
		<li class="previous<?= $is_startpage ? ' disabled' : '' ?>"><a href="<?= $is_startpage ? "#" : $page_index - 1 ?>">←</a></li>
		<li class="next<?= $is_nogame ? ' disabled' : '' ?>"><a href="<?= $is_nogame ? "#" : $page_index + 1 ?>" class="">→</a></li>
	</ul>
	<?php
}
?>
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<?php
			tag_pager($is_startpage, $is_nogame, $page_index);
			if (!$is_nogame) {
				foreach ($games as $i => $game) {
					$i++;
					?>
					<div class="plate plate-game">
						<p class="name"><span class="index"><?= $i ?></span><a href="<?= base_url(PATH_GAME . $game->id) ?>"><?= $game->get_full_title() ?></a></p>
						<p class="description"><?= $game->description ?></p>
					</div>
					<?php
				}
				tag_pager($is_startpage, $is_nogame, $page_index);
			} else {
				?>
				言えるかなは見つかりませんでした
				<?php
			}
			?>
		</div>
	</div>
</div>