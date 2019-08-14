<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190813134344 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE truck (id INT AUTO_INCREMENT NOT NULL, registration VARCHAR(255) DEFAULT NULL, vendor VARCHAR(255) DEFAULT NULL, model VARCHAR(255) DEFAULT NULL, weight DOUBLE PRECISION NOT NULL, length DOUBLE PRECISION NOT NULL, height DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, route_id INT DEFAULT NULL, client_name VARCHAR(255) NOT NULL, client_address VARCHAR(255) NOT NULL, delivery_time DATETIME NOT NULL, latitude DOUBLE PRECISION NOT NULL, longtitude DOUBLE PRECISION NOT NULL, done TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3781EC1034ECB4E6 (route_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, truck_id INT DEFAULT NULL, route_title VARCHAR(255) NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2C42079C6957CCE (truck_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

// Do not need for this project
//        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC1034ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
//        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079C6957CCE FOREIGN KEY (truck_id) REFERENCES truck (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

// Do not need for this project
//        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079C6957CCE');
//        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC1034ECB4E6');
        $this->addSql('DROP TABLE truck');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE route');
    }
}
