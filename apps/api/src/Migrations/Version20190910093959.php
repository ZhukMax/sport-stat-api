<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190910093959 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE game_buffer (id INT AUTO_INCREMENT NOT NULL, source_id INT NOT NULL, league_id INT NOT NULL, sport_id INT NOT NULL, team_one_id INT DEFAULT NULL, team_two_id INT NOT NULL, language_id INT NOT NULL, base_game_id INT DEFAULT NULL, start_at DATETIME NOT NULL, INDEX IDX_4C6F5D3A953C1C61 (source_id), INDEX IDX_4C6F5D3A58AFC4DE (league_id), INDEX IDX_4C6F5D3AAC78BCF8 (sport_id), INDEX IDX_4C6F5D3A8D8189CA (team_one_id), INDEX IDX_4C6F5D3AE6DD6E05 (team_two_id), INDEX IDX_4C6F5D3A82F1BAF4 (language_id), INDEX IDX_4C6F5D3AD0896061 (base_game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_buffer ADD CONSTRAINT FK_4C6F5D3A953C1C61 FOREIGN KEY (source_id) REFERENCES source (id)');
        $this->addSql('ALTER TABLE game_buffer ADD CONSTRAINT FK_4C6F5D3A58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
        $this->addSql('ALTER TABLE game_buffer ADD CONSTRAINT FK_4C6F5D3AAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport_type (id)');
        $this->addSql('ALTER TABLE game_buffer ADD CONSTRAINT FK_4C6F5D3A8D8189CA FOREIGN KEY (team_one_id) REFERENCES sport_team (id)');
        $this->addSql('ALTER TABLE game_buffer ADD CONSTRAINT FK_4C6F5D3AE6DD6E05 FOREIGN KEY (team_two_id) REFERENCES sport_team (id)');
        $this->addSql('ALTER TABLE game_buffer ADD CONSTRAINT FK_4C6F5D3A82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE game_buffer ADD CONSTRAINT FK_4C6F5D3AD0896061 FOREIGN KEY (base_game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE game_buffer');
    }
}
