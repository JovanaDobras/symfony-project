<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511075052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2519EB6921');
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, avatar VARCHAR(255) NOT NULL, client_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, payment_method VARCHAR(255) NOT NULL, bank_acount VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_client (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, client_id INT NOT NULL, month DATETIME NOT NULL, time TIME NOT NULL, INDEX IDX_A2161F68A76ED395 (user_id), INDEX IDX_A2161F6819EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_client ADD CONSTRAINT FK_A2161F68A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_client ADD CONSTRAINT FK_A2161F6819EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE task');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_client DROP FOREIGN KEY FK_A2161F6819EB6921');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, avatar VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, client_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, payment_method VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, bank_acount VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, client_id INT NOT NULL, month DATETIME NOT NULL, time TIME NOT NULL, INDEX IDX_527EDB2519EB6921 (client_id), INDEX IDX_527EDB25A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE user_client');
    }
}
