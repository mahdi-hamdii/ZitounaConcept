<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201013153117 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD sous_titre1 VARCHAR(255) DEFAULT NULL, ADD sous_titre2 VARCHAR(255) DEFAULT NULL, ADD sous_titre3 VARCHAR(255) DEFAULT NULL, ADD desc1_sous_t1 VARCHAR(255) DEFAULT NULL, ADD desc2_sous_t1 VARCHAR(255) DEFAULT NULL, ADD desc3_sous_t1 VARCHAR(255) DEFAULT NULL, ADD desc1_sous_t2 VARCHAR(255) DEFAULT NULL, ADD desc2_sous_t2 VARCHAR(255) DEFAULT NULL, ADD desc3_sous_t2 VARCHAR(255) DEFAULT NULL, ADD desc1_sous_t3 VARCHAR(255) DEFAULT NULL, ADD desc2_sous_t3 VARCHAR(255) DEFAULT NULL, ADD desc3_sous_t3 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP sous_titre1, DROP sous_titre2, DROP sous_titre3, DROP desc1_sous_t1, DROP desc2_sous_t1, DROP desc3_sous_t1, DROP desc1_sous_t2, DROP desc2_sous_t2, DROP desc3_sous_t2, DROP desc1_sous_t3, DROP desc2_sous_t3, DROP desc3_sous_t3');
    }
}
