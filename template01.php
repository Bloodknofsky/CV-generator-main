<!DOCTYPE html>
<html>

<head>
    <title>CV Generator - Template 01</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="generate_cv.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="profile.php">User Profile</a></li>
                <li><a href="cv_template.php">CV Template</a></li>
                <!--                <li><a href="cv_preview.html">CV Preview</a></li> -->
                <li><a href="?logout" onclick="LogoutButtonClicked()">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="cv-generator">
            <div class="container">
                <h2>Create a new CV</h2>
                <form action="#" method="post">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address">
                    <label for="summary">Summary</label>
                    <input type="text" id="summary" name="summary">
                    <label for="education">Education</label>
                    <input type="text" id="education" name="education">
                    <label for="experience">Experience</label>
                    <input type="text" id="experience" name="experience">
                    <label for="photo">Photo</label>
                    <input type="file" id="photo" name="photo">
                    <button type="submit">Generate CV</button>
                </form>
            </div>
        </section>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2023 CV Generator. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>

<?php

if (!isset($_COOKIE["id"])) {
    header("Location: http://localhost:5500/homepage.html");
    exit();
} else {
    if (isset($_GET['logout'])) {

        setcookie("id", "", time() - 3600);

        header('Location: http://localhost:5500/login.php');

        exit;
    }
}

if (sizeof($_POST) > 0) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $summary = $_POST['summary'];
    $education = $_POST['education'];
    $experience = $_POST['experience'];

    // Upload photo
    $photo = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $photo_extension = pathinfo($photo, PATHINFO_EXTENSION);
    $photo_filename = $name . '_photo.' . $photo_extension;
    move_uploaded_file($photo_tmp, 'photos/' . $photo_filename);

    $mysqli = require __DIR__ . "/database.php";
    $stmt = $mysqli->prepare("INSERT INTO cv_gen.generator (name, email, phone, address, summary, education, experience, photo) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $email, $phone, $address, $summary, $education, $experience, $photo_filename);
    $stmt->execute();

    require_once 'tcpdf.php';
    $pdf = new TCPDF();
    $pdf->AddPage();

    // Set the font and size for the CV
    $pdf->SetFont('times', 'B', 18); // Heading font
    $pdf->SetFont('times', '', 12); // Content font

    // Set background color and text color
    $pdf->SetFillColor(220, 220, 220); // Light gray background
    $pdf->SetTextColor(30, 30, 30); // Dark gray text color 

    $pdf->Rect(0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'F');
    // Add content to the PDF
    $content = "
    <style>
        .cv-title {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .cv-section {
            margin-bottom: 20px;
        }

        .cv-section-title {
            background-color: #ccc;
            padding: 5px;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .cv-field {
            margin-bottom: 5px;
        }
    </style>

    <h1 class='cv-title'>CV</h1>

    <div class='cv-section'>
        <div class='cv-section-title'>Personal Information</div>
        <div class='cv-field'><b>Name:</b> $name</div>
        <div class='cv-field'><b>Email:</b> $email</div>
        <div class='cv-field'><b>Phone:</b> $phone</div>
        <div class='cv-field'><b>Address:</b> $address</div>
    </div>

    <div class='cv-section'>
        <div class='cv-section-title'>Summary</div>
        <div class='cv-field'>$summary</div>
    </div>

    <div class='cv-section'>
        <div class='cv-section-title'>Education</div>
        <div class='cv-field'>$education</div>
    </div>

    <div class='cv-section'>
        <div class='cv-section-title'>Experience</div>
        <div class='cv-field'>$experience</div>
    </div>

    <div class='cv-section'>
        <div class='cv-section-title'>Photo</div>
        <img src='photos/$photo_filename' alt='Photo' class='cv-photo'>
    </div>
";
    $pdf->writeHTML($content, true, false, true, false, '');
    ob_end_clean();
    $pdf->Output('cv_temp_01.pdf', 'D'); // Download the PDF file with the name "cv.pdf"

    exit();

    //        header("Location: http://localhost:5500/cv_preview.php");
}

?>