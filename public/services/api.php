<?php
	
	require 'vendor/autoload.php';
	require 'model/db.php';
	require 'model/Pessoa.php';
	require 'model/Usuario.php';
	require 'model/Estado.php';
	require 'model/Municipio.php';
	require 'model/Comunidade.php';
	require 'model/Catequista.php';
	require 'model/EtapaCatequese.php';
	require 'model/InscricaoCatequese.php';
	require 'model/Escola.php';
	require 'model/Turno.php';
	require 'model/TurmaCatequese.php';
	require 'model/SituacaoDizimo.php';
	require 'model/SituacaoInscricao.php';
	require 'model/conversor.php';
	require 'model/util.php';

	//require 'db_connection.php';

	$app = new \Slim\App([
		'settings' => [
			'displayErrorDetails' => true
		]
	]);

	$app->get('/', function ($request, $response) {
		echo "Genus API ";
	});

	// Verifica se o usuario possui autorizacao
	$middleAuthorization = function ($request, $response, $next) {
		if ($request->hasHeader('Authorization')) {
			//$token = explode('Basic ', $request->getHeader('Authorization')[0])[1];
			$token = $request->getHeader('Authorization')[0];
			$user = new Usuario(db::getInstance());
			$result = $user->isValidToken($token);
			if($result === true) {
				$response = $next($request, $response);
				return $response;
			} else {
				return $response->withStatus(401);
			}
		} else {
			return $response->withStatus(401);
		}
	};

	/* CRUD PESSOAS */

	// SELECT ALL
	$app->get('/pessoas', function($request, $response, $args) {
		$pessoa = new Pessoa(db::getInstance());
		$result = $pessoa->getPessoas();
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	// SELECT ONE
	$app->get('/pessoas/{id}', function($request, $response, $args) {
		$pessoa = new Pessoa(db::getInstance());
		$result = $pessoa->getPessoa($args['id']);
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	// INSERT
	$app->post('/pessoas', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$pessoa = new Pessoa(db::getInstance());
		$pessoa->loadData(null, 
						  //array_key_exists('nome', $data) ? $data['nome'] : null,
						  getAtt('nome', $data), getAtt('sexo', $data), getAtt('nomePai', $data),
						  getAtt('nomeMae', $data), getAtt('dataNascimento', $data), getAtt('telefone1', $data),
						  getAtt('telefone2', $data), getAtt('cpf', $data), getAtt('rg', $data),
						  getAtt('rgEmissor', $data), getAtt('rgUF', $data), getAtt('passaporte', $data),
						  getAtt('nacionalidade', $data), getAtt('email', $data), getAtt('logradouro', $data),
						  getAtt('numero', $data), getAtt('complemento', $data), getAtt('bairro', $data),
						  getAtt('municipioId', $data), getAtt('cep', $data), getAtt('numeroDizimo', $data),
						  getAtt('comunidadeId', $data), getAtt('observacoes', $data), getAtt('batizado', $data), getAtt('localBatismo', $data),
						  getAtt('primeiraEucaristia', $data), getAtt('localPrimeiraEucaristia', $data),
						  getAtt('status', $data), getAtt('dataUltimaAlteracao', $data), getAtt('usuarioUltimaAlteracaoId', $data)
						  );
		$result = $pessoa->addPessoa();
		return $result;
	})->add($middleAuthorization);
	

	// UPDATE
	$app->put('/pessoas/{id}', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$pessoa = new Pessoa(db::getInstance());
		$pessoa->loadData($args['id'], $data['nome'], $data['sexo'], $data['nomePai'], $data['nomeMae'],
						  $data['dataNascimento'], $data['telefone1'], $data['telefone2'], $data['cpf'], $data['rg'], 
						  $data['rgEmissor'], $data['rgUF'], $data['passaporte'], $data['nacionalidade'], 
						  $data['email'], $data['logradouro'], $data['numero'], $data['complemento'], 
						  $data['bairro'], $data['municipioId'], $data['cep'], $data['numeroDizimo'], $data['comunidadeId'],
						  $data['observacoes'], $data['batizado'], $data['localBatismo'], $data['primeiraEucaristia'],
						  $data['localPrimeiraEucaristia'], $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
						);
		$result = $pessoa->savePessoa();
		return $response->write($result);
	})->add($middleAuthorization);

	// DELETE
	$app->delete('/pessoas/{id}', function($request, $response, $args) {
		$pessoa = new Pessoa(db::getInstance());
		$pessoa->id = $args['id'];
		$result = $pessoa->deletePessoa();
		return $response->write($result);
	})->add($middleAuthorization);


	$app->post('/login', function($request, $response, $args) { 
		$data = $request->getParsedBody();
		$usuario = new Usuario(db::getInstance());    
		$result = $usuario->checkUser($data['username'], $data['password']);
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'Informações incorretas!' ))));
		} else {  
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write($result);
		}
	});

	/* ESTADOS */

	// SELECT ALL
	$app->get('/estados', function($request, $response, $args) {
		$estado = new Estado(db::getInstance());
		$result = $estado->getEstados();
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	/* ESTADOS */

	// SELECT BY UF
	$app->get('/municipios/{uf}', function($request, $response, $args) {
		$municipio = new Municipio(db::getInstance());
		$result = $municipio->getMunicipio($args['uf']);
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	/* COMUNIDADE */

	// SELECT ALL
	$app->get('/comunidades', function($request, $response, $args) {
		$comunidade = new Comunidade(db::getInstance());
		$result = $comunidade->getComunidades();
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	/* ESTADOS */

	// SELECT BY UF
	$app->get('/comunidades/{id}', function($request, $response, $args) {
		$comunidade = new Comunidade(db::getInstance());
		$result = $comunidade->getComunidade($args['id']);
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);


	/* CATEQUISTAS */

	// SELECT ALL
	$app->get('/catequistas', function($request, $response, $args) {
		$catequista = new Catequista(db::getInstance());
		$result = $catequista->getCatequistas();
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	// SELECT BY id
	$app->get('/catequistas/{id}', function($request, $response, $args) {
		$catequista = new Catequista(db::getInstance());
		$result = $catequista->getCatequista($args['id']);
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);


	// INSERT
	$app->post('/catequistas', function($request, $response, $args) {
		
		$data = $request->getParsedBody();
		//return $data;
		$catequista = new Catequista(db::getInstance());
		$catequista->loadData(null, $data['pessoaId'], $data['comunidadeId'], $data['dataInicio'],
						  $data['observacoes'], $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
						  );
		$result = $catequista->addCatequista();
		return $response->write($result);
	})->add($middleAuthorization);
	
	// UPDATE
	$app->put('/catequistas/{id}', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$catequista = new Catequista(db::getInstance());
		$catequista->loadData($args['id'], $data['pessoaId'], $data['comunidadeId'], $data['dataInicio'],
							  $data['observacoes'], $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
							  );
		$result = $catequista->saveCatequista();
		return $response->write($result);
	})->add($middleAuthorization);

	// DELETE
	$app->delete('/catequistas/{id}', function($request, $response, $args) {
		$catequista = new Catequista(db::getInstance());
		$catequista->id = $args['id'];
		$result = $catequista->deleteCatequista();
		return $response->write($result);
	})->add($middleAuthorization);

	/* ETAPAS DA CATEQUESE */

	// SELECT ALL
	$app->get('/etapas-catequese', function($request, $response, $args) {
		$etapaCatequese = new EtapaCatequese(db::getInstance());
		$result = $etapaCatequese->getEtapasCatequese();
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	/* ESCOLAS */

	// SELECT ALL
	$app->get('/escolas', function($request, $response, $args) {
		$escola = new Escola(db::getInstance());
		$result = $escola->getEscola();
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	/* TURNOS */

	// SELECT ALL
	$app->get('/turnos', function($request, $response, $args) {
		$turno = new Turno(db::getInstance());
		$result = $turno->getTurnos();
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	/* SITUACAO INSCRICAO */

	// SELECT ALL
	$app->get('/situacao-inscricao', function($request, $response, $args) {
		$situacao = new SituacaoInscricao(db::getInstance());
		$result = $situacao->getSituacoesInscricao();
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	/* SITUACAO DIZIMO */

	// SELECT ALL
	$app->get('/situacao-dizimo', function($request, $response, $args) {
		$situacao = new SituacaoDizimo(db::getInstance());
		$result = $situacao->getSituacoesDizimo();
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	/* ------------------- TURMAS CATEQUESE ------------------------- */

	// SELECT ALL
	$app->get('/turmas-catequese', function($request, $response, $args) {
		$turma = new TurmaCatequese(db::getInstance());
		$result = $turma->getTurmasCatequese();
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	// SELECT BY id
	$app->get('/turmas-catequese/{id}', function($request, $response, $args) {
		$turma = new TurmaCatequese(db::getInstance());
		$result = $turma->getTurmaCatequese($args['id']);
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	
	// INSERT
	$app->post('/turmas-catequese', function($request, $response, $args) {
		
		$data = $request->getParsedBody();
		//return $data;
		$turma = new TurmaCatequese(db::getInstance());
		$turma->loadData(null, $data['etapaCatequeseId'], $data['comunidadeId'], $data['catequistaId'], $data['observacoes'],
						 $data['turnoId'], $data['diaSemana'], $data['horario'], $data['dataInicio'], $data['dataTermino'], 
						 $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
						);
		$result = $turma->addTurmaCatequese();
		return $response->write($result);
	})->add($middleAuthorization);


	// UPDATE
	$app->put('/turmas-catequese/{id}', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$turma = new TurmaCatequese(db::getInstance());
		$turma->loadData($args['id'], $data['etapaCatequeseId'], $data['comunidadeId'], $data['catequistaId'], $data['observacoes'],
						 $data['turnoId'], $data['diaSemana'], $data['horario'], $data['dataInicio'], $data['dataTermino'], 
						 $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
						);
		$result = $turma->saveTurmaCatequese();
		return $response->write($result);
	})->add($middleAuthorization);

	// DELETE
	$app->delete('/turmas-catequese/{id}', function($request, $response, $args) {
		$turma = new TurmaCatequese(db::getInstance());
		$turma->id = $args['id'];
		$result = $turma->deleteTurmaCatequese();
		return $response->write($result);
	})->add($middleAuthorization);

	/* ---------------- INSCRICAO CATEQUESE ----------------- */

	// SELECT ALL
	$app->get('/inscricoes-catequese', function($request, $response, $args) {
		$inscricao = new InscricaoCatequese(db::getInstance());
		$result = $inscricao->getInscricoesCatequese();
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);


	// SELECT BY id
	$app->get('/inscricoes-catequese/{id}', function($request, $response, $args) {
		$inscricao = new InscricaoCatequese(db::getInstance());
		$result = $inscricao->getInscricaoCatequese($args['id']);
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);


	// INSERT
	$app->post('/inscricoes-catequese', function($request, $response, $args) {
		
		$data = $request->getParsedBody();
		//return $data;
		$inscricao = new InscricaoCatequese(db::getInstance());
		$inscricao->loadData(null, $data['pessoaId'], $data['etapaCatequeseId'], $data['escolaId'], $data['etapaEscolaId'],
							$data['turmaId'], $data['observacoes'], $data['situacaoInscricaoId'], $data['turnoId'], 
							$data['situacaoDizimoId'], $data['comunidadeId'], $data['dataInscricao'],
							$data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
						  );
		$result = $inscricao->addInscricaoCatequese();
		return $response->write($result);
	})->add($middleAuthorization);


	// UPDATE
	$app->put('/inscricoes-catequese/{id}', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$inscricao = new InscricaoCatequese(db::getInstance());
		$inscricao->loadData($args['id'], $data['pessoaId'], $data['etapaCatequeseId'], $data['escolaId'], $data['etapaEscolaId'],
							  $data['turmaId'], $data['observacoes'], $data['situacaoInscricaoId'], $data['turnoId'], 
							  $data['situacaoDizimoId'], $data['comunidadeId'], $data['dataInscricao'],
							  $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
							);
		$result = $inscricao->saveInscricaoCatequese();
		return $response->write($result);
	})->add($middleAuthorization);

	// DELETE
	$app->delete('/inscricoes-catequese/{id}', function($request, $response, $args) {
		$inscricao = new InscricaoCatequese(db::getInstance());
		$inscricao->id = $args['id'];
		$result = $inscricao->deleteInscricaoCatequese();
		return $response->write($result);
	})->add($middleAuthorization);



	// ---------------------- INICIALIZACAO ----------------------

	$app->run();

?>