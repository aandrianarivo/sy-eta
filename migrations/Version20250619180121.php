<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250619180121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE meal_plan (id SERIAL NOT NULL, name VARCHAR(50) DEFAULT NULL, description TEXT DEFAULT NULL, date_begin DATE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE daily_meal ADD meal_plan_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE daily_meal ADD CONSTRAINT FK_DAF09109912AB082 FOREIGN KEY (meal_plan_id) REFERENCES meal_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DAF09109912AB082 ON daily_meal (meal_plan_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE daily_meal DROP CONSTRAINT FK_DAF09109912AB082
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE meal_plan
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_DAF09109912AB082
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE daily_meal DROP meal_plan_id
        SQL);
    }
}
