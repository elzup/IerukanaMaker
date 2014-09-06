<?php
/* @var $game Gameobj */
/* @var $gamemode string */

$title = $game->get_full_title(TRUE);
switch ($gamemode) {
	case GAME_MODE_EASY:
		$title .= '(やさしい)';
		break;
	case GAME_MODE_SO_EASY:
		$title .= '(超やさしい)';
		break;
	case GAME_MODE_TYPING:
		$title .= '(タイピング)';
		break;
	case GAME_MODE_RANK:
		$title .= '(ランキング)';
		break;
	default:
		break;
}
?>
<div id="game-info" class="plate">
	<div class="row">
		<div class="col-md-8">
			<h1 class="page-title"><?= $title ?></h1>
		</div>
		<div class="col-md-2">
			<?php if (isset($game->is_favorited)): ?>
				<button id="favorite-btn" class="btn btn-default btn-block btn-favorite" <?= $game->is_favorited ? 'style="display: none"' : '' ?>>★お気に入り登録</button>
				<button id="unfavorite-btn" class="btn btn-default btn-block btn-favorite" <?= !$game->is_favorited ? 'style="display: none"' : '' ?>>★お気に入り中　</button>
			<?php else: ?>
				<button class="btn btn-default btn-block btn-favorite disabled disabled-tmp" data-toggle="tooltip" data-placement="top" title="ログインが必要です">★お気に入り登録</button>
			<?php endif; ?>
		</div>
		<div class="col-md-2">
			<?php
			if ($gamemode != GAME_MODE_RANK) {
				?> <a class="btn btn-default" href="<?= $game->get_link() ?>">単語ランキングを見る</a> <?php
			} else {
				echo '<a class="btn btn-default" href="' . $game->get_link() . '">ゲームページヘ</a>';
			}
			?>
		</div>
	</div>
	<div class="description">
		<p><?= $game->get_wraped_description() ?></p>
		<?php
		echo '<div class="tweet-btn-box">';
		$text = $game->get_full_title(TRUE);
		sharebtn_twitter($text, $game->get_link(), 'tweet');
		echo '</div>';
		?>
	</div>
	<div class="tag-box">
		<?php
		foreach ($game->tags as $tag) {
			echo '<div class="tag">' . wrap_taglink_only($tag) . '</div>';
		}
		?>
	</div>
</div>