<?php
include 'db_conn.php';

$id = $_GET['id'];

// 할 일 삭제
$sql = "DELETE FROM todo WHERE id = '$id'";
if (mysqli_query($conn, $sql)) {
    $sql_update = "SET @count = 0"; // ID 순차적으로 업데이트 (삭제된 후 남은 값 재정렬) , @count : 사용자 정의 상수
    if (mysqli_query($conn, $sql_update)) {
        $sql_reorder = "UPDATE todo SET id = (@count := @count + 1)";
        if (mysqli_query($conn, $sql_reorder)) {
            $sql_auto_increment = "ALTER TABLE todo AUTO_INCREMENT = 1"; // AUTO_INCREMENT 값 초기화 (새로 삽입된 값만 해당)
            if (mysqli_query($conn, $sql_auto_increment)) {
                header("Location: index.php");
                exit();
            } 
        }
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
