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
use App\Api\User\UserRepositoryInterface;
use App\Core\DataObject;
use Exception;
use App\Core\ServiceProviderInterface;

/**
 * CollectUserGroupsServiceProvider
 *
 * Service provider that collects groups belong to a user
 */
class CollectUserGroupsServiceProvider implements ServiceProviderInterface
{

    /**
     * @var \App\Api\User\UserManagementInterface
     */
    private $userManagement;

    /**
     * @var \App\Api\User\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var int
     */
    private $userId;

    /**
     * CollectUserGroupsServiceProvider constructor.
     *
     * @param \App\Api\User\UserManagementInterface $userManagement
     * @param \App\Api\User\UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserManagementInterface $userManagement,
        UserRepositoryInterface $userRepository
    ) {
        $this->userManagement = $userManagement;
        $this->userRepository = $userRepository;
    }

    /**
     * Collect groups belong to a user
     *
     * @return array
     * @throws \Exception
     */
    public function execute()
    {
        try {
            $user = $this->userRepository->getById($this->userId);
            $ugRelations = $this->userManagement->getUserRelations($user->getId());
            return $this->toArray($ugRelations);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Set user id
     *
     * @param  int $userId
     * @return \App\Service\User\CollectUserGroupsServiceProvider
     */
    public function setUserId(int $userId) : self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Convert Collection objects to json objects
     *
     * @param  array $ugRelations
     * @return array
     */
    private function toArray(array $ugRelations): array
    {
        $items = [];
        foreach ($ugRelations as $item) {
            if ($item instanceof DataObject) {
                $items[] = $item->toArray();
            } else {
                $items[] = $item;
            }
        }

        return $items;
    }
}
