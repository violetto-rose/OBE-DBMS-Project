<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Register</title>

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
    <form method="post" onsubmit="return validateEmail()">
        <h3>Register Here</h3>

        <label for="user">Username</label>
        <input type="text" placeholder="Email" id="user" required>

        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password" required>

        <button>Register</button>
    </form>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "manju";
    $dbname = "userinfo";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $user = $_POST['user'];
        $password = $_POST['password'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password) VALUES ('$user', '$hashed_password')";
    
        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>


    <script>
        function validateEmail() {
            var email = document.getElementById("username").value;
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }
            return true;
        }
    </script>
</body>


</html>