<?php

include 'server.php';

$st = $fname = $lname = $nickname = $class = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $st       = trim($_POST['st']       ?? "");
    $st = $st === "" ? 0 : intval($st);
    $fname    = trim($_POST['firstname'] ?? "");
    $lname    = trim($_POST['lastname'] ?? "");
    $nickname = trim($_POST['nickname'] ?? "");
    $class    = trim($_POST['class']    ?? "");

    if ($st <= 0 || $fname === "" || $lname === "" || $nickname === "" || $class === "") {
        $error = " กรุณากรอกข้อมูลให้ครบถ้วน";
    } else {
        // sql
        $stmt = $conn->prepare("
            INSERT INTO students_information (student_id, first_name, last_name, nickname, class)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("issss", $st, $fname, $lname, $nickname, $class);

        if ($stmt->execute()) {

            // รีเรียง number
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

            // กลับไปหน้า index.html ทันที
            header("Location: index.html");
            exit();
        } else {
            $error = "เกิดข้อผิดพลาด: " . $stmt->error;
        }

        $stmt->close();
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

    <form method="post" action="register.php">
        <input type="number" name="st" placeholder="Enter student ID" value="<?= htmlspecialchars($st) ?>" required><br>
        <input type="text" name="firstname" placeholder="Enter firstname" value="<?= htmlspecialchars($fname) ?>" required><br>
        <input type="text" name="lastname" placeholder="Enter lastname" value="<?= htmlspecialchars($lname) ?>" required><br>
        <input type="text" name="nickname" placeholder="Enter nickname" value="<?= htmlspecialchars($nickname) ?>" required><br>
        <input type="text" name="class" placeholder="Enter class" value="<?= htmlspecialchars($class) ?>" required><br>
        <button type="submit">Register</button>
    </form>
    <form action="index.html" method="get">
        <button type="submit">Back to Home</button>
    </form>
</body>
</html>