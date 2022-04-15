<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415180918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094F5E237E06 ON company (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094FFFEE978E ON company (num_tva)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FDCA8C9C2B36786B ON cours (title)');
        $this->addSql('ALTER TABLE trainer CHANGE company_id company_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_64C19C15E237E06 ON category');
        $this->addSql('DROP INDEX UNIQ_4FBF094F5E237E06 ON company');
        $this->addSql('DROP INDEX UNIQ_4FBF094FFFEE978E ON company');
        $this->addSql('DROP INDEX UNIQ_FDCA8C9C2B36786B ON cours');
        $this->addSql('ALTER TABLE trainer CHANGE company_id company_id INT NOT NULL');
    }
}
