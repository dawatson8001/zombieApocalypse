<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180829175945 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A6560893980');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65DF9A1AF5');
        $this->addSql('DROP INDEX IDX_98197A6560893980 ON player');
        $this->addSql('DROP INDEX IDX_98197A65DF9A1AF5 ON player');
        $this->addSql('ALTER TABLE player ADD medicine_one_units INT DEFAULT NULL, ADD medicine_two_units INT DEFAULT NULL, DROP medicine_one_units_id, DROP medicine_two_units_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player ADD medicine_one_units_id INT DEFAULT NULL, ADD medicine_two_units_id INT DEFAULT NULL, DROP medicine_one_units, DROP medicine_two_units');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A6560893980 FOREIGN KEY (medicine_one_units_id) REFERENCES medicine (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65DF9A1AF5 FOREIGN KEY (medicine_two_units_id) REFERENCES medicine (id)');
        $this->addSql('CREATE INDEX IDX_98197A6560893980 ON player (medicine_one_units_id)');
        $this->addSql('CREATE INDEX IDX_98197A65DF9A1AF5 ON player (medicine_two_units_id)');
    }
}
