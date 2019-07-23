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
 * Interface UserGroupRelationInterface
 *
 * Use to define a concrete group assignment relation entity
 *
 * @api
 * @version 100.0.0
 */
interface UserGroupRelationInterface
{

    /**
* #@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY = 'user_group_relation';
    const ENTITY_ID = 'id';
    const USER_ID = 'user_id';
    const GROUP_ID = 'group_id';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getUserId();

    /**
     * @return int
     */
    public function getGroupId();

    /**
     * @param  int $userId
     * @return \App\Api\User\Data\UserGroupRelationInterface
     */
    public function setUserId(int $userId);

    /**
     * @param  int $groupId
     * @return \App\Api\User\Data\UserGroupRelationInterface
     */
    public function setGroupId(int $groupId);
}
