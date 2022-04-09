<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220409192600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, prestation_id INT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_E00CEDDE9E45C554 (prestation_id), INDEX IDX_E00CEDDEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, num_tva VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, language_id INT NOT NULL, trainer_id INT DEFAULT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, level INT NOT NULL, price DOUBLE PRECISION NOT NULL, nbr_session INT NOT NULL, duration TIME NOT NULL, description VARCHAR(800) NOT NULL, date DATETIME NOT NULL, INDEX IDX_FDCA8C9C82F1BAF4 (language_id), INDEX IDX_FDCA8C9CFB08EDF6 (trainer_id), UNIQUE INDEX UNIQ_FDCA8C9C12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_D4DB71B55E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestation (id INT AUTO_INCREMENT NOT NULL, cours_id INT NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, days VARCHAR(50) NOT NULL, INDEX IDX_51C88FAD7ECF78B0 (cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainer (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C5150820E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE9E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CFB08EDF6 FOREIGN KEY (trainer_id) REFERENCES trainer (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT FK_51C88FAD7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C12469DE2');
        $this->addSql('ALTER TABLE prestation DROP FOREIGN KEY FK_51C88FAD7ECF78B0');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C82F1BAF4');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE9E45C554');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CFB08EDF6');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE prestation');
        $this->addSql('DROP TABLE trainer');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
