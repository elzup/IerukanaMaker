<?php
/* @var $game Gameobj */
/* @var $is_owner bool */

function to_ans_kana($str) {
	return preg_replace('#ー#u', '-', strtolower(mb_convert_kana(mb_convert_kana($str, 'asKVc', 'utf8'), 'c', 'utf8')));
}
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
	<?php if ($is_owner) { ?>
		<div>
			あなたはこの言えるかな？の作成者です
			<a class="btn btn-info" href="<?= base_url(PATH_UPDATE . $game->id) ?>">変更する</a>
			<input class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" type="button" id="submit-delete-game" value="この言えるかな？を削除する" />
		</div>

		<div class="modal fade" id="modal-delete">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<p class="modal-title">
							作者の技術では復元出来ませんが<br />
							本当に削除してよろしいですか？
						</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
						<a type="button" href="<?= base_url(PATH_DELETE . $game->id) ?>" class="btn btn-danger">削除</a>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	<?php } ?>
	<input type="hidden" id="game-id" value="<?= $game->id ?>" />
	<input type="hidden" id="game-name" value="<?= $game->name ?>" />
	<input type="hidden" id="word-unit" value="<?= $game->word_unit ?>" />
</div>