<?php
// Функции для аутентификации (упрощенная версия)

function isLoggedIn() {
    // Если не хотите использовать аутентификацию, всегда возвращаем true
    return true;
    
    // Если хотите использовать аутентификацию, раскомментируйте:
    // return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

function login($username, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    
    return false;
}

function logout() {
    session_destroy();
    header('Location: login.php');
    exit();
}

function register($username, $password, $email = '') {
    global $pdo;
    
    // Проверяем, существует ли пользователь
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        return false; // Пользователь уже существует
    }
    
    // Создаем нового пользователя
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, email) VALUES (?, ?, ?)");
    
    return $stmt->execute([$username, $passwordHash, $email]);
}

// Функция для получения всех пользователей (для админки)
function getAllUsers() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT id, username, email, created_at FROM users ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Функция для удаления пользователя
function deleteUser($userId) {
    global $pdo;
    
    // Нельзя удалить самого себя
    if (isset($_SESSION['user_id']) && $userId == $_SESSION['user_id']) {
        return false;
    }
    
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$userId]);
}

// Функция для проверки, является ли пользователь администратором
function isAdmin() {
    // Если не используем аутентификацию, считаем всех администраторами
    return true;
    
    // Если используем аутентификацию, раскомментируйте:
    // return isset($_SESSION['username']) && $_SESSION['username'] === 'admin';
}
?>