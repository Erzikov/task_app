<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180808145451 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tblProductData ADD stock INT NOT NULL, ADD cost DOUBLE PRECISION NOT NULL, CHANGE intProductDataId intProductDataId INT AUTO_INCREMENT NOT NULL, CHANGE strProductName strProductName VARCHAR(255) NOT NULL, CHANGE strProductCode strProductCode VARCHAR(255) NOT NULL, CHANGE dtmAdded dtmAdded DATETIME NOT NULL, CHANGE dtmDiscontinued dtmDiscontinued DATE DEFAULT NULL, CHANGE stmTimestamp stmTimestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tblProductData RENAME INDEX strproductcode TO UNIQ_2C11248662F10A58');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tblProductData DROP stock, DROP cost, CHANGE intProductDataId intProductDataId INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE strProductCode strProductCode VARCHAR(10) NOT NULL COLLATE latin1_swedish_ci, CHANGE strProductName strProductName VARCHAR(50) NOT NULL COLLATE latin1_swedish_ci, CHANGE dtmDiscontinued dtmDiscontinued DATETIME DEFAULT NULL, CHANGE dtmAdded dtmAdded DATETIME DEFAULT NULL, CHANGE stmTimestamp stmTimestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE tblProductData RENAME INDEX uniq_2c11248662f10a58 TO strProductCode');
    }
}
