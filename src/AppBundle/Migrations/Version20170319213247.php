<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170319213247 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C793CB796C');
        $this->addSql('ALTER TABLE properties CHANGE financing financing TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C793CB796C FOREIGN KEY (file_id) REFERENCES files (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C793CB796C');
        $this->addSql('ALTER TABLE properties CHANGE financing financing INT NOT NULL');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C793CB796C FOREIGN KEY (file_id) REFERENCES files (id) ON DELETE CASCADE');
    }
}
