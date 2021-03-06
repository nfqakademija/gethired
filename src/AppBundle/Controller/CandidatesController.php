<?php

namespace AppBundle\Controller;

use AppBundle\Entity\JobAd;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CandidatesController
 *
 * @Route("skelbimas/kandidatavo")
 */
class CandidatesController extends Controller
{

    /**
     * Lists of candidates to JobAd (jobApply entities).
     * @param JobAd $jobAd
     *
     * @return Response
     * @Route("/{id}", name="jobapply_index")
     * @Method("GET")
     *
     */
    public function indexAction(JobAd $jobAd)
    {
        $this->denyAccessUnlessGranted('edit', $jobAd);

        $em = $this->getDoctrine()->getManager();

        // TODO: make pagination
        $jobApplies = $em->getRepository('AppBundle:JobApply')->findBy(
            ['jobAd' => $jobAd]
        );

        return $this->render('jobapply/index.html.twig', [
            'jobAd' => $jobAd,
            'jobApplies' => $jobApplies,
        ]);
    }
}
