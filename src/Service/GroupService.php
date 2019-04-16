<?php

namespace App\Service;
use App\Repository\GroupRepository;
use App\Entity\Group;

final class GroupService
{

    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository){
        $this->groupRepository = $groupRepository;
    }

    public function getGroup(int $groupId): ?Group
    {
        return $this->groupRepository->findOneById($groupId);
    }

    public function getAllGroups(): ?array
    {
        return $this->groupRepository->findAll();
    }

    public function addGroup(string $name): Group
    {
        $group = new Group();
        $group->setName($name);
        $this->groupRepository->save($group);
        return $group;
    }


    /** Get the group by his Id
     * and then check if there is no users inside him
     * if it's the case delete him */
    public function deleteGroupIfEmpty(int $groupId): bool
    {
        $group = $this->groupRepository->findOneById($groupId);
        if ($group) {
        if ($group->getUsers()->count()===0){
            $this->groupRepository->delete($group);
            return true;
        }};
        return false;
    }


}