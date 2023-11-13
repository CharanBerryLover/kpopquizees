<?php
require_once("connect.php");
require_once("function.php");
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category-submit'])) {
    // Validate and sanitize the selected category
    $selectedCategory = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);

    // Save the selected category in the session
    $_SESSION['selected_category'] = $selectedCategory;

    // Redirect to quiz.php with the selected category
    header("Location: quiz.php");
    exit();
}

// Fetch distinct categories from the questions table
$sql = "SELECT DISTINCT cat FROM questions";
$result = mysqli_query($conn, $sql);

// Check if there are categories
if (!$result) {
    die("Error fetching categories: " . mysqli_error($conn));
}

$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/quiz.css">
</head>

<body>
    <section class="main-section">
        <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="dashboard.php">Quiz</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                        </li>
                    </ul>

                    <div class="d-flex">
                        <a class="btn btn-danger" href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form action="category.php" method="post">
                        <div class="card my-2 p-3">
                            <div class="card-body">
                                <h5 class="card-title py-2">Choose Category</h5>

                                <?php foreach ($categories as $category) : ?>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="category" value="<?php echo $category['cat']; ?>" required>
                                        <?php echo $category['cat']; ?>
                                    </div>
                                <?php endforeach; ?>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-success" name="category-submit">Start Quiz</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
