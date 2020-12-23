<?php

declare(strict_types=1);

if (@!include __DIR__ . '/vendor/autoload.php') {
	die('Install dependencies using `composer install --dev`');
}


echo ("Start Connection\n");


$connectionInfo = array("driver" =>"sqlsrv", "host"=>"(LocalDB)\\v11.0",  "database"=>"TestSQLQueries", "generalizedQuery"=>true);
$database = new Dibi\Connection($connectionInfo);

$conn = sqlsrv_connect( "(LocalDB)\\v11.0", ["database"=>"TestSQLQueries"]);


$ids = array("2", "5", "3");
$names = array('Bucky', "Ruffus");
$breeds = array('lab', "yorki");

$sql = <<<'SQL'
            Select * from dbo.GoodBoys where Name LIKE %like~ 
        SQL;

$result = $database->fetchAll($sql, "G");


// foreach($ids as $id){
//     foreach($names as $name){
//         foreach($breeds as $breed){
//             $result = $database->fetchAll($sql, 1, "Gruff", "doberman");
//         }
//     }

// }

echo "---Results---\n"  ;
print_r($result);
echo "\n";


$query_sql = "SELECT cplan.usecounts, cplan.objtype, qtext.text, qplan.query_plan
FROM sys.dm_exec_cached_plans AS cplan
CROSS APPLY sys.dm_exec_sql_text(plan_handle) AS qtext
CROSS APPLY sys.dm_exec_query_plan(plan_handle) AS qplan
ORDER BY cplan.usecounts DESC
";

$plans = sqlsrv_query($conn, $query_sql);
echo "----Query Plans ------\n";
while( $row = sqlsrv_fetch_array( $plans, SQLSRV_FETCH_ASSOC) ) {
    echo $row['text']. "\n\n";
}
echo "---------------------------------\n";


?>