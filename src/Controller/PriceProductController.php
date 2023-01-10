<?php

namespace App\Controller;

use App\Entity\PriceProduct;
use App\Repository\PriceProductRepository;
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

class PriceProductController extends AbstractController
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

    #[Route('/api/priceProduct/post', 'post_priceProduct', methods: ['POST'])]
    public function postPriceProduct(Request $request): JsonResponse
    {
        $priceProduct = $this->serializer->deserialize($request->getContent(), PriceProduct::class, 'json');
        $errors = $this->validator->validate($priceProduct);

        if ($errors->count() > 0) {
            return new JsonResponse($this->serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }
        $this->em->persist($priceProduct);
        $this->em->flush();
        return new JsonResponse($this->serializer->serialize($priceProduct, 'json', ['groups' => 'PriceProduct']), Response::HTTP_CREATED, [], true);

    }

    #[Route('/api/priceProduct/show/{id}', name: 'show_priceProduct', methods: ['GET'])]
    public function showPriceProduct(PriceProduct $priceProduct): JsonResponse
    {
        $jsonpriceProduct = $this->serializer->serialize($priceProduct, 'json', ['groups' => 'PriceProduct']);
        return new JsonResponse($jsonpriceProduct, Response::HTTP_OK, [], true);
    }

    #[Route('/api/priceProduct/show', name: 'show_all_priceProduct', methods: ['GET'])]
    public function showAllPriceProduct(PriceProductRepository $repository): JsonResponse
    {
        $priceProducts = $repository->findAll();
        $jsonPriceProducts = $this->serializer->serialize($priceProducts, 'json', ['groups' => 'PriceProduct']);

        return new JsonResponse($jsonPriceProducts, Response::HTTP_OK, [], true);
    }

    #[Route('/api/priceProduct/edit/{id}', name: 'edit_priceProduct', methods: ['PUT'])]
    public function editPriceProduct(Request $request, PriceProduct $priceProduct): Response
    {
        $priceProduct = $this->serializer->deserialize($request->getContent(), PriceProduct::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $priceProduct]);
        $this->em->persist($priceProduct);
        $this->em->flush();

        return new Response($this->serializer->serialize($priceProduct, 'json', ['groups' => 'PriceProduct']), Response::HTTP_OK);
    }

    #[Route('/api/priceProduct/delete/{id}', name: 'delete_priceProduct', methods: ['DELETE'])]
    public function deletePriceProduct(PriceProduct $priceProduct): JsonResponse
    {
        $this->em->remove($priceProduct);
        $this->em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
