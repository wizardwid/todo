<?php
include 'db_conn.php';

$id = $_GET['id'];

// 'completed' 상태로 업데이트
$sql = "UPDATE todo SET status = 'completed' WHERE id = '$id'";

// 쿼리 실행
if (mysqli_query($conn, $sql)) {
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

// 연결 종료
mysqli_close($conn);
?>
