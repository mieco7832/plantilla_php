<?php
namespace Configs;

require_once __DIR__  . "/Database.php";

class Migration extends Database
{

    public function __construct()
    {
        parent::__construct();
    }

    public function runMigration()
    {
        $sqlFilePath = "./database.sql";
        if (file_exists($sqlFilePath)) {
            $sql = file_get_contents($sqlFilePath);
            $statements = explode(";", $sql);

            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement)) {
                    parent::__set("consulta", $statement);
                    $this->EjecutarStatement();
                }
            }

            echo "Migration executed successfully.";
        } else {
            echo "SQL file not found.";
        }
    }
}
