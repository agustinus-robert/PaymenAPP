<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\StreamOutput;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\TenantSeeder;

class MiniPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installing Applications';

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
     * @return int
     */
    public function handle()
    {
        $app = config('app.name');
        $output = new StreamOutput(fopen('php://output', 'w'));
        $this->call('key:generate');
        $this->line("Running {$app} main migration ...");
        Artisan::call('migrate:fresh', [
            '--database' => 'mysql',
            '--force'    => true,
        ], $output);

        $this->line("Running {$app} main seeders ...");
        Artisan::call('db:seed', [
            '--database' => 'mysql',
            '--force'    => true,
        ], $output);

        $this->callSilently('optimize:clear');

        $this->warn("Migrasi selesai");
        $this->info("Terima kasih, sistem sudah terpasang");

        return 0;
    }

    public function setEnvironmentValue($key, $value)
    {
        $path = app()->environmentFilePath();

        $escaped = preg_quote('=' . env($key), '/');

        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
}
