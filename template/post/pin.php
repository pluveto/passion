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
    <title>发布于<?php $this->date("Y年m月j日"); ?>的想法</title>
    <?php importCSS("base", "skeleton", "util", "whitey", "custom"); ?>
    <?php importCss('prism') ?>
    <?php importJs('prism') ?>
    <?php $this->header(); ?>
</head>

<body class=" font-serif">
    <p></p>
    <div class="container" id="write" style="padding-top: 3.6em;">

        <div class="text-right close-page"><a href="<?php $this->options->siteUrl() ?>">×</a></div>
        <div class="" style="user-select:none;font-size:5em;font-weight:bold;">“</div>
        <div class="" style="padding: 0 2em;"><?php $this->content(); ?></div>
        <div class="text-right font-sans" style="font-size: small; color:#bbb;">By <i><?php $this->author(); ?></i> on <?php $this->date("Y-m-j H:i:s"); ?></div>
        <?php if($this->user->hasLogin()):?>
            <a href="<?php $this->options->siteUrl();?>admin/write-post.php?cid=<?php echo $this->cid;?>">编辑</a>
        <?php endif;?>
    </div>

    <div class="container">
        <?php $this->need('comments.php') ?>
    </div>
</body>

</html>