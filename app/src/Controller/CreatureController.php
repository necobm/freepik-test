<?php

namespace App\Controller;

use App\Service\CreatureService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/creature', name: 'creature_')]
class CreatureController
{
    public function __construct(
        private CreatureService $creatureService
    ){}

    #[Route(null, name: 'read_all', methods: ["GET"])]
    public function readAll(): JsonResponse
    {
        $creatures = $this->creatureService->getAll();
        return new JsonResponse($this->creatureService->transformObjectCollectionToArray($creatures));
    }

    #[Route('/{id}', name: 'read', methods: ["GET"])]
    public function read(int $id): JsonResponse
    {
        $creature = $this->creatureService->getOne(resourcesId: $id);
        return is_null($creature)
            ? new JsonResponse(null, Response::HTTP_NOT_FOUND)
            : new JsonResponse($this->creatureService->transformObjectToArray($creature));
    }

    #[Route(null, name: 'create', methods: ["POST"])]
    public function create(Request $request): JsonResponse
    {
        $creatureData = json_encode($request->toArray(), true);

        if($creatureData === false){
            return new JsonResponse([
                'error' => "The Request Payload has an invalid format"
            ],
            Response::HTTP_BAD_REQUEST
            );
        }

        $creature = $this->creatureService->createObjectFromJson($creatureData);

        return new JsonResponse(
            $this->creatureService->transformObjectToArray($creature),
            Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'update', methods: ["PUT", "PATCH"])]
    public function update(int $id, Request $request): JsonResponse
    {
        $creature = $this->creatureService->getOne(resourcesId: $id);

        if (is_null($creature)) {
           return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $creatureData = json_encode($request->toArray(), true);

        $creature = $this->creatureService->updateObjectFromJson($creatureData, $creature);

        return new JsonResponse(
            $this->creatureService->transformObjectToArray($creature),
            Response::HTTP_OK
        );
    }

    #[Route('/{id}', name: 'delete', methods: [Request::METHOD_DELETE])]
    public function delete(int $id): JsonResponse
    {
        $creature = $this->creatureService->getOne(resourcesId: $id);

        if (is_null($creature)) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $this->creatureService->remove($creature);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}