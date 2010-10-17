<?
include 'head.php'; 
include 'input.php';
if ($_GET['word']!==null) $verb = $_GET['word'];
else $verb = '食べる';
//get functions
$prefix = '';
function romaji_to_kana($string) {
	$replacements=array(
	'kya' => 'きゃ',
	'kyo' => 'きょ',
	'kyu' => 'きゅ',
	'gya' => 'ぎゃ',
	'gyu' => 'ぎゅ',
	'gyo' => 'ぎょ',
	'sya' => 'しゃ',
	'sha' => 'しゃ',
	'syu' => 'しゅ',
	'shu' => 'しゅ',
	'syo' => 'しょ',
	'sho' => 'しょ',
	'zya' => 'じゃ',
	'ja' => 'じゃ',
	'zyu' => 'じゅ',
	'ju' => 'じゅ',
	'zyo' => 'じょ',
	'jo' => 'じょ',
	'tya' => 'ちゃ',
	'cha' => 'ちゃ',
	'tyu' => 'ちゅ',
	'chu' => 'ちゅ',
	'tyo' => 'ちょ',
	'chu' => 'ちょ',
	'dya' => 'ぢゃ',
	'dyu' => 'ぢゅ',
	'dyo' => 'ぢょ',
	'nya' => 'にゃ',
	'nyu' => 'にゅ',
	'nyo' => 'にょ',
	'hya' => 'ひゃ',
	'hyu' => 'ひゅ',
	'hyo' => 'ひょ',
	'bya' => 'びゃ',
	'byu' => 'びゅ',
	'byo' => 'びょ',
	'pya' => 'ぴゃ',
	'pyu' => 'ぴゅ',
	'pyo' => 'ぴょ',
	'mya' => 'みゃ',
	'myu' => 'みゅ',
	'myo' => 'みょ',
	'rya' => 'りゃ',
	'ryu' => 'りゅ',
	'ryo' => 'りょ',
	'shi' => 'し',
	'chi' => 'ち',
	'tsu' => 'つ',
	'ka' => 'か',
	'ki' => 'き',
	'ku' => 'く',
	'ke' => 'け',
	'ko' => 'こ',
	'ga' => 'が',
	'gi' => 'ぎ',
	'gu' => 'ぐ',
	'ge' => 'げ',
	'go' => 'ご',
	'sa' => 'さ',
	'si' => 'し',
	'su' => 'す',
	'se' => 'せ',
	'so' => 'そ',
	'za' => 'ざ',
	'zi' => 'じ',
	'ji' => 'じ',
	'zu' => 'ず',
	'ze' => 'ぜ',
	'zo' => 'ぞ',
	'ta' => 'た',
	'ti' => 'ち',
	'tu' => 'つ',
	'te' => 'て',
	'to' => 'と',
	'da' => 'だ',
	'di' => 'ぢ',
	'du' => 'づ',
	'dzu' => 'づ',
	'de' => 'で',
	'do' => 'ど',
	'na' => 'な',
	'ni' => 'に',
	'nu' => 'ぬ',
	'ne' => 'ね',
	'no' => 'の',
	'ha' => 'は',
	'hi' => 'ひ',
	'hu' => 'ふ',
	'fu' => 'ふ',
	'he' => 'へ',
	'ho' => 'ほ',
	'ba' => 'ば',
	'bi' => 'び',
	'bu' => 'ぶ',
	'be' => 'べ',
	'bo' => 'ぼ',
	'pa' => 'ぱ',
	'pi' => 'ぴ',
	'pu' => 'ぷ',
	'pe' => 'ぺ',
	'po' => 'ぽ',
	'ma' => 'ま',
	'mi' => 'み',
	'mu' => 'む',
	'me' => 'め',
	'mo' => 'も',
	'ya' => 'や',
	'yu' => 'ゆ',
	'yo' => 'よ',
	'ra' => 'ら',
	'ri' => 'り',
	'ru' => 'る',
	're' => 'れ',
	'ro' => 'ろ',
	'wa' => 'わ',
	'wo' => 'を',
	'n\'' => 'ん',
	'nn' => 'ん',
	'a' => 'あ',
	'i' => 'い',
	'u' => 'う',
	'e' => 'え',
	'o' => 'お',
	'n' => 'ん',
	'k' => 'っ',
	'g' => 'っ',
	's' => 'っ',
	'z' => 'っ',
	'j' => 'っ',
	't' => 'っ',
	'c' => 'っ',
	'h' => 'っ',
	'f' => 'っ',
	'b' => 'っ',
	'p' => 'っ',
	'm' => 'ん',
	'y' => 'っ',
	'r' => 'っ',
	'w' => 'っ',
	);
	return str_ireplace(array_keys($replacements),array_values($replacements),$string);
}
$verb=romaji_to_kana($verb);
function get_type($v,$prefix) {
	switch ($v)
	{
		// Irregular verbs
	case 'だ':
		return 'copula';
		break;
	case 'する':
	case 'ずる':
		return 'vs';
		break;
	case 'くる':
	case '来る':
		return 'vk';
		break;
	case 'た':
	case 'ぬ':
	case 'つ':
	case 'たり':
		return 'helper';
		break;
		// -aru honorific verbs
	case 'くださる':
	case '下さる':
	case 'なさる':
	case '為さる':
	case 'いらっしゃる':
	case '居らっしゃる':
	case 'でござる':
	case 'ござる':
	case 'で御座る':
	case '御座る':
	case 'おっしゃる':
	case '仰る':
	case '仰っしゃる':
		return 'v5-aru';
		break;
	default:
		// 一段 verbs that look like 五段 and vice versa
		switch($v) {
		case '着る':
		case '見る':
		case '干る':
		case '寝る':
		case '似る':
		case '煮る';
		case 'びる';
		case '看る';
		case '射る';
		case '鋳る';
		case '鑄る';
		case '湿気る';
		case '歴る';
		case '経る';
			return 'v1';
		case 'しる';
		case '翔ける';
		case 'てる';
		case 'ほてる';
		case 'まいる';
		case 'しゃべる';
		case 'はしる';
		case 'はいる';
		case 'しきる';
		case 'めいる';
		case 'むしる';
		case 'ののしる';
		case 'ちる';
		case 'けちる';
		case 'かぎる';
		case 'ちぎる';
		case 'にぎる';
		case 'さえぎる';
		case 'いじる';
		case 'かじる';
		case 'ねじる';
		case 'なじる';
		case 'まじる';
		case '交じる';
		case '混じる';
		case '雑じる';
		case '交じる';
		case '捩じる';
		case '捻じる';
		case '拗じる';
		case 'ふみにじる';
		case 'くつがえる';
		case 'よみがえる';
		case '甦える';
		case '蘇える';
		case 'ける';
		case 'あざける';
		case 'うねる';
		case '畝ねる';
		case 'つねる';
		case 'くねる';
		case 'しげる';
		case 'はべる';
			return 'v5-r';
		}
		switch (substr($v,-3))
		{
			// 五段 verbs
		case 'う':
			return 'v5-u';
			break;
		case 'く':
			return 'v5-k';
			break;
		case 'ぐ':
			return 'v5-g';
			break;
		case 'す':
			return 'v5-s';
			break;
		case 'つ':
			return 'v5-t';
			break;
		case 'ぬ':
			return 'v5-n';
			break;
		case 'ぶ':
			return 'v5-b';
			break;
		case 'む':
			return 'v5-m';
			break;
			// terrible ～る 一段/五段 detection
		case 'る':
			switch(substr($v,-6)) {
			case 'いる':
				case 'える' :
				case'きる' :
				case'ける' :
				case'ぎる' :
				case'げる' :
				case'しる' :
				case'せる' :
				case'じる' :
				case'ぜる' :
				case'ちる' :
				case'てる' :
				case'ぢる' :
				case'でる' :
				case'にる' :
				case'ねる' :
				case'ひる' :
				case'へる' :
				case'びる' :
				case'べる' :
				case'ぴる' :
				case'ぺる' :
				case'みる' :
				case'める' :
				case'りる' :
				case'れる':
				return 'v1';
				break;
			default: return 'v5-r';
			}
			break;
		case 'い':
			return 'adj-i';
			break;
		}
	} 
	echo '「' . $v . '」とはイ形容詞か動詞かではありません。違う言葉を入力してください。';
	die();
}

