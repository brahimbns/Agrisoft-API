<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125144248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE price_product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE price_product (id INT NOT NULL, base_price DOUBLE PRECISION NOT NULL, date_base_price_start DATE NOT NULL, date_base_price_end DATE NOT NULL, prime_price DOUBLE PRECISION NOT NULL, date_prime_price_start DATE NOT NULL, date_prime_price_end DATE NOT NULL, solidarity_tax DOUBLE PRECISION NOT NULL, date_solidarity_tax_start DATE NOT NULL, date_solidarity_tax_end DATE NOT NULL, statistical_tax DOUBLE PRECISION NOT NULL, date_statistical_tax_start DATE NOT NULL, date_statistical_tax_end DATE NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE price_product_id_seq CASCADE');
        $this->addSql('DROP TABLE price_product');
    }
}
