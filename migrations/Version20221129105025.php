<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221129105025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE user_center_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_center (id INT NOT NULL, user_id_id INT NOT NULL, center_id_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_25A2F0199D86650F ON user_center (user_id_id)');
        $this->addSql('CREATE INDEX IDX_25A2F019C0B95842 ON user_center (center_id_id)');
        $this->addSql('COMMENT ON COLUMN user_center.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_center ADD CONSTRAINT FK_25A2F0199D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_center ADD CONSTRAINT FK_25A2F019C0B95842 FOREIGN KEY (center_id_id) REFERENCES center (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE user_center_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_center DROP CONSTRAINT FK_25A2F0199D86650F');
        $this->addSql('ALTER TABLE user_center DROP CONSTRAINT FK_25A2F019C0B95842');
        $this->addSql('DROP TABLE user_center');
    }
}
