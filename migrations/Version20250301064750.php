<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250301064750 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return "";
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function up(Schema $schema): void
    {
        $this->addSql(
            "CREATE TABLE task (
                id INT AUTO_INCREMENT NOT NULL, 
                title VARCHAR(255) NOT NULL, 
                is_done TINYINT(1) DEFAULT 0 NOT NULL, 
                created_at DATETIME NOT NULL, 
                updated_at DATETIME NOT NULL, 
                deleted_at DATETIME DEFAULT NULL, 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB"
        );
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE task");
    }
}
