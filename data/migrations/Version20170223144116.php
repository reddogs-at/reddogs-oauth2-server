<?php

namespace Reddogs\OAuth2\Server\Entity;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170223144116 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->createTable('reddogs_oauth2_server_refresh_token');
        $table->addColumn('id', 'bigint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('identifier', 'string', ['length' => 40]);
        $table->addColumn('access_token_id', 'bigint', ['unsigned' => true]);
        $table->addColumn('expiry_date_time', 'datetime');

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['identifier']);
        $table->addIndex(['access_token_id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('reddogs_oauth2_server_refresh_token');
    }
}
