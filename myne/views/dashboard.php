<div class="row-fluid">
	<div class="span4">
		<h3>Wetter für <?= $this->tools->getSettingByName('weather_location'); ?></h3>
		<hr>
		<?php 
			$this->load->model('weather/weather');
			$city = $this->tools->getSettingByName('weather_location');

			if ($city == "0") {
				echo "<p>Kein Ort für die Wetteranzeige gesetzt. Bitte in den <a href='/settings' title='Einstellungen'>Einstellungen</a> setzen.</p>";
			}
			else {
				$weather_data = $this->weather->get_weather_by_city($city);
				?>
					<p><b><?= $weather_data->name; ?></b> <img src="<?= base_url('img/weather_icons')."/".$weather_data->weather[0]->icon; ?>" title="<?= $weather_data->weather[0]->description; ?>" /> <b><?= $weather_data->main->temp; ?> °C</b></p>
					<p>Temperatur: <b><?= $weather_data->main->temp; ?> °C</b></p>

					<?php
						echo "<pre>".print_r($weather_data,true)."</pre>";
					?>
				<?php
			}
			
		?>
	</div>
</div>
