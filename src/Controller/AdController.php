<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Category;
use App\Factory\Ad\AbstractAdFactory;
use App\Utils\AdService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AdController extends AbstractController
{
    /**
     * @Rest\Post("/ads", name="create_ad")
     *
     * @param Request $request
     * @param AdService $adService
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function create(Request $request, AdService $adService, EntityManagerInterface $em)
    {
        $body = $request->request->all();
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
        $ad = $adService->setFields($body, $ad);
        // Set ad's owner
        $ad->setOwner($this->getUser());
        // Get the ad's category from the database
        $category = $em->getRepository(Category::class)->find($ad->getType());
        $ad->setCategory($category);
        // Persist the new entity
        $em->persist($ad);
        $em->flush();

        $response = $this->get('serializer')->serialize($ad, 'json', ['groups' => ['full_ad']]);
        return new Response($response, 201);
    }

    /**
     * @Rest\Get("/ads", name="get_ads")
     *
     * @return Response
     */
    public function getAll()
    {
        $ads = $this->getDoctrine()->getManager()->getRepository(Ad::class)->findAll();
        $response = $this->get('serializer')->serialize($ads, 'json', ['groups' => ['full_ad']]);
        return new Response($response);
    }

    /**
     * @Rest\Get("/ads/{id}", name="get_ad")
     *
     * @param Ad $ad
     * @return Response
     */
    public function getById(Ad $ad)
    {
        $response = $this->get('serializer')->serialize($ad, 'json', ['groups' => ['full_ad']]);
        return new Response($response);
    }

    /**
     * @Rest\Put("/ads/{id}", name="update_ad")
     *
     * @param Request $request
     * @param Ad $ad
     * @param EntityManagerInterface $em
     * @param AdService $adService
     * @return Response|HttpException
     */
    public function update(Request $request, Ad $ad, EntityManagerInterface $em, AdService $adService)
    {
        $body = $request->request->all();
        // Prevent ad's category from being updated
        if (isset($body['category'])) {
            unset($body['category']);
        }
        // Prevent the ad from being updated by someone else than its owner
        if ($this->getUser() !== $ad->getOwner()) {
            throw new HttpException(403, 'This ad does not belong to you');
        }
        // Set the fields of the ad
        $ad = $adService->setFields($body, $ad);
        // Save the update
        $em->flush();
        // Send the response
        $response = $this->get('serializer')->serialize($ad, 'json', ['groups' => ['full_ad']]);
        return new Response($response, 201);
    }

    /**
     * @Rest\Delete("/ads/{id}", name="delete_ad")
     *
     * @param Ad $ad
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function delete(Ad $ad, EntityManagerInterface $em)
    {
        if ($this->getUser() !== $ad->getOwner()) {
            throw new HttpException(403, 'This ad does not belong to you');
        }

        $em->remove($ad);
        $em->flush();

        return new Response('', 204);
    }
}
