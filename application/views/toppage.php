<?php
/* @var $hot_games Gameobj[] */
/* @var $new_games Gameobj[] */
/* @var $word Word */
/* @var $tags string[] */
/* @var $recent_games Gameobj[] */
?>

<div class="content">
	<div id="topjumbo" class="jumbotron">
		<h1>言えるかな<img class="log-img" src="<?= base_url(PATH_IMG . 'logo.png') ?>" /></h1>
		<p class="description">
			<span class="strong-s">言えるかな？</span>とは、お題に沿った単語のリストの中でいくつ答えられるかを試すゲームです<br />
			このサイトはいろいろな人が作った<span class="strong-s">言えるかな？</span>で遊ぶことが出来るサイトです<br />
			あなたの作りたい言えるかな？を作ることも出来ます
		</p>
		<div class="row">
			<div class="col-md-3">
				<a class="btn btn-primary btn-lg btn-block" href="<?= base_url(PATH_MAKE) ?>">言えるかな？を作る</a>
			</div>
			<div class="col-md-3">
				<button id="btn-please" class="btn btn-primary btn-lg btn-block">誰か作ってと頼む</button>
			</div>
			<div class="col-md-3">
				<div class="tweet-btn">
					<?php
					$text = '言えるかな？ゲームに挑戦しよう';
					sharebtn_twitter($text, base_url(), TRUE, TRUE);
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<?php
			$this->load->view('searchform');
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="tag-box plate">
				<?= tag_icon('tags')?>
				注目のタグ: 
				<?php
				foreach ($tags as $tag) {
					echo '<span class="tag">';
					echo wrap_taglink_only($tag);
					echo '</span>';
				}
				?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-5 col-md-offset-1">
			<ul class="nav nav-tabs nav-tabs-gamelist">
				<li class="active"><a href="#gamelist-hot" data-toggle="tab"><h3 class="sub-title">人気</h3></a></li>
				<li class=""><a href="#gamelist-new" data-toggle="tab"><h3 class="sub-title">新着</h3></a></li>
				<li class=""><a href="#gamelist-recent" data-toggle="tab"><h3 class="sub-title">おすすめ</h3></a></li>
			</ul>
			<div id="tab-content-gamelist" class="tab-content">
				<div class="tab-pane fade active in" id="gamelist-hot">
					<table class="table table-hover table-games games-hot">
						<?php foreach ($hot_games as $i => $game) { ?>
							<tr>
								<td class="name"><a href="<?= base_url(PATH_GAME . $game->id) ?>"><span class="over-text-wrap"><?= $game->get_full_title() ?></span></a></td>
								<!--<td class="count"><?= $game->play_count ?></td>-->
							</tr>
						<?php } ?>
					</table>
					<ul class="pager">
						<li class="next"><a href="<?= PATH_HOT ?>" class="">もっと見る</a>
					</ul>
				</div>
				<div class="tab-pane fade" id="gamelist-new">
					<table class="table table-hover table-games games-new">
						<?php foreach ($new_games as $game) { ?>
							<tr>
								<td class="name"><a href="<?= base_url(PATH_GAME . $game->id) ?>"><?= $game->get_full_title() ?></a></td>
							</tr>
						<?php } ?>
					</table>
					<ul class="pager">
						<li class="next"><a href="<?= PATH_NEW ?>" class="">もっと見る</a>
					</ul>
				</div>
				<div class="tab-pane fade" id="gamelist-recent">
					<table class="table table-hover table-games games-recent">
						<?php foreach ($recent_games as $game) { ?>
							<tr>
								<td class="name"><a href="<?= base_url(PATH_GAME . $game->id) ?>"><?= $game->get_full_title() ?></a></td>
							</tr>
						<?php } ?>
					</table>
					<ul class="pager">
						<li class="next"><a href="<?= PATH_NEW ?>" class="">もっと見る</a>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<h2 class="sub-title">最近人気のワード</h2>
			<ul class="aborted-list">
				<?php
				foreach ($recent_games as $i => $game) {
					$words = $game->get_words_popular();
					list($k, $word) = each($words);
					?>
					<li>
						<span class="word"><?= $word->text ?></span>
						<span class="game-name"><a href="<?= base_url(PATH_GAME . $game->id) ?>"><?= $game->get_full_title() ?></a></span>
					</li>
					<?php
					if ($i >= 4) {
						break;
					}
				}
				?>
			</ul>
			<h2 class="sub-title">最近忘れられたワード</h2>
			<ul class="aborted-list">
				<?php
				foreach ($recent_games as $i => $game) {
					$words = $game->get_words_abord();
					list($k, $word) = each($words);
					?>
					<li>
						<span class="word"><?= $word->text ?></span>
						<span class="game-name"><a href="<?= base_url(PATH_GAME . $game->id) ?>"><?= $game->get_full_title() ?></a></span>
					</li>
					<?php
					if ($i >= 4) {
						break;
					}
				}
				?>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
		</div>
		<div class="col-md-6">
			<a class="twitter-timeline"  href="https://twitter.com/search?q=ierukana%2Felzup.com"  data-widget-id="504209063970750464">ierukana/elzup.com に関するツイート</a>
			<script>!function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
					if (!d.getElementById(id)) {
						js = d.createElement(s);
						js.id = id;
						js.src = p + "://platform.twitter.com/widgets.js";
						fjs.parentNode.insertBefore(js, fjs);
					}
				}(document, "script", "twitter-wjs");</script>
		</div>
	</div>
</div>