<?php

if ($LOCALHOST) {

	class MysqlConfig2 {
		public static $HOST     = "localhost";
		public static $USER     = "root";
		public static $PASSWORD = "Murzik55723!";
		public static $CATALOG  = "gamepainter";
	}
} else {
	class MysqlConfig2 {
		public static $HOST     = "45.56.86.152";
		public static $USER     = "root";
		public static $PASSWORD = "Murzik55723!";
		public static $CATALOG  = "gamepainter";
	}
}

?>