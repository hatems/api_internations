<?php

namespace App\Controller;

use App\Service\GroupService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GroupController extends AbstractFOSRestController
{
    /**
     * @var GroupService
     */
    private $groupService;

    /**
     * GroupController constructor.
     * @param GroupService $groupService
     */
    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    /**
     * In case our POST was a success we need to return a 201 HTTP CREATED response with the created Group
     * In case we have an invalid request return a 400 HTTP Bad Request response
     * @Rest\Post("/groups")
     */
    public function postGroup(Request $request): View
    {
        if ($request->get('name') === '') {
            return View::create([], Response::HTTP_BAD_REQUEST);
        }else{
        $group = $this->groupService->addGroup($request->get('name'));
        return View::create($group, Response::HTTP_CREATED);
        }
    }

    /**
     * Removes the Group resource
     * In case our DELETE was a success we return a 200 HTTP response. The group was deleted.
     * In case our DELETE was a failure we return a 204 HTTP response. The group was not deleted.
     * @Rest\Delete("/groups/{groupId}")
     */
    public function deleteGroup(int $groupId): View
    {
       if ( $this->groupService->deleteGroupIfEmpty($groupId)){
           return View::create([], Response::HTTP_OK);
       } else {
           return View::create([], Response::HTTP_NO_CONTENT);
       }
    }

}