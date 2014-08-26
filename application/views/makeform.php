<?php
/* @var $game Gameobj */
?>
<form id="make-form" class="form-horizontal" method="POST" action="<?= base_url($game ? PATH_UPDATE_POST : PATH_MAKE_POST) ?>" onsubmit="checkMakeForm()">
	<fieldset>
		<!--<legend>Legend</legend>-->
		<div class="form-group">
			<label for="input_game_name" class="col-md-2 control-label">タイトル</label>
			<div class="col-md-10">
				<input class="" <?= $game ? 'disabled=""' : '' ?> id="input_game_name" name="game_name" value="<?= $game ? $game->name : '' ?>" placeholder="炎ポケモン" type="text" maxlength="20">
				<span id="num">&nbsp;&nbsp;0</span>
				<input class="" id="input_words_unit" name="words_unit" value="<?= $game ? $game->word_unit :'個'?>" type="text" maxlength="5">
				言えるかな？
				<span id="check-name"></span>
				<span class="help-block">最大20文字</span>
			</div>
		</div>
		<div class="form-group">
			<label for="input_description" class="col-md-2 control-label">追加説明文</label>
			<div class="col-md-10">
				<input class="form-control" id="input_description" name="description" value="<?= $game ? $game->description :''?>" placeholder="ex. 初代151匹の中で炎タイプをもつポケモンを答えてください" type="text" maxlength="50">
				<span class="help-block">最大50文字 #でタグ付け出来ます</span>
			</div>
		</div>
		<div class="form-group">
			<label for="input_add" class="col-md-2 control-label">ワードリスト</label>
			<div class="col-md-10">
				<div class="row">
					<div class="col-md-4">
						<input class="" id="input_add" name="" placeholder="ヒトカゲ,ブーバー,..." type="text" />
						<input class="btn btn-primary" id="submit-add" name="" maxlength="20" type="button" value="追加" />
						<!--<input class="btn btn-info" id="submit-check" name="" maxlength="10" type="button" value="値チェック" />-->
						<input class="btn btn-danger" id="submit-clear" name="" maxlength="20" type="button" value="全消去" />
					</div>
					<div class="col-md-8">
						<p class="">
							単語は20文字以内ですが全角文字の場合<b>10文字以内</b>推奨です.最大256単語まで<br />
							記号(改行やスペースなど)は使えません.<br />
							右のフォームでカンマ,またはスペース区切りで<b>複数同時</b>に追加できます.<br />
							下のボックスに直接編集することも出来ます.<br />
						</p>
					</div>
				</div>
			</div>
			<div class="col-md-12" id="word-list-box">
				<?php
				$h = 32;
				$w = 8;
				$f = TRUE;
				for ($i = 0; $i < $h; $i++) {
					/* @var $word Wordobj */
					$word = NULL;
					if ($game && $f) {
						$f = list($k, $word) = each($game);
					}
					if ($i == 16) {
						echo '<button type="button" class="btn btn-block btn-default margin-v" data-toggle="collapse" data-target="#more-word-box">表示(129 ~)</button>';
						echo '<div id="more-word-box" class="collapse">';
					}
					echo '<div class="row row-word">';
					for ($j = 0; $j < $w; $j++) {
						$k = $i * $w + $j;
						echo <<< EOL
							<div class="col-md-1">
								<input class="wordbox" id="input_word{$k}" name="word-{$k}" maxlength="20" value="{$word->text}" placeholder="---" type="text">
							</div>
EOL;
					}
					echo '</div>';
				}
				echo '</div>';
				?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-10 col-md-offset-2">
				<!--<button id="check-btn" type="button" class="btn btn-default">チェック</button>-->
				<button id="submit-btn" type="button" class="btn btn-primary">作成</button>
			</div>
		</div>
	</fieldset>
</form>