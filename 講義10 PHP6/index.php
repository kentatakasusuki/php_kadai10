<!doctype html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>モデル登録</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
    <title></title>
    <!-- BootstrapのCSS読み込み -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- BootstrapのJS読み込み -->
    <script src="./js/bootstrap.min.js"></script>
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="./css/base.css" rel="stylesheet">
</head>
<body>
<main>

<?
	define('PVL_DIR_COMN_PATH','./system/'); //comnフォルダまでのpath(必ず設定して下さい)
	require_once(PVL_DIR_COMN_PATH.'config/app_conf.php');

try {
    /* リクエストから得たスーパーグローバル変数をチェックするなどの処理 */
$_ = function($s){return $s;};//展開用
    // データベースに接続
    $pdo = new PDO("mysql:host={$_(PVL_DB_HOSTNAME)};dbname={$_(PVL_DB_DBNAME)};charset=utf8",PVL_DB_USER,PVL_DB_PASSWD,
[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
])
;

$stmt = $pdo->query("SELECT * FROM girllist LEFT OUTER JOIN shoplist ON girllist.girllist_shopid = shoplist.shoplist_id");
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {

   $arg["data2"][]=$row;
}


	

} catch (PDOException $e) {

    // エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
    // - もし手抜きしたくない場合は普通にHTMLの表示を継続する
    // - ここではエラー内容を表示しているが， 実際の商用環境ではログファイルに記録して， Webブラウザには出さないほうが望ましい
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
}	

?>  

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 centerxy">
		<p>B専あぶのーまるちぇっく「指さし」-体験版-</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
		<p><img src="./img/logo.png" alt="" class="logo"></p>
		</div> 
		<div class="col-md-6 centerxy">
		<p>ようこそゲストさん</p>
		</div> 
		
	</div>
	<div class="row">
		<div class="col-md-12">
<ul class="navigation">
	<li>ログイン</li>
	<li><a href="index2.php">女の子登録</a></li>
</ul>
		</div>
	</div>
		<div class="row">
	<div class="col-md-5">
<video src="./img/video1.mp4" autoplay loop muted playsinlin class="videocon"></video>
	</div>
	<div class="col-md-7">
		<p><img src="./img/step1.png" alt="" class="videocon"></p>
		<p><img src="./img/step2.png" alt="" class="videocon"></p>
	</div>
		
		</div>
<hr />
		<div class="row">
		<div class="col-md-12 box2">
<? foreach($arg["data2"] as $data){
?>
<div class="box1">
<a href="./result.php?girlid=<?=$data["girllist_id"]?>">
<img src="./girlimg/<?=$data["girllist_filepath"]?>" alt="" class="girlimg">
</a>
</div><!-- /.box1 -->

<?}?>


		</div>
		</div>

	

</div>


 </main>
<footer>
</footer>
  
</body>
</html>