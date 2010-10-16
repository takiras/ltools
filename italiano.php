<?
include 'head.php'; 
include 'input.php';
if ($_GET['word']!==null) $verb = $_GET['word'];
else $verb = 'amare';
switch(substr($verb,-3,3)) {
case 'rre':
case 'are':
case 'ere':
case 'ire':
	echo null;
	break;
default: die;
}
function get_stem($v,$person,$tense,$prefix) {
	switch (substr($v,-4)) {
		// make sure verbs stay soft/hard
	case 'care':
	case 'gare':
		switch ($tense) {
		case 'present':
			switch ($person) {
			case 1:
			case 3:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'h';
			}
			break;
		case 'subjunctive present':
			return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-3))) . 'h';
		}
		break;
	case 'iare':
		switch($v) {
		case 'alleviare':
		case 'avviare':
		case 'desiare':
		case 'espiare':
		case 'fuorviare':
		case 'inviare':
		case 'obliare':
		case 'odiare':
		case 'ovviare':
		case 'radiare':
		case 'ravviare':
		case 'rinviare':
		case 'spaiare':
		case 'spiare':
		case 'striare':
		case 'svariare':
		case 'sviare':
		case 'variare':
			switch ($tense) {
			case 'present':
				switch ($person) {
				case 3:
					return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-4)));
					break;
				}
				break;
			case 'subjunctive present':
				switch ($person) {
				case 3:
				case 4:
					return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-4)));
					break;
				}
			}
			break;
		default:
			switch ($tense) {
			case 'present':
				switch ($person) {
				case 1:
				case 3:
					return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-4)));
					break;
				}
				break;
			case 'subjunctive present':
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-4)));
				break;
				break;
			}
		}
	}
	switch (substr($v,-5)) {
	case 'ciare':
	case 'giare':
		switch ($tense) {
		case 'present':
			switch ($person) {
			case 1:
			case 3:
				return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-4)));
			}
			break;
		case 'subjunctive present':
			return iconv('ISO-8859-1','UTF-8',iconv('UTF-8','ISO-8859-1',substr($v,0,-4)));
		}
		break;
	}
	switch ($tense) {
		//future stems
	case 'future';
	case 'conditional';
		switch ($v) {
			//irregular future stems
		case 'essere': return 'sar';
		case 'avere': return 'avr';
		case 'dare': return 'dar';
		case 'stare': return 'star';
		case 'andare': return 'andr';
		case 'cadere': return 'cadr';
		case 'potere': return 'potr';
		case 'sapere': return 'sapr';
		case 'vedere': return 'vedr';
		case 'vivere': return 'vivr';
		case 'volere': return 'vorr';
		case 'venire': return 'verr';
			break;
		default:
			switch (substr($v,-3)) {
			case 'are':
				return get_stem($v,1,'present',$prefix) . 'er';
				break;
			case 'ere':
			case 'ire':
				return substr($v,0,-1);
				break;
			case 'rre':
				return substr($v,0,-1);
				break;
			}
		}
		break;
		//subjunctive stems
	case 'subjunctive present':
		switch ($person) {
		case 0:
		case 1:
		case 2:
		case 5: return substr(conjugate($v,0,'present',$prefix),0,-1);
			break;
		case 3:
		case 4: return substr(conjugate($v,3,'present',$prefix),0,-4);
		}
		break;
		//imperfect stems
	case 'imperfect':
	case 'subjunctive imperfect':
		return substr($v,0,-2);
		break;
		//if it's nothing special
	default:
		return iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),0,-3));
		break;
	}
}

