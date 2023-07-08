<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=URL?>public/sources/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?=URL?>public/sources/bootstrap/css/bootstrap-grid.css">
    <link rel="stylesheet" href="<?=URL?>public/sources/bootstrap/css/bootstrap-reboot.css">
    <link rel="stylesheet" href="<?=URL?>public/sources/bootstrap/css/bootstrap-utilities.css">
    <link rel="stylesheet" href="<?=URL?>public/sources/bootstrap/css/bootstrap.rtl.css">
    <?php
    if (isset($links)) {
        foreach ($links as $key => $value) {
            echo "<link rel='stylesheet' href='public/sources/$value'>";
        }
    }
    ?>
    <title><?=isset($titulo) ? $titulo : APP_NAME ?></title>
</head>
<body>