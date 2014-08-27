<?php
/* @var $game Gameobj */
/* @var $is_owner bool */
?>

<div class="content">
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
	<div class="rank-container">
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="row">
					<div class="col-md-6 rank-box">
						<span claas="sub-title">人気ワード</span>
						最初に答えられやすい順
						<ul class="item-rank">
							<?php 
							$rank = 1;
							$p_pre = NULL;
							foreach ($game->get_words_popular() as $i => $word) {
								if (isset($p_pre) && $p_pre != $word->point_positive) {
									$rank = $i + 1;
								}
								$p_pre = $word->point_positive;
								?>
								<li>
									<div class="row">
										<div class="col-md-2 rank">
											<?= $rank ?>
										</div>
										<div class="col-md-6 text">
											<?= $word->text ?>
										</div>
										<div class="col-md-4 graph">
											<?= $word->point_positive ?>
										</div>
									</div>
								<?php } ?>
						</ul>
					</div>
					<div class="col-md-6 rank-box">
						<span claas="sub-title">残念ワード</span>
						よく忘れられているワード
						<ul class="item-rank">
							<?php
							$rank = 1;
							$p_pre = NULL;
							foreach ($game->get_words_abord() as $i => $word) {
								if (isset($p_pre) && $p_pre != $word->point_negative) {
									$rank = $i + 1;
								}
								$p_pre = $word->point_negative;
								?>
								<li>
									<div class="row">
										<div class="col-md-2 rank">
											<?= $rank ?>
										</div>
										<div class="col-md-6 text">
											<?= $word->text ?>
										</div>
										<div class="col-md-4 graph">
											<?= $word->point_negative ?>
										</div>
									</div>
								<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>

	</div>
	<?php
	if ($is_owner) {
		$this->load->view('ownerpanel', array('game' => $game));
	}
	?>
</div>