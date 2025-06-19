<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250619172639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE daily_meal (id SERIAL NOT NULL, author_id INT DEFAULT NULL, meal_date DATE DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DAF09109F675F31B ON daily_meal (author_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE daily_meal_receipe (daily_meal_id INT NOT NULL, receipe_id INT NOT NULL, PRIMARY KEY(daily_meal_id, receipe_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CD466F88BC77B722 ON daily_meal_receipe (daily_meal_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CD466F88C3F9986C ON daily_meal_receipe (receipe_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE daily_meal ADD CONSTRAINT FK_DAF09109F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE daily_meal_receipe ADD CONSTRAINT FK_CD466F88BC77B722 FOREIGN KEY (daily_meal_id) REFERENCES daily_meal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE daily_meal_receipe ADD CONSTRAINT FK_CD466F88C3F9986C FOREIGN KEY (receipe_id) REFERENCES receipe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE daily_meal DROP CONSTRAINT FK_DAF09109F675F31B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE daily_meal_receipe DROP CONSTRAINT FK_CD466F88BC77B722
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE daily_meal_receipe DROP CONSTRAINT FK_CD466F88C3F9986C
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE daily_meal
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE daily_meal_receipe
        SQL);
    }
}
