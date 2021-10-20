<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary " href="./index.php?page=new_pricing"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<!-- <colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
				</colgroup> -->
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Ticket For</th>
						<th>Ride</th>
						<th>Adult Price</th>
						<th>Childe Price</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$ride['all'] = "All";
					$ride[0] = "None";
					$rides = $conn->query("SELECT * FROM rides order by ride asc");
					while($row=$rides->fetch_assoc()){
						$ride[$row['id']] = ucwords($row['ride']);
					}
					$qry = $conn->query("SELECT * FROM pricing order by name asc ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td class=""><b><?php echo ucwords($row['name']) ?></b></td>
						<td><p><small><?php echo $ride[$row['ride_id']] ?></small></p></td>
						<td><p class="text-right"><?php echo number_format($row['adult_price']) ?></p></td>
						<td><p class="text-right"><?php echo number_format($row['child_price']) ?></p></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="index.php?page=edit_pricing&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat ">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_pricing" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
	                      </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table td{
		vertical-align: middle !important;
	}
</style>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
		$('.view_pricings').click(function(){
			uni_modal("pricings's Details","view_pricings.php?id="+$(this).attr('data-id'),"large")
		})
	$('.delete_pricing').click(function(){
	_conf("Are you sure to delete this pricings?","delete_pricing",[$(this).attr('data-id')])
	})
	})
	function delete_pricing($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_pricing',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>