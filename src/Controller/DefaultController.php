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

}
