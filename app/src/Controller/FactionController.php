<?php

namespace App\Controller;

use App\Service\FactionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/faction', name: 'faction_')]
class FactionController
{
    public function __construct(
        private FactionService $factionService
    ){}

    #[Route(null, name: 'read_all', methods: ["GET"])]
    public function readAll(): JsonResponse
    {
        $factions = $this->factionService->getAll();
        return new JsonResponse($this->factionService->transformObjectCollectionToArray($factions));
    }

    #[Route('/{id}', name: 'read', methods: [Request::METHOD_GET])]
    public function read(int $id): JsonResponse
    {
        $faction = $this->factionService->getOne(resourcesId: $id);
        return is_null($faction)
            ? new JsonResponse(
            null,
            Response::HTTP_NOT_FOUND
        )   : new JsonResponse(
            $this->factionService->transformObjectToArray($faction)
        );
    }

    #[Route(null, name: 'create', methods: [Request::METHOD_POST])]
    public function create(Request $request): JsonResponse
    {
        $factionData = json_encode($request->toArray(), true);

        if($factionData === false){
            return new JsonResponse([
                'error' => "The Request Payload has an invalid format"
            ],
            Response::HTTP_BAD_REQUEST
            );
        }

        $faction = $this->factionService->createObjectFromJson($factionData);

        return new JsonResponse(
            $this->factionService->transformObjectToArray($faction),
            Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'update', methods: [Request::METHOD_PUT, Request::METHOD_PATCH])]
    public function update(int $id, Request $request): JsonResponse
    {
        $faction = $this->factionService->getOne(resourcesId: $id);

        if (is_null($faction)) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $factionData = json_encode($request->toArray(), true);

        $faction = $this->factionService->updateObjectFromJson($factionData, $faction);

        return new JsonResponse(
            $this->factionService->transformObjectToArray($faction),
            Response::HTTP_OK
        );
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $faction = $this->factionService->getOne(resourcesId: $id);

        if (is_null($faction)) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        try{
            $this->factionService->remove($faction);
        }
        catch (AccessDeniedException $exception){
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], Response::HTTP_FORBIDDEN);
        }


        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}