<?php
session_start();
include('db_conn.php');

// 로그인 확인
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");  // 로그인하지 않은 경우 로그인 페이지로 리디렉션
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 입력값 확인
    $title = mysqli_real_escape_string($conn, $_POST['title']); // mysqli_real_escape_string: 특수 문자들을 안전한 문자로 변환
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $userid = $_SESSION['userid'];  // 현재 로그인된 사용자의 ID를 가져옴

    // 할 일 추가 SQL 쿼리
    $sql = "INSERT INTO todo (title, content, status, userid) VALUES ('$title', '$content', 'active', '$userid')";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");  // 추가 후 다시 할 일 목록 페이지로 리디렉션
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
