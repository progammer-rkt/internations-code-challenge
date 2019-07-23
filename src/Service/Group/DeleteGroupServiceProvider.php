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

namespace App\Service\Group;

use App\Api\Group\GroupRepositoryInterface;
use App\Core\ServiceProviderInterface;
use Exception;

/**
 * DeleteGroupServiceProvider
 *
 * Service provider to remove a group instance
 */
class DeleteGroupServiceProvider implements ServiceProviderInterface
{


    /**
     * Group repository
     *
     * @var \App\Repository\GroupRepository
     */
    private $groupRepository;

    /**
     * Hold group id
     *
     * @var int
     */
    private $groupId;

    /**
     * DeleteGroupServiceProvider constructor.
     *
     * @param \App\Api\Group\GroupRepositoryInterface $groupRepository
     */
    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * Remove group
     *
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function execute()
    {
        try {
            return $this->groupRepository->deleteById($this->getGroupId());
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Set Group ID
     *
     * @param  int $id
     * @return $this
     */
    public function setGroupId(int $id): self
    {
        $this->groupId = $id;
        return $this;
    }

    /**
     * Get Group ID
     *
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->groupId;
    }
}
