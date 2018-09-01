<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180829173853 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE armor ADD level_available INT NOT NULL');
        $this->addSql('ALTER TABLE enemy ADD level_available INT NOT NULL');
        $this->addSql('ALTER TABLE medicine ADD level_available INT NOT NULL');
        $this->addSql('ALTER TABLE weapon ADD level_available INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE armor DROP level_available');
        $this->addSql('ALTER TABLE enemy DROP level_available');
        $this->addSql('ALTER TABLE medicine DROP level_available');
        $this->addSql('ALTER TABLE weapon DROP level_available');
    }
}
