<?php

namespace App\Parsers;

use Doctrine\DBAL\Connection;
use Goutte\Client as Goutte;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther\Client;

class AbstractParser
{
    protected $client = null;
    protected Connection $connection;
    protected Logger $logger;
    protected bool $waitJs = false;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->logger = new Logger('base');
        $this->logger->pushHandler(new StreamHandler('storage/logs/monolog.log', Level::Info));
        try {
            if ($this->waitJs) {
                $this->client = Client::createChromeClient();
            } else $this->client = new Goutte();
        } catch (\Throwable $e) {
            $this->logger->error("{$e->getMessage()}. File: {$e->getFile()}. Line: {$e->getLine()}");
        }
    }

    protected function request(string $method, string $url): Crawler
    {
        if (!$this->waitJs) {
            return $this->client->request($method, $url);
        }

        $this->client->request($method, $url);
        return $this->client->getCrawler();
    }
}
