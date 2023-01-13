<?php

namespace App\Controller;

use App\Entity\Reception;
use App\Repository\CenterRepository;
use App\Repository\FarmerRepository;
use App\Repository\ProductRepository;
use App\Repository\ReceptionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReceptionController extends AbstractController
{
    private EntityManagerInterface $em;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private UserRepository $userRepository;
    private FarmerRepository $farmerRepository;
    private CenterRepository $centerRepository;
    private ProductRepository $productRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        UserRepository $userRepository,
        FarmerRepository $farmerRepository,
        CenterRepository $centerRepository,
        ProductRepository $productRepository
    )
    {
        $this->em = $entityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->userRepository = $userRepository;
        $this->farmerRepository = $farmerRepository;
        $this->centerRepository = $centerRepository;
        $this->productRepository = $productRepository;
    }

    #[Route('/api/reception/post', 'post_reception', methods: ['POST'])]
    public function postReception(Request $request): JsonResponse
    {
        $reception = $this->serializer->deserialize($request->getContent(), Reception::class, 'json');
        $errors = $this->validator->validate($reception);
        //TODO make error validator to one function in manager
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }
        $content = $request->toArray();
        $idUserReception = $content['user_id'] ?? -1;
        $idFarmerReception = $content['farmer_id'] ?? -1;
        $idCenterReception = $content['center_id'] ?? -1;
        $idProductReception = $content['product_id'] ?? -1;
        $reception->setUserId($this->userRepository->find($idUserReception));
        $reception->setFarmerId($this->farmerRepository->find($idFarmerReception));
        $reception->setCenterId($this->centerRepository->find($idCenterReception));
        $reception->setProductId($this->productRepository->find($idProductReception));

        $this->em->persist($reception);
        $this->em->flush();

        return new JsonResponse($this->serializer->serialize($reception, 'json', ['groups' => 'Reception']), Response::HTTP_CREATED, [], true);

    }

    #[Route('/api/reception/show/{id}', name: 'show_reception', methods: ['GET'])]
    public function showReception(Reception $reception): JsonResponse
    {
        $jsonreception = $this->serializer->serialize($reception, 'json', ['groups' => 'Reception']);
        return new JsonResponse($jsonreception, Response::HTTP_OK, [], true);
    }

    #[Route('/api/reception/show', name: 'show_all_reception', methods: ['GET'])]
    public function showAllReception(ReceptionRepository $repository): JsonResponse
    {
        $receptions = $repository->findAll();
        $jsonReceptions = $this->serializer->serialize($receptions, 'json', ['groups' => 'Reception']);

        return new JsonResponse($jsonReceptions, Response::HTTP_OK, [], true);
    }

    #[Route('/api/reception/edit/{id}', name: 'edit_reception', methods: ['PUT'])]
    public function editReception(Request $request, Reception $reception): Response
    {
        $reception = $this->serializer->deserialize($request->getContent(), Reception::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $reception]);

        $content = $request->toArray();
        $idUserReception = $content['user_id'] ?? -1;
        $idFarmerReception = $content['farmer_id'] ?? -1;
        $idCenterReception = $content['center_id'] ?? -1;
        $idProductReception = $content['product_id'] ?? -1;
        $reception->setUserId($this->userRepository->find($idUserReception));
        $reception->setFarmerId($this->farmerRepository->find($idFarmerReception));
        $reception->setCenterId($this->centerRepository->find($idCenterReception));
        $reception->setProductId($this->productRepository->find($idProductReception));

        $this->em->persist($reception);
        $this->em->flush();

        return new Response($this->serializer->serialize($reception, 'json', ['groups' => 'Reception']), Response::HTTP_OK);
    }

    #[Route('/api/reception/delete/{id}', name: 'delete_reception', methods: ['DELETE'])]
    public function deleteReception(Reception $reception): JsonResponse
    {
        $this->em->remove($reception);
        $this->em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
