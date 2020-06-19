<?php


namespace App\Controller;


use App\Document\Customer;
use App\Document\Personnel;
use App\Document\Url;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonnelController extends AbstractController
{
    /**
     * @Route("/personnel", name="personnel_list")
     * @param DocumentManager $dm
     * @return Response
     */
    public function list(DocumentManager $dm): Response
    {
        /** @var Personnel[] $personnel */
        $personnel = $dm->getRepository(Personnel::class)->findBy([],['role' => 1, 'lastname' => 1, 'firstname' => 1]);

        return $this->render(
            'personnel/personnel.list.html.twig',
            [
                'personnel' => $personnel
            ]
        );
    }

    /**
     * @Route("/personnel/{code}", name="personnel_show")
     * @param DocumentManager $dm
     * @param string $code
     * @return Response
     */
    public function show(DocumentManager $dm, string $code): Response
    {
        /** @var Personnel $person */
        $person = $dm->getRepository(Personnel::class)->findOneBy(['code' => $code]);
        /** @var Customer[] $customers */
        $customers = $dm->getRepository(Customer::class)->findBy(['pm' => $code], ['company' => 'ASC']);

        /** @var Url[] $urlResults */
        $urlResults = $dm->getRepository(Url::class)->findAll();
        $urls = [];
        foreach($urlResults as $url) {
            $urls[$url->getCustomer()][] = $url;
        }

        return $this->render(
            'customer/customer.html.twig',
            [
                'person' => $person,
                'customers' => count($customers) === 0 ? null : $customers,
                'urls' => $urls
            ]
        );
    }

}
