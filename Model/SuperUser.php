<?php

class SuperUser {
    private $nome;
    private $email;
    private $senha;

    public function getNome() : string {
        return $this->nome;
    }

    public function __construct($nome, $email, $senha)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }



}