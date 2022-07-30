<?php

namespace common\widgets;

use Yii;
use yii\base\Widget;

class Pagination extends Widget
{
    const FIRST_PAGE = 0;
    public $pagination;
    public $links;
    public $currentRoute;
    public $id;

    public function run()
    {
        if ($this->pagination->pageCount > 1) {
            $this->prepareData();
        }
    }

    protected function prepareData()
    {
        $this->currentRoute = Yii::$app->controller->route;
        if (isset($_GET['id'])) {
            $this->id = $_GET['id'];
        }
        $firstPage = $this::FIRST_PAGE;
        $lastPage = $this->pagination->pageCount - 1;
        $currentPage = $this->pagination->page;
        $prevPage = $currentPage - 1;
        $nextPage = $currentPage + 1;
        $leftElipsis = $currentPage - $firstPage;
        $rightElipsis = $lastPage - $currentPage;

        if ($firstPage === $currentPage)
            $this->renderView($firstPage, 'current');
        else
            $this->renderView($firstPage);

        if ($leftElipsis > 3)
            $this->renderView($leftElipsis, 'elipsis');

        if ($prevPage !== $firstPage && $prevPage > 0)
            $this->renderView($prevPage);

        if ($currentPage !== $firstPage && $currentPage !== $lastPage)
            $this->renderView($currentPage, 'current');

        if ($nextPage < $lastPage)
            $this->renderView($nextPage);

        if ($rightElipsis > 3)
            $this->renderView($rightElipsis, 'elipsis');

        if ($lastPage === $currentPage)
            $this->renderView($lastPage, 'current');
        else
            $this->renderView($lastPage);
    }

    protected function renderView($link, $status = 'default')
    {
        $link++;
        if ($status === 'default') {
            include __DIR__ . '/layouts/pagination/default.php';
        } elseif ($status === 'current') {
            include __DIR__ . '/layouts/pagination/current.php';
        } else {
            include __DIR__ . '/layouts/pagination/elipsis.php';
        }
    }
}
