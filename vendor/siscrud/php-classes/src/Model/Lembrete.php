<?php
namespace Crud\Model;

use Crud\BD\Conexao;

class Lembrete {
    private $id;
    private $descricao;
    private $fk_usuario;

    /* Getters and Setters */
    public function getId()
    {
        return $this->id;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function getFkUsuario()
    {
        return $this->fk_usuario;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function setFkUsuario($fk_usuario)
    {
        $this->fk_usuario = $fk_usuario;
    }
    /* End Getters and Setters */

    // Função que recebe o id do usuario e retorna um array associativo dos dados dos lembretes de determinado usuario
    public function listByIdUsuario($fk_usuario)
    {
        $con = new Conexao();
        //Recebendo a conexao com o bando
        $pdo = $con->getPdo();

        $listar = $pdo->prepare("SELECT * FROM lembretes WHERE fk_usuario=:fk_usuario");
        $listar->bindValue(":fk_usuario",$fk_usuario);
        $listar->execute();

        $lembretes = $listar->fetchAll(\PDO::FETCH_ASSOC);
        return $lembretes;
    }

    // Função que recebe o id do lembrete e retorna um array associativo dos dados do lembrete
    public function listById($id)
    {
        $con = new Conexao();
        //Recebendo a conexao com o bando
        $pdo = $con->getPdo();

        $listar = $pdo->prepare("SELECT * FROM lembretes WHERE id=:id");
        $listar->bindValue(":id",$id);
        $listar->execute();

        $lembrete = $listar->fetch(\PDO::FETCH_ASSOC);
        return $lembrete;
    }

    // Função para colocar "dentro" do objeto os dados do lembrete
    public function loadById($id)
    {
        $con = new Conexao();
        //Recebendo a conexao com o bando
        $pdo = $con->getPdo();

        $listar = $pdo->prepare("SELECT * FROM lembretes WHERE id=:id");
        $listar->bindValue(":id",$id);
        $listar->execute();

        $resultado = $listar->fetch(\PDO::FETCH_ASSOC);
        
        $this->setId($resultado["id"]);
        $this->setDescricao($resultado["descricao"]);
        $this->setFkUsuario($resultado["fk_usuario"]);

    }

    // Função para deletar lembretes, que recebe os dados diretamente do objeto    
    public function delete()
    {
        $con = new Conexao();
        //Recebendo a conexao com o bando
        $pdo = $con->getPdo();

        $deletar = $pdo->prepare("DELETE FROM lembretes WHERE id=:id");
        $deletar->bindValue(":id",$this->getId());
        $deletar->execute();
    }

    // Função para inserir lembretes, que recebe os dados diretamente do objeto
    public function add()
    {
        $con = new Conexao();
        //Recebendo a conexao com o bando
        $pdo = $con->getPdo();

        $inserir = $pdo->prepare("INSERT INTO lembretes(descricao,fk_usuario) VALUES(:descricao,:fk_usuario)");
        $inserir->bindValue(":descricao",$this->getDescricao());
        $inserir->bindValue(":fk_usuario",$this->getFkUsuario());
        $inserir->execute();
    }

    // Função para atualizar lembretes, que recebe os dados diretamente do objeto
    public function update()
    {
        $con = new Conexao();
        //Recebendo a conexao com o bando
        $pdo = $con->getPdo();

        $inserir = $pdo->prepare("UPDATE lembretes SET descricao=:descricao WHERE id=:id");
        $inserir->bindValue(":descricao",$this->getDescricao());
        $inserir->bindValue(":id",$this->getId());
        $inserir->execute();
    }
}