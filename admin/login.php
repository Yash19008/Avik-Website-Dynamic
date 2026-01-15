<?php
require_once "inc/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
    } else {

        $stmt = mysqli_prepare(
            $conn,
            "SELECT id, name, email, password, status FROM users WHERE email = ? LIMIT 1"
        );

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {

            if ($user['status'] != 1) {
                $error = "Your account is inactive.";
            } elseif (!password_verify($password, $user['password'])) {
                $error = "Invalid email or password.";
            } else {
                // ✅ Login success
                session_regenerate_id(true);

                $_SESSION['user_id']   = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];

                header("Location: index.php");
                exit;
            }
        } else {
            $error = "Invalid email or password.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="index.php" class="h1"><b>Admin</b> Dashboard</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <?php if (!empty($error)) : ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./dist/js/adminlte.min.js"></script>
</body>

</html>