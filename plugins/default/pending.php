<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network (OSSN)
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (C) OpenTeknik LLC
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
 
$search = input('search_users');

$list = get_unvalidated_users_with_documents($search);
$count = get_unvalidated_users_with_documents($search, 'count');

?>
<div>
	<form method="post">
		<input type="text" name="search_users" placeholder="<?php echo ossn_print('search'); ?>" />
		<input type="submit" class="btn btn-primary btn-sm" value="<?php echo ossn_print('search'); ?>"/>
	</form>
</div>

<section class="gallery min-vh-100">
    <div class="container-lg">
		<div class="row gy-4 row-cols-1 row-cols-sm-2 row-cols-md-3">
			<?php
 				
 				if($list) {
					foreach($list as $user) {
						$vds = new OssnVd;
						$vds = $vds->getVds($user->guid);
 						echo '<div class="col">';
						echo '<div class="card" style="width: 18rem;">';
error_log("here - " .$user->guid. " - " . print_r($vds, true));
						if ($vds) {
							foreach ($vds as $vd) {	
							echo '<img class="card-img-top" src="';
error_log("here2 - " .$vd->getVDURL2());
							echo $vd->getVDURL(); 
							}
						}
						echo '" alt="Card image cap">';
						echo '<div class="card-body">';

						echo '<h5 class="card-title">'.$user->fullname.'</h5>';
						echo '<table class="table ossn-users-list">';	
						echo '<tr>';
						echo '<td><a class="badge bg-success text-white" href="';	
						
						echo ossn_site_url("action/admin/validate/user?guid={$user->guid}", true); 
						echo '"><i class="fa-solid fa-user-check"></i>';
						echo ossn_print('validate'); 
						echo '</a></td>';
									
						echo '<td><a class="badge bg-warning text-white" href="';
						echo ossn_site_url("administrator/edituser/{$user->username}");
						echo '"><i class="fa-solid fa-square-pen"></i>';
						echo ossn_print('edit'); 
						echo '</a></td>';

						echo '<td><a class="badge bg-danger text-white" href="';
						echo ossn_site_url("pending_validations/delete/{$user->guid}/{$vds[0]->guid}/user", true); 
						echo '"><i class="fa-solid fa-trash-can"></i>';
						echo ossn_print('delete');
						echo '</a></td></tr></table></div></div></div>';
					}
				}
			?>

		</div>	
	</div>
</section>



<!-- Modal -->
<div class="modal fade" id="gallery-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <img src="img/1.jpg" class="modal-img" alt="modal img">
     
	  <div class="mt-3 d-flex justify-content-center">
		  <button type="button" class="btn btn-success me-2" data-bs-dismiss="modal" onclick='window.location.href="<?php echo ossn_site_url("action/admin/validate/user?guid={$user->guid}", true); ?>"'>Validate</button>
		  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick='window.location.href="<?php echo ossn_site_url("pending_validations/delete/{$user->guid}/{$vds[0]->guid}/user", true); ?>"'>Delete</button>
        </div>
	 </div>
    </div>
  </div>
</div>
		<?php echo ossn_view_pagination($count); ?>
	</div>
</div>
<div class="ossn-unvalidated-multiple-settings d-none">
	<hr />
	<div class="dropdown">
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
		<i class="fa-solid fa-cogs"></i>
		</button>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
			<li><a class="dropdown-item" id="ossn-unvalidated-multi-validate" data-bs-dismiss="modal" href="javascript:void(0);"><?php echo ossn_print('validate'); ?></a></li>
			<li><a class="dropdown-item" id="ossn-unvalidated-multi-delete" data-bs-dismiss="modal" href="javascript:void(0);"><?php echo ossn_print('delete'); ?></a></li>
		</ul>
	</div>
	<div class="margin-top-10"></div>
</div>