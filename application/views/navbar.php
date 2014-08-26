<?php
/* @var $user Userobj */
/* @var $meta Metaobj */
$user;
if ($user == null) {
	$user = false;
}
?>
<nav class="navbar navbar-default" id="navbar">
	<div class="navbar-header">
		<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-categlyes">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>

		<a class="navbar-brand" href="<?= base_url() ?>">言えるかな<img class="log-img" src="<?= base_url(PATH_IMG . 'logo.png')?>" /></a>
	</div>
	<div class="navbar-collapse collapse navbar-categlyes">
		<ul class="nav navbar-nav navbar-right">
			<li>
				<a <?= attr_href(base_url(PATH_MAKE)) ?>>作成</a>
			<li>
				<a <?= attr_href(base_url(PATH_SEARCH)) ?>>検索</a>
			<li>
				<a <?= attr_href('//twitter.com/' . AUTHOR_TWITTER_SCREEN_NAME , NULL, FALSE) ?>>サポート</a>
				<?php
				if (empty($user)) {
					?>
				<li>
					<a <?= attr_href(base_url(PATH_AUTH_LOGIN)) ?>>Twitterでログイン</a>
					<?php
				} else {
					?>
				<li class="img">
					<img src="<?= $user->img_url ?>" alt="アイコン">
				<li>
					<a <?= attr_href('//twitter.com/' . $user->screen_name, NULL, FALSE) ?>><?= $user->screen_name ?></a>
				<li>
					<a <?= attr_href(base_url(PATH_AUTH_LOGOUT)) ?>>ログアウトする</a>
				<?php } ?>

		</ul>
	</div>
</nav>


<div class="container">