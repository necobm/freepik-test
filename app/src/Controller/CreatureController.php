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

    #[Route('/', name: 'read_all', methods: ["GET"])]
    public function readAll(): JsonResponse
    {
        $creatures = $this->creatureService->getAllCreatures();
        return new JsonResponse($creatures);
    }

    #[Route('/{id}', name: 'read', methods: ["GET"])]
    public function read(int $id): JsonResponse
    {
        $creature = $this->creatureService->getCreature(creatureId: $id);
        return is_null($creature) ? new JsonResponse(null, Response::HTTP_NOT_FOUND) : new JsonResponse($creature);
    }

    #[Route('/', name: 'create', methods: ["POST"])]
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

        $creature = $this->creatureService->createCreatureFromJson($creatureData);

        return new JsonResponse(
            $this->creatureService->transformCreatureToArray($creature),
            Response::HTTP_CREATED
        );
    }
}