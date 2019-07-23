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

namespace App\Api\User;

use App\Api\Search\CriteriaInterface;
use App\Api\User\Data\UserInterface;

/**
 * Interface UserRepositoryInterface
 *
 * Users are recommended to collect through an implementation of this interface
 *
 * @api
 * @version 100.0.0
 */
interface UserRepositoryInterface
{
    /**
     * Save a user instance
     *
     * @param  \App\Api\User\Data\UserInterface $user
     * @return \App\Api\User\Data\UserInterface
     */
    public function save(UserInterface $user);

    /**
     * Get a user instance by id
     *
     * @param  int $userId
     * @return \App\Api\User\Data\UserInterface
     */
    public function getById(int $userId);

    /**
     * Collection of user based on the search criteria provided
     *
     * @param  \App\Api\Search\CriteriaInterface $searchCriteria
     * @return \App\Api\User\Data\SearchResultInterface
     */
    public function getList(CriteriaInterface $searchCriteria);

    /**
     * Delete a user instance by Id
     *
     * @param  int $userId
     * @return bool true on success
     */
    public function deleteById($userId);

    /**
     * Delete a user by it's instance
     *
     * @param  \App\Api\User\Data\UserInterface $user
     * @return bool true on success
     */
    public function delete(UserInterface $user);
}
