<?php
	/** @var \Core\Classes\View $this */
	/** @var array $data */
	/** @var array $attributes */
	/** @var array $errors */
	/** @var string $field_string */

	if(!$attributes['params']['show_title_in_form']){ unset($attributes['title']); }

	$field_string = $this->getAttributesStringFromArray($attributes);
?>

<div class="fields" id="geo-fields-list">
	<input id="country" type="hidden" name="<?php print $attributes['params']['country']['name'] ?>" value="<?php print $attributes['params']['country']['id'] ?>">
	<input id="region" type="hidden" name="<?php print $attributes['params']['region']['name'] ?>" value="<?php print $attributes['params']['region']['id'] ?>">
	<input id="city" type="hidden" name="<?php print $attributes['params']['city']['name'] ?>" value="<?php print $attributes['params']['city']['id'] ?>">

	<div class="country field mt-2 radius-0">
		<label class="form-check-label" for=""><?php print fx_lang('home.country_label') ?></label>
		<input id="for-country" class="radius-0 form-control" placeholder="<?php print fx_lang('home.country_placeholder') ?>" type="text" value="<?php print $attributes['params']['country']['value'] ?>">
	</div>
	<div class="region field mt-2 radius-0">
		<label class="form-check-label" for=""><?php print fx_lang('home.region_label') ?></label>
		<input id="for-region" class="radius-0 form-control" placeholder="<?php print fx_lang('home.region_placeholder') ?>" type="text" value="<?php print $attributes['params']['region']['value'] ?>">
	</div>
	<div class="city field mt-2 radius-0">
		<label class="form-check-label" for=""><?php print fx_lang('home.city_label') ?></label>
		<input id="for-city" class="radius-0 form-control" placeholder="<?php print fx_lang('home.city_placeholder') ?>" type="text" value="<?php print $attributes['params']['city']['value'] ?>">
	</div>
</div>

