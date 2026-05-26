<?php

class Pericia {

    private int    $id_personagem;
    private int    $acrobacia;
    private int    $atletismo;
    private int    $adestramento;

    public function __construct(array $dados) {

        $this->id_personagem        = (int) ($dados['id_personagem']  ?? 0);
        $this->acrobacia            = (int) ($dados['acrobacia']  ?? 0);
        $this->atletismo            = (int) ($dados['atletismo']  ?? 0);
        $this->adestramento         = (int) ($dados['adestramento']  ?? 0);
        
    }

    public function getId_personagem():      int    { return $this->id_personagem; }
    public function getAcrobacia():      int    { return $this->acrobacia; }
    public function getAtletismo():      int    { return $this->atletismo; }
    public function getAdestramento():      int    { return $this->adestramento; }
//TERMINAR AS PERICIAS
    public static function novo(int $id_personagem, int $acrobacia, int $atletismo, int $adestramento, ): Pericia {
            if ($id_personagem <= 0) {
            throw new InvalidArgumentException('Usuário inválido.');
        }

        $pericia = new Pericia(['id_personagem' => $id_personagem]);
        $pericia->alterarDados($nome, $tipo, $ciclo, $estilo, $custo, $descricao);

        return $pericia;
    }

    public function alterarDados(string $nome, string $tipo, int $ciclo, string $estilo, int $custo, string $descricao): void {
        $nome = trim($nome);
        $tipo = trim($tipo);
        $estilo = trim($estilo);

        if ($nome === '' || $tipo === '' || $estilo === '') {
            throw new InvalidArgumentException('Nome, tipo e estilo são obrigatórios.');
        }

        if ($ciclo < 1 || $ciclo > 6) {
            throw new InvalidArgumentException('O ciclo deve ser entre 1 e 6.');
        }

        //Colocar as condições de preenchimento

        $this->nome  = $nome;
        $this->tipo = $tipo;
        $this->ciclo = $ciclo;
        $this->estilo  = $estilo;
        $this->custo  = $custo;
        $this->descricao = $descricao;
    }

    public function registrarIdGerado(int $id): void {
        if ($id <= 0) {
            throw new InvalidArgumentException('ID inválido.');
        }

        $this->id = $id;
    }
}