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
<div class="container-fluid">
	<div class="row">
		<div class="col-md-2">
<h2>管理メニュー</h2>
<ul>
<li><a href="https://hystericend.sakura.ne.jp/takasusukisample2/">モデル登録</a></li>
<li><a href="https://hystericend.sakura.ne.jp/takasusukisample2/modellist">モデル一覧→承認</a></li>
</ul>
		</div>
		
<?
	define('PVL_DIR_COMN_PATH','./system/'); //comnフォルダまでのpath(必ず設定して下さい)
	require_once(PVL_DIR_COMN_PATH.'config/app_conf.php');

$id = $_GET["id"];

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
$stmt = $pdo->query("SELECT * FROM takasusukisample where `id` = $id");
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
		
		
		
		
		
		
		<div class="col-md-10">
<h2>モデル編集</h2>
<? foreach($arg["data2"] as $data){
	
$blod_sel[$data["bloodtype"]] ="selected";	
$banktype_sel[$data["banktype"]] ="selected";
	
?>
<form action="editaction.php" method="POST" class="form-horizontal">		
	<div class="form-group">
		<label class="col-sm-1 control-label" for="InputEmail">名前</label>
		<div class="col-sm-5">
			<input  type="text" name="cont1" class="form-control" id="InputEmail" value="<?=$data["name"] ?>">
		</div>
		<label class="col-sm-1 control-label" for="InputEmail">HN/modelname</label>
		<div class="col-sm-5">
			<input  type="text" name="cont2" class="form-control" id="InputEmail" value="<?=$data["modelname"] ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-1 control-label" for="InputEmail">年齢</label>
		<div class="col-sm-1">
			<input  type="number" name="cont3" class="form-control" id="InputEmail" value="<?=$data["age"] ?>">
		</div>
		<label class="col-sm-1 control-label" for="InputEmail">生年月日</label>
		<div class="col-sm-2">
			<input  type="date" name="cont4" class="form-control" id="InputEmail" value="<?=$data["birthday"] ?>">
		</div>
		
		<label class="col-sm-1 control-label" for="InputEmail">血液型</label>
		<div class="col-sm-1">
		<select class="form-control" id="InputSelect" name="cont5">
				<option value="A" <?=$blod_sel["A"] ?>>A型</option>
				<option value="B" <?=$blod_sel["B"] ?>>B型</option>
				<option value="O" <?=$blod_sel["O"] ?>>O型</option>
				<option value="AB" <?=$blod_sel["AB"] ?>>AB型</option>
		</select>	
		</div>
		<label class="col-sm-1 control-label" for="InputEmail">職業</label>
		<div class="col-sm-4">
			<input  type="text" name="cont6" class="form-control" id="InputEmail" value="<?=$data["career"] ?>">
		</div>		
	</div>

	<div class="form-group">
		<label class="col-sm-1 control-label" for="InputEmail">身長</label>
		<div class="col-sm-1">
			<input  type="text" name="cont7" class="form-control" id="InputEmail" value="<?=$data["height"] ?>">
		</div>
	
		<label class="col-sm-1 control-label" for="InputEmail">体重</label>
		<div class="col-sm-1">
			<input  type="text" name="cont9" class="form-control" id="InputEmail" value="<?=$data["weight"] ?>">
		</div>
		<label class="col-sm-1 control-label" for="InputEmail">B</label>
		<div class="col-sm-1">
			<input  type="text" name="cont10" class="form-control" id="InputEmail" value="<?=$data["bust"] ?>">
		</div>

		<label class="col-sm-1 control-label" for="InputEmail">W</label>
		<div class="col-sm-1">
			<input  type="text" name="cont11" class="form-control" id="InputEmail" value="<?=$data["west"] ?>">
		</div>
		<label class="col-sm-1 control-label" for="InputEmail">H</label>
		<div class="col-sm-1">
			<input  type="text" name="cont12" class="form-control" id="InputEmail" value="<?=$data["hip"] ?>">
		</div>
	</div>
			
	<div class="form-group">
		<label class="col-sm-1 control-label" for="InputEmail">趣味・特技</label>
		<div class="col-sm-5">
			<input  type="text" name="cont13" class="form-control" id="InputEmail" value="<?=$data["hobby"] ?>">
		</div>
		<label class="col-sm-1 control-label" for="InputEmail">メールアドレス</label>
		<div class="col-sm-5">
			<input  type="email" name="cont19" class="form-control" id="InputEmail" value="<?=$data["email"] ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label" for="InputEmail">金融機関名</label>
		<div class="col-sm-2">
			<input  type="text" name="cont15" class="form-control" id="InputEmail"  value="<?=$data["bankcompany"] ?>">
		</div>
		<label class="col-sm-1 control-label" for="InputEmail">支店名</label>
		<div class="col-sm-2">
			<input  type="text" name="cont16" class="form-control" id="InputEmail"  value="<?=$data["bankbranch"] ?>">
		</div>
		
		<label class="col-sm-1 control-label" for="InputEmail">預金種別</label>
		<div class="col-sm-2">
				<select class="form-control" id="InputSelect" name="cont17">
				<option value="普通口座" <?=$banktype_sel["普通口座"] ?>>普通口座</option>
				<option value="当座口座" <?=$banktype_sel["当座口座"] ?>>当座口座</option>
				</select>	
		</div>
		<label class="col-sm-1 control-label" for="InputEmail">口座番号</label>
		<div class="col-sm-2">
			<input  type="text" name="cont18" class="form-control" id="InputEmail"  value="<?=$data["banknumber"] ?>">
		</div>		
	</div>
		<div class="form-group">
	
	<label class="col-sm-1 control-label" for="InputEmail">自己紹介</label>
		<div class="col-sm-11">
<textarea name="cont14" id="" cols="30" rows="10" class="form-control"><?=$data["intro"] ?></textarea>
		</div>
		</div>
	
	<input type="hidden" name="id" value="<?=$data["id"] ?>">
	
	
	

<input type="submit">
</form>
<?}?>
</div>
		
		</div>
</div>


 </main>
<footer>
</footer>
  
</body>
</html>