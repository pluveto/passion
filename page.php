<?php

/**
 * Passion - Theme for typecho by Pluveto
 * 
 * @package Passion
 * @author pluveto
 * @version 1.0
 * @link http://www.pluvet.com
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php getTitle($this); ?></title>
    <?php importCSS("base", "skeleton", "util", "whitey", "custom"); ?>
    <?php importCss('prism') ?>
    <?php importJs('prism') ?>
    <?php $this->header(); ?>
</head>

<body class=" font-serif">
    <p></p>
    <div class="container" id="write">
        <div class="text-right close-page"><a href="<?php $this->options->siteUrl() ?>">×</a></div>
        <h1><?php $this->title(); ?></h1>
        <?php $this->content(); ?>
    </div>
    <div class="container">
        <?php $this->need('comments.php') ?>
    </div>

</body>

</html>