<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250815161832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE api_token (id INT AUTO_INCREMENT NOT NULL, token VARCHAR(255) NOT NULL, expiry_date DATETIME NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_7BA2F5EBA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cui VARCHAR(255) NOT NULL, year_created INT NOT NULL, parent_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, department_id INT NOT NULL, work_point_id INT NOT NULL, INDEX IDX_CD1DE18AAE80F5DF (department_id), INDEX IDX_CD1DE18A159D44FE (work_point_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE department_info (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, hire_date DATE NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, job_id INT NOT NULL, INDEX IDX_5D9F75A1BE04EA9 (job_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, salary INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, job_type_id INT NOT NULL, department_id INT NOT NULL, INDEX IDX_FBD8E0F85FA33B08 (job_type_id), INDEX IDX_FBD8E0F8AE80F5DF (department_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE job_information (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE work_point (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, county VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, program_start TIME NOT NULL, program_end TIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, company_id INT NOT NULL, INDEX IDX_9F5E880B979B1AD6 (company_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE api_token ADD CONSTRAINT FK_7BA2F5EBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18AAE80F5DF FOREIGN KEY (department_id) REFERENCES department_info (id)');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A159D44FE FOREIGN KEY (work_point_id) REFERENCES work_point (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F85FA33B08 FOREIGN KEY (job_type_id) REFERENCES job_information (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE work_point ADD CONSTRAINT FK_9F5E880B979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE api_token DROP FOREIGN KEY FK_7BA2F5EBA76ED395');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18AAE80F5DF');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18A159D44FE');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1BE04EA9');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F85FA33B08');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8AE80F5DF');
        $this->addSql('ALTER TABLE work_point DROP FOREIGN KEY FK_9F5E880B979B1AD6');
        $this->addSql('DROP TABLE api_token');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE department_info');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE job_information');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE work_point');
    }
}