<script>
	$(document).ready(function(){
		let lang = "<?php print $this->language->getLanguageKey() ?>";
		let self = this;
		let value;
		let timer_out = null;

		let country_field_visible = $('#for-country');
		let region_field_visible = $('#for-region');
		let city_field_visible = $('#for-city');

		let country_field_hidden = $('#country');
		let region_field_hidden = $('#region');
		let city_field_hidden = $('#city');

		country_field_visible.on('input',function(e){
			value = $(this).val();
			if(timer_out){
				clearTimeout(timer_out);
			}
			timer_out = setTimeout(function(){
				country_field_hidden.val('');
				region_field_hidden.val('');
				city_field_hidden.val('');
				region_field_visible.val('');
				city_field_visible.val('');

				if(value){
					self.getCountry(value);
				}
			},1000);
		});
		region_field_visible.on('input',function(e){
			value = $(this).val();
			if(timer_out){
				clearTimeout(timer_out);
			}
			timer_out = setTimeout(function(){
				region_field_hidden.val('');
				city_field_hidden.val('');
				city_field_visible.val('');

				if(value){
					self.getRegion(value,country_field_hidden.val());
				}
			},1000);
		});
		city_field_visible.on('input',function(e){
			value = $(this).val();
			if(timer_out){
				clearTimeout(timer_out);
			}
			timer_out = setTimeout(function(){
				city_field_hidden.val('');

				if(value){
					self.getCity(value,region_field_hidden.val(),country_field_hidden.val());
				}
			},1000);
		});

		self.getCountry = function(value){
			$.ajax({
				beforeSend:function(){
					dropPanel();
					country_field_hidden.attr('disabled',true);
					region_field_hidden.attr('disabled',true);
					city_field_hidden.attr('disabled',true);
					country_field_visible.attr('disabled',true);
					region_field_visible.attr('disabled',true);
					city_field_visible.attr('disabled',true);
				},
				method: 'POST',
				url: '<?php print fx_get_url('home','get_country') ?>',
				data:{
					value: value,
				},
				success: function(response){
					let response_data = response.controller.home.geo;
					if(response_data.length > 0){
						let action_links = '<div class="clickable-geo-fields">';
						for(let i =0; i<response_data.length;i++){
							let title 	= 'g_title_' + lang;

							let country = '';
							if(response_data[i][title] !== null && response_data[i][title] !== undefined){
								country = response_data[i][title];
							}

							action_links += "<a href=\"javascript:void(0)\" onclick=\"setCountry('" + response_data[i].g_country_id + "', '" + response_data[i][title] + "')\">" +
								"<div class=\"link\">" +
								country +
								"</div>" +
 								"</a>";
						}
						action_links += '</div>';
						$('div.country','#geo-fields-list').append('<div class="closable"><a href="javascript:void(0)" onclick="dropPanel()">x</a></div>');
						$('div.country','#geo-fields-list').append(action_links);
					}
					country_field_hidden.removeAttr('disabled');
					region_field_hidden.removeAttr('disabled');
					city_field_hidden.removeAttr('disabled');
					country_field_visible.removeAttr('disabled');
					region_field_visible.removeAttr('disabled');
					city_field_visible.removeAttr('disabled');
					country_field_visible.focus();
				},
				dataType:'JSON'
			});
		};

		self.getRegion = function(value,country_id){
			$.ajax({
				beforeSend:function(){
					dropPanel();
					country_field_hidden.attr('disabled',true);
					region_field_hidden.attr('disabled',true);
					city_field_hidden.attr('disabled',true);
					country_field_visible.attr('disabled',true);
					region_field_visible.attr('disabled',true);
					city_field_visible.attr('disabled',true);
				},
				method: 'POST',
				url: '<?php print fx_get_url('home','get_region') ?>',
				data:{
					value: value,
					country_id: country_id,
				},
				success: function(response){
					let response_data = response.controller.home.geo;
					if(response_data.length > 0){
						let action_links = '<div class="clickable-geo-fields">';
						for(let i =0; i<response_data.length;i++){
							let country_title 	= 'g_title_' + lang;
							let region_title 	= 'gr_title_' + lang;

							let region = '';
							let country = '';
							if(response_data[i][region_title] !== null && response_data[i][region_title] !== undefined){
								region = response_data[i][region_title] + ", ";
							}
							if(response_data[i][country_title] !== null && response_data[i][country_title] !== undefined){
								country = response_data[i][country_title];
							}

							action_links += "<a href=\"javascript:void(0)\" onclick=\"setRegion('" + response_data[i].gr_region_id + "', '" + response_data[i][region_title] + "','" + response_data[i].g_country_id + "', '" + response_data[i][country_title] + "')\">" +
								"<div class=\"link\">" +
								region + country +
								"</div>" +
								"</a>";
						}
						action_links += '</div>';
						$('div.region','#geo-fields-list').append('<div class="closable"><a href="javascript:void(0)" onclick="dropPanel()">x</a></div>');
						$('div.region','#geo-fields-list').append(action_links);
					}
					country_field_hidden.removeAttr('disabled');
					region_field_hidden.removeAttr('disabled');
					city_field_hidden.removeAttr('disabled');
					country_field_visible.removeAttr('disabled');
					region_field_visible.removeAttr('disabled');
					city_field_visible.removeAttr('disabled');
					region_field_visible.focus();
				},
				dataType:'JSON'
			});
		};

		self.getCity = function(value,region_id,country_id){
			$.ajax({
				beforeSend:function(){
					dropPanel();
					country_field_hidden.attr('disabled',true);
					region_field_hidden.attr('disabled',true);
					city_field_hidden.attr('disabled',true);
					country_field_visible.attr('disabled',true);
					region_field_visible.attr('disabled',true);
					city_field_visible.attr('disabled',true);
				},
				method: 'POST',
				url: '<?php print fx_get_url('home','get_city') ?>',
				data:{
					value: value,
					region_id: region_id,
					country_id: country_id,
				},
				success: function(response){
					let response_data = response.controller.home.geo;
					if(response_data.length > 0){
						let action_links = '<div class="clickable-geo-fields">';
						for(let i =0; i<response_data.length;i++){
							let country_title 	= 'g_title_' + lang;
							let region_title 	= 'gr_title_' + lang;
							let city_title 	= 'gc_title_' + lang;

							let city = '';
							let area = '';
							let region = '';
							let country = '';
							if(response_data[i][city_title] !== null && response_data[i][city_title] !== undefined){
								city = response_data[i][city_title] + ", ";
							}
							if(response_data[i].gc_area !== null && response_data[i].gc_area !== undefined){
								area = response_data[i].gc_area + ", ";
							}
							if(response_data[i][region_title] !== null && response_data[i][region_title] !== undefined){
								region = response_data[i][region_title] + ", ";
							}
							if(response_data[i][country_title] !== null && response_data[i][country_title] !== undefined){
								country = response_data[i][country_title];
							}

							action_links += "<a href=\"javascript:void(0)\" onclick=\"setCity('" + response_data[i].gc_city_id + "', '" + response_data[i][city_title] + "','" + response_data[i].gr_region_id + "', '" + response_data[i][region_title] + "','" + response_data[i].g_country_id + "', '" + response_data[i][country_title] + "')\">" +
								"<div class=\"link\">" +
								city + area + region + country +
								"</div>" +
								"</a>";
						}
						action_links += '</div>';
						$('div.city','#geo-fields-list').append('<div class="closable"><a href="javascript:void(0)" onclick="dropPanel()">x</a></div>');
						$('div.city','#geo-fields-list').append(action_links);
					}
					country_field_hidden.removeAttr('disabled');
					region_field_hidden.removeAttr('disabled');
					city_field_hidden.removeAttr('disabled');
					country_field_visible.removeAttr('disabled');
					region_field_visible.removeAttr('disabled');
					city_field_visible.removeAttr('disabled');
					city_field_visible.focus();
				},
				dataType:'JSON'
			});
		};
	});

	setCountry = function(country_id,country_title){
		country_id = country_id === 'null' ? '' : country_id;
		country_title = country_title === 'null' ? '' : country_title;
		$('input#country').val(country_id);
		$('input#for-country').val(country_title);
		dropPanel();
	};

	setRegion = function(region_id,region_title,country_id,country_title){
		region_id = region_id === 'null' ? '' : region_id;
		region_title = region_title === 'null' ? '' : region_title;
		country_id = country_id === 'null' ? '' : country_id;
		country_title = country_title === 'null' ? '' : country_title;
		$('input#region').val(region_id);
		$('input#for-region').val(region_title);
		$('input#country').val(country_id);
		$('input#for-country').val(country_title);
		dropPanel();
	};

	setCity = function(city_id,city_title,region_id,region_title,country_id,country_title){
		city_id = city_id === 'null' ? '' : city_id;
		city_title = city_title === 'null' ? '' : city_title;
		region_id = region_id === 'null' ? '' : region_id;
		region_title = region_title === 'null' ? '' : region_title;
		country_id = country_id === 'null' ? '' : country_id;
		country_title = country_title === 'null' ? '' : country_title;
		$('input#city').val(city_id);
		$('input#for-city').val(city_title);
		$('input#region').val(region_id);
		$('input#for-region').val(region_title);
		$('input#country').val(country_id);
		$('input#for-country').val(country_title);
		dropPanel();
	};

	dropPanel = function(){
		$('.clickable-geo-fields').remove();
		$('.closable').remove();
	}

</script>