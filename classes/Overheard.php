<?php
require_once('./lib/phpQuery.php');

class Overheard
{
	private static function Parse($html)
	{
		$stories = $html->find('div.shortContent');
		$result = '';
		foreach($stories as $k => $story)
		{
			$story = pq($story)->text();
			$result.=$story;
			$result.= '
===================
';
		    if($k>2) break;
		}
		
		if($result)
		{
			$result = ['result'=>true, 'via'=>'ideer.ru','data'=> $result];
		}else{
			$result = ['result'=>false];
		}
		return json_encode($result);
	}
	
	public static function GetRandom()
	{
		$randompage = rand(1,6500)*15;
		$html = phpQuery::newDocument(file_get_contents('https://ideer.ru/?page='.$randompage));
		
		return self::Parse($html);	
	}
	public static function GetCatList()
	{
		$list = [
			'смешное'=>['смешное'],
			'секс'=>['пошлое','похоть'],
			'жесть'=>['пиздец','чернуха','фуу'],
			'странное'=>['странное','мистика','наблюдения'],
			'бесит'=>['ненависть','бесит','ебанько'],
			'разное'=>['разное','лень','религия','хобби','пьянь','сны','зависть','одиночество'],
			'хорошее'=>['коты','добро','счастье','любовь','бабушки','успех','мечты'],
			'плохое'=>['провал','предательство','жестокость'],
			'стыдно'=>['стыдно'],
			'детство'=>['детство'],
			'семья'=>['семья'],
			'работа'=>['работа'],
			'лайфхаки'=>['лайфхаки'],
			'друзья'=>['друзья'],
			
		];
		return $list;
	}
	public static function GetRandomByTag($tag)
	{
		$main_tags = self::GetCatList();
		$element = array_rand($main_tags[$tag]);
		$list = [
			'разное'=>['raznoe',1300],
			'смешное'=>['funny',2000],
			'пошлое'=>['vulgar',2500],	
			'страшное'=>['creepy',3000],
			'ненависть'=>['angry',500],
			'пиздец'=>['pizdec',1900],
			'странное'=>['strange',3500],
			'похоть'=>['lust',800],	
			'мистика'=>['mysticism',700],
			'чернуха'=>['cherhuha',500],
			'стыдно'=>['shame',1200],
			'религия'=>['religion',300],
			'зависть'=>['envy',300],
			'жестокость'=>['cruelty',900],
			'ебанько'=>['ebanko',1400],
			'лень'=>['laziness',300],
			'одиночество'=>['loneliness',550],
			'коты'=>['cats',1800],
			'бесит'=>['enrage',2200],
			'детство'=>['childhood',5500],
			'мечты'=>['dreams',1500],
			'семья'=>['family',6500],
			'наблюдения'=>['observations',5500],
			'сны'=>['sleeping',300],
			'работа'=>['work',4000],
			'лайфхаки'=>['lifehack',2300],
			'фуу'=>['fuuu',1140],
			'добро'=>['good',1800],
			'счастье'=>['happy',900],
			'друзья'=>['friends',1485],
			'предательство'=>['betrayal',1000],
			'хобби'=>['hobby',300],
			'провал'=>['fail',5500],
			'любовь'=>['love',2200],
			'бабушки'=>['grandma',1200],
			'пьянь'=>['alco',800],
			'успех'=>['luck',2200],
		];
		$cat = $list[$main_tags[$tag][$element]];
		$randompage = rand(1,floor($cat[1])/15)*15;
		$html = phpQuery::newDocument(file_get_contents('https://ideer.ru/secrets/'.$cat[0].'/page/'.$randompage));
		
		return self::Parse($html);
	}
}