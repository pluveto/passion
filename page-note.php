<?php

/**
 * 笔记归档
 *
 * @package custom
 */
$this->_currentPage = getCurrentPage();
$this->articles = getNotes($this->_currentPage, 5);
$this->type = '笔记';
$this->typeId = 'note';
$this->need('template/page/list.php');
?>
