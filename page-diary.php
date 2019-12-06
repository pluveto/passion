<?php

/**
 * 日记归档
 *
 * @package custom
 */
$this->_currentPage = getCurrentPage();
$this->type = '日记';
$this->typeId = 'note';
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
<style>
    .calendar {
        position: relative;
        width: 300px;
        background-color: #fff;
        box-sizing: border-box;
        border-radius: 8px;
        overflow: hidden;
    }

    .calendar__date {
        padding: 20px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(25px, 1fr));
        grid-gap: 10px;
        box-sizing: border-box;
    }

    .calendar__day {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 25px;
        font-weight: 600;
        color: #262626;
    }

    .calendar__day:nth-child(7) {
        color: #ff685d;
    }

    .calendar__number {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 25px;
        color: #262626;
    }

    .calendar__number:nth-child(7n) {
        color: #ff685d;
        font-weight: 700;
    }

    .calendar__number--current,
    .calendar__number:hover {
        background-color: #009688;
        color: #fff !important;
        font-weight: 700;
        cursor: pointer;
    }
    .calendar__number--diary{
        background-color: #ff685d;
        color: #fff !important;
        font-weight: 700;
        cursor: pointer;
    }
    .calendar__number--diary a{
        color: #fff !important;
    }
    .calendar {
        min-width: 300px;
    }
</style>

<body class=" font-serif">
    <p></p>
    <div class="container home-toc" id="write">

        <h1><a href="<?php $this->options->siteUrl() ?>"><?php $this->options->title(); ?></a></h1>
        <p><?php $this->options->description(); ?></p>

        <h2><?php echo $this->type ?></h2>
        <?php
        $yearMonth = getYearAndMonth();
        $year = $yearMonth['year'];
        $month = $yearMonth['month'];
        $time = time();
        $firstDayTime = mktime(0, 0, 0, intval($month), 1, intval($year));
        $days = date("t", $firstDayTime);
        $startweekDay = date("w", $firstDayTime);
        $lastDayTime = mktime(23, 59, 59, intval($month), intval($days), intval($year));

        $this->articles = getDiarysDuring($firstDayTime, $lastDayTime);
        ?>


        <div class="sm-list-no-flex">
            <div class="calendar">
                <h3 class="m-0"><?php echo date('M, Y', $firstDayTime) ?></h3>
                <div class="flex">
                    <?php

                    $yNew = intval($year);
                    $mPlus = $month + 1;
                    if ($mPlus == 13) {
                        $mPlus = 1;
                        $yNew++;
                    }
                    $mMinus = $month - 1;
                    if ($mMinus == 0) {
                        $mMinus = 12;
                        $yNew--;
                    }
                    ?>
                    <a href="<?php echo $this->permalink . '?a=/year/' . $year . '/month/' . $mMinus; ?>" class="m-2 flex-1 w-1/2 text-center" style="border-bottom: 1px solid">上个月</a>
                    <a href="<?php echo $this->permalink . '?a=/year/' . $year . '/month/' . $mPlus; ?>" class="m-2 flex-1 w-1/2 text-center" style="border-bottom: 1px solid">下个月</a>
                </div>
                <div class="calendar__date">
                    <div class="calendar__day">一</div>
                    <div class="calendar__day">二</div>
                    <div class="calendar__day">三</div>
                    <div class="calendar__day">四</div>
                    <div class="calendar__day">五</div>
                    <div class="calendar__day">六</div>
                    <div class="calendar__day">日</div>
                    <?php


                    if ($startweekDay == 0) {
                        $startweekDay = 7;
                    }
                    for ($i = 1; $i < $startweekDay; $i++) {
                        echo '<div class="calendar__number"></div>';
                    }
                    for ($i = 1; $i <= $days; $i++) {
                        $loopYmj = $year . ' ' . $month . ' ' . $i;
                        $dayStart = mktime(0,0,0,$month,$i,$year);
                        $dayEnd = mktime(23,59,59,$month,$i,$year);
                        $foundFlag = false;
                        $link = '';
                        foreach($this->articles as $single){
                            if($single->date->timeStamp <= $dayEnd && $single->date->timeStamp >= $dayStart){
                                $foundFlag = true;
                                $link = $single->permalink;
                            }
                        }

                        if (date('Y m j') == $loopYmj) {
                            echo '<div class="calendar__number calendar__number--current">' . $i . '</div>';
                        } else if($foundFlag){
                            echo '<div class="calendar__number calendar__number--diary"><a href="'.$link .'">' . $i . '</a></div>';
                        }else {
                            echo '<div class="calendar__number">' . $i . '</div>';
                        }
                    }
                    ?>
                </div>

            </div>

            <div class="justify-end">
                <ul>
                    <?php
                    if (count($this->articles) == 0) {
                        echo "当月没有日记";
                        $this->response->setStatus(404);
                    }
                    foreach ($this->articles as $single) { ?>
                        <li>
                            <div class="flex">
                                <div class="flex-1">
                                    <a class="ani-underline" href="<?php $single->permalink(); ?>"><?php $single->title(); ?></a>
                                </div>
                                <div class="justify-end sm-hidden min-width-5em text-right"><?php $single->date("M j"); ?></div>
                            </div>
                            <div class="post-desc">
                                <?php $single->excerpt(); ?>
                            </div>
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
        </div>

    </div>
    <div class="footer">
        <div class="container font-sans">
            Powered by Typecho. Theme “Passion” by Pluveto.
        </div>
    </div>
</body>

</html>