function get_stem($v,$conjugation,$prefix) {
	switch ($conjugation) {
	case 'imperfective':
	case 'continuative':
	case 'predicative':
	case 'attributative':
	case 'hypothetical':
	case 'commanding':
		return substr($v,0,-3);
		break;
	case 'past':
	case 'current conditional':
	case 'conjunctive':
	case 'current conditional':
	case 'representative':
		if ($v=='行く' or $v=='いく') return substr(conjugate($v,'continuative',$prefix),0,-3) . 'っ';
		if ($v=='問う' or $v=='訪う' or $v=='とう' or $v=='乞う' or $v=='請う') return $v;
		switch (get_type($v,$prefix)) {
		case 'v5-u':
		case 'v5-t':
		case 'v5-r':
		case 'v5-aru':
			return substr(conjugate($v,'continuative',$prefix),0,-3) . 'っ';
			break;
		case 'v5-k':
		case 'v5-g':
			return substr(conjugate($v,'continuative',$prefix),0,-3) . 'い';
			break;
		case 'v5-n':
		case 'v5-b':
		case 'v5-m':
			return substr(conjugate($v,'continuative',$prefix),0,-3) . 'ん';
		case 'adj-i':
			return substr(conjugate($v,'continuative',$prefix),0,-3) . 'かっ';
			break;
		default:
			return conjugate($v,'continuative',$prefix);
			break;
		}
		break;
	case 'volitional':
		switch (get_type($v,$prefix)) {
		case 'v5-u': return substr(conjugate($v,'imperfective',$prefix),0,-3) . 'お';
		case 'v5-k': return substr(conjugate($v,'imperfective',$prefix),0,-3) . 'こ';
		case 'v5-g': return substr(conjugate($v,'imperfective',$prefix),0,-3) . 'ご';
		case 'v5-s': return substr(conjugate($v,'imperfective',$prefix),0,-3) . 'そ';
		case 'v5-t': return substr(conjugate($v,'imperfective',$prefix),0,-3) . 'と';
		case 'v5-n': return substr(conjugate($v,'imperfective',$prefix),0,-3) . 'の';
		case 'v5-b': return substr(conjugate($v,'imperfective',$prefix),0,-3) . 'ぼ';
		case 'v5-m': return substr(conjugate($v,'imperfective',$prefix),0,-3) . 'も';
		case 'v5-r':
		case 'v5-aru': return substr(conjugate($v,'imperfective',$prefix),0,-3) . 'ろ';
		case 'vk':
		case 'vs':
		case 'v1': return conjugate ($v,'imperfective',$prefix) . 'よ';
		case 'adj-i': return substr(conjugate($v,'imperfective',$prefix),0,-3) . 'かろ';
			break;
		default: return conjugate ($v,'imperfective',$prefix);
		}
		break;
	default: return '';
	}
}

