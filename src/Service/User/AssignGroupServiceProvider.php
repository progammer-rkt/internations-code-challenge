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

namespace App\Service\User;

use App\Api\User\UserManagementInterface;
use Exception;
use App\Api\Group\GroupRepositoryInterface;
use App\Api\User\Data\UserGroupRelationInterface;
use App\Api\User\UserRepositoryInterface;
use App\Core\ServiceProviderInterface;

/**
 * AssignGroupServiceProvider
 *
 * Service provider that will assign a group to a user
 */
class AssignGroupServiceProvider implements ServiceProviderInterface
{

    /**
     * @var int
     */
    private $groupId;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var \App\Api\User\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var \App\Api\Group\GroupRepositoryInterface
     */
    private $groupRepository;

    /**
     * @var \App\Api\User\Data\UserGroupRelationInterface
     */
    private $userGroupRelation;

    /**
     * @var \App\Api\User\UserManagementInterface
     */
    private $userManagement;

    /**
     * AssignGroupServiceProvider constructor.
     *
     * @param \App\Api\User\UserRepositoryInterface         $userRepository
     * @param \App\Api\Group\GroupRepositoryInterface       $groupRepository
     * @param \App\Api\User\Data\UserGroupRelationInterface $userGroupRelation
     * @param \App\Api\User\UserManagementInterface         $userManagement
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        GroupRepositoryInterface $groupRepository,
        UserGroupRelationInterface $userGroupRelation,
        UserManagementInterface $userManagement
    ) {
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->userGroupRelation = $userGroupRelation;
        $this->userManagement = $userManagement;
    }

    /**
     * Assigns a group to user
     *
     * @return bool|mixed
     * @throws \Exception
     */
    public function execute()
    {
        try {
            $user = $this->userRepository->getById($this->userId);
            $group = $this->groupRepository->getById($this->groupId);

            $this->userGroupRelation->setUserId($user->getId());
            $this->userGroupRelation->setGroupId($group->getId());

            return $this->userManagement->assignGroup($this->userGroupRelation);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Set Group ID
     *
     * @param  int $groupId
     * @return \App\Service\User\AssignGroupServiceProvider
     */
    public function setGroupId(int $groupId): self
    {
        $this->groupId = $groupId;
        return $this;
    }

    /**
     * Set User Id
     *
     * @param  int $userId
     * @return \App\Service\User\AssignGroupServiceProvider
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }
}
