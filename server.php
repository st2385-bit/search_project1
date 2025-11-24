<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "search_project";
$tablename  = "students_information";

$conn = new mysqli($servername, $username, $password, $dbname); //สร้าง oop connection
if ($conn->connect_error) {
    $error = "Connection error";
    $student = null;
    return;
}

$student = null;
$error = "";

// load data from database
function fetch_student($conn, $table, $id) {
    $stmt = $conn->prepare("SELECT * FROM `$table` WHERE student_id = ? LIMIT 1");// block sql injection
    if (!$stmt) return null;

    $stmt->bind_param("i", $id);// ใส่ ใน ?
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->num_rows ? $res->fetch_assoc() : null;
    $stmt->close();
    return $row;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // รับ student_id จากค้นหา (st) หรือ edit form
    $student_id = intval($_POST['student_id'] ?? $_POST['st'] ?? 0);

    if ($student_id > 0) {
        $student = fetch_student($conn, $tablename, $student_id);
        
        // บันทึกค่า
        $nid        = $student['student_id'];
        $nfirstname = $student['first_name'];
        $nlastname = $student['last_name'];
        $nnickname = $student['nickname'];
        $nclass = $student['class'];
        $nnumber = $student['number'];
        
        if (isset($_POST['undo_firstname']) || isset($_POST['undo_lastname']) || isset($_POST['undo_nickname']) || isset($_POST['undo_class'])) {
            return; 
        }

        if ($student) {
            $fields = ["first_name","last_name","nickname","class"];// รายการที่จะแก้ไข

            $update = [];// new values
            $params = [];
            $types  = "";

            foreach ($fields as $i) {// ยัดข้อมูลใหม่เข้า update 
                if (!isset($_POST[$i])) continue; 
                $value   = trim($_POST[$i]);    
                $current = $student[$i];

                if ($value === $current) continue;

                // เตรียมข้อมูล UPDATE
                $update[] = "`$i` = ?";
                $params[] = $value;
                $types   .= "s";   // string type
            }

            if ($update) { // update db
                $sql = "UPDATE `$tablename` SET " . implode(", ", $update) . " WHERE student_id = ?";
                $params[] = $student_id;
                $types   .= "i";

                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $bind = [$types];
                    foreach ($params as &$p) $bind[] = &$p;
                    call_user_func_array([$stmt, "bind_param"], $bind);
                    $stmt->execute();
                    $stmt->close();
                }
                $student = fetch_student($conn, $tablename, $student_id);
            }

        } else {$error = "ไม่พบ: $student_id ในระบบ";}
    } else {$error = "ไม่พบรหัสนักเรียนที่ถูกต้อง";}
}

$nid        = $student['student_id'] ?? '';
$nfirstname = $student['first_name'] ?? '';
$nlastname  = $student['last_name'] ?? '';
$nnickname  = $student['nickname'] ?? '';
$nclass     = $student['class'] ?? '';
$nnumber    = $student['number'] ?? '';
?>

?>
