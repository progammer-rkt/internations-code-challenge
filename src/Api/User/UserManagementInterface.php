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

use App\Api\User\Data\UserGroupRelationInterface;

/**
 * Interface UserManagementInterface
 *
 * Use to enforce group assignment responsibilities
 *
 * @api
 * @version 100.0.0
 */
interface UserManagementInterface
{

    /**
     * @param  \App\Api\User\Data\UserGroupRelationInterface $ugRelation
     * @return bool true if success
     */
    public function assignGroup(UserGroupRelationInterface $ugRelation);

    /**
     * @param  \App\Api\User\Data\UserGroupRelationInterface $ugRelation
     * @return bool true if success
     */
    public function unAssignGroup(UserGroupRelationInterface $ugRelation);
}
