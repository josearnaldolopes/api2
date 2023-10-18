<?php
header('Content-type: application/json');
$body = file_get_contents('php://input');

class acesso {
    public $usuario;
    public $senha;
    function verifica() {
        // echo "Acessado!";
        return true;
    }
}

class arquivo extends acesso {
    public $banco;
    function __construct($banco)
    {
        $this->banco = $banco;
    }
    function __destruct() {
        $this->banco;
    }
    function seleciona() {
        return $this->banco."false!";
    }
    function banco() {
        if (!file_exists($this->banco)) {
            $arquivo = fopen($this->banco,'w');
            if ($arquivo == false) die('Não foi possível criar o arquivo.');
            $texto = "{\"arquivo\":[{\"data\":\"$dataFileC\", \"chave\":\"$chave\", \"token\":\"$token \", \"usuario\":\"$usuario\", \"origem\":\"/v1/\", \"ip\":\"$ip\"}]}";
            fwrite($arquivo, $texto);
            fclose($arquivo);
        }
    }
}

class metodo extends arquivo {
    public $metodo;
    public $parte;
    public $banco;
    function __construct($parte)
    {
        // parent::__construct($banco);
        $this->parte = $parte;
    }
    function metodo() {
        switch ($this->metodo) {
            case "GET":
                // echo parent::seleciona();
                self::GET();
                break;
            case "POST":
                self::POST();
                break;
            case "PUT":
                self::ID($localId, $id);
                self::PUT();
                break;
            case "DELETE":
                self::ID($localId, $id);
                self::DELETE();
                echo "Deleta?";
                break;
        }
    }
    function ID($localId, $idJson) {

        // $json = json_decode(file_get_contents('banco.json'), true);
        foreach ($localId as $item => $idParte)
        {
            if ($idParte["id"] == $idJson) {
                // return true;
                echo "Dados".$idParte["name"].$idParte["condominio"];
            }
        }

    }
    function GET() {
        $json = json_decode(file_get_contents('banco.json'), true);
        echo json_encode($json[$this->parte]);
        // echo json_encode($json[$this->parte][1]);
    }
    function POST() {
        $jsonFile = json_decode(file_get_contents('banco.json'), true);
        $PostBody = json_decode(file_get_contents('php://input'), true);
        $PostBody['id'] = time();
        
        if(!$jsonFile["condominio"]){
          $jsonFile["condominio"] = [];
        }
        $jsonFile["condominio"][] = $PostBody;
        echo json_encode($PostBody);
        file_put_contents('banco.json', json_encode($jsonFile));
    }
    function PUT() {
        $jsonFile = json_decode(file_get_contents('banco.json'), true);
        $PostBody = json_decode(file_get_contents('php://input'), true);
        $PostBody ['id'] = 3;

        if(!$jsonFile["condominio"]){
            $jsonFile["condominio"] = [];
          }
        $jsonFile["condominio"][2] = $PostBody;

        echo self::ID($jsonFile["condominio"], 1608252567);
        // echo json_encode($PostBody);
        file_put_contents('banco.json', json_encode($jsonFile));
        
    }
    function DELETE() {
        // echo self::ID($jsonFile["condominio"], 1608252567);

        // $input = array("item 1", "item2", "item3", "item4");

        // $remover = array("item2");
        
        // $resultado = array_diff($input, $remover);

        // var_dump($resultado);

        $jsonFile = json_decode(file_get_contents('banco.json'), true);
        // var_dump($jsonFile["condominio"]);
        // array_diff($jsonFile["condominio"], $jsonFile["condominio"][1]);
        // unset($jsonFile["condominio"][1]);
        // var_export($jsonFile["condominio"]);
        echo json_encode($jsonFile["condominio"]);


        // var_dump($jsonFile["condominio"][1]);
        // echo "[".json_encode($jsonFile["condominio"])."]";
        // echo "[".json_encode($jsonFile["condominio"][3])."]";
        // echo json_encode($jsonFile["condominio"]);
        // file_put_contents('banco.json', json_encode($jsonFile));
        // print_r($jsonFile["condominio"][0]);
    }
}
// $acesso = new acesso;
// $acesso->verifica();
// $arquivo = new arquivo("banco.json");
$arquivo = new arquivo("db.json");
$arquivo->banco();
// $metodo = new metodo("arquivo");
$metodo = new metodo("condominio");
$metodo->metodo = $_SERVER['REQUEST_METHOD'];
$metodo->metodo();