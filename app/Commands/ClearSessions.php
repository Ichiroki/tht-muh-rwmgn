<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ClearSessions extends BaseCommand
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
    protected $name = 'clear:sessions';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Delete all session file in writable/session';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'clear:sessions [arguments] [options]';

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
        $files = glob(WRITEPATH . 'session/*');
        foreach ($files as $file) {
            if(is_file($file)) {
                unlink($file);
            }
        }

        CLI::write('All sessions successfully deleted');
    }
}
