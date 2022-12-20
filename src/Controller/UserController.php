<?php

namespace App\Controller;

use App\Entity\User;
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
use Symfony\Component\VarDumper\VarDumper;

class UserController extends AbstractController
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

    #[Route('/api/user/post', 'post_user', methods: ['POST'])]
    public function postUser(Request $request): JsonResponse
    {
        $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $errors = $this->validator->validate($user);

        if ($errors->count() > 0) {
            return new JsonResponse($this->serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }
        $this->em->persist($user);
        $this->em->flush();
        return new JsonResponse($this->serializer->serialize($user, 'json'), Response::HTTP_CREATED, [], true);

    }

    #[Route('/api/user/show/{id}', name: 'show_user', methods: ['GET'])]
    public function showUser(User $user): JsonResponse
    {
        $jsonUser = $this->serializer->serialize($user, 'json');
        return new JsonResponse($jsonUser, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('/api/user/show', name: 'show_all_user', methods: ['GET'])]
    public function showAllUser(UserRepository $repository): JsonResponse
    {
        $users = $repository->findAll();
        $jsonUsers = $this->serializer->serialize($users, 'json');

        return new JsonResponse($jsonUsers, Response::HTTP_OK, [], true);
    }

    #[Route('/api/user/delete/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function deleteUser(User $user): JsonResponse
    {
        $this->em->remove($user);
        $this->em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/user/edit/{id}', name: 'edit_user', methods: ['PUT'])]
    public function editUser(Request $request, User $user): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);
        $this->em->persist($data);
        $this->em->flush();

        return new Response($this->serializer->serialize($user, 'json'), Response::HTTP_OK);
    }

}
