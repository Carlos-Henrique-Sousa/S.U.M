<?php
try {
    // Definições de constantes para a conexão
    define('HOST', 'localhost'); // Nome do servidor do banco de dados
    define('DB', 's.u.m_bd'); // Nome do banco de dados
    define('USER', 'Portal_Edu'); // Nome de usuário do banco de dados
    define('PASS', 'Carloshenrique2008'); // Senha do banco de dados

    // Criando a conexão com o banco de dados usando PDO
    $conect = new PDO('mysql:host=' . HOST . ';dbname=' . DB . ';charset=utf8', USER, PASS);
    // Configurando o modo de erro do PDO para exceções
    $conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    // Captura e exibe qualquer erro de conexão
    echo '<b>Erro na conexão com o banco de dados:</b> ' . $error->getMessage();
}
