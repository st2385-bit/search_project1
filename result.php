<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "search_project"; // ชื่อฐานข้อมูล
$tablename = "students_information"; // ชื่อตาราง

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// เตรียมข้อมูลก่อนแสดงผล
$student ;
$error = "";

if (isset($_GET['st'])) {
    $student_id = intval($_GET['st']);
    $stmt = $conn->prepare("SELECT * FROM $tablename WHERE student_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute(); 
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        $error = "ไม่พบข้อมูลนักเรียนที่มี ID: $student_id";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="design.css"> -->
    <title>ผลการค้นหานักเรียน</title>
</head>
<body>
    <h1>ผลการค้นหา</h1>
    
    <?php if (isset($_GET['st'])): ?>
        <?php if ($student): ?>
            <div class="result-card">
                <h2>ข้อมูลนักเรียน</h2>
                <p>รหัสนักเรียน: <?php echo htmlspecialchars($student['student_id']); ?></p>
                <p>ชื่อ: <?php echo htmlspecialchars($student['first_name']); ?></p>
                <p>นามสกุล: <?php echo htmlspecialchars($student['last_name']); ?></p>
                <p>ชื่อเล่น: <?php echo htmlspecialchars($student['nickname']); ?></p>
                <p>ชั้น: <?php echo htmlspecialchars($student['class']); ?></p>
                <p>เลขที่: <?php echo htmlspecialchars($student['number']); ?></p>
            </div>
        <?php else: ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
    <?php else: ?>
        <p>กรุณากรอกรหัสนักเรียนที่ต้องการค้นหา</p>
    <?php endif; ?>

    <a href="index.html" class="back-link">กลับหน้าหลัก</a>
</body>
</html>
<?php
$conn->close();
?>
