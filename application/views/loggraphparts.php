<?php
/* @var $logs Logobj[] */
/* @var $col int */
?>

<?php
if (isset($col)) {
	echo '<div class="col-md-' . $col . '">';
}
var_dump($logs);
?>

<?php
if (isset($col)) {
	echo '</div>';
}