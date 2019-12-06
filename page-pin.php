<?php

/**
 * 想法归档
 *
 * @package custom
 */
$this->_currentPage = getCurrentPage();
$this->articles = getPins($this->_currentPage, 5);
$this->type = '想法';
$this->typeId = 'pin';
$this->need('template/page/pin-list.php');
?>
