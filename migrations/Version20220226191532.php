<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220226191532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA145FF69B7D');
        $this->addSql('DROP INDEX IDX_CFBDFA145FF69B7D ON note');
        $this->addSql('ALTER TABLE note CHANGE form_id formes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14BE7E687C FOREIGN KEY (formes_id) REFERENCES form (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14BE7E687C ON note (formes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14BE7E687C');
        $this->addSql('DROP INDEX IDX_CFBDFA14BE7E687C ON note');
        $this->addSql('ALTER TABLE note CHANGE formes_id form_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA145FF69B7D FOREIGN KEY (form_id) REFERENCES form (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA145FF69B7D ON note (form_id)');
    }
}
