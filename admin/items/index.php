<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Items</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-success"><span class="fas fa-plus"></span>  ADD</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr class="bg-red disabled" STYLE="">
						
						<th>Item Code</th>
						<th>Item Name</th>
						<th>Price</th>
						<th>Location</th>
						<th>In-Stock</th>
						<th>Unit</th>
						<th>Date Created</th>
						<!--<th>Status</th>-->
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					if(isset($_GET['stock'])){
						$item_stock = $_GET['stock'];
						$qry = $conn->query("SELECT * from `item_list` WHERE stock < '$item_stock' order by (`name`) asc ");
					}elseif(isset($_GET['location'])){
						$location = $_GET['location'];
						$qry = $conn->query("SELECT * from `item_list` WHERE location = '$location' order by (`name`) asc ");
					}else{
						$qry = $conn->query("SELECT * from `item_list` order by (`name`) asc ");
					}
					
					while($row = $qry->fetch_assoc()):
						$row['description'] = html_entity_decode($row['description']);
					?>
						<tr>
							
							<td><?php echo $row['name'] ?></td>
							<td class='truncate-3' title="<?php echo $row['description'] ?>"><?php echo $row['description'] ?></td>
							<td><?php echo $row['price'] ?></td>
							<td><?php

								$loc_id = $row['location'];	
								$supplier_qry = $conn->query("SELECT * FROM `supplier_list` WHERE id = '$loc_id'")->fetch_assoc();
								echo $supplier_qry['name'];

							?></td>
							<td><?php 
                     		$po = $conn->query("SELECT * FROM po_list where `status` =2 ")->num_rows;
                     			if($row['stock'] < 20)
									echo '<span class="alert alert-danger">'.$row['stock'].'</span>';
								else
									echo $row['stock'];
							?></td>
							<td><?php echo $row['unit'] ?></td>

							<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<!--<td class="text-center">
								<?php if($row['status'] == 1): ?>
									<span class="badge badge-success">Active</span>
								<?php else: ?>
									<span class="badge badge-secondary">Inactive</span>
								<?php endif; ?>
							</td>-->
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon py-0" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id = "<?php echo $row['id'] ?>"><span class="fa fa-info text-primary"></span> View</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id = "<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item re_stock" href="javascript:void(0)" data-id = "<?php echo $row['id'] ?>"><span class="fa fa-plus text-success"></span> Re-stock</a>
				                  </div>
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
			_conf("Are you sure to delete this Item permanently?","delete_item",[$(this).attr('data-id')])
		})
		$('#create_new').click(function(){
			uni_modal("<i class='fa fa-plus'></i> Create New Item","items/manage_item.php")
		})
		$('.view_data').click(function(){
			uni_modal("<i class='fa fa-info-circle'></i> Item's Details","items/view_details.php?id="+$(this).attr('data-id'),"")
		})
		$('.edit_data').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Edit Item's Details","items/manage_item.php?id="+$(this).attr('data-id'))
		})
		$('.re_stock').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Restock Item","items/manage_item.php?id="+$(this).attr('data-id')+"&purpose=restock")
		})
		$('.table th,.table td').addClass('px-1 py-0 align-middle')
		$('.table').dataTable();
	})
	function delete_item($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_item",
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