<?php


class TransacoesController { 

    static $usuarios = array();
    static $lojistas = [ ];
    
    static function buscarCpf($cpf) {
        foreach (TransacoesController::$usuarios as $user ) {
            if ($user->getCpf() == $cpf) {
                return $user;
            }
        }
        return null;
    
    }  

    static function efetuarTransferencia($contaOrigem, $cpfDestino, $valorOperacao) 
    {

        if ($contaOrigem->getSaldo() < $valorOperacao){
            return "Transação negada";
        }

        $contaDestino = TransacoesController::buscarCpf($cpfDestino);

        if ($contaDestino == null) {
            return "Não foi possível encontrar a conta destinatária.";
        }

        try{
            if (!TransacoesController::autorizaTransacao()) {
                return "Transação não autorizada";
            }

            $contaOrigem->sacar($valorOperacao);
            $contaDestino->depositar($valorOperacao);
        } catch(Exception $e) {
            echo "Erro ".$e->getMessage();
        }

        return "Operação realizada com sucesso.";
    
    }
    
    

    static function validarTransacao() {
        $curl_host = curl_init();

        $url = "https://util.devi.tools/api/v2/authorize";

        curl_setopt($curl_host, CURLOPT_URL, $url);
        curl_setopt($curl_host, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl_host);

        if (curl_errno($curl_host)) {
            echo 'Erro: ' . curl_error($curl_host);
            curl_close($curl_host);
            return null;
        } else {
            $dados = json_decode($response, true);
            curl_close($curl_host);
            return $dados;
        } 

    }

    static function autorizaTransacao() {

        $resposta = TransacoesController::validarTransacao();

        if($resposta["status"] == "fail") {
            return false;
        }

        if($resposta["status"] == "success") {
            return true;
        }
    }



}





