<?php
/* @var $hot_games Gameobj[] */
/* @var $new_games Gameobj[] */
//var_dump($hot_games);
//var_dump($new_games);
?>

<div class="content">
	<div id="topjumbo" class="jumbotron">
		<h1>言えるかな<img class="log-img" src="<?= base_url(PATH_IMG . 'logo.png') ?>" /></h1>
		<p class="description">
			<span class="strong-s">言えるかな？</span>とは、お題に沿った単語のリストの中でいくつ答えられるかを試すゲームです<br />
			このサイトはいろいろな人が作った<span class="strong-s">言えるかな？</span>で遊ぶことが出来るサイトです<br />
			あなたの作りたい言えるかな？を作ることも出来ます
		</p>
		<div class="float-left">
			<a class="btn btn-primary btn-lg" href="<?= base_url(PATH_MAKE) ?>">言えるかな？を作る</a>
		</div>
		<div class="tweet-btn">
			<?php
			$text = '言えるかな？ゲームに挑戦しよう';
			sharebtn_twitter($text, base_url(), TRUE, TRUE);
			?>
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
		<div class="col-md-6">
			<h2 class="sub-title">人気な言えるかな</h2>
			<table class="table table-hover table-games games-new">
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
		<div class="col-md-6">
			<h2 class="sub-title">新着の言えるかな</h2>
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