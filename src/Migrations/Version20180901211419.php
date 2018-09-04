<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180901211419 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player CHANGE health health INT DEFAULT 100, CHANGE max_health max_health INT DEFAULT 100, CHANGE level level INT DEFAULT 1, CHANGE moves moves INT DEFAULT 1, CHANGE weapon_condition weapon_condition INT DEFAULT NULL, CHANGE armor_condition armor_condition INT DEFAULT NULL, CHANGE medicine_one_units medicine_one_units INT DEFAULT NULL, CHANGE medicine_two_units medicine_two_units INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player CHANGE health health INT DEFAULT 100 NOT NULL, CHANGE max_health max_health INT DEFAULT 100 NOT NULL, CHANGE weapon_condition weapon_condition INT NOT NULL, CHANGE armor_condition armor_condition INT NOT NULL, CHANGE medicine_one_units medicine_one_units INT NOT NULL, CHANGE medicine_two_units medicine_two_units INT NOT NULL, CHANGE level level INT DEFAULT 1 NOT NULL, CHANGE moves moves INT DEFAULT 1 NOT NULL');
    }
}
