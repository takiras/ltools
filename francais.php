<?
include 'head.php'; 
include 'input.php';
if ($_GET['word']!==null) $verb = $_GET['word'];
else $verb = 'aimer';
switch(substr($verb,-2,2)) {
	case 'er':
	case 're':
	case 'ir':
		echo null;
		break;
	default: die;
}
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
function circumflex($vowel) {
	switch ($vowel) {
	case 'a': return 'â';
		break;
	case 'e': return 'ê';
		break;
	case 'i': return 'î';
		break;
	case 'o': return 'ô';
		break;
	case 'u': return 'û';
		break;
	default: return $vowel;
		break;
	}
}
function deaccent($vowel) {
	switch ($vowel) {
	case 'á':
	case 'â': return 'a';
		break;
	case 'é':
	case 'ê': return 'e';
		break;
	case 'í':
	case 'î': return 'i';
		break;
	case 'ó': 
	case 'ô':return 'o';
		break;
	case 'ú':
	case 'û': return 'u';
		break;
	default: return $vowel;
		break;
	}
}
function get_stem($v,$person,$tense,$prefix) {
	switch (substr($v,-3)) {
		// make sure verbs stay soft/hard
	case 'ger':
		switch ($tense) {
		case 'présent':
			switch ($person) {
			case 3:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2))) . 'e';
				break;
			}
			break;
		case 'imparfait':
		case 'participe_présent':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2))) . 'e';
				break;
			}
			break;
		case 'passé simple':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-2))) . 'e';
				break;
			}
			break;
		}
		break;
	case 'cer':
		switch ($tense ) {
		case 'présent':
			switch ($person) {
			case 3:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'ç';
				break;
			}
			break;
		case 'imparfait':
		case 'participe_présent':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'ç';
				break;
			default:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'c';
				break;
			}
			break;
		case 'passé simple':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 3:
			case 4:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'ç';
				break;
			}
			break;
		}
	}
	switch ($tense) {
		//future stems
	case 'futur simple';
	case 'conditionnel';
		switch ($v) {
			//irregular future stems
		case 'être': return 'ser';
		case 'avoir': return 'aur';
		case 'enir': return 'iendr';
		case 'voir': return 'verr';
		case 'aller': return 'ir';
		case 'faire': return 'fer';
		case 'pouvoir': return 'pourr';
		case 'savour': return 'saur';
		case 'vouloir': return 'voudr';
		case 'falloir': return 'faudr';
		case 'valoir': return 'vaudr';
		case 'pleuvoir': return 'pleuvr';
		case 'mouvoir': return 'mouvr';
		case 'mourir': return 'mourr';
		case 'asseoir': return 'assiér';
		case 'cueillir': return 'cueiller';
		case 'quérir': return 'quérr';
			break;
		default:
			return $v;
		}
		break;
		//subjonctif stems
	case 'subjonctif présent':
		switch ($person) {
		case 0:
		case 1:
		case 2:
		case 5: return substr(conjugate($v,5,'présent',$prefix),0,strripos(conjugate($v,5,'présent',$prefix),'ent'));
			break;
		case 3:
		case 4: return substr(conjugate($v,3,'présent',$prefix),0,strripos(conjugate($v,3,'présent',$prefix),'ons'));
		}
		break;
	case 'subjonctif imparfait':
		if ((substr($v,-2))=='er') return conjugate($v,2,'passé simple',$prefix);
		return substr(conjugate($v,2,'passé simple',$prefix),0,strripos(conjugate($v,2,'passé simple',$prefix),'t'));
		//imparfait and participe_présent stems
	case 'imparfait':
	case 'participe_présent':
		return substr(conjugate($v,3,'présent',$prefix),0,strripos(conjugate($v,3,'présent',$prefix),'ons'));
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
	if (strstr($tense,' passé composé')!==false OR strstr($tense,'plus-que-parfait')!==false OR strstr($tense,'passé antérieur')!==false OR $tense=='passé composé' OR $tense=='negatif impératif') $compound_tense = true;
	else $compound_tense= false;
	//auxiliary verb for perfect tenses
	switch ($prefix . $v) {
	case 'mourir':
	case 'retourner':
	case 'sortir':
	case 'venir':
	case 'aller':
	case 'naître':
	case 'descendre':
	case 'entrer':
	case 'tomber':
	case 'rester':
	case 'arriver':
	case 'monter':
	case 'partir':
		$auxiliary='être';
		break;
	default: $auxiliary='avoir';
	}
	switch ($v) {
		//compound verbs
	case 'recevoir':
	case 'apercevoir':
	case 'concevoir':
	case 'décevoir':
	case 'entrapercevoir':
	case 'percevoir':
		$prefix2=substr($v,0,stripos($v,'cevoir'));
		if ($compound_tense==true or conjugate('cevoir',$person,$tense,$prefix2)=='') return conjugate('cevoir',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('cevoir',$person,$tense,$prefix);
		break;
	case 'tenir':
	case 'abstenir':
	case 'advenir':
	case 'appartenir':
	case 'avenir':
	case 'bienvenir':
	case 'circonvenir':
	case 'contenir':
	case 'contrevenir':
	case 'convenir':
	case 'détenir':
	case 'devenir':
	case 'disconvenir':
	case 'entretenir':
	case 'intervenir':
	case 'maintenir':
	case 'obtenir':
	case 'obvenir':
	case 'parvenir':
	case 'prévenir':
	case 'provenir':
	case 'redevenir':
	case 'ressouvenir':
	case 'retenir':
	case 'revenir':
	case 'soutenir':
	case 'souvenir':
	case 'subvenir':
	case 'survenir':
	case 'venir':
		$prefix2=substr($v,0,stripos($v,'enir'));
		if ($compound_tense==true or conjugate('enir',$person,$tense,$prefix2)=='') return conjugate('enir',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('enir',$person,$tense,$prefix);
		break;
	case 'accueillir':
		$prefix2=substr($v,0,stripos($v,'cueillir'));
		if ($compound_tense==true or conjugate('cueillir',$person,$tense,$prefix2)=='') return conjugate('cueillir',$person,$tense,$prefix2);
		else return $prefix2 . conjugate('cueillir',$person,$tense,$prefix);
		break;
		//irregular verbs
	case 'être':
		switch ($tense) {
		case 'présent':
			switch ($person) {
			case 0: return 'suis';
			case 1: return 'es';
			case 2: return 'est';
			case 3: return 'sommes';
			case 4: return 'êtes';
			case 5: return 'sont';
			}
			break;
		case 'imparfait':
			return conjugate('éter',$person,$tense,$prefix);
			break;
		case 'passé simple':
			switch ($person) {
			case 0: return 'fus';
			case 1: return 'fus';
			case 2: return 'fut';
			case 3: return 'fûmes';
			case 4: return 'fûtes';
			case 5: return 'furent';
			}
			break;
		case 'subjonctif présent':
			switch ($person) {
			case 0: return 'sois';
			case 1: return 'sois';
			case 2: return 'soit';
			case 3: return 'soyons';
			case 4: return 'soyez';
			case 5: return 'soient';
			}
			break;
		case 'positif impératif':
			switch ($person) {
			case 1: return 'sois';
			case 3: return 'soyons';
			case 4: return 'soyez';
			}
			break;
		case 'participe_présent':
			return 'étant';
			break;
		case 'past participle':
			return $prefix . 'été';
			break;
		}
		break;
	case 'aller':
		switch ($tense) {
		case 'présent':
			switch ($person) {
			case 0: return 'vais';
			case 1: return 'vas';
			case 2: return 'va';
			case 5: return 'vont';
			}
			break;
			break;
		case 'subjonctif présent':
			switch ($person) {
			case 0: return 'aille';
			case 1: return 'ailles';
			case 2: return 'aille';
			case 5: return 'aillent';
			}
			break;
		}
		break;
	case 'avoir':
		switch ($tense) {
		case 'présent':
			switch ($person) {
			case 0: return 'ai';
			case 1: return 'as';
			case 2: return 'a';
			case 3: return 'avons';
			case 4: return 'avez';
			case 5: return 'ont';
			}
			break;
		case 'passé simple':
			switch ($person) {
			case 0: return 'eus';
			case 1: return 'eus';
			case 2: return 'eut';
			case 3: return 'eûmes';
			case 4: return 'eûtes';
			case 5: return 'eurent';
			}
			break;
		case 'subjonctif présent':
			switch ($person) {
			case 0: return 'ais';
			case 1: return 'ais';
			case 2: return 'ait';
			case 3: return 'ayons';
			case 4: return 'ayez';
			case 5: return 'aient';
			}
			break;
		case 'positif impératif':
			switch ($person) {
			case 1: return 'aie';
			case 3: return 'ayons';
			case 4: return 'ayez';
			}
			break;
		case 'participe_présent':
			return 'ayant';
			break;
		case 'past participle':
			return $prefix . 'eu';
			break;
		}
		break;
	case 'naître':
		switch ($tense) {
		case 'présent':
			switch ($person) {
			case 2: return 'naît';
			default: return conjugate('nair',$person,$tense,$prefix);
			}
			break;
		case 'passé simple':
			switch ($person) {
			case 0: return 'naquis';
			case 1: return 'naquis';
			case 2: return 'naquit';
			case 3: return 'naquîmes';
			case 4: return 'naquîtes';
			case 5: return 'naquirent';
			}
			break;
		case 'past participle':
			return $prefix . 'né';
			break;
		}
		break;
	case 'devoir':
		switch ($tense) {
		case 'présent':
			switch ($person) {
			case 0:
			case 1: return 'dois';
			case 2: return 'doit';
			case 3: return 'devons';
			case 4: return 'devez';
			case 5: return 'doivent';
			}
			break;
		case 'passé simple':
			switch ($person) {
			case 0: return 'dus';
			case 1: return 'dus';
			case 2: return 'dut';
			case 3: return 'dûmes';
			case 4: return 'dûtes';
			case 5: return 'durent';
			}
			break;
		case 'past participle':
			return $prefix . 'dû';
			break;
		}
		break;
	case 'cevoir':
		switch ($tense) {
		case 'présent':
			switch ($person) {
			case 0:
			case 1: return 'çois';
			case 2: return 'çoit';
			case 3: return 'cevons';
			case 4: return 'cevez';
			case 5: return 'çoivent';
			}
			break;
		case 'passé simple':
			switch ($person) {
			case 0: return 'çus';
			case 1: return 'çus';
			case 2: return 'çut';
			case 3: return 'çûmes';
			case 4: return 'çûtes';
			case 5: return 'çurent';
			}
			break;
		case 'past participle':
			return $prefix . 'çu';
			break;
		}
		break;
	case 'savoir':
		switch ($tense) {
		case 'présent':
			switch ($person) {
			case 0:
			case 1: return 'sais';
			case 2: return 'sait';
			case 3: return 'savons';
			case 4: return 'savez';
			case 5: return 'savent';
			}
			break;
		case 'passé simple':
			switch ($person) {
			case 0: return 'sus';
			case 1: return 'sus';
			case 2: return 'sut';
			case 3: return 'sûmes';
			case 4: return 'sûtes';
			case 5: return 'surent';
			}
			break;
		case 'subjonctif présent':
		case 'participe_présent':
			return conjugate('sacher',$person,$tense,$prefix);
			break;
		case 'past participle':
			return $prefix . 'su';
			break;
		}
		break;
	case 'pouvoir':
		switch ($tense) {
		case 'présent':
			switch ($person) {
			case 0:
			case 1: return 'peux';
			case 2: return 'peut';
			case 3: return 'pouvons';
			case 4: return 'pouvez';
			case 5: return 'peuvent';
			}
			break;
		case 'passé simple':
			switch ($person) {
			case 0: return 'pus';
			case 1: return 'pus';
			case 2: return 'put';
			case 3: return 'pûmes';
			case 4: return 'pûtes';
			case 5: return 'purent';
			}
			break;
		case 'subjonctif présent':
			return conjugate('puir',$person,$tense,$prefix);
			break;
		case 'past participle':
			return $prefix . 'pu';
			break;
		}
		break;
	case 'mourir':
		switch ($tense) {
		case 'présent':
			switch ($person) {
			case 0:
			case 1: return 'meurs';
			case 2: return 'meurt';
			case 3: return 'mourons';
			case 4: return 'mourez';
			case 5: return 'meurent';
			}
			break;
		case 'passé simple':
			switch ($person) {
			case 0: return 'mourus';
			case 1: return 'mourus';
			case 2: return 'mourut';
			case 3: return 'mourûmes';
			case 4: return 'mourûtes';
			case 5: return 'moururent';
			}
			break;
		case 'past participle':
			return $prefix . 'mort';
			break;
		case 'participe_présent':
			return $prefix . 'mourant';
			break;
		}
		break;
	case 'vouloir':
		switch ($tense) {
		case 'présent':
			switch ($person) {
			case 0:
			case 1: return 'veux';
			case 2: return 'veut';
			case 3: return 'voulons';
			case 4: return 'voulez';
			case 5: return 'veulent';
			}
			break;
		case 'passé simple':
			switch ($person) {
			case 0: return 'voulus';
			case 1: return 'voulus';
			case 2: return 'voulut';
			case 3: return 'voulûmes';
			case 4: return 'voulûtes';
			case 5: return 'voulurent';
			}
			break;
		case 'subjonctif présent':
			switch ($person) {
			case 0: return 'veuille';
			case 1: return 'veuilles';
			case 2: return 'veuille';
			case 5: return 'veuillent';
			}
		case 'past participle':
			return $prefix . 'voulu';
			break;
		}
		break;
	case 'connaître':
		switch ($tense) {
		case 'présent':
			switch ($person) {
			case 2: return 'connaît';
			default: return conjugate('connair',$person,$tense,$prefix);
			}
			break;
		case 'passé simple':
			switch ($person) {
			case 0: return 'connus';
			case 1: return 'connus';
			case 2: return 'connut';
			case 3: return 'connûmes';
			case 4: return 'connûtes';
			case 5: return 'connurent';
			}
			break;
		case 'past participle':
			return $prefix . 'connu';
			break;
		}
		break;
	case 'courir':
		switch ($tense) {
		case 'présent':
			switch ($person) {
			case 2: return 'court';
			default: return conjugate('courre',$person,$tense,$prefix);
			}
			break;
		case 'passé simple':
			switch ($person) {
			case 0: return 'courus';
			case 1: return 'courus';
			case 2: return 'courut';
			case 3: return 'courûmes';
			case 4: return 'courûtes';
			case 5: return 'coururent';
			}
			break;
		default: return conjugate('courre',$person,$tense,$prefix);
		}
		break;
	case 'cueillir':
		switch ($tense) {
		case 'futur simple':
		case 'présent':
			return conjugate('cueiller',$person,$tense,$prefix);
		}
		break;
	case 'enir':
		switch ($tense) {
		case 'présent':
			switch ($person) {
			case 0: return 'iens';
			case 1: return 'iens';
			case 2: return 'ient';
			case 3: return 'enons';
			case 4: return 'enez';
			case 5: return 'iennent';
			}
			break;
		case 'passé simple':
			switch ($person) {
			case 0: return 'ins';
			case 1: return 'ins';
			case 2: return 'int';
			case 3: return 'înmes';
			case 4: return 'întes';
			case 5: return 'inrent';
			}
			break;
		case 'subjonctif présent':
			switch ($person) {
			case 0: return 'ienne';
			case 1: return 'iennes';
			case 2: return 'ienne';
			case 5: return 'iennent';
			}
		case 'subjonctif imparfait':
			switch ($person) {
			case 2: return 'înt';
			}
			break;
		case 'past participle':
			return $prefix . 'enu';
			break;
		}
		break;
	}
	switch ($tense) {
		//participe_présent
	case 'participe_présent':
		if($prefix!=='') {
			return $prefix . conjugate($v,0,'participe_présent','');
		}
		return $verb_stem . 'ant';
		break;
		//past participle
	case 'past participle':
		if($prefix!=='') {
			return $prefix . conjugate($v,0,'past participle','');
		}
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-2))) {
		case 'er':
			return $verb_stem . 'é';
			break;
		case 'ir':
			return $verb_stem . 'i';
			break;
		case 're':
			return $verb_stem . 'u';
			break;
		}
		break;
		//présent tense
	case 'présent':
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-2))) {
			//-er verbs
		case 'er':
			switch ($person) {
			case 0: return $verb_stem . 'e';
			case 1: return $verb_stem . 'es';
			case 2: return $verb_stem . 'e';
			case 3: return $verb_stem . 'ons';
			case 4: return $verb_stem . 'ez';
			case 5: return $verb_stem . 'ent';
			}
			break;
			//-ir verbs
		case 'ir':
			switch ($person) {
			case 0: return $verb_stem . 'is';
			case 1: return $verb_stem . 'is';
			case 2: return $verb_stem . 'it';
			case 3: return $verb_stem . 'issons';
			case 4: return $verb_stem . 'issez';
			case 5: return $verb_stem . 'issent';
			}
			break;
			//-re verbs
		case 're':
			switch ($person) {
			case 0: return $verb_stem . 's';
			case 1: return $verb_stem . 's';
			case 2: return $verb_stem;
			case 3: return $verb_stem . 'ons';
			case 4: return $verb_stem . 'ez';
			case 5: return $verb_stem . 'ent';
			}
			break;
		}
		break;
		//imparfait and conditionnel tense
	case 'imparfait':					
	case 'conditionnel':					
		switch ($person) {
		case 0: return $verb_stem . 'ais';
		case 1: return $verb_stem . 'ais';
		case 2: return $verb_stem . 'ait';
		case 3: return $verb_stem . 'ions';
		case 4: return $verb_stem . 'iez';
		case 5: return $verb_stem . 'aient';
		}
		break;
		//passé simple tense
	case 'passé simple':
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-2))) {
			//-er verbs
		case 'er':
			switch ($person) {
			case 0: return $verb_stem . 'ai';
			case 1: return $verb_stem . 'as';
			case 2: return $verb_stem . 'a';
			case 3: return $verb_stem . 'âmes';
			case 4: return $verb_stem . 'âtes';
			case 5: return $verb_stem . 'èrent';
			}
			break;
			//-ir/-re verbs
		case 'ir':
		case 're':
			switch ($person) {
			case 0: return $verb_stem . 'is';
			case 1: return $verb_stem . 'is';
			case 2: return $verb_stem . 'it';
			case 3: return $verb_stem . 'îmes';
			case 4: return $verb_stem . 'îtes';
			case 5: return $verb_stem . 'irent';
			}
			break;
		}
		break;
		//future tense
	case 'futur simple':
		switch ($person) {
		case 0: return $verb_stem . 'ai';
		case 1: return $verb_stem . 'as';
		case 2: return $verb_stem . 'a';
		case 3: return $verb_stem . 'ons';
		case 4: return $verb_stem . 'ez';
		case 5: return $verb_stem . 'ont';
		}
		break;
		//perfect tense
	case 'passé composé':
		switch ($person) {
		case 0: return conjugate($auxiliary,0,'présent','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate($auxiliary,1,'présent','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate($auxiliary,2,'présent','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate($auxiliary,3,'présent','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate($auxiliary,4,'présent','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate($auxiliary,5,'présent','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//plus-que-parfait tense
	case 'plus-que-parfait':
		switch ($person) {
		case 0: return conjugate($auxiliary,0,'imparfait','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate($auxiliary,1,'imparfait','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate($auxiliary,2,'imparfait','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate($auxiliary,3,'imparfait','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate($auxiliary,4,'imparfait','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate($auxiliary,5,'imparfait','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//passé antérieur tense
	case 'passé antérieur':
		switch ($person) {
		case 0: return conjugate($auxiliary,0,'passé simple','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate($auxiliary,1,'passé simple','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate($auxiliary,2,'passé simple','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate($auxiliary,3,'passé simple','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate($auxiliary,4,'passé simple','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate($auxiliary,5,'passé simple','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//futur antérieur tense
	case 'futur antérieur':
		switch ($person) {
		case 0: return conjugate($auxiliary,0,'futur simple','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate($auxiliary,1,'futur simple','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate($auxiliary,2,'futur simple','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate($auxiliary,3,'futur simple','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate($auxiliary,4,'futur simple','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate($auxiliary,5,'futur simple','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//conditionnel perfect tense
	case 'conditionnel passé':
		switch ($person) {
		case 0: return conjugate($auxiliary,0,'conditionnel','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate($auxiliary,1,'conditionnel','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate($auxiliary,2,'conditionnel','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate($auxiliary,3,'conditionnel','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate($auxiliary,4,'conditionnel','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate($auxiliary,5,'conditionnel','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//subjonctif présent tense
	case 'subjonctif présent':
		switch ($person) {
		case 0: return $verb_stem . 'e';
		case 1: return $verb_stem . 'es';
		case 2: return $verb_stem . 'e';
		case 3: return $verb_stem . 'ions';
		case 4: return $verb_stem . 'iez';
		case 5: return $verb_stem . 'ent';
		}
		break;
		//subjonctif imparfait tense
	case 'subjonctif imparfait':
		switch ($person) {
		case 0: return $verb_stem . 'sse';
		case 1: return $verb_stem . 'sses';
		case 2: return substr($verb_stem,0,-1) . circumflex(substr($verb_stem,-1)) . 't';
		case 3: return $verb_stem . 'ssions';
		case 4: return $verb_stem . 'ssiez';
		case 5: return $verb_stem . 'ssent';
		}
		break;
		//subjonctif perfect tense
	case 'subjonctif passé':
		switch ($person) {
		case 0: return conjugate($auxiliary,0,'subjonctif présent','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate($auxiliary,1,'subjonctif présent','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate($auxiliary,2,'subjonctif présent','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate($auxiliary,3,'subjonctif présent','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate($auxiliary,4,'subjonctif présent','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate($auxiliary,5,'subjonctif présent','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//subjonctif plus-que-parfait tense
	case 'subjonctif plus-que-parfait':
		switch ($person) {
		case 0: return conjugate($auxiliary,0,'subjonctif imparfait','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate($auxiliary,1,'subjonctif imparfait','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate($auxiliary,2,'subjonctif imparfait','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate($auxiliary,3,'subjonctif imparfait','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate($auxiliary,4,'subjonctif imparfait','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate($auxiliary,5,'subjonctif imparfait','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//positif impératif
	case 'positif impératif':
		switch ($person) {	
		case 1: if (substr($v,-2)=='er') return substr(conjugate($v,1,'présent',$prefix),0,-1);
			return conjugate($v,1,'présent',$prefix);
		case 3: return conjugate($v,3,'présent',$prefix);
		case 4: return conjugate($v,4,'présent',$prefix);
		}
		break;
		//negatif impératif
	case 'negatif impératif':
		switch ($person) {
		case 1: return 'ne ' . $prefix . conjugate($v,1,'positif impératif',$prefix) . ' pas';
		case 3: return 'ne ' . $prefix . conjugate($v,3,'positif impératif',$prefix) . ' pas';
		case 4: return 'ne ' . $prefix . conjugate($v,4,'positif impératif',$prefix) . ' pas';
		}
		break;
	}	
}
//verb data
$pp=array(
'je',
'tu',
'il',
'nous',
'vous',
'ils');
$tense=array(
'présent',
'imparfait',
'passé simple',
'futur simple',
'passé composé',
'plus-que-parfait',
'passé antérieur',
'futur antérieur',
'conditionnel',
'conditionnel passé',
'subjonctif présent',
'subjonctif imparfait',
'subjonctif passé',
'subjonctif plus-que-parfait',
'positif impératif',
'negatif impératif');

//config
$xml_caching = false; //xml caching - true to use cache, false to generate xml each time.
$use_color = true; //use colored tables opposed to greyscale.

//don't edit below here
if ($xml_caching==true) $write_option='x';
else $write_option='w';

//write xml
if ((!file_exists('francais_xml/' . $verb . '.xml')) or $xml_caching==false) {
	$file=fopen('francais_xml/' . $verb . '.xml',$write_option);
	fwrite($file,
	'<?xml version="1.0"?>
<verb>
	<tense name="infinitif">
		<infinitif>' . $verb . '</infinitif>
		<participe_présent>' . conjugate($verb,0,'participe_présent','') . '</participe_présent>
		<participe_passé>' . conjugate($verb,0,'past participle','') . '</participe_passé>
	</tense>');
	for ($t=0;$t<=count($tense)-1;$t++) {
		fwrite($file,'
	<tense name="' . $tense[$t] . '">');
		for ($i=0;$i<=count($pp);$i++) {
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
$xml = simplexml_load_file('francais_xml/' . $verb . '.xml');
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