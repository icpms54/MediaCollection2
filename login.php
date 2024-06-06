<?php
// Connect to database and profile file
require_once 'db_connection.php';
require_once 'profile.php';

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect input
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Create new user object
    $user = new User(null, null, null, null, $conn);

    // Call login method
    $user->login($username, $password);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Media Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;900&family=Poppins:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <script src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script>
        // Load header and footer
        $(function () {
            $("#header").load("header.html");
            $("#footer").load("footer.html");
        });
    </script>
</head>

<body>
    <div id="header"></div>
    <div class="login-container">
        <div class="px-4 py-5 my-5 text-center">
            <img class="d-block mx-auto mb-4" src="images\placeholder.jpg" alt="" width="72" height="57" />
            <h2 class="display-5 fw-bold text-body-emphasis">
                Log in to <span class="blue">My Media </span><span class="orange">Collection</span>
            </h2>
            <!-- Prompt user to login -->
            <p class="mt-3 mb-3">
                Please enter your username and password to log in.
            </p>
            <form action="login.php" method="post">
                <div class="mb-3">
                    <!-- Prompt user for username -->
                    <label for="=username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter user name"
                        required />
                </div>
                <div class="mb-3">
                    <!-- Prompt user for password -->
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter password" required />
                </div>
                <!-- Submit button to edit profile and cancel to go back -->
                <button type="submit" class="btn btn-primary mt-3">Log In</button>
            </form>
        </div>
    </div>
    <div id="footer" style="padding-top: 6vh"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>