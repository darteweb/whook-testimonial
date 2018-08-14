<?php
/*This file is part of Whook Testimonial.

    Whook Testimonial is free plugin: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Whook Testimonial is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Whook Testimonial.  If not, see <https://www.gnu.org/licenses/>.*/
class whook_test_list
{
function __construct()
{
   include_once(whook_test_path.'/ssp.class.php' );
}

public function whook_test_question_table_show()
{
?>
<h2>Questions</h2>
<div class="col-md-12 msg-data-table nopadding">
<div class="col-md-12 nopadding control-area">
<button name="check_all" class="btn btn-sm btn-primary" id="check_all" ><span class="oi oi-check"></span> Check</button>
<button name="delete" class="btn btn-sm btn-danger ques-delete-btn" ><span class="oi oi-trash"></span> Delete</button>
<label for="question_status">Status</label>
<select name="question_status" id="question_status">
<option value="">-Choose-</option>
<option value="0">Active</option>
<option value="1">Inactive</option>
</select>
<button name="add_new" class="btn btn-sm btn-primary ques-addnew-btn" ><span class="oi oi-plus"></span> Add New</button>
<a href="" class="btn btn-sm btn-success btn-refresh"> <span class="oi oi-reload"></span> Refresh</a>
</div>
<form action="" method="post" class="table-frm"> 
<table id="question-table-list" class="display" cellspacing="0" width="100%">
<thead>
    <tr>
         <th>S. NO.</th>
        <th>Question</th>
        <th>Question-Status</th>
    </tr>
</thead>
</table>
</form>
</div>
<div id="popup-msg" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalPopoversLabel" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="question-edit-frm">
      
    </div>
  </div>
</div>
<div class="preload_area" style="display:none;"><img src="<?php echo whook_test_plugin_url;?>/default.svg"></div>
<?php
}

public function whook_test_table_show()
{
?>
<h2>Testimonials</h2>
<div class="col-md-12 msg-data-table nopadding">
<div class="col-md-12 nopadding control-area">
<button name="check_all" class="btn btn-sm btn-primary" id="check_all" ><span class="oi oi-check"></span> Check</button>
<button name="delete" class="btn btn-sm btn-danger msg-delete-btn" ><span class="oi oi-trash"></span> Delete</button>
<label for="msg_status">Status</label>
<select name="msg_status" id="msg_status">
<option value="">-Choose-</option>
<option value="0">Active</option>
<option value="1">Inactive</option>
</select>
<a href="" class="btn btn-sm btn-success btn-refresh"> <span class="oi oi-reload"></span> Refresh</a>
</div>
<form id="msg-table-frm" class="table-frm">
<table id="msg-table" class="display" cellspacing="0" width="100%">
<thead>
    <tr>
        <th>S. NO.</th>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Message</th>
        <th>Status</th>
        <th>Submit Date</th>
    </tr>
</thead>
</table>
</form>
</div>
<div id="popup-msg" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalPopoversLabel" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" method="post"  id="msg-frm" novalidate="novalidate">
      <div class="modal-body" style="padding: 0px 15px !important;">
      <div class="col-md-12 nopadding" id="msg-edit">  
      
      </div>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="msg-submit-btn"><span class="oi oi-check"></span> Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="preload_area" style="display:none;"><img src="<?php echo whook_test_plugin_url;?>/default.svg"></div>
<?php
}

function get_question_table(){
// DB table to use
global $wpdb;
$table = $wpdb->prefix.'dweb_question';
// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array(
		'db'        => 'id',
		'dt'        => 0,
		'formatter' => function( $d, $row ) {
			return '<input type="checkbox" name="id[]" class="checkbox_id" value="'.$d.'" >   <button type="button" name="edit" style="margin: 0px 10px 0px 25px;" class="btn btn-sm btn-primary question-edit-btn"  data-id="'.$d.'" ><span class="oi oi-eye"></span></button>';
		}),
	array( 'db' => 'question', 'dt' => 1 ),
	/*array( 'db' => 'msg_email',  'dt' => 2 ),
	array( 'db' => 'msg_mobile',   'dt' => 3 ),
	array( 'db' => 'msg_message',     'dt' => 4 ,'formatter' => function( $d, $row ) {
			return substr($d,0,80);;
		} ),*/
		array(
		'db'        => 'question_status',
		'dt'        => 2,
		'formatter' => function( $d, $row ) {
			
			if($d=='0')
			{
			   $status = '<span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>';
			}else
			{
			   $status = '<span class="glyphicon glyphicon-remove text-danger" aria-hidden="true"></span>';
			}
			return $status;
		}
	));

// SQL server connection information
$sql_details = array(
	'user' => DB_USER,
	'pass' => DB_PASSWORD,
	'db'   => DB_NAME,
	'host' => DB_HOST
);
 
	 $custom_search = '';
	 
	 if(isset($_REQUEST['question_status']) && $_REQUEST['question_status']!="")
	 {
	    $custom_search = 'question_status = "'.$_REQUEST['question_status'].'"';
	 }
	
	echo json_encode(
		whook_test_SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$custom_search)
	);
	wp_die();
}

	
public function get_whook_test_table()
{
	// DB table to use
	global $wpdb;
	$table = $wpdb->prefix.'dweb_message';
	// Table's primary key
	$primaryKey = 'id';
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	
	
	$columns = array(
		array(
			'db'        => 'id',
			'dt'        => 0,
			'formatter' => function( $d, $row ) {
				return '<input type="checkbox" name="id[]" class="checkbox_id" value="'.$d.'" >   <button type="button" name="edit" style="margin: 0px 10px 0px 25px;" class="btn btn-sm btn-primary msg-edit-btn"  data-id="'.$d.'" ><span class="oi oi-eye"></span></button>';
			}),
		array( 'db' => 'msg_name', 'dt' => 1 ),
		array( 'db' => 'msg_email',  'dt' => 2 ),
		array( 'db' => 'msg_mobile',   'dt' => 3 ),
		array( 'db' => 'msg_message',     'dt' => 4 ,'formatter' => function( $d, $row ) {
				return substr($d,0,80);;
			} ),
			array(
			'db'        => 'msg_status',
			'dt'        => 5,
			'formatter' => function( $d, $row ) {
				
				if($d=='0')
				{
				   $status = '<span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>';
				}else
				{
				   $status = '<span class="glyphicon glyphicon-remove text-danger" aria-hidden="true"></span>';
				}
				return $status;
			}
		),
		array(
			'db'        => 'msg_submit_date',
			'dt'        => 6,
			'formatter' => function( $d, $row ) {
				return date( 'jS M Y', strtotime($d));
			}
		),
		
	);
	
	// SQL server connection information
	$sql_details = array(
		'user' => DB_USER,
		'pass' => DB_PASSWORD,
		'db'   => DB_NAME,
		'host' => DB_HOST
	);
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP
	 * server-side, there is no need to edit below this line.
	 */
	 
	 $custom_search = '';
	 
	 if(isset($_REQUEST['msg_status']) && $_REQUEST['msg_status']!="")
	 {
	    $custom_search = 'msg_status = "'.$_REQUEST['msg_status'].'"';
	 }
	
	echo json_encode(
		whook_test_SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$custom_search)
	);
	wp_die();
}

}
?>