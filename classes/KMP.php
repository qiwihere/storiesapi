<?
require_once('./lib/phpQuery.php');
class KMP
{
	private static function Parse($html)
	{
		$result = '';
		$_stories = $html->find('div.row')
						 ->find('div.col-xs-12:not(:first):not(:last)');
		
		foreach($_stories as $k=>$story)
		{
			if(!($k%3))
			{
				$pqs = pq($story);
				if(trim($pqs->text())=='18+')
				{
					$href = $pqs->find('a')->attr('href');
					$hided_story = phpQuery::newDocument(file_get_contents('https://killpls.me'.$href))->find('div.col-xs-12');
					foreach($hided_story as $i=>$_story)
					{
						
					    $result.=trim(pq($_story)->text());
						break;
					}
					
				}else
				{
					$result.=$pqs->text();
				}
				$result.=
'
===================
';
                if(floor($k/3)>2) break;
			}
		}
		if($result)
		{
			$result = ['result'=>true, 'via'=>'killpls.me','data'=> $result];
		}else{
			$result = ['result'=>false];
		}
		return json_encode($result);
	}
	public static function GetRandom()
	{
		
		$randompage = rand(1,2365);
		$html = phpQuery::newDocument(file_get_contents('https://killpls.me/page/'.$randompage));
		
		return self::Parse($html);	
	}
	public static function GetCatList()
	{
		$list = [
			'учеба'=>['stud',96],
			'техника'=>['tech',37],
			'семья'=>['family',514],
			'секс'=>['sex',232],
			'родители'=>['parents',368],
			'разное'=>['other',551],
			'работа'=>['rabota',223],
			'отношения'=>['relations',735],
			'здоровье'=>['health',313],
			'друзья'=>['friends',187],
			'деньги'=>['money',266],
			'внешность'=>['look',133]
			
		];

		return($list);
	}
	
	
	public static function GetRandomByTag($tag)
	{
		$list = self::GetCatList();
		$cat = $list[$tag];
		$randompage = rand(1,$cat[1]);
		$html = phpQuery::newDocument(file_get_contents('https://killpls.me/bytag/'.$cat[0].'/'.$randompage));
		
		return self::Parse($html);
	}
}
?>