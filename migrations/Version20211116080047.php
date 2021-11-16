<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211116080047 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gift (id INT AUTO_INCREMENT NOT NULL, gift_list_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, INDEX IDX_A47C990D51F42524 (gift_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gifts_list (id INT AUTO_INCREMENT NOT NULL, is_published TINYINT(1) DEFAULT \'0\' NOT NULL, date_published DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, tchat_room_id INT DEFAULT NULL, user_id INT DEFAULT NULL, content LONGTEXT NOT NULL, date DATETIME NOT NULL, type VARCHAR(100) NOT NULL, is_read TINYINT(1) NOT NULL, INDEX IDX_B6BD307F16F52A05 (tchat_room_id), INDEX IDX_B6BD307FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tchat_room (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, selected_user_id INT DEFAULT NULL, gifts_list_id INT DEFAULT NULL, tchat_room_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, is_selected TINYINT(1) NOT NULL, is_allowed_to_select_user TINYINT(1) DEFAULT \'0\' NOT NULL, hash VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, is_first_connection TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D6494F2AAD0B (selected_user_id), UNIQUE INDEX UNIQ_8D93D6496B26620B (gifts_list_id), UNIQUE INDEX UNIQ_8D93D64916F52A05 (tchat_room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gift ADD CONSTRAINT FK_A47C990D51F42524 FOREIGN KEY (gift_list_id) REFERENCES gifts_list (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F16F52A05 FOREIGN KEY (tchat_room_id) REFERENCES tchat_room (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494F2AAD0B FOREIGN KEY (selected_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496B26620B FOREIGN KEY (gifts_list_id) REFERENCES gifts_list (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64916F52A05 FOREIGN KEY (tchat_room_id) REFERENCES tchat_room (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gift DROP FOREIGN KEY FK_A47C990D51F42524');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496B26620B');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F16F52A05');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64916F52A05');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494F2AAD0B');
        $this->addSql('DROP TABLE gift');
        $this->addSql('DROP TABLE gifts_list');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE tchat_room');
        $this->addSql('DROP TABLE user');
    }
}
