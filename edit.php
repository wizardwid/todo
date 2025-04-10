<?php
include 'db_conn.php';

$id = $_GET['id'];
$sql1 = "SELECT * FROM todo WHERE id = '$id'";
$result = mysqli_query($conn, $sql1);
$todo = mysqli_fetch_assoc($result); // 연관 배열

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql2 = "UPDATE todo SET title = '$title', content = '$content' WHERE id = '$id'";
    if (mysqli_query($conn, $sql2)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Todo</title>
    <link rel="stylesheet" href="CSS/edit.css">
</head>
<body>
    <h1>Edit Todo</h1>
    <form action="" method="POST">
        <input type="text" name="title" value="<?php echo htmlspecialchars($todo['title']); ?>" required>
        <input type="text" name="content" value="<?php echo htmlspecialchars($todo['content']); ?>" required>
        <button type="submit">수정</button>
    </form>
</body>
</html>
