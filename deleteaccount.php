<?php
// Connect to database and profile page
require_once 'db_connection.php';
require_once 'profile.php';

// Create new user object
$user = new User(null, null, null, null, $conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If form is submitted
    if (isset($_POST['confirmDelete'])) {
        // Set variabe
        $profileId = $_SESSION['ProfileID'];
        // Call deleteAccount method
        $success = $user->deleteAccount($profileId, $conn);
        if ($success) {
            // Redirect user to index
            header("Location: index.html");
            exit;
        } else {
            echo "Failed to delete account.";
        }
    } else {
        echo "Confirmation required to delete account.";
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
                    Delete<span class="blue">Your</span><span class="orange">Account</span>
                </h2>
                <p class="mt-3 mb-3 text-center">
                    Are you sure you want to delete your account?
                </p>
                <!-- Form for profile deletion -->
                <form action="deleteaccount.php" method="post" enctype="multipart/form-data">
                    <div class="form-check">
                        <!-- Checkbox to ensure desired profile deletion -->
                        <input class="form-check-input" type="checkbox" value="" id="confirmDelete"
                            name="confirmDelete">
                        <label class="form-check-label" for="confirmDelete">
                            Yes, I want to delete my account.
                        </label>
                    </div>
                    <!-- Submit button to delete profile and cancel to go back -->
                    <button type="submit" class="btn btn-danger mt-3">
                        Delete Account
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