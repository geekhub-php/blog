<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170118051043 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post CHANGE dataCreate dataCreate DATE NOT NULL, CHANGE dataEdit dataEdit DATE NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE dataCreate dataCreate DATE NOT NULL');
        $this->addSql('ALTER TABLE comment CHANGE date date DATE NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment CHANGE date date VARCHAR(10) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE post CHANGE dataCreate dataCreate VARCHAR(10) NOT NULL COLLATE utf8_unicode_ci, CHANGE dataEdit dataEdit VARCHAR(10) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE dataCreate dataCreate VARCHAR(10) NOT NULL COLLATE utf8_unicode_ci');
    }
}
