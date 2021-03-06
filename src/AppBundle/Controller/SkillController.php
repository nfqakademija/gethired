<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Skill;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class SkillController
 * @package AppBundle\Controller
 * @Route("gebejimai")
 */
class SkillController extends Controller
{

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/naujas",
     *     options = { "expose" = true },
     *     name = "add_skill",
     * )
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();
        if (! $user || ! $user->hasRole('ROLE_USER_SEEKER')) {
            throw new AccessDeniedException();
        }

        $skillTitle = $request->request->get('skill');

        $user = $this->getUser();

        $skill = new Skill();
        $skill->setTitle($skillTitle);
        $skill->setUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($skill);
        $em->flush();

        // Gets last insert ID
        $id = $skill->getId();

        // Sends last insert id to main.js class
        $response = new JsonResponse();
        $response->setData([
            'id' => $id
        ]);

        return $response;
    }

    /**
     * @param Skill $skill
     * @return JsonResponse
     *
     * @Route("/{id}",
     *     options = { "expose" = true },
     *     name = "delete_skill",
     * )
     */
    public function deleteAction(Skill $skill)
    {
        // Security! Check user.
        if ($skill->getUser() !== $this->getUser()) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($skill);
        $em->flush();

        return new JsonResponse();
    }
}
