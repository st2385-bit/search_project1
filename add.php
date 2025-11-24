<?php
include 'server.php';

$st = $fname = $lname = $nickname = $class = "";
$error = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $st       = trim($_POST['st'] ?? "");
    $st       = $st === "" ? 0 : intval($st);
    $fname    = trim($_POST['firstname'] ?? "");
    $lname    = trim($_POST['lastname'] ?? "");
    $nickname = trim($_POST['nickname'] ?? "");
    $class    = trim($_POST['class'] ?? "");

    // ตรวจข้อมูลครบไหม
    if ($st <= 0 || $fname === "" || $lname === "" || $nickname === "" || $class === "") {
        $error = "กรุณากรอกข้อมูลให้ครบถ้วน";
    } else {

        // ตรวจว่ามี student_id ซ้ำไหม
        $check = $conn->prepare("SELECT student_id FROM students_information WHERE student_id = ?");
        $check->bind_param("i", $st);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "รหัสนักเรียนนี้ถูกใช้แล้ว!";
        } else {

            // add to db
            $stmt = $conn->prepare("
                INSERT INTO students_information (student_id, first_name, last_name, nickname, class)
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->bind_param("issss", $st, $fname, $lname, $nickname, $class);

            if ($stmt->execute()) {
                $success = true;

                // sort number
                $conn->query("SET @row := 0");
                $conn->query("
                    UPDATE Students_information
                        JOIN (
                        SELECT student_id, (@row := @row + 1) AS new_number
                        FROM Students_information
                        ORDER BY student_id
                        ) AS t ON Students_information.student_id = t.student_id
                    SET Students_information.number = t.new_number
                ");
            } else {
                $error = "เกิดข้อผิดพลาด: " . $stmt->error;
            }

            $stmt->close();
        }

        $check->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <title>Register Student</title>
</head>

<body>
    <h1>Register Menu</h1>

    <?php if ($error !== ""): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p>YESSSSSSS!</p>
    <?php endif; ?>

    <form method="post" action="add.php">
        <input type="number" name="st" placeholder="Enter student ID"
               value="" required><br>
        <input type="text" name="firstname" placeholder="Enter firstname"
               value="" required><br>
        <input type="text" name="lastname" placeholder="Enter lastname"
               value="" required><br>
        <input type="text" name="nickname" placeholder="Enter nickname"
               value="" required><br>
        <input type="text" name="class" placeholder="Enter class"
               value="" required><br>

        <button type="submit">Register</button>
    </form>

    <form action="index.html" method="get">
        <button type="submit">Back to Home</button>
    </form>
</body>
</html>
