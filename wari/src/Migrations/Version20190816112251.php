<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190816112251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE depots (id INT AUTO_INCREMENT NOT NULL, compt_id INT DEFAULT NULL, caissier_id INT DEFAULT NULL, montant INT NOT NULL, date_depot DATETIME NOT NULL, solde_initial INT NOT NULL, INDEX IDX_D99EA427765D939F (compt_id), INDEX IDX_D99EA427B514973B (caissier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE depots ADD CONSTRAINT FK_D99EA427765D939F FOREIGN KEY (compt_id) REFERENCES compts (id)');
        $this->addSql('ALTER TABLE depots ADD CONSTRAINT FK_D99EA427B514973B FOREIGN KEY (caissier_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE depots');
    }
}
