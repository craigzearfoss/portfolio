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
        Schema::connection('dictionary_db')->create('databases', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->unique();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('abbreviation', 100)->nullable();
            $table->tinyInteger('open_source')->default(0);
            $table->tinyInteger('proprietary')->default(0);
            $table->string('owner', 100)->nullable();
            $table->string('wiki_page')->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->integer('readonly')->default(0);
            $table->integer('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [ 'id' => 1,  'full_name' => 'Access',                   'name' => 'Access',             'slug' => 'access',                   'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://www.microsoft.com/en-us/microsoft-365/access',          'wiki_page' => 'https://en.wikipedia.org/wiki/Microsoft_Access'                   ],
            [ 'id' => 2,  'full_name' => 'Amazon Aurora',            'name' => 'Aurora',             'slug' => 'amazon-aurora',            'abbreviation' => 'Aurora',    'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://aws.amazon.com/rds/aurora/',                            'wiki_page' => 'https://en.wikipedia.org/wiki/Amazon_Aurora'                      ],
            [ 'id' => 3,  'full_name' => 'Amazon DynamoDB',          'name' => 'DynamoDB',           'slug' => 'amazon-dynamodb',          'abbreviation' => 'DynamoDB',  'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://aws.amazon.com/dynamodb/',                              'wiki_page' => 'https://en.wikipedia.org/wiki/Amazon_DynamoDB'                    ],
            [ 'id' => 4,  'full_name' => 'Amazon Redshift',          'name' => 'Redshift',           'slug' => 'amazon-redshift',          'abbreviation' => 'Redshift',  'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://aws.amazon.com/redshift/',                              'wiki_page' => 'https://en.wikipedia.org/wiki/Amazon_Redshift'                    ],
            [ 'id' => 5,  'full_name' => 'Azure Cosmos DB',          'name' => 'Cosmos DB',          'slug' => 'azure-cosmos-db',          'abbreviation' => 'Cosmos DB', 'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://azure.microsoft.com/en-us/products/cosmos-db',          'wiki_page' => 'https://en.wikipedia.org/wiki/Cosmos_DB'                          ],
            [ 'id' => 6,  'full_name' => 'Azure SQL Database',       'name' => 'Azure SQL Database', 'slug' => 'azure-sql-database',       'abbreviation' => 'Azure SQL', 'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://azure.microsoft.com/en-us/products/azure-sql/database', 'wiki_page' => 'https://en.wikipedia.org/wiki/Microsoft_Azure_SQL_Database'       ],
            [ 'id' => 7,  'full_name' => 'BigQuery',                 'name' => 'BigQuery',           'slug' => 'bigquery',                 'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://cloud.google.com/bigquery',                             'wiki_page' => 'https://en.wikipedia.org/wiki/BigQuery'                           ],
            [ 'id' => 8,  'full_name' => 'Bigtable',                 'name' => 'Bigtable',           'slug' => 'bigtable',                 'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => 'Google',           'link' => 'https://cloud.google.com/bigtable',                             'wiki_page' => 'https://en.wikipedia.org/wiki/Bigtable'                           ],
            [ 'id' => 9,  'full_name' => 'Cassandra',                'name' => 'Cassandra',          'slug' => 'cassandra',                'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://cassandra.apache.org/_/index.html',                     'wiki_page' => 'https://en.wikipedia.org/wiki/Apache_Cassandra'                   ],
            [ 'id' => 10, 'full_name' => 'ClickHouse',               'name' => 'ClickHouse',         'slug' => 'clickhouse',               'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://clickhouse.com/',                                       'wiki_page' => 'https://en.wikipedia.org/wiki/ClickHouse'                         ],
            [ 'id' => 11, 'full_name' => 'CloudSQL',                 'name' => 'CloudSQL',           'slug' => 'cloudsql',                 'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => 'Google',           'link' => 'https://cloud.google.com/sql',                                  'wiki_page' => null                                                               ],
            [ 'id' => 12, 'full_name' => 'Databricks',               'name' => 'Databricks',         'slug' => 'databricks',               'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => 'Databricks, Inc.', 'link' => 'https://www.databricks.com/',                                   'wiki_page' => 'https://en.wikipedia.org/wiki/Databricks'                         ],
            [ 'id' => 13, 'full_name' => 'DuckDB',                   'name' => 'DuckDB',             'slug' => 'duckdb',                   'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://duckdb.org/',                                           'wiki_page' => 'https://en.wikipedia.org/wiki/DuckDB'                             ],
            [ 'id' => 14, 'full_name' => 'Elasticsearch',            'name' => 'Elasticsearch',      'slug' => 'elasticsearch',            'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://www.elastic.co/',                                       'wiki_page' => 'https://en.wikipedia.org/wiki/Elasticsearch'                      ],
            [ 'id' => 15, 'full_name' => 'GraphQL',                  'name' => 'GraphQL',            'slug' => 'graphql',                  'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://graphql.org/',                                          'wiki_page' => 'https://en.wikipedia.org/wiki/GraphQL'                            ],
            [ 'id' => 16, 'full_name' => 'Hbase',                    'name' => 'Hbase',              'slug' => 'hbase',                    'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => 'Apache',           'link' => 'https://hbase.apache.org/',                                     'wiki_page' => 'https://en.wikipedia.org/wiki/Apache_Hbase'                       ],
            [ 'id' => 17, 'full_name' => 'InfluxDB',                 'name' => 'InfluxDB',           'slug' => 'influxdb',                 'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://www.influxdata.com/',                                   'wiki_page' => 'https://en.wikipedia.org/wiki/InfluxDB'                           ],
            [ 'id' => 18, 'full_name' => 'MariaDB',                  'name' => 'MariaDB',            'slug' => 'mariadb',                  'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://go.mariadb.com/',                                       'wiki_page' => 'https://en.wikipedia.org/wiki/MariaDB'                            ],
            [ 'id' => 19, 'full_name' => 'MaxDB',                    'name' => 'MaxDB',              'slug' => 'maxdb',                    'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://maxdb.sap.com/',                                        'wiki_page' => 'https://en.wikipedia.org/wiki/MaxDB'                              ],
            [ 'id' => 20, 'full_name' => 'Memcached',                'name' => 'Memcached',          'slug' => 'memcached',                'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://memcached.org/',                                        'wiki_page' => 'https://en.wikipedia.org/wiki/Memcached'                          ],
            [ 'id' => 21, 'full_name' => 'MongoDB',                  'name' => 'MongoDB',            'slug' => 'mongodb',                  'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://www.mongodb.com/',                                      'wiki_page' => 'https://en.wikipedia.org/wiki/MongoDB'                            ],
            [ 'id' => 22, 'full_name' => 'MySQL',                    'name' => 'MySQL',              'slug' => 'mysql',                    'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => 'Oracle',           'link' => 'https://www.mysql.com/',                                        'wiki_page' => 'https://en.wikipedia.org/wiki/MySQL'                              ],
            [ 'id' => 23, 'full_name' => 'NebulaGraph',              'name' => 'NebulaGraph',        'slug' => 'nebulagraph',              'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://www.nebula-graph.io/',                                  'wiki_page' => 'https://en.wikipedia.org/wiki/Oracle_Database'                    ],
            [ 'id' => 24, 'full_name' => 'Neutron Monitor Database', 'name' => 'NMDB',               'slug' => 'neutron-monitor-database', 'abbreviation' => 'NMDB',      'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://www.nmdb.eu/',                                          'wiki_page' => 'https://en.wikipedia.org/wiki/Real-time_Neutron_Monitor_Database' ],
            [ 'id' => 25, 'full_name' => 'Oracle',                   'name' => 'Oracle',             'slug' => 'oracle',                   'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => 'Oracle',           'link' => 'https://www.oracle.com/',                                       'wiki_page' => 'https://en.wikipedia.org/wiki/Oracle_Database'                    ],
            [ 'id' => 26, 'full_name' => 'PostgreSQL',               'name' => 'PostgreSQL',         'slug' => 'postgresql',               'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://www.postgresql.org/',                                   'wiki_page' => 'https://en.wikipedia.org/wiki/PostgreSQL'                         ],
            [ 'id' => 27, 'full_name' => 'Prefect',                  'name' => 'Prefect',            'slug' => 'prefect',                  'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://www.prefect.io/',                                       'wiki_page' => null                                                               ],
            [ 'id' => 28, 'full_name' => 'RavenDB',                  'name' => 'RavenDB',            'slug' => 'ravendb',                  'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://ravendb.net/',                                          'wiki_page' => 'https://en.wikipedia.org/wiki/RavenDB'                            ],
            [ 'id' => 29, 'full_name' => 'Redis',                    'name' => 'Redis',              'slug' => 'redis',                    'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://redis.io/',                                             'wiki_page' => 'https://en.wikipedia.org/wiki/Redis'                              ],
            [ 'id' => 30, 'full_name' => 'ScyllaDB',                 'name' => 'ScyllaDB',           'slug' => 'scylladb',                 'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://www.scylladb.com/',                                     'wiki_page' => 'https://en.wikipedia.org/wiki/ScyllaDB'                           ],
            [ 'id' => 31, 'full_name' => 'Snowflake',                'name' => 'Snowflake',          'slug' => 'snowflake',                'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://www.snowflake.com/en/',                                 'wiki_page' => 'https://en.wikipedia.org/wiki/Snowflake_Inc.'                     ],
            [ 'id' => 32, 'full_name' => 'SQL Server',               'name' => 'MSSQL',              'slug' => 'sql-server',               'abbreviation' => 'MSSQL',     'open_source' => 0, 'proprietary' => 0, 'owner' => 'Microsoft',        'link' => 'https://www.microsoft.com/en-us/sql-server',                    'wiki_page' => 'https://en.wikipedia.org/wiki/Microsoft_SQL_Server'               ],
            [ 'id' => 33, 'full_name' => 'SQLite',                   'name' => 'SQLite',             'slug' => 'sqlite',                   'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://sqlite.org/',                                           'wiki_page' => 'https://en.wikipedia.org/wiki/SQLite'                             ],
            [ 'id' => 34, 'full_name' => 'Venice',                   'name' => 'Venice',             'slug' => 'venice',                   'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://venicedb.org/',                                         'wiki_page' => null                                                               ],
            [ 'id' => 35, 'full_name' => 'Vitess',                   'name' => 'Vitess',             'slug' => 'vitess',                   'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://vitess.io/',                                            'wiki_page' => null                                                               ],
            [ 'id' => 36, 'full_name' => 'Presto',                   'name' => 'Presto',             'slug' => 'prestos',                  'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => 'https://prestodb.io/',                                          'wiki_page' => 'https://en.wikipedia.org/wiki/Presto_(SQL_query_engine)'          ],
            [ 'id' => 37, 'full_name' => 'other',                    'name' => 'other',              'slug' => 'other',                    'abbreviation' => null,        'open_source' => 0, 'proprietary' => 0, 'owner' => null,               'link' => null,                                                            'wiki_page' => null                                                               ],
        ];

        \App\Models\Dictionary\Database::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('dictionary_db')->dropIfExists('databases');
    }
};
