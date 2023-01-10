<?php

namespace App\Controller;

use App\Entity\Credit;
use App\Entity\Farmer;
use App\Repository\CreditRepository;
use App\Repository\FarmerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreditController extends AbstractController
{
    private EntityManagerInterface $em;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private FarmerRepository $farmerRepository;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator, FarmerRepository $farmerRepository)
    {
        $this->em = $entityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->farmerRepository = $farmerRepository;
    }

    #[Route('/api/credit/post', 'post_credit', methods: ['POST'])]
    public function postCredit(Request $request): JsonResponse
    {
        $credit = $this->serializer->deserialize($request->getContent(), Credit::class, 'json');
        $errors = $this->validator->validate($credit);

        if ($errors->count() > 0) {
            return new JsonResponse($this->serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }
        $content = $request->toArray();
        $idFarmer = $content['farmer'] ?? -1;
        $credit->setFarmerId($this->farmerRepository->find($idFarmer));
        $this->em->persist($credit);
        $this->em->flush();
        return new JsonResponse($this->serializer->serialize($credit, 'json', ['groups' => 'Credit']), Response::HTTP_CREATED, [], true);

    }

    #[Route('/api/credit/show/{id}', name: 'show_credit', methods: ['GET'])]
    public function showCredit(Credit $credit): JsonResponse
    {
        $jsonCredit = $this->serializer->serialize($credit, 'json', ['groups' => 'Credit']);
        return new JsonResponse($jsonCredit, Response::HTTP_OK, [], true);
    }

    #[Route('/api/credit/show', name: 'show_all_credit', methods: ['GET'])]
    public function showAllCredit(CreditRepository $repository): JsonResponse
    {
        $credits = $repository->findAll();
        $jsonCredits = $this->serializer->serialize($credits, 'json', ['groups' => 'Credit']);

        return new JsonResponse($jsonCredits, Response::HTTP_OK, [], true);
    }

    #[Route('/api/credit/edit/{id}', name: 'edit_credit', methods: ['PUT'])]
    public function editCredit(Request $request, Credit $credit): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), Credit::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $credit]);
        $this->em->persist($data);
        $this->em->flush();

        return new Response($this->serializer->serialize($credit, 'json', ['groups' => 'Credit']), Response::HTTP_OK);
    }

    #[Route('/api/credit/delete/{id}', name: 'delete_credit', methods: ['DELETE'])]
    public function deleteCredit(Credit $credit): JsonResponse
    {
        $this->em->remove($credit);
        $this->em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
