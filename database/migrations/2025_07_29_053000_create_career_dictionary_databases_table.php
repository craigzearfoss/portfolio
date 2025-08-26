<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('career_db')->create('dictionary_databases', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->unique();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('abbreviation', 100)->nullable();
            $table->tinyInteger('open_source')->default(0);
            $table->tinyInteger('proprietary')->default(0);
            $table->string('owner', 100)->nullable();
            $table->string('website')->nullable();
            $table->string('wiki_page')->nullable();
            $table->text('description')->nullable();
        });

        $data = [
            [ 'id' => 1,  'name' => 'Access',             'full_name' => 'Access',                   'slug' => 'access',                   'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://www.microsoft.com/en-us/microsoft-365/access', 'wiki_page' => 'https://en.wikipedia.org/wiki/Microsoft_Access' ],
            [ 'id' => 2,  'name' => 'Aurora',             'full_name' => 'Amazon Aurora',            'slug' => 'amazon-aurora',            'abbreviation' => 'Aurora',    'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://aws.amazon.com/rds/aurora/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Amazon_Aurora' ],
            [ 'id' => 3,  'name' => 'DynamoDB',           'full_name' => 'Amazon DynamoDB',          'slug' => 'amazon-dynamodb',          'abbreviation' => 'DynamoDB',  'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://aws.amazon.com/dynamodb/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Amazon_DynamoDB' ],
            [ 'id' => 4,  'name' => 'Redshift',           'full_name' => 'Amazon Redshift',          'slug' => 'amazon-redshift',          'abbreviation' => 'Redshift',  'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://aws.amazon.com/redshift/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Amazon_Redshift' ],
            [ 'id' => 5,  'name' => 'Cosmos DB',          'full_name' => 'Azure Cosmos DB',          'slug' => 'azure-cosmos-db',          'abbreviation' => 'Cosmos DB', 'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://azure.microsoft.com/en-us/products/cosmos-db', 'wiki_page' => 'https://en.wikipedia.org/wiki/Cosmos_DB' ],
            [ 'id' => 6,  'name' => 'Azure SQL Database', 'full_name' => 'Azure SQL Database',       'slug' => 'azure-sql-database',       'abbreviation' => 'Azure SQL', 'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://azure.microsoft.com/en-us/products/azure-sql/database', 'wiki_page' => 'https://en.wikipedia.org/wiki/Microsoft_Azure_SQL_Database' ],
            [ 'id' => 7,  'name' => 'BigQuery',           'full_name' => 'BigQuery',                 'slug' => 'bigquery',                 'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://cloud.google.com/bigquery', 'wiki_page' => 'https://en.wikipedia.org/wiki/BigQuery' ],
            [ 'id' => 8,  'name' => 'Bigtable',           'full_name' => 'Bigtable',                 'slug' => 'bigtable',                 'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => 'Google',           'website' => 'https://cloud.google.com/bigtable', 'wiki_page' => 'https://en.wikipedia.org/wiki/Bigtable' ],
            [ 'id' => 9,  'name' => 'Cassandra',          'full_name' => 'Cassandra',                'slug' => 'cassandra',                'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://cassandra.apache.org/_/index.html', 'wiki_page' => 'https://en.wikipedia.org/wiki/Apache_Cassandra' ],
            [ 'id' => 10, 'name' => 'ClickHouse',         'full_name' => 'ClickHouse',               'slug' => 'clickhouse',               'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://clickhouse.com/', 'wiki_page' => 'https://en.wikipedia.org/wiki/ClickHouse' ],
            [ 'id' => 11, 'name' => 'CloudSQL',           'full_name' => 'CloudSQL',                 'slug' => 'cloudsql',                 'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => 'Google',           'website' => 'https://cloud.google.com/sql', 'wiki_page' => '' ],
            [ 'id' => 12, 'name' => 'Databricks',         'full_name' => 'Databricks',               'slug' => 'databricks',               'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => 'Databricks, Inc.', 'website' => 'https://www.databricks.com/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Databricks' ],
            [ 'id' => 13, 'name' => 'DuckDB',             'full_name' => 'DuckDB',                   'slug' => 'duckdb',                   'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://duckdb.org/', 'wiki_page' => 'https://en.wikipedia.org/wiki/DuckDB' ],
            [ 'id' => 14, 'name' => 'Elasticsearch',      'full_name' => 'Elasticsearch',            'slug' => 'elasticsearch',            'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://www.elastic.co/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Elasticsearch' ],
            [ 'id' => 15, 'name' => 'GraphQL',            'full_name' => 'GraphQL',                  'slug' => 'graphql',                  'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://graphql.org/', 'wiki_page' => 'https://en.wikipedia.org/wiki/GraphQL' ],
            [ 'id' => 16, 'name' => 'Hbase',              'full_name' => 'Hbase',                    'slug' => 'hbase',                    'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => 'Apache',           'website' => 'https://hbase.apache.org/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Apache_Hbase' ],
            [ 'id' => 17, 'name' => 'InfluxDB',           'full_name' => 'InfluxDB',                 'slug' => 'influxdb',                 'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://www.influxdata.com/', 'wiki_page' => 'https://en.wikipedia.org/wiki/InfluxDB' ],
            [ 'id' => 18, 'name' => 'MariaDB',            'full_name' => 'MariaDB',                  'slug' => 'mariadb',                  'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://go.mariadb.com/', 'wiki_page' => 'https://en.wikipedia.org/wiki/MariaDB' ],
            [ 'id' => 19, 'name' => 'MaxDB',              'full_name' => 'MaxDB',                    'slug' => 'maxdb',                    'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://maxdb.sap.com/', 'wiki_page' => 'https://en.wikipedia.org/wiki/MaxDB' ],
            [ 'id' => 20, 'name' => 'Memcached',          'full_name' => 'Memcached',                'slug' => 'memcached',                'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://memcached.org/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Memcached' ],
            [ 'id' => 21, 'name' => 'MongoDB',            'full_name' => 'MongoDB',                  'slug' => 'mongodb',                  'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://www.mongodb.com/', 'wiki_page' => 'https://en.wikipedia.org/wiki/MongoDB' ],
            [ 'id' => 22, 'name' => 'MySQL',              'full_name' => 'MySQL',                    'slug' => 'mysql',                    'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => 'Oracle',           'website' => 'https://www.mysql.com/', 'wiki_page' => 'https://en.wikipedia.org/wiki/MySQL' ],
            [ 'id' => 23, 'name' => 'NebulaGraph',        'full_name' => 'NebulaGraph',              'slug' => 'nebulagraph',              'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://www.nebula-graph.io/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Oracle_Database' ],
            [ 'id' => 24, 'name' => 'NMDB',               'full_name' => 'Neutron Monitor Database', 'slug' => 'neutron-monitor-database', 'abbreviation' => 'NMDB',      'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://www.nmdb.eu/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Real-time_Neutron_Monitor_Database' ],
            [ 'id' => 25, 'name' => 'Oracle',             'full_name' => 'Oracle',                   'slug' => 'oracle',                   'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => 'Oracle',           'website' => 'https://www.oracle.com/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Oracle_Database' ],
            [ 'id' => 26, 'name' => 'PostgreSQL',         'full_name' => 'PostgreSQL',               'slug' => 'postgresql',               'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://www.postgresql.org/', 'wiki_page' => 'https://en.wikipedia.org/wiki/PostgreSQL' ],
            [ 'id' => 27, 'name' => 'Prefect',            'full_name' => 'Prefect',                  'slug' => 'prefect',                  'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://www.prefect.io/', 'wiki_page' => '' ],
            [ 'id' => 28, 'name' => 'RavenDB',            'full_name' => 'RavenDB',                  'slug' => 'ravendb',                  'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://ravendb.net/', 'wiki_page' => 'https://en.wikipedia.org/wiki/RavenDB' ],
            [ 'id' => 29, 'name' => 'Redis',              'full_name' => 'Redis',                    'slug' => 'redis',                    'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://redis.io/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Redis' ],
            [ 'id' => 30, 'name' => 'ScyllaDB',           'full_name' => 'ScyllaDB',                 'slug' => 'scylladb',                 'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://www.scylladb.com/', 'wiki_page' => 'https://en.wikipedia.org/wiki/ScyllaDB' ],
            [ 'id' => 31, 'name' => 'Snowflake',          'full_name' => 'Snowflake',                'slug' => 'snowflake',                'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://www.snowflake.com/en/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Snowflake_Inc.' ],
            [ 'id' => 32, 'name' => 'MSSQL',              'full_name' => 'SQL Server',               'slug' => 'sql-server',               'abbreviation' => 'MSSQL',     'open_source' => 0, 'proprietary' => 0, 'owner' => 'Microsoft',        'website' => 'https://www.microsoft.com/en-us/sql-server', 'wiki_page' => 'https://en.wikipedia.org/wiki/Microsoft_SQL_Server' ],
            [ 'id' => 33, 'name' => 'SQLite',             'full_name' => 'SQLite',                   'slug' => 'sqlite',                   'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://sqlite.org/', 'wiki_page' => 'https://en.wikipedia.org/wiki/SQLite' ],
            [ 'id' => 34, 'name' => 'Venice',             'full_name' => 'Venice',                   'slug' => 'venice',                   'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://venicedb.org/', 'wiki_page' => '' ],
            [ 'id' => 35, 'name' => 'Vitess',             'full_name' => 'Vitess',                   'slug' => 'vitess',                   'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://vitess.io/', 'wiki_page' => '' ],
            [ 'id' => 36, 'name' => 'Presto',             'full_name' => 'Presto',                   'slug' => 'prestos',                  'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'website' => 'https://prestodb.io/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Presto_(SQL_query_engine)' ],
        ];

        App\Models\Career\DictionaryDatabase::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('dictionary_databases');
    }
};
