<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191005152947 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment ADD user_id INT DEFAULT NULL, ADD application_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C3E030ACD FOREIGN KEY (application_id) REFERENCES application (id)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526C3E030ACD ON comment (application_id)');
        $this->addSql('ALTER TABLE sanction ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE sanction ADD CONSTRAINT FK_6D6491AFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6D6491AFA76ED395 ON sanction (user_id)');
        $this->addSql('ALTER TABLE user ADD action_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6499D32F035 ON user (action_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C3E030ACD');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395 ON comment');
        $this->addSql('DROP INDEX IDX_9474526C3E030ACD ON comment');
        $this->addSql('ALTER TABLE comment DROP user_id, DROP application_id');
        $this->addSql('ALTER TABLE sanction DROP FOREIGN KEY FK_6D6491AFA76ED395');
        $this->addSql('DROP INDEX IDX_6D6491AFA76ED395 ON sanction');
        $this->addSql('ALTER TABLE sanction DROP user_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499D32F035');
        $this->addSql('DROP INDEX UNIQ_8D93D6499D32F035 ON user');
        $this->addSql('ALTER TABLE user DROP action_id');
    }
}
