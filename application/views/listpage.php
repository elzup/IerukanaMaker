<?php
/* @var $games Gameobj[] */
/* @var $page_index integer */
/* @var $is_tag bool */
$is_tag = !!@$is_tag;
$is_nogame = count($games) < 1;
$is_startpage = $page_index == 0;

function tag_pager($is_startpage, $is_nogame, $page_index, $q, $is_tag) {
	if ($is_tag) {
		$prev_url = base_url(PATH_TAG . $q .'/' . ($page_index - 1));
		$next_url = base_url(PATH_TAG . $q .'/' . ($page_index + 1));
	} else {
		$prev_url = ($page_index - 1) . ($q ? '?q=' . urlencode($q) : "");
		$next_url = ($page_index + 1) . ($q ? '?q=' . urlencode($q) : "");
	}
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
			tag_pager($is_startpage, $is_nogame, $page_index, $q, $is_tag);
			if (!$is_nogame) {
				foreach ($games as $i => $game) {
					$i++;
					?>
					<div class="plate plate-game">
						<p class="name"><span class="index"><?= $i ?></span><a href="<?= $game->get_link() ?>"><?= $game->get_full_title() ?></a></p>
						<p class="description"><?= $game->get_wraped_description() ?></p>
					</div>
					<?php
				}
				tag_pager($is_startpage, $is_nogame, $page_index, $q, $is_tag);
			} else {
				?>
				言えるかなは見つかりませんでした
				<?php
			}
			?>
		</div>
	</div>
</div>