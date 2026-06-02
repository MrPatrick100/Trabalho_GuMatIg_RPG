<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../entity/Item.php';

class ItemRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConexao();
    }

    /** @return Item[] */ // Lista todas as habilidades salvas no Banco daquele usuário
    public function listarPorPersonagem(int $id_personagem): array {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM item WHERE id_personagem = :id_p ORDER BY nome ASC'
        );
        $stmt->execute([':id_p' => $id_personagem]);
        $lista = [];
        foreach ($stmt->fetchAll() as $dados) {
            $lista[] = new Item($dados);
        }
        return $lista;
    }

    // public function listarFiltrando(int $usuarioId, string $nome_pesquisa): array {
    //     $pesquisa = '%' . $nome_pesquisa . '%';
    //     $stmt = $this->pdo->prepare(
    //         'SELECT * FROM habilidade WHERE id_usuario = :idu AND nome LIKE :pesquisa ORDER BY nome ASC'
    //     );
    //     $stmt->execute([':idu' => $usuarioId, ':pesquisa' => $pesquisa]);
    //     $lista = [];
    //     foreach ($stmt->fetchAll() as $dados) {
    //         $lista[] = new Habilidade($dados);
    //     }
    //     return $lista;
    // }

    public function buscarPorIdPersonagem(int $id_personagem): ?Habilidade {
        $stmt = $this->pdo->prepare('SELECT * FROM item WHERE id = :id_p LIMIT 1');
        $stmt->execute([':id_p' => $id_personagem]);
        $dados = $stmt->fetch();

        if ($dados) {
            return new Item($dados);
        }

        return null;
    }

    public function salvar(Item $item): void {
        if ($item->getId() > 0) {
            $stmt = $this->pdo->prepare(
                'UPDATE item SET nome = :nome, tipo = :tipo, descricao = :descricao, equipado = :equipado, deletado = :deletado WHERE id = :id'
            );
            $stmt->execute([
                ':id' => $item->getId(),
                ':nome' => $item->getNome(),
                ':tipo' => $item->getTipo(),
                ':descricao' => $item->getDescricao(),
                ':equipado' => $item->getEquipado(),
                ':deletado' => $item->getDeletado(),
            ]);
            return;
        }

        if ($item->getId_personagem() <= 0) {
            throw new InvalidArgumentException('Usuário inválido.');
        }

        $stmt = $this->pdo->prepare(
            'INSERT INTO item (id_personagem, nome, tipo, descricao, equipado, deletado) VALUES (:idu, :nome, :tipo, :descricao, :equipado, :deletado)'
        );
        $stmt->execute([
            ':id_p' => $item->getId_personagem(),
            ':nome' => $item->getNome(),
            ':tipo' => $item->getTipo(),
            ':descricao' => $item->getDescricao(),
            ':equipado' => $item->getEquipado(),
            ':deletado' => $item->getDeletado(),
        ]);

        $item->registrarIdGerado((int) $this->pdo->lastInsertId());
    }

    public function inserir(int $id_personagem, string $nome, string $tipo, string $descricao, bool $equipado, bool $deletado): void {
        $item = Item::novo($id_personagem, $nome, $tipo, $descricao, $equipado, $deletado);
        $this->salvar($item);
    }

    public function atualizar(int $id, string $nome, string $tipo, string $descricao, bool $equipado, bool $deletado): void {
        $item = $this->buscarPorId($id);

        if ($item === null) {
            throw new RuntimeException('Item não encontrado.');
        }

        $item->alterarDados($nome, $tipo, $descricao, $equipado, $deletado);
        $this->salvar($item);
    }

    public function excluir(int $id): void {
        $stmt = $this->pdo->prepare('DELETE FROM item WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
