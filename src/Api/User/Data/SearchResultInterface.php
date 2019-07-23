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

namespace App\Api\User\Data;

/**
 * Interface SearchResultInterface
 *
 * Suppose to hold the collection of users which is provided by the
 * UserRepository
 *
 * @api
 * @version 100.0.0
 */
interface SearchResultInterface
{

    /**
     * Get User List
     *
     * @return []
     */
    public function getItems();

    /**
     * Set User List
     *
     * @param  array $items
     * @return \App\Api\User\Data\SearchResultInterface
     */
    public function setItems(array $items);
}
