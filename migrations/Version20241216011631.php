<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241216011631 extends AbstractMigration
{
    /**
     * {@inheritDoc}
     */
    public function getDescription(): string
    {
        return 'init';
    }

    /**
     * {@inheritDoc}
     */
    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE app_user (
                id INT AUTO_INCREMENT NOT NULL, 
                email VARCHAR(180) NOT NULL, 
                password VARCHAR(255) NOT NULL, 
                roles JSON NOT NULL, 
                UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');

        $this->addSql('
            CREATE TABLE type (
                id INT AUTO_INCREMENT NOT NULL, 
                label VARCHAR(100) NOT NULL, 
                UNIQUE INDEX UNIQ_8CDE5729EA750E8 (label), PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');

        $this->addSql('
            CREATE TABLE vehicle (
                id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', 
                type_id INT DEFAULT NULL, label VARCHAR(150) NOT NULL, 
                brand VARCHAR(150) NOT NULL, seats_amount INT NOT NULL, 
                color VARCHAR(50) DEFAULT NULL, 
                gvwr DOUBLE PRECISION DEFAULT NULL, 
                UNIQUE INDEX UNIQ_1B80E486EA750E8 (label), 
                INDEX IDX_1B80E486C54C8C93 (type_id), PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');

        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
    }

    /**
     * {@inheritDoc}
     */
    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486C54C8C93');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE vehicle');
    }
}
