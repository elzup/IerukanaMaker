<?php
/* @var $game Gameobj */
/* @var $is_owner bool */

function to_ans_kana($str) {
	return preg_replace('#ー#u', '-', strtolower(mb_convert_kana(mb_convert_kana($str, 'asKVc', 'utf8'), 'c', 'utf8')));
}
?>

<div class="content">
	<?php $this->load->view('gameinfo', array("game" => $game, 'page' => 'game')); ?>
	<div class="game-container">
		<div class="control-box">
			<div class="row">
				<div class="col-md-3">
					<div class="timer plate plate-plain">
						<div id="time-box">00:00:00.00</div>
					</div>
				</div>
				<div class="col-md-2">
					<div class="counter plate plate-plain">
						<span id="process_count">0</span>
						/
						<span id="process-all"><?= $game->get_words_num() ?></span>
					</div>
				</div>
				<div class="col-md-5">
					<div class="control-forms">
						<input id="answer-form" class="form-control" type="text" placeholder="解答欄" maxlength="20" />
						<input class="btn btn-primary" id="submit-answer" type="button" value="答える" />
						<input class="btn btn-success" id="submit-start" type="button" value="スタート" />
						<input class="btn btn-danger" id="submit-end" type="button" value="降参する" />
						<input class="btn btn-primary" id="submit-tweet" type="button" value="結果ツイート" />
					</div>
				</div>
			</div>
		</div>
		<div class="words-box">
			<table class="table table-words">
				<?php
				$i = 0;
				$p = ($game->get_words_num() <= 32) ? 4 : 8;
				foreach ($game->word_list as $word) {
					if ($i % $p == 0) {
						if ($i != 0) {
							echo '</tr>';
						}
						echo '<tr>';
					}
					echo '<td nid="' . $word->id . '" ans="' . $word->text . '" ansc="' . to_ans_kana($word->text) . '"></td>';
					$i++;
				}
				while ($i % $p != 0) {
					$i++;
					echo '<td class="emp"></td>';
				}
				echo '</tr>';
				?>
			</table>
		</div>
	</div>
	<?php
	if ($is_owner) {
		$this->load->view('ownerpanel', array('game' => $game));
	}
	?>
	<input type="hidden" id="game-id" value="<?= $game->id ?>" />
	<input type="hidden" id="game-name" value="<?= $game->name ?>" />
	<input type="hidden" id="word-unit" value="<?= $game->word_unit ?>" />
</div>