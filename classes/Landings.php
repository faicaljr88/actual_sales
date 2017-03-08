<?php

require_once 'config.php';

class Landings{

	private $table = 'landing';
	private $regiao_table = 'regiao';
	private $unidade_table = 'unidade';
	
	private $nome;
	private $email;
	private $dataNasc;
	private $telefone;
	private $regiao;
	private $unidade;
	private $token;
	private $score = 10;

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function setTelefone($telefone){
		$this->telefone = $telefone;
	}

	public function setRegiao($regiao){
		$this->regiao = $regiao;
	}

	public function setUnidade($unidade){
		$this->unidade = $unidade;
	}

	public function setDataNasc($dataNasc){
		$this->dataNasc = $dataNasc;
	}

	public function setToken($token){
		$this->token = $token;
	}

	public function salvar(){
		$sql = "INSERT INTO $this->table (nome, email, telefone, data_nasc, score, token, id_regiao, id_unidade) VALUES (:nome, :email, :telefone, :dataNasc, :score, :token, :id_regiao, :id_unidade)";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":nome", $this->nome);
		$stmt->bindParam(":email", $this->email);
		$stmt->bindParam(":telefone", $this->telefone);
		$stmt->bindParam(":id_unidade", $this->unidade);
		$stmt->bindParam(":id_regiao", $this->regiao);
		$stmt->bindParam(":dataNasc", $this->dataNasc);
		$stmt->bindParam(":score", $this->score);
		$stmt->bindParam(":token", $this->token);
		return $stmt->execute();
	}

	public function calculaScore($regiao, $unidade = ''){
		if($regiao == 1){
			$this->score -= 2;
		}
		elseif($regiao == 2){
			$this->score -= 4;
		}
		elseif($regiao == 3){
			$this->score -= 3;
		}
		elseif($regiao == 4){
			$this->score -= 5;
		}
		elseif($regiao == 5 && $unidade != 1){
			$this->score -= 1;
		}
	}

	public function calculaIdade($dataNasc){
		$data = new DateTime( '2016-11-01' );
		$intervalo = $data->diff( new DateTime( $dataNasc ) );
		$idade = (int)$intervalo->format( '%Y' );

		if($idade > 100 || $idade < 18){
			$this->score -= 5;
		}
		elseif($idade >= 40 && $idade <= 99){
			$this->score -= 3;
		}
		elseif($idade >= 18 && $idade <= 39){
			$this->score -= 0;
		}
	}

	public function regiao(){

		$sql = "SELECT r.id_regiao , r.nome as regiao 
 				FROM $this->regiao_table r";
		$stmt = DB::prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function unidade($regiao = ''){

		if(isset($regiao) && $regiao != ''){
			$filtro = " WHERE r.id_regiao = " . $regiao . "";
		}

		$sql = "SELECT u.id_unidade , u.nome as unidade 
 				FROM $this->regiao_table r
 				INNER JOIN $this->unidade_table u 
 					ON u.id_regiao = r.id_regiao" . $filtro;
		$stmt = DB::prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}
}