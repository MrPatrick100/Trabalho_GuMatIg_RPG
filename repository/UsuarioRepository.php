<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../entity/Usuario.php';

class UsuarioRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConexao();
    }

    public function buscarPorEmail(string $email): ?Usuario {
        $stmt = $this->pdo->prepare('SELECT * FROM usuario WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $dados = $stmt->fetch();

        if ($dados) {
            return new Usuario($dados);
        }

        return null;
    }

    public function criarUsuario(string $nome, string $email, string $senha): void {
        $stmt = $this->pdo->prepare('INSERT INTO usuario (nome, email, senha, foto_perfil) VALUES (:nome, :email, :senha, :foto_perfil)');
        $stmt->execute([':nome' => $nome, ':email' => $email, ':senha' => $senha, ':foto_perfil' => '']);
    }

    public function atualizarSenha(int $id, string $senha): void {
        $stmt = $this->pdo->prepare('UPDATE usuario SET senha = :senha WHERE id = :id');
        $stmt->execute([':senha' => $senha,':id' => $id]);
    }

    public function atualizarAvatar(int $id, string $foto_perfil): void {
        $stmt = $this->pdo->prepare('UPDATE usuario SET foto_perfil = :foto_perfil WHERE id = :id');
        $stmt->execute([':foto_perfil' => $foto_perfil,':id' => $id]);
    }

    public function atualizarEmail(int $id, string $email): void {
        $stmt = $this->pdo->prepare('UPDATE usuario SET email = :email WHERE id = :id');
        $stmt->execute([':email' => $email,':id' => $id]);
    }

    public function atualizarCor(int $id, string $cor): void {
        $stmt = $this->pdo->prepare('UPDATE usuario SET cor_principal = :cor_principal WHERE id = :id');
        $stmt->execute([':cor_principal' => $cor,':id' => $id]);
    }
}
