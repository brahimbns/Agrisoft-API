<?php

namespace App\Controller;

use App\Entity\Center;
use App\Repository\CenterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CenterController extends AbstractController
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

    #[Route('/api/center/post', 'post_center', methods: ['POST'])]
    public function postCenter(Request $request): JsonResponse
    {
        $center = $this->serializer->deserialize($request->getContent(), Center::class, 'json');
        $errors = $this->validator->validate($center);

        if ($errors->count() > 0) {
            return new JsonResponse($this->serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }
        $this->em->persist($center);
        $this->em->flush();
        return new JsonResponse($this->serializer->serialize($center, 'json', ['groups' => 'Center']), Response::HTTP_CREATED, [], true);

    }

    #[Route('/api/center/show/{id}', name: 'show_center', methods: ['GET'])]
    public function showCenter(Center $center): JsonResponse
    {
        $jsonCenter = $this->serializer->serialize($center, 'json', ['groups' => 'Center']);
        return new JsonResponse($jsonCenter, Response::HTTP_OK, [], true);
    }

    #[Route('/api/center/show', name: 'show_all_center', methods: ['GET'])]
    public function showAllCenter(CenterRepository $repository): JsonResponse
    {
        $centers = $repository->findAll();
        $jsonCenters = $this->serializer->serialize($centers, 'json', ['groups' => 'Center']);

        return new JsonResponse($jsonCenters, Response::HTTP_OK, [], true);
    }

    #[Route('/api/center/edit/{id}', name: 'edit_center', methods: ['PUT'])]
    public function editCenter(Request $request, Center $center): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), Center::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $center]);
        $this->em->persist($data);
        $this->em->flush();

        return new Response($this->serializer->serialize($center, 'json'), Response::HTTP_OK);
    }

    #[Route('/api/center/delete/{id}', name: 'delete_center', methods: ['DELETE'])]
    public function deleteCenter(Center $center): JsonResponse
    {
        $this->em->remove($center);
        $this->em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}
