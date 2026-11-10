
<?php

date_default_timezone_set("America/New_York");

require( 'moonphase.inc.php' );

// Determine offset in seconds of system timezone from UTC
$origin_tz = date_default_timezone_get();
$origin_dtz = new DateTimeZone($origin_tz);
$origin_dt = new DateTime("now", $origin_dtz);
$timeZoneOffset = $origin_dtz->getOffset($origin_dt);

// Get Current Moon Phase
$moondata = phase();

$MoonPhase	= $moondata[0];
$MoonIllum	= $moondata[1];
$MoonAge	= $moondata[2];
$MoonDist	= $moondata[3];
$MoonAng	= $moondata[4];
$SunDist	= $moondata[5];
$SunAng		= $moondata[6];

// Get Moon Phases for current and next month
// Note some of these phases have already occured

if (date("d") > 15) $nextmoon = phasehunt( strtotime(date("Y-m-d")));
else $nextmoon = phasehunt( strtotime(date("Y-m-15")));

$MoonDate[0] = $nextmoon[0];
$MoonDate[1] = $nextmoon[1];
$MoonDate[2] = $nextmoon[2];
$MoonDate[3] = $nextmoon[3];
$MoonDate[4] = $nextmoon[4];
$MoonDate[5] = $nextmoon[5];
$MoonDate[6] = $nextmoon[6];
$MoonDate[7] = $nextmoon[7];
//$MoonDate[8] = $nextmoon[8];


$MoonName[0] = "New Moon";
$MoonName[1] = "First Qtr";
$MoonName[2] = "Full Moon";
$MoonName[3] = "Last Qtr";
$MoonName[4] = "New Moon";
$MoonName[5] = "First Qtr";
$MoonName[6] = "Full Moon";
$MoonName[7] = "Last Qtr";
$MoonName[8] = "New Moon";

$MoonGifImage[0] = "moon_0.gif";
$MoonGifImage[1] = "moon_7.gif";
$MoonGifImage[2] = "moon_14.gif";
$MoonGifImage[3] = "moon_21.gif";
$MoonGifImage[4] = "moon_0.gif";
$MoonGifImage[5] = "moon_7.gif";
$MoonGifImage[6] = "moon_14.gif";
$MoonGifImage[7] = "moon_21.gif";
$MoonGifImage[8] = "moon_0.gif";


// Work out which image to display for the current moon
$MoonImage = round( $MoonAge, 0 );

// Get Moon Illumination as percentage
$MoonPhasePercent = round( $MoonIllum, 2 ) * 100;

// Determine Name of Current Moon Phase
if ($MoonAge <  1.84566) $phaseText = 'New Moon';
else if ($MoonAge <= 5.53699)   $phaseText = 'Waxing Crescent';
else if ($MoonAge < 9.22831)    $phaseText = 'First Quarter Moon';
else if ($MoonAge <= 12.91963)  $phaseText = 'Waxing Gibbous';
else if ($MoonAge <= 16.61096)  $phaseText = 'Full Moon';
else if ($MoonAge <= 20.30228)  $phaseText = 'Waning Gibbous';
else if ($MoonAge <= 23.99361)  $phaseText = 'Last Quarter Moon';
else if ($MoonAge <= 27.68493)  $phaseText = 'Waning Crescent';
else $phaseText = 'New Moon';

?>








