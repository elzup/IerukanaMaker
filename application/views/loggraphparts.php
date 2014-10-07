<?php
/* @var $logs Logobj[] */
/* @var $col int */
/* @var $word_num int */
/* @var $is_login bool */
?>

<?php
if (isset($col)) {
	echo '<div class="col-md-' . $col . '">';
}
if ($is_login) {
	// ログイン時
	?>
	<div class="plate plate-tab">
		<span class="sub-title">
			履歴
		</span>
	</div>
	<div class="plate plate-wide">
		前回の成績 [ <?= $logs[0]->point ?> /  <?= $word_num ?> ]
		<!--
		<svg height="110px" width="100%">	
		<?php
		$max = 0;
		foreach ($logs as $log) {
			$max = max($log->point, $max);
		}
		foreach ($logs as $i => $log) {
			$ph = $log->point / $max;
			$mh = 90;
			$x = $i * 30;
			$h = $mh * $ph;
			$y = $mh - $h;
			$w = 20;
			echo '<rect class="rect-test" x="' . $x . 'px" y="' . $y . '%" height="' . $h . '%" width="' . $w . 'px" fill="orange" />';
			echo '<text x="' . ($x + 12) . '" y="' . ($mh + 20) . '" font-size="10px">' . $log->point . '</text>';
		}
		?>
		</svg>
  -->
	</div>

	<?php
} else {
	// 非ログイン時
	?>
	<div class="plate plate-tab">
		<span class="sub-title">
			非ログインユーザです
		</span>
	</div>
	<?php
}
if (isset($col)) {
	echo '</div>';
}