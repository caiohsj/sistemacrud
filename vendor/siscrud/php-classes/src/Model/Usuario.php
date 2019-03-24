<?php
namespace Crud\Model;

use Crud\BD\Conexao;

class Usuario {
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $status;

    /* Getters and Setters ------------------------------------------*/
    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
    /* End Getters and Setters ------------------------------------------- */

    public function add()
    {
    	$con = new Conexao();
        //Recebendo a conexao com o bando
        $pdo = $con->getPdo();

    	//QUERY PARA INSERIR USUARIO NO BANCO
    	$inserir = $pdo->prepare("INSERT INTO usuarios(nome,email,senha,status) VALUES(:nome,:email,:senha,:status)");
    	$inserir->bindValue(":nome", utf8_encode($this->getNome()));
    	$inserir->bindValue(":email", $this->getEmail());
    	$inserir->bindValue(":senha", $this->getPasswordHash($this->getSenha()));
    	$inserir->bindValue(":status", $this->getStatus());
    	$inserir->execute();

    }

    public function loadByEmail($email)
    {
        $con = new Conexao();
        //Recebendo a conexao com o bando
        $pdo = $con->getPdo();

        $listar = $pdo->prepare("SELECT * FROM usuarios WHERE email=:email");
        $listar->bindValue(":email",$email);
        $listar->execute();

        $resultado = $listar->fetch(\PDO::FETCH_ASSOC);
        
        $this->setId($resultado["id"]);
        $this->setNome($resultado["nome"]);
        $this->setEmail($resultado["email"]);
        $this->setSenha($resultado["senha"]);
        $this->setStatus($resultado["status"]);

    }

    //Função que retorna o hash da senha recebida por parâmetro
    public function getPasswordHash($senha)
    {
        $hash = password_hash($_POST['senha'], PASSWORD_BCRYPT, ['cost' => 12]);
        return $hash;
    }

    public static function verifyLogin()
    {
        if(
            isset($_SESSION["idUsuario"]) 
            &&
            isset($_SESSION["nomeUsuario"]) 
            &&
            isset($_SESSION["emailUsuario"]) 
            &&
            isset($_SESSION["statusUsuario"]) 
            &&
            $_SESSION["idUsuario"] != ""
            &&
            $_SESSION["nomeUsuario"] != ""
            &&
            $_SESSION["emailUsuario"] != ""
            &&
            $_SESSION["statusUsuario"] != ""
        ){
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $senha)
    {
        $this->loadByEmail($email);

        //Verifica se a senha é válida
        if(password_verify($senha, $this->getSenha())){
            $_SESSION["idUsuario"] = $this->getId();
            $_SESSION["nomeUsuario"] = $this->getNome();
            $_SESSION["emailUsuario"] = $this->getEmail();
            $_SESSION["statusUsuario"] = $this->getStatus();
            return true;
        } else {
            return false;
        }
    }


    public function loadById($id)
    {
        $con = new Conexao();
        //Recebendo a conexao com o bando
        $pdo = $con->getPdo();

        $listar = $pdo->prepare("SELECT * FROM usuarios WHERE id=:id");
        $listar->bindValue(":id",$id);
        $listar->execute();

        $resultado = $listar->fetch(PDO::FETCH_ASSOC);
        
        $this->setId($resultado["id"]);
        $this->setNome($resultado["nome"]);
        $this->setEmail($resultado["email"]);
        $this->setSenha($resultado["senha"]);
        $this->setStatus($resultado["status"]);
        
    }

    public function findByEmail($email)
    {
    	$con = new Conexao();
        //Recebendo a conexao com o bando
        $pdo = $con->getPdo();

        $listar = $pdo->prepare("SELECT * FROM usuarios WHERE email=:email");
        $listar->bindValue(":email",$email);
        $listar->execute();

        $resultado = $listar->fetch(\PDO::FETCH_ASSOC);
        
        if(empty($resultado)){
            return false;
        } else {
            return true;
        }
    }

    public static function logout()
    {
        $_SESSION["idUsuario"] = NULL;
        $_SESSION["nomeUsuario"] = NULL;
        $_SESSION["emailUsuario"] = NULL;
        $_SESSION["statusUsuario"] = NULL;
    }

    public static function getFromSession()
    {
        $array = [
            "id"=>$_SESSION["idUsuario"],
            "nome"=>$_SESSION["nomeUsuario"],
            "email"=>$_SESSION["emailUsuario"]
        ];

        return $array;
    }

    // Função que recebe o erro
    public static function setErro($msg)
    {
        $_SESSION["erroCadastro"] = $msg;
    }

    public static function getErro()
    {
        $msg = (isset($_SESSION["erroCadastro"])) ? $_SESSION["erroCadastro"] : "";

        Usuario::clearErro();

        return $msg;
    }

    public static function clearErro()
    {
        $_SESSION["erroCadastro"] = NULL;
    }

/*
    public function confirmarCadastro($id)
    {
        $con = new Conexao();
        //Recebendo a conexao com o bando
        $pdo = $con->getPdo();

        $confirmar = $pdo->prepare("UPDATE usuarios SET status=1 WHERE id=:id");
        $confirmar->bindValue(":id",$id);
        $confirmar->execute();
    }
*/
}