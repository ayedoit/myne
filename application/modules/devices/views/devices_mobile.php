<div data-role="content">
	<ul data-role="listview" data-inset="false" data-filter="true" class="ui-listview">
		<?php
			$this->load->model('room');
			$rooms = $this->room->getRooms();
			foreach ($rooms as $room) {
				echo '<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-a ui-first-child">';
					echo '<div class="ui-grid-a">';
						echo '<div class="ui-block-a" style="text-align:left">'.$room->clear_name.'</div>';
						echo '<div class="ui-block-b" style="text-align:right">';
							echo '<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-inline="true" data-mini="true" data-disabled="false" class="ui-btn ui-btn-up-a ui-shadow ui-btn-corner-all ui-mini ui-btn-inline" aria-disabled="false"><span class="ui-btn-inner"><span class="ui-btn-text">An</span></span><button data-theme="a" data-mini="true" data-inline="true" data-type="room" data-name="'.$room->name.'" class="toggle_on ui-btn-hidden" data-disabled="false">Ein</button></div>';
							echo '<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-inline="true" data-mini="true" data-disabled="false" class="ui-btn ui-btn-up-a ui-shadow ui-btn-corner-all ui-mini ui-btn-inline" aria-disabled="false"><span class="ui-btn-inner"><span class="ui-btn-text">Aus</span></span><button data-theme="a" data-mini="true" data-inline="true" data-type="room" data-name="'.$room->name.'" class="toggle_off ui-btn-hidden" data-disabled="false">Aus</button></div>';
						echo '</div>';
					echo '</div>';
				echo '</li>';
				
				// Get group members
				$this->load->model('device');
				$devices = $this->device->getDevicesByRoom($room->id);
				foreach ($devices as $device) {
					echo '<li class="ui-li ui-li-static ui-btn-up-a">';
						echo '<div class="ui-grid-a">';
							echo '<div class="ui-block-a" style="text-align:left">'.$device->clear_name.'</div>';
							echo '<div class="ui-block-b" style="text-align:right">';
							
							$options = $this->device->getOptionsByDeviceID($device->id);
							if (array_key_exists('toggle',$options)) {
								echo '<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-inline="true" data-mini="true" data-disabled="false" class="ui-btn ui-btn-up-a ui-shadow ui-btn-corner-all ui-mini ui-btn-inline" aria-disabled="false"><span class="ui-btn-inner"><span class="ui-btn-text">An</span></span><button data-theme="a" data-mini="true" data-inline="true" data-type="device" data-name="'.$device->name.'" class="toggle_on ui-btn-hidden" data-disabled="false">Ein</button></div>';
								echo '<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-inline="true" data-mini="true" data-disabled="false" class="ui-btn ui-btn-up-a ui-shadow ui-btn-corner-all ui-mini ui-btn-inline" aria-disabled="false"><span class="ui-btn-inner"><span class="ui-btn-text">Aus</span></span><button data-theme="a" data-mini="true" data-inline="true" data-type="device" data-name="'.$device->name.'" class="toggle_off ui-btn-hidden" data-disabled="false">Aus</button></div>';
							}
							
							echo '</div>';
						echo '</div>';
					echo '</li>';
				}
			}
		?>
	</ul>
</div>
<script>
	$(document).ready(function() {
		$('.toggle_on').click(function() {
			$(this).myne_api({
			  method: "toggle",
			  params: {"model": "devices/device", "opts":{"type":$(this).data('type'),"name":$(this).data('name'),"status":"on"}}
			});
		});
		
		$('.toggle_off').click(function() {
			$(this).myne_api({
			  method: "toggle",
			  params: {"model": "devices/device", "opts":{"type":$(this).data('type'),"name":$(this).data('name'),"status":"off"}}
			});
		});
	});
</script>
