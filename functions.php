<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form)
{ }

function themeFields($layout)
{
    if ('/admin/write-page.php' == _fuck(Typecho_Request::getInstance(), '_baseUrl')) {
        $showInHome = new Typecho_Widget_Helper_Form_Element_Radio(
            'showInHome',
            array('yes' => '是', 'no' => '否'),
            'no',
            _t('在首页显示'),
            _t('是否显示在首页')
        );
        $layout->addItem($showInHome);  //  注册  
        $pageDescription = new Typecho_Widget_Helper_Form_Element_Text(
            'pageDescription',
            NULL,
            NULL,
            _t('页面描述文本'),
            _t('显示在首页的描述文本')
        );
        $layout->addItem($pageDescription);  //  注册  
    } else {
        $template = new Typecho_Widget_Helper_Form_Element_Select(
            'template',
            array(
                'article' => '文章',
                'diary' => '日记',
                'pin' => '想法',
                'note' => '笔记'
            ),
            'show',
            _t('文本类型'),
            _t('不同的文本类型对应不同的样式')
        );
        $layout->addItem($template);  //  注册  
    }
}

function getYearAndMonth()
{
    if(!array_key_exists('a',$_GET)){
        return [
            'year'=> date('Y'),
            'month'=> date('m')
        ];
    }
    $re = '/\/year\/(\d+)\/month\/(\d+)/m';
    $str = $_GET['a'];

    preg_match($re, $str, $matches);
    // Print the entire match result
    if(count($matches)==3)
    {
        return [
            'year'=> $matches[1],
            'month'=> $matches[2]
        ];
    }else{
        return false;
    }

}

function getCurrentPage()
{
    if(!array_key_exists('a',$_GET)){
        return 1;
    }
    $re = '/\/page\/(\d+)\//m';
    $str = $_GET['a'];

    preg_match($re, $str, $matches);
    // Print the entire match result
    if(count($matches)==2)
    {
        return intval($matches[1]);
    }else{
        return 1;
    }

}
function _countUnderArticleTemplate($template)
{
    $db = Typecho_Db::get();
    return $db->fetchObject(
        $db->select(array('COUNT(cid)' => 'num'))->from('table.fields')
            ->where('name = ?', 'template')
            ->where('str_value = ?', $template)
    )->num;
}
function getDiarysDuring($tsStart, $tsEnd){


    $db = Typecho_Db::get();
    $rows = $db->fetchAll(
        $db->select()->from('table.fields')
            ->where('name = ?', 'template')
            ->where('str_value = ?', 'diary')
            ->where('created >= ?', $tsStart)
            ->where('created <= ?', $tsEnd)
            //->page($page,$perpage)
            ->join('table.contents', 'table.contents.cid = table.fields.cid')
            ->order('created', Typecho_Db::SORT_DESC)
    );

    $posts = [];

    foreach ($rows as $row) {
        $posts[] = Typecho_Widget::widget(
            'Widget_Archive@post_' . $row['cid'],
            "type=post",
            "cid=" . $row['cid']
        );
    }
    return $posts;
}
function _getByArticleTemplate($template, $page, $perpage, $except = 0)
{


    $db = Typecho_Db::get();
    $rows = $db->fetchAll(
        $db->select()->from('table.fields')
            ->where('name = ?', 'template')
            ->where('str_value = ?', $template)
            ->where('table.contents.cid <> ?', $except)
            ->page($page,$perpage)
            ->join('table.contents', 'table.contents.cid = table.fields.cid')
            ->order('created', Typecho_Db::SORT_DESC)
    );

    return rowToPosts($rows);
}
function rowToPosts($rows){
    
    $posts = [];

    foreach ($rows as $row) {
        
        $tmp = Typecho_Widget::widget(
            'Widget_Archive@post_' . $row['cid'],
            "type=post",
            "cid=" . $row['cid']
        );
        if($tmp->cid == NULL){
            var_dump($row['cid']);
        }
        $posts[] = $tmp;
    }
    
    return $posts;
}
function getArticles($page = 1, $perpage = 5, $except = -1)
{
    return _getByArticleTemplate('article', $page, $perpage);

    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $tableContents = $prefix . "contents";
    $tabbleFields = $prefix . "fields";
    $offset = ($page - 1) * $perpage;
    $query =
        <<<EOT
    SELECT  $tableContents.cid,$tableContents.created FROM  $tableContents  WHERE (
        (
                ((SELECT count(1) as cnt FROM $tabbleFields WHERE ( $tableContents.cid == $tabbleFields.cid))=0)
                
        )  AND  $tableContents.type="post" AND  $tableContents.status="publish"  AND  $tableContents.password is null AND  $tableContents.cid != $except
    )
    UNION
    SELECT  $tableContents.cid,$tableContents.created FROM  $tableContents JOIN $tabbleFields ON   $tableContents.cid = $tabbleFields.cid  WHERE (
        (
            ($tabbleFields.name = "template" AND $tabbleFields.str_value="article")			
        )  AND  $tableContents.type="post" AND  $tableContents.status="publish"  AND  $tableContents.password is null AND  $tableContents.cid != $except
    )
    ORDER BY $tableContents.created DESC
    LIMIT $perpage
    OFFSET $offset
EOT;
    /*

    */

    $rows = $db->query($query);
    return rowToPosts($rows);    
}
function getChineseDate($date)
{
    $weekarray = array("日", "一", "二", "三", "四", "五", "六");

    $day =  "星期" . $weekarray[date("w", $date->timeStamp)];
    return date("m 月 j 日　" . $day, $date->timeStamp);
}
function getDiarys($page = 1, $perpage = 5, $except = -1)
{
    $got = _getByArticleTemplate('diary', $page, $perpage, $except);
    //var_dump($got);
    return $got;
}
function getPins($page = 1, $perpage = 5)
{
    return _getByArticleTemplate('pin', $page, $perpage);
}
function getNotes($page = 1, $perpage = 5, $except = -1)
{
    return _getByArticleTemplate('note', $page, $perpage, $except);
}
function getPages()
{
    $db = Typecho_Db::get();
    $rows = $db->fetchAll(
        $db->select()->from('table.fields')
            ->where('name = ?', 'showInHome')
            ->where('str_value = ?', 'yes')
            ->join('table.contents', 'table.contents.cid = table.fields.cid')
            ->order('order', Typecho_Db::SORT_ASC)
    );
    $pages = [];

    foreach ($rows as $row) {
        $pages[] = Typecho_Widget::widget(
            'Widget_Archive@page_' . $row['cid'],
            "type=page",
            "cid=" . $row['cid']
        );
    }
    return $pages;
}

