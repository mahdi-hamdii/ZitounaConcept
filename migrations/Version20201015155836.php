<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201015155836 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sous_article (id INT AUTO_INCREMENT NOT NULL, catalog_article_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, images LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', promotion DOUBLE PRECISION DEFAULT NULL, tab_dimension LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', sous_titre1 VARCHAR(255) DEFAULT NULL, sous_titre2 VARCHAR(255) DEFAULT NULL, sous_titre3 VARCHAR(255) DEFAULT NULL, desc1_sous_t1 VARCHAR(255) DEFAULT NULL, desc2_sous_t1 VARCHAR(255) DEFAULT NULL, desc3_sous_t1 VARCHAR(255) DEFAULT NULL, desc1_sous_t2 VARCHAR(255) DEFAULT NULL, desc2_sous_t2 VARCHAR(255) DEFAULT NULL, desc3_sous_t2 VARCHAR(255) DEFAULT NULL, desc1_sous_t3 VARCHAR(255) DEFAULT NULL, desc2_sous_t3 VARCHAR(255) DEFAULT NULL, desc3_sous_t3 VARCHAR(255) DEFAULT NULL, INDEX IDX_2133762BC7BE7447 (catalog_article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sous_article ADD CONSTRAINT FK_2133762BC7BE7447 FOREIGN KEY (catalog_article_id) REFERENCES catalog_article (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sous_article');
    }
}
