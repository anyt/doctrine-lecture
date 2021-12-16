<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211216170827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, main_chat_id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1483A5E9EED1D8CC ON users (main_chat_id)');
        $this->addSql('CREATE TABLE users_chats (user_id INT NOT NULL, chat_id INT NOT NULL, PRIMARY KEY(user_id, chat_id))');
        $this->addSql('CREATE INDEX IDX_CA1FBC46A76ED395 ON users_chats (user_id)');
        $this->addSql('CREATE INDEX IDX_CA1FBC461A9A7125 ON users_chats (chat_id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9EED1D8CC FOREIGN KEY (main_chat_id) REFERENCES chats (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_chats ADD CONSTRAINT FK_CA1FBC46A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_chats ADD CONSTRAINT FK_CA1FBC461A9A7125 FOREIGN KEY (chat_id) REFERENCES chats (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chats ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chats ADD CONSTRAINT FK_2D68180F642B8210 FOREIGN KEY (admin_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2D68180F642B8210 ON chats (admin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chats DROP CONSTRAINT FK_2D68180F642B8210');
        $this->addSql('ALTER TABLE users_chats DROP CONSTRAINT FK_CA1FBC46A76ED395');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_chats');
        $this->addSql('DROP INDEX IDX_2D68180F642B8210');
        $this->addSql('ALTER TABLE chats DROP admin_id');
    }
}
