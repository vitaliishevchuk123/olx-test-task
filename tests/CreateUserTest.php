<?php

use App\Actions\CreateUser;
use App\Dbal\ConnectionFactory;
use App\Entities\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

class CreateUserTest extends TestCase
{
    protected Connection $connection;

    public function setUp(): void
    {
        $dotenv = new Dotenv();
        $dotenv->load(dirname(__DIR__) . '/.env');

        // Refresh DB
        $conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sqlDrop = "DROP DATABASE IF EXISTS {$_ENV['DB_TEST_DATABASE']}";
        if ($conn->query($sqlDrop) === TRUE) {
            echo "Database dropped successfully\n";
        } else {
            echo "Error dropping database: " . $conn->error . "\n";
        }

        $sql = "CREATE DATABASE IF NOT EXISTS {$_ENV['DB_TEST_DATABASE']}";
        if ($conn->query($sql) === TRUE) {
            echo "Database created successfully" . "\n";
        } else {
            echo "Error creating database: " . $conn->error . "\n";
        }
        $conn->close();

        // Створення підключення до БД
        $connectionParams = [
            'dbname' => $_ENV['DB_TEST_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT'],
            'driver' => $_ENV['DB_DRIVER'],
        ];
        $this->connection = (new ConnectionFactory($connectionParams))->create();

        // Виконання міграцій
        $schema = new Schema();
        $migrationsPath = "database/migrations";
        $migrationFiles = scandir($migrationsPath);
        $filteredFiles = array_filter($migrationFiles, function ($fileName) {
            return !in_array($fileName, ['.', '..']);
        });
        $migrationsToApply = array_values($filteredFiles);
        foreach ($migrationsToApply as $migration) {
            $migrationInstance = require $migrationsPath . "/$migration";
            $migrationInstance->up($schema);
        }
        // Збирання запитів в масив
        $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());
        foreach ($sqlArray as $sql) {
            //Виконати SQL-запити
            $this->connection->executeQuery($sql);
        }
        echo "Migrations fresh successfully" . "\n";

        parent::setUp();
    }

    public function testHandle()
    {
        $user = User::fill(
            'Jon@gmail.com',
            new \DateTimeImmutable(),
            'Jon',
        );

        $createUser = new CreateUser();
        $createdUser = $createUser->handle($user, $this->connection);

        $this->assertInstanceOf(User::class, $createdUser);
        $this->assertEquals(1, $createdUser->getId());
    }

}
