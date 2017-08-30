<?php

namespace App\Console\Commands;

use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class TestElaticsearchQuery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:query';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test search for elaticsearch';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = ClientBuilder::create()->setHosts(config('elasticsearch.hosts.local'))->build();
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id'
        ];

        $response = $client->get($params);
        print_r($response);
    }
}
