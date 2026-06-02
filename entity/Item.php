<?php

class Item {

    private int    $id_personagem;
    private int    $id;
    private string $nome;
    private string $tipo;
    private string $descricao;
    private bool   $equipado;
    private bool   $deletado;

    public function __construct(array $dados) {

        $this->id_personagem        = (int) ($dados['id_usuario']  ?? 0);
        $this->id                = (int) ($dados['id']             ?? 0);
        $this->nome              =        $dados['nome']           ?? '';
        $this->tipo              =        $dados['tipo']           ?? '';
        $this->ciclo             = (int) ($dados['ciclo']          ?? 0);
        $this->descricao         =        $dados['descricao']      ?? '';
        $this->equipado          =        $dados['equipado']       ?? FALSE;
        $this->deletado          =        FALSE;
    }

    public function Id_personagem():      int    { return $this->id_personagem; }
    public function getId():              int    { return $this->id; }
    public function getNome():            string { return $this->nome; }
    public function getTipo():            string { return $this->tipo; }
    public function getDescricao():       string { return $this->descricao; }
    public function getEquipado():        bool { return $this->equipado; }
    public function getDeletado():        bool { return $this->deletado; }

    public static function novo(int $id_personagem, string $nome, string $tipo, string $descricao, bool $equipado, bool $deletado): Item {
            if ($id_personagem <= 0) {
            throw new InvalidArgumentException('Usuário inválido.');
        }

        $item = new Item(['id_personagem' => $id_personagem]);
        $item->alterarDados($nome, $tipo, $descricao, $equipado, $deletado);

        return $item;
    }

    public function alterarDados(string $nome, string $tipo, string $descricao, bool $equipado, bool $deletado): void {
        $nome = trim($nome);
        $tipo = trim($tipo);

        if ($nome === '' || $tipo === '') {
            throw new InvalidArgumentException('Nome, tipo e estilo são obrigatórios.');
        }

        //Colocar as condições de preenchimento

        $this->nome  = $nome;
        $this->tipo = $tipo;
        $this->descricao = $descricao;
        $this->equipado = $equipado;
        $this->deletado = $deletado;
    }

    public function registrarIdGerado(int $id): void {
        if ($id <= 0) {
            throw new InvalidArgumentException('ID inválido.');
        }

        $this->id = $id;
    }
}
