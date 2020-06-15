<?php


namespace App\Controller;


use App\Document\Customer;
use App\Document\Url;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UrlController extends AbstractController
{
    /**
     * @Route("/url", name="url_list")
     * @param DocumentManager $dm
     * @return Response
     */
    public function list(DocumentManager $dm): Response
    {
        $out = '';

        $urls = $dm->getRepository(Url::class)->findAll();

        /** @var Url $url */
        foreach($urls as $url) {
            $out .= sprintf("<h2>%s: === %s</h2>", $url->getUrl(), $url->getCustomer());
        }

        return new Response($out);
    }

}