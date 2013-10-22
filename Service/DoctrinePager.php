<?php

namespace DevDrive\PagerBundle\Service;

use Doctrine\ORM\Tools\Pagination\Paginator;


/**
 * Some code is used from doctrine 1.2 pager
 *
 * @inheritdoc
 */
class DoctrinePager extends Paginator implements PagerInterface
{
    protected $query;
    protected $page;
    protected $maxPerPage;
    protected $lastPage;

    /**
     * Construct, we will construct the Paginator in the init method.
     */
    public function __construct()
    {

    }

    /**
     * Init
     *
     * @param \Doctrine\ORM\Query $query
     * @param int $page
     * @param int $maxPerPage
     * @param bool $fetchJoinCollection
     * @throws \Exception
     */
    public function init(\Doctrine\ORM\Query $query, $page = 1, $maxPerPage = 20, $fetchJoinCollection = true)
    {
        $page = (int) $page;
        $maxPerPage = (int) $maxPerPage;

        if ($page < 1 || $maxPerPage < 1)
        {
            throw new \Exception('Invalid pager parameters.');
        }

        $this->query = $query;
        $this->page = $page;
        $this->maxPerPage = $maxPerPage;

        $this->query
            ->setFirstResult($this->page * $this->maxPerPage - $this->maxPerPage)
            ->setMaxResults($this->maxPerPage)
        ;

        parent::__construct($this->query, $fetchJoinCollection);

        $this->lastPage = ceil($this->count() / $this->getMaxPerPage());
    }

    /**
     * Gets the first page, its always 1.
     * For historical purposes...
     *
     * @abstract
     * @return int
     */
    public function getFirstPage()
    {
        return 1;
    }

    /**
     * Get the last page
     *
     * @abstract
     * @return int
     */
    public function getLastPage()
    {
        return $this->lastPage;
    }

    /**
     * Get max number of results per page
     *
     * @abstract
     * @return int
     */
    public function getMaxPerPage()
    {
        return $this->maxPerPage;
    }


    /**
     * Get the next page number, if we are on the last
     * page it will return the current page
     *
     * @abstract
     * @return int
     */
    public function getNextPage()
    {
        return min($this->getPage() + 1, $this->getLastPage());
    }


    /**
     * Get the number of results (all, not just for the current page)
     *
     * @abstract
     * @return int
     */
    public function getNumResults()
    {
        return $this->count();
    }


    /**
     * Get the current page number
     *
     * @abstract
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Get the previous page, if we are in the first
     * page it will return 1
     *
     * @abstract
     * @return int
     */
    public function getPreviousPage()
    {
        return max($this->getPage() - 1, $this->getFirstPage());
    }

    /**
     * Get the number of results in the current page.
     * In the last page, it's not equal with the maxPerPage
     *
     * @abstract
     * @return int
     */
    public function getResultsInPage()
    {
        $page = $this->getPage();

        if ($page != $this->getLastPage()) {
            return $this->getMaxPerPage();
        }

        $offset = ($this->getPage() - 1) * $this->getMaxPerPage();

        return abs($this->getNumResults() - $offset);
    }


    /**
     * Return true, if there is more than one page.
     *
     * @abstract
     * @return boolean
     */
    public function haveToPaginate()
    {
        return ($this->getNumResults() > $this->getMaxPerPage());
    }


    /**
     * Return an array, with $chunk elements,
     * in the middle with the current page
     *
     * @abstract
     * @param $chunk
     * @return array
     */
    public function getPagination($chunk = 5)
    {
        $page  = $this->getPage();
        $pages = $this->getLastPage();

        if ($chunk > $pages) {
            $chunk = $pages;
        }

        $chunkStart = $page - (floor($chunk / 2));
        $chunkEnd   = $page + (ceil($chunk / 2)-1);

        if ($chunkStart < 1) {
            $adjust = 1 - $chunkStart;
            $chunkStart = 1;
            $chunkEnd = $chunkEnd + $adjust;
        }

        if ($chunkEnd > $pages) {
            $adjust = $chunkEnd - $pages;
            $chunkStart = $chunkStart - $adjust;
            $chunkEnd = $pages;
        }

        return range($chunkStart, $chunkEnd);
    }
}

