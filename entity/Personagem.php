<?php

class Personagem {

    private int    $id_usuario;
    private int    $id;
    private string $nome;
    private int    $idade;
    private string $raca;
    private int    $nivel;
    private int    $agilidade;
    private int    $forca;
    private int    $intelecto;
    private int    $constituicao;
    private int    $carisma;
    private int    $magia;
    private string $aparencia;
    private string $lore;
    private int    $deletado;
    private int    $favorito;
    private int    $hp;
    private int    $stamina;
    private int    $mana;
    private int    $pf;

    public function __construct(array $dados) {
        $this->id_usuario        = (int) ($dados['id_usuario']        ?? 0);
        $this->id                = (int) ($dados['id']       ?? 0);
        $this->nome              =        $dados['nome']       ?? '';
        $this->idade             = (int) ($dados['idade']      ?? 0);
        $this->raca              =        $dados['raca'] ?? '';
        $this->nivel             = (int) ($dados['nivel']        ?? 0);
        $this->agilidade         = (int) ($dados['agilidade']       ?? 0);
        $this->forca             = (int) ($dados['forca']       ?? 0);
        $this->intelecto         = (int) ($dados['intelecto']      ?? 0);
        $this->constituicao      = (int) ($dados['constituicao'] ?? 0);
        $this->carisma           = (int) ($dados['carisma']        ?? 0);
        $this->magia             = (int) ($dados['magia']       ?? 0);
        $this->aparencia         =        $dados['aparencia']       ?? '';
        $this->lore              =        $dados['lore'] ?? '';
        $this->deletado          = (int) ($dados['deletado'] ?? 0);
        $this->favorito          = (int) ($dados['favorito'] ?? 0);
        $this->hp                = $this->nivel * 5 + $this->constituicao * 5;
        $this->stamina           = $this->forca * 10;
        $this->mana              = $this->magia * 10;
        if($this->carisma > $this->intelecto) $this->pf = $this->carisma;
        else $this->pf = $this->intelecto;
    }

    public function getId_usuario():      int    { return $this->id_usuario; }
    public function getId():              int    { return $this->id; }
    public function getNome():            string { return $this->nome; }
    public function getIdade():           int    { return $this->idade; }
    public function getRaca():            string { return $this->raca; }
    public function getNivel():           int    { return $this->nivel; }
    public function getAgilidade():       int    { return $this->agilidade; }
    public function getForca():           int    { return $this->forca; }
    public function getIntelecto():       int    { return $this->intelecto; }
    public function getConstituicao():    int    { return $this->constituicao; }
    public function getCarisma():         int    { return $this->carisma; }
    public function getMagia():           int    { return $this->magia; }
    public function getAparencia():       string { return $this->aparencia; }
    public function getLore():            string { return $this->lore; }
    public function getDeletado():        int    { return $this->deletado; }
    public function getFavorito():        int    { return $this->favorito; }
    public function getHp():              int    { return $this->hp; }
    public function getStamina():         int    { return $this->stamina; }
    public function getMana():            int    { return $this->mana; }
    public function getPf():              int    { return $this->pf; }

    public static function novo(
        int $id_usuario, string $nome, int $idade, string $raca, int $nivel, 
        int $agilidade, int $forca, int $intelecto, int $constituicao, int $carisma, int $magia, 
        string $aparencia, string $lore, int $deletado, int $favorito
    ): Personagem {
        if ($id_usuario <= 0) {
            throw new InvalidArgumentException('Usuário inválido.');
        }

        $personagem = new Personagem(['id_usuario' => $id_usuario]);
        $personagem->alterarDados($nome, $idade, $raca, $nivel, $agilidade, $forca, $intelecto, $constituicao, $carisma, $magia, $aparencia, $lore, $deletado, $favorito);

        return $personagem;
    }

    public function alterarDados(
        string $nome, int $idade, string $raca, int $nivel, int $agilidade, int $forca, int $intelecto, int $constituicao, 
        int $carisma, int $magia, string $aparencia, string $lore, int $deletado, int $favorito
    ): void {
        $nome = trim($nome);
        $raca = trim($raca);

        if ($nome === '' || $raca === '') {
            throw new InvalidArgumentException('Nome e raça são obrigatórios.');
        }

        if ($idade < 0) {
            throw new InvalidArgumentException('A idade deve ser maior que 0');
        }

        if ($nivel < 1 || $nivel > 5) {
            throw new InvalidArgumentException('O nível deve ser entre 1 e 5.');
        }

        $this->nome         = $nome;
        $this->idade        = $idade;
        $this->raca         = $raca;
        $this->nivel        = $nivel;
        $this->agilidade    = $agilidade;
        $this->forca        = $forca;
        $this->intelecto    = $intelecto;
        $this->constituicao = $constituicao;
        $this->carisma      = $carisma;
        $this->magia        = $magia;
        $this->aparencia    = $aparencia;
        $this->lore         = $lore;
        $this->deletado     = $deletado;
        $this->favorito     = $favorito;
        $this->hp           = $nivel * 5 + $constituicao * 5;
        $this->stamina      = $forca * 10;
        $this->mana         = $magia * 10;
        if($carisma > $intelecto) $this->pf = $carisma;
        else $this->pf      = $intelecto;
    }

    public function registrarIdGerado(int $id): void {
        if ($id <= 0) {
            throw new InvalidArgumentException('ID inválido.');
        }

        $this->id = $id;
    }
}
