<?php

if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $file = file_get_contents("./lang/$lang" . "_Lang_xx.json");

    $data = json_decode($file, true);

    // echo $data['title'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Facegram</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#"><?= isset($_GET['lang']) ? $data['nav']['Home'] : 'Home' ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><?= isset($_GET['lang']) ? $data['nav']['About'] : 'About' ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"> <?= isset($_GET['lang']) ? $data['nav']['Contact'] : 'Our Contact' ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><?= isset($_GET['lang']) ? $data['nav']['Product'] : 'Our Product' ?></a>
                    </li>

                </ul>
                <form class="d-flex gap-3">
                    <label for="">
                        Choose Language
                    </label>

                    <select name="lang" id="" onchange="this.form.submit()">
                        <option value="eng" <?php if (isset($_GET['lang']) && $_GET['lang'] == 'eng') {
                                            ?> selected <?php
                                            } ?>>English</option>
                        <option value="ind" <?php if (isset($_GET['lang']) && $_GET['lang'] == 'ind') {
                                            ?> selected <?php
                                            } ?>>Indonesia</option>
                        <option value="bel" <?php if (isset($_GET['lang']) && $_GET['lang'] == 'bel') {
                                            ?> selected <?php
                                            } ?>>Belanda</option>
                    </select>
                </form>
            </div>
        </div>
    </nav>

    <div class="m-5 container">

        <?php if (isset($_GET['lang'])) {
            foreach ($data['content'] as $key) {
        ?>
                <h1><?= $key['heading'] ?></h1>
                <p><?= $key['paragraph'] ?></p>
            <?php
            }
        } else {
            ?>
            <h1>Beautiful Beaches in Bali Island</h1>
            <p>The beaches in Bali Island are incredibly beautiful and enchanting. The soft white sand and clear blue waters make these beaches an ideal place to relax and enjoy the natural beauty</p>

            <h1>Beautiful Beaches in Bali Island</h1>
            <p>The beaches in Bali Island are incredibly beautiful and enchanting. The soft white sand and clear blue waters make these beaches an ideal place to relax and enjoy the natural beauty</p>

        <?php
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>