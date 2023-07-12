<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230712102649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE music ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224AC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_CD52224AC54C8C93 ON music (type_id)');
        $this->addSql('ALTER TABLE user ADD music_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649399BBB13 FOREIGN KEY (music_id) REFERENCES music (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649399BBB13 ON user (music_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649399BBB13');
        $this->addSql('DROP INDEX IDX_8D93D649399BBB13 ON user');
        $this->addSql('ALTER TABLE user DROP music_id');
        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224AC54C8C93');
        $this->addSql('DROP INDEX IDX_CD52224AC54C8C93 ON music');
        $this->addSql('ALTER TABLE music DROP type_id');
    }
}
