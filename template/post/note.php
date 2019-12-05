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
        <div class="sm-list-no-flex pb-5">
            <div class="pr-1 "><a class="back-link" href="<?php $this->options->siteUrl(); ?>"> ←返回</a></div>
            <div class="flex-1">«<?php $this->title(); ?>»</div>
            <div class="justify-end">by <?php $this->author() ?> on <?php $this->date("M j, Y") ?></div>
        </div>
        <?php $this->content(); ?>
    </div>
    <div class="container">
        <?php $this->need('comments.php') ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=default"></script>
    <script type="text/x-mathjax-config"> 
        MathJax.Hub.Config({
			showProcessingMessages: false,
			messageStyle: "none",
			extensions: ["tex2jax.js","TeX/mediawiki-texvc.js"],
			jax: ["input/TeX", "output/SVG"],
			tex2jax: {
				inlineMath: [ ['$','$'], ["\\(","\\)"] ],
				displayMath: [ ['$$','$$'], ["\\[","\\]"] ],
				skipTags: ['script', 'noscript', 'style', 'textarea', 'pre','code','a'],
				ignoreClass:"comment-content"
			},
			"HTML-CSS": {
				availableFonts: ["STIX","TeX"],
				showMathMenu: false
			}
		});
		MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
		</script>
</body>

</html>