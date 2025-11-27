<!DOCTYPE html>
<html lang="th">
<meta charset="utf-8">
<title>Register Student</title>
<link rel="stylesheet" href="register.css">
<script src="show.js"></script>

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
                // redirect ไปที่หน้า index พร้อมพารามิเตอร์ added=1
                // หน้า index จะตรวจสอบพารามิเตอร์นี้แล้วเรียก showAlert()
                echo "<script>window.location.href='index.html?added=1';</script>";
                exit();
        } else {
            $error = "เกิดข้อผิดพลาด : " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>


<body>
    <div class="auth-page">
        <div class="card">
            <h1 class="title">Resgister</h1>
                <?php if ($error !== ""): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
            

            <form class="main-form" method="post" action="register.php">
                <input class="text-input" type="number" name="st" placeholder="Student ID" value="<?= htmlspecialchars($st) ?>" required>

                <input class="text-input" type="text" name="firstname" placeholder="Name" value="<?= htmlspecialchars($fname) ?>" required>

                <input class="text-input" type="text" name="lastname" placeholder="Lastname" value="<?= htmlspecialchars($lname) ?>" required>

                <input class="text-input" type="text" name="nickname" placeholder="Nickname" value="<?= htmlspecialchars($nickname) ?>" required>

                <input class="text-input" type="text" name="class" placeholder="Class" value="<?= htmlspecialchars($class) ?>" required>

                <button class="primary-btn" type="submit">Register</button>

            </form>

            <div class="footer-link">
        <a href="index.html" style="text-decoration: underline;">Back to home</a>
            </div>
        </div>
    </div>

    <form method="get" action="index.html" style="display:none;">
        <button type="submit">Back to Home</button>
    </form>
</body>
</html>