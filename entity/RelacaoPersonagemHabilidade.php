<?php

class RelacaoPersonagemHabilidade {

    private int    $id_usuario;
    private int    $id;  
    private int    $id_personagem;
    private int    $id_habilidade;

    public function __construct(array $dados) {

        $this->id_usuario           = (int) ($dados['id_usuario']     ?? 0);
        $this->id                   = (int) ($dados['id']             ?? 0);
        $this->id_personagem        = (int) ($dados['id_personagem']  ?? 0);
        $this->id_habilidade        = (int) ($dados['id_habilidade']  ?? 0);
    }

    public function getId_usuario():         int    { return $this->id_usuario; }
    public function getId():                 int    { return $this->id; }
    public function getId_personagem():      int    { return $this->id_personagem; }
    public function getId_habilidade():      int    { return $this->id_habilidade; }

    public static function novo(int $id_usuario, int $id_personagem, int $id_habilidade): RelacaoPersonagemHabilidade {

        if ($id_usuario <= 0) {
            throw new InvalidArgumentException('Usuário inválido.');
        }

        if ($id_personagem <= 0) {
            throw new InvalidArgumentException('Personagem inválido.');
        }
    
        $relacao = new RelacaoPersonagemHabilidade(['id_usuario' => $id_usuario]);
        $relacao->alterarDados($id_personagem, $id_habilidade);

        return $relacao;
    }

    public function alterarDados(int $id_personagem, int $id_habilidade): void {

        $this->id_personagem  = $id_personagem;
        $this->id_habilidade = $id_habilidade;
    }

    public function registrarIdGerado(int $id): void {
        if ($id <= 0) {
            throw new InvalidArgumentException('ID inválido.');
        }

        $this->id = $id;
    }
}
