<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250806084404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cui VARCHAR(255) NOT NULL, year_created INT NOT NULL, parent_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, department_id INT NOT NULL, work_point_id INT NOT NULL, INDEX IDX_CD1DE18AAE80F5DF (department_id), INDEX IDX_CD1DE18A159D44FE (work_point_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE department_info (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, salary INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, job_type_id INT NOT NULL, department_id INT NOT NULL, INDEX IDX_FBD8E0F85FA33B08 (job_type_id), INDEX IDX_FBD8E0F8AE80F5DF (department_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE job_information (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE work_point (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) NOT NULL, county VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, program_start TIME NOT NULL, program_end TIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, company_id INT NOT NULL, INDEX IDX_9F5E880B979B1AD6 (company_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18AAE80F5DF FOREIGN KEY (department_id) REFERENCES department_info (id)');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A159D44FE FOREIGN KEY (work_point_id) REFERENCES work_point (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F85FA33B08 FOREIGN KEY (job_type_id) REFERENCES job_information (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE work_point ADD CONSTRAINT FK_9F5E880B979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18AAE80F5DF');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18A159D44FE');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F85FA33B08');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8AE80F5DF');
        $this->addSql('ALTER TABLE work_point DROP FOREIGN KEY FK_9F5E880B979B1AD6');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE department_info');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE job_information');
        $this->addSql('DROP TABLE work_point');
    }
}
