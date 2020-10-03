<?php

require 'config.php';

if(isset($_POST["install"])){
    
    // dump file
    $filename = 'apps/instats.sql';
    // MySQL host
    $mysql_host = isset($_POST["install"]) ? $_POST["server"]  : 'localhost';
    // MySQL username
    $mysql_username = isset($_POST["username"]) ? $_POST["username"]  : 'root';;
    // MySQL password
    $mysql_password = isset($_POST["password"]) ? $_POST["password"]  : '';;
    // Database name
    $mysql_database = isset($_POST["table"]) ? $_POST["table"]  : 'instats';

    // Connect to MySQL server
    mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
    
    // Select database
    mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

    $sql = '';
    $file = file($filename);
    
    foreach ($file as $line)
    {
        
        // Skip comment
        if (substr($line, 0, 2) == '--' || $line == '' || $line == '#')
            continue;

        $sql .= $line;
        
        // If it has a semicolon at the end, it's the end of the query
        if (substr(trim($line), -1, 1) == ';')
        {
            
            // Perform the query
            mysql_query($sql) or print('' . $sql . ': ' . mysql_error() . '<br /><hr />');
            
            // Temp variable to empty
            $sql = '';
        }
    }
    
    echo 'Installation successfully   <a href="/reports.php">Login</a>';
}
