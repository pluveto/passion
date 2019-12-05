<?php
$tpl = $this->fields->template;
if ($tpl == 'note') {
    $this->need('template/post/note.php');
} else if ($tpl == 'pin') {
    $this->need('template/post/pin.php');
} else {
    $this->need('template/post/article.php');
}
