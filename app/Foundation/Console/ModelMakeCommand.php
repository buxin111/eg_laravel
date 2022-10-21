<?php

namespace App\Foundation\Console;

use Doctrine\DBAL\Exception;
use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * @author buxin
 * @date 2022-09-29
 * @package App\Foundation\Console
 */
class ModelMakeCommand extends GeneratorCommand
{
    use CreatesMatchingTest;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false && !$this->option('force')) {
            return false;
        }

        if ($this->option('all')) {
            $this->input->setOption('factory', true);
            $this->input->setOption('seed', true);
            $this->input->setOption('migration', true);
            $this->input->setOption('controller', true);
            $this->input->setOption('policy', true);
            $this->input->setOption('resource', true);
        }

        if ($this->option('factory')) {
            $this->createFactory();
        }

        if ($this->option('migration')) {
            $this->createMigration();
        }

        if ($this->option('seed')) {
            $this->createSeeder();
        }

        if ($this->option('controller') || $this->option('resource') || $this->option('api')) {
            $this->createController();
        }

        if ($this->option('policy')) {
            $this->createPolicy();
        }
    }

    /**
     * Create a model factory for the model.
     *
     * @return void
     */
    protected function createFactory()
    {
        $factory = Str::studly($this->argument('name'));

        $this->call('make:factory', [
            'name' => "{$factory}Factory",
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createMigration()
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));

        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    /**
     * Create a seeder file for the model.
     *
     * @return void
     */
    protected function createSeeder()
    {
        $seeder = Str::studly(class_basename($this->argument('name')));

        $this->call('make:seeder', [
            'name' => "{$seeder}Seeder",
        ]);
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('make:controller', array_filter([
            'name' => "{$controller}Controller",
            '--model' => $this->option('resource') || $this->option('api') ? $modelName : null,
            '--api' => $this->option('api'),
            '--requests' => $this->option('requests') || $this->option('all'),
        ]));
    }

    /**
     * Create a policy file for the model.
     *
     * @return void
     */
    protected function createPolicy()
    {
        $policy = Str::studly(class_basename($this->argument('name')));

        $this->call('make:policy', [
            'name' => "{$policy}Policy",
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->option('pivot')
            ? $this->resolveStubPath('/stubs/model.pivot.stub')
            : $this->resolveStubPath('/stubs/model.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param string $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return is_dir(app_path('Models')) ? $rootNamespace . '\\Models' : $rootNamespace;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a migration, seeder, factory, policy, and resource controller for the model'],
            ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the model'],
            ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the model'],
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the model'],
            ['policy', null, InputOption::VALUE_NONE, 'Create a new policy for the model'],
            ['seed', 's', InputOption::VALUE_NONE, 'Create a new seeder for the model'],
            ['pivot', 'p', InputOption::VALUE_NONE, 'Indicates if the generated model should be a custom intermediate table model'],
            ['resource', 'r', InputOption::VALUE_NONE, 'Indicates if the generated controller should be a resource controller'],
            ['api', null, InputOption::VALUE_NONE, 'Indicates if the generated controller should be an API controller'],
            ['requests', 'R', InputOption::VALUE_NONE, 'Create new form request classes and use them in the resource controller'],
        ];
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @return string
     *
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceNotes($stub, $name)->replaceClass($stub, $name);
    }


    /**
     * 获取model 注释
     * @author buxin
     * @date 2022-09-29
     * @throws \Doctrine\DBAL\Exception
     * @throws \ReflectionException
     * @return string
     */
    public function getNotes()
    {
        $tableName = $this->getTableName();

        $columns = Schema::getConnection()->getDoctrineSchemaManager()->listTableColumns($tableName);

        if (!$columns) {
            exit($this->error('table does not exit'));
        }

        $notes = "";

        foreach ($columns as $column) {

            $columnType = str_contains($this->accessProtected($column, '_type')->getName(), 'int') ? 'integer' : 'string';

            $columnName = $this->accessProtected($column, '_name');

            $columnComment = trim($this->accessProtected($column, '_comment'));

            $notes .= sprintf(" * @property %s %s %s\r\n", $columnType, $columnName, $columnComment);

        }

        return substr($notes,0,-2);

    }

    /**
     * 访问为受保护的变量
     * @author buxin
     * @date 2022-09-29
     * @param $obj
     * @param $prop
     * @throws \ReflectionException
     * @return mixed
     */
    public function accessProtected($obj, $prop)
    {
        $reflection = new \ReflectionClass($obj);

        $property = $reflection->getProperty($prop);

        $property->setAccessible(true);

        return $property->getValue($obj);
    }

    /**
     * 替换注释
     * @author buxin
     * @date 2022-09-29
     * @param $stub
     * @param $name
     * @throws Exception
     * @throws \ReflectionException
     * @return $this
     */
    public function replaceNotes(&$stub, $name)
    {
        $tableInfo = Schema::getConnection()->getDoctrineSchemaManager()->listTableDetails($this->getTableName());

        $notes = $this->getNotes();

        $author = getenv('AUTHOR');

        $date = date('Y-m-d');

        $tableComment = $this->accessProtected($tableInfo,'_options')['comment'];

        $searches = [
            ['{{table_comment}}','{{notes}}', '{{author}}', '{{date}}', '{{name}}'],
            ['{{ table_comment }}','{{ notes }}', '{{ author }}', '{{ date }}', '{{ name }}'],
        ];

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                [$tableComment,$notes, $author, $date, $name],
                $stub
            );
        }

        return $this;

    }

    /**
     * 获取表名称
     * @author buxin
     * @date 2022-09-29
     * @return string
     */
    public function getTableName()
    {
        return Str::snake($this->argument('name'));
    }
}
