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

namespace App\Repository;

use App\Api\User\Data\UserGroupRelationInterface;
use App\Exceptions\EntitySaveException;
use Exception;
use App\Api\User\UserManagementInterface;
use App\Entity\User\ResourceModel\UserGroupRelation;

/**
 * UserManagement
 *
 * Repository that implements the management of assign/un-assign groups to a user
 */
class UserManagement implements UserManagementInterface
{

    /**
     * @var \App\Entity\User\ResourceModel\UserGroupRelation
     */
    private $ugRelation;

    /**
     * UserManagement constructor.
     *
     * @param \App\Entity\User\ResourceModel\UserGroupRelation $ugRelation
     */
    public function __construct(UserGroupRelation $ugRelation)
    {
        $this->ugRelation = $ugRelation;
    }

    /**
     * Add a user-group relation
     *
     * @param  \App\Api\User\Data\UserGroupRelationInterface $userManagement
     * @return bool|null
     */
    public function assignGroup(UserGroupRelationInterface $userManagement): ?bool
    {
        try {
            $this->ugRelation->assign($userManagement);
            return true;
        } catch (Exception $exception) {
            $relationSaveFailureException = new EntitySaveException();
            $relationSaveFailureException->setMessage(
                'User assignment to group is failed'
            );
        }
        return false;
    }

    /**
     * Remove a user-group relation
     *
     * @param  \App\Api\User\Data\UserGroupRelationInterface $userManagement
     * @return bool|null
     */
    public function unAssignGroup(UserGroupRelationInterface $userManagement): ?bool
    {
        try {
            $this->ugRelation->unAssign($userManagement);
            return true;
        } catch (Exception $exception) {
            $relationSaveFailureException = new EntitySaveException();
            $relationSaveFailureException->setMessage(
                'User un-assignment to group is failed'
            );
        }
        return false;
    }
}
