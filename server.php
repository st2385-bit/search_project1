<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "search_project";// ชื่อฐานข้อมูล
$tablename = "students_information";// ชื่อตาราง

$conn = new mysqli($servername,$username,$password,$dbname);
if ($conn->connect_error) die("Connection failed :" . $conn->connect_error);

$student = null;
$error = "";

// เมื่อมีการส่งข้อมูล ค้นหาหรืออัปเดต
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = intval($_POST['student_id'] ?? $_POST['st'] ?? 0); // หา id จาก hidden input ด้วยถ้าแล้ว('??')

    //มีการกรอกค่าใหม่อะป่าว
    $fields = [
        'nameupdate' => 'first_name',
        'lastname'   => 'last_name',
        'nickname'   => 'nickname',
        'class'      => 'class',
        'number'     => 'number'
    ];

    $updateFields = [];
    $params = [];
    $types = "";

    foreach ($fields as $input => $column) { // เชคว่ามีการกรอกมั้ยผ่านloop
        if (!empty($_POST[$input])) {
            $updateFields[] = "$column = ?";
            $params[] = $_POST[$input];
            $types .= "s";
        }
    }

    if ($updateFields) {
        $sql = "UPDATE $tablename SET " . implode(", ", $updateFields) . " WHERE student_id = ?";
        $params[] = $student_id;
        $types .= "i";// เพื่อความปลอดถัย เดี๋ยวมีไอคนมาใส่ '; DROP TABLE students_information;--' อะไรแบบนี้

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);// load ข้อมูลใหม่ 
        $stmt->execute();
    }

    // ดึงข้อมูลนักเรียนจากฐานข้อมูล

    $stmt = $conn->prepare("SELECT * FROM $tablename WHERE student_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->num_rows ? $result->fetch_assoc() : null;
    
    
    
    if (!$student) $error = "ไม่พบ: $student_id โว้ย";
}
$nid = $student['student_id'] ?? ''; 
$nfirstname = $student['first_name'] ?? ''; 
$nlastname = $student['last_name'] ?? ''; 
$nnickname = $student['nickname'] ?? ''; 
$nclass = $student['class'] ?? ''; 
$nnumber = $student['number'] ?? '';
?>
