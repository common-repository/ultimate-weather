<?php
/*
  Plugin Name:Ultimate Weather
  Plugin URI:http://www.junktheme.com
  Description:
  Version: 1.1
  Author: Junk Theme
  Author URI: http://www.junktheme.com
 */
include dirname(__FILE__) . '/inc/bs_weather_post.php';
include dirname(__FILE__) . '/bs_weather_shortcode.php';
class Bs_Weather{
	public function Bs_Weather_Instance(){
		$custom_post=new Bs_weather_Post('bs-weather');
		$custom_post->Bs_Make_Weather_Post('bs_weather','Ultimate Weather','Ultimate Weathers',array('supports'=>array('title')));
		add_action('save_post', array($this, 'bs_weather_save_post'), 10, 2);
		add_action('admin_init',array($this,'bs_weather_metabox'));
		add_action('admin_init', array($this, 'bs_weather_shortcode'));
		add_action('admin_enqueue_scripts', array($this, 'bs_weather_color_picker'));
	}
	public function Bs_Weather_Getinstance(){
		$this->Bs_Weather_Instance();
	}
	public function bs_weather_metabox(){
		add_meta_box( 'bs_weather_id', 'Add Weather', array($this,'bs_weather_showmeta'),'bs_weather', 'normal', 'high');
	}
	public function bs_weather_shortcode(){
		add_meta_box('bs_weather_shortcode_id', 'ShortCode', array($this, 'bs_weather_showshortcode'), 'bs_weather', 'side', 'low');
	}
	public function bs_weather_showshortcode(){?>
		<div class="bs_img_comparison_sh">
            <input type="text" class="input_shortcode_weather" size="30px" onClick="this.setSelectionRange(0, this.value.length)" value="[bs_ultimate_weather id='<?= get_the_id(); ?>']" disabled></input>
        </div>
	<?php }

	public function bs_weather_save_post($post_id, $bs_weather){
		if (!isset($_POST['bs_weather_noncefeild']) || !wp_verify_nonce($_POST['bs_weather_noncefeild'], 'bs_weather_nonce')) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        $value=array('bs_city','bs_temp','forecast_show_days','show_only_forecast','forecast_bg_color','font_color','singel_bg_color');
        foreach ($_POST as $key => $data_table) {
        	if(in_array($key, $value)){
        		update_post_meta($post_id, $key, $data_table);
        	}
        }
	}
	public function bs_weather_showmeta($bs_weather){
		wp_nonce_field('bs_weather_nonce','bs_weather_noncefeild');
		$bs_city = get_post_meta($bs_weather->ID, 'bs_city', true);
		$bs_temp = get_post_meta($bs_weather->ID, 'bs_temp', true);
		$forecast_show_days = get_post_meta($bs_weather->ID, 'forecast_show_days', true);
		$show_only_forecast = get_post_meta($bs_weather->ID, 'show_only_forecast', true);
		$forecast_bg_color = get_post_meta($bs_weather->ID, 'forecast_bg_color', true);
		$font_color = get_post_meta($bs_weather->ID, 'font_color', true);
		$singel_bg_color = get_post_meta($bs_weather->ID, 'singel_bg_color', true);
		require_once(dirname(__FILE__).'/inc/bs_weather_metafield.php');
	}
	public function bs_weather_color_picker(){
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('bs_weather_colorpicker', plugins_url('js/color_picker.js', __FILE__), array('wp-color-picker'), '', true);
	}
}
$var=new Bs_Weather();
$var->Bs_Weather_Getinstance();
?>