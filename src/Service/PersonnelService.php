<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\PersonnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PersonnelService
{
    protected $personnelRepository;
    protected $userRepository;
    protected $entityManager;
    protected $encoder;




    public function __construct(UserRepository $userRepository, PersonnelRepository $personnelRepository, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->personnelRepository = $personnelRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }


    public function addUser($personnel)
    {
        $user = new User();
        $role = ["ROLE_USER"];
        $user->setPersonnel($personnel)
            ->setEmail($personnel->getEmail())
            ->setUsername($personnel->getNom() . ' ' . $personnel->getPrenom())
            ->setPassword($this->encoder->encodePassword($user, $personnel->getPpr()))
            ->setRoles($role);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function delete(int $id)
    {
        $personnel = $this->personnelRepository->find($id);
        $user = $this->userRepository->findOneBy([
            'personnel' => $personnel
        ]);
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}