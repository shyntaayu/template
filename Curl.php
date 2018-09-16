<?php

function access_api($url, $method, $data)

{
    $api = base_url_api('inno').$url;

	$curl = curl_init();
	if($method == "POSTJSON"){
        $headers = array(
            'Content-Type:application/json'
			// "content-type: application/x-www-form-urlencoded"
        );
	}else {
        $headers = array(
            "content-type: multipart/form-data",
            // "content-type: application/x-www-form-urlencoded"
        );
	}
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	if ($method == "POST") {
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	}else if($method == "POSTJSON"){
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($data));
	} elseif ($method == "PUT") {
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        // curl_setopt($curl, CURLOPT_PUT, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	} elseif ($method == "DELETE") {
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	} else {
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
	}

	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);

	if ($err) {
        // return "cURL Error #:" . $err;
		return \Response::view('errors.500', array(), 500);
	} else {
		return json_decode($response);
	}
}
function access_api_json ($data,$url){
    $url = base_url_api('inno').$url;


    $headers = array(
        'Content-Type:application/json'
    );
    //CURL request to route notification to FCM connection server (provided by Google)
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $result_api = curl_exec($ch);
    curl_close($ch);

    if ($result_api === FALSE) {
        return \Response::view('errors.500', array(), 500);
    }else
	{
        return json_decode($result_api);
	}

}

function access_api_itams($url, $method, $data)

{
	$api = base_url_api('lk').'api/parking/'.$url;

	$curl = curl_init();
	$headers = array(
		"content-type: application/json",
		"cache-control: no-cache",
        // "content-type: application/x-www-form-urlencoded"
		);
	curl_setopt($curl, CURLOPT_URL, $api);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_TIMEOUT, 60);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	
	//curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	if ($method == "POST") {
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
	} elseif ($method == "PUT") {
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        // curl_setopt($curl, CURLOPT_PUT, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	} elseif ($method == "DELETE") {
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	} else {
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
	}

	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);

	if ($err) {
        // return "cURL Error #:" . $err;
		return \Response::view('errors.500', array(), 500);
	} else {
		return json_decode($response);
	}
}

function access_api_local($url, $method, $data)

{

	$api = '192.168.0.36/'.$url;

	$curl = curl_init();
	$headers = array(
		"content-type: multipart/form-data",
        // "content-type: application/x-www-form-urlencoded"
		);
	curl_setopt($curl, CURLOPT_URL, $api);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_TIMEOUT, 60);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	if ($method == "POST") {
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	} elseif ($method == "PUT") {
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        // curl_setopt($curl, CURLOPT_PUT, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	} elseif ($method == "DELETE") {
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	} else {
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
	}

	$response = curl_exec($curl);
	curl_close($curl);

	if (!curl_errno($curl)) {
        // return "cURL Error #:" . $err;
		return \Response::view('errors.500', array(), 500);
	} else {
		return json_decode($response);
	}
}


function page_role($code)

{
	$data = new Stdclass();
	if (\Session::has('PR')) {

		if (sizeof(\Session::get('PR'))>1) {
			foreach (\Session::get('PR') as $item) {
				if ($item->code == $code) {
					$data->insert = intval($item->insert);
					$data->edit = intval($item->edit);
					$data->delete = intval($item->delete);
					$data->view = intval($item->view);
					$data->approve = intval($item->approve);
					$data->download = intval($item->download);
					break;
				} else {
					$data->insert = null;
					$data->edit = null;
					$data->delete = null;
					$data->view = null;
					$data->approve = null;
					$data->download = null;
				}
			}
		} else {
			$data->insert = null;
			$data->edit = null;
			$data->delete = null;
			$data->view = null;
			$data->approve = null;
			$data->download = null;
		}

	} else {
		$data->insert = null;
		$data->edit = null;
		$data->delete = null;
		$data->view = null;
		$data->approve = null;
		$data->download = null;
	}

	return $data;
}

function replace_money($money)
{
	$number = str_replace(' ', '', str_replace('Rp', '', str_replace('.', '', str_replace(',', '', $money))));

	return $number;
}

function generate_code($length)
{

	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function get_name_from_list($datalist, $id)
{
	if ($datalist == null) {
		return null;
	} else {
		foreach ($datalist as $data) {
			if(isset($data->id)) {
				if ($data->id == $id) {
					return $data->name;
				}
			}
		}
	}
}

function get_name_zona ($datalist, $id){
	$name ="";
    if ($datalist == null) {
        return null;
    } else {
        foreach ($datalist as $data) {
            if(isset($data->id_zona)) {
                if ($data->id_zona == $id) {
                    $name = $data->name;
                }
            }
        }
    }
    return $name;

}
function base_url_api($type){
	if($type == 'lk'){
		$base_url = "https://itamsdev.vnetcloud.com/ParkingCore/";
	}else {
		// $base_url = 'http://localhost:8888/public/';
		//  $base_url = "https://innoprod.vnetcloud.com/ParkingSystemAPI/public/"

		$base_url = 'https://developers.themoviedb.org/3/movies/';
		

	}
    return $base_url;
}
?>
