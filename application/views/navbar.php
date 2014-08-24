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

		<a class="navbar-brand" href="<?= base_url() ?>"><?= SITE_NAME ?></a>
	</div>
	<div class="navbar-collapse collapse navbar-categlyes">
		<ul class="nav navbar-nav navbar-right">
			<li>
				<a <?= attr_href(PATH_MAKE, NULL, TRUE) ?>>言えるかなを作成</a>
				<?php
				if (empty($user)) {
					?>
				<li>
					<a <?= attr_href(PATH_AUTH_LOGIN) ?>>Twitterでログイン</a>
					<?php
				} else {
					?>
				<li>
					<img src="<?= $user->img_url ?>" alt="アイコン">
				<li>
					<a <?= attr_href('//twitter.com/' . $user->screen_name, NULL, FALSE) ?>><?= $user->screen_name ?></a>
				<li>
					<a <?= attr_href(PATH_AUTH_LOGOUT) ?>>ログアウトする</a>
				<?php } ?>

		</ul>
	</div>
</nav>


<div class="container">