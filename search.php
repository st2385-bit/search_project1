<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "search_project"; // your database name
$tablename = "students_information";

$conn = new mysqli($servername, $username, $password, $dbname); // Connect to database


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // if cant connect to database
}


$student_id = isset($_GET['st']) ? intval($_GET['st']) : 0; // read student_id from URL 


$sql = "SELECT * FROM $tablename ORDER BY student_id ASC"; // import all data from database to read
$result = $conn->query($sql);

// form

if (isset($_GET['st'])) {

    $student_id = intval($_GET['st']);

    $sql = "SELECT * FROM $tablename WHERE student_id = $student_id ORDER BY student_id ASC";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$result) {
        die("❌ Query error: " . $conn->error . "<br>SQL: " . $sql);
    }

    echo "<h2>ผลการค้นหา</h2>";

    if ($result->num_rows > 0) {
        echo "student ID : $student_id<br>
            First Name : " . $row["first_name"] . "<br>
            Last Name : " . $row["last_name"] . "<br>
            Nickname : " . $row["nickname"] . "<br>
            Class : " . $row["class"] . "<br>
            Number : " . $row["number"] . "<br>
        ";
        echo '<br><a href="index.html">🔙 กลับหน้าแรก</a>';
    } else {
        echo "⚠️ ไม่พบข้อมูลนักเรียนที่มี Student ID = $student_id";
        echo '<br><a href="index.html">🔙 กลับหน้าแรก</a>';
    }
} else {
    echo "⚠️ กรุณากรอกค่า Student ID ในฟอร์มก่อน";
    echo '<br><a href="index.html">🔙 กลับหน้าแรก</a>';
}

$conn->close();
