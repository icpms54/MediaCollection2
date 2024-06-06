<?php
// Connect to database and profile page
require_once 'db_connection.php';
require_once 'profile.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect input for profile creation
    $username = mysqli_real_escape_string($conn, $_POST["Username"]);
    $email = mysqli_real_escape_string($conn, $_POST["Email"]);
    $password = mysqli_real_escape_string($conn, $_POST["Password"]);
    $firstName = mysqli_real_escape_string($conn, $_POST["FirstName"]);
    $lastName = mysqli_real_escape_string($conn, $_POST["LastName"]);
    $dob = mysqli_real_escape_string($conn, $_POST["DOB"]);

    // Create new user object
    $user = new User(null, null, null, null, $conn);

    // Call the createProfile method
    $result = $user->createProfile($username, $email, $password, $firstName, $lastName, $dob, $conn);

    // Check if result is a string indicating an error
    if (is_string($result)) {
        // Display the error message
        echo $result;
    }
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="css/style.css" rel="stylesheet" />
    <style>
        .create-profile-container {
            max-width: 400px;
            max-height: 1500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
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
    <main>
        <div class="create-profile-container">
            <div class="px-4 py-5 my-5">
                <img class="d-block mx-auto mb-4 text-center" src="images\placeholder.jpg" alt="" width="72"
                    height="57" />
                <h2 class="display-5 fw-bold text-body-emphasis text-center">
                    Sign up for <span class="blue">Band</span><span class="orange">Sync</span>
                </h2>
                <p class="mt-3 mb-3 text-center">
                    Please enter your personal information to create an account.
                </p>
                <!-- Form for profile creation -->
                <form action="createprofile.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <!-- Prompt user for First name -->
                        <label for="FirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="FirstName" name="FirstName"
                            placeholder="Enter first name" required />
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for Last name -->
                        <label for="LastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="LastName" name="LastName"
                            placeholder="Enter last name" required />
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for Username -->
                        <label for="Username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="Username" name="Username"
                            placeholder="Enter user name" required />
                        <div class="">
                        </div>
                        <div class="mb-3">
                            <!-- Prompt user for password -->
                            <label for="Password" class="form-label">Password</label>
                            <input type="Password" class="form-control" id="Password" name="Password"
                                placeholder="Enter password" required />
                        </div>
                        <div class="mb-3">
                            <!-- Prompt user for email -->
                            <label for="Email" class="form-label">Email</label>
                            <input type="Email" class="form-control" id="Email" name="Email" placeholder="Enter email"
                                required />
                        </div>
                        <div class="mb-3">
                            <!-- Prompt user for DOB -->
                            <label for="DOB" class="form-label">Date of Birth</label>
                            <input type="Date" class="form-control" id="DOB" name="DOB"
                                placeholder="Enter Date of Birth" />
                        </div>
                        <!-- Submit button to create profile and cancel to go back -->
                        <button type="submit" class="btn btn-primary mt-3">
                            Submit
                        </button>
                        <a href="index.php" class="btn btn-secondary mt-3">Cancel</a>
                </form>
            </div>
        </div>
    </main>
    <div id="footer" style="padding-top: 6vh;"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>