<?php
include("connect.php");

if (isset($_POST["submit"])) {
    $id = $_POST["questionid"];
    $question = $_POST["question"];
    $ans_id = $_POST["answerid"];
    $cat = $_POST["category"];

    // For uploads photos
    $upload_dir = "uploads/";
    $q_images = $upload_dir . $_FILES["imageUpload"]["name"];
    $upload_file = $upload_dir . basename($_FILES["imageUpload"]["name"]);
    $imageType = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));
    $check = $_FILES["imageUpload"]["size"];
    $upload_ok = 1; // Initialize to 1

    if (file_exists($upload_file)) {
        echo "<script>alert('The file already exists')</script>";
        $upload_ok = 0; // Set to 0 to indicate an issue
    } else {
        if ($check === 0) {
            echo '<script>alert("The photo size is 0 or the file is empty. Please select a valid photo.")</script>';
            $upload_ok = 0;
        } else {
            if (!in_array($imageType, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo '<script>alert("Please change the image format to jpg, jpeg, png, or gif.")</script>';
                $upload_ok = 0;
            }
        }
    }

    if ($upload_ok === 1) { // Check for a successful check
        if ($question !== "") {
            move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $upload_file);

            $sql = "INSERT INTO questions (id, q_images, question, ans_id, cat) 
                    VALUES ('$id', '$q_images', '$question', '$ans_id', '$cat')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Your product was uploaded successfully')</script>";
            } else {
                echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "')</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Page</title>
    <link rel="stylesheet" href="product.css">
    <style>
        .page-header {
            background-color: coral;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .container {
            align-items: center;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            text-align: center;
        }

        #upload_container form select {
            padding: 8px;
            outline: none;
            background: white;
            border: 1px solid hotpink;
            margin-bottom: 20px;
        }

        .messages {
            text-align: center;
            font-size: 15px;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <header class="page-header">
        <h1>Insert Page</h1>
    </header>

    <div class="container">
        <section id="upload_container">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="questionid" id="questionid" placeholder="Question ID" required>
                <input type="text" name="question" id="question" placeholder="Question" required>
                <input type="number" name="answerid" id="answerid" placeholder="Answer" required>
                <select name="category" id="category" required>
                    <option value="easy">Easy</option>
                    <option value="medium">Medium</option>
                    <option value="hard">Hard</option>
                    <option value="extreme">Extreme</option>
                </select>
                <input type="file" name="imageUpload" id="imageUpload" required hidden>
                <button id="choose" onclick="upload();">Choose Image</button>
                <input type="submit" value="Upload" name="submit">
            </form>
            <div class="messages">
                <p><a href="homePage.php">Back to Main Menu</a></p>
            </div>
        </section>

        <script>
            var questionid = document.getElementById("questionid");
            var question = document.getElementById("question");
            var answerid = document.getElementById("answerid");
            var choose = document.getElementById("choose");
            var uploadImage = document.getElementById("imageUpload");

            function upload() {
                uploadImage.click();
            }

            uploadImage.addEventListener("change", function () {
                var file = this.files[0];
                if (question.value == "") {
                    question.value = file.name;
                }
                choose.innerHTML = "You can change(" + file.name + ") picture";
            })
        </script>
    </div>
</body>

</html>
