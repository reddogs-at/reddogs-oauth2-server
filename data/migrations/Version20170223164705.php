<?php

namespace Reddogs\OAuth2\Server\Entity;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170223164705 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->createTable('reddogs_oauth2_server_auth_code_scope');
        $table->addColumn('auth_code_id', 'bigint', ['unsigned' => true]);
        $table->addColumn('scope_id', 'bigint', ['unsigned' => true]);

        $table->setPrimaryKey(['auth_code_id', 'scope_id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('reddogs_oauth2_server_auth_code_scope');
    }
}
