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
    
        $relacao = new RelacaoPersonagemHabilidade(['id_usuario' => $id_usuario]);
        // $relacao->alterarDados($id_personagem, $id_habilidade);

        return $relacao;
    }

    // public function alterarDados(string $nome, string $tipo, int $ciclo, string $estilo, int $custo, string $descricao): void {
    //     $nome = trim($nome);
    //     $tipo = trim($tipo);
    //     $estilo = trim($estilo);

    //     if ($nome === '' || $tipo === '' || $estilo === '') {
    //         throw new InvalidArgumentException('Nome, tipo e estilo são obrigatórios.');
    //     }

    //     if ($ciclo < 1 || $ciclo > 6) {
    //         throw new InvalidArgumentException('O ciclo deve ser entre 1 e 6.');
    //     }

    //     //Colocar as condições de preenchimento

    //     $this->nome  = $nome;
    //     $this->tipo = $tipo;
    //     $this->ciclo = $ciclo;
    //     $this->estilo  = $estilo;
    //     $this->custo  = $custo;
    //     $this->descricao = $descricao;
    // }

    public function registrarIdGerado(int $id): void {
        if ($id <= 0) {
            throw new InvalidArgumentException('ID inválido.');
        }

        $this->id = $id;
    }
}
