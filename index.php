<?php
session_start();
include('db_conn.php');

// 로그인 확인
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");  // 로그인하지 않은 경우 로그인 페이지로 리디렉션
    exit;
}

// 활성 상태의 할 일 목록 가져오기
$sql_active = "SELECT * FROM todo WHERE status = 'active' AND userid = {$_SESSION['userid']}";
$result_active = mysqli_query($conn, $sql_active);
if (!$result_active) {
    echo "Error in query: " . mysqli_error($conn);
}
$activeTodos = mysqli_fetch_all($result_active, MYSQLI_ASSOC); // 연관 배열 반환

// 완료된 할 일 목록 가져오기
$sql_completed = "SELECT * FROM todo WHERE status = 'completed' AND userid = {$_SESSION['userid']}";
$result_completed = mysqli_query($conn, $sql_completed);
if (!$result_completed) {
    echo "Error in query: " . mysqli_error($conn);
}
$completedTodos = mysqli_fetch_all($result_completed, MYSQLI_ASSOC); // 연관 배열 반환

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Todo List</title>
    <link rel="stylesheet" href="CSS/index.css">
</head>
<body>
    <h1>Todo List</h1>

    <!-- 할 일 추가 폼 -->
    <form action="add_todo.php" method="POST">
        <input type="text" name="title" placeholder="제목" required>
        <input type="text" name="content" placeholder="내용" required>
        <button type="submit">추가</button>
    </form>

    <!-- 활성 상태의 할 일 목록 -->
    <h2>Active Todos</h2>
    <div>
        <?php foreach ($activeTodos as $todo): ?> <!-- $activeTodos 배열의 각 요소를 순회 -> $todo라는 변수 -->
            <div class="todo-item">
                <input type="checkbox" onchange="location.href='complete.php?id=<?= $todo['id'] ?>'">   <!--체크 표시 후  complete.php로 이동-->
                <span><?= htmlspecialchars($todo['title']) ?></span>
                <span><?= htmlspecialchars($todo['content']) ?></span>
                <div class="todo-actions">
                    <!-- edit_icon과 delete_icon의 경로를 DB에서 가져와 표시 -->
                    <a href="edit.php?id=<?= $todo['id'] ?>">
                        <img src="<?= htmlspecialchars($todo['edit_icon']) ?>" alt="Edit" width="25" height="25">
                    </a>
                    <a href="delete.php?id=<?= $todo['id'] ?>">
                        <img src="<?= htmlspecialchars($todo['delete_icon']) ?>" alt="Delete" width="20" height="20">
                    </a>
                </div>
            </div>
        <?php endforeach; ?> <!--foreach 종료-->
    </div>

    <!-- 완료된 할 일 목록 -->
    <h2>Completed Todos</h2>
    <div> 
        <?php foreach ($completedTodos as $todo): ?> <!-- $completedTodos 배열의 각 요소를 순회 -> $todo라는 변수 -->
            <div class="todo-item">
                <span><?= htmlspecialchars($todo['title']) ?></span>
                <span><?= htmlspecialchars($todo['content']) ?></span><br>
                <div class="todo-actions">
                    <!-- delete_icon의 경로를 DB에서 가져와 표시 -->
                    <a href="delete.php?id=<?= $todo['id'] ?>">
                        <img src="<?= htmlspecialchars($todo['delete_icon']) ?>" alt="Delete" width="20" height="20">
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
