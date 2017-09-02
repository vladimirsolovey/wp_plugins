<?php
/**
 * Date: 22.08.17
 * Time: 19:43
 * @var array $settings
 */

?>

<div class="wrap hf-sc-container">
	<h1 class="hf-sc-header">
	SoundCloud Settings
	</h1>

	<?php include HF_SOUND_CLOUD_PLUGIN_DIR.'/view/notification/notify.php'?>

	<form method="post" action="" name="save-sc-settings" id="hf-sc-settings-form" class="validate" novalidate="novalidate" autocomplete="off">
		<input type="hidden" value="1" name="hf-sc-save">
	<div class="hf-sc-box">
		<div class="hf-sc-box-title">
			<h3>SoundCloud API Settings</h3>
		</div>
		<div class="hf-sc-box-body">

			<div class="hf-sc-items">
				<div class="hf-sc-item">
					<div class="hf-sc-item-label">
						<label for="client-id">Client ID</label>
					</div>
					<div class="hf-sc-item-input">
						<input name="client-id" type="text" id="client-id" value="<?php echo $settings['client-id'];?>">
					</div>
				</div>

			</div>

		</div>
		<ul class="hf-sc-box-footer">
			<li class="hf-sc-box-btn-right">
				<input type="submit" class="button button-primary button-small" name="update-billing-address" value="Update">
			</li>
		</ul>
	</div>
		</form>
</div>
