<?php
/**
 * Code Challenge - InterNations
 *
 * This file is a part of the code challenge that is given by
 * the InterNations Team.
 *
 * @version   1.0.0
 * @author    Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 * @copyright Copyright © Rajeev K Tomy
 */

namespace App\Api\Search;

/**
 * Interface SearchResultInterface
 *
 * Use to construct a search criteria that should be provided
 * to a repository's getList method to grab the collections.
 *
 * This interface is deliberately made simple due to the simplicity
 * in the requirements. However in a large application, this could
 * be become much more complex
 *
 * @api
 * @version 100.0.0
 */
interface CriteriaInterface
{
    const LIMIT = 'limit';
    const START = 'start';
    const SORT_ORDER = 'order';
    const ASCENDING = 'asc';
    const DESCENDING = 'desc';

    /**
     * Get search criteria limit
     *
     * @return number
     */
    public function getLimit();

    /**
     * Get search criteria start
     *
     * @return number
     */
    public function getStart();

    /**
     * Get search criteria sort order
     *
     * @return array
     */
    public function getSortOrder();

    /**
     * Set search criteria limit
     *
     * @param  int $limit
     * @return \App\Api\Search\CriteriaInterface
     */
    public function setLimit(int $limit);

    /**
     * Set search criteria start
     *
     * @param  int $start
     * @return \App\Api\Search\CriteriaInterface
     */
    public function setStart(int $start);

    /**
     * Set search criteria sort order
     *
     * @param  array $sortOrder
     * @return \App\Api\Search\CriteriaInterface
     */
    public function setSortOrder(array $sortOrder);

    /**
     * Get search filters
     *
     * @return array
     */
    public function getFilters();

    /**
     * Set search filters
     *
     * @param  array $filter
     * @return \App\Api\Search\CriteriaInterface
     */
    public function setFilters(array $filter);
}
