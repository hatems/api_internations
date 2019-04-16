<?php

namespace App\Controller;

use App\Service\UserService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends AbstractFOSRestController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * In case our POST was a success we need to return a 201 HTTP CREATED response with the created User
     * In case we have an invalid request return a 400 HTTP Bad Request response
     * @Rest\Post("/users")
     */
    public function postUser(Request $request): View
    {
        if ($request->get('name') === '') {
            return View::create([], Response::HTTP_BAD_REQUEST);
        }else{
        $user = $this->userService->addUser($request->get('name'));
        return View::create($user, Response::HTTP_CREATED);
        }
    }

    /**
     * Removes the User resource
     * In case our DELETE was a success we return a 200 HTTP response. The user was deleted.
     * In case our DELETE was a failure we return a 204 HTTP response. The user was not deleted.
     * @Rest\Delete("/users/{userId}")
     */
    public function deleteUser(int $userId): View
    {
        if ($this->userService->deleteUser($userId) === true) {
            return View::create([], Response::HTTP_OK);
        } else {
            return View::create([], Response::HTTP_NO_CONTENT);
        }
    }

}