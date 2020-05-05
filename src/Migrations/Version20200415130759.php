<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200415130759 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article ADD cahier_id INT DEFAULT NULL, DROP cahier');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E661E0D9F2 FOREIGN KEY (cahier_id) REFERENCES cahier (id)');
        $this->addSql('CREATE INDEX IDX_23A0E661E0D9F2 ON article (cahier_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E661E0D9F2');
        $this->addSql('DROP INDEX IDX_23A0E661E0D9F2 ON article');
        $this->addSql('ALTER TABLE article ADD cahier VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP cahier_id');
    }
}
