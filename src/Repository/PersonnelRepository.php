<?php


namespace App\Repository;


use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class PersonnelRepository extends DocumentRepository
{

    public function findAllPersonnelInRole(string $role)
    {
        return $this->createQueryBuilder()
            ->field('roles')->equals($role)
            ->sort('lastname', 'ASC')
            ->getQuery()
            ->execute();
    }

}