<?phprequire_once '../config.php';mysql_query("SET NAMES 'utf8'");mysql_query("SET CHARACTER SET 'utf8'");//$res_mess = mysql_query("SELECT * FROM `goods` ORDER BY `id` ASC limit 20") ;if(isset($_POST['fon'])) {$fon = $_POST['fon'];} else {$fon = 0;};if(isset($_POST['name'])) { $name = $_POST['name'];mysql_query("create table `$name`(`id` int unsigned not null auto_increment PRIMARY KEY,`link` TEXT NOT NULL,`name` TEXT NOT NULL)");mysql_query("INSERT INTO `name_tabls` (`name`, `fon`) VALUES ('$name', '$fon')");} else {$name = '0';}$nameFon['name'] = $name;$nameFon['fon'] = $fon;print json_encode($name);