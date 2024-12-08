<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(env('APP_NAME'), ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <div class="jumbotron">
            <h1 class="display-4"><?= htmlspecialchars(env('APP_NAME'), ENT_QUOTES, 'UTF-8') ?></h1>
            <p class="lead"><?= htmlspecialchars(env('APP_DESC'), ENT_QUOTES, 'UTF-8') ?></p>
            <hr class="my-4">

            <?php if (!empty($department) && is_array($department)): ?>
                <p>
                    <?php foreach ($department as $departments): ?>
                        <?= htmlspecialchars($departments->department_name, ENT_QUOTES, 'UTF-8') ?><br>
                    <?php endforeach; ?>
                </p>
            <?php else: ?>
                <p>No departments found.</p>
            <?php endif; ?>

            <p>
                <strong>It is a great OOP Oriented Framework in PHP</strong>
                <hr class="my-4">
                Welcome to the PROTON framework. You can now create and develop web applications and application interfaces very easily. It supports most databases such as MySQL, PostgreSQL, SQLite, and MongoDB.
            </p>
            <a href="#" class="btn btn-primary btn-lg">Get Started</a>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>