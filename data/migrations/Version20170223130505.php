<?php

namespace Reddogs\OAuth2\Server\Entity;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170223130505 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->createTable('reddogs_oauth2_server_access_token');
        $table->addColumn('id', 'bigint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('identifier', 'string', ['length' => 40]);
        $table->addColumn('user_identifier', 'string', ['length' => 40]);
        $table->addColumn('expiry_date_time', 'datetime');
        $table->addColumn('client_id', 'bigint', ['unsigned' => true]);

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['identifier']);
        $table->addIndex(['client_id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $table = $schema->dropTable('reddogs_oauth2_server_access_token');
    }
}
