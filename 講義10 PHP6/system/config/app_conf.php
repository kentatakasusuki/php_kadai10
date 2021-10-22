<?php
	if(preg_match('#app_conf.php#', $_SERVER["PHP_SELF"]))
	{
		exit();
	}


	//== Data base define ============================
	// ホスト名
	define("PVL_DB_HOSTNAME", "mysql734.db.sakura.ne.jp");

	// ポート番号
//	define("PVL_DB_PORT", "3306");

	// データベース名
	define("PVL_DB_DBNAME", "hystericend_takasusukisample");

	// ユーザー名
	define("PVL_DB_USER", "hystericend");

	// パスワード
	define("PVL_DB_PASSWD", "mikageslight6");

	// 接続用文字列
	define("PVL_CONNECT_DB","localhost,root,");

    //テンプレート
	define("ERROR_TEMP", "");
	define("MASTER_TEMP", "");


?>
