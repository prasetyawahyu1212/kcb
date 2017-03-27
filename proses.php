<?php 
include_once 'koneksi.php';
$name = $_FILES['file']['name'];
$path = $_FILES['file']['tmp_name'];
if($name!=null){
	$file=file_get_contents($path);
	insert_file($name,$file,strtolower($file),word_removal(strtolower($file)),stamming(word_removal(strtolower($file))));
	insert_freq(file_id_terakhir(),stamming(word_removal(strtolower($file))));
	echo "<script>window.location='view.php?id_file=".file_id_terakhir()."'</script>";
}

//============================================ Algoritma Porter ============================================
function file_id_terakhir(){
	$query=mysql_query("SELECT id_file FROM file ORDER BY id_file DESC LIMIT 1");
	$last_id=mysql_fetch_array($query);
	return $last_id['id_file'];
}
//============================================ Algoritma Porter ============================================
function insert_data_freq($id_file,$kata,$jumlah){
	if(mysql_query("INSERT INTO frekuensi (id_file, kata, jumlah) VALUES ('$id_file', '$kata', '$jumlah')")){
		echo "sukses";
	}else{
		echo mysql_error();
	}
}

function insert_freq($id_file,$isi_file){
	$kata=explode(" ", $isi_file);
	$a="";

	for($i=0;$i<count($kata);$i++){
		if(strrpos($a, $kata[$i])||$kata[$i]==""){
			
		}else{
			$jumlah=1;
			for($b=$i+1;$b<count($kata);$b++){
				if($kata[$b]===$kata[$i]){
					$jumlah++;
				}	
			}
			mysql_query("INSERT INTO frekuensi (id_file, kata, jumlah) VALUES ('$id_file', '$kata[$i]', '$jumlah')");
			//insert_data_freq("11",$kata[$i],$jumlah);
			$a=$a.$kata[$i];
		}	
	}
}

//============================================ Stop Word ============================================
function word_removal($file){
	$query=mysql_query("SELECT kata FROM stopwords");
	while($hasil=mysql_fetch_array($query)){
		$stopwords[]=$hasil['kata'];
	}
	foreach ($stopwords as &$word) {
	    $word = '/\b' . preg_quote($word, '/') . '\b/';
	}
	return preg_replace($stopwords, '', $file);
}


//============================================  Insert File ============================================
function insert_file($nama,$token,$case_folding,$stopword,$stamming){
	if($insert_field=mysql_query("INSERT INTO file (nama_file, token, case_folding, stopword, stamming)
								 VALUES ('$nama', '$token', '$case_folding', '$stopword', '$stamming')")){
	}else{
		echo mysql_error();
	}

}


//============================================ Algoritma Porter ============================================
function stamming($kalimat){
	$kata=explode(" ", $kalimat);
	$hasil="";

	for($i=0;$i<count($kata);$i++){
		$kata_dasar[$i]=hapusakhiran(hapusawalan2(hapusawalan1(hapuspp(hapuspartikel($kata[$i])))));
		$hasil=$hasil.$kata_dasar[$i]." ";
	}
	return $hasil;
}


function cari($kata){
	$hasil = mysql_num_rows(mysql_query("SELECT * FROM tb_katadasar WHERE katadasar='$kata'"));
	return $hasil;
}

//langkah 1 - hapus partikel
function hapuspartikel($kata){
if(cari($kata)!=1){
	if((substr($kata, -3) == 'kah' )||( substr($kata, -3) == 'lah' )||( substr($kata, -3) == 'pun' )){
		$kata = substr($kata, 0, -3);			
		}
	}
	return $kata;
}

//langkah 2 - hapus possesive pronoun
function hapuspp($kata){
if(cari($kata)!=1){
	if(strlen($kata) > 4){
	if((substr($kata, -2)== 'ku')||(substr($kata, -2)== 'mu')){
		$kata = substr($kata, 0, -2);
	}else if((substr($kata, -3)== 'nya')){
		$kata = substr($kata,0, -3);
	}
  }
}
	return $kata;
}

//langkah 3 hapus first order prefiks (awalan pertama)
function hapusawalan1($kata){
if(cari($kata)!=1){

	if(substr($kata,0,4)=="meng"){
		if(substr($kata,4,1)=="e"||substr($kata,4,1)=="u"){
		$kata = "k".substr($kata,4);
		}else{
		$kata = substr($kata,4);
		}
	}else if(substr($kata,0,4)=="meny"){
		$kata = "s".substr($kata,4);
	}else if(substr($kata,0,3)=="men"){
		$kata = substr($kata,3);
	}else if(substr($kata,0,3)=="mem"){
		if(substr($kata,3,1)=="a" || substr($kata,3,1)=="i" || substr($kata,3,1)=="e" || substr($kata,3,1)=="u" || substr($kata,3,1)=="o"){
			$kata = "p".substr($kata,3);
		}else{
			$kata = substr($kata,3);
		}
	}else if(substr($kata,0,2)=="me"){
		$kata = substr($kata,2);
	}else if(substr($kata,0,4)=="peng"){
		if(substr($kata,4,1)=="e" || substr($kata,4,1)=="a"){
		$kata = "k".substr($kata,4);
		}else{
		$kata = substr($kata,4);
		}
	}else if(substr($kata,0,4)=="peny"){
		$kata = "s".substr($kata,4);
	}else if(substr($kata,0,3)=="pen"){
		if(substr($kata,3,1)=="a" || substr($kata,3,1)=="i" || substr($kata,3,1)=="e" || substr($kata,3,1)=="u" || substr($kata,3,1)=="o"){
			$kata = "t".substr($kata,3);
		}else{
			$kata = substr($kata,3);
		}
	}else if(substr($kata,0,3)=="pem"){
		if(substr($kata,3,1)=="a" || substr($kata,3,1)=="i" || substr($kata,3,1)=="e" || substr($kata,3,1)=="u" || substr($kata,3,1)=="o"){
			$kata = "p".substr($kata,3);
		}else{
			$kata = substr($kata,3);
		}
	}else if(substr($kata,0,2)=="di"){
		$kata = substr($kata,2);
	}else if(substr($kata,0,3)=="ter"){
		$kata = substr($kata,3);
	}else if(substr($kata,0,2)=="ke"){
		$kata = substr($kata,2);
	}
}
	return $kata;
}
//langkah 4 hapus second order prefiks (awalan kedua)
function hapusawalan2($kata){
if(cari($kata)!=1){
  
	if(substr($kata,0,3)=="ber"){
		$kata = substr($kata,3);
	}else if(substr($kata,0,3)=="bel"){
		$kata = substr($kata,3);
	}else if(substr($kata,0,2)=="be"){
		$kata = substr($kata,2);
	}else if(substr($kata,0,3)=="per" && strlen($kata) > 5){
		$kata = substr($kata,3);
	}else if(substr($kata,0,2)=="pe"  && strlen($kata) > 5){
		$kata = substr($kata,2);
	}else if(substr($kata,0,3)=="pel"  && strlen($kata) > 5){
		$kata = substr($kata,3);
	}else if(substr($kata,0,2)=="se"  && strlen($kata) > 5){
		$kata = substr($kata,2);
	}
}
	return $kata;
}
////langkah 5 hapus suffiks
function hapusakhiran($kata){
if(cari($kata)!=1){

	if (substr($kata, -3)== "kan" ){
		$kata = substr($kata, 0, -3);
	}
	else if(substr($kata, -1)== "i" ){
	    $kata = substr($kata, 0, -1);
	}else if(substr($kata, -2)== "an"){
		$kata = substr($kata, 0, -2);
	}
}	

	return $kata;
}


 ?>