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
                'UPDATE habilidade SET nome = :nome, tipo = :tipo, ciclo = :ciclo, estilo = :estilo, dano = :dano, buff_nerf = :buff_nerf, custo = :custo, alcance = :alcance, area = :area, duracao = :duracao, pontos = :pontos, descricao = :descricao, deletado = :deletado WHERE id = :id'
            );
            $stmt->execute([
                ':id' => $habilidade->getId(),
                ':nome' => $habilidade->getNome(),
                ':tipo' => $habilidade->getTipo(),
                ':ciclo' => $habilidade->getCiclo(),
                ':estilo' => $habilidade->getEstilo(),
                ':dano' => $habilidade->getDano(),
                ':buff_nerf' => $habilidade->getBuffNerf(),
                ':custo' => $habilidade->getCusto(),
                ':alcance' => $habilidade->getAlcance(),
                ':area' => $habilidade->getArea(),
                ':duracao' => $habilidade->getDuracao(),
                ':pontos' => $habilidade->getPontos(),
                ':descricao' => $habilidade->getDescricao(),
                ':deletado' => $habilidade->getDeletado(),
            ]);
            return;
        }

        if ($habilidade->getId_usuario() <= 0) {
            throw new InvalidArgumentException('Usuário inválido.');
        }

        $stmt = $this->pdo->prepare(
            'INSERT INTO habilidade (id_usuario, nome, tipo, ciclo, estilo, dano, buff_nerf, custo, alcance, area, duracao, pontos, descricao, deletado) 
            VALUES (:idu, :nome, :tipo, :ciclo, :estilo, :dano, :buff_nerf, :custo, :descricao, :alcance, :area, :duracao, :pontos, :deletado)'
        );
        $stmt->execute([
            ':idu' => $habilidade->getId_usuario(),
            ':nome' => $habilidade->getNome(),
                ':tipo' => $habilidade->getTipo(),
                ':ciclo' => $habilidade->getCiclo(),
                ':estilo' => $habilidade->getEstilo(),
                ':dano' => $habilidade->getDano(),
                ':buff_nerf' => $habilidade->getBuffNerf(),
                ':custo' => $habilidade->getCusto(),
                ':alcance' => $habilidade->getAlcance(),
                ':area' => $habilidade->getArea(),
                ':duracao' => $habilidade->getDuracao(),
                ':pontos' => $habilidade->getPontos(),
                ':descricao' => $habilidade->getDescricao(),
                ':deletado' => $habilidade->getDeletado(),
        ]);

        $habilidade->registrarIdGerado((int) $this->pdo->lastInsertId());
    }

    public function inserir(int $id_usuario, string $nome, string $tipo, int $ciclo, string $estilo, string $dano, string $buff_nerf, int $custo, string $alcance, string $area, string $duracao, int $pontos, string $descricao, int $deletado): void {
        $habilidade = Habilidade::novo($id_usuario, $nome, $tipo, $ciclo, $estilo, $dano, $buff_nerf, $custo, $alcance, $area, $duracao, $pontos, $descricao, $deletado);
        $this->salvar($habilidade);
    }

    public function atualizar(int $id, string $nome, string $tipo, int $ciclo, string $estilo, string $dano, string $buff_nerf, int $custo, string $alcance, string $area, string $duracao, int $pontos, string $descricao, int $deletado): void {
        $habilidade = $this->buscarPorId($id);

        if ($habilidade === null) {
            throw new RuntimeException('Habilidade não encontrado.');
        }

        $habilidade->alterarDados($nome, $tipo, $ciclo, $estilo, $dano, $buff_nerf, $custo, $alcance, $area, $duracao, $pontos, $descricao, $deletado);
        $this->salvar($habilidade);
    }

    public function excluir(int $id): void {
        $stmt = $this->pdo->prepare('DELETE FROM habilidade WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function recuperar(int $id): void {
        $stmt = $this->pdo->prepare('UPDATE habilidade SET deletado = 0 WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
