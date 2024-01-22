<?php
namespace App\Repositories;

use App\Entities\Announcement;
use App\Entities\User;
use App\Helpers\Collection;
use Doctrine\DBAL\Connection;

class AnnouncementRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function findByUrl(string $url): ?Announcement
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $result = $queryBuilder->select('*')
            ->from('announcements')
            ->where('url = :url')
            ->setParameter('url', $url)
            ->executeQuery();

        $announcement = $result->fetchAssociative();

        if (!$announcement) {
            return null;
        }

        return Announcement::fill(
            url: $announcement['url'],
            createdAt: new \DateTimeImmutable($announcement['created_at']),
            price: $announcement['price'],
            id: $announcement['id'],
        );
    }

    public function all(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $result = $queryBuilder->select('*')
            ->from('announcements')
            ->executeQuery();

        $announcements = $result->fetchAllAssociative();

        $announcementEntities = [];
        foreach ($announcements as $announcement) {
            $announcementEntities[] = Announcement::fill(
                url: $announcement['url'],
                createdAt: new \DateTimeImmutable($announcement['created_at']),
                price: $announcement['price'],
                id: $announcement['id'],
            );
        }

        return $announcementEntities;
    }

    public function getUsers(Announcement $announcement): Collection
    {
        $users = new Collection();

        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->select('u.*')
            ->from('announcement_user', 'au')
            ->join('au', 'users', 'u', 'au.user_id = u.id')
            ->where('au.announcement_id = :announcement_id')
            ->setParameter('announcement_id', $announcement->getId());

        $result = $queryBuilder->executeQuery();

        // Assuming you have a method to hydrate the result into Announcement objects
        while ($data = $result->fetchAssociative()) {
            $user = User::fill(
                email: $data['email'],
                createdAt: new \DateTimeImmutable($data['created_at']),
                name: $data['name'],
                id: $data['id']
            );
            $users->add($user);
        }

        return $users;
    }
}