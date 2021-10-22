<!doctype html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>モデル情報詳細</title>
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
<div class="container-fluid">
	<div class="row">
		<div class="col-md-2">
<h2>管理メニュー</h2>
<ul>
<li><a href="https://hystericend.sakura.ne.jp/takasusukisample2/">モデル登録</a></li>
<li><a href="https://hystericend.sakura.ne.jp/takasusukisample2/modellist.php">モデル一覧→承認</a></li>
</ul>
		</div>
		
		<div class="col-md-10">
<h2>モデル詳細</h2>

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

$stmt = $pdo->query("SELECT * FROM takasusukisample");
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

<table class="table">
	<tr>
		<th>ID</th>
		<th>HN/modelname</th>
		<th>名前</th>
		<th>生年月日</th>
		<th>承認状況</th>
		<th>操作ボタン</th>
	</tr>
<? foreach($arg["data2"] as $data){
?>
	<tr>
		<th><? echo($data["id"]);?></th>
		<th><? echo($data["modelname"]);?></th>
		<th><? echo($data["name"]);?></th>
		<th><? echo($data["birthday"]);?></th>
		<th><?
		switch($data["entry_flag"]){
		case "0":
		$msg ="未承認";
		break;
		case "1":
		$msg ="承認";
		break;
		case "2":
		$msg ="非承認";
		break;
		default:
		$msg ="xxx";
	};
echo($msg);
		
		?></th>
		
		<th>
	<p><a class="btn btn-default" href="https://hystericend.sakura.ne.jp/takasusukisample2/detail.php?id=<? echo($data["id"]);?>" role="button">詳細</a></p>
	<p><a class="btn btn-default" href="https://hystericend.sakura.ne.jp/takasusukisample2/edit.php?id=<? echo($data["id"]);?>" role="button">編集</a></p>
	<p><a class="btn btn-default" href="https://hystericend.sakura.ne.jp/takasusukisample2/delete.php?id=<? echo($data["id"]);?>" role="button">削除</a></p>

		</th>
	</tr>
<?}?>

</table>









	</div>
		
		</div>
</div>


 </main>
<footer>
</footer>
  
</body>
</html>