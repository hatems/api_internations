<?php
/**
 * Created by PhpStorm.
 * Assignment: Hatem Sahli
 * Date: 15/04/2019
 * Time: 15:19
 */

namespace App\Service;

use App\Repository\AssignmentRepository;
use App\Entity\Group;
use App\Entity\Assignment;
use App\Entity\User;

final class AssignmentService
{

    /**
     * @var AssignmentRepository
     */
    private $assignmentRepository;

    /**
     * @var UserService
     */
    private $UserService;

    /**
     * @var GroupService
     */
    private $GroupService;

    public function __construct(AssignmentRepository $assignmentRepository,UserService $userService,
    GroupService $groupService){
        $this->assignmentRepository = $assignmentRepository;
        $this->GroupService = $groupService;
        $this->UserService = $userService;
    }

    public function getAssignment(int $assignmentId): ?Assignment
    {
        return $this->assignmentRepository->findOneById($assignmentId);
    }

    public function getAllAssignments(): ?array
    {
        return $this->assignmentRepository->findAll();
    }

    public function addAssignment(int $user_id,int $group_id): Assignment
    {
        $user= $this->UserService->getUser($user_id);
        $group= $this->GroupService->getGroup($group_id);
        $assignment = new Assignment();
        $assignment->setUser($user);
        $assignment->setGroupe($group);
        $this->assignmentRepository->save($assignment);
        return $assignment;
    }


    /** remove users from a group*/
    public function deleteAssignment(int $userId,int $groupId): bool
    {
        $assignment = $this->assignmentRepository->findOneBy(
            ['groupe' => $groupId,
                'user' => $userId]
        );
        if ($assignment) {
            $this->assignmentRepository->delete($assignment);
            return true;
        }
        return false;
    }
    

}