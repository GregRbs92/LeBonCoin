<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Category;
use App\Factory\Ad\AbstractAdFactory;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdController extends AbstractController
{
    /**
     * @Rest\Post("/ads", name="create_ad")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
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
        // For each entry in the request's body, try to call the corresponding setter in the Ad instance
        foreach ($body as $key => $value) {
            $methodName = 'set' . ucfirst($key);
            $method = [$ad, $methodName];
            if (is_callable($method)) {
                call_user_func($method, $value);
            }
        }
        // Get the ad's category from the database
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->find($ad->getType());
        $ad->setCategory($category);
        // Persist the new entity
        $em->persist($ad);
        $em->flush();

        $response = $this->get('serializer')->serialize($ad, 'json');
        return new Response($response, 201);
    }
}