function importCSS(...$urls)
{
    foreach ($urls as $url) {
        if (!(strpos($url, "//") || strpos($url, "http"))) {
            ob_start();
            Helper::options()->themeUrl('css/' . $url . '.css');
            $url = ob_get_clean();
        }
        echo '<link href="' . $url . '" rel="stylesheet">' . "\n";
    }
}
function importJs(...$urls)
{
    foreach ($urls as $url) {
        if (!(strpos($url, "//") || strpos($url, "http"))) {
            ob_start();
            Helper::options()->themeUrl('js/' . $url . '.js');
            $url = ob_get_clean();
        }
        echo '<script src="' . $url . '"></script>' . "\n";
    }
}

function svg($name, $size = 24)
{
    echo '<img ' . 'width="' . $size . '" height="' . $size . '" src = "';
    Helper::options()->themeUrl('icon/' . $name . '.svg');
    echo '" >';
}
function getArticleById($id)
{
    $id = intval($id);
    $post = Typecho_Widget::widget('Widget_Archive@post_' . $id, "type=post", "cid=" . $id);
    //$post->have();
    return $post;
}

function getTitle($ego)
{
    $ego->archiveTitle(array(
        'category'  =>  _t('分类 %s 下的文章'),
        'search'    =>  _t('包含关键字 %s 的文章'),
        'tag'       =>  _t('标签 %s 下的文章'),
        'author'    =>  _t('%s 发布的文章')
    ), '', ' - ');
    _fuck($ego, 'options')->title();
}

function _fuck($obj, $prop)
{
    $reflection = new ReflectionClass($obj);
    $property = $reflection->getProperty($prop);
    $property->setAccessible(true);
    return $property->getValue($obj);
}
