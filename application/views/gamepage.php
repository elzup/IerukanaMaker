<?php
/* @var $game Gameobj */
function to_ans_kana($str) {
	return strtolower(mb_convert_kana(mb_convert_kana($str, 'asKVc', 'utf8'), 'c', 'utf8'));
}
?>

<div class="content">
	<p class="description"><?= $game->description ?></p>
	<div class="game-container">
		<div class="control-box">
			<div class="row">
				<div class="col-md-2">
					<span id="time-box">00:00:00.00</span>
				</div>
				<div class="col-md-2">
					<span id="process_count">0</span>
					/
					<span id="process-all"><?= $game->get_words_num() ?></span>
				</div>
				<div class="col-md-3">
					<input id="answer-form" type="type" />
				</div>
				<div class="col-md-1">
					<input class="btn btn-primary" id="submit-answer" type="button" value="答える" />
				</div>
				<div class="col-md-1">
					<input class="btn btn-success" id="submit-start" type="button" value="スタート" />
				</div>
				<div class="col-md-1" for="submit-end">
					<input class="btn btn-danger" id="submit-end" type="button" value="降参する" />
				</div>
			</div>
		</div>
		<div class="words-box">
			<table class="table words-table">
				<?php
				foreach ($game->word_list as $i => $word) {
					if ($i % 8 == 0) {
						if ($i != 0) {
							echo '</tr>';
						}
						echo '<tr>';
					}
					echo '<td nid="' . $word->id . '" ans="' . $word->text . '" ansc="' . to_ans_kana($word->text) . '"></td>';
				}
				echo '</tr>';
				?>
			</table>
		</div>
	</div>
	<input type="hidden" id="game-id" value="<?= $game->id ?>" />
</div>