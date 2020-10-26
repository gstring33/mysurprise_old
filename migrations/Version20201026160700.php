<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201026160700 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E6B5C234');
        $this->addSql('DROP INDEX UNIQ_8D93D649E6B5C234 ON user');
        $this->addSql('ALTER TABLE user CHANGE user_selected_id selected_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494F2AAD0B FOREIGN KEY (selected_user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6494F2AAD0B ON user (selected_user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494F2AAD0B');
        $this->addSql('DROP INDEX UNIQ_8D93D6494F2AAD0B ON user');
        $this->addSql('ALTER TABLE user CHANGE selected_user_id user_selected_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E6B5C234 FOREIGN KEY (user_selected_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E6B5C234 ON user (user_selected_id)');
    }
}
