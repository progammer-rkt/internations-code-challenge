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

namespace App\Controller\Admin;

use Exception;
use App\Core\Controller\BaseController;
use App\Entity\AdminUser;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * AuthLoginController
 *
 * API endpoint for authenticating an admin user
 */
class AuthLoginController extends BaseController
{

    /**
     * Authenticate and provide JWT for an admin user
     *
     * @Route("/api/login_check", methods={"POST"})
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $jwtManager
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function execute(
        JWTTokenManagerInterface $jwtManager,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager
    ) {
        $username = $this->request()->get('username', false);
        $password = $this->request()->get('password', false);

        if (!$username || !$password) {
            return $this->validationErrorResponse([
                'Username or Password is wrong. Please try again'
            ]);
        }

        try {
            // find admin user by username
            $adminUser = $entityManager
                ->getRepository(AdminUser::class)
                ->findOneBy(['username' => $username]);

            if (!$adminUser) {
                return $this->invalidAdminResponse();
            }

            $isValid = $passwordEncoder->isPasswordValid($adminUser, $password);

            if (!$isValid) {
                return $this->invalidAdminResponse();
            }

            return $this->successResponse(['token' => $jwtManager->create($adminUser)]);
        } catch (Exception $exception) {
            return $this->customFailureResponse('Request is invalid. Please try again');
        }
    }

    private function invalidAdminResponse()
    {
        return $this->customFailureResponse('Invalid Admin User');
    }
}
