<?php

$a = @$_POST["current"];
$b = @$_POST["dest"];
if(!isset($a)){
	$a=1;
	$b=6;
}

//set the distance array
$_distArr = array();
$_distArr[1][2] = 10;
$_distArr[1][3] = 10;

$_distArr[2][1] = 10;
$_distArr[2][3] = 5;

$_distArr[3][1] = 10;
$_distArr[3][2] = 5;
$_distArr[3][4] = 2;

$_distArr[4][3] = 2;
$_distArr[4][5] = 12;
$_distArr[4][6] = 15;

$_distArr[5][4] = 12;
$_distArr[5][6] = 4;

$_distArr[6][5] = 4;
$_distArr[6][4] = 15;




//initialize the array for storing
$S = array();//the nearest path with its parent and weight
$Q = array();//the left nodes without the nearest path
foreach(array_keys($_distArr) as $val) $Q[$val] = 99999;
$Q[$a] = 0;

//start calculating
while(!empty($Q)){
    $min = array_search(min($Q), $Q);//the most min weight
    if($min == $b) break;
    foreach($_distArr[$min] as $key=>$val) if(!empty($Q[$key]) && $Q[$min] + $val < $Q[$key]) {
        $Q[$key] = $Q[$min] + $val;
        $S[$key] = array($min, $Q[$key]);
    }
    unset($Q[$min]);
}

//list the path
$path = array();
$pos = $b;
while($pos != $a){
    $path[] = $pos;
    $pos = $S[$pos][0];
}
$path[] = $a;
$path = array_reverse($path);

//print result



/* Latitute,Longitude Collection 17z
Mens Hostel = 12.9721166,79.1570022
SJT = 12.9709212,79.1617122
TT = 12.9708092,79.159500
Bihari Dhaba =12.9676232,79.1533935
Apna Travels = 12.9672768,79.1558235
fc = 12.970098, 79.159353
*/



?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <script src="http://maps.google.com/maps/api/js"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script src="js/gmaps.js"></script>
  <style type="text/css">
    #map {
      width: 560px;
      height: 440px;
    }
  </style>
</head>
<body>


<div style="background-color:#1abc9c;width:41.3%;height:60px;color:white" >
<div style="margin-top:20px"></div>

<?php 
echo "<br />From $a to $b";
echo "<br />The length is ".$S[$b][1];
echo " and the path is ".implode('->', $path);

?>
</div>
<div id="map" style="margin-top:20px" ></div>
<script>
   var map = new GMaps({
	  zoom: 16,
      el: '#map',
      lat: 12.9709212,
      lng: 79.16
	  });
	  path = [[12.9721166,79.16], [12.9709212,79.16400],[12.9708092,79.159500],[12.970098, 79.159353],[12.9676232,79.1533935],[12.9672768,79.1558235]];
	  path2 = [[12.9721166,79.16],[12.9708092,79.159500]];
	  path3 = [[12.970098, 79.159353],[12.9672768,79.1558235]];
	  

map.drawPolyline({
  path: path,
  strokeColor: '#131540',
  strokeOpacity: 0.6,
  strokeWeight: 6
});

map.drawPolyline({
  path: path2,
  strokeColor: '#131540',
  strokeOpacity: 0.6,
  strokeWeight: 6
});

map.drawPolyline({
  path: path3,
  strokeColor: '#131540',
  strokeOpacity: 0.6,
  strokeWeight: 6
});
	  
</script>
<div style="margin-top:-540px;margin-left:800px;position:absolute">
	<form method="post" action="nearest.php">
		<div style="float:left;">
		<h4> Current place </h4>
		<select name="current">
		  <option value="1">Mens Hostel</option>
		  <option value="2">SJT</option>
		  <option value="3">TT</option>
		  <option value="4">Food Court</option>
		  <option value="5">Apna Dhaba</option>
		  <option value="6">Bihari Dhaba</option>
		</select>
		</div>
		<div style="float:right;">
		<h4> Destination </h4>
		<select name="dest">
		  <option value="1">Mens Hostel</option>
		  <option value="2">SJT</option>
		  <option value="3">TT</option>
		  <option value="4">Food Court</option>
		  <option value="5">Apna Dhaba</option>
		  <option value="6">Bihari Dhaba</option>
		</select>
		</div>
		<br>
		<div style="margin-top:100px">
		<input type="submit" class="button" name="select" value="Submit" />
		</div>
	</form>
	<img src="img/dsa.png"/>
</div>

</body>
</html>
