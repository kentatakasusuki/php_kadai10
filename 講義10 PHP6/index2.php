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

$stmt = $pdo->query("SELECT * FROM shoplist");
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
	
		<div class="col-md-12">
<h2>女の子の登録</h2>
<form action="therapist_regist_check.php" method="POST" class="form-horizontal"  enctype="multipart/form-data">		
	<div class="form-group">
		<label class="col-sm-1 control-label" for="InputEmail">名前</label>
		<div class="col-sm-5">
			<input  type="text" name="cont1" class="form-control" id="InputEmail" >
		</div>
		<label class="col-sm-1 control-label" for="InputEmail">年齢</label>
		<div class="col-sm-1">
			<input  type="number" name="cont3" class="form-control" id="InputEmail" >
		</div>

	</div>

	<div class="form-group">
		<label class="col-sm-1 control-label" for="InputEmail">生年月日</label>
		<div class="col-sm-2">
			<input  type="date" name="cont4" class="form-control" id="InputEmail" >
		</div>
		
		<label class="col-sm-1 control-label" for="InputEmail">血液型</label>
		<div class="col-sm-1">
		<select class="form-control" id="InputSelect" name="cont5">
				<option value="A">A型</option>
				<option value="B">B型</option>
				<option value="O">O型</option>
				<option value="AB">AB型</option>
		</select>	
		</div>
		
	</div>

	<div class="form-group">
		<label class="col-sm-1 control-label" for="InputEmail">身長</label>
		<div class="col-sm-1">
			<input  type="text" name="cont7" class="form-control" id="InputEmail" >
		</div>

		<label class="col-sm-1 control-label" for="InputEmail">B</label>
		<div class="col-sm-1">
			<input  type="text" name="cont10" class="form-control" id="InputEmail" >
		</div>

		<label class="col-sm-1 control-label" for="InputEmail">W</label>
		<div class="col-sm-1">
			<input  type="text" name="cont11" class="form-control" id="InputEmail" >
		</div>
		<label class="col-sm-1 control-label" for="InputEmail">H</label>
		<div class="col-sm-1">
			<input  type="text" name="cont12" class="form-control" id="InputEmail" >
		</div>
	</div>
			
	<div class="form-group">
		<label class="col-sm-1 control-label" for="InputEmail">趣味・特技</label>
		<div class="col-sm-5">
			<input  type="text" name="cont13" class="form-control" id="InputEmail" >
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label" for="InputEmail">お店の名前</label>
		<div class="col-sm-2">
				<select class="form-control" id="InputSelect" name="cont17">
<?
foreach($arg["data2"] as $key){
	?>
				<option value="<?=$key["shoplist_id"]?>"><?=$key["shoplist_name"]?></option>
<?}?>
				</select>	
		</div>
		<label class="col-sm-1 control-label" for="InputEmail">写真のアップロード</label>
		<div class="col-sm-2">
		<input type="file" id="InputFile" name="image">
		</div>
	</div>
		<div class="form-group">
	
	<label class="col-sm-1 control-label" for="InputEmail">自己紹介</label>
		<div class="col-sm-11">
<textarea name="cont14" id="" cols="30" rows="10" class="form-control"></textarea>
		</div>
		</div>
	
	  
	
	
	

<input type="submit">
</form>
</div>
		
		</div>
</div>


 </main>
<footer>
</footer>
  
</body>
</html>