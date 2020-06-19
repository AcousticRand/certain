<?php


namespace App\Controller;


use App\Document\Url;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UrlController
 * @package App\Controller
 */
class UrlController extends AbstractController
{
    /**
     * @Route("/url", name="url_list")
     * @param DocumentManager $dm
     * @return Response
     * @throws MongoDBException
     */
    public function list(DocumentManager $dm): Response
    {
        $urls = $this->testUrls($dm);

        return $this->render(
            'url/url.list.html.twig',
            [
                'urls' => $urls
            ]
        );
    }

    /**
     * @param DocumentManager $dm
     * @return Url[]|array|object[]
     * @throws MongoDBException
     * @throws Exception
     */
    private function testUrls(DocumentManager $dm): array
    {
        $urls = $dm->getRepository(Url::class)->findBy([], ['customer' => 'ASC', 'url' => 'ASC']);

        /** @var Url $url */
        foreach ($urls as $url) {
            if (!$url->isExpireDateCached()) {
                $dm->persist($url);
                $dm->flush();
            }
        }

        return $urls;
    }

}