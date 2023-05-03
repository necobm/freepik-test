<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class BaseService
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected SerializerInterface $serializer,
        protected Security $security,
        protected string $resourceClass = ""
    ){}

    /**
     * @return object[]
     */
    public function getAll(): array
    {
        return $this->entityManager->getRepository($this->resourceClass)->findAll();
    }

    /**
     * @param int $resourcesId
     * @return object|null
     */
    public function getOne(int $resourcesId): ?object
    {
        return $this->entityManager->find($this->resourceClass, $resourcesId);
    }

    /**
     * @param string $jsonData
     * @return object
     * @throws \Exception
     */
    public function createObjectFromJson(string $jsonData): object
    {
        if (json_decode($jsonData) === null || json_decode($jsonData) === false) {
            throw new \Exception("Invalid JSON format");
        }
        $object = $this->serializer->deserialize($jsonData, $this->resourceClass, 'json');

        if (get_class($object) !== $this->resourceClass) {
            throw new \Exception("Failed decoding JSON into an object");
        }

        $this->entityManager->persist($object);
        $this->entityManager->flush();
        return $object;
    }

    /**
     * @param string $jsonData
     * @param object $object
     * @return object
     * @throws \Exception
     */
    public function updateObjectFromJson(string $jsonData, object $object): object
    {
        if (json_decode($jsonData) === null || json_decode($jsonData) === false) {
            throw new \Exception("Invalid JSON format");
        }
        $this->serializer->deserialize($jsonData, $this->resourceClass, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $object]);

        if (get_class($object) !== $this->resourceClass) {
            throw new \Exception("Failed decoding JSON into an object");
        }

        $this->entityManager->persist($object);
        $this->entityManager->flush();
        return $object;
    }

    /**
     * @param object $object
     * @return void
     */
    public function remove(object $object): void
    {
        if( !$this->checkAccessRights(Request::METHOD_DELETE) ){
            throw new AccessDeniedException("Insufficient rights to perform this operation");
        }
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }

    /**
     * @param object $object
     * @return array
     */
    public function transformObjectToArray(object $object): array
    {
        $jsonData = $this->serializer->serialize($object, 'json');
        $arrayData = json_decode($jsonData, true);
        return ($arrayData !== false && $arrayData !== null) ? $arrayData : [];
    }

    /**
     * @param object[] $objectCollection
     * @return array
     */
    public function transformObjectCollectionToArray(array $objectCollection): array
    {
        $dataArray = [];
        foreach ($objectCollection as $object) {
            $dataArray[] = $this->transformObjectToArray($object);
        }

        return $dataArray;
    }

    /**
     * @param string $operation
     * @return bool
     */
    protected function checkAccessRights(string $operation): bool
    {
        return match ($operation) {
            Request::METHOD_DELETE => $this->security->isGranted('ROLE_ADMIN'),
            default => true
        };
    }
}