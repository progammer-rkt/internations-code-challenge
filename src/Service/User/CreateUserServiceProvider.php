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
use App\Exceptions\EntitySaveException;

class CreateUserServiceProvider implements ServiceProviderInterface
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
     * CreateUserServiceProvider constructor.
     *
     * @param \App\Api\User\UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Creating new user
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
     * Set the user to perform save later
     *
     * @param  \App\Api\User\Data\UserInterface $user
     * @return $this
     */
    public function setUser(UserInterface $user): self
    {
        $this->user = $user;
        return $this;
    }
}
