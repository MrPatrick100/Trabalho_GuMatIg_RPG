<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../entity/Habilidade.php';

class HabilidadeRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConexao();
    }

    /** @return Habilidade[] */ // Lista todas as habilidades salvas no Banco daquele usuário
    public function listarPorUsuario(int $usuarioId): array {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM habilidade WHERE id_usuario = :idu ORDER BY nome ASC'
        );
        $stmt->execute([':idu' => $usuarioId]);
        $lista = [];
        foreach ($stmt->fetchAll() as $dados) {
            $lista[] = new Habilidade($dados);
        }
        return $lista;
    }

    public function listarFiltrando(int $usuarioId, string $nome_pesquisa): array {
        $pesquisa = '%' . $nome_pesquisa . '%';
        $stmt = $this->pdo->prepare(
            'SELECT * FROM habilidade WHERE id_usuario = :idu AND nome LIKE :pesquisa ORDER BY nome ASC'
        );
        $stmt->execute([':idu' => $usuarioId, ':pesquisa' => $pesquisa]);
        $lista = [];
        foreach ($stmt->fetchAll() as $dados) {
            $lista[] = new Habilidade($dados);
        }
        return $lista;
    }

    public function buscarPorId(int $id): ?Habilidade {
        $stmt = $this->pdo->prepare('SELECT * FROM habilidade WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $dados = $stmt->fetch();

        if ($dados) {
            return new Habilidade($dados);
        }

        return null;
    }

    public function salvar(Habilidade $habilidade): void {
        if ($habilidade->getId() > 0) {
            $stmt = $this->pdo->prepare(
                'UPDATE habilidade SET nome = :nome, tipo = :tipo, ciclo = :ciclo, estilo = :estilo, custo = :custo, descricao = :descricao WHERE id = :id'
            );
            $stmt->execute([
                ':id' => $habilidade->getId(),
                ':nome' => $habilidade->getNome(),
                ':tipo' => $habilidade->getTipo(),
                ':ciclo' => $habilidade->getCiclo(),
                ':estilo' => $habilidade->getEstilo(),
                ':custo' => $habilidade->getCusto(),
                ':descricao' => $habilidade->getDescricao(),
            ]);
            return;
        }

        if ($habilidade->getId_usuario() <= 0) {
            throw new InvalidArgumentException('Usuário inválido.');
        }

        $stmt = $this->pdo->prepare(
            'INSERT INTO habilidade (id_usuario, nome, tipo, ciclo, estilo, custo, descricao) VALUES (:idu, :nome, :tipo, :ciclo, :estilo, :custo, :descricao)'
        );
        $stmt->execute([
            ':idu' => $habilidade->getId_usuario(),
            ':nome' => $habilidade->getNome(),
            ':tipo' => $habilidade->getTipo(),
            ':ciclo' => $habilidade->getCiclo(),
            ':estilo' => $habilidade->getEstilo(),
            ':custo' => $habilidade->getCusto(),
            ':descricao' => $habilidade->getDescricao(),
        ]);

        $habilidade->registrarIdGerado((int) $this->pdo->lastInsertId());
    }

    public function inserir(int $id_usuario, string $nome, string $tipo, int $ciclo, string $estilo, int $custo, string $descricao): void {
        $habilidade = Habilidade::novo($id_usuario, $nome, $tipo, $ciclo, $estilo, $custo, $descricao);
        $this->salvar($habilidade);
    }

    public function atualizar(int $id, string $nome, string $tipo, int $ciclo, string $estilo, int $custo, string $descricao): void {
        $habilidade = $this->buscarPorId($id);

        if ($habilidade === null) {
            throw new RuntimeException('Habilidade não encontrado.');
        }

        $habilidade->alterarDados($nome, $tipo, $ciclo, $estilo, $custo, $descricao);
        $this->salvar($habilidade);
    }

    public function excluir(int $id): void {
        $stmt = $this->pdo->prepare('DELETE FROM habilidade WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
