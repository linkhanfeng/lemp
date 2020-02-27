<?php
# 执行命令 composer require symfony/var-dumper
require 'vendor/autoload.php';
/**
 * 检测 laravel 扩展是否开启
 */
$extensions = array_map(fn($item) => strtolower($item), get_loaded_extensions());
$laravel6 = ['BCMath','Ctype','JSON','Mbstring','OpenSSL','PDO','Tokenizer','XML'];

$enable_extensions['PHP_VERSION'] = PHP_VERSION;
foreach ($laravel6 as $value) {
    $enable_extensions[$value] = in_array(strtolower($value), $extensions);
}
dump("判断是否满足 laravel6 要求:", $enable_extensions);

/**
 * 连接数据库
 */
$dbInfo = [
    'host' => 'mysql',
    'dbname' => 'default',
    'user' => 'default',
    'password' => 'default'
];

$dsn = "mysql:dbname=" . $dbInfo['dbname'] . ";host=" . $dbInfo['host'];
try {
    $db = new PDO($dsn, $dbInfo['user'], $dbInfo['password']);
    dump( "mysql 连接成功" );
} catch (PDOException $e) {
    dump( 'mysql 连接失败:' . $e->getMessage() );
}

/**
 * redis
 */
$redis = new Redis();
$redis->connect(redis, 6379); //连接Redis
$redis->auth('sOImQf@o^i8C7D2-34s&*2sDfs&'); //密码验证
$redis->set( "testKey" , "redis 链接成功"); //设置测试key
dump($redis->get("testKey"));

phpinfo();
?>