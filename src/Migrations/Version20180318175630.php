<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180318175630 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE alert (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, resources_id INT DEFAULT NULL, type VARCHAR(100) NOT NULL, comment VARCHAR(100) NOT NULL, INDEX IDX_17FD46C1A76ED395 (user_id), INDEX IDX_17FD46C1ACFC5BFF (resources_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, creation_date DATETIME NOT NULL, update_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_subject (category_id INT NOT NULL, subject_id INT NOT NULL, INDEX IDX_3C167E0412469DE2 (category_id), INDEX IDX_3C167E0423EDC87 (subject_id), PRIMARY KEY(category_id, subject_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, subject_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, summary VARCHAR(350) NOT NULL, link VARCHAR(350) NOT NULL, creation_date DATETIME NOT NULL, update_date DATETIME NOT NULL, relevance INT DEFAULT 0 NOT NULL, tag VARCHAR(100) NOT NULL, INDEX IDX_BC91F416A76ED395 (user_id), INDEX IDX_BC91F41623EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, creation_date DATETIME NOT NULL, update_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject_user (subject_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1F59529223EDC87 (subject_id), INDEX IDX_1F595292A76ED395 (user_id), PRIMARY KEY(subject_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(254) NOT NULL, is_active TINYINT(1) NOT NULL, subscription_date DATETIME NOT NULL, roles VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alert ADD CONSTRAINT FK_17FD46C1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE alert ADD CONSTRAINT FK_17FD46C1ACFC5BFF FOREIGN KEY (resources_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE category_subject ADD CONSTRAINT FK_3C167E0412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_subject ADD CONSTRAINT FK_3C167E0423EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resource ADD CONSTRAINT FK_BC91F416A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE resource ADD CONSTRAINT FK_BC91F41623EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE subject_user ADD CONSTRAINT FK_1F59529223EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subject_user ADD CONSTRAINT FK_1F595292A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category_subject DROP FOREIGN KEY FK_3C167E0412469DE2');
        $this->addSql('ALTER TABLE alert DROP FOREIGN KEY FK_17FD46C1ACFC5BFF');
        $this->addSql('ALTER TABLE category_subject DROP FOREIGN KEY FK_3C167E0423EDC87');
        $this->addSql('ALTER TABLE resource DROP FOREIGN KEY FK_BC91F41623EDC87');
        $this->addSql('ALTER TABLE subject_user DROP FOREIGN KEY FK_1F59529223EDC87');
        $this->addSql('ALTER TABLE alert DROP FOREIGN KEY FK_17FD46C1A76ED395');
        $this->addSql('ALTER TABLE resource DROP FOREIGN KEY FK_BC91F416A76ED395');
        $this->addSql('ALTER TABLE subject_user DROP FOREIGN KEY FK_1F595292A76ED395');
        $this->addSql('DROP TABLE alert');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_subject');
        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE subject_user');
        $this->addSql('DROP TABLE user');
    }
}
