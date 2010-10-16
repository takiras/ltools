<?
include 'head.php'; 
include 'input.php';
if ($_GET['word']!==null) $verb = $_GET['word'];
else $verb = 'amar';
switch(iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$verb),-2,2))) {
	case 'ar':
	case 'er':
	case 'ír':
	case 'ir':
		echo null;
		break;
	default: die;
}
//get functions
$prefix = '';
function accent($vowel) {
	switch ($vowel) {
	case 'a': return 'á';
		break;
	case 'e': return 'é';
		break;
	case 'i': return 'í';
		break;
	case 'o': return 'ó';
		break;
	case 'u': return 'ú';
		break;
	default: return $vowel;
		break;
	}
}

function deaccent($vowel) {
	switch ($vowel) {
	case 'á': return 'a';
		break;
	case 'é': return 'e';
		break;
	case 'í': return 'i';
		break;
	case 'ó': return 'o';
		break;
	case 'ú': return 'u';
		break;
	default: return $vowel;
		break;
	}
}

function get_stem($v,$person,$tense,$prefix) {
	//stem-changing verbs
	switch ($v) {
		// -ue- verbs
	case 'jugar':
		switch ($tense) {
		case 'presente':
			return 'jueg';
		case 'subjuntivo presente':
			return 'juegu';
			break;
		}
	case 'avergonzar':
		switch ($tense) {
		case 'presente':
			return 'avergüenz';
		case 'subjuntivo presente':
			return 'avergüenc';
			break;
		}
		break;
		// o -> ue + zar
	case 'forzar':
	case 'almorzar':
	case 'disforzar':
	case 'esforzar':
	case 'reforzar':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$o_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',$v)),'o');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'ue' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1));
				break;
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		case 'subjuntivo presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$o_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',$v)),'o');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'ue' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1,-1)) . 'c';
				break;
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		}
	case 'rogar':
	case 'colgar':
	case 'descolgar':
	case 'holgar':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$o_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',$v)),'o');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'ue' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1));
				break;
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		case 'subjuntivo presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$o_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',$v)),'o');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'ue' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1)) . 'u';
				break;
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		} 
		break;	
	case 'escocer':
	case 'cocer':
	case 'recocer':
	case 'retorcer':
	case 'torcer':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0:
				$o_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',$v)),'o');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'ue' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1,-1)) . 'z';
				break;
			case 1:
			case 2:
			case 5:
				$o_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',$v)),'o');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'ue' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1));
				break;
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		case 'subjuntivo presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$o_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',$v)),'o');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'ue' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1,-1)) . 'z';
				break;
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'z';
				break;
			}
		} 
		break;		
	case 'volcar':
	case 'emporcar':
	case 'revolcar':
	case 'trastocar':
	case 'trastrocar':
	case 'trocar':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$o_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',$v)),'o');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'ue' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1));
				break;
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		case 'subjuntivo presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$o_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',$v)),'o');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'ue' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1,-1)) . 'qu';
				break;
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		}
		break;
		// o -> ue
	case 'acordar':
	case 'acostar':
	case 'afollar':
	case 'aforar':
	case 'amoblar':
	case 'amolar':
	case 'apostar':
	case 'aprobar':
	case 'asolar':
	case 'asonar':
	case 'atronar':
	case 'colar':
	case 'comprobar':
	case 'concordar':
	case 'consolar':
	case 'costar':
	case 'demostrar':
	case 'denostar':
	case 'desacordar':
	case 'desaforar':
	case 'desaprobar':
	case 'descollar':
	case 'desconsolar':
	case 'descontar':
	case 'descornar':
	case 'desencontrar':
	case 'desolar':
	case 'desollar':
	case 'despoblar':
	case 'discordar':
	case 'disonar':
	case 'encontrar':
	case 'engrosar':
	case 'escornar':
	case 'hollar':
	case 'mancornar':
	case 'mostrar':
	case 'poblar':
	case 'probar':
	case 'recontar':
	case 'recordar':
	case 'recostar':
	case 'reencontrar':
	case 'renovar':
	case 'repoblar':
	case 'reprobar':
	case 'resollar':
	case 'resonar':
	case 'rodar':
	case 'sobrevolar':
	case 'solar':
	case 'soldar':
	case 'soltar':
	case 'sonar':
	case 'soñar':
	case 'superpoblar':
	case 'tostar':
	case 'tronar':
	case 'volar':
	case 'moler':
	case 'condoler':
	case 'conmover':
	case 'demoler':
	case 'doler':
	case 'llover':
	case 'morder':
	case 'promover':
	case 'remorder':
	case 'remover':
	case 'resolver':
	case 'volver':
	case 'acostar':
	case 'almorzar':
	case 'contar':
	case 'costar':
	case 'doler':
	case 'encontrar':
	case 'mostrar':
	case 'oler':
	case 'poder':
	case 'probar':
	case 'recorder':
	case 'soler':
	case 'soltar':
	case 'sonar':
	case 'soñar':
	case 'volar':
	case 'volver':
		switch ($tense) {
		case 'presente':
		case 'subjuntivo presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$o_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',$v)),'o');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'ue' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1));
				break;
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		}
		break;
		// -i- verbs
	case 'pedir':
	case 'acomedir':
	case 'comedir':
	case 'competir':
	case 'concebir':
	case 'derretir':
	case 'desmedir':
	case 'despedir':
	case 'desvestir':
	case 'embestir':
	case 'expedir':
	case 'gemir':
	case 'henchir':
	case 'impedir':
	case 'investir':
	case 'medir':
	case 'preconcebir':
	case 'rendir':
	case 'repetir':
	case 'revestir':
	case 'servir':
	case 'travestir':
	case 'vestir':
	case 'ceñir':
	case 'constreñir':
	case 'desceñir':
	case 'desteñir':
	case 'estreñir':
	case 'teñir':
	case 'reír':
		switch ($tense) {
		case 'presente':
		case 'subjuntivo presente':
		case 'gerundio':
			$e_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,-2)))),'e');
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				if ($v!=='reír') return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'i' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1));
				else return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'í' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1));
				break;
			case 3:
			case 4:
				if ($tense=='subjuntivo presente') return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'í' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1));
				else return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,-2));
				break;
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 2:
			case 5:
				$e_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,-2)))),'e');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'i' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1));
				break;
			}
			break;
		}
		break;
	case 'sentir':
	case 'adherir':
	case 'advertir':
	case 'arrepentir':
	case 'asentir':
	case 'circunferir':
	case 'conferir':
	case 'consentir':
	case 'convertir':
	case 'desmentir':
	case 'diferir':
	case 'digerir':
	case 'disentir':
	case 'divertir':
	case 'herir':
	case 'hervir':
	case 'inferir':
	case 'ingerir':
	case 'injerir':
	case 'interferir':
	case 'invertir':
	case 'malherir':
	case 'mentir':
	case 'pervertir':
	case 'preferir':
	case 'presenteir':
	case 'proferir':
	case 'reconvertir':
	case 'referir':
	case 'reinvertir':
	case 'requerir':
	case 'resentir':
	case 'revertir':
	case 'subvertir':
	case 'sugerir':
	case 'transferir':
	case 'trasferir':
	case 'zaherir':
		$e_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,-2)))),'e');
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'ie' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1));;
				break;
			}
			break;
		case 'subjuntivo presente':
			switch ($person) {
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'i' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1));
				break;
			}
			break;
		case 'gerundio':
			return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'i' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1));
			break;
		case 'pretérito':
			switch ($person) {
			case 2:
			case 5:
				$e_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,-2)))),'e');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'i' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1));
				break;
			}
			break;
		}
		break;
	case 'morir':
	case 'dormir':
		$o_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,-2)))),'o');
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'ue' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1));;
				break;
			}
			break;
		case 'subjuntivo presente':
			switch ($person) {
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'u' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1));
				break;
			}
			break;
		case 'gerundio':
			return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'u' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1));
			break;
		case 'pretérito':
			switch ($person) {
			case 2:
			case 5:
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'u' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1));
				break;
			}
			break;
		}
		break;
	case 'decir':
	case 'seguir':
	case 'erguir':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$e_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,-2)))),'e');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'i' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1));
				break;
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,-2));
				break;
			}
		case 'pretérito':
			switch ($person) {
			case 2:
			case 5:
				$e_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,-2)))),'e');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'i' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1));
				break;
			}
			break;
		}
		break;
		// -ie- verbs
	case 'acrecentar':
	case 'alentar':
	case 'apacentar':
	case 'apretar':
	case 'arrendar':
	case 'asentar':
	case 'aserrar':
	case 'aterrar':
	case 'atestar':
	case 'atravesar':
	case 'aventar':
	case 'beldar':
	case 'calentar':
	case 'cerrar':
	case 'cimentar':
	case 'concertar':
	case 'confesar':
	case 'dentar':
	case 'desacertar':
	case 'desalentar':
	case 'desaterrar':
	case 'desconcertar':
	case 'desenterrar':
	case 'desgobernar':
	case 'deshelar':
	case 'desmembrar':
	case 'despertar':
	case 'desterrar':
	case 'emparentar':
	case 'empedrar':
	case 'encerrar':
	case 'encomendar':
	case 'enmelar':
	case 'enmendar':
	case 'ensangrentar':
	case 'enterrar':
	case 'entrecerrar':
	case 'escarmentar':
	case 'gobernar':
	case 'helar':
	case 'herrar':
	case 'incensar':
	case 'invernar':
	case 'manifestar':
	case 'melar':
	case 'mentar':
	case 'merendar':
	case 'nevar':
	case 'pensar':
	case 'quebrar':
	case 'recalentar':
	case 'recomendar':
	case 'remendar':
	case 'repensar':
	case 'requebrar':
	case 'reventar':
	case 'salpimentar':
	case 'sembrar':
	case 'sentar':
	case 'serrar':
	case 'sobrecalentar':
	case 'soterrar':
	case 'subarrendar':
	case 'temblar':
	case 'tentar':
	case 'ascender':
	case 'atender':
	case 'defender':
	case 'cerner':
	case 'condescender':
	case 'contender':
	case 'desatender':
	case 'descender':
	case 'desentender':
	case 'distender':
	case 'encender':
	case 'extender':
	case 'heder':
	case 'hender':
	case 'malentender':
	case 'perder':
	case 'reverter':
	case 'sobreentender':
	case 'sobrentender':
	case 'subtender':
	case 'tender':
	case 'transcender':
	case 'trascender':
	case 'verter':
	case 'adquirir':
	case 'inquirir':
	case 'discernir':
	case 'cernir':
	case 'concernir':
	case 'hendir':
	case 'advertir':
	case 'ascender':
	case 'atravesar':
	case 'cerrar':
	case 'descender':
	case 'despertar':
	case 'divertir':
	case 'divertir':
	case 'entender':
	case 'mentir':
	case 'pensar':
	case 'perder':
	case 'preferir':
	case 'quebrar':
	case 'querer':
	case 'recomendar':
	case 'sentar':
	case 'sentir':
		switch ($tense) {
		case 'presente':
		case 'subjuntivo presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$i_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2))))),'i');
				$e_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2))))),'e');
				if ($i_position > $e_position) $e_position = $i_position;
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'ie' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1));
				break;
			case 3:
			case 4:
				if ($tense=='presente') return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		}
		break;
	case 'negar':
	case 'anegar':
	case 'cegar':
	case 'denegar':
	case 'desasosegar':
	case 'desplegar':
	case 'estregar':
	case 'fregar':
	case 'plegar':
	case 'refregar':
	case 'regar':
	case 'renegar':
	case 'replegar':
	case 'restregar':
	case 'segar':
	case 'sosegar':
	case 'trasegar':
		switch ($tense) {
		case 'presente':
		case 'gerundio':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$e_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2))))),'e');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'ie' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1));
				break;
			case 3:
			case 4:
				if ($tense=='presente') return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		case 'subjuntivo presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$e_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2))))),'e');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'ie' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1)) . 'u';
				break;
			case 3:
			case 4:
				if ($tense=='presente') return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		}
		break;
	case 'tropezar':
	case 'comenzar':
	case 'empezar':
	case 'recomenzar':
		switch ($tense) {
		case 'presente':
		case 'gerundio':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$e_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2))))),'e');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'ie' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1));
				break;
			case 3:
			case 4:
				if ($tense=='presente') return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		case 'subjuntivo presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$e_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2))))),'e');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'ie' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1,-1)) . 'c';
				break;
			case 3:
			case 4:
				if ($tense=='presente') return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		}
		break;
		//o -> üe
	case 'degollar':
	case 'regoldar':
	case 'avergonzar':
		switch ($tense) {
		case 'presente':
		case 'subjuntivo presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$o_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2))))),'o');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$o_position)) . 'üe' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$o_position+1));
				break;
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		}
		break;
		//au/ahu -> aú/ahú, ua -> úa
	case 'aullar':
	case 'ahumar':
	case 'ahusar':
	case 'aunar':
	case 'aupar':
	case 'maullar':
	case 'rehusar':
	case 'sahumar':
	case 'reunir':
		switch ($tense) {
		case 'presente':
		case 'subjuntivo presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$u_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2))))),'u');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$u_position)) . 'ú' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$u_position+1));
				break;
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		}
		break;
		//ai -> aí
	case 'aislar':
	case 'ahijar':
	case 'ahitar':
	case 'airar':
	case 'amohinar':
	case 'desahijar':
	case 'desairar':
	case 'descafeinar':
	case 'prohijar':
	case 'rehilar':
	case 'sobrehilar':
	case 'vaciar':
	case 'aliar':
	case 'amnistiar':
	case 'ampliar':
	case 'arriar':
	case 'ataviar':
	case 'averiar':
	case 'aviar':
	case 'cablegrafiar':
	case 'taquigrafiar':
	case 'biografiar':
	case 'calcografiar':
	case 'caligrafiar':
	case 'chirriar':
	case 'ciar':
	case 'confiar':
	case 'contrariar':
	case 'criar':
	case 'desafiar':
	case 'descarriar':
	case 'desconfiar':
	case 'desliar':
	case 'desvariar':
	case 'desviar':
	case 'enfriar':
	case 'enviar':
	case 'escalofriar':
	case 'espiar':
	case 'esquiar':
	case 'estriar':
	case 'expatriar':
	case 'expiar':
	case 'extasiar':
	case 'extraviar':
	case 'fiar':
	case 'fotografiar':
	case 'guiar':
	case 'hastiar':
	case 'inventariar':
	case 'liar':
	case 'malcriar':
	case 'mecanografiar':
	case 'piar':
	case 'porfiar':
	case 'radiografiar':
	case 'recriar':
	case 'reenviar':
	case 'resfriar':
	case 'rociar':
	case 'sumariar':
	case 'telegrafiar':
	case 'variar':
	case 'vidriar':
	case 'xerografiar':
	case 'cohibir':
	case 'prohibir':
		switch ($tense) {
		case 'presente':
		case 'subjuntivo presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$i_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2))))),'i');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$i_position)) . 'í' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$i_position+1));
				break;
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		}
		break;
	case 'tener':
	case 'venir':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				$e_position = strripos(iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2))))),'e');
				return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,$e_position)) . 'ie' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',get_stem($v,3,'presente','')),$e_position+1));
				break;
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			}
		}
		break;
		//other irregulars
	case 'ser':
		switch ($tense) {
		case 'subjuntivo presente':
			return 'se';
			break;
		}
		break;
	case 'haber':
		switch ($tense) {
		case 'subjuntivo presente':
			return 'hay';
			break;
		}
		break;
	case 'ir':
		switch ($tense) {
		case 'subjuntivo presente':
			return 'vay';
			break;
		}
		break;
	case 'saber':
		switch ($tense) {
		case 'subjuntivo presente':
			return 'sep';
			break;
		}
		break;
	case 'hacer':
		switch ($tense) {
		case 'subjuntivo presente':
			return 'hag';
			break;
		}
		break;
	case 'satisfacer':
		switch ($tense) {
		case 'subjuntivo presente':
			return 'satisfag';
			break;
		}
		break;
	case 'mecer':
	case 'coercer':
	case 'convencer':
	case 'ejercer':
	case 'vencer':
		switch ($tense) {
		case 'presente':
		case 'subjuntivo presente':
			if ($v!=='decir' AND ($person==0 OR $tense=='subjuntivo presente'))return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'z';
			break;
		}
		break;
	}
	//stem-end modification
	switch (substr($v,-4)) {
	case 'quir':
		switch ($tense) {
		case 'presente':
		case 'subjuntivo presente':
			if ($person==0 OR $tense=='subjuntivo presente')return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-4))) . 'c';
			break;
		}
		break;
	case 'guir':
		switch ($tense) {
		case 'presente':
		case 'subjuntivo presente':
			if ($person==0 OR $tense=='subjuntivo presente')return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-4))) . 'g';
			break;
		}
		break;
	}
	switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3))) {
	case 'gar':
		switch ($tense ) {
		case 'pretérito':
		case 'subjuntivo presente':
			if ($person==0 OR $tense=='subjuntivo presente') return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2))) . 'u';
			break;
		}
		break;
	case 'car':
		switch ($tense) {
		case 'pretérito':
		case 'subjuntivo presente':
			if ($person==0 OR $tense=='subjuntivo presente') return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'qu';
			break;
		}
		break;
	case 'uir':
	case 'aír':
		switch ($tense) {
		case 'presente':
			switch ($v) {
			case 'huir':
			case 'afluir':
			case 'atribuir':
			case 'concluir':
			case 'confluir':
			case 'constituir':
			case 'construir':
			case 'contribuir':
			case 'derruir':
			case 'destituir':
			case 'destruir':
			case 'desvaír':
			case 'diluir':
			case 'disminuir':
			case 'distribuir':
			case 'efluir':
			case 'estatuir':
			case 'excluir':
			case 'fluir':
			case 'gruir':
			case 'imbuir':
			case 'incluir':
			case 'influir':
			case 'inmiscuir':
			case 'instituir':
			case 'instruir':
			case 'intuir':
			case 'obstruir':
			case 'ocluir':
			case 'prostituir':
			case 'recluir':
			case 'reconstituir':
			case 'reconstruir':
			case 'redistribuir':
			case 'refluir':
			case 'restituir':
			case 'retribuir':
			case 'substituir':
			case 'sustituir':
				switch ($person) {
				case 0:
				case 1:
				case 2:
				case 5: return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,-2)) . 'y';
				}
				break;
			}
			break;
		}
		break;
	case 'cer':
		switch ($tense) {
		case 'presente':
		case 'subjuntivo presente':
			if ($person==0 OR $tense=='subjuntivo presente') return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'zc';
			break;
		}
		break;
	case 'cir':
		switch ($tense) {
		case 'presente':
			switch ($v) {
			case 'lucir':
			case 'balbucir':
			case 'deslucir':
			case 'enlucir':
			case 'entrelucir':
			case 'relucir':
			case 'translucir':
			case 'traslucir':
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'zc';
			}
			if ($v!=='decir' AND $person==0)return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'z';
			break;
		}
		break;
	case 'ger':
	case 'gir':
		switch ($tense) {
		case 'presente':
			if ($person==0) return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'j';
			break;
		}
		break;
	case 'zar':
		switch (substr($v,-5)) {
		case 'aizar':
		case 'eizar':
			switch ($tense ) {
			case 'presente':
				if ($person!==3 AND $person!==4) return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-4))) . 'í' . iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,-3,1)));
				break;
			case 'subjuntivo presente':
				if ($person!==3 AND $person!==4) return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-4))) . 'íc';
				break;
			}
		}
		switch ($tense ) {
		case 'pretérito':
		case 'subjuntivo presente':
			if ($person==0 OR $tense=='subjuntivo presente') return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'c';
			break;
		}
		break;
	case 'uar':
		switch (substr($v,-4)) {
		case 'guar':
			switch ($tense ) {
			case 'pretérito':
			case 'subjuntivo presente':
				if ($person==0 OR $tense=='subjuntivo presente') return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'ü';
			}
			break;
		}
		switch ($tense ) {
		case 'presente':
		case 'subjuntivo presente':
			switch ($v) {
			case 'adecuar':
			case 'anticuar':
			case 'apropincuar':
			case 'evacuar':
			case 'menstruar':
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				break;
			default:
				switch ($person) {
				case 0:
				case 1:
				case 2:
				case 5:
					return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'ú';
					break;
				default: return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2)));
				}
				break;
			}
			break;
		}
		break;
	}
	switch ($tense) {
		//futuro stems
	case 'futuro';
	case 'condicional';
		switch ($v) {
			//irregular futuro stems
		case 'venir': return 'vendr';
		case 'poder': return 'podr';
		case 'poner': return 'pondr';
		case 'tener': return 'tendr';
		case 'haber': return 'habr';
		case 'salir': return 'saldr';
		case 'querer': return 'querr';
		case 'valer': return 'valdr';
		case 'saber': return 'sabr';
		case 'hacer': return 'har';
		case 'satisfacer': return 'satisfar';
		case 'decir': return 'dir';
		case 'caber': return 'cabr';
			break;
		default:
			$futuro_stem = '';
			for ($i=0; $i<strlen(iconv('UTF-8','ISO-8859-1',$v)); $i++) {
				$futuro_stem = $futuro_stem . deaccent(iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),$i,1)));
			}
			return $futuro_stem;
		}
		break;
		//subjuntivo stems
	case 'subjuntivo presente':
		return substr(conjugate($v,0,'presente',$prefix),0,strripos(conjugate($v,0,'presente',$prefix),'o'));
		break;
	case 'subjuntivo futuro':
	case 'subjuntivo imperfecto 1':
	case 'subjuntivo imperfecto 2':
		if ($person == 3) return substr(get_stem($v,0,'subjuntivo futuro',$prefix),0,-1) . accent(substr(get_stem($v,0,'subjuntivo futuro',$prefix),-1));
		return substr(conjugate($v,5,'pretérito',$prefix),0,-3);
		break;
		//if it's nothing special
	default:
		return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,-2));
		break;
	}
}

