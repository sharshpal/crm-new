<?php

namespace App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

class CrmCommand extends Command
{
    /**
     * The console command parameter Verbose.
     *
     * @var bool
     */
    protected $verbose = false;

    /**
     * The console progress bar.
     *
     * @var string
     */
    protected $progress = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /*
    protected function installNpm() {
        $npm = new Process(["npm", "install", php_uname('s') == 'Linux' ? "--no-optional" : ""]);
        $npm->setTimeout(0);
        $npm->run(function ($type, $buffer) {
            if (!$this->verbose) return;
            if (Process::ERR === $type) $this->line("\r\n" . $buffer);
            else $this->info("\r\n" . $buffer);
        });
        unset($npm);
    }

    protected function installYarn() {
        $yarn = new Process(["yarn", "install"]);
        $yarn->setTimeout(0);
        $yarn->run(function ($type, $buffer) {
            if (!$this->verbose) return;
            if (Process::ERR === $type) $this->line("\r\n" . $buffer);
            else $this->info("\r\n" . $buffer);
        });
        unset($yarn);
    }

    protected function installComposer() {
        $composer = new Process(["php", "composer", "install"]);
        $composer->setTimeout(0);
        $composer->run(function ($type, $buffer) {
            if (!$this->verbose) return;
            if (Process::ERR === $type) $this->line("\r\n" . $buffer);
            else $this->info("\r\n" . $buffer);
        });
        unset($composer);
    }

    protected function npmCompile($env = 'prod') {
        $npm = new Process(["npm", "run", $env]);
        $npm->setTimeout(0);
        $npm->run(function ($type, $buffer) {
            if (!$this->verbose) return;
            if (Process::ERR === $type) $this->line("\r\n" . $buffer);
            else $this->info("\r\n" . $buffer);
        });
        unset($npm);
    }
    */

    protected function prepare() {

        var_dump("prepare");

        // NPM install
        /*
        $this->info("\r\n");
        $this->info("\r\nInstallo i pacchetti NPM mancanti...");
        $this->installNpm();
        $this->progress->advance();

        // COMPOSER install
        $this->info("\r\n");
        $this->info("\r\nInstallo i pacchetti Web mancanti...");
        $this->installComposer();
        $this->progress->advance();

        // ARTISAN MIGRATE
        $this->info("\r\n");
        $this->info("\r\nMigrazione tabelle...");
        Artisan::call('migrate', ['--force' => true]);
        $this->progress->advance();

        // ARTISAN RESET ALL CACHES
        $this->info("\r\n");
        $this->info("\r\nPulisco cache...");
        Artisan::call('cache:clear');
        $this->progress->advance();
        $this->info("\r\n");
        $this->info("\r\nPulisco cache dei file di configurazione...");
        Artisan::call('config:clear');
        $this->progress->advance();
        $this->info("\r\n");
        $this->info("\r\nPulisco cache delle viste...");
        Artisan::call('view:clear');
        $this->progress->advance();
        $this->info("\r\n");
        $this->info("\r\nPulisco cache dei permessi...");
        Artisan::call('permission:cache-reset');
        $this->progress->advance();

        $this->info("\r\n");
        $this->info("\r\nFinalizzo... (potrebbe richiedere qualche minuto)");
        $this->npmCompile();
        $this->progress->advance();
        */
    }

    /*

    /**
     * Write .env file function.
     *
     * @param $name
     * @param $db
     * @param $smtp
     * @return mixed
     */
    /*
    protected function writeEnvFile($name, $url, $db, $smtp)
    {
        $envFilePath = base_path() . DIRECTORY_SEPARATOR . '.env';
        $envExampleFilePath = base_path() . DIRECTORY_SEPARATOR . '.env.example';

        // Check if .env exists
        $overwrite = false;
        if (file_exists($envFilePath)) {
            $overwrite = $this->choice("\r\nEsiste già un file di configurazione, sovrascriverlo?", ['Si', 'No, esci'], 1) == 'Si';
        }

        if (!$overwrite) {
            $this->info("\r\nProcedura di installazione terminata dall'utente.");
            return -1;
        } else {
            unlink($envFilePath);
        }

        // Copy .env file
        $this->info("\r\n");
        $this->info("\r\nScrivo i dati nel file di configurazione .env");
        copy($envExampleFilePath, $envFilePath);

        // New .env values
        $values = [
            // App info
            'APP_NAME' => $name,
            'APP_DEBUG' => 'false',
            'APP_URL' => $url,
            // Database
            'DB_HOST' => $db['host'],
            'DB_PORT' => $db['port'],
            'DB_DATABASE' => $db['name'],
            'DB_USERNAME' => $db['user'],
            'DB_PASSWORD' => $db['pass'],
            // SMTP
            'MAIL_HOST' => $smtp['host'],
            'MAIL_PORT' => $smtp['port'],
            'MAIL_USERNAME' => $smtp['user'],
            'MAIL_PASSWORD' => $smtp['pass'],
            'MAIL_ENCRYPTION' => $smtp['ssl'] ? 'ssl' : 'null',
            'MAIL_FROM_ADDRESS' => $smtp['mailfrom'],
            'MAIL_FROM_NAME' => $smtp['mailfromname']
        ];

        $this->setEnvironmentValues($envFilePath, $values);

        return 1;
    }

    protected function setEnvironmentValues($filePath, array $values)
    {
        $str = file_get_contents($filePath);

        // Fix EOL delimiters
        $str = preg_replace("/\r\n/", "\n", $str);
        $str = preg_replace("/\r/", "\n", $str);
        $str = preg_replace("/\n/", "\r\n", $str);

        $strArr = explode("\r\n", $str);

        if (count($values) > 0) { // EDIT
            foreach ($strArr as $strLine) {
                $key = trim(strtok($strLine, "="));
                if (isset($values[$key])) {
                    //$value = strtok($strLine, $key . "=");
                    $valueFind = explode($key.'=', $strLine);
                    $value = $valueFind[1];
                    if (strpos($values[$key], " ") === true) $values[$key] = '"' . $values[$key] . '"'; // Add " when string contains at least one 'space char'
                    $str = str_replace($key . "=" . $value, $key . "=" . $values[$key], $str);
                    unset($values[$key]);
                }
            }
        }

        if (!empty($values)) { // ADD
            foreach ($values as $key => $value)
                $str .= "\r\n" . $key . "=" . $value;
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($filePath, $str)) return false;
        return true;
    }
    */
}
