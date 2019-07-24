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
declare(strict_types=1);

namespace App\Api\User;

use App\Api\Search\CriteriaInterface;
use App\Api\User\Data\UserGroupRelationInterface;

/**
 * UGRelationRepositoryInterface
 *
 * Repository interface for user_group_relation entity
 */
interface UGRelationRepositoryInterface
{

    /**
* #@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY = 'user_group_relation';
    const ENTITY_ID = 'id';
    const GROUP_ID = 'group_id';
    const USER_ID = 'user_id';

    /**
     * @param  int $id
     * @return \App\Api\User\Data\UserGroupRelationInterface
     */
    public function getById(int $id);

    /**
     * @param  \App\Api\Search\CriteriaInterface $criteria
     * @return \App\Api\User\Data\UserGroupRelationInterface[]
     */
    public function getBy(CriteriaInterface $criteria);

    /**
     * @param \App\Api\User\Data\UserGroupRelationInterface $userGroupRelation
     * @return bool true if success
     */
    public function create(UserGroupRelationInterface $userGroupRelation);

    /**
     * @param \App\Api\User\Data\UserGroupRelationInterface $userGroupRelation
     * @return bool true if success
     */
    public function delete(UserGroupRelationInterface $userGroupRelation);
}
