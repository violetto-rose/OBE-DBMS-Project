<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Login</title>

    <meta name="author" content="violetto-rose" />
    <meta name="description"
        content="A project on OBE (Outcome based education) tracker with Course and Program outcome details along with subject information." />

    <!--Stylesheet-->
    <link rel="stylesheet" href="login.css">

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="$_POST">
        <h3>Login Here</h3>

        <label for="user">Username</label>
        <input type="text" placeholder="Email" id="user" required>

        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password" required>

        <button>Log In</button>

        <div class="options">
            <p class="sign-up">Don't have an account? <a href="register.php">Sign up now</a></p>
        </div>
    </form>

    <?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "manju";
    $dbname = "userinfo";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conn = new mysqli($servername, $username, "", $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $user = $_POST['user'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username='$user'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user'] = $user;
                header("Location: admin.php");
                exit();
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "User not found";
        }

        $conn->close();
    }
    ?>

</body>

</html>