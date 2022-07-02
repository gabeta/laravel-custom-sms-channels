<?php

namespace Gabeta\CustomSmsChannels\Console\Commands;

use Gabeta\CustomSmsChannels\WebSocketsServerMessage;
use Illuminate\Console\Command;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class StartServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customsms:serve {--host=0.0.0.0} {--port=6001}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the CustomSmsChannel server.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Starting the CustomSmsChannel server on port {$this->option('port')}...");

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new WebSocketsServerMessage()
                )
            ),
            $this->option('port'),
            $this->option('host'),
        );

        $server->run();
    }
}
