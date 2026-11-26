<?php
session_start();
include "config/koneksi.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM users WHERE username = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && hash('sha256', $password) === $user['password']) {
        session_regenerate_id(true);
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Presensi Siswa</title>
</head>
<body>

<h2>LOGIN PRESENSI SISWA</h2>

<?php if (isset($error)) echo $error; ?>

<form method="POST">
    <input type="text" name="username"
        placeholder="Username" required>

    <br><br>

    <input type="password" name="password"
        placeholder="Password" required>

    <br><br>

    <button type="submit" name="login">
        Login
    </button>
</form>

</body>
</html>
