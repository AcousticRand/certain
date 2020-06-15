<?php


namespace App\Controller;


use App\Document\Customer;
use App\Document\Personnel;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customer", name="customer_list")
     * @param DocumentManager $dm
     * @return Response
     */
    public function list(DocumentManager $dm): Response
    {
        /** @var Customer[] $customers */
        $customers = $dm->getRepository(Customer::class)->findBy([],['name' => 1]);

        return $this->render(
            'personnel/personnel.list.html.twig',
            [
                'personnel' => $customers
            ]
        );
    }

    /**
     * @Route("/personnel/{code}", name="personnel_show")
     * @param DocumentManager $dm
     * @param string $code
     * @return Response
     */
    public function projectManagerShow(DocumentManager $dm, string $code): Response
    {
        /** @var Personnel $person */
        $person = $dm->getRepository(Personnel::class)->findOneBy(['code' => $code]);
        /** @var Customer[] $customers */
        $customers = $dm->getRepository(Customer::class)->findBy(['pm' => $code], ['company' => 'ASC']);

        return $this->render(
            'customer/customer.html.twig',
            [
                'person' => $person,
                'customers' => count($customers) === 0 ? null : $customers
            ]
        );
    }

}
