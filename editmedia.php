<?php
// Connect to database and media page
require_once 'db_connection.php';
require_once 'media.php';
require_once 'ownership.php';

// Check if logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["ProfileID"])) {
    // If not logged in redirect to login screen
    header("Location: login.php");
    exit;
} else {
    // Set profile id
    $profileId = $_SESSION['ProfileID'];
}

// Create a new media and ownership object
$media = new Media(null, null, null, null, null, null, null, null, null, null, $conn);
$ownership = new Ownership(null, null, null, null, null, null, null, $conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect input for media and ownership editing
    $mediaid = $_POST['mediaId'];
    $title = $_POST["Title"];
    $format = $_POST["Format"];
    $releaseYear = $_POST["ReleaseYear"];
    $author_Artist = $_POST["Author_Artist"];
    $isbn_Upc = $_POST["ISBN_UPC"];
    $runtime_Duration = $_POST["Runtime_Duration"];
    $genre = $_POST["Genre"];
    $language = $_POST["Language"];
    $publisher_Label = $_POST["Publisher_Label"];
    $purchaseDate = $_POST["PurchaseDate"];
    $purchasePrice = $_POST["PurchasePrice"];
    $itemCondition = $_POST["ItemCondition"];
    $notes = $_POST["Notes"];

    // Call the editMedia method with input
    $success_media = $media->editMedia($mediaid, $title, $format, $releaseYear, $author_Artist, $isbn_Upc, $runtime_Duration, $genre, $language, $publisher_Label, $conn);

    // Call the editOwnership method with input
    $success_ownership = $ownership->editOwnership($purchaseDate, $purchasePrice, $itemCondition, $notes, $mediaid, $conn);

    // If both are successful
    if ($success_media && $success_ownership) {
        // Redirect
        header("Location: mymedia.php");
        exit;
    } else {
        echo "Failed to edit media or ownership details.";
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
                    Edit <span class="blue">Your </span><span class="orange">Media</span>
                </h2>
                <p class="mt-3 mb-3 text-center">
                    Please enter information to be updated
                </p>
                <!-- Form for Adding new media -->
                <form action="editMedia.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <!-- Include the mediaId as a hidden field -->
                        <input type="hidden" name="mediaId" value="<?php echo $_GET['mediaId']; ?>">
                        <!-- Prompt user for title -->
                        <label for="Title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="Title" name="Title" placeholder="Enter Title"
                            required />
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for format -->
                        <label for="Format" class="form-label">Format</label>
                        <input type="text" class="form-control" id="Format" name="Format" placeholder="Enter Format"
                            required />
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for release year -->
                        <label for="ReleaseYear" class="form-label">Release Year</label>
                        <input type="number" class="form-control" id="ReleaseYear" name="ReleaseYear"
                            placeholder="Enter Release Year" min="1800" max="<?php echo date('Y'); ?>" required />
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for author or artist -->
                        <label for="Author_Artist" class="form-label">Author / Artist</label>
                        <input type="text" class="form-control" id="Author_Artist" name="Author_Artist"
                            placeholder="Enter Author / Artist" required />
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for ISBN or UPC -->
                        <label for="ISBN_UPC" class="form-label">ISBN / UPC</label>
                        <input type="text" class="form-control" id="ISBN_UPC" name="ISBN_UPC"
                            placeholder="Enter ISBN / UPC" required pattern="\d+" />
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for runtime or duration -->
                        <label for="Runtime_Duration" class="form-label">Runtime / Duration (in minutes)</label>
                        <input type="text" class="form-control" id="Runtime_Duration" name="Runtime_Duration"
                            placeholder="Enter Runtime / Duration (e.g., 90)" pattern="\d+"
                            title="Please enter a valid runtime in minutes (e.g., 90)" required />
                        <small id="Runtime_Duration_Help" class="form-text text-muted">
                            Please enter the runtime in minutes.
                        </small>
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for genre -->
                        <label for="Genre" class="form-label">Genre</label>
                        <input type="text" class="form-control" id="Genre" name="Genre" placeholder="Enter Genre"
                            required />
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for language -->
                        <label for="Language" class="form-label">Language</label>
                        <input type="text" class="form-control" id="Language" name="Language"
                            placeholder="Enter Language" required />
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for publisher or record label -->
                        <label for="Publisher_Label" class="form-label">Publisher / Label</label>
                        <input type="text" class="form-control" id="Publisher_Label" name="Publisher_Label"
                            placeholder="Enter Publisher / Label" required />
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for purchase date -->
                        <label for="PurchaseDate" class="form-label">Purchase Date</label>
                        <input type="date" class="form-control" id="PurchaseDate" name="PurchaseDate"
                            placeholder="Enter Purchase Date" required />
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for purchase price -->
                        <label for="PurchasePrice" class="form-label">Purchase Price</label>
                        <input type="number" class="form-control" id="PurchasePrice" name="PurchasePrice"
                            placeholder="Enter Purchase Price" step="0.01" required />
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for item condition -->
                        <label for="ItemCondition" class="form-label">Item Condition</label>
                        <select class="form-select" id="ItemCondition" name="ItemCondition"
                            aria-describedby="ItemCondition" required>
                            <option value="" disabled selected>Select item condition</option>
                            <option value="Poor">Poor</option>
                            <option value="Good">Good</option>
                            <option value="Great">Great</option>
                            <option value="Mint">Mint</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <!-- Prompt user for any notes -->
                        <label for="Notes" class="form-label">Notes</label>
                        <input type="text" class="form-control" id="Notes" name="Notes" placeholder="Notes" />
                    </div>
                    <!-- Submit button to create media and cancel to go back -->
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