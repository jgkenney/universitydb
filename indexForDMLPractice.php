<?php
$servername = "localhost";
$username = "root";
$password = "dingdong";
$dbname = "universitydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{	
	echo "Successfully connected";
    echo "<br>";
} 


// Practice 1--insert following data in the department table:
$sql = "INSERT INTO department VALUES ('Physics', 'Jennings', 10000)";
if ($conn->query($sql) === TRUE) {
    echo "<br/>"; // new line
    echo "Insertion successful";
} else {
    echo "<br/>"; // new line 
    echo "Error accessing database: " . $conn->error;
}

$sql = "INSERT INTO department VALUES ('Biology', 'Jennings', 15000)";
if ($conn->query($sql) === TRUE) {
    echo "<br/>"; // new line
    echo "Insertion successful";
} else {
    echo "<br/>"; // new line 
    echo "Error accessing database: " . $conn->error;
}

// Practice 2---insert a row in student table
$sql = "INSERT INTO student VALUES ('11111', 'David', 'Physics', 3.5)";
if ($conn->query($sql) === TRUE) {
    echo "<br/>"; // new line
    echo "Insertion successful";
} else {
    echo "<br/>"; // new line 
    echo "Error accessing database: " . $conn->error;
}

//Practice 3---update: increase the budget of Biology department by 10 percent

$sql = "UPDATE department SET budget = budget*1.10 WHERE dept_name = 'Biology'";
if ($conn->query($sql) === TRUE) {
	echo "<br/>"; // new line
    echo "Update successful";
} else {
	echo "<br/>"; // new line 
    echo "Error accessing database: " . $conn->error;
}


//Practice 4---echo: print all data from the student table
echo "<br>";
$sql = "SELECT * FROM student";
$result = $conn->query($sql);

//number of rows
echo "<br/>Total records: $result->num_rows<br/>";

//display the records
if ($result->num_rows > 0) {	
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "name: " . $row["name"]. "; dept_name: " . $row["dept_name"]. "; total credits: " . $row["tot_cred"]. "."."<br>";
    }
} else {
    echo "0 results";
}


// Practice 5--echo: show the budget of Biology department
$sql = "SELECT budget FROM department WHERE dept_name = 'Biology'";
$result = $conn->query($sql);
echo "<br/>Total records: $result->num_rows<br/>";
$values = $result->fetch_assoc();
echo "Biology budget: $".$values["budget"];

//terminate connection
$conn->close();
echo "<br><br>";
echo "Connection terminated";
?>