function conjugate($v,$person,$tense,$prefix) {
	//get the stem
	$verb_stem = get_stem($v,$person,$tense,$prefix);
	if (strstr($tense,' perfect')!==false OR strstr($tense,'pluperfect')!==false OR strstr($tense,'past anterior')!==false OR $tense=='perfect' OR $tense=='negative imperative') $compound_tense = true;
	else $compound_tense= false;
	//compressed infinitives
	if (substr($v,-3)=='rre' and $tense!=='future' and $tense!=='conditional' and ($tense . $person!=='negative imperative1')) {
		return conjugate(substr($v,0,-3) . 'cere',$person,$tense,$prefix);
	}
	//auxiliary verb for perfect tenses
	switch ($prefix . $v) {
	case 'essere':
	case 'stare':
	case 'uscire':
	case 'venire':
	case 'andare':
	case 'naître':
	case 'descendre':
	case 'entrer':
	case 'tomber':
	case 'rester':
	case 'arriver':
	case 'monter':
	case 'partir':
		$auxiliary='essere';
		break;
	default: $auxiliary='avere';
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
	case 'essere':
		switch ($tense) {
		case 'present':
			switch ($person) {
			case 0: return 'sono';
			case 1: return 'sei';
			case 2: return 'è';
			case 3: return 'siamo';
			case 4: return 'siete';
			case 5: return 'sono';
			}
			break;
		case 'imperfect':
			switch ($person) {
			case 0: return 'ero';
			case 1: return 'eri';
			case 2: return 'era';
			case 3: return 'eravamo';
			case 4: return 'eravate';
			case 5: return 'erano';
			}
			break;
		case 'past historic':
			switch ($person) {
			case 0: return 'fui';
			case 1: return 'fosti';
			case 2: return 'fu';
			case 3: return 'fummo';
			case 4: return 'foste';
			case 5: return 'furono';
			}
			break;
		case 'subjunctive present':
			switch ($person) {
			case 0:
			case 1:
			case 2: return 'sia';
			case 3: return 'siamo';
			case 4: return 'siate';
			case 5: return 'siano';
			}
			break;
		case 'subjunctive imperfect':
			switch ($person) {
			case 0: return 'fossi';
			case 1: return 'fossi';
			case 2: return 'fosse';
			case 3: return 'fossimo';
			case 4: return 'foste';
			case 5: return 'fossero';
			}
			break;
		case 'positive imperative':
			switch ($person) {
			case 1: return 'sii';
			case 2: return 'sia';
			case 3: return 'siamo';
			case 4: return 'siate';
			case 5: return 'siano';
			}
			break;
		case 'past participle':
			return $prefix . 'stato';
			break;
		}
	case 'avere':
		switch ($tense) {
		case 'present':
			switch ($person) {
			case 0: return 'ho';
			case 1: return 'hai';
			case 2: return 'ha';
			case 3: return 'abbiamo';
			case 5: return 'hanno';
			}
			break;
		case 'past historic':
			switch ($person) {
			case 0: return 'ebbi';
			case 2: return 'ebbe';
			case 5: return 'ebbero';
			}
			break;
		case 'subjunctive present':
			switch ($person) {
			case 0:
			case 1:
			case 2: return 'abbia';
			case 5: return 'abbiano';
			}
			break;
		case 'positive imperative':
			switch ($person) {
			case 1: return 'abbi';
			case 4: return 'abbiate';
			}
			break;
		case 'past participle':
			return $prefix . 'avuto';
			break;
		}
		break;
	case 'stare':
		switch ($tense) {
		case 'present':
			switch ($person) {
			case 1: return 'stai';
			case 5: return 'stanno';
			}
			break;
		case 'past historic':
			switch ($person) {
			case 0: return 'stetti';
			case 1: return 'stesti';
			case 2: return 'stette';
			case 3: return 'stemmo';
			case 4: return 'steste';
			case 5: return 'stettero';
			}
			break;
		case 'subjunctive present':
			switch ($person) {
			case 0:
			case 1:
			case 2: return 'stia';
			case 5: return 'stiano';
			}
			break;
		}
		break;
	case 'andare':
		switch ($tense) {
		case 'present':
			switch ($person) {
			case 0: return 'vado';
			case 1: return 'vai';
			case 2: return 'va';
			case 5: return 'vanno';
			}
			break;
		case 'subjunctive present':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5: return conjugate('vadere',$person,$tense,$prefix);
			}
			break;
		}
		break;
	case 'dare':
		switch ($tense) {
		case 'present':
			switch ($person) {
			case 1: return 'dai';
			case 2: return 'dà';
			case 5: return 'danno';
			}
			break;
		case 'past historic':
			switch ($person) {
			case 0: return 'diedi';
			case 1: return 'desti';
			case 2: return 'diede';
			case 3: return 'demmo';
			case 4: return 'deste';
			case 5: return 'diedero';
			}
			break;
		case 'subjunctive present':
			switch ($person) {
			case 0:
			case 1:
			case 2:
			case 5: return conjugate('diere',$person,$tense,$prefix);
			}
			break;
		case 'subjunctive imperfect':
			return conjugate('dere',$person,$tense,$prefix);
			break;
		}
		break;
	}
	switch ($tense) {
		//gerund
	case 'gerund':
		if($prefix!=='') {
			return $prefix . conjugate($v,0,'gerund','');
		}
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3))) {
		case 'are':
			return $verb_stem . 'ando';
			break;
		case 'ere':
		case 'ire':
			return $verb_stem . 'endo';
			break;
		}
		break;
		//present participle
	case 'present participle':
		if($prefix!=='') {
			return $prefix . conjugate($v,0,'present participle','');
		}
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3))) {
		case 'are':
			return $verb_stem . 'ante';
			break;
		case 'ere':
		case 'ire':
			return $verb_stem . 'ente';
			break;
		}
		break;
		//past participle
	case 'past participle':
		if($prefix!=='') {
			return $prefix . conjugate($v,0,'past participle','');
		}
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3))) {
		case 'are':
			return $verb_stem . 'ato';
			break;
		case 'ere':
			return $verb_stem . 'uto';
			break;
		case 'ire':
			return $verb_stem . 'ito';
			break;
		}
		break;
		//present tense
	case 'present':
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3))) {
			//-are verbs
		case 'are':
			switch ($person) {
			case 0: return $verb_stem . 'o';
			case 1: return $verb_stem . 'i';
			case 2: return $verb_stem . 'a';
			case 3: return $verb_stem . 'iamo';
			case 4: return $verb_stem . 'ate';
			case 5: return $verb_stem . 'ano';
			}
			break;
			//-ere verbs
		case 'ere':
			switch ($person) {
			case 0: return $verb_stem . 'o';
			case 1: return $verb_stem . 'i';
			case 2: return $verb_stem . 'e';
			case 3: return $verb_stem . 'iamo';
			case 4: return $verb_stem . 'ete';
			case 5: return $verb_stem . 'ono';
			}
			break;
			//-ire verbs
		case 'ire':
			switch ($person) {
			case 0: return $verb_stem . 'o';
			case 1: return $verb_stem . 'i';
			case 2: return $verb_stem . 'e';
			case 3: return $verb_stem . 'iamo';
			case 4: return $verb_stem . 'ite';
			case 5: return $verb_stem . 'ono';
			}
			break;
		}
		break;
		//imperfect tense
	case 'imperfect':								
		switch ($person) {
		case 0: return $verb_stem . 'vo';
		case 1: return $verb_stem . 'vi';
		case 2: return $verb_stem . 'va';
		case 3: return $verb_stem . 'vamo';
		case 4: return $verb_stem . 'vate';
		case 5: return $verb_stem . 'vano';
		}
		break;
		//conditional tense	
	case 'conditional':					
		switch ($person) {
		case 0: return $verb_stem . 'ei';
		case 1: return $verb_stem . 'esti';
		case 2: return $verb_stem . 'ebbe';
		case 3: return $verb_stem . 'emmo';
		case 4: return $verb_stem . 'este';
		case 5: return $verb_stem . 'ebbero';
		}
		break;
		//past historic tense
	case 'past historic':
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3))) {
			//-are verbs
		case 'are':
			switch ($person) {
			case 0: return $verb_stem . 'ai';
			case 1: return $verb_stem . 'asti';
			case 2: return $verb_stem . 'ò';
			case 3: return $verb_stem . 'ammo';
			case 4: return $verb_stem . 'aste';
			case 5: return $verb_stem . 'arono';
			}
			break;
			//-ere verbs
		case 'ere':
			switch ($person) {
			case 0: return $verb_stem . 'ei';
			case 1: return $verb_stem . 'esti';
			case 2: return $verb_stem . 'é';
			case 3: return $verb_stem . 'emmo';
			case 4: return $verb_stem . 'este';
			case 5: return $verb_stem . 'erono';
			}
			break;
			//-ire verbs
		case 'ire':
			switch ($person) {
			case 0: return $verb_stem . 'ii';
			case 1: return $verb_stem . 'isti';
			case 2: return $verb_stem . 'ì';
			case 3: return $verb_stem . 'immo';
			case 4: return $verb_stem . 'iste';
			case 5: return $verb_stem . 'irono';
			}
			break;
		}
		break;
		//future tense
	case 'future':
		switch ($person) {
		case 0: return $verb_stem . 'ò';
		case 1: return $verb_stem . 'ai';
		case 2: return $verb_stem . 'à';
		case 3: return $verb_stem . 'emo';
		case 4: return $verb_stem . 'ete';
		case 5: return $verb_stem . 'anno';
		}
		break;
		//perfect tense
	case 'perfect':
		switch ($person) {
		case 0: return conjugate($auxiliary,0,'present','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate($auxiliary,1,'present','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate($auxiliary,2,'present','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate($auxiliary,3,'present','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate($auxiliary,4,'present','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate($auxiliary,5,'present','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//pluperfect tense
	case 'pluperfect':
		switch ($person) {
		case 0: return conjugate($auxiliary,0,'imperfect','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate($auxiliary,1,'imperfect','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate($auxiliary,2,'imperfect','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate($auxiliary,3,'imperfect','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate($auxiliary,4,'imperfect','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate($auxiliary,5,'imperfect','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//past anterior tense
	case 'past anterior':
		switch ($person) {
		case 0: return conjugate($auxiliary,0,'past historic','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate($auxiliary,1,'past historic','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate($auxiliary,2,'past historic','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate($auxiliary,3,'past historic','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate($auxiliary,4,'past historic','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate($auxiliary,5,'past historic','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//future perfect tense
	case 'future perfect':
		switch ($person) {
		case 0: return conjugate($auxiliary,0,'future','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate($auxiliary,1,'future','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate($auxiliary,2,'future','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate($auxiliary,3,'future','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate($auxiliary,4,'future','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate($auxiliary,5,'future','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//conditional perfect tense
	case 'conditional perfect':
		switch ($person) {
		case 0: return conjugate($auxiliary,0,'conditional','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate($auxiliary,1,'conditional','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate($auxiliary,2,'conditional','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate($auxiliary,3,'conditional','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate($auxiliary,4,'conditional','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate($auxiliary,5,'conditional','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//subjunctive present tense
	case 'subjunctive present':
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3))) {
		case 'are':
			switch ($person) {
			case 0:
			case 1:
			case 2: return $verb_stem . 'i';
			case 3: return $verb_stem . 'iamo';
			case 4: return $verb_stem . 'iate';
			case 5: return $verb_stem . 'ino';
			}
			break;
		case 'ere':
		case 'ire':
			switch ($person) {
			case 0:
			case 1:
			case 2: return $verb_stem . 'a';
			case 3: return $verb_stem . 'iamo';
			case 4: return $verb_stem . 'iate';
			case 5: return $verb_stem . 'ano';
			}
			break;
		}
		break;
		//subjunctive imperfect tense
	case 'subjunctive imperfect':
		switch ($person) {
		case 0:
		case 1: return $verb_stem . 'ssi';
		case 2: return $verb_stem . 'sse';
		case 3: return $verb_stem . 'ssimo';
		case 4: return $verb_stem . 'ste';
		case 5: return $verb_stem . 'ssero';
		}
		break;
		//subjunctive perfect tense
	case 'subjunctive perfect':
		switch ($person) {
		case 0: return conjugate($auxiliary,0,'subjunctive present','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate($auxiliary,1,'subjunctive present','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate($auxiliary,2,'subjunctive present','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate($auxiliary,3,'subjunctive present','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate($auxiliary,4,'subjunctive present','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate($auxiliary,5,'subjunctive present','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//subjunctive pluperfect tense
	case 'subjunctive pluperfect':
		switch ($person) {
		case 0: return conjugate($auxiliary,0,'subjunctive imperfect','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 1: return conjugate($auxiliary,1,'subjunctive imperfect','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 2: return conjugate($auxiliary,2,'subjunctive imperfect','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 3: return conjugate($auxiliary,3,'subjunctive imperfect','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 4: return conjugate($auxiliary,4,'subjunctive imperfect','') . ' ' . conjugate($v,0,'past participle',$prefix);
		case 5: return conjugate($auxiliary,5,'subjunctive imperfect','') . ' ' . conjugate($v,0,'past participle',$prefix);
		}
		break;
		//positive imperative
	case 'positive imperative':
		switch (iconv('ISO-8859-1','UTF-8',substr(iconv('UTF-8','ISO-8859-1',$v),-3))) {
		case 'are':
			switch ($person) {	
			case 1: return conjugate($v,2,'present',$prefix);
			case 2: return conjugate($v,2,'subjunctive present',$prefix);
			case 3: return conjugate($v,3,'present',$prefix);
			case 4: return conjugate($v,4,'present',$prefix);
			case 5: return conjugate($v,5,'subjunctive present',$prefix);
			}
			break;
		case 'ire':
		case 'ere':
			switch ($person) {	
			case 1: return conjugate($v,1,'present',$prefix);
			case 2: return conjugate($v,2,'subjunctive present',$prefix);
			case 3: return conjugate($v,3,'present',$prefix);
			case 4: return conjugate($v,4,'present',$prefix);
			case 5: return conjugate($v,5,'subjunctive present',$prefix);
			}
			break;
		}
		break;
		//negative imperative
	case 'negative imperative':
		switch ($person) {	
		case 1: return 'non ' . $v;
		case 2:
		case 3:
		case 4:
		case 5: return 'non ' . conjugate($v,$person,'positive imperative',$prefix);
		}
		break;
	}
}
	//verb data
	$pp=array(
	'io',
	'tu',
	'lui',
	'noi',
	'voi',
	'loro');
	$tense=array(
	'present',
	'imperfect',
	'past historic',
	'future',
	'perfect',
	'pluperfect',
	'past anterior',
	'future perfect',
	'conditional',
	'conditional perfect',
	'subjunctive present',
	'subjunctive imperfect',
	'subjunctive perfect',
	'subjunctive pluperfect',
	'positive imperative',
	'negative imperative');

	//config
	$xml_caching = false; //xml caching - true to use cache, false to generate xml each time.
	$use_color = true; //use colored tables opposed to greyscale.

	//don't edit below here
	if ($xml_caching==true) $write_option='x';
	else $write_option='w';

	//write xml
	if ((!file_exists('italiano_xml/' . $verb . '.xml')) or $xml_caching==false) {
		$file=fopen('italiano_xml/' . $verb . '.xml',$write_option);
		fwrite($file,
		'<?xml version="1.0"?>
<verb>
	<tense name="infinitive">
		<infinitive>' . $verb . '</infinitive>
		<gerund>' . conjugate($verb,0,'gerund','') . '</gerund>
		<present_participle>' . conjugate($verb,0,'present participle','') . '</present_participle>
		<past_participle>' . conjugate($verb,0,'past participle','') . '</past_participle>
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
	$xml = simplexml_load_file('italiano_xml/' . $verb . '.xml');
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