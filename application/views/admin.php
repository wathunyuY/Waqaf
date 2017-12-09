<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Waqaf | Admin</title>
	<link rel="stylesheet" type="text/css" href="<?PHP echo base_url('asset/bootstrap/css/bootstrap.css')?>">
	<link rel="stylesheet" type="text/css" href="<?PHP echo base_url('asset/bootstrap/css/bootstrap.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?PHP echo base_url('asset/plugin/datatables/jquery.dataTables.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?PHP echo base_url('asset/fancybox/jquery.fancybox.css')?>">
	
</head>
<body>
<!-- /////////////////////////////////////////// แก้ไข หน้าตา เว็บ /////////////////////////////////////////////////////////// -->

	<div class="container bg-success">
		<div class="col-md-6 col-md-offset-3 bg-warning text-center">
			<h1><?PHP echo $topic[0]['detail']; ?></h1>
			<small><a href="#topic_input" class="various"">แก้ไขชื่อโครงการ</a></small>
		</div>
		<div class="col-md-6 col-md-offset-3 bg-danger">
			<form method="POST" action="admin/merge">
				<input type="hidden" name="cash_id" id="cash_id" value="x">
				<div class="form-group">
				    <label for="cash">จำนวนเงิน :</label>
				    <input type="text" class="form-control" name="cash_amount" id="cash_amount" style="text-align: center"> 
				</div>
				<div class=" form-group text-right">
					<button id="btn_ok" type="submit" class="btn btn-success ">ตกลง</button>
					<button id="btn_cancel" class="btn btn-danger" onclick="cancel();">ยกเลิก</button>
				</div>
				<div class="text-right">
					<small><a href="#goal_input" class="various" id="btn_goal ">เป้าหมาย</a></small>
				</div>
				<div class="text-center">
					ยอดเงินรวมล่าสุด  : <label id="sum"><?PHP echo $sum;?></label> 
				</div>
			</form>
			<hr>
		</div>
		<div class="col-md-6 col-md-offset-3 bg-danger text-center"><br>
			<table id="dataTables">
				<thead>
					<tr>
						<td>ลำดับ</td>
						<td>จำนวนเงิน</td>
						<td>เวลา</td>
						<td>*</td>
					</tr>
				</thead>
				<tbody>
				 <?php foreach ($res as $i  =>$x) { ?>
					<tr>
						<td><?PHP echo $i+1; ?></td>
						<td><?PHP echo $x['CASH_AMOUNT']; ?></td>
						<td><?PHP echo $x['LAST_UPDATE']; ?></td>
						<td>
							<button class="btn btn-sm btn-warning" onclick="getItem(<?PHP echo $x['CASH_ID'];?>);"> แก้ไข</button> 
							<button class="btn btn-sm btn-danger" onclick="delItem(<?PHP echo $x['CASH_ID'];?>);"> ลบ</button>
						</td>
					</tr>
				 <?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div hidden id="goal_input">
		<form method="post" action="admin/updateGoal">
			<div class="col-xs-6"><label for="goal_cash">จำนวนเงิน(เป้าหมาย) :</label></div>
			<div class="input-group col-xs-6">
			    <input type="text" class="form-control" name="goal_cash" id="goal_cash" value="<?PHP echo $goal; ?>" style="text-align: right">
			    <div class="input-group-addon">.บาท</div>
			</div><br>
			<button type="submit" class="btn btn-success btn-block">แก้ไข</button>
		</form>
	</div>
	<div hidden id="topic_input">
		<form method="post" action="admin/updateTopic">
			<div class="col-xs-6"><label for="detail"><?PHP echo $topic[0]['topic']; ?> :</label></div>
			<div class="form-group col-xs-6">
			    <input type="text" class="form-control" name="detail1" id="detail1" value="<?PHP echo $topic[0]['detail']; ?>" style="text-align: right">
			</div><br>
			<div class="col-xs-6"><label for="detail"><?PHP echo $topic[1]['topic']; ?> :</label></div>
			<div class="form-group col-xs-6">
			    <input type="text" class="form-control" name="detail2" id="detail2" value="<?PHP echo $topic[1]['detail']; ?>" style="text-align: right">
			</div><br>
			<div class="col-xs-6"><label for="detail"><?PHP echo $topic[2]['topic']; ?> :</label></div>
			<div class="form-group col-xs-6">
			    <input type="text" class="form-control" name="detail3" id="detail3" value="<?PHP echo $topic[2]['detail']; ?>" style="text-align: right">
			</div><br>
			<button type="submit" class="btn btn-success btn-block">แก้ไข</button>
		</form>
	</div>
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     -->

<script src="<?PHP echo base_url('asset/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>
<script src="<?PHP echo base_url('asset/jQuery/js/jquery-1.9.0.min.js')?>" type="text/javascript"></script>
<script src="<?PHP echo base_url('asset/plugin/datatables/dataTables.bootstrap.min.js')?>" type="text/javascript"></script>
<script src="<?PHP echo base_url('asset/plugin/datatables/jquery.dataTables.min.js')?>" type="text/javascript"></script>
<script src="<?PHP echo base_url('asset/fancybox/jquery.fancybox.pack.js')?>" type="text/javascript"></script>
<script src="<?PHP echo base_url('asset/fancybox/jquery.fancybox-media.js')?>" type="text/javascript"></script>
<script type="text/javascript">
	$('#cash_amount').focus();
	$('#dataTables').DataTable();
	$('#sum').html(numberWithCommas($('#sum').html()));
	$(".various").fancybox({
		maxWidth	: 700,
		maxHeight	: 200,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
	function getItem(id) {
		$.post("<?PHP echo base_url('index.php/admin/getCashById')?>",{id:id},function(data){
			console.log(data);
			$('#cash_id').val(data.CASH_ID);
			$('#cash_amount').val(data.CASH_AMOUNT);
			$('#btn_ok').html("แก้ไข");
			$('#btn_cancel').html("ยกเลิกการแก้ไข");
		});
	}
	function delItem(id) {
		if(confirm("ต้องการลบ!"))
			$.post("<?PHP echo base_url('index.php/admin/deleteWaqaf')?>",{id:id},function(data){
				location.reload();
			});
	}
	function cancel(){
		location.reload();
	}
	function numberWithCommas(x) {
    	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
</script>
</body>
</html>