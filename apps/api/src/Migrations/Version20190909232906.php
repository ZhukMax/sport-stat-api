<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190909232906 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, source_id INT NOT NULL, league_id INT NOT NULL, sport_id INT NOT NULL, team_one_id INT NOT NULL, team_two_id INT NOT NULL, language_id INT NOT NULL, start_at DATETIME NOT NULL, INDEX IDX_232B318C953C1C61 (source_id), INDEX IDX_232B318C58AFC4DE (league_id), INDEX IDX_232B318CAC78BCF8 (sport_id), INDEX IDX_232B318C8D8189CA (team_one_id), INDEX IDX_232B318CE6DD6E05 (team_two_id), INDEX IDX_232B318C82F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, synonyms JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, synonyms JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport_type (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, synonyms JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport_team (id INT AUTO_INCREMENT NOT NULL, sport_id INT NOT NULL, title VARCHAR(255) NOT NULL, synonyms JSON DEFAULT NULL, INDEX IDX_B33F88E3AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C953C1C61 FOREIGN KEY (source_id) REFERENCES source (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport_type (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C8D8189CA FOREIGN KEY (team_one_id) REFERENCES sport_team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CE6DD6E05 FOREIGN KEY (team_two_id) REFERENCES sport_team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE sport_team ADD CONSTRAINT FK_B33F88E3AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport_type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C58AFC4DE');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C82F1BAF4');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CAC78BCF8');
        $this->addSql('ALTER TABLE sport_team DROP FOREIGN KEY FK_B33F88E3AC78BCF8');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C953C1C61');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C8D8189CA');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CE6DD6E05');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE sport_type');
        $this->addSql('DROP TABLE source');
        $this->addSql('DROP TABLE sport_team');
    }
}
