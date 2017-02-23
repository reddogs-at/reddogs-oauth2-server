<?php

namespace Reddogs\OAuth2\Server\Entity;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170223133253 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->createTable('reddogs_oauth2_server_access_token_scope');
        $table->addColumn('access_token_id', 'bigint', ['unsigned' => true]);
        $table->addColumn('scope_id', 'bigint', ['unsigned' => true]);

        $table->setPrimaryKey(['access_token_id', 'scope_id']);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }
}
