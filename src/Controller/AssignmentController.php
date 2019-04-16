<?php

namespace App\Controller;

use App\Service\AssignmentService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AssignmentController extends AbstractFOSRestController
{
    /**
     * @var AssignmentService
     */
    private $assignmentService;

    /**
     * AssignmentController constructor.
     * @param AssignmentService $assignmentService
     */
    public function __construct(AssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    /**
     * Creates an Assignment
     * In case our POST was a success we need to return a 201 HTTP CREATED response with the created Assignment
     * In case we have an invalid request return a 400 HTTP Bad Request response
     * @Rest\Post("/assignments")
     */
    public function postAssignment(Request $request): View
    {
        if ($request->get('user_id') === '' || $request->get('group_id') === '') {
            return View::create([], Response::HTTP_BAD_REQUEST);
        }else {
            $this->assignmentService->addAssignment($request->get('user_id'), $request->get('group_id'));
            return View::create([], Response::HTTP_CREATED);
        }
    }

    /**
     * Removes an Assignment
     * In case our DELETE was a failure we return a 204 HTTP NO CONTENT response. The assignment was not deleted.
     * In case our DELETE was a failure we return a 200 HTTP NO CONTENT response. The assignment was deleted.
     * @Rest\Delete("/assignments/{userId}/{groupId}")
     */
    public function deleteAssignment(int $userId,int $groupId): View
    {
       if($this->assignmentService->deleteAssignment($userId,$groupId) === true){
        return View::create([], Response::HTTP_OK);
       }
        else{
            return View::create([], Response::HTTP_NO_CONTENT);
        }
    }

}