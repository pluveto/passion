<?php

/**
 * 文章归档
 *
 * @package custom
 */
$this->_currentPage = getCurrentPage();
$this->articles = getArticles($this->_currentPage, 5);
$this->type = '文章';
$this->typeId = 'article';
$this->need('template/page/list.php');
?>
