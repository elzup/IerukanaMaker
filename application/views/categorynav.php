<?php
/* @var $category int */
?>
<ul class="nav nav-tabs">
	<?php
	$tab_codes = array();
	if ($category != GAME_CATEGORY_ALL) {
		$tab_codes[] = GAME_CATEGORY_ALL;
	}
	for ($i = 1; $i < GAME_CATEGORY_NUM; $i++) {
		$tab_codes[] = $i;
	}
	$tab_codes[] = GAME_CATEGORY_OTHER;
	foreach ($tab_codes as $code) {
		echo '<li class="' . ($code == $category ? 'active' : '' ) . '"><a href="' . PATH_CATEGORY . $code . '" >' . Gameobj::to_category_str($code) . '</a></li>';
	}
	?>
</ul>
