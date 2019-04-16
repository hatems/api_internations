<?php

namespace App\Repository;

use App\Entity\Assignment;
use App\Entity\Group;
use App\Entity\User;
use App\Service\GroupService;
use App\Service\UserService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Assignment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assignment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assignment[]    findAll()
 * @method Assignment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssignmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry,UserService $userService,
                                GroupService $groupService)
    {
        parent::__construct($registry, Assignment::class);
        $this->GroupService = $groupService;
        $this->UserService = $userService;
    }

    public function save(Assignment $assignment){
        $check= $this->checkAssignment($assignment->getUser()->getId(),$assignment->getGroupe()->getId());
        if($check===false){
        $this->_em->persist($assignment);
        $this->_em->flush();
        }
    }

    public function delete(Assignment $assignment){
        $this->_em->remove($assignment);
        $this->_em->flush();
    }

    public function checkAssignment(int $user_id,int $group_id): bool
    {
        $user= $this->UserService->getUser($user_id);
        $group= $this->GroupService->getGroup($group_id);

        if( $this->findBy(
            ['groupe' => $group->getId(),
            'user' => $user->getId()]
        )){
            return true;
        }
        return false;
    }



}
