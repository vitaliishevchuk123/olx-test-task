<?php
namespace App\Repositories;

use App\Entities\User;
use Doctrine\DBAL\Connection;

class UserRepository
{
    public function findByEmail(string $email, Connection $connection): ?User
    {
        $queryBuilder = $connection->createQueryBuilder();

        $result = $queryBuilder->select('*')
            ->from('users')
            ->where('email = :email')
            ->setParameter('email', $email)
            ->executeQuery();

        $user = $result->fetchAssociative();

        if (! $user) {
            return null;
        }

        return User::create(
            email: $user['email'],
            createdAt: new \DateTimeImmutable($user['created_at']),
            name: $user['name'],
            id: $user['id'],
        );
    }
}