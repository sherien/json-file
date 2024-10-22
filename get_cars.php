<?
header('Access-Control-Allow-Origin: *');
include ('../init.php'); //db connection

	$sql = "SELECT * FROM gs_users WHERE username = 'gdmc-admin'";
    $result = mysqli_query($ms, $sql);
	// Check if we have any users
	$data = [];
if (mysqli_num_rows($result) > 0) {
    // Loop through the users
    while ($user = mysqli_fetch_assoc($result)) {
        $user_id = $user['id'];

        // Query to get user objects for the current user
        $sql_objects = "SELECT * FROM gs_user_objects WHERE user_id = $user_id";
        $result_objects = mysqli_query($ms, $sql_objects);

        // Check if user objects exist
        if (mysqli_num_rows($result_objects) > 0) {
            // Loop through each user object
            while ($user_object = mysqli_fetch_assoc($result_objects)) {
                $imei = $user_object['imei'];
                $sql_imei = "SELECT * FROM gs_objects WHERE imei = '$imei'";
                $result_imei = mysqli_query($ms, $sql_imei);

                // Check if we got a valid result for the imei
                if ($row = mysqli_fetch_assoc($result_imei)) {
        						$data []= [
        						"Reg" => $row['name'],
        						"VehicleId" => $row['imei'],
        						"DriverId" => "000000",
        						"DriverName" => "0",
        						"latituide" =>$row['lat'],
        						"longitude" => $row['lng']
        						 ];   
                }
            }
        }
    }
	header('Content-Type: application/json');
	$json = json_encode($data);

	// Output the JSON
	echo $json;
	
} else {
    echo "No user found with username 'gdmc-admin'";
}
	
	
		

?>
