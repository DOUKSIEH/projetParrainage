<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190904130205 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amount_donate (id INT AUTO_INCREMENT NOT NULL, id_donneur_id INT NOT NULL, somme INT NOT NULL, donnation_date DATETIME DEFAULT NULL, frequency VARCHAR(255) NOT NULL, INDEX IDX_BCE6FD4D3203028C (id_donneur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amount_donate ADD CONSTRAINT FK_BCE6FD4D3203028C FOREIGN KEY (id_donneur_id) REFERENCES donneur (id)');
        $this->addSql('ALTER TABLE user ADD token VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE amount_donate');
        $this->addSql('ALTER TABLE user DROP token');
    }
}
