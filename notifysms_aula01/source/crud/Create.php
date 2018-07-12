<?php

/**
 * <b>Create [ INSERT ]</b>
 * Classe responsável por cadastros genéricos no banco de dados!
 *
 * @copyright (c) 2018, UPINSIDE TREINAMENTOS
 */

namespace CRUD;

USE \PDOException;
USE \PDO;

class Create
{

    /** @var string $table Nome da tabela */

    private $table;

    /** @var array $data Array associativo com os campos e respectivos valores */
    private $data;

    /** @var null|integer $result Retorno nulo ou o id inserido se tiver sucesso */

    private $result;

    /** @var PDOStatement */

    private $create;

    /** @var PDO */

    private $conn;

    /**
     * Obtém conexão do banco de dados Singleton
     */

    public function __construct()
    {
        $this->conn = Conn::getConn();
    }

    /**
     * <b>create:</b> Executa um cadastro simplificado no banco de dados utilizando prepared statements.
     * Basta informar o nome da tabela e um array atribuitivo com nome da coluna e valor!
     *
     * @param string $table Informe o nome da tabela no banco
     * @param array $data Informe um array atribuitivo. ( Nome Da Coluna => Valor )
     * @return void
     */

    public function create($table, array $data)
    {
        $this->table = (string) $table;
        $this->data = $data;

        $this->getSyntax();
        $this->execute();
    }

    /**
     * <b>createMultiple:</b> Executa um cadastro múltiplo no banco de dados utilizando prepared statements.
     * Basta informar o nome da tabela e um array multidimensional com nome da coluna e valores!
     *
     * @param string $table Informe o nome da tabela no banco
     * @param array $data Informe um array multidimensional. ( [] = Key => Value )
     * @return void
     */

    public function createMultiple($table, array $data)
    {
        $this->table = (string) $table;
        $this->data = $data;

        $fields = implode(', ', array_keys($this->data[0]));
        $places = null;
        $inserts = null;
        $links = count(array_keys($this->data[0]));

        foreach ($data as $valueMult) {
            $places .= '(';
            $places .= str_repeat('?,', $links);
            $places .= '),';

            foreach ($valueMult as $valueSingle) {
                $inserts[] = $valueSingle;
            }
        }

        $places = str_replace(',)', ')', $places);
        $places = substr($places, 0, -1);
        $this->data = $inserts;

        $this->create = "INSERT INTO {$this->table} ({$fields}) VALUES {$places}";
        $this->execute();
    }

    /**
     * <b>getResult:</b> Retorna o ID do registro inserido ou FALSE caso nenhum registro seja inserido!
     *
     * @return null|integer O retorno será null caso não tenha sucesso ao criar o registro, caso contrário o ID será retornado
     */

    public function getResult()
    {
        return $this->result;
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */

    /**
     * Obtém o PDO e Prepara a query
     */

    private function connect()
    {
        $this->create = $this->conn->prepare($this->create);
    }

    /**
     * Cria a sintaxe da query para Prepared Statements
     */

    private function getSyntax()
    {
        $fields = implode(', ', array_keys($this->data));
        $places = ':' . implode(', :', array_keys($this->data));
        $this->create = "INSERT INTO {$this->table} ({$fields}) VALUES ({$places})";
    }

    /**
     * Obtém a Conexão e a Syntax, executa a query!
     */

    private function execute()
    {
        $this->connect();

        try {
            $this->create->execute($this->data);
            $this->result = $this->conn->lastInsertId();
        } catch (PDOException $e) {
            $this->result = null;
            echo "<b>Erro ao Cadastrar:</b> {$e->getMessage()} {$e->getCode()}";
        }
    }

}
