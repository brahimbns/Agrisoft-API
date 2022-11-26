<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125164711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "analyse_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE payment_farmer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "analyse" (id INT NOT NULL, analyse_request_id_id INT NOT NULL, date_analyse TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_351B0C7E12FA93CE ON "analyse" (analyse_request_id_id)');
        $this->addSql('CREATE TABLE payment_farmer (id INT NOT NULL, analyse_request_id_id INT NOT NULL, credit DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C9BD371912FA93CE ON payment_farmer (analyse_request_id_id)');
        $this->addSql('ALTER TABLE "analyse" ADD CONSTRAINT FK_351B0C7E12FA93CE FOREIGN KEY (analyse_request_id_id) REFERENCES analyse_request (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment_farmer ADD CONSTRAINT FK_C9BD371912FA93CE FOREIGN KEY (analyse_request_id_id) REFERENCES analyse_request (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "analyse_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE payment_farmer_id_seq CASCADE');
        $this->addSql('ALTER TABLE "analyse" DROP CONSTRAINT FK_351B0C7E12FA93CE');
        $this->addSql('ALTER TABLE payment_farmer DROP CONSTRAINT FK_C9BD371912FA93CE');
        $this->addSql('DROP TABLE "analyse"');
        $this->addSql('DROP TABLE payment_farmer');
    }
}
