<?php
include 'server.php';

// ตรวจสอบว่ามีการส่งค่า student_id มาจากฟอร์ม
if (isset($_POST['student_id'])) {
    $student_id = intval($_POST['student_id']); // แปลงเป็นตัวเลขเพื่อความปลอดภัย

    if ($student_id <= 0) {
        echo "invalid id";
        echo '<br><a href="search.php">back to homepage</a>';
        exit;
    }

    // --- ลบข้อมูลนักเรียน ---
    $stmt = $conn->prepare("DELETE FROM students_information WHERE student_id = ?");
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "ลบ student ID $student_id เรียบร้อยแล้ว<br>";

            // --- รีเรียงเลขที่นักเรียน (number) ใหม่ ---
            $conn->query("SET @row := 0"); // กำหนดตัวแปรสำหรับ row
            $update_number_sql = "
                UPDATE students_information
                JOIN (
                    SELECT student_id, (@row := @row + 1) AS new_number
                    FROM students_information
                    ORDER BY student_id
                ) AS t USING(student_id)
                SET students_information.number = t.new_number
            ";
            if ($conn->query($update_number_sql)) {
                echo "success sort";
            } else {
                echo "error" . $conn->error;
            }

        } else {
            echo "$student_id not found";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    echo '<br><a href="search.php">back to searchpage</a>';

} else {
    echo "ไม่มี student_id ถูกส่งมา";
    echo '<br><a href="search.php">Back to Searchpage</a>';
}
?>
