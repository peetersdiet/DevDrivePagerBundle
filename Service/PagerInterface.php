<?php

namespace DevDrive\PagerBundle\Service;

/**
 * Pager is similar for the doctrine 1.2 pager.
 *
 */
interface PagerInterface
{

    /**
     * Gets the first page, its always 1.
     * For historical purposes...
     *
     * @abstract
     * @return int
     */
    public function getFirstPage();

    /**
     * Get the last page
     *
     * @abstract
     * @return int
     */
    public function getLastPage();


    /**
     * Get max number of results per page
     *
     * @abstract
     * @return int
     */
    public function getMaxPerPage();


    /**
     * Get the next page number, if we are on the last
     * page it will return the current page
     *
     * @abstract
     * @return int
     */
    public function getNextPage();

    /**
     * Get the number of results (all, not just for the current page)
     *
     * @abstract
     * @return int
     */
    public function getNumResults();


    /**
     * Get the current page number
     *
     * @abstract
     * @return int
     */
    public function getPage();


    /**
     * Get the previous page, if we are in the first
     * page it will return 1
     *
     * @abstract
     * @return int
     */
    public function getPreviousPage();


    /**
     * Get the number of results in the current page.
     * In the last page, it's not equal with the maxPerPage
     *
     * @abstract
     * @return int
     */
    public function getResultsInPage();


    /**
     * Return true, if there is more than one page.
     *
     * @abstract
     * @return boolean
     */
    public function haveToPaginate();


    /**
     * Return an array, with $chunk elements,
     * in the middle with the current page
     *
     * @abstract
     * @param $chunk
     * @return array
     */
    public function getPagination($chunk = 5);
}

