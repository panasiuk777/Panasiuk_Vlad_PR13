http://panasiukvladpr14.gamer.gd/
<?php

$message = "";
$generatedPassword = "";

$userIP = $_SERVER['REMOTE_ADDR'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset($_POST["generate"])) {



        $generatedPassword = bin2hex(random_bytes(8)) . "@A1";

        $message = "Згенеровано безпечний пароль.";

    }

    if (isset($_POST["check"])) {

        $password = htmlspecialchars($_POST["password"]);

        $errors = [];


        if (strlen($password) < 8) {

            $errors[] = "мінімум 8 символів";

        }


        if (!preg_match('/[A-Z]/', $password)) {

            $errors[] = "велика літера";

        }


        if (!preg_match('/[a-z]/', $password)) {

            $errors[] = "мала літера";

        }

        if (!preg_match('/[0-9]/', $password)) {

            $errors[] = "цифра";

        }


        if (!preg_match('/[\W]/', $password)) {

            $errors[] = "спецсимвол";

        }


        if (empty($errors)) {

            $message = "Пароль сильний ✅";

        } else {

            $message = "Слабкий пароль. Не вистачає: " . implode(", ", $errors);

        }

    }

}

?>

<!DOCTYPE html>

<html lang="uk">
<head>

    <meta charset="UTF-8">

    <title>Перевірка пароля</title>

    <style>

        body {

            font-family: Arial;

            background: #f2f2f2;

            margin: 40px;

        }

        .container {

            background: white;

            padding: 20px;

            border-radius: 10px;

            max-width: 600px;

            margin: auto;

        }

        input {

            width: 100%;

            padding: 10px;

            margin-top: 10px;

        }

        button {

            padding: 10px 15px;

            margin-top: 10px;

            cursor: pointer;

        }

        .message {

            margin-top: 15px;

            font-weight: bold;

        }

    </style>

</head>

<body>

<div class="container">

    <h2>Перевірка складності пароля</h2>

    <p><strong>Ваш IP:</strong> <?php echo $userIP; ?></p>

    <form method="POST">

        <label>Введіть пароль:</label>

        <input type="text" name="password"

               value="<?php echo $generatedPassword; ?>"

               placeholder="Введіть пароль">

        <button type="submit" name="check">Перевірити пароль</button>

        <button type="submit" name="generate">Згенерувати пароль</button>

    </form>

    <div class="message">

        <?php echo $message; ?>

    </div>

</div>

</body>

</html>
