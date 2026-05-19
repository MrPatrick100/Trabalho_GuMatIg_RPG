<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../entity/Personagem.php';

class PersonagemRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConexao();
    }

    /** @return Personagem[] */
    public function listarPorUsuario(int $usuarioId): array {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM personagem WHERE id_usuario = :idu ORDER BY nome ASC'
        );
        $stmt->execute([':idu' => $usuarioId]);
        $lista = [];
        foreach ($stmt->fetchAll() as $dados) {
            $lista[] = new Personagem($dados);
        }
        return $lista;
    }

    public function buscarPorId(int $id): ?Personagem {
        $stmt = $this->pdo->prepare('SELECT * FROM personagem WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $dados = $stmt->fetch();

        if ($dados) {
            return new Personagem($dados);
        }

        return null;
    }

    public function salvar(Personagem $personagem): void {
        if ($personagem->getId() > 0) {
            $stmt = $this->pdo->prepare(
                'UPDATE personagem SET nome = :nome, tipo = :tipo, nivel = :nivel WHERE id = :id'
            );
            $stmt->execute([
                ':nome'  => $personagem->getNome(),
                ':tipo'  => $personagem->getTipo(),
                ':nivel' => $personagem->getNivel(),
                ':id'    => $personagem->getId(),
            ]);
            return;
        }

        if ($personagem->getUsuarioId() <= 0) {
            throw new InvalidArgumentException('Usuário inválido.');
        }

        $stmt = $this->pdo->prepare(
            'INSERT INTO personagem (nome, tipo, nivel, id_usuario) VALUES (:nome, :tipo, :nivel, :uid)'
        );
        $stmt->execute([
            ':nome'  => $personagem->getNome(),
            ':tipo'  => $personagem->getTipo(),
            ':nivel' => $personagem->getNivel(),
            ':uid'   => $personagem->getUsuarioId(),
        ]);

        $personagem->registrarIdGerado((int) $this->pdo->lastInsertId());
    }

    public function inserir(string $nome, string $tipo, int $nivel, int $usuarioId): void {
        $personagem = Personagem::novo($nome, $tipo, $nivel, $usuarioId);
        $this->salvar($personagem);
    }

    public function atualizar(int $id, string $nome, string $tipo, int $nivel): void {
        $personagem = $this->buscarPorId($id);

        if ($personagem === null) {
            throw new RuntimeException('Pokémon não encontrado.');
        }

        $personagem->alterarDados($nome, $tipo, $nivel);
        $this->salvar($personagem);
    }

    public function excluir(int $id): void {
        $stmt = $this->pdo->prepare('DELETE FROM personagem WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
