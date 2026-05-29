<?php

class Pericia {
    private int    $id_personagem;
    private int    $acrobacia;
    private int    $adestramento;
    private int    $artes;
    private int    $atletismo;
    private int    $diplomacia;
    private int    $enganacao;
    private int    $fortitude;
    private int    $furtividade;
    private int    $intimidacao;
    private int    $intuicao;
    private int    $investigacao;
    private int    $luta_briga;
    private int    $medicina;
    private int    $ocultismo;
    private int    $percepcao;
    private int    $pontaria;
    private int    $reflexos_iniciativa;
    private int    $religiao;
    private int    $tatica;
    private int    $vontade;

    public function __construct(array $dados) {

        $this->id_personagem        = (int) ($dados['id_personagem']  ?? 0);
        $this->acrobacia            = (int) ($dados['acrobacia']  ?? 0);
        $this->adestramento         = (int) ($dados['adestramento']  ?? 0);
        $this->artes                = (int) ($dados['artes']  ?? 0);
        $this->atletismo            = (int) ($dados['atletismo']  ?? 0);
        $this->diplomacia           = (int) ($dados['diplomacia']  ?? 0);
        $this->enganacao            = (int) ($dados['enganacao']  ?? 0);
        $this->fortitude            = (int) ($dados['fortitude']  ?? 0);
        $this->furtividade          = (int) ($dados['furtividade']  ?? 0);
        $this->intimidacao          = (int) ($dados['intimidacao']  ?? 0);
        $this->intuicao             = (int) ($dados['intuicao']  ?? 0);
        $this->investigacao         = (int) ($dados['investigacao']  ?? 0);
        $this->luta_briga           = (int) ($dados['luta_briga']  ?? 0);
        $this->medicina             = (int) ($dados['medicina']  ?? 0);
        $this->ocultismo            = (int) ($dados['ocultismo']  ?? 0);
        $this->percepcao            = (int) ($dados['percepcao']  ?? 0);
        $this->pontaria             = (int) ($dados['pontaria']  ?? 0);
        $this->reflexos_iniciativa  = (int) ($dados['reflexos_iniciativa']  ?? 0);
        $this->religiao             = (int) ($dados['religiao']  ?? 0);
        $this->tatica               = (int) ($dados['tatica']  ?? 0);
        $this->vontade              = (int) ($dados['vontade']  ?? 0);
    }

    public function getId_personagem():             int    { return $this->id_personagem; }
    public function getAcrobacia():                 int    { return $this->acrobacia; }
    public function getAdestramento():              int    { return $this->adestramento; }
    public function getArtes():                     int    { return $this->artes; }
    public function getAtletismo():                 int    { return $this->atletismo; }
    public function getDiplomacia():                int    { return $this->diplomacia; }
    public function getEnganacao():                 int    { return $this->enganacao; }
    public function getFortitude():                 int    { return $this->fortitude; }
    public function getFurtividade():               int    { return $this->furtividade; }
    public function getIntimidacao():               int    { return $this->intimidacao; }
    public function getIntuicao():                  int    { return $this->intuicao; }
    public function getInvestigacao():              int    { return $this->investigacao; }
    public function getLuta_Briga():                int    { return $this->luta_briga; }
    public function getMedicina():                  int    { return $this->medicina; }
    public function getOcultismo():                 int    { return $this->ocultismo; }
    public function getPercepcao():                 int    { return $this->percepcao; }
    public function getPontaria():                  int    { return $this->pontaria; }
    public function getReflexos_Iniciativa():       int    { return $this->reflexos_iniciativa; }
    public function getReligiao():                  int    { return $this->religiao; }
    public function getTatica():                    int    { return $this->tatica; }
    public function getVontade():                   int    { return $this->vontade; }

    public static function novo(
        int $id_personagem, int $acrobacia, int $adestramento, int $artes, int $atletismo, 
        int $diplomacia, int $enganacao, int $fortitude, int $furtividade, int $intimidacao, int $intuicao,
        int $investigacao, int $luta_briga, int $medicina, int $ocultismo, int $percepcao, int $pontaria,
        int $reflexos_iniciativa, int $religiao, int $tatica, int $vontade
    ): Pericia {
        if ($id_personagem <= 0) {
            throw new InvalidArgumentException('Personagem inválido.');
        }

        $pericia = new Pericia(['id_personagem' => $id_personagem]);
        $pericia->alterarDados(
            $acrobacia, $adestramento, $artes, $atletismo, 
            $diplomacia, $enganacao, $fortitude, $furtividade, $intimidacao, $intuicao,
            $investigacao, $luta_briga, $medicina, $ocultismo, $percepcao, $pontaria,
            $reflexos_iniciativa, $religiao, $tatica, $vontade
        );
        return $pericia;
    }

    public function alterarDados(
        int $acrobacia, int $adestramento, int $artes, int $atletismo, 
        int $diplomacia, int $enganacao, int $fortitude, int $furtividade, int $intimidacao, int $intuicao,
        int $investigacao, int $luta_briga, int $medicina, int $ocultismo, int $percepcao, int $pontaria,
        int $reflexos_iniciativa, int $religiao, int $tatica, int $vontade
    ): void {
        // if ($nome === '' || $tipo === '' || $estilo === '') {
        //     throw new InvalidArgumentException('Nome, tipo e estilo são obrigatórios.');
        // }

        // if ($ciclo < 1 || $ciclo > 6) {
        //     throw new InvalidArgumentException('O ciclo deve ser entre 1 e 6.');
        // }

        //Colocar as condições de preenchimento

        $this->acrobacia            = $acrobacia;
        $this->adestramento         = $adestramento;
        $this->artes                = $artes;
        $this->atletismo            = $atletismo;
        $this->diplomacia           = $diplomacia;
        $this->enganacao            = $enganacao;
        $this->fortitude            = $fortitude;
        $this->furtividade          = $furtividade;
        $this->intimidacao          = $intimidacao;
        $this->intuicao             = $intuicao;
        $this->investigacao         = $investigacao;
        $this->luta_briga           = $luta_briga;
        $this->medicina             = $medicina;
        $this->ocultismo            = $ocultismo;
        $this->percepcao            = $percepcao;
        $this->pontaria             = $pontaria;
        $this->reflexos_iniciativa  = $reflexos_iniciativa;
        $this->religiao             = $religiao;
        $this->tatica               = $tatica;
        $this->vontade              = $vontade;
    }

    public function registrarIdGerado(int $id_personagem): void {
        if ($id_personagem <= 0) {
            throw new InvalidArgumentException('Personagem inválido.');
        }

        $this->id_personagem = $id_personagem;
    }
}