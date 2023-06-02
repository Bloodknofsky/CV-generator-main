<!DOCTYPE html>
<html>

<head>
    <title>CV Generator - Generate CV</title>
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
    $pdf->SetFont('helvetica', 'B', 16); // Heading font
    $pdf->SetFont('helvetica', '', 12); // Content font

    // Add content to the PDF
    $content = "
        <h1>CV</h1>

        <h2>Personal Information</h2>
        <table>
            <tr>
                <td><b>Name:</b></td>
                <td>$name</td>
            </tr>
            <tr>
                <td><b>Email:</b></td>
                <td>$email</td>
            </tr>
            <tr>
                <td><b>Phone:</b></td>
                <td>$phone</td>
            </tr>
            <tr>
                <td><b>Address:</b></td>
                <td>$address</td>
            </tr>
        </table>

        <h2>Summary</h2>
        <p>$summary</p>

        <h2>Education</h2>
        <ul>
            <li>$education</li>
        </ul>

        <h2>Experience</h2>
        <ul>
            <li>$experience</li>
        </ul>

        <h2>Photo</h2>
         <img src='data:image/$photo_extension;base64," . base64_encode(file_get_contents('photos/' . $photo_filename)) . "' alt='Photo' width='200' height='200'>
    ";
    $pdf->writeHTML($content, true, false, true, false, '');
    ob_end_clean();
    $pdf->Output('cv.pdf', 'D'); // Download the PDF file with the name "cv.pdf"

    exit();

    //        header("Location: http://localhost:5500/cv_preview.php");
}

?>