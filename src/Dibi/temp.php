<?php
declare(strict_types=1);


// require_once('Connection.php');
use Dibi;

echo ("Start Connection\n");


$connectionInfo = array("driver" =>"sqlsrv", "host"=>"(LocalDB)\v11.0", "username"=>'simon.maguire',  "database"=>"TestSQLQueries");
// $database = new Connection($connectionInfo);


try {
	dibi::connect($connectionInfo);
	echo 'OK';
} catch (Dibi\Exception $e) {
	echo get_class($e), ': ', $e->getMessage(), "\n";
}


if( $conn ) {
    echo "Connection established.\n";
} else{
    echo "Connection could not be established\n";
    die( print_r( sqlsrv_errors(), true));
}


// $result = $conn->query("USE TestSQLQueries; Select * from dbo.GoodBoys");


// $result = sqlsrv_query($conn, "Select * from dbo.GoodBoys");
// if( $stmt === false ) {
//     die( print_r( sqlsrv_errors(), true));
// }

// $server_info = sqlsrv_client_info( $conn);
// if( $server_info )
// {
//     foreach( $server_info as $key => $value) {
//        echo $key.": ".$value."<br />";
//     }
// } else {
//       die( print_r( sqlsrv_errors(), true));
// }




echo ("Done\n");

?>