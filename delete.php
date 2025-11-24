<?php
include 'server.php';

// ตรวจสอบว่ามีการส่งค่า student_id มาจากฟอร์ม
if (isset($_POST['student_id'])) {
    $student_id = intval($_POST['student_id']);

    if ($student_id <= 0) {
        // redirect กลับ index.html ถ้า id ไม่ถูกต้อง
        header("Location: index.html");
        exit();
    }

    // ลบข้อมูลนักเรียน
    $stmt = $conn->prepare("DELETE FROM students_information WHERE student_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();

    // รีเรียงลำดับ number ใหม่
    $conn->query("SET @row := 0");
    $update_number_sql = "
        UPDATE students_information
        JOIN (
            SELECT student_id, (@row := @row + 1) AS new_number
            FROM students_information
            ORDER BY student_id
        ) AS t USING(student_id)
        SET students_information.number = t.new_number
    ";
    $conn->query($update_number_sql);

    // ปิดการเชื่อมต่อ
    $stmt->close();
    $conn->close();

    // กลับไปหน้า index.html ทันทีเมื่อทำงานเสร็จ
    header("Location: index.html");
    exit();

} else {
    // กลับไปหน้า index.html ถ้าไม่มี student_id
    header("Location: index.html");
    exit();
}
?>