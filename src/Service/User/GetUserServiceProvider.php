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

use App\Api\User\Data\UserInterface;
use App\Api\User\UserRepositoryInterface;
use App\Core\ServiceProviderInterface;
use Exception;

/**
 * Service Provider that collect user details
 */
class GetUserServiceProvider implements ServiceProviderInterface
{

    /**
     * User repository
     *
     * @var \App\Repository\UserRepository
     */
    private $userRepository;

    /**
     * Hold user id
     *
     * @var int
     */
    private $userId;

    /**
     * GetUserServiceProvider constructor.
     *
     * @param \App\Api\User\UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Collect user details
     *
     * @return \App\Api\User\Data\UserInterface|\App\Entity\User\ResourceModel\User|mixed|null
     * @throws \Exception
     */
    public function execute(): UserInterface
    {
        try {
            return $this->userRepository->getById($this->getUserId());
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Set User ID
     *
     * @param  int $id
     * @return $this
     */
    public function setUserId(int $id): self
    {
        $this->userId = $id;
        return $this;
    }

    /**
     * Get User ID
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
