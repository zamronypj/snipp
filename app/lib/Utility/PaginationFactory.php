<?php
namespace Snippet\Utility;

use Snippet\Utility\Pagination;

/**
 * Factory class for pagination
 */
class PaginationFactory
{
    public function create($currentUrl, $viewInstance, $currentPage, $total, $take)
    {
        $paginator = new Pagination($currentPage, $total, $take);
        $paginator->onBeginPage(function($page, $currPage, $totalPage, $itemsPerPage, $totalItems) use($viewInstance, $currentUrl) {
            return $viewInstance->getPartial('pagination/begin', [
                'currentUrl' => $currentUrl,
                'page' => $page,
                'currentPage' => $currPage,
                'totalPage' => $totalPage,
                'itemsPerPage' => $itemsPerPage,
                'totalItems' => $totalItems
            ]);
        });
        $paginator->onPrevPage(function($page, $currPage, $totalPage, $itemsPerPage, $totalItems) use($viewInstance, $currentUrl) {
            return $viewInstance->getPartial('pagination/prev', [
                'currentUrl' => $currentUrl,
                'page' => $page,
                'currentPage' => $currPage,
                'totalPage' => $totalPage,
                'itemsPerPage' => $itemsPerPage,
                'totalItems' => $totalItems
            ]);
        });
        $paginator->onEachPage(function($page, $currPage, $totalPage, $itemsPerPage, $totalItems) use($viewInstance, $currentUrl) {
            return $viewInstance->getPartial('pagination/each', [
                'currentUrl' => $currentUrl,
                'page' => $page,
                'currentPage' => $currPage,
                'totalPage' => $totalPage,
                'itemsPerPage' => $itemsPerPage,
                'totalItems' => $totalItems
            ]);
        });
        $paginator->onNextPage(function($page, $currPage, $totalPage, $itemsPerPage, $totalItems) use($viewInstance, $currentUrl) {
            return $viewInstance->getPartial('pagination/next', [
                'currentUrl' => $currentUrl,
                'page' => $page,
                'currentPage' => $currPage,
                'totalPage' => $totalPage,
                'itemsPerPage' => $itemsPerPage,
                'totalItems' => $totalItems
            ]);
        });
        $paginator->onEndPage(function($page, $currPage, $totalPage, $itemsPerPage, $totalItems) use($viewInstance, $currentUrl) {
            return $viewInstance->getPartial('pagination/end', [
                'currentUrl' => $currentUrl,
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
