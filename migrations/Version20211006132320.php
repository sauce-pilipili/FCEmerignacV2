<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211006132320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adversaires (id INT AUTO_INCREMENT NOT NULL, logo_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_ABAD13DDF98F144A (logo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE albums (id INT AUTO_INCREMENT NOT NULL, sub_galery_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F4E2474FC84DE6BB (sub_galery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, photo_en_avant_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, introduction VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, meta_description VARCHAR(255) NOT NULL, contenu VARCHAR(10000) DEFAULT NULL, UNIQUE INDEX UNIQ_BFDD31682D58A620 (photo_en_avant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, photo_equipe_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2449BA1512469DE2 (category_id), UNIQUE INDEX UNIQ_2449BA1560784DA8 (photo_equipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galery (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE joueurs (id INT AUTO_INCREMENT NOT NULL, photo_debout_id INT DEFAULT NULL, photo_portrait_id INT DEFAULT NULL, lastname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, age VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, poste VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F0FD889DDB9798ED (photo_debout_id), UNIQUE INDEX UNIQ_F0FD889D1CB1072F (photo_portrait_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE match_avenir (id INT AUTO_INCREMENT NOT NULL, equipe_id INT DEFAULT NULL, adversaire_id INT DEFAULT NULL, match_date DATETIME NOT NULL, INDEX IDX_E112B0D76D861B89 (equipe_id), INDEX IDX_E112B0D73E4689F5 (adversaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, article_photo_fond_id INT DEFAULT NULL, albums_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_14B7841835D5565C (article_photo_fond_id), INDEX IDX_14B78418ECBB55AF (albums_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_galery (id INT AUTO_INCREMENT NOT NULL, galery_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, INDEX IDX_B90C1C6CDA40A005 (galery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adversaires ADD CONSTRAINT FK_ABAD13DDF98F144A FOREIGN KEY (logo_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE albums ADD CONSTRAINT FK_F4E2474FC84DE6BB FOREIGN KEY (sub_galery_id) REFERENCES sub_galery (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31682D58A620 FOREIGN KEY (photo_en_avant_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA1512469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA1560784DA8 FOREIGN KEY (photo_equipe_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE joueurs ADD CONSTRAINT FK_F0FD889DDB9798ED FOREIGN KEY (photo_debout_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE joueurs ADD CONSTRAINT FK_F0FD889D1CB1072F FOREIGN KEY (photo_portrait_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE match_avenir ADD CONSTRAINT FK_E112B0D76D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE match_avenir ADD CONSTRAINT FK_E112B0D73E4689F5 FOREIGN KEY (adversaire_id) REFERENCES adversaires (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B7841835D5565C FOREIGN KEY (article_photo_fond_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418ECBB55AF FOREIGN KEY (albums_id) REFERENCES albums (id)');
        $this->addSql('ALTER TABLE sub_galery ADD CONSTRAINT FK_B90C1C6CDA40A005 FOREIGN KEY (galery_id) REFERENCES galery (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE match_avenir DROP FOREIGN KEY FK_E112B0D73E4689F5');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418ECBB55AF');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B7841835D5565C');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA1512469DE2');
        $this->addSql('ALTER TABLE match_avenir DROP FOREIGN KEY FK_E112B0D76D861B89');
        $this->addSql('ALTER TABLE sub_galery DROP FOREIGN KEY FK_B90C1C6CDA40A005');
        $this->addSql('ALTER TABLE adversaires DROP FOREIGN KEY FK_ABAD13DDF98F144A');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD31682D58A620');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA1560784DA8');
        $this->addSql('ALTER TABLE joueurs DROP FOREIGN KEY FK_F0FD889DDB9798ED');
        $this->addSql('ALTER TABLE joueurs DROP FOREIGN KEY FK_F0FD889D1CB1072F');
        $this->addSql('ALTER TABLE albums DROP FOREIGN KEY FK_F4E2474FC84DE6BB');
        $this->addSql('DROP TABLE adversaires');
        $this->addSql('DROP TABLE albums');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE galery');
        $this->addSql('DROP TABLE joueurs');
        $this->addSql('DROP TABLE match_avenir');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE sub_galery');
        $this->addSql('DROP TABLE user');
    }
}
