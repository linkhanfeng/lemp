<?php
$dsn = 'mysql:dbname=app;host=db';
$user = 'root';
$password = 'D7s&ls4*7pw';

// 连接数据库
try {
    $db = new PDO($dsn, $user, $password);
    myecho( "数据库连接成功<br>" );
} catch (PDOException $e) {
    myecho( '数据库连接失败:' . $e->getMessage() );
}

// 预订义常量
myecho( '预订义常量', $db->getAttribute(PDO::ATTR_DRIVER_NAME) );

// 执行SQL语句

$createTable = $db->exec("
  CREATE TABLE `tb_product` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
    `product_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '商品id',
    `name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
    `price` int(11) NOT NULL DEFAULT '0' COMMENT '商品价格',
    PRIMARY KEY (`id`),
    UNIQUE KEY (`product_id`)
  ) COMMENT='商品信息表';
");

$tables = $db->query("SHOW TABLES;")->fetchAll(PDO::FETCH_GROUP);
var_dump($tables);

/**
 * pdo 执行事物
 * 事物: 同时执行一组语句,全部成功;或全部失败并回滚到原始状态
 * 视图: 组合一组表,提取需要的信息到一张虚拟表中.方便操作.
 * 游标: 方便的取上一条下一条.
 * 索引: 空间换时间
 * 锁: 悲观锁:执行事物的时候,表不可操作; 乐观锁: 表执行事物的瞬间不可操作.
 */

// try {
//   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // 错误处理方式

//   $db->beginTransaction(); // 开启事物
//   $db->exec("insert into staff (id, first, last) values (23, 'Joe', 'Bloggs')");
//   $db->exec("insert into salarychange (id, amount, changedate) values (23, 50000, NOW())");
//   $db->commit(); // 执行语句组成功则完成事物
// } catch (Exception $e) {
//   $db->rollBack(); // 执行语句组失败则回滚事物
//   myecho( "事务执行失败: " . $e->getMessage() );
// }

// 关闭连接
$db = null;

function myecho () {
  $bugInfo = debug_backtrace()[0];
  echo '<p style="padding: 5px 10px; background: #eee; box-shadow: 0px 0px 5px #aae; border-radius: 4px;">'
  . $bugInfo['line']
  . '行: '
  . implode(', ', $bugInfo['args'])
  . '</p>';
}

phpinfo();
?>