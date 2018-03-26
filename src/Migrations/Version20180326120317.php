<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180326120317 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE subject_user');
        $this->addSql('ALTER TABLE alert DROP FOREIGN KEY FK_17FD46C1ACFC5BFF');
        $this->addSql('DROP INDEX IDX_17FD46C1ACFC5BFF ON alert');
        $this->addSql('ALTER TABLE alert CHANGE resources_id resource_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE alert ADD CONSTRAINT FK_17FD46C189329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('CREATE INDEX IDX_17FD46C189329D25 ON alert (resource_id)');
        $this->addSql('ALTER TABLE subject ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FBCE3E7AA76ED395 ON subject (user_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE subject_user (subject_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1F59529223EDC87 (subject_id), INDEX IDX_1F595292A76ED395 (user_id), PRIMARY KEY(subject_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subject_user ADD CONSTRAINT FK_1F59529223EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subject_user ADD CONSTRAINT FK_1F595292A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE alert DROP FOREIGN KEY FK_17FD46C189329D25');
        $this->addSql('DROP INDEX IDX_17FD46C189329D25 ON alert');
        $this->addSql('ALTER TABLE alert CHANGE resource_id resources_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE alert ADD CONSTRAINT FK_17FD46C1ACFC5BFF FOREIGN KEY (resources_id) REFERENCES resource (id)');
        $this->addSql('CREATE INDEX IDX_17FD46C1ACFC5BFF ON alert (resources_id)');
        $this->addSql('ALTER TABLE subject DROP FOREIGN KEY FK_FBCE3E7AA76ED395');
        $this->addSql('DROP INDEX IDX_FBCE3E7AA76ED395 ON subject');
        $this->addSql('ALTER TABLE subject DROP user_id');
    }
}
