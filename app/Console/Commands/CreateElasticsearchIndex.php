<?php

namespace App\Console\Commands;

use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class CreateElasticsearchIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create index for elaticsearch';

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
            'index' => 'zhihu',
            'type' => 'question',
            'id' => 'my_id',
            'body' => ['testField' => 'abc']
        ];

        $response = $client->index($params);
        print_r($response);
    }
}
