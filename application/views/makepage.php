<?php 
/* @var $game Gameobj */
?>

<div class="content">
	<form id="make-form" class="form-horizontal" method="POST" action="<?= base_url(PATH_MAKE_POST) ?>" onsubmit="checkMakeForm()">
		<fieldset>
			<!--<legend>Legend</legend>-->
			<div class="form-group">
				<label for="input_game_name" class="col-md-2 control-label">タイトル</label>
				<div class="col-md-10">
					<input class="" id="input_game_name" name="game_name" placeholder="炎ポケモン" type="text">
					<span id="num">00</span>
					<input class="" id="input_words_unit" name="words_unit" value="個" type="text">
					言えるかな？
					<span class="help-block">最大20文字</span>
				</div>
			</div>
			<div class="form-group">
				<label for="input_description" class="col-md-2 control-label">追加説明文</label>
				<div class="col-md-10">
					<input class="form-control" id="input_description" name="description" placeholder="ex. 初代151匹の中で炎タイプをもつポケモンを答えてください" type="text">
					<span class="help-block">最大50文字</span>
				</div>
			</div>
			<div class="form-group">
				<label for="input_add" class="col-md-2 control-label">ワードリスト</label>
				<div class="col-md-10">
					<div class="row">
						<div class="col-md-4">
							<input class="" id="input_add" name="" placeholder="ヒトカゲ,ブーバー,..." type="text" />
							<input class="btn btn-primary" id="submit_add" name="" maxlength="10" type="button" value="追加" />
						</div>
						<div class="col-md-8">
							<p class="">
								右のフォームでカンマ,またはTab区切りで複数同時に追加できます<br>
								下のボックスに直接入力することも出来ます.一単語(最大10文字)<br />
							</p>
						</div>
					</div>
				</div>
				<div class="col-md-offset-2 col-md-10">
					<?php
					$h = 16;
					$w = 8;
					for ($i = 0; $i < $h; $i++) {
						echo '<div class="row row-word">';
						for ($j = 0; $j < $w; $j++) {
							$k = $i * $w + $j;
							echo <<< EOL
							<div class="col-md-1">
								<input class="wordbox" id="input_word{$k}" name="word-{$k}" maxlength="10" placeholder="---" type="text">
							</div>
EOL;
						}
						echo '</div>';
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-10 col-md-offset-2">
					<button id="check-btn" type="button" class="btn btn-default">チェック</button>
					<button id="submit-btn" type="button" class="btn btn-primary">作成</button>
				</div>
			</div>
		</fieldset>
	</form>
</div>