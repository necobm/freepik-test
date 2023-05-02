<?php

namespace App\Service;

use App\Entity\Creature;
use App\Entity\Weapon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class WeaponService extends BaseService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
    ){
        parent::__construct($entityManager, $serializer);
        $this->resourceClass = Weapon::class;
    }

    /**
     * @param Weapon $object
     * @return void
     */
    public function remove(object $object): void
    {
        $creaturesWithThisWeapon = $this->entityManager->getRepository(Creature::class)->findBy([
            'weapon' => $object->getId()
        ]);

        if (!empty($creaturesWithThisWeapon)) {
            foreach ($creaturesWithThisWeapon as $creature) {
                $creature->setWeapon(null);
                $this->entityManager->persist($creature);
            }
        }
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }
}