function conjugate($v,$person,$tense,$prefix) {
	//get the stem
	$verb_stem = get_stem($v,$person,$tense,$prefix);
	if (strstr($tense,' perfecto')!==false OR strstr($tense,'pluscuamperfecto')!==false OR strstr($tense,'past anterior')!==false OR $tense=='perfecto' OR $tense=='negativo imperativo') $compound_tense = true;
	else $compound_tense= false;
	switch ($v) {
		//irregular verbs
	case 'caer':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'caigo';
			}
			break;
		}
		break;
	case 'ser':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'soy';
			case 1: return 'eres';
			case 2: return 'es';
			case 3: return 'somos';
			case 4: return 'sois';
			case 5: return 'son';
			}
			break;
		case 'imperfecto':
			if ($person==3) return 'éramos';
			return 'er' . iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',conjugate('er',$person,$tense,$prefix)),1));
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'fui';
			case 1: return 'fuiste';
			case 2: return 'fue';
			case 3: return 'fuimos';
			case 4: return 'fuisteis';
			case 5: return 'fueron';
			}
			break;
		case 'positivo imperativo':
			if ($person==1) return 'sé';
			break;
		}
		break;
	case 'haber':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'he';
			case 1: return 'has';
			case 2: return 'ha';
			case 3: return 'hemos';
			case 5: return 'han';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'hube';
			case 1: return 'hubiste';
			case 2: return 'hubo';
			case 3: return 'hubimos';
			case 4: return 'hubisteis';
			case 5: return 'hubieron';
			}
			break;
		}
	case 'traer':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'traigo';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'traje';
			case 1: return 'trajiste';
			case 2: return 'trajo';
			case 3: return 'trajimos';
			case 4: return 'trajisteis';
			case 5: return 'trajeron';
			}
			break;
		}
		break;
	case 'reír':
		switch ($tense) {
		case 'gerundio':
			return 'riendo';
			break;
		case 'presente':
			switch ($person) {
			case 3: return 'reímos';
			}
		case 'subjuntivo presente':
			switch ($person) {
			case 4: return 'riáis';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 2: return 'rió';
			case 5: return 'rieron';
			}
			break;
		}
		break;
	case 'estar':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'estoy';
			case 1: return 'estás';
			case 2: return 'está';
			case 5: return 'están';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'estuve';
			case 1: return 'estuviste';
			case 2: return 'estuvo';
			case 3: return 'estuvimos';
			case 4: return 'estuvisteis';
			case 5: return 'estuvieron';
			}
		case 'subjuntivo presente':
			switch ($person) {
			case 0: return 'esté';
			case 1: return 'estés';
			case 2: return 'esté';
			case 5: return 'estén';
			}
			break;
		}
		break;
	case 'desosar':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'deshueso';
			case 1: return 'deshuesas';
			case 2: return 'deshuesa';
			case 5: return 'deshuesan';
			}
			break;
		case 'subjuntivo presente':
			switch ($person) {
			case 0: return 'deshuese';
			case 1: return 'deshueses';
			case 2: return 'deshuese';
			case 5: return 'deshuesen';
			}
			break;
		}
		break;
	case 'dar':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'doy';
			case 4: return 'dais';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'di';
			case 1: return 'diste';
			case 2: return 'di';
			case 3: return 'dimos';
			case 4: return 'disteis';
			case 5: return 'dieron';
			}
		case 'subjuntivo presente':
			switch ($person) {
			case 0: return 'dé';
			case 2: return 'dé';
			case 4: return 'deis';
			}
			break;
		}
		break;
	case 'andar':
		switch ($tense) {
		case 'pretérito':
			switch ($person) {
			case 0: return 'anduve';
			case 1: return 'anduviste';
			case 2: return 'anduvo';
			case 3: return 'anduvimos';
			case 4: return 'anduvisteis';
			case 5: return 'anduvieron';
			}
		}
		break;
	case 'elegir':
	case 'colegir':
	case 'corregir':
	case 'reelegir':
	case 'regir':
		switch ($tense) {
		case 'gerundio':
			return substr($v,0,-4) . 'igiendo';
			break;
		case 'past participle':
			return $prefix . substr($v,0,-4) . 'gido, ' . $prefix . substr($v,0,-4) . 'ecto';
			break;
		case 'presente':
			switch ($person) {
			case 0: return substr($v,0,-4) . 'ijo';
			case 1: return substr($v,0,-4) . 'iges';
			case 2: return substr($v,0,-4) . 'ige';
			case 5: return substr($v,0,-4) . 'igen';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 2: return substr($v,0,-4) . 'igió';
			case 5: return substr($v,0,-4) . 'igieron';
			}
			break;
		}
		break;
	case 'tener':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'tengo';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'tuve';
			case 1: return 'tuviste';
			case 2: return 'tuvo';
			case 3: return 'tuvimos';
			case 4: return 'tuvisteis';
			case 5: return 'tuvieron';
			}
			break;
		case 'positivo imperativo':
			if ($person==1) return 'ten';
			break;
		}
		break;
	case 'valer':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'valgo';
			}
			break;
		}
		break;
	case 'pudrir':
		switch ($tense) {
		case 'past participle':
			return $prefix . 'podrido';
			break;
		}
		break;
	case 'salir':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'salgo';
			}
			break;
		case 'positivo imperativo':
			if ($person==1) return 'sal';
			break;
		}
		break;
	case 'poner':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'pongo';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'puse';
			case 1: return 'pusiste';
			case 2: return 'puso';
			case 3: return 'pusimos';
			case 4: return 'pusisteis';
			case 5: return 'pusieron';
			}
			break;
		case 'past participle':
			return $prefix . 'puesto';
			break;
		case 'positivo imperativo':
			if ($person==1) return 'pon';
			break;
		}
		break;
	case 'rehuir':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'rehúyo';
			case 1: return 'rehúyes';
			case 2: return 'rehúye';
			case 5: return 'rehúyen';
			}
			break;
		}
		break;
	case 'ver':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'veo';
			case 4: return 'veis';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'vi';
			case 2: return 'vio';
			}
			break;
		case 'imperfecto':
			return conjugate('veer',$person,$tense,$prefix);
			break;
		case 'past participle':
			return $prefix . 'visto';
			break;
		}
		break;
	case 'prever':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'preveo';
			case 1: return 'prevés';
			case 2: return 'prevé';
			case 5: return 'prevén';
			}
			break;
		case 'imperfecto':
			return conjugate('preveer',$person,$tense,$prefix);
			break;
		case 'past participle':
			return $prefix . 'previsto';
			break;
		}
		break;
	case 'entrever':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'entreveo';
			case 1: return 'entrevés';
			case 2: return 'entrevé';
			case 5: return 'entrevén';
			}
			break;
		case 'imperfecto':
			return conjugate('entreveer',$person,$tense,$prefix);
			break;
		case 'past participle':
			return $prefix . 'entrevisto';
			break;
		}
		break;
	case 'oler':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'huelo';
			case 1: return 'hueles';
			case 2: return 'huele';
			case 5: return 'huelen';
			}
			break;
		case 'subjuntivo presente':
			switch ($person) {
			case 0: return 'huela';
			case 1: return 'huelas';
			case 2: return 'huela';
			case 5: return 'huelan';
			}
			break;
		}
		break;
	case 'oír':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'oigo';
			case 1: return 'oyes';
			case 2: return 'oye';
			case 3: return 'oímos';
			case 5: return 'oyen';
			}
			break;
		}
		break;
	case 'raer':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'raigo';
			}
			break;
		}
		break;
	case 'asir':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'asgo';
			}
			break;
		}
		break;
	case 'ir':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'voy';
			case 4: return 'vais';
			default: return conjugate('var',$person,$tense,$prefix);
			}
		case 'imperfecto':
			switch ($person) {
			case 0: return 'iba';
			case 1: return 'ibas';
			case 2: return 'iba';
			case 3: return 'íbamos';
			case 4: return 'ibais';
			case 5: return 'iban';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'fui';
			case 1: return 'fuiste';
			case 2: return 'fue';
			case 3: return 'fuimos';
			case 4: return 'fuisteis';
			case 5: return 'fueron';
			}
			break;
		case 'positivo imperativo':
			if ($person==1) return 've';
			if ($person==3) return 'vamos/vayamos';
			break;
		case 'gerundio':
			return 'yendo';
			break;
		}
		break;
	case 'venir':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'vengo';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'vine';
			case 1: return 'viniste';
			case 2: return 'vino';
			case 3: return 'vinimos';
			case 4: return 'vinisteis';
			case 5: return 'vinieron';
			}
			break;
		case 'positivo imperativo':
			if ($person==1) return 'ven';
			break;
		case 'gerundio':
			return 'viniendo';
			break;
		}
		break;
	case 'querer':
		switch ($tense) {
		case 'pretérito':
			switch ($person) {
			case 0: return 'quise';
			case 1: return 'quisiste';
			case 2: return 'quiso';
			case 3: return 'quisimos';
			case 4: return 'quisisteis';
			case 5: return 'quisieron';
			}
			break;
		}
		break;
	case 'caber':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'quepo';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'cupe';
			case 1: return 'cupiste';
			case 2: return 'cupo';
			case 3: return 'cupimos';
			case 4: return 'cupisteis';
			case 5: return 'cupieron';
			}
			break;
		}
		break;
	case 'saber':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'sé';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'supe';
			case 1: return 'supiste';
			case 2: return 'supo';
			case 3: return 'supimos';
			case 4: return 'supisteis';
			case 5: return 'supieron';
			}
			break;
		}
		break;
	case 'argüir':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'arguyo';
			case 1: return 'arguyes';
			case 2: return 'arguye';
			case 5: return 'arguyen';
			}
			break;
		}
		break;
	case 'ducir':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'duzco';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'duje';
			case 1: return 'dujiste';
			case 2: return 'dujo';
			case 3: return 'dujimos';
			case 4: return 'dujisteis';
			case 5: return 'dujeron';
			}
			break;
		}
		break;
	case 'erguir':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'irgo';
			}
			break;
		}
		break;
	case 'seguir':
		switch ($tense) {
		case 'presente':
			switch ($person) {
			case 0: return 'sigo';
			}
			break;
		}
		break;
	case 'decir':
		switch ($tense) {
		case $prefix . 'past participle':
			return 'dicho';
		case 'presente':
			switch ($person) {
			case 0: return 'digo';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'dije';
			case 1: return 'dijiste';
			case 2: return 'dijo';
			case 3: return 'dijimos';
			case 4: return 'dijisteis';
			case 5: return 'dijeron';
			}
			break;
		case 'positivo imperativo':
			if ($person==1) return 'di';
			break;
		}
		break;
	case 'satisfacer':
		switch ($tense) {
		case 'past participle':
			return $prefix . 'satisfecho';
		case 'presente':
			switch ($person) {
			case 0: return 'satisfago';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'satisfice';
			case 1: return 'satisficiste';
			case 2: return 'satisfizo';
			case 3: return 'satisficimos';
			case 4: return 'satisficisteis';
			case 5: return 'satisficieron';
			}
			break;
		case 'positivo imperativo':
			if ($person==1) return 'satisfaz';
			break;
		}
		break;
	case 'hacer':
		switch ($tense) {
		case $prefix . 'past participle':
			return 'hecho';
		case 'presente':
			switch ($person) {
			case 0: return 'hago';
			}
			break;
		case 'pretérito':
			switch ($person) {
			case 0: return 'hice';
			case 1: return 'hiciste';
			case 2: return 'hizo';
			case 3: return 'hicimos';
			case 4: return 'hicisteis';
			case 5: return 'hicieron';
			}
			break;
		case 'positivo imperativo':
			if ($person==1) return 'haz';
			break;
		}
		break;
	case 'poder':
		switch ($tense) {
		case 'pretérito':
			switch ($person) {
			case 0: return 'pude';
			case 1: return 'pudiste';
			case 2: return 'pudo';
			case 3: return 'pudimos';
			case 4: return 'pudisteis';
			case 5: return 'pudieron';
			}
			break;
		}
		break;
		//compound verbs
	case 'advenir':
	case 'antevenir':
	case 'aprevenir':
	case 'avenir':
	case 'circunvenir':
	case 'contravenir':
	case 'convenir':
	case 'desavenir':
	case 'desconvernir':
	case 'desprevenir':
	case 'devenir':
	case 'disconvenir':
	case 'entrevenir':
	case 'evenir':
	case 'intervenir':
	case 'invenir':
	case 'prevenir':
	case 'provenir':
	case 'reconvenir':
	case 'revenir':
	case 'sobrevenir':
	case 'subvenir':
	case 'supervenir':
		$prefix2=substr($v,0,stripos($v,'venir'));
		switch ($tense) {
		case 'positivo imperativo':
			switch ($person) {
			case 1: return substr($v,0,-4) . 'én';
			}
			break;
		}
		if ($compound_tense==true or conjugate('venir',$person,$tense,$prefix2)=='') return conjugate('venir',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('venir',$person,$tense,$prefix);
		break;    
	case 'bendecir':
	case 'maldecir':
		$prefix2=substr($v,0,stripos($v,'decir'));
		if ($compound_tense==true or conjugate('decir',$person,$tense,$prefix2)=='') return conjugate('decir',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('decir',$person,$tense,$prefix);
		break;       
	case 'sobresalir':
		$prefix2=substr($v,0,stripos($v,'salir'));
		if ($compound_tense==true or conjugate('salir',$person,$tense,$prefix2)=='') return conjugate('salir',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('salir',$person,$tense,$prefix);
		break;    
	case 'repudrir':
		$prefix2=substr($v,0,stripos($v,'pudrir'));
		if ($compound_tense==true or conjugate('pudrir',$person,$tense,$prefix2)=='') return conjugate('pudrir',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('pudrir',$person,$tense,$prefix);
		break;    
	case 'conducir':
	case 'aducir':
	case 'deducir':
	case 'inducir':
	case 'introducir':
	case 'producir':
	case 'reconducir':
	case 'reducir':
	case 'reproducir':
	case 'seducir':
	case 'traducir':
		$prefix2=substr($v,0,stripos($v,'ducir'));
		if ($compound_tense==true or conjugate('ducir',$person,$tense,$prefix2)=='') return conjugate('ducir',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('ducir',$person,$tense,$prefix);
		break;    
	case 'equivaler':
	case 'prevaler':
		$prefix2=substr($v,0,stripos($v,'valer'));
		if ($compound_tense==true or conjugate('valer',$person,$tense,$prefix2)=='') return conjugate('valer',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('valer',$person,$tense,$prefix);
	case 'reargüir':
	case 'redargüir':
		$prefix2=substr($v,0,stripos($v,'argüir'));
		if ($compound_tense==true or conjugate('argüir',$person,$tense,$prefix2)=='') return conjugate('argüir',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('argüir',$person,$tense,$prefix);
		break;    
	case 'retener':
	case 'abstener':
	case 'atener':
	case 'contener':
	case 'detener':
	case 'entretener':
	case 'mantener':
	case 'obtener':
	case 'sostener':
		$prefix2=substr($v,0,stripos($v,'tener'));
		switch ($tense) {
		case 'positivo imperativo':
			switch ($person) {
			case 1: return substr($v,0,-4) . 'én';
			}
			break;
		}
		if ($compound_tense==true or conjugate('tener',$person,$tense,$prefix2)=='') return conjugate('tener',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('tener',$person,$tense,$prefix);
		break;
	case 'predecir':
	case 'desdecir':
	case 'contradecir':
		$prefix2=substr($v,0,stripos($v,'decir'));
		switch ($tense) {
		case 'positivo imperativo':
			switch ($person) {
			case 1: return substr($v,0,-4) . 'ice';
			}
			break;
		}
		if ($compound_tense==true or conjugate('decir',$person,$tense,$prefix2)=='') return conjugate('decir',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('decir',$person,$tense,$prefix);
		break;
	case 'reponer':
	case 'anteponer':
	case 'aponer':
	case 'componer':
	case 'contraponer':
	case 'deponer':
	case 'descomponer':
	case 'disponer':
	case 'exponer':
	case 'imponer':
	case 'indisponer':
	case 'interponer':
	case 'oponer':
	case 'posponer':
	case 'predisponer':
	case 'presuponer':
	case 'proponer':
	case 'recomponer':
	case 'sobreponer':
	case 'superponer':
	case 'suponer':
	case 'transponer':
	case 'yuxtaponer':
		$prefix2=substr($v,0,stripos($v,'poner'));
		switch ($tense) {
		case 'positivo imperativo':
			switch ($person) {
			case 1: return substr($v,0,-4) . 'ón';
			}
			break;
		}
		if ($compound_tense==true or conjugate('poner',$person,$tense,$prefix2)=='') return conjugate('poner',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('poner',$person,$tense,$prefix);
		break;    
	case 'bienquerer':
	case 'malquerer':
		$prefix2=substr($v,0,stripos($v,'querer'));
		if ($compound_tense==true or conjugate('querer',$person,$tense,$prefix2)=='') return conjugate('querer',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('querer',$person,$tense,$prefix);
		break;    
	case 'deshacer':
		$prefix2=substr($v,0,stripos($v,'hacer'));
		if ($compound_tense==true or conjugate('hacer',$person,$tense,$prefix2)=='') return conjugate('hacer',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('hacer',$person,$tense,$prefix);
		break; 
	case 'rehacer':
		$prefix2=substr($v,0,stripos($v,'hacer'));
		switch ($tense) {
		case 'pretérito':
			switch ($person) {
			case 0: return 'rehíce';
			case 2: return 'rehízo';
			}
			break;
		}
		if ($compound_tense==true or conjugate('hacer',$person,$tense,$prefix2)=='') return conjugate('hacer',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('hacer',$person,$tense,$prefix);
		break; 
	case 'abstraer':
	case 'atraer':
	case 'contraer':
	case 'distraer':
	case 'extraer':
	case 'maltraer':
	case 'retraer':
	case 'retrotraer':
	case 'substraer':
	case 'sustraer':
		$prefix2=substr($v,0,stripos($v,'traer'));
		if ($compound_tense==true or conjugate('traer',$person,$tense,$prefix2)=='') return conjugate('traer',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('traer',$person,$tense,$prefix);
		break;
	case 'desandar':
		$prefix2=substr($v,0,stripos($v,'andar'));
		if ($compound_tense==true or conjugate('andar',$person,$tense,$prefix2)=='') return conjugate('andar',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('andar',$person,$tense,$prefix);
		break;
	case 'conseguir':
	case 'perseguir':
	case 'proseguir':
	case 'subseguir':
		$prefix2=substr($v,0,stripos($v,'seguir'));
		if ($compound_tense==true or conjugate('seguir',$person,$tense,$prefix2)=='') return conjugate('seguir',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('seguir',$person,$tense,$prefix);
		break;
	case 'engreír':
	case 'freír':
	case 'refreír':
	case 'sofreír':
	case 'sonreír':
		$prefix2=substr($v,0,stripos($v,'reír'));
		if ($compound_tense==true or conjugate('reír',$person,$tense,$prefix2)=='') return conjugate('reír',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('reír',$person,$tense,$prefix);
		break;
	}
	switch ($tense) {
		//gerundio
	case 'gerundio':
		if($prefix!=='') {
			return $prefix . conjugate($v,0,'gerundio','');
		}
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-2))) {
		case 'ar':
			return $verb_stem . 'ando';
			break;
		case 'ír':
		case 'ir':
		case 'er':
			switch(iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3,1))) {
			case 'a':
			case 'e':
			case 'o':
			case 'u':
			case 'ü':
				return $verb_stem . 'yendo';
				break;
			case 'ñ':
				return $verb_stem . 'endo';
				break;
			default:
				if(iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-4,2))=='ll') return $verb_stem . 'endo';
				return $verb_stem . 'iendo';
			}
			break;
		}
		break;
		//past participle
	case 'past participle':
		if($prefix!=='') {
			return $prefix . conjugate($v,0,'past participle','');
		}
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-2))) {
		case 'ar':
			return $verb_stem . 'ado';
			break;
		case 'ír':
		case 'ir':
		case 'er':
			switch(iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3,1))) {
			case 'a':
			case 'e':
			case 'o':
				return $verb_stem . 'ído';
				break;
			default: return $verb_stem . 'ido';
			}
			break;
		}
		break;
		//presente tense
	case 'presente':
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-2))) {
			//-ar verbs
		case 'ar':
			switch ($person) {
			case 0: return $verb_stem . 'o';
			case 1: return $verb_stem . 'as';
			case 2: return $verb_stem . 'a';
			case 3: return $verb_stem . 'amos';
			case 4: return $verb_stem . 'áis';
			case 5: return $verb_stem . 'an';
			}
			break;
			//-er verbs
		case 'er':
			switch ($person) {
			case 0: return $verb_stem . 'o';
			case 1: return $verb_stem . 'es';
			case 2: return $verb_stem . 'e';
			case 3: return $verb_stem . 'emos';
			case 4: return $verb_stem . 'éis';
			case 5: return $verb_stem . 'en';
			}
			break;
			//-ir verbs
		case 'ir':
		case 'ír':
			switch ($person) {
			case 0: return $verb_stem . 'o';
			case 1: return $verb_stem . 'es';
			case 2: return $verb_stem . 'e';
			case 3: return $verb_stem . 'imos';
			case 4: return $verb_stem . 'ís';
			case 5: return $verb_stem . 'en';
			}
			break;
		}
		break;
		//imperfecto tense
	case 'imperfecto':
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-2))) {
			//-ar verbs
		case 'ar':
			switch ($person) {
			case 0: return $verb_stem . 'aba';
			case 1: return $verb_stem . 'abas';
			case 2: return $verb_stem . 'aba';
			case 3: return $verb_stem . 'ábamos';
			case 4: return $verb_stem . 'abais';
			case 5: return $verb_stem . 'aban';
			}
			break;
			//-er/-ir verbs
		case 'er':
		case 'ir' :
		case 'ír':
			switch ($person) {
			case 0: return $verb_stem . 'ía';
			case 1: return $verb_stem . 'ías';
			case 2: return $verb_stem . 'ía';
			case 3: return $verb_stem . 'íamos';
			case 4: return $verb_stem . 'íais';
			case 5: return $verb_stem . 'ían';
			}
			break;
		}
		break;
		//pretérito tense
	case 'pretérito':
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-2))) {
			//-ar verbs
		case 'ar':
			switch ($person) {
			case 0: return $verb_stem . 'é';
			case 1: return $verb_stem . 'aste';
			case 2: return $verb_stem . 'ó';
			case 3: return $verb_stem . 'amos';
			case 4: return $verb_stem . 'asteis';
			case 5: return $verb_stem . 'aron';
			}
			break;
			//-er/-ir verbs
		case 'er':
		case 'ir' :
		case 'ír':
			switch ($person) {
			case 0: return $verb_stem . 'í';
			case 1: 
				switch(iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3,1))) {
				case 'a':
				case 'e':
				case 'o':
					return $verb_stem . 'íste';
					break;
				default: return $verb_stem . 'iste';
				}
			case 2: 
				switch(iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3,1))) {
				case 'a':
				case 'e':
				case 'o':
				case 'u':
				case 'ü':
					return $verb_stem . 'yó';
					break;
				case 'ñ':
					return $verb_stem . 'ó';
					break;
				default: 
					if(iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-4,2))=='ll') return $verb_stem . 'ó';
					return $verb_stem . 'ió';
				}
			case 3:
				switch(iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3,1))) {
				case 'a':
				case 'e':
				case 'o':
					return $verb_stem . 'ímos';
					break;
				default: return $verb_stem . 'imos';
				}
			case 4:
				switch(iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3,1))) {
				case 'a':
				case 'e':
				case 'o':
					return $verb_stem . 'ísteis';
					break;
				default: return $verb_stem . 'isteis';
				}
			case 5: 
				switch(iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3,1))) {
				case 'a':
				case 'e':
				case 'o':
				case 'u':
				case 'ü':
					return $verb_stem . 'yeron';
					break;
				case 'ñ':
					return $verb_stem . 'eron';
					break;
				default: 
					if(iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-4,2))=='ll') return $verb_stem . 'eron';
					return $verb_stem . 'ieron';
				}
			}
			break;
		}
		break;
		//futuro tense
	case 'futuro':
		switch ($person) {
		case 0: return $verb_stem . 'é';
		case 1: return $verb_stem . 'ás';
		case 2: return $verb_stem . 'á';
		case 3: return $verb_stem . 'emos';
		case 4: return $verb_stem . 'éis';
		case 5: return $verb_stem . 'án';
		}
		break;
		//perfect tense
	case 'perfecto':
		switch ($person) {
		case 0: return conjugate('haber',0,'presente','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate('haber',1,'presente','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate('haber',2,'presente','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate('haber',3,'presente','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate('haber',4,'presente','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate('haber',5,'presente','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//pluscuamperfecto tense
	case 'pluscuamperfecto':
		switch ($person) {
		case 0: return conjugate('haber',0,'imperfecto','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate('haber',1,'imperfecto','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate('haber',2,'imperfecto','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate('haber',3,'imperfecto','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate('haber',4,'imperfecto','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate('haber',5,'imperfecto','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//past anterior tense
	case 'past anterior':
		switch ($person) {
		case 0: return conjugate('haber',0,'pretérito','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate('haber',1,'pretérito','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate('haber',2,'pretérito','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate('haber',3,'pretérito','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate('haber',4,'pretérito','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate('haber',5,'pretérito','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//futuro perfect tense
	case 'futuro perfecto':
		switch ($person) {
		case 0: return conjugate('haber',0,'futuro','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate('haber',1,'futuro','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate('haber',2,'futuro','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate('haber',3,'futuro','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate('haber',4,'futuro','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate('haber',5,'futuro','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//condicional tense
	case 'condicional':
		switch ($person) {
		case 0: return $verb_stem . 'ía';
		case 1: return $verb_stem . 'ías';
		case 2: return $verb_stem . 'ía';
		case 3: return $verb_stem . 'íamos';
		case 4: return $verb_stem . 'íais';
		case 5: return $verb_stem . 'ían';
		}
		//condicional perfect tense
	case 'condicional perfecto':
		switch ($person) {
		case 0: return conjugate('haber',0,'condicional','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate('haber',1,'condicional','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate('haber',2,'condicional','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate('haber',3,'condicional','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate('haber',4,'condicional','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate('haber',5,'condicional','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//subjuntivo presente tense
	case 'subjuntivo presente':
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-2))) {
			//-ar verbs
		case 'ar':
			switch ($person) {
			case 0: return $verb_stem . 'e';
			case 1: return $verb_stem . 'es';
			case 2: return $verb_stem . 'e';
			case 3: return $verb_stem . 'emos';
			case 4: return $verb_stem . 'éis';
			case 5: return $verb_stem . 'en';
			}
			break;
			//-er/-ir verbs
		case 'er':
		case 'ir' :
		case 'ír':
			switch ($person) {
			case 0: return $verb_stem . 'a';
			case 1: return $verb_stem . 'as';
			case 2: return $verb_stem . 'a';
			case 3: return $verb_stem . 'amos';
			case 4: return $verb_stem . 'áis';
			case 5: return $verb_stem . 'an';
			}
			break;
		}
		break;
		//subjuntivo futuro tense
	case 'subjuntivo futuro':
		switch ($person) {
		case 0: return $verb_stem . 're';
		case 1: return $verb_stem . 'res';
		case 2: return $verb_stem . 're';
		case 3: return $verb_stem . 'remos';
		case 4: return $verb_stem . 'reis';
		case 5: return $verb_stem . 'ren';
		}
		break;
		//subjuntivo imperfecto tenses
	case 'subjuntivo imperfecto 1':
		switch ($person) {
		case 0: return $verb_stem . 'se';
		case 1: return $verb_stem . 'ses';
		case 2: return $verb_stem . 'se';
		case 3: return $verb_stem . 'semos';
		case 4: return $verb_stem . 'seis';
		case 5: return $verb_stem . 'sen';
		}
		break;
	case 'subjuntivo imperfecto 2':
		switch ($person) {
		case 0: return $verb_stem . 'ra';
		case 1: return $verb_stem . 'ras';
		case 2: return $verb_stem . 'ra';
		case 3: return $verb_stem . 'ramos';
		case 4: return $verb_stem . 'rais';
		case 5: return $verb_stem . 'ran';
		}
		break;
		//subjuntivo perfect tense
	case 'subjuntivo perfecto':
		switch ($person) {
		case 0: return conjugate('haber',0,'subjuntivo presente','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate('haber',1,'subjuntivo presente','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate('haber',2,'subjuntivo presente','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate('haber',3,'subjuntivo presente','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate('haber',4,'subjuntivo presente','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate('haber',5,'subjuntivo presente','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//subjuntivo futuro perfect tense
	case 'subjuntivo futuro perfecto':
		switch ($person) {
		case 0: return conjugate('haber',0,'subjuntivo futuro','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate('haber',1,'subjuntivo futuro','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate('haber',2,'subjuntivo futuro','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate('haber',3,'subjuntivo futuro','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate('haber',4,'subjuntivo futuro','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate('haber',5,'subjuntivo futuro','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//subjuntivo pluscuamperfecto tense
	case 'subjuntivo pluscuamperfecto 1':
		switch ($person) {
		case 0: return conjugate('haber',0,'subjuntivo imperfecto 1','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate('haber',1,'subjuntivo imperfecto 1','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate('haber',2,'subjuntivo imperfecto 1','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate('haber',3,'subjuntivo imperfecto 1','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate('haber',4,'subjuntivo imperfecto 1','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate('haber',5,'subjuntivo imperfecto 1','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
	case 'subjuntivo pluscuamperfecto 2':
		switch ($person) {
		case 0: return conjugate('haber',0,'subjuntivo imperfecto 2','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate('haber',1,'subjuntivo imperfecto 2','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate('haber',2,'subjuntivo imperfecto 2','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate('haber',3,'subjuntivo imperfecto 2','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate('haber',4,'subjuntivo imperfecto 2','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate('haber',5,'subjuntivo imperfecto 2','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//positivo imperativo
	case 'positivo imperativo':
		switch ($person) {		
		case 1: return conjugate($v,2,'presente',$prefix);
		case 2: return conjugate($v,2,'subjuntivo presente',$prefix);
		case 3: return conjugate($v,3,'subjuntivo presente',$prefix);
		case 4: return substr($v,0,-1) . 'd';
		case 5: return conjugate($v,5,'subjuntivo presente',$prefix);
		}
		break;
		//negativo imperativo
	case 'negativo imperativo':
		switch ($person) {
		case 1: return 'no ' . $prefix . conjugate($v,1,'subjuntivo presente',$prefix);
		case 2: return 'no ' . $prefix . conjugate($v,2,'subjuntivo presente',$prefix);
		case 3: return 'no ' . $prefix . conjugate($v,3,'subjuntivo presente',$prefix);
		case 4: return 'no ' . $prefix . conjugate($v,4,'subjuntivo presente',$prefix);
		case 5: return 'no ' . $prefix . conjugate($v,5,'subjuntivo presente',$prefix);
		}
		break;
	}	
}
//verb data
$pp=array(
'yo',
'tu',
'él',
'nosotros',
'vosotros',
'ellos');
$tense=array(
'presente',
'imperfecto',
'pretérito',
'futuro',
'perfecto',
'pluscuamperfecto',
'past anterior',
'futuro perfecto',
'condicional',
'condicional perfecto',
'subjuntivo presente',
'subjuntivo futuro',
'subjuntivo imperfecto 1',
'subjuntivo imperfecto 2',
'subjuntivo perfecto',
'subjuntivo futuro perfecto',
'subjuntivo pluscuamperfecto 1',
'subjuntivo pluscuamperfecto 2',
'positivo imperativo',
'negativo imperativo');

//config
$xml_caching = false; //xml caching - true to use cache, false to generate xml each time.

//don't edit below here
if ($xml_caching==true) $write_option='x';
else $write_option='w';

//write xml
if ((!file_exists('espanol_xml/' . $verb . '.xml')) or $xml_caching==false) {
	$file=fopen('espanol_xml/' . $verb . '.xml',$write_option);
	fwrite($file,
	'<?xml version="1.0"?>
<verb>
	<tense name="infinitivo">
		<infinitivo>' . $verb . '</infinitivo>
		<gerundio>' . conjugate($verb,0,'gerundio','') . '</gerundio>
		<participio>' . conjugate($verb,0,'past participle','') . '</participio>
	</tense>');
	for ($t=0;$t<=count($tense)-1;$t++) {
		fwrite($file,'
	<tense name="' . $tense[$t] . '">');
		for ($i=0;$i<=count($pp)-1;$i++) {
			if (conjugate($verb,$i,$tense[$t],'')!==null) fwrite($file,'
		<' . $pp[$i] . '>'. conjugate($verb,$i,$tense[$t],'') . '</' . $pp[$i] . '>');
		}
		fwrite($file,'
	</tense>');
	}
	fwrite($file,'
</verb>');
	fclose($file);
}

//parse xml
include 'head.php';
$xml = simplexml_load_file('espanol_xml/' . $verb . '.xml');
foreach($xml->children() as $child)
{		
	foreach($child->attributes() as $a => $b)
	{
		echo '<table><tr>
<th colspan="2">' . $b . '</th></tr>';
	}
	foreach($child->children() as $child2)
	{
		foreach($child->attributes() as $a => $b)
		{
			echo '<tr><td>' . $child2->getName() . "</td><td>" . $child2 . '</td></tr>';
		}
	}
	echo '</table>';
}
?>
</body>
</html>