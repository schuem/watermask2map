<?php
function db_connect() {

        // Define connection as a static variable, to avoid connecting more than once 
    static $connection;

        // Try and connect to the database, if a connection has not been established yet
    if(!isset($connection)) {
             // Load configuration as an array. Use the actual location of your configuration file
        $config = parse_ini_file('../private/config.ini');
        $conStr = sprintf("host=%s dbname=%s user=%s password=%s", 
                $config['servername'], 
                $config['dbname'], 
                $config['username'], 
                $config['password']);
        $connection = pg_connect($conStr);
    }
    if(!$connection) {
      echo "Error : Unable to open database\n";
    }
    // else {
    //   echo "Opened database successfully\n";
    // }

        // If connection was not successful, handle the error
    if($connection === false) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
        return pg_last_error(); 
    }
    return $connection;
}

// Connect to the database
$connection = db_connect();

// Check connection
// if ($connection->connect_error) {
//     die("Connection failed: " . $connection->connect_error);
// }

?>
