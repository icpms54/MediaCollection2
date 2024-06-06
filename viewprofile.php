<?php
// Connect to database and profile page
require_once 'db_connection.php';
require_once 'profile.php';

// Check if logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["ProfileID"])) {
    // If not logged in redirect to login screen
    header("Location: login.php");
    exit;
} else {
    // Set profile id
    $profileId = $_SESSION['ProfileID'];
}

// Create a new user object
$user = new User(null, null, null, null, $conn);


$firstName = $user->getFirstName($profileId, $conn);
$lastName = $user->getLastName($profileId, $conn);
$dob = $user->getDOB($profileId, $conn);
$username = $user->getUsername($profileId, $conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>View Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;900&family=Poppins:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="css/style.css" rel="stylesheet" />
    <script>
        // Load header and footer
        $(function () {
            $("#header").load("header.php");
            $("#footer").load("footer.html");
        });
    </script>
    <style>
        .view-profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .user-fields-header {
            font-size: 22px;
            color: #333;
            margin-top: 20px;
            font-weight: bold;
        }

        .fieldheader {
            font-size: 18px;
            color: #555;
            margin-bottom: 15px;
        }

        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #007bff;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div id="header"></div>
    <main>
        <div class="view-profile-container">
            <div class="px-4 py-5 my-5">
                <div class="text-center">
                    <img class="d-block mx-auto mb-4" src="images\placeholder.jpg" alt="" width="72" height="57" />
                    <h2 class="display-5 fw-bold text-body-emphasis">
                        View <span class="blue">My Media </span><span class="orange">Collection </span> Profile
                    </h2>
                </div>
                <p class="mt-3 mb-3"></p>
                <div class="mb-3">
                    <!-- Display profile picture -->
                    <div class="image-container">
                        <img src="images\placeholder.jpg" alt="Profile Image" class="profile-image">
                    </div>
                    <!-- Display first name -->
                    <h3 class="user-fields-header">First Name</h3>
                    <div class="fieldheader">
                        <?php echo $firstName; ?>
                    </div>
                    <!-- Display last name -->
                    <h3 class="user-fields-header">Last Name</h3>
                    <div class="fieldheader">
                        <?php echo $lastName; ?>
                    </div>
                    <!-- Display date of birth -->
                    <h3 class="user-fields-header">Date of Birth</h3>
                    <div class="fieldheader">
                        <?php echo $dob; ?>
                    </div>
                    <!-- Display username -->
                    <h3 class="user-fields-header">Username</h3>
                    <div class="fieldheader">
                        <?php echo $username; ?>
                    </div>
                    <div class="d-flex justify-content-between">
                        <!-- Link to edit profile -->
                        <a href="editprofile.php" class="btn btn-primary btn-lg px-4 me-2">Edit Account</a>
                        <!-- Link to change password -->
                        <a href="changepassword.php" class="btn btn-primary btn-lg px-4 me-2">Change Password</a>
                        <!-- Link to delete account -->
                        <a href="deleteaccount.php" class="btn btn-primary btn-lg px-4">Delete Account</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div id="footer" style="padding-top: 6vh;"></div>
</body>

</html>