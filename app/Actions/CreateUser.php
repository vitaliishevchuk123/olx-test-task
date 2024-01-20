<?php

namespace App\Actions;

use App\Entities\User;
use Doctrine\DBAL\Connection;

class CreateUser
{
    public function handle(User $user, Connection $connection)
    {
        $queryBuilder = $connection->createQueryBuilder();

        $queryBuilder
            ->insert('users')
            ->values([
                'name' => ':name',
                'email' => ':email',
                'created_at' => ':created_at',
            ])
            ->setParameters([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
            ])->executeQuery();

        $user->setId($connection->lastInsertId());

        return $user;
    }
}