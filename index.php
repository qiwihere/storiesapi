<?php
require_once('classes/KMP.php');
require_once('classes/Overheard.php');

function GetCats()
{
	$from_kmp = array_keys(KMP::GetCatList());
	$from_oh = array_keys(Overheard::GetCatList());
	$cats = array_unique(array_merge($from_kmp,$from_oh));
	
	return $cats;
}


$type = $_GET['type'];

if($type=='stories')
{
	$action = $_GET['action'];
	
	if($action=='categories')
	{
		$result = ['result'=>true,'categories'=>GetCats()];
		echo(json_encode($result));
	}
	
	if($action=='random')
	{
		$choose = rand(0,1);
		if($choose)
		{
			echo(KMP::GetRandom());
		}else
		{
			echo(Overheard::GetRandom());
		}
	}
	if($action=='by_cat')
	{
		$tag = $_GET['tag'];
		if(!in_array($tag,GetCats()))
		{
			$result = ['result'=>false,'error'=>'Bad category'];
			echo(json_encode($result));
			die();
		}
		$from_kmp = array_keys(KMP::GetCatList());
		$from_oh = array_keys(Overheard::GetCatList());
		
		if(in_array($tag,$from_kmp) and in_array($tag,$from_oh))
		{
			$choose = rand(0,1);
			if($choose)
			{
				echo(KMP::GetRandomByTag($tag));
			}else
			{
				echo(Overheard::GetRandomByTag($tag));
			}
			die();
		}
		if(in_array($tag,$from_kmp))
		{
			echo(KMP::GetRandomByTag($tag));
			die();
		}
		if(in_array($tag,$from_oh))
		{
			echo(Overheard::GetRandomByTag($tag));
			die();
		}
		
	}
}