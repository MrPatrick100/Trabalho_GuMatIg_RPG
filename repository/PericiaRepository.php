<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../entity/Pericia.php';

class PericiaRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConexao();
    }

    /** @return Pericia[] */ // Lista todas as habilidades salvas no Banco daquele usuário
    public function listarPorPersonagem(int $id_personagem): array {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM pericias WHERE id_personagem = :idp ORDER BY id_personagem ASC'
        );
        $stmt->execute([':idp' => $id_personagem]);
        $lista = [];
        foreach ($stmt->fetchAll() as $dados) {
            $lista[] = new Pericia($dados);
        }
        return $lista;
    }

    public function buscarPorId(int $id_personagem): ?Pericia {
        $stmt = $this->pdo->prepare('SELECT * FROM pericias WHERE id_personagem = :id_personagem LIMIT 1');
        $stmt->execute([':id_personagem' => $id_personagem]);
        $dados = $stmt->fetch();

        if ($dados) {
            return new Pericia($dados);
        }

        return null;
    }

    public function salvar(Pericia $pericia): void {
        if ($pericia->num_alteracao > 0) {
            $stmt = $this->pdo->prepare(
                'UPDATE pericias SET acrobacia = :acrobacia, adestramento = :adestramento, 
                artes = :artes, atletismo = :atletismo, diplomacia = :diplomacia, enganacao = :enganacao,
                fortitude = :fortitude, furtividade = :furtividade, intimidacao = :intimidacao, intuicao = :intuicao,
                investigacao = :investigacao, luta_briga = :luta_briga, medicina = :medicina, ocultismo = :ocultismo,
                percepcao = :percepcao, pontaria = :pontaria, reflexos_iniciativa = :reflexos_iniciativa,
                religiao = :religiao, tatica = :tatica, vontade = :vontade WHERE id_personagem = :id_personagem'
            );
            $stmt->execute([
                ':id_personagem' => $pericia->getId_personagem(),
                ':acrobacia' => $pericia->getAcrobacia(),
                ':adestramento' => $pericia->getAdestramento(),
                ':artes' => $pericia->getArtes(),
                ':atletismo' => $pericia->getAtletismo(),
                ':diplomacia' => $pericia->getDiplomacia(),
                ':enganacao' => $pericia->getEnganacao(),
                ':fortitude'=> $pericia->getFortitude(),
                ':furtividade' => $pericia->getFurtividade(),
                ':intimidacao' => $pericia->getIntimidacao(),
                ':intuicao' => $pericia->getIntuicao(),
                ':investigacao' => $pericia->getInvestigacao(),
                ':luta_briga' => $pericia->getLuta_Briga(),
                ':medicina' => $pericia->getMedicina(),
                ':ocultismo' => $pericia->getOcultismo(),
                ':percepcao' => $pericia->getPercepcao(),
                ':pontaria' => $pericia->getPontaria(),
                ':reflexos_iniciativa' => $pericia->getReflexos_Iniciativa(),
                ':religiao' => $pericia->getReligiao(),
                ':tatica' => $pericia->getTatica(),
                ':vontade' => $pericia->getVontade(),
            ]);
            return;
        }

        $stmt = $this->pdo->prepare(
            'INSERT INTO pericias (id_personagem, acrobacia, adestramento, artes, atletismo, diplomacia, enganacao,
            fortitude, furtividade, intimidacao, intuicao, investigacao, luta_briga, medicina, ocultismo, percepcao,
            pontaria, reflexos_iniciativa, religiao, tatica, vontade)
            VALUES (:id_personagem, :acrobacia, :adestramento, :artes, :atletismo, :diplomacia, :enganacao,
            :fortitude, :furtividade, :intimidacao, :intuicao, :investigacao, :luta_briga, :medicina, :ocultismo,
            :percepcao, :pontaria, :reflexos_iniciativa, :religiao, :tatica, :vontade)'
        );
        $stmt->execute([
            ':id_personagem' => $pericia->getId_personagem(),
            ':acrobacia' => $pericia->getAcrobacia(),
            ':adestramento' => $pericia->getAdestramento(),
            ':artes' => $pericia->getArtes(),
            ':atletismo' => $pericia->getAtletismo(),
            ':diplomacia' => $pericia->getDiplomacia(),
            ':enganacao' => $pericia->getEnganacao(),
            ':fortitude'=> $pericia->getFortitude(),
            ':furtividade' => $pericia->getFurtividade(),
            ':intimidacao' => $pericia->getIntimidacao(),
            ':intuicao' => $pericia->getIntuicao(),
            ':investigacao' => $pericia->getInvestigacao(),
            ':luta_briga' => $pericia->getLuta_Briga(),
            ':medicina' => $pericia->getMedicina(),
            ':ocultismo' => $pericia->getOcultismo(),
            ':percepcao' => $pericia->getPercepcao(),
            ':pontaria' => $pericia->getPontaria(),
            ':reflexos_iniciativa' => $pericia->getReflexos_Iniciativa(),
            ':religiao' => $pericia->getReligiao(),
            ':tatica' => $pericia->getTatica(),
            ':vontade' => $pericia->getVontade(),
        ]);

        $pericia->registrarIdGerado($pericia->getId_personagem());
        $pericia->num_alteracao++;
    }

    public function inserir(
        int $id_personagem, int $acrobacia, int $adestramento, int $artes, int $atletismo, 
        int $diplomacia, int $enganacao, int $fortitude, int $furtividade, int $intimidacao, int $intuicao,
        int $investigacao, int $luta_briga, int $medicina, int $ocultismo, int $percepcao, int $pontaria,
        int $reflexos_iniciativa, int $religiao, int $tatica, int $vontade
        ): void {
        $pericia = Pericia::novo(
            $id_personagem, $acrobacia, $adestramento, $artes, $atletismo, 
            $diplomacia, $enganacao, $fortitude, $furtividade, $intimidacao, $intuicao,
            $investigacao, $luta_briga, $medicina, $ocultismo, $percepcao, $pontaria,
            $reflexos_iniciativa, $religiao, $tatica, $vontade
        );
        $this->salvar($pericia);
    }

    public function atualizar(
        int $id_personagem, int $acrobacia, int $adestramento, int $artes, int $atletismo, 
        int $diplomacia, int $enganacao, int $fortitude, int $furtividade, int $intimidacao, int $intuicao,
        int $investigacao, int $luta_briga, int $medicina, int $ocultismo, int $percepcao, int $pontaria,
        int $reflexos_iniciativa, int $religiao, int $tatica, int $vontade
        ): void {
        $pericia = $this->buscarPorId($id_personagem);

        if ($pericia === null) {
            throw new RuntimeException('Pericias não encontradas.');
        }

        $pericia->alterarDados(
            $acrobacia, $adestramento, $artes, $atletismo, 
            $diplomacia, $enganacao, $fortitude, $furtividade, $intimidacao, $intuicao,
            $investigacao, $luta_briga, $medicina, $ocultismo, $percepcao, $pontaria,
            $reflexos_iniciativa, $religiao, $tatica, $vontade
        );
        $this->salvar($pericia);
    }

    public function excluir(int $id_personagem): void {
        $stmt = $this->pdo->prepare('DELETE FROM pericias WHERE id_personagem = :id_personagem');
        $stmt->execute([':id_personagem' => $id_personagem]);
    }
}