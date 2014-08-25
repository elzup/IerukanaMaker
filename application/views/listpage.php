<?php
/* @var $games Gameobj[] */
/* @var $page_index integer */
$is_nogame = count($games) < 1;
$is_startpage = $page_index == 0;

function tag_pager($is_startpage, $is_nogame, $page_index, $q) {
	$prev_url = ($page_index - 1) . ($q ? '?q=' . urlencode($q): "");
	$next_url = ($page_index + 1) . ($q ? '?q=' . urlencode($q): "");
	?>
	<ul class="pager">
		<li class="previous<?= $is_startpage ? ' disabled' : '' ?>"><a href="<?= $is_startpage ? "#" : $prev_url ?>">←</a></li>
		<li class="next<?= $is_nogame ? ' disabled' : '' ?>"><a href="<?= $is_nogame ? "#" : $next_url ?>" class="">→</a></li>
	</ul>
	<?php
}
?>
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<?php
			$this->load->view('searchform');
			tag_pager($is_startpage, $is_nogame, $page_index, $q);
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
				tag_pager($is_startpage, $is_nogame, $page_index, $q);
			} else {
				?>
				言えるかなは見つかりませんでした
				<?php
			}
			?>
		</div>
	</div>
</div>