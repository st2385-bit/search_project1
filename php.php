<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design.css">
    <title>ผลการค้นหานักเรียน</title>
</head>
<body>
    <h1>ผลการค้นหา</h1>

    <?php if (isset($_POST['st'])): ?>
        <?php if ($student): ?>
            <div class="result_table">
                <h2>ข้อมูลนักเรียน</h2>
                <p>รหัสนักเรียน: <?php echo htmlspecialchars($student['student_id']); ?>
                <form method="post" action="search.php" class="new search">
                    <input type="Number" id="st" name="st" placeholder="new search" class="update" required>
                    <button type="submit" name="search" class="submit_button">กดดิวะ</button></p>
                </form><br>

                <p>ชื่อ: <?php echo htmlspecialchars($student['first_name']); ?></p>
                <form method="post" action="search.php" class="input">
                    <input type="hidden" name="search" value="<?php echo $row['id']; ?>">
                    <input type="Text" id="st" name="st" placeholder="new search" class="update" required>
                    <button type="submit" name="search" name="nameupdate" class="name_button">กดดิวะ</button></p>
                </form><br>

                <p>นามสกุล: <?php echo htmlspecialchars($student['last_name']); ?></p>
                <form method="post" action="search.php" class="input">
                    <input type="hidden" name="search" value="<?php echo $row['id']; ?>">
                    <input type="Text" id="st" name="st" placeholder="new search" class="update" required>
                    <button type="submit" name="search" name="lastnameupdate" class="name_button">กดดิวะ</button></p>
                </form><br>

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