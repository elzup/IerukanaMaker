<?php
/* @var $game Gameobj */
/* @var $is_owner bool */
/* @var $gamemode string */

/**
 * 
 * @param string $str
 * @return string
 */
function to_ans_kana($str) {
	return str_replace(array('ー', '-', '+', '.', '#', '・', ' '), array('__h', '__h', '__p', '__d', '__s', '', ''), strtolower(mb_convert_kana(mb_convert_kana($str, 'asKVc', 'utf8'), 'c', 'utf8')));
}

function to_valuetext($text, $gamemode) {
	switch ($gamemode) {
		case GAME_MODE_EASY:
			return strtosilhouette($text);
		case GAME_MODE_SO_EASY:
			return strtosilhouette($text, TRUE);
		case GAME_MODE_TYPING:
			return $text;
		default:
			break;
	}
	return '';
}

function strtosilhouette($str, $head_view = FALSE) {
	$strs = mbStringToArray($str);
	$silhouette = '';
	$lib = 'ぁぃぅぇぉっゃゅょゎァィゥェォッャュョヮ.。、';
	foreach ($strs as $i => $c) {
		if ($i == 0 && $head_view && count($strs) != 1) {
			$silhouette .= $c;
			continue;
		}
		if (mb_strpos($lib, $c) !== FALSE) {
			$silhouette .= 'o';
			continue;
		}
		if (is_half_char($c)) {
			$silhouette .= 'O';
			continue;
		}
		$silhouette .= '○';
	}
	return $silhouette;
}

function is_half_char($str) {
	return strlen($str) === mb_strlen($str);
}

function mbStringToArray($sStr, $sEnc = 'UTF-8') {
	$aRes = array();
	while ($iLen = mb_strlen($sStr, $sEnc)) {
		array_push($aRes, mb_substr($sStr, 0, 1, $sEnc));
		$sStr = mb_substr($sStr, 1, $iLen, $sEnc);
	}
	return $aRes;
}
?>
<?php if ($game->words_num > 32) { ?>
	<div class="row">
		<div class="col-xs-12 visible-xs">
			<div class="alerts-div">
				<div class="alert alert-dismissable alert-warning">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<p>ワード数30を超える言えるかなはPCでのプレイをおすすめしています</p>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<div class="content">
	<?php $this->load->view('gameinfo', array("game" => $game, 'page' => 'game', 'gamemode' => $gamemode)); ?>
	<div class="game-container">
		<div class="control-box">
			<div class="row game-mode-box">
				<div class="col-xs-12">
					<span href="#" class="ruby-btn">ゲームモード</span>
				</div>
				<div class="col-xs-12">
					<div class="btn-group">
						<a href="<?= base_url(PATH_GAME . $game->id) ?>" class="btn btn-default<?= $gamemode == GAME_MODE_NORMAL ? ' active disabled' : '' ?>">ノーマル</a>
						<a href="<?= base_url(PATH_GAME . $game->id . '?easy') ?>" class="btn btn-default<?= $gamemode == GAME_MODE_EASY ? ' active disabled' : '' ?>">やさしい</a>
						<a href="<?= base_url(PATH_GAME . $game->id . '?soeasy') ?>" class="btn btn-default<?= $gamemode == GAME_MODE_SO_EASY ? ' active disabled' : '' ?>">超やさしい</a>
						<a href="<?= base_url(PATH_GAME . $game->id . '?typing') ?>" class="btn btn-default<?= $gamemode == GAME_MODE_TYPING ? ' active disabled' : '' ?>">タイピング</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<div class="input-group timer-set" disabled="">
						<span class="input-group-btn">
							<button id="timer-toggle-btn" class="btn btn-xs btn-default" type="button" data-toggle="button"><i class="glyphicon glyphicon-time"></i></button>
						</span>
						<input id="timer-input" type="number" class="form-control" value="3" disabled="">
						<span class="input-group-addon">分</span>
					</div><!-- /input-group -->
				</div>
			</div>
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
				<div class="col-md-7">
					<div class="control-forms">
						<div class="action-box">
							<span style="display: none" class="judge judge-ok">○</span>
							<span style="display: none" class="judge judge-ng">×</span>
							<span style="display: none" class="judge judge-already">済</span>
						</div>
						<input id="answer-form" class="form-control" type="text" placeholder="解答欄" maxlength="20" />
						<input class="btn btn-primary" id="submit-answer" type="button" value="答える" />
						<input class="btn btn-primary" id="submit-start" type="button" value="スタート" />
						<input class="btn btn-danger" id="submit-end" type="button" value="降参する" />
						<input class="btn btn-success" id="submit-tweet" type="button" value="結果ツイート" />
					</div>
				</div>
			</div>
		</div>
		<div class="words-box">
			<table class="table table-words table-<?= $gamemode ?>">
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
					$value = to_valuetext($word->text, $gamemode);
					echo '<td nid="' . $word->id . '" ans="' . $word->text . '" ansc="' . to_ans_kana($word->text) . '">' . $value . '</td>';
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
	<input type="hidden" id="game-mode" value="<?= $gamemode ?>" />
</div>