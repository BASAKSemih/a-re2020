<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103143806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, UNIQUE INDEX UNIQ_97A0ADA3166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE thermician ADD active_ticket_id INT DEFAULT NULL, DROP active_ticket, DROP inactive_ticket');
        $this->addSql('ALTER TABLE thermician ADD CONSTRAINT FK_805EB6B6669604E6 FOREIGN KEY (active_ticket_id) REFERENCES ticket (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_805EB6B6669604E6 ON thermician (active_ticket_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE thermician DROP FOREIGN KEY FK_805EB6B6669604E6');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP INDEX UNIQ_805EB6B6669604E6 ON thermician');
        $this->addSql('ALTER TABLE thermician ADD active_ticket INT NOT NULL, ADD inactive_ticket INT NOT NULL, DROP active_ticket_id');
    }
}
