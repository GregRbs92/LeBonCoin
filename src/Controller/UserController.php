<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Utils\CommonService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * Create a new user
     *
     * @Rest\Post("/register", name="create_user")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $body      = $request->request;
        $firstName = $body->get('firstName');
        $lastName  = $body->get('lastName');
        $email     = $body->get('email');
        $password  = $body->get('password');
        // Verify that all the fields are defined
        if(!CommonService::isAllDefined($firstName, $lastName, $email, $password)) {
            throw new HttpException(400, 'Fields missing');
        }
        // Verify that the email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new HttpException(400, 'Your email is not valid');
        }
        // Create a new User
        $user = new User();
        // Encode the password
        $encodedPassword = $encoder->encodePassword($user, $password);
        // Set the different fields of the new user
        $user
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPassword($encodedPassword);
        // Get the entity manager and persist the entity
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response(null, 201);
    }
}
