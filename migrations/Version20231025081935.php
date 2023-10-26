<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231025081935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_880E0D76F85E0677 ON `admin`');
        $this->addSql('ALTER TABLE `admin` ADD email VARCHAR(180) NOT NULL, CHANGE username user_name VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D7624A232CF ON `admin` (user_name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76E7927C74 ON `admin` (email)');
        $this->addSql('ALTER TABLE user ADD user_name VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64924A232CF ON user (user_name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_880E0D7624A232CF ON `admin`');
        $this->addSql('DROP INDEX UNIQ_880E0D76E7927C74 ON `admin`');
        $this->addSql('ALTER TABLE `admin` ADD username VARCHAR(180) NOT NULL, DROP user_name, DROP email');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76F85E0677 ON `admin` (username)');
        $this->addSql('DROP INDEX UNIQ_8D93D64924A232CF ON user');
        $this->addSql('ALTER TABLE user DROP user_name');
    }
}
