<?php
namespace Snippet\Utility;

/**
 * wrapper class for pagination
 */
class Pagination implements PaginationInterface
{
    private $beginPaginationCallback;
    private $endPaginationCallback;
    private $prevPaginationCallback;
    private $nextPaginationCallback;
    private $eachPaginationCallback;

    public $currentPage;
    public $totalItems;
    public $totalItemsPerPage;

    public function __construct($currPage, $totItems, $itemsPerPage)
    {
        $this->currentPage = $currPage;
        $this->totalItems = $totItems;
        $this->totalItemsPerPage = $itemsPerPage;
    }

    /**
     * Build pagination string
     * @return string
     */
    private function renderPagination($currentPage, $totalPage, $itemsPerPage, $totalItems)
    {
        $output = [];
        if (is_callable($this->beginPaginationCallback)) {
            $beginPaginationCallback = $this->beginPaginationCallback;
            $output[] = $beginPaginationCallback(0,
                            $currentPage, $totalPage, $itemsPerPage, $totalItems);
        }

        if (is_callable($this->prevPaginationCallback)) {
            $prevPaginationCallback = $this->prevPaginationCallback;
            $output[] = $prevPaginationCallback($currentPage - 1,
                            $currentPage, $totalPage, $itemsPerPage, $totalItems);
        }

        if (is_callable($this->eachPaginationCallback)) {
            $eachPaginationCallback = $this->eachPaginationCallback;
            for($page = 0; $page < $totalPage; $page++) {
                $output[] = $eachPaginationCallback($page,
                                $currentPage, $totalPage, $itemsPerPage, $totalItems);
            }
        }

        if (is_callable($this->nextPaginationCallback)) {
            $nextPaginationCallback = $this->nextPaginationCallback;
            $output[] = $nextPaginationCallback($currentPage + 1,
                                $currentPage, $totalPage, $itemsPerPage, $totalItems);
        }

        if (is_callable($this->endPaginationCallback)) {
            $endPaginationCallback = $this->endPaginationCallback;
            $output[] = $endPaginationCallback($totalPage - 1,
                                $currentPage, $totalPage, $itemsPerPage, $totalItems);
        }
        return join('', $output);
    }

    /**
     * Build pagination string
     * @return string
     */
    public function buildPagination()
    {
        if (($this->totalItems <= 0) || ($this->totalItemsPerPage <= 0)) {
            return '';
        }
        $totalPage = floor($this->totalItems / $this->totalItemsPerPage);
        $totalPage += (($this->totalItems % $this->totalItemsPerPage) > 0 ? 1 : 0);
        return $this->renderPagination($this->currentPage, $totalPage,
                            $this->totalItemsPerPage, $this->totalItems);
    }

    public function onBeginPage($callback)
    {
        $this->beginPaginationCallback = $callback;
    }

    public function onPrevPage($callback)
    {
        $this->prevPaginationCallback = $callback;
    }

    public function onEachPage($callback)
    {
        $this->eachPaginationCallback = $callback;
    }

    public function onNextPage($callback)
    {
        $this->nextPaginationCallback = $callback;
    }

    public function onEndPage($callback)
    {
        $this->endPaginationCallback = $callback;
    }
}
