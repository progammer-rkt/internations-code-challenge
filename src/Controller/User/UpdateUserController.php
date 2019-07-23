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

namespace App\Controller\User;

use App\Api\User\Data\UserInterface;
use App\Core\Controller\PostController;
use App\Exceptions\EntityHasNoChangeException;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\EntitySaveException;
use App\Service\User\UpdateUserServiceProvider;
use Exception;
use Symfony\Component\Routing\Annotation\Route;

/**
 * UpdateUserController
 *
 * Deals with user update action
 *
 * - Validate inputs
 * - Make sure user exists
 * - Perform user update
 * - Returns a suitable json response
 */
class UpdateUserController extends PostController
{
    /**
     * API Endpoint that handles updating a user
     *
     * @Route("/api/user/{userId}", name="updateUser", methods={"PUT"})
     * @param  string $userId
     * @param  \App\Service\User\UpdateUserServiceProvider $serviceProvider
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function execute(
        $userId,
        UpdateUserServiceProvider $serviceProvider
    ) {
        try {
            // load user by id
            $user = $serviceProvider->getUserById((int)$userId);

            // checks data has any change
            if (!$this->isUserDataChanged($user)) {
                $noChangeException = new EntityHasNoChangeException();
                $noChangeException->setEntity(UserInterface::ENTITY);
                throw $noChangeException;
            }

            // setting new data to the user instance
            $data = $this->requestData();
            $user->setFullname($data[UserInterface::FULLNAME])
                ->setCountry($data[UserInterface::COUNTRY]);

            // checks whether changed entity is valid
            if ($this->isValid($user)) {
                // updating user
                $serviceProvider->execute();

                // success response
                return $this->successResponse($user->toArray());
            }

            // validation error occurred; so send validation error response
            return $this->validationErrorResponse($this->errors());
        } catch (EntityNotFoundException $exception) {
            // requested user could not found; so send "not-found-error" error response
            return $this->customFailureResponse($exception->message());
        } catch (EntitySaveException $exception) {
            // Some error occurred while saving; sends an "entity-save-failure" error response
            return $this->customFailureResponse($exception->message());
        } catch (EntityHasNoChangeException $exception) {
            // There is no change to the user; sends a "no-change-in-entity" error response
            return $this->customFailureResponse($exception->message());
        } catch (Exception $exception) {
            // Request failed due to unknown reason; sends server failure response
            return $this->serverFailureResponse();
        }
    }

    /**
     * Checks user data has any change
     *
     * @param  \App\Api\User\Data\UserInterface $user
     * @return bool
     */
    private function isUserDataChanged(UserInterface $user): bool
    {
        $data = $this->requestData();

        if ($data[UserInterface::FULLNAME] !== $user->getFullname()) {
            return true;
        }

        if ($data[UserInterface::COUNTRY] !== $user->getCountry()) {
            return true;
        }

        return false;
    }

    /**
     * Prepare an array based on the request body
     *
     * Request Data
     *
     * @return array
     */
    private function requestData(): array
    {
        $body = json_decode($this->request()->getContent(), true);
        $fullName = $body[UserInterface::FULLNAME] ?? '';
        $country = $body[UserInterface::COUNTRY] ?? '';
        return [
            UserInterface::FULLNAME => $fullName,
            UserInterface::COUNTRY  => $country,
        ];
    }
}
