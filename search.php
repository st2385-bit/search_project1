<?php 
$serverscript = 'server.php';   // เขียนชื่อให้ตรงกับไฟล์ server 
include($serverscript); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design.css">
    <script src="show.js"></script>
    <title>Student information</title>
</head>
<body>
    <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && $student): ?>
        <div class="result_table">

            <p>
                <form method="post" action="delete.php" class="delete">
                    <b>st : </b> <?= htmlspecialchars($nid) ?>
                    <button type="submit" name="delete" onclick="return confirmDelete();" class="delete">delete</button>
                </form>
                <form method="post" action="search.php" style="display:inline-block; margin-left:20px;">
                    <input type="number" name="st" placeholder="new search" class="update" required>
                    <button type="submit" class="submit_button">ค้นหา</button>
                </form>
            </p><br>

            <form method="post" action="search.php" class="update_form">
                <input type="hidden" name="student_id" value="<?= $student['student_id'] ?>"> <!--ขาดไม่ได้เดี๋ยวโปรแกรมเอ๋อ-->

                <label>ชื่อจริง : </label><input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($nfirstname) ?>">
                <button type="submit" name="first_name" onclick="return confirmEdit();" class="update">edit</button>
                <button type="submit" name="undo_firstname" class="undo">undo</button><br><br>

                <label>นามสกุล : </label><input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($nlastname) ?>">
                <button type="submit" name="last_name" onclick="return confirmEdit();" class="update">edit</button>
                <button type="submit" name="undo_lastname" class="undo">undo</button><br><br>

                <label>ชื่อเล่น : </label><input type="text" id="nickname" name="nickname" value="<?= htmlspecialchars($nnickname) ?>">
                <button type="submit" name="nickname" onclick="return confirmEdit();" class="update">edit</button>
                <button type="submit" name="undo_nickname" class="undo">undo</button><br><br>

                <label>ชั้น : </label><input type="text" id="class" name="class" value="<?= htmlspecialchars($nclass) ?>">
                <button type="submit" name="class" onclick="return confirmEdit();" class="update">edit</button>
                <button type="submit" name="undo_class" class="undo">undo</button><br><br>

                <label>เลขที่ : </label><label><?= htmlspecialchars($nnumber) ?></label><br><br>
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
        <button type="submit">Back to home</button>
    </form>
</body>
</html>
<?php $conn->close();?>