<div id="topjumbo" class="jumbotron">
	<h1>言えるかな<img class="log-img" src="<?= base_url(PATH_IMG . 'logo.png') ?>" /></h1>
	<p class="description">
		<strong>腕試し</strong>に<strong>暇つぶし</strong>に<strong>学習</strong>に<br />
		<span class="strong-s">言えるかな？</span>とは、お題に沿った単語のリストの中でいくつ答えられるかを試すゲームです<br />
		このサイトはいろいろな人が作った<span class="strong-s">言えるかな？</span>で遊ぶことが出来るサイトです<br />
		あなたの作りたい言えるかな？を作ることも出来ます
	</p>
	<div class="row sub-btns">
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
