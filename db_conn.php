<?php
$host = 'localhost';  // 데이터베이스 서버
$user = 'test';   // 데이터베이스 사용자명
$passwd = '1111';   // 데이터베이스 비밀번호
$dbname = 'testdb';    // 데이터베이스 이름

// 데이터베이스 연결
$conn = mysqli_connect($host, $user, $passwd, $dbname);
?>
