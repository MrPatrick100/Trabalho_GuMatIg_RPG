<?php

class Inventario {

    private int     $id_personagem;
    private string  $cabeca;
    private string  $peitoral;
    private string  $calca;
    private string  $calcado;
    private string  $arma1;
    private string  $arma2;
    private string  $amuleto;
    private string  $itens;
    private int     $moedas;

    public function __construct(array $dados) {

        $this->id_personagem    = (int) ($dados['id_personagem'] ?? 0);
        $this->cabeca           =       $dados['cabeca']         ?? '';
        $this->peitoral         =       $dados['peitoral']       ?? '';
        $this->calca            =       $dados['calca']          ?? '';
        $this->calcado          =       $dados['calcado']        ?? '';
        $this->arma1            =       $dados['arma1']          ?? '';
        $this->arma2            =       $dados['arma2']          ?? '';
        $this->amuleto          =       $dados['amuleto']        ?? '';
        $this->itens            =       $dados['itens']          ?? '';
        $this->moedas           = (int) ($dados['moedas']        ?? 0);

    }

    public function getId_personagem():     int         { return $this->id_personagem; }
    public function getCabeca():            string      { return $this->cabeca; }
    public function getPeitoral():          string      { return $this->peitoral; }
    public function getCalca():             string      { return $this->calca; }
    public function getCalcado():           string      { return $this->calcado; }
    public function getArma1():             string      { return $this->arma1; }
    public function getArma2():             string      { return $this->arma2; }
    public function getAmuleto():           string      { return $this->amuleto; }
    public function getItens():             string      { return $this->itens; }
    public function getMoedas():            int         { return $this->moedas; }


    public static function novo(
        int $id_personagem, string $cabeca, string $peitoral, string $calca, string $calcado, 
        string $arma1, string $arma2, string $amuleto, string $itens, int $moedas
    ): Inventario {
            if ($id_personagem <= 0) {
            throw new InvalidArgumentException('Usuário inválido.');
        }

        $inventario = new Inventario(['id_personagem' => $id_personagem]);
        $inventario->alterarDados($cabeca, $peitoral, $calca, $calcado, $arma1, $arma2, $amuleto, $itens, $moedas);

        return $inventario;
    }

    public function alterarDados(string $cabeca, string $peitoral, string $calca, string $calcado, 
        string $arma1, string $arma2, string $amuleto, string $itens, int $moedas): void {
        $cabeca     = trim($cabeca);
        $peitoral   = trim($peitoral);
        $calca      = trim($calca);
        $calcado    = trim($calcado);
        $arma1      = trim($arma1);
        $arma2      = trim($arma2);
        $amuleto    = trim($amuleto);
        $itens      = trim($itens);
        $moedas     = trim($moedas);

        //Colocar as condições de preenchimento

        $this->cabeca  = $cabeca;
        $this->peitoral = $peitoral;
        $this->calca = $calca;
        $this->calcado = $calcado;
        $this->arma1 = $arma1;
        $this->arma2 = $arma2;
        $this->amuleto = $amuleto;
        $this->itens = $itens;
        $this->moedas = $moedas;
    }

    public function registrarIdGerado(int $id_personagem): void {
        if ($id_personagem <= 0) {
            throw new InvalidArgumentException('ID inválido.');
        }

        $this->id_personagem = $id_personagem;
    }
}
