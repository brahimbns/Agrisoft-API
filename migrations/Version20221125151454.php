<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125151454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE reception_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE reception (id INT NOT NULL, user_id_id INT NOT NULL, farmer_id_id INT NOT NULL, center_id_id INT NOT NULL, product_id_id INT NOT NULL, receipt BIGINT NOT NULL, ticket_number INT DEFAULT NULL, date_receipt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, quantity DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_50D6852F9D86650F ON reception (user_id_id)');
        $this->addSql('CREATE INDEX IDX_50D6852FD532C99C ON reception (farmer_id_id)');
        $this->addSql('CREATE INDEX IDX_50D6852FC0B95842 ON reception (center_id_id)');
        $this->addSql('CREATE INDEX IDX_50D6852FDE18E50B ON reception (product_id_id)');
        $this->addSql('COMMENT ON COLUMN reception.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reception.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reception.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE reception ADD CONSTRAINT FK_50D6852F9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reception ADD CONSTRAINT FK_50D6852FD532C99C FOREIGN KEY (farmer_id_id) REFERENCES farmer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reception ADD CONSTRAINT FK_50D6852FC0B95842 FOREIGN KEY (center_id_id) REFERENCES center (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reception ADD CONSTRAINT FK_50D6852FDE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE reception_id_seq CASCADE');
        $this->addSql('ALTER TABLE reception DROP CONSTRAINT FK_50D6852F9D86650F');
        $this->addSql('ALTER TABLE reception DROP CONSTRAINT FK_50D6852FD532C99C');
        $this->addSql('ALTER TABLE reception DROP CONSTRAINT FK_50D6852FC0B95842');
        $this->addSql('ALTER TABLE reception DROP CONSTRAINT FK_50D6852FDE18E50B');
        $this->addSql('DROP TABLE reception');
    }
}
