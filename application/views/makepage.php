<?php
/* @var $game Gameobj */
/* @var $user Userobj */
?>

<div class="content">
	<?php
	if (!empty($user)) {
		$this->load->view('makeform', array('game' => @$game));
	} else {
		?>
		新しい言えるかなゲームを作成するにはTwitterアカウントでの認証が必要です
		<a class="btn btn-warning btn-lg" href="<?= base_url(PATH_AUTH_LOGIN) ?>">Twitter認証する</a>
		<?php
	}
	?>
</div>