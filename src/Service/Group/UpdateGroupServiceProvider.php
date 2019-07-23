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

namespace App\Service\Group;

use App\Api\Group\GroupRepositoryInterface;
use Exception;
use App\Api\Group\Data\GroupInterface;
use App\Exceptions\EntitySaveException;

/**
 * UpdateGroupServiceProvider
 *
 * Service provider that handles updating a group details
 */
class UpdateGroupServiceProvider
{
    /**
     * @var \App\Repository\GroupRepository
     */
    private $groupRepository;

    /**
     * @var \App\Api\Group\Data\GroupInterface
     */
    private $group;

    /**
     * UpdateGroupServiceProvider constructor.
     *
     * @param \App\Api\Group\GroupRepositoryInterface $groupRepository
     */
    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * Update new group
     *
     * @return \App\Api\Group\Data\GroupInterface|\App\Entity\Group
     * @throws \App\Exceptions\EntitySaveException
     */
    public function execute()
    {
        try {
            return $this->groupRepository->save($this->group);
        } catch (EntitySaveException $exception) {
            throw $exception;
        }
    }

    /**
     * Collect group by id
     *
     * @param  int $groupId
     * @return \App\Api\Group\Data\GroupInterface|null
     * @throws \Exception
     */
    public function getGroupById(int $groupId): ?GroupInterface
    {
        try {
            $this->group = $this->groupRepository->getById($groupId);
            return $this->group;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
