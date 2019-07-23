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

namespace App\Core\Search;

use App\Api\Search\CriteriaInterface;

/**
 * Search Criteria
 *
 * Implementing a basic search criteria module
 *
 * This will provide a provision to set limit, offset, sort order, filtering
 * and there by consistently use it for db query search
 */
class Criteria implements CriteriaInterface
{

    /**
     * @var string
     */
    private $sortOrder;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $start;

    /**
     * @var array
     */
    private $filters = [];

    /**
     * Get search limit
     *
     * @return int
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Set collection limit
     *
     * @param  int $limit
     * @return \App\Core\Search\Criteria
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Get sort order
     *
     * @return array|null
     */
    public function getSortOrder(): ?array
    {
        return $this->sortOrder;
    }

    /**
     * Set sort order
     *
     * @param  array $sortOrder
     * @return \App\Core\Search\Criteria
     */
    public function setSortOrder(array $sortOrder): self
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * Set start
     *
     * @return int
     */
    public function getStart(): ?int
    {
        return $this->start;
    }

    /**
     * Set start
     *
     * @param  int $start
     * @return \App\Core\Search\Criteria
     */
    public function setStart(int $start): self
    {
        $this->start = $start;
        return $this;
    }

    /**
     * Get filters
     *
     * @return array
     */
    public function getFilters() : array
    {
        return $this->filters;
    }

    /**
     * Set Filters
     *
     * @param  array $filters
     * @return \App\Core\Search\Criteria
     */
    public function setFilters(array $filters) : self
    {
        $this->filters = $filters;
        return $this;
    }
}
