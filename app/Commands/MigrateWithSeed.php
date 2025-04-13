<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MigrateWithSeed extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'custom';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'migrate:freseed';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'This is for migrate refresh and then seed the data';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:name [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        CLI::write('Running migrate:freseed...');

        command('migrate:rollback');
        
        CLI::write('Rollback all migration, run migration');

        command('migrate');

        CLI::write('Migrate Complete, run seed');

        command('db:seed DatabaseSeeder');

        CLI::write('Freseed complete');
    }
}
