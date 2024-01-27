<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Purchase Items</h3>
		<div class="card-tools">
			<a href="?page=purchase_orders/manage_po" class="btn btn-flat btn-success"><span class="fas fa-plus"></span>  PURCHASE</a>
		</div>
		<div class="card-tools mr-3">
			<a href="
				<?php
					if(isset($_GET['start_date']) && isset($_GET['end_date'])){
						echo "?page=purchase_orders/view_po&start_date=".$_GET['start_date']."&end_date=".$_GET['end_date'];
					}else{
						echo "?page=purchase_orders/view_po&id=all";
					}
				?>
			" class="btn btn-flat btn-info"><span class="fas fa-print"></span> PRINT</a>
		</div>

	</div>
	<div class="card-body">
		<form action="" method="GET"  class="d-flex mb-3">
			<div class="mr-2">
				<label>Start Date</label>
				<input type="text" name="page" value="purchase_orders" hidden>

				<input type="date" name="start_date" class="form-control" value="<?php
					if(isset($_GET['start_date'])) 
						echo $_GET['start_date'];
					else
						echo "";
				?>">
			</div>
			<div class="mr-2">
				<label>End Date</label>
				<input type="date" name="end_date" class="form-control" value="<?php
					if(isset($_GET['end_date']))
						echo $_GET['end_date'];
					else
						echo "";
				?>">
			</div>
			<div>
				<br>
				<button type="submit" class="btn btn-primary mt-2">Filter</button>
			</div>			
		</form>
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="20%">
					<col width="10%">
					<col width="15%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr class="bg-red disabled">
						<th>#</th>
						<th>Date Created</th>
						<th>PO #</th>
						<th>Location</th>
						<th>Quantity</th>
						<th>Total Amount</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						if(isset($_GET['status'])){
							$status_id = $_GET['status'];
							$qry = $conn->query("SELECT po.*, s.name as sname FROM `po_list` po inner join `supplier_list` s on po.supplier_id = s.id WHERE po.status = '$status_id' order by unix_timestamp(po.date_created) DESC ");
						}elseif(isset($_GET['start_date']) && isset($_GET['end_date'])){
							$start = $_GET['start_date'];
							$end = $_GET['end_date'];
							$qry = $conn->query("SELECT po.*, s.name as sname FROM `po_list` po inner join `supplier_list` s on po.supplier_id = s.id WHERE po.date_created BETWEEN '$start' AND date_add('$end', interval 1 day)  order by unix_timestamp(po.date_created) DESC ");
						}
						else{
							$qry = $conn->query("SELECT po.*, s.name as sname FROM `po_list` po inner join `supplier_list` s on po.supplier_id = s.id order by unix_timestamp(po.date_created) DESC");
						}

						while($row = $qry->fetch_assoc()):
							$row['item_count'] = $conn->query("SELECT * FROM order_items where po_id = '{$row['id']}'")->num_rows;
							$row['total_amount'] = $conn->query("SELECT sum(quantity * unit_price) as total FROM order_items where po_id = '{$row['id']}'")->fetch_array()['total'];
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo date("M d,Y H:i",strtotime($row['date_created'])) ; ?></td>
							<td class="text-center"><?php echo $row['po_no'] ?></td>
							<td class="text-center"><?php echo $row['sname'] ?></td>
							<td class="text-center"><?php echo number_format($row['item_count']) ?></td>
							<td class="text-center"><?php echo number_format($row['total_amount']) ?></td>
							<td align="center">
								<button type="button" class="btn btn-flat btn-default btn-sm">
				                	<a href="?page=purchase_orders/view_po&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-primary"></span> View</a>
				                </button>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this rent permanently?","delete_rent",[$(this).attr('data-id')])
		})
		$('.view_details').click(function(){
			uni_modal("Reservaton Details","purchase_orders/view_details.php?id="+$(this).attr('data-id'),'mid-large')
		})
		$('.renew_data').click(function(){
			_conf("Are you sure to renew this rent data?","renew_rent",[$(this).attr('data-id')]);
		})
		$('.table th,.table td').addClass('px-1 py-0 align-middle')
		$('.table').dataTable();
	})
	function delete_rent($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_rent",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
	function renew_rent($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=renew_rent",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>