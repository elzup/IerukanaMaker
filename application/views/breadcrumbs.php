<?php
/* @var $list array */
?>

<ul class="breadcrumb">
	<?php
	foreach ($list as $key => $url) {
		if ($url === TRUE) {
			echo '<li class="active">' . $key . '</li>';
			continue;
		}
		echo '<li><a href="' . $url . '">' . $key . '</a></li>';
	}
	?>
</ul>