<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class BaseService
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected SerializerInterface $serializer,
        protected string $resourceClass = ""
    ){}

    /**
     * @return array
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
        $object = $this->serializer->deserialize($jsonData, $this->resourceClass, 'json');

        if (get_class($object) !== $this->resourceClass) {
            throw new \Exception("Failed decoding JSON into an object");
        }

        $this->entityManager->persist($object);
        $this->entityManager->flush();
        return $object;
    }

    public function updateObjectFromJson(string $jsonData, object $object): object
    {
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
     * @return array
     */
    public function transformObjectToArray(object $object): array
    {
        $jsonData = $this->serializer->serialize($object, 'json');
        $arrayData = json_decode($jsonData, true);
        return $arrayData !== false ? $arrayData : [];
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
}