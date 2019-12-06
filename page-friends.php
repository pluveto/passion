<?php

/**
 * 友情连接
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

function getFriends($content){	
	$lines = explode("\n",$content);
	$ret = [];
	foreach($lines as $line){
		if(strlen($line)==0) continue;
		$segs = explode("|", $line,4);
		if(count($segs)!=4) continue;
		$ret[] = [
			'name' => $segs[0],
			'desc' => $segs[1],
			'avatar' => $segs[2],
			'link' => $segs[3],
		];
	}
	
	return $ret;
}
?>

<body class=" font-serif">
	<p></p>
	<div class="container home-toc" id="write">
		<h1><a href="<?php $this->options->siteUrl()?>"><?php $this->options->title(); ?></a></h1>
		<p><?php $this->options->description(); ?></p>
		<h2><?php echo $this->title ?></h2>
		<div class="sm-list-no-flex pb-8 flex-wrap" style="margin:0 -15px;">
        <?php
		$content = $this->row['text'];
			$friends = getFriends($content );
			foreach ($friends as $single) { ?>
				<a class="cursor-default w-1/2" style="padding:0 15px;" href="<?php echo $single['link']; ?>">
					<div class="pin-item md-rawblock flex under-sm-m-0" style="height:98px;">
						<div style="min-width: 96px;">
							<img class="friends-avatar" src="<?php echo $single['avatar'];?>">
						</div>
						<div class="m-2">
							<b><?php echo $single['name']; ?></b>
							<div class="title"><?php echo $single['desc']; ?></div>
						</div>
					</div>
				</a>
			<?php
			}
			?>
		</div>
	</div>
	<div class="footer">
		<div class="container font-sans">
			Powered by Typecho. Theme “Passion” by Pluveto.
		</div>
	</div>
</body>

</html>
