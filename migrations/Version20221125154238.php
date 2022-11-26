<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125154238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE analyse_request_reception_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE analyse_request_reception (id INT NOT NULL, receipt_id_id INT NOT NULL, request_id_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D10326819BDC2A67 ON analyse_request_reception (receipt_id_id)');
        $this->addSql('CREATE INDEX IDX_D103268122532272 ON analyse_request_reception (request_id_id)');
        $this->addSql('COMMENT ON COLUMN analyse_request_reception.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE analyse_request_reception ADD CONSTRAINT FK_D10326819BDC2A67 FOREIGN KEY (receipt_id_id) REFERENCES reception (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE analyse_request_reception ADD CONSTRAINT FK_D103268122532272 FOREIGN KEY (request_id_id) REFERENCES analyse_request (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE analyse_request_reception_id_seq CASCADE');
        $this->addSql('ALTER TABLE analyse_request_reception DROP CONSTRAINT FK_D10326819BDC2A67');
        $this->addSql('ALTER TABLE analyse_request_reception DROP CONSTRAINT FK_D103268122532272');
        $this->addSql('DROP TABLE analyse_request_reception');
    }
}
