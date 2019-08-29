<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190820221756 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom_envoi VARCHAR(255) DEFAULT NULL, prenom_evoie VARCHAR(255) DEFAULT NULL, cni_envoie VARCHAR(255) DEFAULT NULL, montant_envoi BIGINT DEFAULT NULL, date_envoie DATETIME DEFAULT NULL, code_envoie VARCHAR(255) NOT NULL, cni_retrait VARCHAR(255) DEFAULT NULL, montant_retrait BIGINT DEFAULT NULL, date_retrait DATETIME DEFAULT NULL, tel_envoi INT DEFAULT NULL, tel_retrait INT DEFAULT NULL, commission_etat BIGINT NOT NULL, commission_admin BIGINT NOT NULL, commission_retrait BIGINT NOT NULL, commission_envoie BIGINT NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_723705D1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE transaction');
    }
}
