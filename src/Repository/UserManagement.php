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
    private $ugRelationResourceModel;

    /**
     * UserManagement constructor.
     *
     * @param \App\Entity\User\ResourceModel\UserGroupRelation $ugRelation
     */
    public function __construct(UserGroupRelation $ugRelation)
    {
        $this->ugRelationResourceModel = $ugRelation;
    }

    /**
     * Get group relations belong to a user.
     *
     * @param  int $userId
     * @return array|mixed
     * @throws \Exception
     */
    public function getUserRelations(int $userId)
    {
        try {
            $ugRelations = $this->ugRelationResourceModel->findGroupsBelongToUser($userId);
            return $ugRelations;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
