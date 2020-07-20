<?php
//======================================================================
// INSERT DATA INTO THE UNIVERSITY DATABASE (universitydb)
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

/* use the created database */
$db_connection->select_db("universitydb");

$db_connection->query('SET foreign_key_checks = 1');

//-----------------------------------------------------
// Populate Tables of Database
//-----------------------------------------------------
echo "Table creation started." . nl2br("\r\n");

/* department */
$insert_department = $db_connection->prepare(
	"INSERT INTO department
	(dept_name,
	building,
	budget) VALUES(?,?,?);"
	);

$insert_department->bind_param("ssi",
$dept_name,
$building,
$budget
);

$dept_name = 'Psychology';
$building = 'Kirtland Hall';
$budget = 1000000.00;
$insert_department->execute();

$dept_name = 'Psychiatry';
$building = '300 George St.';
$budget = 2000000.00;
$insert_department->execute();

$dept_name = 'Medicine';
$building = '333 Cedar St.';
$budget = 3000000.00;
$insert_department->execute();


$insert_department->close();

/* course */
$insert_course = $db_connection->prepare(
	"INSERT INTO course
	(course_id,
	title,
	dept_name,
	credits) VALUES(?,?,?,?);"
	);

$insert_course->bind_param("sssi",
$course_id,
$title,
$dept_name,
$credits
);

$course_id = 'Psychology 101';
$title = 'Abnormal Psychology';
$dept_name = 'Psychology';
$credits = 3;
$insert_course->execute();

$course_id = 'Psychiatry 201';
$title = 'Psychopharmacology';
$dept_name = 'Psychiatry';
$credits = 3;
$insert_course->execute();

$course_id = 'Medicine 301';
$tile = 'Anatomy & Physiology';
$dept_name = 'Medicine';
$credits = 4;
$insert_course->execute();


$insert_course->close();

/* instructor */
$insert_instructor = $db_connection->prepare(
	"INSERT INTO instructor (
	id,
	name,
	dept_name,
	salary
	) VALUES(?,?,?,?);"
);

$insert_instructor->bind_param("isss",
$id,
$name,
$dept_name,
$salary
);

$id = 1;
$name = 'Eugen Bleuler';
$dept_name = 'Psychology';
$salary = 250000.00;
$insert_instructor->execute();

$id = 2;
$name = 'Sigmund Freud';
$dept_name = 'Psychiatry';
$salary = 500000.00;
$insert_instructor->execute();

$id = 3;
$name = 'Hippocrates';
$dept_name = 'Medicine';
$salary = 1000000.00;
$insert_instructor->execute();

$id = 
$name = 
$dept_name = 
$salary = 
$insert_instructor->execute();


$insert_instructor->close();





/* student */
$insert_student = $db_connection->prepare(
	"INSERT INTO student (
	id,
	name,
	dept_name,
	tot_cred
	) VALUES(?,?,?,?);"
);

$insert_student->bind_param("issi",
$id,
$name,
$dept_name,
$tot_cred
);

$id = 1;
$name = "Jason Johannesen";
$dept_name = 'Psychology';
$tot_cred = 128;
$insert_student->execute();

$id = 2;
$name = "Phil Corlett";
$dept_name = 'Psychiatry';
$tot_cred = 128;
$insert_student->execute();

$id = 3;
$name = "Josh Kenney";
$dept_name = 'Medicine';
$tot_cred = 36;
$insert_student->execute();

// $id = 
// $name = 
// $dept_name = 
// $tot_cred = 
// $insert_student->execute();

$insert_student->close();

/* section */
$insert_section = $db_connection->prepare(
	"INSERT INTO section (
	course_id,
	sec_id,
	semester,
	year,
	building,
	room_number
	) VALUES(?,?,?,?,?,?);"
);

$insert_section->bind_param("sisisi",
$course_id,
$sec_id,
$semester,
$year,
$building,
$room_number
);

$course_id = 'Psychology 101';
$sec_id = 1;
$semester = 'summer';
$year = 2020;
$building = 'Kirtland Hall';
$room_number = 310;
$insert_section->execute();

$course_id = 'Psychiatry 201';
$sec_id = 1;
$semester = 'spring';
$year = 2020;
$building = '300 George St.';
$room_number = 210;
$insert_section->execute();

$course_id = 'Medicine 301';
$sec_id = 2;
$semester = 'fall';
$year = 2020;
$building = '333 Cedar St.';
$room_number = 110;
$insert_section->execute();

// $course_id = 
// $sec_id = 
// $semester = 
// $year = 
// $building =
// $room_number =
// $insert_teaches->execute();

$insert_section->close();

/* teaches */
$insert_teaches = $db_connection->prepare(
	"INSERT INTO teaches (
	id,
	course_id,
	sec_id,
	semester,
	year
	) VALUES(?,?,?,?,?);"
);

$insert_teaches->bind_param("isisi",
$id,
$course_id,
$sec_id,
$semester,
$year
);

$id = 1;
$course_id = 'Psychology 101';
$sec_id = 1;
$semester = 'summer';
$year = 2020;
$insert_teaches->execute();

$id = 2;
$course_id = 'Psychiatry 201';
$sec_id = 1;
$semester = 'spring';
$year = 2020;
$insert_teaches->execute();

$id = 3;
$course_id = 'Medicine 301';
$sec_id = 2;
$semester = 'fall';
$year = 2020;
$insert_teaches->execute();

// $id = 
// $course_id = 
// $sec_id = 
// $semester =
// $year = 
// $insert_teaches->execute();

$insert_teaches->close();




//-----------------------------------------------------
// Finishing Up...
//-----------------------------------------------------

// Status Display
echo nl2br("The database tables were successfully populated.\r\n");
// Return to homepage after 5 seconds
header( "refresh:3;url=/universitydb" );

// ALWAYS CLOSE THE DB CONNECTION
$db_connection->close();

?>


