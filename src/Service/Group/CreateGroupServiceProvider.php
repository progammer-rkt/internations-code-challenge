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
use App\Exceptions\EntitySaveException;

class CreateGroupServiceProvider implements ServiceProviderInterface
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
     * CreateGroupServiceProvider constructor.
     *
     * @param \App\Api\Group\GroupRepositoryInterface $groupRepository
     */
    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * Creating new group
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
     * Set the group to perform save later
     *
     * @param  \App\Api\Group\Data\GroupInterface $group
     * @return $this
     */
    public function setGroup(GroupInterface $group): self
    {
        $this->group = $group;
        return $this;
    }
}
