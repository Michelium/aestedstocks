<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191207124823 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, parent_page_id INT DEFAULT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, modified_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_140AB620989D9B62 (slug), UNIQUE INDEX UNIQ_140AB6207E0E17A2 (parent_page_id), INDEX IDX_140AB620B03A8386 (created_by_id), INDEX IDX_140AB62099049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_content_block (id INT AUTO_INCREMENT NOT NULL, page_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, background_colour VARCHAR(10) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, modified_at DATETIME DEFAULT NULL, INDEX IDX_F902B3CBC4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, modified_at DATETIME DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB6207E0E17A2 FOREIGN KEY (parent_page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62099049ECE FOREIGN KEY (modified_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE page_content_block ADD CONSTRAINT FK_F902B3CBC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB6207E0E17A2');
        $this->addSql('ALTER TABLE page_content_block DROP FOREIGN KEY FK_F902B3CBC4663E4');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620B03A8386');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62099049ECE');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_content_block');
        $this->addSql('DROP TABLE user');
    }
}
