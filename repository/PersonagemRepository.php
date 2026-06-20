<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../entity/Personagem.php';

class PersonagemRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConexao();
    }

    /** @return Personagem[] */ // Lista todas os personagens salvos no Banco daquele usuário
    public function listarPorUsuario(int $usuarioId): array {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM personagem WHERE id_usuario = :idu ORDER BY favorito DESC, nome ASC'
        );
        $stmt->execute([':idu' => $usuarioId]);
        $lista = [];
        foreach ($stmt->fetchAll() as $dados) {
            $lista[] = new Personagem($dados);
        }
        return $lista;
    }

    public function listarFiltrando(int $usuarioId, string $nome_pesquisa): array {
        $pesquisa = '%' . $nome_pesquisa . '%';
        $stmt = $this->pdo->prepare(
            'SELECT * FROM personagem WHERE id_usuario = :idu AND nome LIKE :pesquisa ORDER BY nome ASC'
        );
        $stmt->execute([':idu' => $usuarioId, ':pesquisa' => $pesquisa]);
        $lista = [];
        foreach ($stmt->fetchAll() as $dados) {
            $lista[] = new Personagem($dados);
        }
        return $lista;
    }

    public function filtrarPorFavorito(int $usuarioId): array {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM personagem WHERE id_usuario = :idu AND favorito = 1 ORDER BY nome ASC'
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
                'UPDATE personagem SET nome = :nome, idade = :idade, raca = :raca,
                nivel = :nivel, agilidade = :agilidade, forca = :forca, intelecto = :intelecto,
                constituicao = :constituicao, carisma = :carisma, magia = :magia, aparencia = :aparencia,
                deletado = :deletado, lore = :lore, favorito = :favorito  WHERE id = :id'
            );
            $stmt->execute([
                ':id' => $personagem->getId(),
                ':nome' => $personagem->getNome(),
                ':idade' => $personagem->getIdade(),
                ':raca' => $personagem->getRaca(),
                ':nivel' => $personagem->getNivel(),
                ':agilidade' => $personagem->getAgilidade(),
                ':forca' => $personagem->getForca(),
                ':intelecto' => $personagem->getIntelecto(),
                ':constituicao' => $personagem->getConstituicao(),
                ':carisma' => $personagem->getCarisma(),
                ':magia' => $personagem->getMagia(),
                ':aparencia' => $personagem->getAparencia(),
                ':deletado' => $personagem->getDeletado(),
                ':lore' => $personagem->getLore(),
                ':favorito' => $personagem->getFavorito()
            ]);
            return;
        }

        if ($personagem->getId_usuario() <= 0) {
            throw new InvalidArgumentException('Usuário inválido.');
        }

        $stmt = $this->pdo->prepare(
            'INSERT INTO personagem (id_usuario, nome, idade, raca, nivel, agilidade, forca, intelecto, constituicao, carisma, magia, aparencia, deletado, lore, favorito) 
            VALUES (:idu, :nome, :idade, :raca, :nivel, :agilidade, :forca, :intelecto, :constituicao, :carisma, :magia, :aparencia, :deletado, :lore, :favorito)'
        );
        $stmt->execute([
            ':idu'   => $personagem->getId_usuario(),
            ':nome'  => $personagem->getNome(),
            ':idade' => $personagem->getIdade(),
            ':raca'  => $personagem->getRaca(),
            ':nivel' => $personagem->getNivel(),
            ':agilidade'   => $personagem->getAgilidade(),
            ':forca'  => $personagem->getForca(),
            ':intelecto'  => $personagem->getIntelecto(),
            ':constituicao' => $personagem->getConstituicao(),
            ':carisma'   => $personagem->getCarisma(),
            ':magia'  => $personagem->getMagia(),
            ':aparencia'  => $personagem->getAparencia(),
            ':deletado' => $personagem->getDeletado(),
            ':lore' => $personagem->getLore(),
            ':favorito' => $personagem->getFavorito()
        ]);

        $personagem->registrarIdGerado((int) $this->pdo->lastInsertId());
    }

    public function inserir(
        int $id_usuario, string $nome, int $idade, string $raca, int $nivel,
        int $agilidade, int $forca, int $intelecto, int $constituicao, int $carisma,
        int $magia,string $aparencia, string $lore, int $deletado, int $favorito
    ): void {
        $personagem = Personagem::novo($id_usuario, $nome, $idade, $raca, $nivel, $agilidade, $forca, $intelecto,
        $constituicao, $carisma, $magia, $aparencia, $lore, $deletado, $favorito);
        $this->salvar($personagem);
    }

    public function atualizar(int $id, string $nome, int $idade, string $raca, int $nivel, int $agilidade,
    int $forca, int $intelecto, int $constituicao, int $carisma, int $magia, string $aparencia, string $lore, int $deletado, int $favorito
    ): void {
        $personagem = $this->buscarPorId($id);

        if ($personagem === null) {
            throw new RuntimeException('Personagem não encontrado.');
        }

        $personagem->alterarDados($nome, $idade, $raca, $nivel, $agilidade, $forca, $intelecto, $constituicao, $carisma, $magia, $aparencia, $lore, $deletado, $favorito);
        $this->salvar($personagem);
    }

    public function excluir(int $id): void {
        $stmt = $this->pdo->prepare('DELETE FROM personagem WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function recuperar(int $id): void {
        $stmt = $this->pdo->prepare('UPDATE personagem SET deletado = 0 WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function setFavorito(int $id, int $favorito): void {
        $stmt = $this->pdo->prepare('UPDATE personagem SET favorito = :favorito WHERE id = :id');
        $stmt->execute([
            ':id' => $id,
            ':favorito' => $favorito
        ]);
    }
}
