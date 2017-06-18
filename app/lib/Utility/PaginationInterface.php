<?php
namespace Snippet\Utility;

/**
 * interface for pagination
 */
interface PaginationInterface
{
    /**
     * Build pagination string
     * @return string
     */
    public function buildPagination();
}
