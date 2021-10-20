<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary " href="./index.php?page=new_ticket"><i class="fa fa-plus"></i> Add New</a>
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
						<th>Date</th>
						<th>Customer</th>
						<th>Adult Ticket</th>
						<th>Child Ticket</th>
						<th>Ticket For</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT t.*,p.name as ticket_for FROM ticket_list t inner join pricing p on p.id = t.pricing_id order by unix_timestamp(t.date_created) desc ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td class=""><b><?php echo date("M d, Y h:i A",strtotime($row['date_created'])) ?></b></td>
						<td class=""><b><?php echo ucwords($row['name']) ?></b></td>
						<td class=""><b><?php echo number_format($row['no_adult']) ?></b></td>
						<td class=""><b><?php echo number_format($row['no_child']) ?></b></td>
						<td><p><small><?php echo $row['ticket_for'] ?></small></p></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="index.php?page=edit_ticket&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat ">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_ticket" data-id="<?php echo $row['id'] ?>">
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
		$('.view_tickets').click(function(){
			uni_modal("tickets's Details","view_ticket.php?id="+$(this).attr('data-id'),"large")
		})
	$('.delete_ticket').click(function(){
	_conf("Are you sure to delete this tickets?","delete_ticket",[$(this).attr('data-id')])
	})
	})
	function delete_ticket($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_ticket',
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