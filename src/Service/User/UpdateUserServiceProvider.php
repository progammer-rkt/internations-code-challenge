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

use App\Api\User\UserRepositoryInterface;
use Exception;
use App\Api\User\Data\UserInterface;
use App\Exceptions\EntitySaveException;

/**
 * UpdateUserServiceProvider
 *
 * Service provider that handles updating a user details
 */
class UpdateUserServiceProvider
{
    /**
     * @var \App\Repository\UserRepository
     */
    private $userRepository;

    /**
     * @var \App\Api\User\Data\UserInterface
     */
    private $user;

    /**
     * UpdateUserServiceProvider constructor.
     *
     * @param \App\Api\User\UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Update new user
     *
     * @return \App\Api\User\Data\UserInterface|\App\Entity\User
     * @throws \App\Exceptions\EntitySaveException
     */
    public function execute()
    {
        try {
            return $this->userRepository->save($this->user);
        } catch (EntitySaveException $exception) {
            throw $exception;
        }
    }

    /**
     * Collect user by id
     *
     * @param  int $userId
     * @return \App\Api\User\Data\UserInterface|null
     * @throws \Exception
     */
    public function getUserById(int $userId): ?UserInterface
    {
        try {
            $this->user = $this->userRepository->getById($userId);
            return $this->user;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
