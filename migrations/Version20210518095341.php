<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518095341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD thumb_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C7034EA5 FOREIGN KEY (thumb_id) REFERENCES thumb (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C7034EA5 ON user (thumb_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C7034EA5');
        $this->addSql('DROP INDEX UNIQ_8D93D649C7034EA5 ON user');
        $this->addSql('ALTER TABLE user DROP thumb_id');
    }
}
