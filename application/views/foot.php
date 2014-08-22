<!-- jQuery include -->
<?= tag_script_js(URL_JQUERY); ?> 

<!-- Incliude Twitter share button widgets -->
<?= tag_script_js(URL_TWITTER_WIDGETS); ?> 
<?= tag_script_js(base_url(PATH_BOOTSTRAP_JS)); ?> 

<!-- js of act on all page-->
<?= tag_script_js(base_url(PATH_JS . 'script.js')); ?>

<?php
if (!empty($jss)) {
	foreach ($jss as $js) {
		?>
		<script src="<?= base_url(PATH_JS . "{$js}.js") ?>" type="text/javascript"></script>
		<?php
	}
}
?>