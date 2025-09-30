<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "search_project"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}


$student_id = isset($_GET['st']) ? intval($_GET['st']) : 0;


$sql = "SELECT * FROM $dbname ORDER BY student_id ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $rank = null;
    $num = 1;

    while ($row = $result->fetch_assoc()) {
        if ($row["student_id"] == $student_id) {
            $rank = $num;
            break;
        }
        $num++;
    }
} else {
    echo "⚠️ Query error หรือไม่พบข้อมูลในตาราง";
}


// form

if (isset($_GET['st'])) {
    $student_id = intval($_GET['st']); 

    $sql = "SELECT * FROM $dbname WHERE student_id = $student_id ORDER BY student_id ASC";
    $result = $conn->query($sql);

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
            Number : " . $rank . "<br>
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

?>