<?php
namespace App\Repositories;

use App\Entities\Announcement;
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
}