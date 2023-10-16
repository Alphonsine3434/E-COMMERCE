<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231016081904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD2B36786B ON product (title)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9B2A6C7EAEA34913 ON supplier (reference)');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(200) NOT NULL, ADD first_name VARCHAR(200) NOT NULL, ADD adress VARCHAR(200) NOT NULL, ADD phone INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP name, DROP first_name, DROP adress, DROP phone');
        $this->addSql('DROP INDEX UNIQ_9B2A6C7EAEA34913 ON supplier');
        $this->addSql('DROP INDEX UNIQ_D34A04AD2B36786B ON product');
    }
}
