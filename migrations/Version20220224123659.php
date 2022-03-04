<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220224123659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE color DROP FOREIGN KEY FK_665648E926ED0855');
        $this->addSql('DROP INDEX IDX_665648E926ED0855 ON color');
        $this->addSql('ALTER TABLE color DROP note_id');
        $this->addSql('ALTER TABLE form DROP FOREIGN KEY FK_5288FD4F26ED0855');
        $this->addSql('DROP INDEX IDX_5288FD4F26ED0855 ON form');
        $this->addSql('ALTER TABLE form DROP note_id');
        $this->addSql('ALTER TABLE note ADD color_id INT DEFAULT NULL, ADD form_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA147ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA145FF69B7D FOREIGN KEY (form_id) REFERENCES form (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA147ADA1FB5 ON note (color_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA145FF69B7D ON note (form_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE color ADD note_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE color ADD CONSTRAINT FK_665648E926ED0855 FOREIGN KEY (note_id) REFERENCES note (id)');
        $this->addSql('CREATE INDEX IDX_665648E926ED0855 ON color (note_id)');
        $this->addSql('ALTER TABLE form ADD note_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4F26ED0855 FOREIGN KEY (note_id) REFERENCES note (id)');
        $this->addSql('CREATE INDEX IDX_5288FD4F26ED0855 ON form (note_id)');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA147ADA1FB5');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA145FF69B7D');
        $this->addSql('DROP INDEX IDX_CFBDFA147ADA1FB5 ON note');
        $this->addSql('DROP INDEX IDX_CFBDFA145FF69B7D ON note');
        $this->addSql('ALTER TABLE note DROP color_id, DROP form_id');
    }
}
