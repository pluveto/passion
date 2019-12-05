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
</head>
<?php
$articles = getArticles(1, 5);
$diaries = getDiarys();
$pins = getPins(1, 3);
$notes = getNotes(1, 5);
?>

<body class=" font-serif">
	<p></p>
	<div class="container home-toc" id="write">
		<h1><?php $this->options->title(); ?></h1>
		<p><?php $this->options->description(); ?></p>
		<h2>文章</h2>
		<ul>
			<?php
			foreach ($articles as $single) {

				?>
				<li>
					<div class="flex">
						<div class="flex-1">
							<a class="ani-underline" href="<?php $single->permalink(); ?>"><?php $single->title(); ?></a>
						</div>
						<div class="justify-end sm-hidden min-width-5em text-right"><?php $single->date("M j"); ?></div>
					</div>
				</li>
			<?php
			}
			?>
		</ul>
		<h2>日记</h2>
		<ul>
			<?php
			foreach ($diaries as $single) { ?>
				<li>
					<div class="flex">
						<div class="flex-1">
							<a class="ani-underline" href="<?php $single->permalink(); ?>"><?php $single->title(); ?></a>
						</div>
						<div class="justify-end sm-hidden min-width-5em text-right"><?php $single->date("M j"); ?></div>
					</div>
				</li>
			<?php
			}
			?>
		</ul>
		<h2>想法</h2>
		<ul class="list-clear-style pl-0">
			<?php
			foreach ($pins as $single) { ?>
				<li class="pin-item">
					<a class="ani-underline  cursor-default " href="<?php $single->permalink(); ?>">
						<div class="md-rawblock"><?php $single->content(); ?></div>
					</a>
				</li>
			<?php
			}
			?>
		</ul>
		<h2>笔记</h2>
		<ul>
			<?php
			foreach ($notes as $single) { ?>
				<li>
					<a class="ani-underline" href="<?php $single->permalink(); ?>"><?php $single->title(); ?></a>
				</li>
			<?php
			}
			?>
		</ul>
		<h2>其他</h2>
		<div class="flex pb-8 flex-wrap">
			<a class="cursor-default w-1/2" href="<?php $this->options->adminUrl(); ?>">
				<div class="pin-item md-rawblock">
					<b>后台</b>
					<div class="title">进入管理后台</div>
				</div>
			</a>
			<?php
			$pages = getPages();
			foreach ($pages as $single) { ?>
				<a class="cursor-default w-1/2" href="<?php $single->permalink(); ?>">
					<div class="pin-item md-rawblock">
						<b><?php $single->title(); ?></b>
						<div class="title"><?php echo  $single->fields->pageDescription; ?></div>
					</div>
				</a>
			<?php
			}
			?>
		</div>
	</div>
	<div class="footer">
		<div class="container font-serif" style="color: #777;
				letter-spacing: .1em;">
			Powered by Typecho. Theme “Passion” by Pluveto. 2013 - 2020.
		</div>
		<p></p>
	</div>
</body>

</html>