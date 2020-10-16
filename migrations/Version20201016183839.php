<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201016183839 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sous_service ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sous_service ADD CONSTRAINT FK_C294E29FED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('CREATE INDEX IDX_C294E29FED5CA9E6 ON sous_service (service_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sous_service DROP FOREIGN KEY FK_C294E29FED5CA9E6');
        $this->addSql('DROP INDEX IDX_C294E29FED5CA9E6 ON sous_service');
        $this->addSql('ALTER TABLE sous_service DROP service_id');
    }
}
