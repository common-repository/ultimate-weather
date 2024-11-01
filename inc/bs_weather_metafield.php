<div class="bs_price_title">
    <div class="price_table_left">
         <label class="bs_price_table_label_title" >City</label>
    </div> 
    <div class="price_table_right"> 
         <input class="price_table_cl" type="text" name="bs_city" value="<?=esc_attr($bs_city);?>"></input>
    </div>     
</div>
	<div class="price_table_left">
    <label class="bs_price_table_label">Temperature</label>
</div>
<div class="price_table_right">     
        <select  class="price_table_cl" id='bs_temp' name="bs_temp">;
        <?php 
            $values = array('f'=>'F','c'=>'C');
            foreach ( $values as $key=>$value ) {
                echo '<option value="' . esc_attr($key) . '"';
                if ( $key == $bs_temp ) {
                    echo 'selected="selected"';
                }
                echo '>' . esc_attr($value) . '</option>';
                }
         ?>
        </select> 
	</div> 

	<div class="price_table_left">
    <label class="bs_price_table_label">Forecast Show Days</label>
</div>
<div class="price_table_right">     
        <select  class="price_table_cl" id='forecast_show_days' name="forecast_show_days">;
        <?php 
            $values = array(1,2,3,4,5,6,7,8,9,10);
            foreach ( $values as $key ) {
                echo '<option value="' . esc_attr($key) . '"';
                if ( $key == $forecast_show_days ) {
                    echo 'selected="selected"';
                }
                echo '>' . esc_attr($key) . '</option>';
                }
         ?>
        </select> 
	</div>       

	<div class="price_table_left">
    <label class="bs_price_table_label">Show Only Forecast</label>
</div>
<div class="price_table_right">     
        <select  class="price_table_cl" id='show_only_forecast' name="show_only_forecast">;
        <?php 
            $values = array('yes'=>'YES','no'=>'NO');
            foreach ( $values as $key=>$value ) {
                echo '<option value="' . esc_attr($key) . '"';
                if ( $key == $show_only_forecast ) {
                    echo 'selected="selected"';
                }
                echo '>' . esc_attr($value) . '</option>';
                }
         ?>
        </select> 
	</div>
	<div class="price_table_left">
    <label class="bs_price_table_label">forecast Background Color</label>
</div>
<div class="price_table_right">   
    <input  type="text" class="bs_weather_color" name="forecast_bg_color" value="<?=esc_attr($forecast_bg_color);?>"></input>
</div>  
<!-- <div class="price_table_left">
    <label class="bs_price_table_label">Font Color</label>
</div>
<div class="price_table_right">   
    <input  type="text" class="bs_weather_color" name="font_color" value="<?=esc_attr($font_color);?>"></input>
</div>  --> 
<div class="price_table_left">
    <label class="bs_price_table_label">singel Background Color</label>
</div>
<div class="price_table_right">   
    <input  type="text" class="bs_weather_color" name="singel_bg_color" value="<?=esc_attr($singel_bg_color);?>"></input>
</div>  
