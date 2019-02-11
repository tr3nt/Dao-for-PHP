<?php

/**
 * Dao for PHP v1.0
 * Abstract class DAO for PHP/PDO/MySQL
 *
 * @author tr3nt
 */
abstract class DAO
{
    /**
     * @var PDO $con
     * @var string $query
     * @var array $result
     */
    protected $con;
    protected $query;
    public $result;

    public function __construct()
    {
        /**
         * MySQL config data
         * Datos MySQL de configuración
         *
         * @var string $user
         * @var string $pass
         * @var string $base
         * @var string $host
         */
        $user = '';
        $pass = '';
        $base = '';
        $host = 'localhost';

        $this->con = new PDO("mysql:host={$host};dbname={$base};charset=utf8", $user, $pass,
                         [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);
        /**
         * Try-catch errors ON
         */
        $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Execute query and get success or fail message
     * Ejecutar el query y obtener respuesta afirmativa o negativa
     *
     * @param string $query
     * @param array $params
     */
    protected function execute(string $query, array $params = [])
    {
        $res = [false, 'Transacción correcta.'];
        $this->query = $this->con->prepare($query);

        try {
            $this->query->execute($params);
        } catch (PDOException $e) {
            $res = [true, $e->getMessage()];
        } catch (Exception $e) {
            $res = [true, $e->getMessage()];
        } finally {
            $this->result = [
                'error' => $res[0],
                'data' => $res[1]
            ];
        }
    }

    /**
     * Execute query to get Result Set or fail message
     * Ejecutar el query y obtener los datos o respuesta negativa
     *
     * @param string $query
     * @param array $params
     */
    protected function executeGet(string $query, array $params = [])
    {
        $res = [true, "No se encontraron datos"];
        $this->query = $this->con->prepare($query);

        try {
            $this->query->execute($params);
            $data = $this->query->fetchAll(PDO::FETCH_ASSOC);
            if (count($data) > 0) {
                $res = [false, $data];
            }
        } catch (PDOException $e) {
            $res = [true, $e->getMessage()];
        } catch (Exception $e) {
            $res = [true, $e->getMessage()];
        } finally {
            $this->result = [
                'error' => $res[0],
                'data' => $res[1]
            ];
        }
    }

    /**
     * Returns custom message as long as there is no error
     * Devuelve un mensaje personalizado siempre y cuando no haya error
     *
     * @param string $msj
     */
    protected function message(string $msj)
    {
        if (!$this->result['error']) {
            $this->result['data'] = $msj;
        }
    }

    /**
     * Close MySQL connection
     * Cierra la conexión a MySQL
     */
    public function close()
    {
        $this->con = null;
    }
}
