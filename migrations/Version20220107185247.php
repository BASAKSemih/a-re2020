<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220107185247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP INDEX UNIQ_97A0ADA3CD9CE09F, ADD INDEX IDX_97A0ADA3CD9CE09F (old_thermician_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP INDEX IDX_97A0ADA3CD9CE09F, ADD UNIQUE INDEX UNIQ_97A0ADA3CD9CE09F (old_thermician_id)');
    }
}
