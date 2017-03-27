<?php
mysql_connect('localhost','root','') or die("ERROR HOST CONNECTION");
 
mysql_select_db('top_index') or die("ERROR DATBASE CONNECTION");

function resultset($query){
	$ambildata=mysql_query($query);
	if($ambildata){
		if(mysql_num_rows($ambildata)>0)
		{
			while ($ad=mysql_fetch_assoc($ambildata))
			{
				$data[]=$ad;
			}
			
				return $data;
		}
		else
		{
			return "data kosong";	
		} 
	}else{
		return mysql_error();
	}
}



/*function stopword($file){
	$query=mysql_query("SELECT kata FROM stopwords");
	while($hasil=mysql_fetch_array($query)){
		$stopwords[]=$hasil['kata'];
	}
	foreach ($stopwords as &$word) {
	    $word = '/\b' . preg_quote($word, '/') . '\b/';
	}
	return preg_replace($stopwords, '', $file);
}*/
?>