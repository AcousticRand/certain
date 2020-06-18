<?php


namespace App\Controller;


use App\Document\Item;
use App\Document\Order;
use App\Document\Url;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param DocumentManager $dm
     * @return Response
     */
    public function index(DocumentManager $dm): Response
    {
        return $this->render(
            'base.html.twig'
        );
    }

    /**
     * @Route("/test/show", name="testshow")
     * @param DocumentManager $dm
     * @return Response
     * @throws MongoDBException
     */
    public function testShow(DocumentManager $dm): Response
    {

        $orders = $dm->getRepository(Order::class)->findAll();

        return $this->render(
            'order/order.list.html.twig',
            [ 'orders' => $orders ]
        );
    }

    /**
     * @Route("/test/fill", name="testfiller")
     * @param DocumentManager $dm
     * @return Response
     * @throws MongoDBException
     */
    private function testFiller(DocumentManager $dm): Response
    {
        $itemCollection = $dm->getDocumentCollection(Item::class);
        $itemCollection->deleteMany([]);
        $orderCollection = $dm->getDocumentCollection(Order::class);
        $orderCollection->deleteMany([]);

        $hat = (new Item())
            ->setName('Hat')
            ->setQty(20)
            ->setPrice(12.99);
        $scarf = (new Item())
            ->setName('Scarf')
            ->setQty(15)
            ->setPrice(11.99);
        $gloves = (new Item())
            ->setName('Gloves')
            ->setQty(25)
            ->setPrice(13.99);

        $items1 = [
            $hat,
            $scarf
        ];

        $items2 = [
            $hat,
            $gloves
        ];

        $dm->persist($hat);
        $dm->persist($scarf);
        $dm->persist($gloves);

        $dm->flush();

        $order1 = (new Order())
            ->setCode('a')
            ->setItems($items1);

        $order2 = (new Order())
            ->setCode('b')
            ->setItems($items2);

        $dm->persist($order1);
        $dm->persist($order2);

        $dm->flush();

    }

    /**
     * Get all SSL Certificate expire dates if not checked in last hour
     *
     * Get the collection of URLs, and for each URL, we get the SSL Certificate, x509 parse out the expire date
     * and then we update dateLastChecked, and then persist the object!
     *
     * @Route("/test/sslfetch", name="test_sslfetch")
     * @param DocumentManager $dm
     *
     * @return Response
     * @throws Exception
     */
    public function sslFetcher(DocumentManager $dm): Response
    {
        $urlCollection = $dm->getRepository(Url::class)->findAll();

        /** @var Url $url */
        foreach ($urlCollection as $url) {
            $a = $url->getExpireDate();
            $dm->persist($url);
            $dm->flush();
        }

        return new Response("Certificates checked and recorded");

    }

}
