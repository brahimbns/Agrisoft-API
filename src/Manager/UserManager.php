<?php
namespace App\Manager;

use App\Entity\UserCenter;
use App\Repository\CenterRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserManager
{
    private EntityManagerInterface $em;
    private CenterRepository $centerRepository;

    public function __construct(EntityManagerInterface $entityManager,CenterRepository $centerRepository)
    {
        $this->em = $entityManager;
        $this->centerRepository = $centerRepository;
    }

    public function addUserCenter($request, $user, ): UserCenter
    {

        $content = $request->toArray();
        $idCenter = $content['center'] ?? -1;

        $userCenter = new UserCenter();
        $userCenter->setCenterId($this->centerRepository->find($idCenter));
        $userCenter->setUserId($user);

        return $userCenter;
    }

}
