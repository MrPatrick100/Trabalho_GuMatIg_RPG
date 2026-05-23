<?php

class Habilidade {

    private int    $id;
    private string $nome;
    private string $tipo;
    private int    $ciclo;
    private string $estilo;
    private int    $custo;
    private string $descricao;

    public function __construct(array $dados) {
        $this->id                = (int) ($dados['id']        ?? 0);
        $this->nome              =        $dados['nome']      ?? '';
        $this->tipo              =        $dados['tipo']      ?? '';
        $this->ciclo             = (int) ($dados['ciclo']     ?? 0);
        $this->estilo            =        $dados['estilo']    ?? '';
        $this->custo             = (int) ($dados['custo']     ?? 0);
        $this->descricao         =        $dados['descricao'] ?? '';
    }

    public function getId():              int    { return $this->id; }
    public function getNome():            string { return $this->nome; }
    public function getTipo():            string { return $this->tipo; }
    public function getCiclo():           int    { return $this->ciclo; }
    public function getEstilo():          string { return $this->estilo; }
    public function getCusto():           int    { return $this->custo; }
    public function getDescricao():       string { return $this->descricao; }

    public static function novo(int $id, string $nome, string $tipo, int $ciclo, string $estilo, int $custo, string $descricao): Personagem {

        $habilidade = new Habilidade();
        $habilidade->alterarDados($nome, $tipo, $ciclo, $estilo, $custo, $descricao);

        return $habilidade;
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
