<?php

if (isset($_POST['Submit'])) {
    $name = $_POST['cityname'];

    $apiKey = "483d7222577eb25976873f990576b98d";
    $googleApiUrl = "http://api.openweathermap.org/data/2.5/forecast?q=" . $name . "&units=metric&appid=" . $apiKey . "";

// appid=1c9f66ca3cef9fc28af0cd4bc8e09522

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $googleApiUrl);

    $response = curl_exec($ch);

    curl_close($ch);
    $data = json_decode($response);
    $data2 = json_decode($response,true);
    if(count($data2)!=2)
    {

    

    $lon = $data->city->coord->lon;
    $lat = $data->city->coord->lat;
    

    $url = "https://api.openweathermap.org/data/2.5/onecall?lat=" . $lat . "&lon=" . $lon . "&exclude=minutely,hourly&units=metric&appid=" . $apiKey . "";

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_URL, $url);

    $curl_response = curl_exec($curl);

   
    curl_close($curl);
    $curl_data = json_decode($curl_response);
    $curl_data1 = json_decode($curl_response,true);
   

    echo "<pre>";
    // print_r($curl_data);
    echo "</pre>";

    $currentTime = time();
    } 

}

?>

<!doctype html>
<html>
<head>
<title>Forecast Weather using OpenWeatherMap with PHP</title>

<style>
body {
font-family: Arial;
font-size: 0.95em;
color: #929292;
}

.report-container {
border: #E0E0E0 1px solid;
padding: 20px 40px 40px 40px;
border-radius: 2px;
width: 550px;
margin: 0 auto;
}

.weather-icon {
vertical-align: middle;
margin-right: 20px;
}

.weather-forecast {
color: #212121;
font-size: 1.2em;
font-weight: bold;
margin: 20px 0px;
}

span.min-temperature {
margin-left: 15px;
color: #929292;
}

.time {
line-height: 25px;
}
</style>

</head>
<body>


<div>
<form method="Post" action="curl.php">
    <label>City Name :
        <input type="text" name="cityname" placeholder="City Name" id="name" style="margin:30px"><br>
    </label>


    <!-- <label>Number of days :
        <input type="number" name="days" placeholder="Days" id="days"><br>
    </label> -->

    <input type="submit" value="Submit" name="Submit" id="submit">


</form>


</div>

<?php if (isset($_POST['Submit'])) {

if(count($data2)!=2)
{



    ?>
<div class="report-container">
<h2><?php echo ucwords($name); ?> Weather Status</h2>

<?php

    foreach ($curl_data->daily as $key => $val) {

        foreach ($val->weather as $val2) {

            ?>






<div class="time">
<div><?php echo date('l F\'y, d', $val->dt); ?></div>

<?php

            ?>



<div><?php echo ucwords($val2->description); ?></div>
</div>
<div class="weather-forecast">


<img
src="http://openweathermap.org/img/w/<?php echo $val2->icon; ?>.png"
class="weather-icon" /> <?php echo $val->temp->max; ?>&deg;C<span
class="min-temperature"><?php echo $val->temp->min; ?>&deg;C</span>
</div>
<div class="time">
<div>Humidity: <?php echo $val->humidity; ?> %</div>
<div>Wind: <?php echo $val->wind_deg; ?> km/h</div>
<hr>


</div>
<?php

        }
    }
} else
{
    echo"<script>
    alert('No City Name Found');
    </script>";
}
        
        }?>
</div>


</body>
</html>


