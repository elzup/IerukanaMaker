<?php ?>

<div id="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="row">
					<div class="col-md-4">
						<b>メニュー</b>
						<ul>
							<li><a href="<?= base_url() ?>">トップページ</a>
							<li><a href="<?= base_url(PATH_HELP) ?>">言えるかなを作る</a>
							<li><a href="<?= base_url(PATH_USER) ?>">マイページ</a>
							<li><a href="<?= base_url(PATH_HELP) ?>">ヘルプ</a>
						</ul>
					</div>
					<div class="col-md-4">
						<b>リスト</b>
						<ul>
							<li><a href="<?= base_url(PATH_HOT) ?>">人気の言えるかな</a>
							<li><a href="<?= base_url(PATH_NEW) ?>">新着言えるかな</a>
						</ul>
					</div>
					<div class="col-md-4">
						<b>リンク</b>
						<ul>
							<li><a href="https://twitter.com/ierukana" class="twitter-follow-button" data-show-count="false">Follow @ierukana</a>
								<script>!function(d, s, id) {
										var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
										if (!d.getElementById(id)) {
											js = d.createElement(s);
											js.id = id;
											js.src = p + '://platform.twitter.com/widgets.js';
											fjs.parentNode.insertBefore(js, fjs);
										}
									}(document, 'script', 'twitter-wjs');</script>
						</ul>
						<b>シェア</b>
						<ul>
							<li>
								<div class="tweet-btn">
<?php
$text = '言えるかな？ゲームに挑戦しよう';
sharebtn_twitter($text, base_url(), TRUE, TRUE);
?>
								</div>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>