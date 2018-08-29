<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180826215508 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE armor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, defence INT NOT NULL, max_item_condition INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicine (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, heal_amount INT NOT NULL, max_units INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, weapon_id INT DEFAULT NULL, armor_id INT DEFAULT NULL, medicine_one_id INT DEFAULT NULL, medicine_two_id INT DEFAULT NULL, username VARCHAR(255) NOT NULL, health INT NOT NULL, max_health INT NOT NULL, weapon_condition INT DEFAULT NULL, armor_condition INT DEFAULT NULL, INDEX IDX_98197A6595B82273 (weapon_id), INDEX IDX_98197A65F5AA3663 (armor_id), INDEX IDX_98197A656D87EE99 (medicine_one_id), INDEX IDX_98197A656DB0956 (medicine_two_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weapon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, min_damage INT NOT NULL, max_damage INT NOT NULL, max_item_condition INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A6595B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65F5AA3663 FOREIGN KEY (armor_id) REFERENCES armor (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A656D87EE99 FOREIGN KEY (medicine_one_id) REFERENCES medicine (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A656DB0956 FOREIGN KEY (medicine_two_id) REFERENCES medicine (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65F5AA3663');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A656D87EE99');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A656DB0956');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A6595B82273');
        $this->addSql('DROP TABLE armor');
        $this->addSql('DROP TABLE medicine');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE weapon');
    }
}
