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

use App\Api\Group\Data\GroupInterface;
use App\Api\Group\GroupRepositoryInterface;
use App\Core\ServiceProviderInterface;
use App\Repository\GroupRepository;
use Exception;

/**
 * Service Provider that collect group details
 */
class GetGroupServiceProvider implements ServiceProviderInterface
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
     * GetGroupServiceProvider constructor.
     *
     * @param \App\Api\Group\GroupRepositoryInterface $groupRepository
     */
    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * Collect group details
     *
     * @return \App\Api\Group\Data\GroupInterface|\App\Entity\Group\ResourceModel\Group|mixed|null
     * @throws \Exception
     */
    public function execute(): GroupInterface
    {
        try {
            return $this->groupRepository->getById($this->getGroupId());
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
