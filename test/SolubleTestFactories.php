<?php

use PjbServer\Tools\StandaloneServer;

class SolubleTestFactories
{

    /**
     *
     * @var StandaloneServer|null
     */
    protected static $standaloneServer;

    /**
     *
     * @var int
     */
    // protected static $javaBridgeServerPid;

    /**
     * Start (and eventually install) the standalone
     * java bridge server
     */
    public static function startJavaBridgeServer()
    {


        if ($_SERVER['AUTORUN_PJB_STANDALONE'] == 'true') {

            if (self::$standaloneServer === null) {
                $server_address = self::getJavaBridgeServerAddress();
                //$url = parse_url($server_address, PHP_URL_HOST);
                $port = parse_url($server_address, PHP_URL_PORT);

                $params = [
                    'port' => $port
                ];
                $config = new StandaloneServer\Config($params);

                echo "Starting java bridge standalone server on port $port\n";
                try {
                    self::$standaloneServer = new StandaloneServer($config);
                    self::$standaloneServer->start();
                    //$output = self::$standaloneServer->getOutput();
                } catch (\Exception $e) {
                    die($e->getMessage());
                }

                register_shutdown_function([__CLASS__, 'killStandaloneServer']);
            }
        }
    }

    public static function killStandaloneServer()
    {
        if (self::$standaloneServer !== null) {
            if (self::$standaloneServer->isProcessRunning()) {
                self::$standaloneServer->stop();
            }
        }
    }

    public static function isStandaloneServerRunning()
    {
        $test_dir = dirname(__FILE__);
        $pid_file = "$test_dir/logs/pjb-standalone.pid";
        if (file_exists($pid_file)) {
            $pid = trim(file_get_contents($pid_file));
            if (is_numeric($pid)) {
                $result = shell_exec(sprintf("ps %d", $pid));
                if (count(preg_split("/\n/", $result)) > 2) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     *
     * @return string
     */
    public static function getJavaBridgeServerAddress()
    {
        return $_SERVER['PJB_SERVLET_ADDRESS'];
    }

    /**
     * @return string
     */
    public static function getCachePath()
    {
        $cache_dir = $_SERVER['PHPUNIT_CACHE_DIR'];
        if (!preg_match('/^\//', $cache_dir)) {
            $cache_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . $cache_dir;
        }
        return $cache_dir;
    }

}
