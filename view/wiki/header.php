<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' | ' : null ?><?= APP_NAME ?></title>
    <link rel="shortcut icon" href="<?= ABSURL ?>favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="192x192" href="<?= ABSURL ?>img/maskable192.png">
    <link rel="manifest" href="<?= ABSURL ?>manifest.json" crossorigin="use-credentials">
    <meta name="theme-color" content="#475569">
    <meta name="description" content="<?= APP_NAME ?>">
    <link rel="stylesheet" href="<?= ABSURL ?>css/fonts.css">
    <link rel="stylesheet" href="<?= ABSURL ?>css/style.css?v=<?= VERSION ?>">
    <link rel="stylesheet" href="<?= ABSURL ?>css/alertjs.css">
    <link rel="stylesheet" href="<?= ABSURL ?>highlight/styles/atom-one-light.min.css">
    <link rel="stylesheet" href="<?= ABSURL ?>fontawesome/css/all.min.css">
    <script src="<?= ABSURL ?>highlight/highlight.min.js"></script>
    <script src="<?= ABSURL ?>js/alert.js"></script>
    <script defer>hljs.highlightAll();</script>
</head>
<body>
