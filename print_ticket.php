<?php include 'db_connect.php' ?>
<?php 
 $ride['all'] = "All";
$ride[0] = "None";
$rides = $conn->query("SELECT * FROM rides order by ride asc");
while($row=$rides->fetch_assoc()){
  $ride[$row['id']] = ucwords($row['ride']);
}
$ticket = $conn->query("SELECT t.*,p.name as ticket_for FROM ticket_list t inner join pricing p on p.id = t.pricing_id where t.id =".$_GET['id'])->fetch_array();
foreach($ticket as $k => $v){
	$$k = $v;
}
$tarr= array('','Adult','Child');
$ticket_items = $conn->query("SELECT * FROM ticket_items where ticket_id = $id");

?>
<style>
	.text-center{
		text-align: center
	}
	.text-right{
		text-align: right
	}
</style>

<?php while($row = $ticket_items->fetch_assoc()): ?>
	<table width="100%">
		<tr>
			<th class="text-center" colspan="2">Theme Park</th>
		</tr>
		<tr>
			<th class="text-center" colspan="2"><?php echo ucwords($ticket_for) ?></th>
		</tr>
		<tr>
			<th class="text-center" colspan="2"><?php echo ($tarr[$row['type']]) ?></th>
		</tr>
		<tr>
			<td width="50%">Ticket No.</td>
			<td width="50%" class="text-right"><?php echo $row['ticket_no'] ?></td>
		</tr>
		<tr>
			<td width="50%" style="font-size: 9px">Date :</td>
			<td width="50%" class="text-right" style="font-size: 9px"><?php echo date("M d, Y",strtotime($row['date_created'])) ?></td>
		</tr>
	</table>
	<hr>
<?php endwhile; ?>