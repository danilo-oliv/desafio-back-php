<?php

include_once 'Model/SuperUser.php';


class User extends SuperUser {
    private $cpf;
    private $saldo;

    function getCpf() { return $this->cpf; }
    function setCpf($cpf) { $this->cpf = $cpf; }

    function getSaldo() { return $this->saldo; }

    public function __construct($nome, $email, $senha, $cpf)
    {
        parent::__construct($nome, $email, $senha);
        $this->cpf = $cpf;
        $this->saldo = 0;
        TransacoesController::$usuarios[] = $this;
    }

    function depositar($valor) {
        $this->saldo += $valor;
        return $this->getNome().", depósito feito. Saldo atualizado: $this->saldo.\n";
    }

    function sacar($valor) {
        if ($this->saldo == 0 || $this->saldo<$valor) {
            return "Transação negada.";
        }

        $this->saldo -= $valor;
        return "Saque feito. Saldo atualizado: $this->saldo.\n";
    }


    function solicitarTransferencia($cpfDestino, $valorOperacao) 
    {
        echo TransacoesController::efetuarTransferencia($this, $cpfDestino, $valorOperacao);   

    }

    function consultarSaldo() {
        echo "\n".$this->getNome().", seu saldo é de R$".$this->getSaldo();
    }


}