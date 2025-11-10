<?php 
$serverscript = 'server.php';// เขียนชื่อให้ตรงกับไฟล์ server 
 include($serverscript); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="design.css"> -->
    <title>Student information</title>
</head>
<body>
    <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && $student): ?>
        <div class="result_table">

            <p>
                <b>ID:</b> <?= htmlspecialchars($nid) ?><form method="post" action="search.php" style="display:inline-block; margin-left:20px;">
                    <input type="number" name="st" placeholder="new search" class="update" required>
                    <button type="submit" class="submit_button">ค้นหา</button>
                </form>
            </p><br>

            <form method="post" action="search.php" class="update_form">
                <input type="hidden" name="student_id" value="<?= $student['student_id'] ?>"> <!--ขาดไม่ได้เดี๋ยวโปรแกรมเอ๋อ-->

                <label>ชื่อ:</label><label><?= htmlspecialchars($nfirstname) ?></label>
                <input type="text" name="nameupdate" class="update"><br><br>

                <label>นามสกุล:</label><label><?= htmlspecialchars($nlastname) ?></label>
                <input type="text" name="lastname" class="update"><br><br>

                <label>ชื่อเล่น:</label><label><?= htmlspecialchars($nnickname) ?></label>
                <input type="text" name="nickname" class="update"><br><br>

                <label>ชั้น:</label><label><?= htmlspecialchars($nclass) ?></label>
                <input type="text" name="class" class="update"><br><br>

                <label>เลขที่:</label>
                <label><?= htmlspecialchars($nnumber) ?></label>
                <!-- <input type="number" name="number" value="<?= htmlspecialchars($nnumber) ?>" class="update"> -->
                <br><br>
                <button type="submit" class="name_button">save your update</button>
            </form>
        </div>

    <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    
    <?php if ($_SERVER["REQUEST_METHOD"] !== "POST"): ?>
        <form method="post" action="search.php" class="new search">
            <input type="number" name="st" placeholder="กรอกรหัสนักเรียน" class="update" required>
            <button type="submit" class="submit_button">ค้นหา</button>
        </form>
    <?php endif; ?>

    <form action="index.html" method="get">
        <button type="submit">Back to Home</button>
    </form>
</body>
</html>
<?php $conn->close();?>
