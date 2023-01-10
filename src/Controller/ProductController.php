<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\PriceProductRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    private EntityManagerInterface $em;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private PriceProductRepository $priceProductRepository;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator, PriceProductRepository $priceProductRepository)
    {
        $this->em = $entityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->priceProductRepository = $priceProductRepository;
    }

    #[Route('/api/product/post', 'post_product', methods: ['POST'])]
    public function postProduct(Request $request): JsonResponse
    {
        $product = $this->serializer->deserialize($request->getContent(), Product::class, 'json');
        $errors = $this->validator->validate($product);
        //TODO make error validator to one function in manager
        if ($errors->count() > 0) {
            return new JsonResponse($this->serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }
        $content = $request->toArray();
        $idPriceProduct = $content['price'] ?? -1;
        $product->setPrice($this->priceProductRepository->find($idPriceProduct));
        $this->em->persist($product);
        $this->em->flush();

        return new JsonResponse($this->serializer->serialize($product, 'json', ['groups' => 'Product']), Response::HTTP_CREATED, [], true);

    }

    #[Route('/api/product/show/{id}', name: 'show_product', methods: ['GET'])]
    public function showProduct(Product $product): JsonResponse
    {
        $jsonproduct = $this->serializer->serialize($product, 'json', ['groups' => 'Product']);
        return new JsonResponse($jsonproduct, Response::HTTP_OK, [], true);
    }

    #[Route('/api/product/show', name: 'show_all_product', methods: ['GET'])]
    public function showAllProduct(ProductRepository $repository): JsonResponse
    {
        $products = $repository->findAll();
        $jsonProducts = $this->serializer->serialize($products, 'json', ['groups' => 'Product']);

        return new JsonResponse($jsonProducts, Response::HTTP_OK, [], true);
    }

    #[Route('/api/product/edit/{id}', name: 'edit_product', methods: ['PUT'])]
    public function editProduct(Request $request, Product $product): Response
    {
        $product = $this->serializer->deserialize($request->getContent(), Product::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $product]);

        $content = $request->toArray();
        $idPriceProduct = $content['price'] ?? -1;
        $product->setPrice($this->priceProductRepository->find($idPriceProduct));

        $this->em->persist($product);
        $this->em->flush();

        return new Response($this->serializer->serialize($product, 'json', ['groups' => 'Product']), Response::HTTP_OK);
    }

    #[Route('/api/product/delete/{id}', name: 'delete_product', methods: ['DELETE'])]
    public function deleteProduct(Product $product): JsonResponse
    {
        $this->em->remove($product);
        $this->em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
