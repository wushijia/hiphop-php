<?php
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'mysql_pdo_test.inc');
	$db = MySQLPDOTest::factory();

	try {

		$db->exec('DROP TABLE IF EXISTS test');
		$db->exec('CREATE TABLE test(id INT, label CHAR(255)) ENGINE=MyISAM');
		$db->exec('CREATE FULLTEXT INDEX idx1 ON test(label)');

		$stmt = $db->prepare('SELECT id, label FROM test WHERE MATCH label AGAINST (:placeholder)');
		$stmt->execute(array(':placeholder' => 'row'));
		var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));

		$stmt = $db->prepare('SELECT id, label FROM test WHERE MATCH label AGAINST (:placeholder)');
		$stmt->execute(array('placeholder' => 'row'));
		var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));

		$stmt = $db->prepare('SELECT id, label FROM test WHERE MATCH label AGAINST (?)');
		$stmt->execute(array('row'));
		var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));

	} catch (PDOException $e) {

		printf("[001] %s, [%s} %s\n",
			$e->getMessage(), $db->errorCode(), implode(' ', $db->errorInfo()));

	}

	print "done!";
?><?php
require dirname(__FILE__) . '/mysql_pdo_test.inc';
$db = MySQLPDOTest::factory();
$db->exec('DROP TABLE IF EXISTS test');
?>