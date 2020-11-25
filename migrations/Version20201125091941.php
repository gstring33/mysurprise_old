<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201125091941 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, tchat_room_id INT DEFAULT NULL, user_id INT DEFAULT NULL, content LONGTEXT NOT NULL, date DATETIME NOT NULL, type VARCHAR(100) NOT NULL, is_read TINYINT(1) NOT NULL, INDEX IDX_B6BD307F16F52A05 (tchat_room_id), INDEX IDX_B6BD307FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tchat_room (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F16F52A05 FOREIGN KEY (tchat_room_id) REFERENCES tchat_room (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD tchat_room_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64916F52A05 FOREIGN KEY (tchat_room_id) REFERENCES tchat_room (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64916F52A05 ON user (tchat_room_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F16F52A05');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64916F52A05');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE tchat_room');
        $this->addSql('DROP INDEX UNIQ_8D93D64916F52A05 ON user');
        $this->addSql('ALTER TABLE user DROP tchat_room_id');
    }
}
