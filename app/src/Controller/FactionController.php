<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/faction', name: 'faction_')]
class FactionController
{
    #[Route('/', name: 'read_all', methods: ["GET"])]
    public function readAll(): JsonResponse
    {
        return new JsonResponse([
            "message" => "Hola Mundo"
        ]);
    }

    #[Route('/{id}', name: 'read', methods: ["GET"])]
    public function read(int $id): JsonResponse
    {
        return new JsonResponse([
            "message" => "Hola Mundo with id $id"
        ]);
    }
}