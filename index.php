<?php
// Connect to dataabse
require_once 'db_connection.php';

// Check if user is logged in
if (isset($_SESSION["loggedin"])) {
  // Redirect to welcome page
  header("Location: welcome.php");
  exit();
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
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous"></script>
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
    <div class="px-4 py-5 my-5 text-center">
      <img class="d-block mx-auto mb-4" src="images/CD.png" alt="" width="200" height="200" />
      <h1 class="display-5 fw-bold text-body-emphasis">
        <span class="blue">My Media </span><span class="orange">Collection</span>
      </h1>
      <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">
          My Media Collection is a website dedicated to helping you track your growing physical media collection!
        </p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
          <!-- Links to profile creation and login -->
          <a href="createprofile.php" class="btn btn-primary btn-lg px-4">Create
            Account</a>
          <a href="login.php" class="btn btn-secondary btn-lg px-4">Log In</a>
        </div>
      </div>
    </div>
  </main>
  <div id="footer" style="padding-top: 6vh"></div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</body>

</html>