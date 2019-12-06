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
        <div class="sm-list-no-flex pb-5">
            <div class="pr-1 "><a class="back-link" href="<?php $this->options->siteUrl(); ?>"> ←返回</a></div>
            <div class="flex-1">«<?php $this->title(); ?>»</div>
            <div class="justify-end">by <?php $this->author() ?> on <?php $this->date("M j, Y") ?></div>
        </div>
        <?php $this->content(); ?>
        <?php if($this->user->hasLogin()):?>
            <a href="<?php $this->options->siteUrl();?>admin/write-post.php?cid=<?php echo $this->cid;?>">编辑</a>
        <?php endif;?>
    </div>    
    <div class="container">
        <?php $this->need('comments.php') ?>
    </div>

</body>

</html>