<?php

namespace App\Utils;

use App\Entity\Ad;
use App\Entity\Category;
use App\Entity\User;
use App\Factory\Ad\AbstractAdFactory;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AdService
{
    private $em;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Create a new Ad instance and persist it in database
     *
     * @param array $body
     * @return Ad
     * @throws NotNullConstraintViolationException
     */
    public function create(array &$body)
    {
        // Set category at 'other' by default
        $adCategory = 'other';
        // Get the ad's category and delete category from request's body
        if (isset($body['category'])) {
            $adCategory = $body['category'];
            unset($body['category']);
        }
        // Get the appropriate entity thanks to factories
        $factory = AbstractAdFactory::getFactory($adCategory);
        /** @var Ad $ad */
        $ad = $factory::createEntity();
        // Set the fields of the ad
        $ad = $this->setFields($body, $ad);
        // Set ad's owner
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();
        $ad->setOwner($user);
        // Get the ad's category from the database
        $category = $this->em->getRepository(Category::class)->find($ad->getType());
        $ad->setCategory($category);
        // Persist the new entity
        $this->em->persist($ad);
        $this->em->flush();

        return $ad;
    }

    /**
     * Call the different setters of the ad corresponding to the keys in the request body
     *
     * @param array $body
     * @param Ad $ad
     * @return Ad
     */
    public function setFields(array &$body, Ad $ad)
    {
        // For each entry in the request's body, try to call the corresponding setter in the Ad instance
        foreach ($body as $key => $value) {
            $methodName = 'set' . ucfirst($key);
            $method = [$ad, $methodName];
            if (is_callable($method)) {
                call_user_func($method, $value);
            }
        }

        return $ad;
    }
}
