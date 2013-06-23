<div class="row-fluid">
	<div class="span4">
		<h3>Wetter für <?= $this->tools->getSettingByName('weather_location'); ?></h3>
		<hr>
		<?php 
			$this->load->model('weather/weather');
			$weather_data = $this->weather->get_weather_by_city($this->tools->getSettingByName('weather_location'));
		?>

		<p><b><?= $weather_data->name; ?></b> <img src="<?= base_url('img/weather_icons')."/".$weather_data->weather[0]->icon; ?>" title="<?= $weather_data->weather[0]->description; ?>" /> <b><?= $weather_data->main->temp; ?> °C</b></p>
		<p>Temperatur: <b><?= $weather_data->main->temp; ?> °C</b></p>
	</div>
</div>
