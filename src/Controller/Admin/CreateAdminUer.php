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

namespace App\Controller\Admin;

use App\Core\Controller\BaseController;
use App\Entity\AdminUser;
use Exception;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * CreateAdminUer
 *
 * API endpoint that creates an admin user
 */
class CreateAdminUer extends BaseController
{

    /**
     * Creates admin user
     *
     * @Route("/api/create/admin", methods={"POST"})
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $jwtManager
     * @param \Symfony\Component\Security\Core\User\UserInterface $adminUser
     * @return \Symfony\Component\HttpFoundation\JsonResponse|null
     */
    public function execute(
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager,
        JWTTokenManagerInterface $jwtManager,
        UserInterface $adminUser
    ) {
        try {
            // collect inputs
            $username = $this->request()->get('username', false);
            $password = $this->request()->get('password', false);

            // make sure inputs are valid
            if (!$username || !$password) {
                return $this->validationErrorResponse([
                    'Username or Password fields are empty. Please check the inputs'
                ]);
            }

            // setting admin user
            $adminUser->setUsername($username);
            $adminUser->setRoles(['ROLE_USER']);
            $adminUser->setPassword($passwordEncoder->encodePassword(
                $adminUser,
                $password
            ));

            //perform save
            $entityManager->persist($adminUser);
            $entityManager->flush();

            $token = $jwtManager->create($adminUser);

            // send success response
            return $this->successResponse([
                'username' => $username,
                'password' => $password,
                'token' => $token
            ]);
        } catch (Exception $exception) {
            return $this->customFailureResponse([
                'We faced some issue while creating an admin user'
            ]);
        }
    }
}
