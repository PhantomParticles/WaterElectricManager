<?php
	error_reporting(null);
	session_start();
	include("../medoo.php");
	$databases=new medoo();
	if(isset($_SESSION["adminname"]) && $_SESSION["level"]==2){

	}else{
		echo "你没有权限管理此页面";
		exit;
	}




?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>用户详细信息</title>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
	<meta http-equiv="expires" content="Wed, 26 Feb 1997 08:21:57 GMT">
	<link rel="stylesheet" type="text/css" href="css/userinfo.css">
	<script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/userinfo.js"></script>
	<script type="text/javascript">
	<?php
		$uuid=$_GET["id"];
		echo "var Guuid=\"".$uuid."\";";
	?>
		
	</script>
</head>
<body>
	<?php
		echo "<p class=\"title\"><a href=\"user.php?page=".$_GET["page"]."\" class=\"return\">&lt;返回</a>用户详细信息</p>";
	?>
	<!-- 电表弹出框 -->
	<div id="ebox">
		<form action="" id="eform">
			<p>
				<input type="text" name="ename" id="ename" placeholder="电表编号">
			</p>
			<p>
				<input type="text" name="rate" id="rate" placeholder="倍率">
			</p>
			<p>
				<input type="text" name="inite" id="inite" placeholder="电表读数初值">
			</p>
			<p>
				<input type="text" name="notee" id="notee" placeholder="备注">
			</p>
			<p id="efunc">
				
			</p>
		</form>
	</div>
	<!--  -->
	<!--  -->
	<div id="wbox">
		<form action="" id="wform">
			<p>
				<input type="text" name="wname" id="wname" placeholder="水表编号">
			</p>
			<p>
				<input type="text" name="initw" id="initw" placeholder="水表读数初值">
			</p>
			<p>
				<input type="text" name="notew" id="notew" placeholder="备注">
			</p>
			<p id="wfunc">
				
			</p>
		</form>
	</div>
	<!--  -->

	<div id="userinfo">
		<form action="" method="POST" action="ajax_user.php?method=setinfo" id="infoform" onsubmit="return ajax_save()">
			<ul>
				<li>
					<span class="item">区号</span>
					<input type="text" name="area" id="area">
				</li>
				<li>
					<span class="item">工资编号</span>
					<input type="text" name="pay" id="pay">				
				</li>
				<li>
					<span class="notice">若不是工资扣款用户，此项可不填</span>
				</li>
				<li>
					<span class="item">用户姓名</span>
					<input type="text" name="name" id="name">
				</li>
				<li>
					<span class="item">用户地址</span>
					<input type="text" name="address" id="address">
				</li>
				<li>
					<span class="item">用户电话</span>
					<input type="text" name="phone" id="phone">
				</li>
				<li>
					<span class="item">用户类型</span>
					<select name="type" id="type">
						<option value="1">工资扣款</option>
						<option value="2">一卡通扣款</option>
						<option value="3">现金扣款</option>
					</select>
				</li>
				<li>
					<span class="item">电价类型</span>
					<select name="etype" id="etype" onchange="Cetype()">
						<?php
							$datas=$databases->select("eprice",array(
								"name",
								"price"
							));
							for($i=0; $i<count($datas); ++$i){
								echo "<option value=\"".$datas[$i]["price"]."\">".$datas[$i]["name"]."</option>";
							}
						?>
						
					</select>
				</li>
				<li>
					<span class="item">电价</span>
					<input type="text" name="eprice" id="eprice">					
				</li>
				<li>
					<span class="notice">电价以此处的数值为准,不超过两位小数</span>
				</li>
				<li>
					<span class="item">水价类型</span>
					<select name="wtype" id="wtype" onchange="Cwtype()">
						<?php
							$datas=$databases->select("wprice",array(
								"name",
								"price"
							));
							for($i=0; $i<count($datas); ++$i){
								echo "<option value=\"".$datas[$i]["price"]."\">".$datas[$i]["name"]."</option>";
							}
						?>
					</select>
				</li>
				<li>
					<span class="item">水价</span>
					<input type="text" name="wprice" id="wprice">				
				</li>
				<li>
					<span class="notice">水价以此处的数值为准,不超过两位小数</span>
				</li>
				<li class="note">
					<span class="item">备注</span>
					<textarea name="note" id="note"></textarea>
				</li>
			</ul>
			<p style="text-align:center;">
				<input type="submit" value="提交" id="submit">
			</p>
		</form>
	</div>
	<p class="title">用户电表信息 <span class="add" onclick="openeadd()">增加电表</span></p>
	<div id="electric">
		<ul>
			<li class="navi">
				<span class="nvname">表名</span>
				<span class="nvrate">倍率</span>
				<span class="nvnote">备注</span>
			</li>
		<?php
			$datas=$databases->select("electric",array(
				"id",
				"name",
				"rate",
				"note"
				),array(
				"uid"=>$uuid
			));
			for($i=0; $i<count($datas); ++$i){
				echo "<li>";
					echo "<span class=\"nvname\">".$datas[$i]["name"]."</span>";
					echo "<span class=\"nvrate\">".$datas[$i]["rate"]."</span>";
					echo "<span class=\"nvnote\">".$datas[$i]["note"]."</span>";
					echo "<a href=\"".$datas[$i]["id"]."\" class=\"delE\">删除</a>";
					echo "<a href=\"".$datas[$i]["id"]."\" class=\"modifyE\">修改</a>";
				echo "</li>";
			}
		?>
			
			
		</ul>
	</div>
	<p class="title">用户水表信息 <span class="add" onclick="openwadd()">增加水表</span></p>
	<div id="water">
		<ul>
			<li class="navi">
				<span class="nvname">表名</span>
				<span class="nvnote">备注</span>
			</li>
		<?php
			$datas=$databases->select("water",array(
				"id",
				"name",
				"note"
				),array(
				"uid"=>$uuid
			));
			for($i=0; $i<count($datas); ++$i){
				echo "<li>";
					echo "<span class=\"nvname\">".$datas[$i]["name"]."</span>";
					echo "<span class=\"nvnote\">".$datas[$i]["note"]."</span>";
					echo "<a href=\"".$datas[$i]["id"]."\" class=\"delW\">删除</a>";
					echo "<a href=\"".$datas[$i]["id"]."\" class=\"modifyW\">修改</a>";
				echo "</li>";
			}
		?>		
		</ul>
	</div>
</body>
</html>