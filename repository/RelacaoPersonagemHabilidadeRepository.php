<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../entity/RelacaoPersonagemHabilidade.php';

class RelacaoPersonagemHabilidadeRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConexao();
    }

    /** @return RelacaoPersonagemHabilidade[] */ // Lista todas as habilidades salvas no Banco daquele usuário
    public function listarPorUsuario(int $usuarioId): array {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM personagem_habilidade WHERE id_usuario = :idu ORDER BY nome ASC'
        );
        $stmt->execute([':idu' => $usuarioId]);
        $lista = [];
        foreach ($stmt->fetchAll() as $dados) {
            $lista[] = new RelacaoPersonagemHabilidade($dados);
        }
        return $lista;
    }

    public function buscarPorId(int $id): ?RelacaoPersonagemHabilidade {
        $stmt = $this->pdo->prepare('SELECT * FROM personagem_habilidade WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $dados = $stmt->fetch();

        if ($dados) {
            return new RelacaoPersonagemHabilidade($dados);
        }

        return null;
    }

    public function salvar(RelacaoPersonagemHabilidade $relacao): void {
        if ($relacao->getId() > 0) {
            $stmt = $this->pdo->prepare(
                'UPDATE personagem_habilidade SET id_personagem = :id_personagem, id_habilidade = :id_habilidade WHERE id = :id'
            );
            $stmt->execute([
                ':id' => $relacao->getId(),
                ':id_personagem' => $relacao->getId_personagem(),
                ':id_habilidade' => $relacao->getId_habilidade(),
            ]);
            return;
        }

        if ($relacao->getId_usuario() <= 0) {
            throw new InvalidArgumentException('Usuário inválido.');
        }
        
        $stmt = $this->pdo->prepare(
            'INSERT INTO personagem_habilidade (id_usuario, id_personagem, id_habilidade) VALUES (:id_usuario, :id_personagem, :id_habilidade)'
        );
        $stmt->execute([
            ':id_usuario' => $relacao->getId_usuario(),
            ':id_personagem' => $relacao->getId_personagem(),
            ':id_habilidade' => $relacao->getId_habilidade()
        ]);

        $relacao->registrarIdGerado((int) $this->pdo->lastInsertId());
    }

    public function inserir(int $id_personagem, int $id_habilidade): void {
        $relacao = RelacaoPersonagemHabilidade::novo($id_usuario, $id_personagem, $id_habilidade);
        $this->salvar($relacao);
    }

    // public function atualizar(int $id, string $nome, string $tipo, int $ciclo, string $estilo, int $custo, string $descricao): void {
    //     $habilidade = $this->buscarPorId($id);

    //     if ($habilidade === null) {
    //         throw new RuntimeException('Habilidade não encontrado.');
    //     }

    //     $habilidade->alterarDados($nome, $tipo, $ciclo, $estilo, $custo, $descricao);
    //     $this->salvar($habilidade);
    // }

    // public function excluir(int $id): void {
    //     $stmt = $this->pdo->prepare('DELETE FROM habilidade WHERE id = :id');
    //     $stmt->execute([':id' => $id]);
    // }
}
