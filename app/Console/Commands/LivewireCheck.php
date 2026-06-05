<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Livewire\Livewire;
use ReflectionClass;

class LivewireCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livewire:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all registered Livewire components';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Use reflection to access the private or protected properties
        $livewireManager = Livewire::getFacadeRoot();
        $reflection = new ReflectionClass($livewireManager);

        // Find the component registry property (this might vary based on Livewire version)
        $properties = $reflection->getProperties();


        foreach ($properties as $property) {
            $property->setAccessible(true);
            if (is_array($property->getValue($livewireManager))) {
                $components = $property->getValue($livewireManager);
                foreach ($components as $alias => $componentClass) {
                    $this->line("Alias: $alias => Class: $componentClass");
                }
                return;
            }
        }

        Log::info('No Livewire components registered or unable to find the registry.');
    }
}
