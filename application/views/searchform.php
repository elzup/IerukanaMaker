<?php
/* @var $q string */
$q = @$q ?: '';
?>

<div class="plate plate-search">
	<div class="form-group">
		<form action="<?= base_url(PATH_SEARCH) ?>" method="GET">
			<label class="col-md-2 col-xs-4 control-label" for="input-search"><?= tag_icon('search')?>検索</label>
			<div class="col-md-10 col-xs-8">
				<input name="q" class="form-control" id="input-search" value="<?= $q ?>" type="text">
			</div>
		</form>
	</div>
</div>