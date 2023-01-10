<?php
namespace App\Manager;

use App\Entity\UserCenter;
use App\Repository\CenterRepository;
use App\Repository\UserCenterRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserManager
{
    private EntityManagerInterface $em;
    private CenterRepository $centerRepository;
    private UserCenterRepository $userCenterRepository;

    public function __construct(EntityManagerInterface $entityManager,CenterRepository $centerRepository, UserCenterRepository $userCenterRepository)
    {
        $this->em = $entityManager;
        $this->centerRepository = $centerRepository;
        $this->userCenterRepository = $userCenterRepository;
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
