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

namespace App\Api\Group;

use App\Api\Search\CriteriaInterface;
use App\Api\Group\Data\GroupInterface;

/**
 * Interface GroupRepositoryInterface
 *
 * Groups are recommended to collect through an implementation of this interface
 *
 * @api
 * @version 100.0.0
 */
interface GroupRepositoryInterface
{
    /**
     * Save a group instance
     *
     * @param  \App\Api\Group\Data\GroupInterface $group
     * @return \App\Api\Group\Data\GroupInterface
     */
    public function save(GroupInterface $group);

    /**
     * Get a group instance by id
     *
     * @param  int $groupId
     * @return \App\Api\Group\Data\GroupInterface
     */
    public function getById(int $groupId);

    /**
     * Collection of group based on the search criteria provided
     *
     * @param  \App\Api\Search\CriteriaInterface $searchCriteria
     * @return \App\Api\Group\Data\SearchResultInterface
     */
    public function getList(CriteriaInterface $searchCriteria);

    /**
     * Delete a group instance by Id
     *
     * @param  int $groupId
     * @return bool true on success
     */
    public function deleteById($groupId);

    /**
     * Delete a group by it's instance
     *
     * @param  \App\Api\Group\Data\GroupInterface $group
     * @return bool true on success
     */
    public function delete(GroupInterface $group);
}
