<?php namespace Dietercoopman\SajanPhp\Services;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Comparator;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaDiff;
use Illuminate\Support\Collection;
use function Termwind\{render};

class DatabaseManager
{

    private                            $config;
    private Connection|null            $sourceConnection = null;
    private Connection|null            $targetConnection = null;
    private AbstractSchemaManager|null $sourceSchema;
    private AbstractSchemaManager|null $targetSchema;

    public function __construct($sourceConfig, $targetConfig)
    {

        $this->config['source'] = $this->validateForMysql($sourceConfig, 'source');
        $this->config['target'] = $this->validateForMysql($targetConfig, 'target');
    }


    public function compare($sourceDatabase, $targetDatabase): array
    {
        $this->sourceConnection = $this->targetConnection = null;
        $this->sourceSchema     = $this->targetSchema = null;

        $this->config['source']['dbname'] = $sourceDatabase;
        $this->config['target']['dbname'] = $targetDatabase;

        $sourceSchema = $this->getSchemaManager('source', true);
        $targetSchema = $this->getSchemaManager('target', true);


        $schemaDiff = $targetSchema->createComparator()->compareSchemas($targetSchema->introspectSchema(), $sourceSchema->introspectSchema());

        $databasePlatform = $this->targetConnection->getDatabasePlatform();
        return $databasePlatform->getAlterSchemaSQL($schemaDiff);

    }

    public function getDatabases($connectionName): array
    {
        return $this->getSchemaManager($connectionName)->listDatabases();
    }

    public function getSchemaManager($connectionName, $renewConnection = false): AbstractSchemaManager
    {
        if (!isset($this->{$connectionName . "Schema"}) || $renewConnection) {
            $this->{$connectionName . "Schema"} = $this->getConnection($connectionName, $renewConnection)->createSchemaManager();
        }

        return $this->{$connectionName . "Schema"};
    }

    public function getConnection($connectionName, $renewConnection = false): Connection
    {
        if (empty($this->{$connectionName . "Connection"}) || $renewConnection) {
            $connection = $this->config[$connectionName];
            if (!$renewConnection) {

                if (isset($connection['mysql_ssh']) && $connection['mysql_ssh'] == "y") {
                    render('<div class="ml-1 mt-1">Establishing ' . $connectionName . ' connection over ssh with ' . $connection['ssh'] . ' 🔐</div>');
                    exec('ssh -i '.$connection['keyfile'].' -f -L ' . $connection['port'] . ':127.0.0.1:3306 ' . $connection['ssh'] . ' sleep 10 > /dev/null');
                } else {
                    render('<div class="ml-1">Establishing ' . $connectionName . ' connection</div>');
                }
            }

            $this->{$connectionName . "Connection"} = \Doctrine\DBAL\DriverManager::getConnection($connection);
            $databasePlatform                       = $this->{$connectionName . "Connection"}->getDatabasePlatform();
            $databasePlatform->registerDoctrineTypeMapping('enum', 'string');
        }

        return $this->{$connectionName . "Connection"};

    }

    private function validateForMysql($config, $type): array
    {
        $mysqlConfig = [];
        if ($config['mysql_ssh'] == "y") {
            $ports               = ['source' => 13333, 'target' => 13334];
            $mysqlConfig['port'] = $ports[$type];
            $mysqlConfig['ssh']  = $config['username'] . '@' . $config['host'];
            $mysqlConfig['host'] = "127.0.0.1";
            $mysqlConfig['keyfile'] = $config['keyfile'];
        } else {
            $mysqlConfig['host'] = $config['host'];
            $mysqlConfig['port'] = $config['mysql_port'];
        }
        $mysqlConfig['database'] = $config['database'] ?? '';
        $mysqlConfig['driver']   = 'pdo_mysql';
        $mysqlConfig['user']     = $config['mysql_user'];
        $mysqlConfig['password'] = $config['mysql_password'];

        $mysqlConfig['mysql_ssh'] = $config['mysql_ssh'];
        return $mysqlConfig;
    }
}
