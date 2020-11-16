<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201116095948 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create the database';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE reset_password_request (
            id INT AUTO_INCREMENT NOT NULL,
            user_id INT NOT NULL,
            selector VARCHAR(20) NOT NULL,
            hashed_token VARCHAR(100) NOT NULL,
            requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id))
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

            CREATE TABLE user (
                id INT AUTO_INCREMENT NOT NULL,
                selected_user_id INT DEFAULT NULL,
                gifts_list_id INT DEFAULT NULL,
                username VARCHAR(180) NOT NULL,
                roles JSON NOT NULL, password VARCHAR(255) NOT NULL,
                firstname VARCHAR(100) NOT NULL,
                lastname VARCHAR(100) NOT NULL,
                is_selected TINYINT(1) NOT NULL,
                is_allowed_to_select_user TINYINT(1) DEFAULT \'0\' NOT NULL,
                hash VARCHAR(255) NOT NULL,
                image VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                is_first_connection TINYINT(1) NOT NULL,
                UNIQUE INDEX UNIQ_8D93D649F85E0677 (username),
                UNIQUE INDEX UNIQ_8D93D6494F2AAD0B (selected_user_id),
                UNIQUE INDEX UNIQ_8D93D6496B26620B (gifts_list_id),
                PRIMARY KEY(id))
                DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

                CREATE TABLE gifts_list (
                    id INT AUTO_INCREMENT NOT NULL,
                    is_published TINYINT(1) DEFAULT \'0\' NOT NULL,
                    date_published DATE DEFAULT NULL,
                    PRIMARY KEY(id))
                    DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
                
                CREATE TABLE gift (
                    id INT AUTO_INCREMENT NOT NULL,
                    gift_list_id INT NOT NULL,
                    title VARCHAR(255) NOT NULL,
                    description LONGTEXT DEFAULT NULL,
                    link VARCHAR(255) DEFAULT NULL,
                    INDEX IDX_A47C990D51F42524 (gift_list_id),
                    PRIMARY KEY(id))
                    DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
                
                ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id);
                ALTER TABLE user ADD CONSTRAINT FK_8D93D6494F2AAD0B FOREIGN KEY (selected_user_id) REFERENCES user (id);
                ALTER TABLE user ADD CONSTRAINT FK_8D93D6496B26620B FOREIGN KEY (gifts_list_id) REFERENCES gifts_list (id);
                ALTER TABLE gift ADD CONSTRAINT FK_A47C990D51F42524 FOREIGN KEY (gift_list_id) REFERENCES gifts_list (id);
        ');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
