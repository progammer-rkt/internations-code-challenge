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

namespace App\Api\Group\Data;

/**
 * Interface SearchResultInterface
 *
 * Suppose to hold the collection of groups which is provided by the
 * GroupRepository
 *
 * @api
 * @version 100.0.0
 */
interface SearchResultInterface
{

    /**
     * Get Group List
     *
     * @return []
     */
    public function getItems();

    /**
     * Set Group List
     *
     * @param  array $items
     * @return \App\Api\Group\Data\SearchResultInterface
     */
    public function setItems(array $items);
}
