<?php
$server_username = "root";
$server_password = "";
$server_host = "localhost";
$database = 'devmarketer';
$conn= mysqli_connect($server_host,$server_username,$server_password,$database);
if(!$conn)
{
	die("Lỗi kết nối dữ liệu");
	exit();
}
mysqli_query($conn,"SET NAMES 'UTF8'");
require('../phpMQTT.php');


$server = '13.67.74.76';     // change if necessary
$port = 1883;                     // change if necessary
$username = '';                   // set your username
$password = '';                   // set your password
$client_id = 'phpMQTT-subscriber'; // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);
if(!$mqtt->connect(true, NULL, $username, $password)) {
	exit(1);
}

$mqtt->debug = true;

$topics["Topic/GPS"] = array("qos" => 0, "function" => "procMsg");
$mqtt->subscribe($topics, 0);

while($mqtt->proc()) {

}

$mqtt->close();

// function procMsg($topic, $msg){
// 		echo 'Msg Recieved: ' . date('r') . "\n";
// 		echo "Topic: {$topic}\n\n";
// 		echo "\t$msg\n\n";
// }
function procMsg($topic, $msg){
	?>
		<div>
			<h1><?php echo($msg);?></h1>
			<?php 
				$server_username = "root";
				$server_password = "";
				$server_host = "localhost";
				$database = 'devmarketer';
				$id = rand(1,1000);
				$conn= mysqli_connect($server_host,$server_username,$server_password,$database);
				$query = "INSERT INTO messgps(id,mess,dateGPS) VALUES({$id},'{$msg}',NULL)";
				$results = mysqli_query($conn,$query);
			
			// DB::table('message')->insert([
			// 	'mess' => $msg,
			// 	'date' => NULL
			// ]);
			?>
		</div>
		<!-- echo "\n";
		echo "\t$msg\n\n"; -->
	<?php
}
?>



