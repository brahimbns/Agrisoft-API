<?php

namespace App\Controller;

use App\Entity\Farmer;
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

class FramerController extends AbstractController
{
    private EntityManagerInterface $em;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->em = $entityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    #[Route('/api/farmer/post', 'post_farmer', methods: ['POST'])]
    public function postFarmer(Request $request): JsonResponse
    {
        $farmer = $this->serializer->deserialize($request->getContent(), Farmer::class, 'json');
        $errors = $this->validator->validate($farmer);

        if ($errors->count() > 0) {
            return new JsonResponse($this->serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }
        $this->em->persist($farmer);
        $this->em->flush();
        return new JsonResponse($this->serializer->serialize($farmer, 'json', ['groups' => 'Farmer']), Response::HTTP_CREATED, [], true);

    }

    #[Route('/api/farmer/show/{id}', name: 'show_farmer', methods: ['GET'])]
    public function showFarmer(Farmer $farmer): JsonResponse
    {
        $jsonFarmer = $this->serializer->serialize($farmer, 'json', ['groups' => 'Farmer']);
        return new JsonResponse($jsonFarmer, Response::HTTP_OK, [], true);
    }

    #[Route('/api/farmer/show', name: 'show_all_farmer', methods: ['GET'])]
    public function showAllFarmer(FarmerRepository $repository): JsonResponse
    {
        $farmers = $repository->findAll();
        $jsonFarmers = $this->serializer->serialize($farmers, 'json', ['groups' => 'Farmer']);

        return new JsonResponse($jsonFarmers, Response::HTTP_OK, [], true);
    }

    #[Route('/api/farmer/edit/{id}', name: 'edit_farmer', methods: ['PUT'])]
    public function editFarmer(Request $request, Farmer $farmer): Response
    {
        $farmer = $this->serializer->deserialize($request->getContent(), Farmer::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $farmer]);
        $this->em->persist($farmer);
        $this->em->flush();

        return new Response($this->serializer->serialize($farmer, 'json'), Response::HTTP_OK);
    }

    #[Route('/api/farmer/delete/{id}', name: 'delete_farmer', methods: ['DELETE'])]
    public function deleteFarmer(Farmer $farmer): JsonResponse
    {
        $this->em->remove($farmer);
        $this->em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
