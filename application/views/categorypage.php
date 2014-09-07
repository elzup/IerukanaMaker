<?php
/* @var $games_hot Gameobj[] */
/* @var $games_new Gameobj[] */
/* @var $games_recent Gameobj[] */
/* @var $tags string[] */
/* @var $category string[] */
?>

<div class="content">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<?php
			$this->load->view('searchform');
			?>
		</div>
	</div>
	<?php $this->load->view('categorynav', array('category' => $category)); ?>
	<?php $this->load->view('topmain', array('games_hot' => $games_hot, 'games_new' => $games_new, 'games_recent' => $games_recent, 'tags' => $tags)); ?>

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