<?php

class Bs_ultimate_weather_shortcode {

    public function __construct() {

        add_shortcode('bs_ultimate_weather', array($this, 'show_shortcode_bs_ultimate_weather'));
        add_action('wp_enqueue_scripts', array($this, 'bs_ultimate_weather_enqueue_scripts'));
    }

    public function get_weather_icon($forcast_icon) {
            $w_icon = array(
                'Clear' => 'wi wi-day-sunny',
                'Partly Cloudy'=>'wi wi-day-cloudy',
                'Sunny'=>'wi wi-day-sunny',
                'Light Rain'=>'wi wi-day-rain',
                'Mostly Cloudy'=>'wi wi-day-cloudy-high',
                'Thunderstorm'=>'wi wi-day-thunderstorm',
                'Mostly Sunny'=>'wi wi-day-sunny',
                'Rain'=>'wi wi-day-rain-mix',
                'Scattered Showers'=>'wi wi-storm-showers',
                'Thunderstorms'=>'wi wi-day-thunderstorm',
                'Cloudy'=>'wi wi-cloud',
                'Breezy'=>'wi wi-strong-wind',
                'Scattered Thunderstorms'=>'wi wi-day-thunderstorm'
            );
            foreach ($w_icon as $key => $w_icons) {
                    if ($key==$forcast_icon) {
                        return $w_icons;
                    }
            }
                
    }
    public function show_shortcode_bs_ultimate_weather($atts, $content = NULL) {
        extract(shortcode_atts(
             array(
            'id' => '',
           
            ), $atts)
        );
        $query_args = array(
            'p' => (!empty($id)) ? $id : -1,
            'posts_per_page' => -1,
            'post_type' => 'bs_weather',
            'order' => 'DESC',
            'orderby' => 'menu_order',
        );
        $wp_query = new WP_Query($query_args);
        if ($wp_query->have_posts()):while ($wp_query->have_posts()) : $wp_query->the_post();
                $city = get_post_meta($id, 'bs_city', true);
                $temp = get_post_meta($id, 'bs_temp', true);
                $forecast_show_days = get_post_meta($id, 'forecast_show_days', true);
                $show_only_forecast = get_post_meta($id, 'show_only_forecast', true);
                $forecast_bg_color = get_post_meta($id, 'forecast_bg_color', true);
                //$font_color = get_post_meta($id, 'font_color', true);
                $singel_bg_color = get_post_meta($id, 'singel_bg_color', true);
            endwhile;
        
        $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
        $query = 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="' . $city . '")and u="' . $temp . '"';
        $query = $BASE_URL . "?q=" . urlencode($query) . "&format=json";
        $session = curl_init($query);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($session);
        $weather_values = json_decode($json);
        if(!empty($weather_values)):
        foreach ($weather_values as $weather_value) {
            $weather_value->results->channel->location->city;
        }
        endif;
        $forcast = $weather_value->results->channel->item->condition->text;
        $forcast_icon=$weather_value->results->channel->item->condition->text;
        ob_start();
        ?>
        <div class="sample">
        <?php if($show_only_forecast=='no'):?>
            <div id="example-5" style="background-color: <?php echo $singel_bg_color;?>">
                <div class="flatWeatherPlugin simple"><h2><?= $weather_value->results->channel->location->country . ',' . $weather_value->results->channel->location->city; ?></h2>
                    <div class="wiToday">
                        <div class="wiIconGroup">
                            <div class="wi wi501"></div>
                            <span class="sunny"><i class="<?php echo $this->get_weather_icon($forcast_icon); ?>"></i></span>
                            <p class="wiTexts"><?= $forcast_icon ?></p>
                        </div>
                        <p class="wiTemperature"><?= $weather_value->results->channel->item->condition->temp; ?><sup>&deg;<?php echo $temp; ?></sup></p>
                    </div>
                </div>
            </div>
        <?php  endif;?>    
        </div>
        <div id="example-1" style="background-color: <?php echo $forecast_bg_color;?>">
            <div class="flatWeatherPlugin full">
                <div class="left-area">
                    <h2><?= $weather_value->results->channel->location->country . ',' . $weather_value->results->channel->location->city; ?></h2>
                    <p class="date-time"><?= $weather_value->results->channel->item->condition->date; ?></p>
                    <h2>
                    <span class="humani"> Humidity </span>            
                    <span class="humanity"><i class="wi wi-humidity"></i><?= $weather_value->results->channel->atmosphere->humidity;?></span>
                    </h2>
                </div>
                <div class="right-area">
                    <p class="wiText"><?php
                        echo '<i class="wi wi-sunrise"></i>' . ' ' . $sunrise = $weather_value->results->channel->astronomy->sunrise;
                        echo "<br>";
                        echo '<i class="wi wi-sunset"></i>' . '  ' . $sunset = $weather_value->results->channel->astronomy->sunset;
                        ?></p>
                </div>        
                    <ul class="wiForecasts">
                        <?php
                        $forcast = $weather_value->results->channel->item->forecast;
                        for ($i = 0; $i < $forecast_show_days; $i++):
                            ?>
                            <li class="wiDay"><span><?= $forcast[$i]->day; ?></span>
                                <ul class="wiForecast">
                                    <li class="wi wi800"></li>
                                    <li>
                                        <i class="<?php echo $this->get_weather_icon($forcast[$i]->text); ?>"></i>
                                        <p class="wiText"><?= $forcast[$i]->text; ?></p>
                                    </li>
                                    <li class="wiMax"><?= $forcast[$i]->high; ?><sup>°<?php echo $temp; ?></sup> <span class="arrow"><i class="wi wi-direction-up"></i></span></li>
                                    <li class="wiMin"><?= $forcast[$i]->low; ?><sup>°<?php echo $temp; ?></sup><span class="arrow-down"><i class="wi wi-direction-down"></i></span></li>
                                </ul>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </div>
            <div class="clear"> </div>
            <?php
            $content = ob_get_contents();
            ob_get_clean();
            return $content;
            else: echo 'No Weather Found';
            endif;
        }

        public function bs_ultimate_weather_enqueue_scripts() {
            wp_enqueue_style('bs_ultimate_weather_css', plugin_dir_url(__FILE__) . 'css/style.css');
            wp_enqueue_style('bs_ultimate_weather_css_icon', plugin_dir_url(__FILE__) . 'css/weather-icons.min.css');
        }

    }

    new Bs_ultimate_weather_shortcode();


