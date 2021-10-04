<?php 

global $wpdb;
$season = BarhanMediaSeasonsFunctions::get_season($arguments['id']);
if($season->status):
$sponsors = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_sponsors');
?>
<div id="sponsors_list">
	<table>
		<tr>
			<th> </th>
			<th>نام </th>
		</tr>
		<?php foreach($sponsors as &$sponsor): ?>
		<tr>
			<td><img src="<?= $sponsor->page_picture ?>"></td>
			<td><a href="https://instagram.com/<?= $sponsor->page_username ?>"><?= $sponsor->page_full_name ?></a>
		</tr>
		<?php endforeach; ?>
	</table>
</div>
<?php endif; ?>