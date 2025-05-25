<?php

namespace App\Console\Commands;

use App\Models\Server;
use App\Models\HostingAccount;
use Illuminate\Console\Command;

class FixServerAccountCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:fix-server-counts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix server current_accounts counts by recalculating from hosting accounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing server account counts...');

        $servers = Server::all();
        $fixed = 0;

        foreach ($servers as $server) {
            $actualCount = HostingAccount::where('server_id', $server->id)->count();

            if ($server->current_accounts !== $actualCount) {
                $this->warn("Server '{$server->name}': stored={$server->current_accounts}, actual={$actualCount}");
                $server->update(['current_accounts' => $actualCount]);
                $fixed++;
            }
        }

        if ($fixed > 0) {
            $this->info("Fixed {$fixed} server(s) with incorrect account counts.");
        } else {
            $this->info('All server account counts are correct.');
        }

        return 0;
    }
}
