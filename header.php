<!DOCTYPE html>
<html lang="en">
<!-- Header -->

<head>
    <title>My Media Collection Header</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
</head>

<body class="header-body">
    <script>
        const toggle = () => {
            document.getElementById('nav').classList.toggle('navactive')
        };
    </script>
    <header>
        <div class="brand">
            <h1 class="blue-class">My Media </h1>
            <h1 class="orange-class" style="margin-left: 5px;">Collection</h1>
        </div>
        <!-- Menu with navigation buttons -->
        <span class="fas fa-solid fa-bars" id="menuIcon" onclick="toggle()"></span>
        <div class="navbar" id="nav">
            <ul class="header-ul">
                <li>
                    <span class="fas fa-home" id="headIcon"></span>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <span class="fas fa-solid fa-user" id="headIcon"></span>
                    <a href="viewprofile.php">Profile</a>
                </li>
                <li>
                    <span class="fas fa-solid fa-book" id="headIcon"></span>
                    <a href="mediaselectionpage.php">Media</a>
                </li>
                <li>
                    <span class="fas fa-solid fa-list" id="headIcon"></span>
                    <a href="collectionselectionpage.php">My Collections</a>
                </li>
                <li>
                    <span class=" fas fa-solid fa-lock" id="headIcon"></span>
                    <a href="logout.php">Sign Out</a>
                </li>
            </ul>
        </div>
    </header>
</body>

</html>