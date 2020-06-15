<?php


namespace App\Controller;


use App\Document\Customer;
use App\Document\Personnel;
use App\Document\Role;
use App\Document\Url;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
{
    /**
     * @Route("/role", name="role_list")
     * @param DocumentManager $dm
     * @return Response
     */
    public function index(DocumentManager $dm): Response
    {
        $roles = $dm->getRepository(Role::class)->findAll();

        return $this->render(
            'role/role.list.html.twig',
            [
                'roles' => $roles
            ]
        );
    }

    /**
     * @Route("/role/{roleKey}", name="role_show")
     * @param DocumentManager $dm
     * @param string $roleKey
     * @return Response
     * @throws NoResultException
     */
    public function roleListMembers(DocumentManager $dm, string $roleKey): Response
    {
        /** @var Role $roleResult */
        $roleResult = $dm->getRepository(Role::class)->findBy(["code" => $roleKey],["lastname" => 1, "firstname" => 1]);
        $role = null;
        if (count($roleResult) === 1) {
            $role = $roleResult[0];
        }
        /** @var Personnel[] $personnel */
        $personnel = $dm->getRepository(Personnel::class)->findAllPersonnelInRole($roleKey);

        return $this->render(
            'role/role.show.html.twig',
            [
                'role' => $role,
                'personnel' => $personnel
            ]
        );
    }


}