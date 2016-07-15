<?php
$v = $_GET["foodname"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fooditems";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
//echo $v[0];
$fstr = $v[0];
$sql = "SELECT $fstr FROM foodnaam";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo "foodname: " . $row["$fstr"]. "<br>";
		$name = $row["$fstr"];
    }
} else {
    echo "0 results";
}



$fileweight= array();
$filesort = array();
for($i=1;$i<=5;$i++){
	$filename = 'img/'.$v.'/'.$i.'.jpg';
	$filesort[] = $filename;
	$fileweight[] =filesize($filename);
}

$time_start_ssort = microtime(true); 

function selectionSort(array $arr)
{
    $n = sizeof($arr);
    for ($i = 0; $i < $n; $i++) {
        $lowestValueIndex = $i;
        $lowestValue = $arr[$i];
        for ($j = $i + 1; $j < $n; $j++) {
            if ($arr[$j] < $lowestValue) {
                $lowestValueIndex = $j;
                $lowestValue = $arr[$j];
            }
        }
 
        $arr[$lowestValueIndex] = $arr[$i];
        $arr[$i] = $lowestValue;
    }
     
    return $arr;
}
 
$time_end_ssort = microtime(true);
$time_start_qsort = microtime(true);
function quicksort( $array ) {
    if( count( $array ) < 2 ) {
        return $array;
    }
    $left = $right = array( );
    reset( $array );
    $pivot_key  = key( $array );
    $pivot  = array_shift( $array );
    foreach( $array as $k => $v ) {
        if( $v < $pivot )
            $left[$k] = $v;
        else
            $right[$k] = $v;
    }
    return array_merge(quicksort($left), array($pivot_key => $pivot), quicksort($right));
}
$time_end_qsort = microtime(true);
$execution_time =0;
$result = selectionSort($fileweight);
$array  = quicksort($fileweight); 
	   
if($_POST){
    if(isset($_POST['insert'])){
        unset($filesort);
		$filesort = array();
        $filesort = select($array,$name);
		$execution_time = ($time_end_qsort - $time_start_qsort)/60;
    }elseif(isset($_POST['select'])){
		unset($filesort);
		$filesort = array();
        $filesort = select($result,$name);
		$execution_time = ($time_end_ssort - $time_start_ssort)/60;
	}
}
	
	function select($result,$name)
    {
       foreach($result as $key => $value)
		{
			for($j=1;$j<=5;$j++){
				$fname = 'img/'.$name.'/'.$j.'.jpg';
				if($value == filesize($fname)){
					$fsort[] = $fname;
				}
			}
		}
		return $fsort;
	}
    function insert($array,$name)
    {
       foreach($array as $key => $value)
		{
			for($j=1;$j<=5;$j++){
				$fname = 'img/'.$name.'/'.$j.'.jpg';
				if($value == filesize($fname)){
					$fsort[] = $fname;
				}
			}
		}
		return $fsort;
	}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Foodsearch</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/jquery.js"></script>
	<script src="js/new.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
		img{
			height:160px;
			width:160px;
		}
		.web{
			color:green;
		}
	</style>
  </head>
  <body style="#e7eaf0">
  <div class="container">
	<div style="margin-top:30px;width:100%">
		
		<img src="<?php echo $filesort[0] ?>"/>
		<img src="<?php echo $filesort[1] ?>"/>
		<img src="<?php echo $filesort[2] ?>"/>
		<img src="<?php echo $filesort[3] ?>"/>
		<img src="<?php echo $filesort[4] ?>"/>
		<br><br>
		<?php echo '<b>Total Sorting Time:</b> '.$execution_time.' Mins'; ?>
		<form method="post" action="search.php?foodname=<?php echo $name?>&submit=Food+search">
		<input type="submit" class="button" name="select" value="Sort : Selection Sort" />
		<input type="submit" class="button" name="insert" value="Sort : Quick Sort" />
		</form>
	</div>
	
	<div id="left" style="width:70%;float:left">
		<div style="margin-top:40px;">
			<h4><a href="nearest.php">Make strawberry <?php echo $name ?> in 3 steps! </a></h4>
			<p class="web">www.<?php echo $name ?>area.com</p>
			<p>Find and share everyday cooking inspiration on Allrecipes.<br> Discover recipes, cooks, videos, and how-tos based on the food you love and the friends you follow.</p>
				
		</div>
		
		<div style="margin-top:40px;">
			<h4><a href="nearest.php">Find <?php echo $name ?> to a home near you! </a></h4>
			<p class="web">www.punjabi<?php echo $name ?>.com</p>
			<p>Find and share everyday cooking inspiration on Allrecipes. <br> Discover recipes, cooks, videos, and how-tos based on the food you love and the friends you follow.</p>
		</div>
	</div>
	
	<div id="right" style="width:30%;float:right;margin-right:-50px">
	<h1> Related Searches </h1>
	<?php
	if($v == "lassi"){
	echo'<a href="http://localhost/foodsearch/search.php?foodname=juice&submit=Food+search"><h3>Juice</h3></a>';
	echo'<a href="http://localhost/foodsearch/search.php?foodname=orange&submit=Food+search"><h3>Orange</h3></a>';
	}
	elseif($v == "juice"){
	echo'<a href="http://localhost/foodsearch/search.php?foodname=orange&submit=Food+search"><h3>Orange</h3></a>';
	echo'<a href="http://localhost/foodsearch/search.php?foodname=lassi&submit=Food+search"><h3>Lassi</h3></a>';
	}
	elseif($v == "orange"){
	echo'<a href="http://localhost/foodsearch/search.php?foodname=juice&submit=Food+search"><h3>Juice</h3></a>';
	echo'<a href="http://localhost/foodsearch/search.php?foodname=lassi&submit=Food+search"><h3>Lassi</h3></a>';
	}
	else{
	echo'<a href="http://localhost/foodsearch/search.php?foodname=juice&submit=Food+search"><h3>Food1</h3></a>';
	echo'<a href="http://localhost/foodsearch/search.php?foodname=orange&submit=Food+search"><h3>Food2</h3></a>';
	}
	?>
	</div>
</div>

    
  </body>
</html>