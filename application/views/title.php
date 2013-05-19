<div class="row-fluid">
	<div class="page-header">
		<div class="row-fluid">
			<h1>
			<?php
				if (isset($icon)) {
						echo "<img src='".base_url('img/type_icons/'.$icon->icon)."' />";
				}
			?>
			<?= $title ?></h1>
		</div>
	</div>
</div>