function conjugate($v,$conjugation,$prefix) {
	$stem=get_stem($v,$conjugation,$prefix);
	// compounds
	if ($prefix=='') {
		$compound_auxiliaries=array(
		'する',
		'ずる',
		'くる',
		'来る',
		'いく',
		'行く',
		'ゆく',
		'ます',
		'ん',
		);
		foreach ($compound_auxiliaries as $auxiliary) {
			if (substr($v,-strlen($auxiliary))==$auxiliary and $v!==$auxiliary) {
				if ($conjugation!=='honorific' and $conjugation!=='humble' and conjugate($auxiliary,$conjugation,substr($v,0,-strlen($auxiliary)))=='なし') return 'なし';
				else if ($conjugation=='honorific' or $conjugation=='humble') return conjugate($auxiliary,$conjugation,substr($v,0,-strlen($auxiliary)));
				return substr($v,0,-strlen($auxiliary)) . conjugate($auxiliary,$conjugation,substr($v,0,-strlen($auxiliary)));
			}
		}
		if (substr($v,-6)=='いい' and $v!=='いい' and conjugate('いい',$conjugation,substr($v,0,-6))!=='なし') return substr($v,0,-6) . conjugate('いい',$conjugation,substr($v,0,-6));
	}
	// irregular forms
	switch ($v) {
	case '食べる':
	case 'たべる':
	case '飲む':
	case '呑む':
	case 'のむ':
		switch ($conjugation) {
		case 'humble': return 'いただく';
		case 'honorific': return 'お召し上がる';
		}
		break;
	case 'もらう':
	case '貰う':
		switch ($conjugation) {
		case 'humble': return 'いただく';
		}
		break;
	case '行く':
	case 'いく':
		switch ($conjugation) {
		case 'humble': return $prefix . '参る';
		}
		break;
	case 'いる':
	case '居る':
		switch ($conjugation) {
		case 'humble': return 'おる';
		case 'honorific': return 'いらっしゃる／お出でになる／お出でなさる';
		}
	case 'しる':
	case '知る':
		switch ($conjugation) {
		case 'humble': return '存じる';
		case 'honorific': return 'ご存知になる／ご存知なさる';
		}
	case 'みる':
	case '見る':
		switch ($conjugation) {
		case 'humble': return '拝見する';
		case 'honorific': return '御覧になる／ご覧なさる';
		}
		break;
	case '寝る':
	case 'ねる':
		switch ($conjugation) {
		case 'honorific': return 'お休みになる／お休みなさる';
		}
		break;
	case '思う':
	case '想う':
	case 'おもう':
		switch ($conjugation) {
		case 'honorific': return '思し召す／お思いになる／お思いになさる';
		}
		break;
	case 'きる':
	case '着る':
		switch ($conjugation) {
		case 'honorific': return 'お召しになる／お召しなさる';
		}
		break;
	case '聞く':
		switch ($conjugation) {
		case 'humble': return '伺う／承る';
		}
		break;
	case 'あげる':
	case '上げる':
		switch ($conjugation) {
		case 'humble': return '差し上げる';
		}
		break;
	case 'あう':
	case '会う':
	case '合う':
		switch ($conjugation) {
		case 'humble': return 'お目にかかる';
		}
		break;
	case 'みせる':
	case '見せる':
		switch ($conjugation) {
		case 'humble': return 'ご覧に入れる';
		}
		break;
	case '言う':
	case '云う':
	case '謂う':
	case 'いう':
		switch ($conjugation) {
		case 'humble': return '申す';
		case 'honorific': return 'おっしゃる';
		}
		break;
	case 'ぬ':
	case 'ん':
		switch ($conjugation) {
		case 'continuative': return 'ず';
		case 'predicative': return 'ん';
		case 'attributative': return 'ぬ';
		case 'conjunctive': return 'ず';
		default: return 'なし';
		}
		break;
	case 'た':
		switch ($conjugation) {
		case 'imperfective': return 'たろ';
		case 'hypothetical': return 'たら';
		case 'predicative':
		case 'attributative': return 'た';
		default: return 'なし';
		}
		break;
	case 'ます':
		switch ($conjugation) {
		case 'imperfective': return 'ませ';
		case 'hypothetical': return 'ますれ';
		case 'non-past negative': return conjugate('ます','imperfective',$prefix) . 'ん';
		case 'past negative': return conjugate('ます','non-past negative',$prefix) . conjugate('だ','polite past','');
		case 'volitional': return conjugate('ます','continuative',$prefix) . 'ょう';
		case 'conjunctive negative': return 'ませずに';
		}
		break;
	case 'つ':
		switch ($conjugation) {
		case 'imperfective': return 'て';
		case 'continuative': return 'て';
		case 'attributative': return 'つ／る';
		case 'hypothetical': return 'つれ';
		case 'commanding': return 'つれ';
		default: return 'なし';
		}
		break;
	case '起る':
	case '起こる':
		switch ($conjugation) {
		case 'potential': return conjugate($v,'continuative',$prefix) . 'える';
		}
		break;
	case 'ある':
	case '有る':
	case '在る':
		switch ($conjugation) {
		case 'potential': return conjugate($v,'continuative',$prefix) . 'える';
		case 'volitional negative': return conjugate($v,'non-past',$prefix) . 'まい／' . $prefix . conjugate(conjugate($v,'non-past negative',$prefix),'volitional',$prefix);
		case 'non-past negative': return 'ない';
		}
		break;
	case 'である':
		switch ($conjugation) {
		case 'volitional negative':
			return 'であるまい／ではなかろう';
			break;
		case 'non-past negative':
		case 'past negative':
		case 'polite non-past negative':
		case 'polite past negative':
		case 'conjunctive negative':
			return 'では' . conjugate('ある',$conjugation,'では');
			break;
		default:
			return 'で' . conjugate('ある',$conjugation,'で');
			break;
		}
		break;
	case 'だ':
		switch ($conjugation) {
		case 'imperfective': return 'だろ';
		case 'continuative': return 'で';
		case 'predicative': return 'だ';
		case 'attributative': return 'な';
		case 'hypothetical': return 'なら';
		case 'past': return 'だった';
		case 'current conditional': return 'だったら';
		case 'hypothetical conditional': return 'なら〔ば〕';
		case 'polite non-past':
		case 'polite past':
		case 'polite volitional': return conjugate('です',substr($conjugation,7),$prefix);
		case 'volitional': return 'だろう';
		case 'conjunctive': return 'で';
		case 'representative listing': return 'だったり';
		default: 
			return conjugate('である',$conjugation,$prefix);
			break;
		}
		break;
	case 'です':
		switch ($conjugation) {
		case 'non-past': return 'です';
		case 'past': return 'でした';
		case 'volitional': return 'でしょう';
		case 'current conditional': return 'でしたら';
		case 'non-past negative':
		case 'past negative': return conjugate('である','polite ' . $conjugation,'');
		case 'hypothetical conditional':
		case 'polite non-past':
		case 'polite past': return conjugate('である',$conjugation,'');
		default: 
			return conjugate('だ',$conjugation,$prefix);
			break;
		}
		break;
	case 'いい':
		switch ($conjugation) {
		case 'predicative':
		case 'attributative': return 'いい';
		case 'imperfective':
		case 'continuative':
		case 'hypothetical':
		case 'commanding': return conjugate('よい',$conjugation,$prefix);
		case 'noun': return 'よさ';
		case '-sou': return 'よさそう';
		}
		break;
	case 'ない':
		switch ($conjugation) {
		case 'noun': return 'なし';
			break;
		}
		break;
	case 'くる':
		switch ($conjugation) {
		case 'imperfective': return 'こ';
		case 'continuative': return 'き';
		case 'hypothetical': return 'くれ';
		case 'commanding': return 'こい';
		case 'humble': return $prefix . '参る';
		case 'honorific': return $prefix . 'いらっしゃる／' . $prefix . 'お出でになる／' . $prefix . 'お出でなさる';
		}
		break;
	case '来る':
		switch ($conjugation) {
		case 'imperfective': return '来';
		case 'continuative': return '来';
		case 'hypothetical': return '来れ';
		case 'commanding': return '来い';
		case 'humble': return $prefix . '参る';
		case 'honorific': return $prefix . 'いらっしゃる／' . $prefix . 'お出でになる／' . $prefix . 'お出でなさる';
		}
		break;
	case 'する':
		switch ($conjugation) {
		case 'imperfective': return 'さ、' . $prefix . 'し、' . $prefix . 'せ';
		case 'continuative': return 'し';
		case 'hypothetical': return 'すれ';
		case 'commanding': return 'しろ／' . $prefix . 'せよ';
		case 'imperative': return 'しろ／' . $prefix . 'せよ';
		case 'non-past negative': return 'しない';
		case 'classical negative': return 'せぬ';
		case 'potential': return 'できる';
		case 'passive': return 'される';
		case 'causative': return 'させる';
		case 'short causative': return 'さす';
		case 'negative adverb': return 'せず';
		case 'volitional': return 'しよう';
		case 'short passive-causative': return 'なし';
		}
		break;
	case 'ずる':
		switch ($conjugation) {
		case 'imperfective': return 'じ、' . $prefix . 'ぜ';
		case 'continuative': return 'じ';
		case 'predicative':
		case 'attributative': return 'じる／' . $prefix . 'ずる';
		case 'hypothetical': return 'じれ／' . $prefix . 'ずれ';
		case 'commanding': return 'じろ／' . $prefix . 'じよ／' . $prefix . 'ぜよ';
		case 'non-past negative': return 'じない';
		case 'hypothetical conditional': return 'じれば／' . $prefix . 'ずれば';
		case 'classical negative': return 'じぬ／' . $prefix . 'ぜぬ';
		case 'potential': return 'できる／' . $prefix . 'じられる';
		case 'passive': return 'じられる';
		case 'causative': return 'じさせる';
		case 'short causative': return 'じさす／' . $prefix . 'ざす';
		case 'negative adverb': return 'じず／' . $prefix . 'せず';
		case 'volitional': return 'じよう';
		case 'volitional negative': return 'じまい／' . $prefix . 'ずるまい';
		}
		break;
	}
	switch ($conjugation) {
		// imperfective form
	case 'imperfective':
		switch(get_type($v,$prefix)) {
		case 'v5-u':
			return $stem . 'わ';
			break;
		case 'v5-k':
			return $stem . 'か';
			break;
		case 'v5-g':
			return $stem . 'が';
			break;
		case 'v5-s':
			return $stem . 'さ';
			break;
		case 'v5-t':
			return $stem . 'た';
			break;
		case 'v5-n':
			return $stem . 'な';
			break;
		case 'v5-b':
			return $stem . 'ば';
			break;
		case 'v5-m':
			return $stem . 'ま';
			break;
		case 'v5-r':
		case 'v5-aru':
			return $stem . 'ら';
			break;
		case 'v1':
			return $stem;
			break;
		case 'adj-i':
			return $stem . 'く';
			break;
		}
		break;
		// continuative form
	case 'continuative':
		switch(get_type($v,$prefix)) {
		case 'v5-u':
		case 'v5-aru':
			return $stem . 'い';
			break;
		case 'v5-k':
			return $stem . 'き';
			break;
		case 'v5-g':
			return $stem . 'ぎ';
			break;
		case 'v5-s':
			return $stem . 'し';
			break;
		case 'v5-t':
			return $stem . 'ち';
			break;
		case 'v5-n':
			return $stem . 'に';
			break;
		case 'v5-b':
			return $stem . 'び';
			break;
		case 'v5-m':
			return $stem . 'み';
			break;
		case 'v5-r':
			return $stem . 'り';
			break;
		case 'adj-i':
			return $stem . 'く';
		case 'v1':
			return $stem;
			break;
		}
		break;
		// predicative/attributative form
	case 'predicative':
	case 'attributative':
		switch(get_type($v,$prefix)) {
		case 'copula':
			if ($conjugation=='predicative') return 'だ';
			return 'な';
			break;
		default: return $v;
		}
		break;
		// hypothetical and commanding form
	case 'hypothetical':
	case 'commanding':
		switch(get_type($v,$prefix)) {
		case 'v5-u':
			return $stem . 'え';
			break;
		case 'v5-k':
			return $stem . 'け';
			break;
		case 'v5-g':
			return $stem . 'げ';
			break;
		case 'v5-s':
			return $stem . 'せ';
			break;
		case 'v5-t':
			return $stem . 'て';
			break;
		case 'v5-n':
			return $stem . 'ね';
			break;
		case 'v5-b':
			return $stem . 'べ';
			break;
		case 'v5-m':
			return $stem . 'め';
			break;
		case 'v5-r':
			return $stem . 'れ';
			break;
		case 'adj-i':
			if ($conjugation=='hypothetical') return $stem . 'けれ';
			return $stem . 'かれ';
		case 'v5-aru':
			if ($conjugation=='hypothetical') return $stem . 'れ';
			return $stem . 'い';
		case 'v1':
			if ($conjugation=='hypothetical') return $stem . 'れ';
			return $stem . 'ろ／' . $stem . 'よ';
		}
		break;
		//non-past
	case 'non-past':
		return conjugate($v,'predicative',$prefix);
		break;
		//non-past negative
	case 'non-past negative':
		return conjugate($v,'imperfective',$prefix) . conjugate('ない','predicative','');
		break;
	case 'classical negative':
		if (get_type($v,$prefix)=='adj-i') return 'なし';
		return conjugate($v,'imperfective',$prefix) . 'ぬ';
		break;
	case 'negative adverb':
		if (get_type($v,$prefix)=='adj-i') return 'なし';
		return conjugate($v,'imperfective',$prefix) . conjugate('ぬ','continuative','');
		break;
	case 'conjunctive negative':
		return conjugate(conjugate($v,'non-past negative',$prefix),'conjunctive','') . '／' . $prefix . conjugate($v,'non-past negative',$prefix) . 'で';
		break;
		//past
	case 'past':		
		switch(get_type($v,$prefix)) {
		case 'v5-g':
		case 'v5-n':
		case 'v5-b':
		case 'v5-m':
			return $stem . 'だ';
			break;
		default:
			return $stem . 'た';
			break;
		}
		break;
		//past negative
	case 'past negative':
		return conjugate(conjugate($v,'non-past negative',$prefix),'past','');
		break;
		//current conditional
	case 'current conditional':		
		switch(get_type($v,$prefix)) {
		case 'v5-g':
		case 'v5-n':
		case 'v5-b':
		case 'v5-m':
			return $stem . 'だら';
			break;
		default:
			return $stem . 'たら';
			break;
		}
		break;
		//hypothetical conditional
	case 'hypothetical conditional':		
		return conjugate($v,'hypothetical',$prefix) . 'ば';
		break;
		// polite forms
	case 'polite non-past':
	case 'polite non-past negative':
	case 'polite past':
	case 'polite past negative':
	case 'polite volitional':
	case 'polite imperative':
		if (get_type($v,$prefix)=='adj-i') {
			switch ($conjugation) {
			case 'polite imperative':
			case 'polite non-past negative':
			case 'polite past negative': return conjugate($v,'continuative',$prefix) . conjugate('ある',substr('polite ' . $conjugation,7),'');
			case 'polite non-past': return conjugate($v,substr($conjugation,7),$prefix) . conjugate('だ','polite non-past','');
			case 'polite past': return conjugate($v,substr($conjugation,7),$prefix) . conjugate('だ','polite non-past','');
			default: return conjugate($v,'non-past',$prefix) . conjugate('だ',$conjugation,'');
			}
		}
		return conjugate($v,'continuative',$prefix) . conjugate('ます',substr($conjugation,7),conjugate($v,'continuative',$prefix));
		break;
		//volitional & volitional negative
	case 'volitional':		
		return $stem . 'う';
		break;
	case 'volitional negative':		
		switch (get_type($v,$prefix)) {
		case 'v1':
			return conjugate($v,'imperfective',$prefix) . 'まい';
			break;
		case 'adj-i':
			return conjugate(conjugate($v,'non-past negative',''),'volitional',$prefix);
			break;
		default:
			return conjugate($v,'attributative',$prefix) . 'まい';
			break;
		}
		break;
		//-sou form
	case '-sou':		
		if (get_type($v,$prefix)=='adj-i') 		return get_stem($v,'imperfective',$prefix) . 'そう';
		return conjugate($v,'continuative',$prefix) . 'そう';
		break;
		//potential
	case 'potential':		
		switch (get_type($v,$prefix)) {
		case 'v1':
		case 'vs':
		case 'vk':
			return conjugate($v,'imperfective',$prefix) . 'られる';
			break;
		case 'adj-i':
			return 'なし';
			break;
		default:
			return conjugate($v,'hypothetical',$prefix) . 'る';
			break;
		}
		break;
		//passive
	case 'passive':		
		switch (get_type($v,$prefix)) {
		case 'v1':
		case 'vs':
		case 'vk':
			return conjugate($v,'imperfective',$prefix) . 'られる';
			break;
		case 'adj-i':
			return 'なし';
			break;
		default:
			return conjugate($v,'imperfective',$prefix) . 'れる';
			break;
		}
		break;
		//causative
	case 'causative':		
		switch (get_type($v,$prefix)) {
		case 'v1':
		case 'vs':
		case 'vk':
			return conjugate($v,'imperfective',$prefix) . 'させる';
			break;
		case 'adj-i':
			return 'なし';
			break;
		default:
			return conjugate($v,'imperfective',$prefix) . 'せる';
			break;
		}
		break;
	case 'short causative':		
		switch (get_type($v,$prefix)) {
		case 'v1':
		case 'vs':
		case 'vk':
			return conjugate($v,'imperfective',$prefix) . 'さす';
			break;
		case 'adj-i':
			return 'なし';
			break;
		default:
			return conjugate($v,'imperfective',$prefix) . 'す';
			break;
		}
		break;
		//passive-causative
	case 'passive-causative':
		if (get_type($v,$prefix)!=='adj-i'){
			return conjugate(conjugate($v,'causative',$prefix),'passive',$prefix);
		}
		return 'なし';
		break;
	case 'short passive-causative':
		switch (get_type($v,$prefix)) {
		case 'adj-i':
		case 'v1':
		case 'v5-s':
		case 'vs':
		case 'vk':
			return 'なし';
			break;
		default:
			return conjugate(conjugate($v,'short causative',$prefix),'passive',$prefix);
			break;
		}
		break;
		//conjunctive
	case 'conjunctive':		
		switch(get_type($v,$prefix)) {
		case 'v5-g':
		case 'v5-n':
		case 'v5-b':
		case 'v5-m':
			return $stem . 'で';
			break;
		case 'adj-i':
			return conjugate($v,'continuative',$prefix) . 'て';
			break;
		default:
			return $stem . 'て';
			break;
		}
		break;
		//representative
	case 'representative':		
		switch(get_type($v,$prefix)) {
		case 'v5-g':
		case 'v5-n':
		case 'v5-b':
		case 'v5-m':
			return $stem . 'だり';
			break;
		default:
			return $stem . 'たり';
			break;
		}
		break;
		//noun
	case 'noun':		
		switch(get_type($v,$prefix)) {
		case 'adj-i':
			return substr(conjugate($v,'continuative',$prefix),0,-3) . 'さ／' . $prefix . substr(conjugate($v,'continuative',$prefix),0,-3) . 'み';
		default:
			return conjugate($v,'continuative',$prefix);
			break;
		}
		break;
		//desires
	case 'desirative':		
		switch(get_type($v,$prefix)) {
		case 'adj-i':
			return 'なし';
			break;
		default: return conjugate($v,'continuative',$prefix) . 'たい';
			break;
		}
		break;
	case 'desired action':		
		return conjugate($v,'conjunctive',$prefix) . 'ほしい';
		break;
		//imperatives
	case 'imperative':	
		switch(get_type($v,$prefix)) {
		case 'adj-i':
			return conjugate($v,'commanding',$prefix) . '／' . $prefix . conjugate($v,'continuative',$prefix) . 'あれ';
			break;	
		default: return conjugate($v,'commanding',$prefix);
			break;
		}
		break;
	case 'prohibitive':		
		switch(get_type($v,$prefix)) {
		case 'adj-i':
			return conjugate(conjugate($v,'non-past negative',$prefix),'commanding',$prefix) . '／' . $prefix . conjugate($v,'continuative',$prefix) . 'あるな';
			break;	
		default: return conjugate($v,'attributative',$prefix) . 'な';
			break;
		}
		break;
	case 'request':		
		return conjugate($v,'conjunctive',$prefix) . 'ください';
		break;
	case 'negative request':		
		return conjugate($v,'non-past negative',$prefix) . 'でください';
		break;
		//honorific and humble
	case 'honorific':
		switch(get_type($v,$prefix)) {
		case 'adj-i':
			return 'なし';
			break;	
		case 'vs':
			if ($prefix=='') return 'なさる';
			return 'ご' . $prefix . conjugate($v,'continuative',$prefix) . 'になる' . '／ご' . $prefix . conjugate($v,'continuative',$prefix) . 'なさる';
			break;	
		default: return 'お' . $prefix . conjugate($v,'continuative',$prefix) . 'になる' . '／お' . $prefix . conjugate($v,'continuative',$prefix) . 'なさる';
			break;
		}
	break;
	case 'humble':
		switch(get_type($v,$prefix)) {
		case 'adj-i':
			return 'なし';
			break;	
		case 'vs':
			if ($prefix=='') return '致す';
			return 'ご' . $prefix . conjugate($v,'continuative',$prefix) . 'する' . '／ご' . $prefix . conjugate($v,'continuative',$prefix) . '致す';
			break;	
		default: return 'お' . $prefix . conjugate($v,'continuative',$prefix) . 'する' . '／お' . $prefix . conjugate($v,'continuative',$prefix) . '致す';
			break;
		}
	break;
	}
}
//verb data
$conjugation=array(
'imperfective',
'continuative',
'predicative',
'attributative',
'hypothetical',
'commanding',
'non-past',
'non-past negative',
'past',
'past negative',
'volitional',
'volitional negative',
'imperative',
'prohibitive',
'polite non-past',
'polite non-past negative',
'polite past',
'polite past negative',
'polite volitional',
'polite imperative',
'noun',
'classical negative',
'negative adverb',
'current conditional',
'hypothetical conditional',
'-sou',
'humble',
'honorific',
'potential',
'passive',
'causative',
'short causative',
'passive-causative',
'short passive-causative',
'conjunctive',
'conjunctive negative',
'representative',
'request',
'negative request',
'desirative',
'desired action',
);

