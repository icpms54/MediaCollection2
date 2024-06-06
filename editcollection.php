<?php
// Connect to the database and include necessary files
require_once 'db_connection.php';
require_once 'collection.php';

// Check if logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["ProfileID"])) {
    // If not logged in redirect to login screen
    header("Location: login.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect input for collection update
    $collectionId = $_POST["collectionId"];
    $name = mysqli_real_escape_string($conn, $_POST["Name"]);
    $description = mysqli_real_escape_string($conn, $_POST["Description"]);

    // Create a new collection object
    $collection = new Collection(null, null, null, null, $conn);

    // Call the editCollection method
    $result = $collection->editCollection($collectionId, $name, $description, $conn);

    if ($result === true) {
        // Redirect
        header("Location: collectionselectionpage.php");
        exit;
    } else {
        echo "Failed to edit collection: " . $result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Collection</title>
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
            $("#header").load("header.php");
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
                    Edit <span class="blue">Your </span><span class="orange">Collection</span>
                </h2>
                <p class="mt-3 mb-3 text-center">
                    Please enter information to edit collection.
                </p>
                <!-- Form for editing collection -->
                <form action="editcollection.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="collectionId" value="<?php echo $_GET['collectionId'];
                    ; ?>">
                    <div class="mb-3">
                        <!-- Prompt user for name -->
                        <label for="Name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="Name" name="Name" placeholder="Enter Name" />
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for Description -->
                        <label for="Description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="Description" name="Description"
                            placeholder="Enter Description" />
                    </div>
                    <!-- Submit button to edit collection and cancel to go back -->
                    <button type="submit" class="btn btn-primary mt-3">
                        Submit
                    </button>
                    <a href="collectionselectionpage.php" class="btn btn-secondary mt-3">Cancel</a>
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