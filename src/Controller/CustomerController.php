<?php


namespace App\Controller;


use App\Document\Customer;
use App\Document\Personnel;
use App\Document\Url;
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
            'customer/customer.list.html.twig',
            [
                'customers' => $customers
            ]
        );
    }

    /**
     * @Route("/customer/platform/{platform}", name="customer_in_platform_list")
     * @param DocumentManager $dm
     * @param string $platform
     * @return Response
     */
    public function platformList(DocumentManager $dm, string $platform): Response
    {
        /** @var Customer[] $customers */
        $customers = $dm->getRepository(Customer::class)->findBy(['platform' => $platform],['name' => 1]);

        return $this->render(
            'customer/customer.list.html.twig',
            [
                'customers' => $customers,
                'platform' => $platform
            ]
        );
    }

    /**
     * @Route("/customer/{customerCode}", name="customer_show")
     * @param DocumentManager $dm
     * @param string $customerCode
     * @return Response
     */
    public function show(DocumentManager $dm, string $customerCode): Response
    {
        /** @var Customer[] $customerResult */
        $customerResult = $dm->getRepository(Customer::class)->findBy(["code" => $customerCode]);

        /** @var Customer|null $customer */
        $customer = null;
        /** @var Url[]|null $urls */
        $urls = null;
        /** @var Personnel $pm */
        $pm = null;
        if (count($customerResult) === 1) {
            $customer = $customerResult[0];
            $urlResult = $dm->getRepository(Url::class)->findBy(["customer" => $customer->getCode()], ["url" => "ASC"]);
            if (count($urlResult) > 0) {
                $urls = $urlResult;
            }
            $pm = $dm->getRepository(Personnel::class)->findOneBy(['code' => $customer->getPm()]);
        }

        return $this->render(
            'customer/customer.show.html.twig',
            [
                'customer' => $customer,
                'urls' => $urls,
                'pm' => $pm
            ]
        );
    }
}
