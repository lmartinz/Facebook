<?php

class Facebook {
	
	private $login = 'example@domain.com';
	private $password = 'password';
	
	public function getUserId($search){
		
		$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://login.facebook.com/login.php?m&amp;next=http%3A%2F%2Fm.facebook.com%2Fhome.php');
			curl_setopt($ch, CURLOPT_POSTFIELDS,'email='.urlencode($this->login).'&pass='.urlencode($this->password).'&login=Login');
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
			curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
			curl_exec($ch);

			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_URL, 'http://www.facebook.com/search/?init=quick&q='.$search);
			$page = curl_exec($ch);

			curl_setopt($ch, CURLOPT_POST, 1);

			$pieces = explode('cururl', $page);

			$res = str_replace("&quot;:&quot;https://www.facebook.com/", '', stripslashes(stripslashes($pieces[1])));
			$res = explode('&quot;', $res);

			return $res[0];
	}
	
	public function getImg($search){
		$user = $this->getUserId($search);
		return "http://graph.facebook.com/$user/picture?type=large";
	}
	
	public function getImgFromId($id){
		return "http://graph.facebook.com/$id/picture?type=large";
	}
	
}