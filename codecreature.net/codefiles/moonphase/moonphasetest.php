


<meta http-equiv="Content-Type" content="text/html;charset=utf-8">

<?php

// Test Scripts for moonphase 
//
//
// requires moonphase.php and moonphase-inc.php

include 'moonphase.php';

echo "Current Server Time and Date: " .  date("l dS F Y h:i:s A") . "<br><br>\n";


echo "Current Time Zone: $origin_tz " . date('T') . "<br><br>\n";
echo "Time Zone Offset from UTC: " . $timeZoneOffset/(60*60) . " Hours<br><br>\n";
echo "Current Time and Date: " .  date("l dS F Y h:i:s A") . "<br><br>\n";

print "Moon Age: $MoonAge Days <br><br>";
print "Moon Phase: $phaseText <br><br>";
print "MoonIllum: $MoonIllum <br><br>";
print "Percent Illuminated: $MoonPhasePercent% <br><br>";

for ($i=0; $i<=7; $i++)
{
  echo $MoonName[$i] . ":  " . date("D M j G:i T Y", $MoonDate[$i]) . "<br><br>\n";
}

// Work out which image to display for the current moon
$MoonImage = round( $MoonAge, 0 );

print "Southern Hemisphere<br>";
print "<img src=south_moonimages/moon_$MoonImage.gif>";

print "<br>Northern Hemisphere<br>";
print "<img src=north_moonimages/moon_$MoonImage.gif>";

print "<br><br>"
?>





<table class="suntimes">
        <tr align=center>
         	<th>Current Moon</th>
<?php

// Skip over moon phases that have already occured 
// i.e. where time of phase is before the current time     
    $NextPhaseIndex=0;
	while($MoonDate[$NextPhaseIndex] < time() )
  	{
  		$NextPhaseIndex++;

  	}
  	
  	$j = $NextPhaseIndex;
  	for ($i=0; $i<=3; $i++)
	{
  		echo "		<th> $MoonName[$j] </th>\n";
  		$j++;
	}
?>
        </tr>
        <tr align=center>
            <td rowspan="2" ><?php echo "<img class=moon src=south_moonimages/moon_$MoonImage.gif>"; ?></td>           
<?php      
  	$j = $NextPhaseIndex;
  	for ($i=0; $i<=3; $i++)
	{
	 		echo "		<td><img class=\"moon\" src=south_moonimages/$MoonGifImage[$j] height=\"80%\"></td>\n";
  		$j++;
	} 	
?>
        </tr>
        <tr align=center>      
<?php      
  	$j = $NextPhaseIndex;
  	for ($i=0; $i<=3; $i++)
	{
  		echo "		<td>" . date("D M d", $MoonDate[$j]) . "</td>\n";
  		$j++;
	}	
?>
        </tr>
        <tr>
            <td><?php echo "$MoonPhasePercent% $phaseText"; ?></td>
        </tr>
</table>

