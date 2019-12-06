<?php

/**
 * 文章归档
 *
 * @package custom
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

?>

<body class=" font-serif">
	<p></p>
	<div class="container home-toc" id="write">
		<h1><a href="<?php $this->options->siteUrl()?>"><?php $this->options->title(); ?></a></h1>
		<p><?php $this->options->description(); ?></p>
		<h2><?php echo $this->type ?></h2>
		<ul class="list-clear-style pl-0">
			<?php
			foreach ($this->articles as $single) { ?>
				<li class="pin-item">
					<a class="ani-underline  cursor-default " href="<?php $single->permalink(); ?>">
						<div class="md-rawblock"><?php $single->content(); ?></div>
					</a>
				</li>
			<?php
			}
			?>
		</ul>
        <?php
        $count = _countUnderArticleTemplate($this->typeId);
		$this->setTotal($count);
        $this->parameter->pageSize = min($count, 5);
		$this->parameter->type = 'index';
		$this->options->index = $this->permalink . "?a=";
		$this->pageNav('&laquo; 前一页', '后一页 &raquo;');
		?>
	</div>
	<div class="footer">
		<div class="container font-sans">
			Powered by Typecho. Theme “Passion” by Pluveto.
		</div>
	</div>
</body>

</html>