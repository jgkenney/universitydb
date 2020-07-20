<?php
//======================================================================
// CREATE THE UNIVERSITY DATABASE (universitydb)
//======================================================================

error_reporting(-1);
ini_set('display_errors', 'On');

/* database connection */
DEFINE('DB_HOST', "localhost");
DEFINE('DB_USER', "root");
DEFINE('DB_PASSWORD', "dingdong"); //Note: this should be your root password


try {
  $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD)
    OR die("Connection failed: " . $db_connection->connect_error);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), nl2br("\r\n");
}

/* check if database exists; if not  database will be created */
$create_stmt = "CREATE DATABASE IF NOT EXISTS universitydb";
/* Check if database drop was sucessful */
if(mysqli_query($db_connection, $create_stmt)) {
	echo nl2br("Database was successfully created.\r\n");
} else {
	echo "Error dropping database: " . mysqli_error() . nl2br("\r\n");
}
$prep_stmt = $db_connection -> prepare($create_stmt);
$prep_stmt->execute();
$prep_stmt->close();

/* use the created database */
$db_connection->select_db("universitydb");

/* drop all tables for clean insert */
$db_connection->query('SET foreign_key_checks = 0');
if ($result = $db_connection->query("SHOW TABLES")) {
  while($row = $result->fetch_array(MYSQLI_NUM)) {
    $db_connection->query('DROP TABLE IF EXISTS '.$row[0]);
	}
	echo "Tables removed successfully." . nl2br("\r\n");
} else {
	echo "No tables were removed." . nl2br("\r\n");
}
$db_connection->query('SET foreign_key_checks = 1');


//-----------------------------------------------------
// Create Database Tables
//-----------------------------------------------------
echo "Table creation started." . nl2br("\r\n");

/* department  */
$create_department = $db_connection->prepare(
	"CREATE or REPLACE TABLE `department` (
		`dept_name` varchar(20),
		`building` varchar(15),
		`budget` numeric(10,2),
		PRIMARY KEY (`dept_name`)
	);"
);
$create_department->execute();
$create_department->close();


/* course */
$create_course = $db_connection->prepare(
	"CREATE or REPLACE TABLE `course` (
  		`course_id` varchar(50),
		`title` varchar(50),
		`dept_name` varchar(20),
		`credits` numeric(2,0),
		PRIMARY KEY (`course_id`),
		FOREIGN KEY (`dept_name`) REFERENCES `department`(`dept_name`)
	);"
);
$create_course->execute();
$create_course->close();

/* instructor */
$create_instructor = $db_connection->prepare(
	"CREATE or REPLACE TABLE `instructor` (
  		`id` int not null,
		`name` varchar(20),
		`dept_name` varchar(20),
		`salary` numeric(10,2),
		PRIMARY KEY (`id`),
		FOREIGN KEY (`dept_name`) REFERENCES `department`(`dept_name`)
	);"
);
$create_instructor->execute();
$create_instructor->close();

/* student */
$create_student = $db_connection->prepare(
	"CREATE or REPLACE TABLE `student` (
  		`id` int,
		`name` varchar(50),
		`dept_name` varchar(50),
		`tot_cred` int,
		PRIMARY KEY (`id`),
		FOREIGN KEY (`dept_name`) REFERENCES `department`(`dept_name`)
	);"
);
$create_student->execute();
$create_student->close();

/* section */
$create_section = $db_connection->prepare(
	"CREATE or REPLACE TABLE `section` (
  		`course_id` varchar(50),
		`sec_id` int not null,
		`semester` varchar(8),
		`year` numeric(4),
		`building` varchar(20),
		`room_number` numeric(3),
		PRIMARY KEY (`sec_id`, `semester`, `year`),
		FOREIGN KEY (`course_id`) REFERENCES `course`(`course_id`)
		-- FOREIGN KEY (`building`) REFERENCES `department`(`building`)

	);"
);
$create_section->execute();
$create_section->close();

/* teaches */
$create_teaches = $db_connection->prepare(
	"CREATE or REPLACE TABLE `teaches` (
  		`id` int not null,
		`course_id` varchar(50),
		`sec_id` int not null,
		`semester` varchar(8),
		`year` numeric(4),
		PRIMARY KEY (`id`, `sec_id`, `semester`, `year`),
		FOREIGN KEY (`course_id`) REFERENCES `course`(`course_id`)
		-- FOREIGN KEY (`sec_id`) REFERENCES `section`(`sec_id`),
		-- FOREIGN KEY (`semester`) REFERENCES `section`(`semester`),
		-- FOREIGN KEY (`year`) REFERENCES `section`(`year`)
	);"
);
$create_teaches->execute();
$create_teaches->close();






//-----------------------------------------------------
// Finishing Up...
//-----------------------------------------------------

// Status Display
echo nl2br("The database tables were successfully created.\r\n");
// Return to homepage after 5 seconds
header( "refresh:3;url=/universitydb" );

// ALWAYS CLOSE THE DB CONNECTION
$db_connection->close();

?>
