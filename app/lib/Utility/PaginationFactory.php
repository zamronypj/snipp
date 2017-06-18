<?php
namespace Snippet\Utility;

use Snippet\Utility\Pagination;

/**
 * Factory class for pagination
 */
class PaginationFactory
{
    public function create($currentPage, $total, $take, $viewInstance, $currentUrlCallback)
    {
        $paginator = new Pagination($currentPage, $total, $take);
        $paginator->onBeginPage(function($page, $currPage, $totalPage, $itemsPerPage, $totalItems) use($viewInstance, $currentUrlCallback) {
            return $viewInstance->getPartial('pagination/begin', [
                'currentUrl' => $currentUrlCallback($page),
                'page' => $page,
                'currentPage' => $currPage,
                'totalPage' => $totalPage,
                'itemsPerPage' => $itemsPerPage,
                'totalItems' => $totalItems
            ]);
        });
        $paginator->onPrevPage(function($page, $currPage, $totalPage, $itemsPerPage, $totalItems) use($viewInstance, $currentUrlCallback) {
            return $viewInstance->getPartial('pagination/prev', [
                'currentUrl' => $currentUrlCallback($page),
                'page' => $page,
                'currentPage' => $currPage,
                'totalPage' => $totalPage,
                'itemsPerPage' => $itemsPerPage,
                'totalItems' => $totalItems
            ]);
        });
        $paginator->onEachPage(function($page, $currPage, $totalPage, $itemsPerPage, $totalItems) use($viewInstance, $currentUrlCallback) {
            return $viewInstance->getPartial('pagination/each', [
                'currentUrl' => $currentUrlCallback($page),
                'page' => $page,
                'currentPage' => $currPage,
                'totalPage' => $totalPage,
                'itemsPerPage' => $itemsPerPage,
                'totalItems' => $totalItems
            ]);
        });
        $paginator->onNextPage(function($page, $currPage, $totalPage, $itemsPerPage, $totalItems) use($viewInstance, $currentUrlCallback) {
            return $viewInstance->getPartial('pagination/next', [
                'currentUrl' => $currentUrlCallback($page),
                'page' => $page,
                'currentPage' => $currPage,
                'totalPage' => $totalPage,
                'itemsPerPage' => $itemsPerPage,
                'totalItems' => $totalItems
            ]);
        });
        $paginator->onEndPage(function($page, $currPage, $totalPage, $itemsPerPage, $totalItems) use($viewInstance, $currentUrlCallback) {
            return $viewInstance->getPartial('pagination/end', [
                'currentUrl' => $currentUrlCallback($page),
                'page' => $page,
                'currentPage' => $currPage,
                'totalPage' => $totalPage,
                'itemsPerPage' => $itemsPerPage,
                'totalItems' => $totalItems
            ]);
        });
        return $paginator;
    }
}
