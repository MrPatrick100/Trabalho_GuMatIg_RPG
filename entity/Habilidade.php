<?php

class Habilidade {

    private int    $id_usuario;
    private int    $id;
    private string $nome;
    private string $tipo;
    private int    $ciclo;
    private string $estilo;
    private string $dano;
    private string $buff_nerf;
    private int    $custo;
    private string $alcance;
    private string $area;
    private string $duracao;
    private int    $pontos;
    private string $descricao;
    private int    $deletado;

    public function __construct(array $dados) {

        $this->id_usuario        = (int) ($dados['id_usuario']  ?? 0);
        $this->id                = (int) ($dados['id']          ?? 0);
        $this->nome              =        $dados['nome']        ?? '';
        $this->tipo              =        $dados['tipo']        ?? '';
        $this->ciclo             = (int) ($dados['ciclo']       ?? 0);
        $this->estilo            =        $dados['estilo']      ?? '';
        $this->dano              =        $dados['dano']        ?? '';
        $this->buff_nerf         =        $dados['buff_nerf']   ?? '';
        $this->custo             = (int) ($dados['custo']       ?? 0);
        $this->alcance           =        $dados['alcance']     ?? '';
        $this->area              =        $dados['area']        ?? '';
        $this->duracao           =        $dados['duracao']     ?? '';
        $this->pontos            = (int) ($dados['pontos']      ?? 0);
        $this->descricao         =        $dados['descricao']   ?? '';
        $this->deletado          = (int) ($dados['deletado']    ?? 0);
    }

    public function getId_usuario():      int    { return $this->id_usuario; }
    public function getId():              int    { return $this->id; }
    public function getNome():            string { return $this->nome; }
    public function getTipo():            string { return $this->tipo; }
    public function getCiclo():           int    { return $this->ciclo; }
    public function getEstilo():          string { return $this->estilo; }
    public function getDano():            string { return $this->dano; }
    public function getBuffNerf():        string { return $this->buff_nerf; }
    public function getCusto():           int    { return $this->custo; }
    public function getAlcance():         string { return $this->alcance; }
    public function getArea():            string { return $this->area; }
    public function getDuracao():         string { return $this->duracao; }
    public function getPontos():          int    { return $this->pontos; }
    public function getDescricao():       string { return $this->descricao; }
    public function getDeletado():        int    { return $this->deletado; }

    public static function novo(int $id_usuario, string $nome, string $tipo, int $ciclo, string $estilo, string $dano, string $buff_nerf, int $custo, string $alcance, string $area, string $duracao, int $pontos, string $descricao, int $deletado): Habilidade {
            if ($id_usuario <= 0) {
            throw new InvalidArgumentException('Usuário inválido.');
        }

        $habilidade = new Habilidade(['id_usuario' => $id_usuario]);
        $habilidade->alterarDados($nome, $tipo, $ciclo, $estilo, $dano, $buff_nerf, $custo, $alcance, $area, $duracao, $pontos, $descricao, $deletado);

        return $habilidade;
    }

    public function alterarDados(string $nome, string $tipo, int $ciclo, string $estilo, string $dano, string $buff_nerf, int $custo, string $alcance, string $area, string $duracao, int $pontos, string $descricao, int $deletado): void {
        $nome = trim($nome);
        $tipo = trim($tipo);
        $estilo = trim($estilo);

        if ($nome === '' || $tipo === '' || $estilo === '') {
            throw new InvalidArgumentException('Nome, tipo e estilo são obrigatórios.');
        }

        if ($ciclo < 1 || $ciclo > 6) {
            throw new InvalidArgumentException('O ciclo deve ser entre 1 e 6.');
        }
        else {
            $pontos = 25 + ($ciclo * 25)
        }

        if ($alcance)

        //Colocar as condições de preenchimento

        $this->nome      = $nome;
        $this->tipo      = $tipo;
        $this->ciclo     = $ciclo;
        $this->estilo    = $estilo;
        $this->dano      = $dano;
        $this->buff_nerf = $buff_nerf;
        $this->custo     = $custo;
        $this->alcance   = $alcance;
        $this->area      = $area;
        $this->duracao   = $duracao;
        $this->pontos    = $pontos;
        $this->descricao = $descricao;
        $this->deletado  = $deletado;
    }

    public function registrarIdGerado(int $id): void {
        if ($id <= 0) {
            throw new InvalidArgumentException('ID inválido.');
        }

        $this->id = $id;
    }
}