//config
$xml_writing = true; //enable xml writing, disable if you don't want any new files
$xml_caching = false; //xml caching - true to use cache, false to generate xml each time.
$use_color = true; //use colored tables opposed to greyscale.
$disable_page = false; //stop people using the page for conjugations (headers will still show)

//don't edit below here
if ($xml_caching==true) $write_option='x';
else $write_option='w';
if ($use_color==true) $color_option='c';
else $color_option='g';
if ($disable_page==true) {
echo 'すみませんが、今このページは使用禁止でございます。';
die;
}

//write xml
if ((!file_exists('japanese_xml/' . $verb . '.xml') or $xml_caching==false) and $xml_writing==true) {
	$file=fopen('japanese_xml/' . $verb . '.xml',$write_option);
	fwrite($file,
	'<?xml version="1.0"?>
<verb>');
	for ($i=0;$i<=count($conjugation)-1;$i++) {
		if (conjugate($verb,$conjugation[$i],'')!=='なし') fwrite($file,'
	<conjugation name="' . $conjugation [$i] . '">'. conjugate($verb,$conjugation[$i],'') . '</conjugation>');
	}
	fwrite($file,'
</verb>');
	fclose($file);
}
	elseif (!file_exists('japanese_xml/' . $verb . '.xml')) {
		echo 'すみませんが、「' . $verb . '」という言葉は見つけられませんでした。';
		die;
	}
//parse xml
include 'head.php';
$xml = simplexml_load_file('japanese_xml/' . $verb . '.xml');
echo '<table>';
$color=0;
foreach($xml->children() as $child)
{		
	foreach($child->attributes() as $a => $b)
	{
		if ($color==2) $color=0;
		$color++;
		if ($child!=='') echo '<tr>
<td class="' . $color_option . ($color+2)  .'">' . $b . '</td><td class="' . $color_option . $color.'">' . $child . '</td></tr>';
	}
}
echo '</table>';
?>
</body>
</html>