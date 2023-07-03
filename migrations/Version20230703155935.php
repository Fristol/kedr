<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230703155935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL COMMENT \'Уникальный идентификатор\', login VARCHAR(64) NOT NULL COMMENT \'Логин пользователя\', password VARCHAR(64) NOT NULL COMMENT \'Пароль пользователя\', UNIQUE INDEX uidx__user__login (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_event (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL COMMENT \'Уникальный идентификатор\', user_id BIGINT UNSIGNED NOT NULL COMMENT \'Уникальный идентификатор\', title VARCHAR(256) NOT NULL COMMENT \'Текст\', date_time DATETIME NOT NULL COMMENT \'Дата\', INDEX IDX_D96CF1FFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FFA76ED395');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_event');
    }
}
