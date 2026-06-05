<?php

namespace App\Providers;

use App\Support\Livewire\Decomposer as LivewireDecomposer;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Livewire;
use ReflectionClass;
use Symfony\Component\Finder\SplFileInfo;

class LivewireComponentServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerModuleLivewireComponents();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    protected function registerModuleLivewireComponents()
    {
        if (LivewireDecomposer::checkDependencies(['livewire/livewire'])->type == 'error') {
            return false;
        }
        $modules = collect(config('modules-livewire.custom_modules', []));
        $modules->each(function ($module, $moduleName) {
            $moduleLivewireNamespace = $module['namespace'] ?? config('modules-livewire.namespace', 'Livewire');
            $directory = (string) Str::of($module['path'] ?? '')
                ->append('/Http/' . $moduleLivewireNamespace)
                ->replace(['\\'], '/');
            $namespace = ($module['module_namespace'] ?? $moduleName) . '\\Http\\' . $moduleLivewireNamespace;
            $lowerName = $module['name_lower'] ?? strtolower($moduleName);

            $this->registerComponentDirectory($directory, $namespace, $lowerName . '::');
        });
    }

    /**
     * Register component directory.
     *
     * @param string $directory
     * @param string $namespace
     * @param string $aliasPrefix
     *
     * @return void
     */
    protected function registerComponentDirectory($directory, $namespace, $aliasPrefix = ''): void
    {
        $filesystem = new Filesystem();

       // Log::info($namespace);

        if (!$filesystem->isDirectory($directory)) {
       //     Log::info(!$filesystem->isDirectory($directory) ? 'break in this line' : 'next to function');
            return;
        }

        collect($filesystem->allFiles($directory))
            ->map(fn (SplFileInfo $file) => Str::of($namespace)
                ->append("\\{$file->getRelativePathname()}")
                ->replace(['/', '.php'], ['\\', ''])
                ->toString())
            ->filter(fn ($class) => (is_subclass_of($class, Component::class) && !(new ReflectionClass($class))->isAbstract()))
            ->each(fn ($class) => $this->registerSingleComponent($class, $namespace, $aliasPrefix));
    }

    /**
     * Register livewire single component.
     *
     * @param string $class
     * @param string $namespace
     * @param string $aliasPrefix
     *
     * @return void
     */
    private function registerSingleComponent(string $class, string $namespace, string $aliasPrefix): void
    {
      //  Log::info($class);

        $alias = $aliasPrefix . Str::of($class)
            ->after($namespace . '\\')
            ->replace(['/', '\\'], '.')
            ->explode('.')
            ->map([Str::class, 'kebab'])
            ->implode('.');

        Str::endsWith($class, ['\Index', '\index'])
            ? Livewire::component(Str::beforeLast($alias, '.index'), $class)
            : Livewire::component($alias, $class);

        // Inside the registerComponentDirectory method
       // Log::info('Registering Livewire component: ' . $alias . ' => ' . $class);
    }
}
