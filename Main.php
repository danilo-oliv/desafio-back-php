<?php

include_once 'Model/User.php';

include 'Controller/TransacoesController.php';


$usuario1 = new User("João", "joao@joao", "1234", "123456-90");
$usuario2 = new User("Maria", "maria@maria", "1234", "123456-80");


echo $usuario1->depositar(500);
echo $usuario2->depositar(500);

echo $usuario1->solicitarTransferencia("123456-80", 100);

$usuario1->consultarSaldo();
$usuario2->consultarSaldo();

