<?php
header('Content-Type:text/html;charset=utf-8');
require_once "../../util/php/DButil.php";
$id = $_GET['id'];
$currentPage = ((int)$_GET['currentPage'] - 1) * 10;
$pageSize = (int)$_GET['pageSize'];
$sql = "SELECT COUNT(*) as totalPages FROM articles as a WHERE a.category_id = {$id}";

$totalPages = query($sql)[0]['totalPages'];

$sql = "SELECT a.id, a.title, a.created,c.name FROM articles a LEFT JOIN categories as c ON a . category_id = c . id WHERE a.category_id = {$id} ORDER BY a.created DESC LIMIT {$currentPage}, {$pageSize}";
// echo $sql;
// 执行sql语句
$data = query($sql);
$res = array("code" => 200, "msg" => "获取新闻数据失败,请联系管理员 666-6666");
if (!empty($data)) {
    $res["code"] = 100;
    $res["msg"] = "获取数据成功";
    $res["data"] = $data;
    $res['totalPages'] = $totalPages;
}

$json = json_encode($res, JSON_UNESCAPED_UNICODE);
echo $json;

?>
