<?php

class CommonFunctions extends CApplicationComponent {


    
    public static function checkValidAgent($table_agent_id, $controlleragent_id ) {
    
        if($table_agent_id !== $controlleragent_id) {
		//CommonFunctions::DoLogOut();	
            echo 'Caution : you are accessing other service agent details!!!'; exit;
        }
        
    }

	public static function getCurrentpageAgentId($user_role)
	{

	 	$agent_id = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : '';

                if($agent_id == 0) {
					//CommonFunctions::DoLogOut();	
                    echo 'Accessing agent details not exist!!!'; exit;
                }
                
                return $agent_id;
        
	}

	public static function DoLogOut() {

	 switch(Yii::app()->user->name) {
                  
			case 'system_owner' : 
			Yii::app()->user->logout();
			Yii::app()->request->redirect(Yii::app()->baseUrl);
			break;

			case 'state_manager' : 
			Yii::app()->user->logout();
			Yii::app()->request->redirect(Yii::app()->baseUrl.'/state');
			break;

			case 'operation_manager' : 
			Yii::app()->user->logout();
			Yii::app()->request->redirect(Yii::app()->baseUrl.'/operation');
			break;

			case 'agent' : 
			Yii::app()->user->logout();
			Yii::app()->request->redirect(Yii::app()->baseUrl.'/agent');
			break;

			case 'supervisor' : 			
			case 'site_supervisor' : 
			case 'staff' : 			
			Yii::app()->user->logout();
			$agent_id = Yii::app()->user->agent_id;
			break;

		}

	}
	

	public static function siteURL()
	{
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$domainName = CommonFunctions::remove_http(Yii::app()->getBaseUrl(true));
		return $protocol.$domainName;
	}

	

    public static function remove_http($url) {
        $disallowed = array('http://', 'https://');
        foreach ($disallowed as $d) {
            if (strpos($url, $d) === 0) {
                return str_replace($d, '', $url);
            }
        }
        return $url;
    }

  public static function getUserBaseUrl($user_role) {


	$user_base_url = '';
	$home_base_url = CommonFunctions::siteURL();
	      switch($user_role) {
			case 'system_owner' : 
			$user_base_url = $home_base_url;
			break;

			case 'state_manager' : 
			$user_base_url = $home_base_url.'/state';
			break;

			case 'operation_manager' : 
			$user_base_url = $home_base_url.'/operation';
			break;

			case 'agent' : 
			$user_base_url = $home_base_url.'/agent';
			break;

			case 'supervisor' : 			
			case 'site_supervisor' : 
			case 'staff' : 			
			$user_base_url = $home_base_url.'/member';
			break;

		}

	return $user_base_url;

    }


  public static function getUserDashboardUrl($user_role) {

	$user_base_url = '';
	$home_base_url = CommonFunctions::siteURL();
	      switch($user_role) {
			case 'system_owner' : 
			$user_base_url = $home_base_url.'/?r=Dashboard';
			break;

			case 'state_manager' : 
			$user_base_url = $home_base_url.'/state?r=StateDashboard';
			break;

			case 'operation_manager' : 
			$user_base_url = $home_base_url.'/operation?r=OperationDashboard';
			break;

			case 'agent' : 
			$user_base_url = $home_base_url.'/agent?r=AgentDashboard';
			break;

			case 'supervisor' : 			
			case 'site_supervisor' : 
			case 'staff' : 			
			$user_base_url = $home_base_url.'/member?r=MemberDashboard';
			break;

		}

	return $user_base_url;

    }

    public static function IsAnyInductionDues($user_id) {
        $base = Yii::app()->baseUrl;
        $Criteria = new CDbCriteria();
        $Criteria->condition = "user_id = " . $user_id . " && (induction_status='pending' || CURDATE() > expiry_date)";
        $induction_dues = Induction::model()->findAll($Criteria);

        if (count($induction_dues) > 0) {
            header("Location: $base?r=User/default/MyLicencesInductions");
            exit;
        }
    }

    public static function getIntervalDays($start_date, $end_date) {

        $date1 = new DateTime($start_date);
        $date2 = new DateTime($end_date);
        $diff = $date2->diff($date1)->format("%a");
        return $diff;
    }

    public static function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    public static function loadQuoteModel($id) {
        $model = Quotes::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public static function loadJobModel($id) {
        $model = QuoteJobs::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public static function loadJobServiceModel($id) {
        $model = Service::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public static function IsUsingDevice() {

        if (isset($_SERVER['HTTP_USER_AGENT']) && !empty($_SERVER['HTTP_USER_AGENT'])) {
            $iPod = stripos($_SERVER['HTTP_USER_AGENT'], "iPod");
            $iPhone = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
            $Android = stripos($_SERVER['HTTP_USER_AGENT'], "Android");
            $webOS = stripos($_SERVER['HTTP_USER_AGENT'], "webOS");
            $iPad = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");

            if ($iPod || $iPhone || $Android || $webOS || $iPad) {
                return 1;
            } else {
                return 0;
            }
        }
        return 0;
    }


  public static function GetUserDetailsByUserId($id) {
	$model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    public static function GetUserDetailsByEmailAddress($email_address) {
        
        $user_name = '';
        
        $user_model = User::model()->findByAttributes(
                            array(
                                'email' => $email_address
                            )
                    );
        if($user_model !== null) {
            $user_name = ucfirst($user_model->first_name).' '.ucfirst($user_model->last_name);
        }
        
        return $user_name;
        
    }


	/**
	*  Accepts a signature created by signature pad in Json format
	*  Converts it to an image resource
	*  The image resource can then be changed into png, jpg whatever PHP GD supports
	*
	*  To create a nicely anti-aliased graphic the signature is drawn 12 times it's original size then shrunken
	*
	*  @param string|array $json
	*  @param array $options OPTIONAL; the options for image creation
	*    imageSize => array(width, height)
	*    bgColour => array(red, green, blue) | transparent
	*    penWidth => int
	*    penColour => array(red, green, blue)
	*    drawMultiplier => int
	*
	*  @return object
	*/
	public function sigJsonToImage($json, $options = array()) {
	$defaultOptions = array(
	'imageSize' => array(288, 98)
	, 'bgColour' => array(0xff, 0xff, 0xff)
	, 'penWidth' => 2
	, 'penColour' => array(0x14, 0x53, 0x94)
	, 'drawMultiplier' => 12
	);

	$options = array_merge($defaultOptions, $options);

	$img = imagecreatetruecolor($options['imageSize'][0] * $options['drawMultiplier'], $options['imageSize'][1] * $options['drawMultiplier']);

	if ($options['bgColour'] == 'transparent') {
	imagesavealpha($img, true);
	$bg = imagecolorallocatealpha($img, 0, 0, 0, 127);
	} else {
	$bg = imagecolorallocate($img, $options['bgColour'][0], $options['bgColour'][1], $options['bgColour'][2]);
	}

	$pen = imagecolorallocate($img, $options['penColour'][0], $options['penColour'][1], $options['penColour'][2]);
	imagefill($img, 0, 0, $bg);

	if (is_string($json))
	$json = json_decode(stripslashes($json));

	foreach ($json as $v)
	CommonFunctions::drawThickLine($img, $v->lx * $options['drawMultiplier'], $v->ly * $options['drawMultiplier'], $v->mx * $options['drawMultiplier'], $v->my * $options['drawMultiplier'], $pen, $options['penWidth'] * ($options['drawMultiplier'] / 2));

	$imgDest = imagecreatetruecolor($options['imageSize'][0], $options['imageSize'][1]);

	if ($options['bgColour'] == 'transparent') {
	imagealphablending($imgDest, false);
	imagesavealpha($imgDest, true);
	}

	imagecopyresampled($imgDest, $img, 0, 0, 0, 0, $options['imageSize'][0], $options['imageSize'][0], $options['imageSize'][0] * $options['drawMultiplier'], $options['imageSize'][0] * $options['drawMultiplier']);
	imagedestroy($img);

	return $imgDest;
	}

	/**
	*  Draws a thick line
	*  Changing the thickness of a line using imagesetthickness doesn't produce as nice of result
	*
	*  @param object $img
	*  @param int $startX
	*  @param int $startY
	*  @param int $endX
	*  @param int $endY
	*  @param object $colour
	*  @param int $thickness
	*
	*  @return void
	*/
	public function drawThickLine($img, $startX, $startY, $endX, $endY, $colour, $thickness) {
	$angle = (atan2(($startY - $endY), ($endX - $startX)));

	$dist_x = $thickness * (sin($angle));
	$dist_y = $thickness * (cos($angle));

	$p1x = ceil(($startX + $dist_x));
	$p1y = ceil(($startY + $dist_y));
	$p2x = ceil(($endX + $dist_x));
	$p2y = ceil(($endY + $dist_y));
	$p3x = ceil(($endX - $dist_x));
	$p3y = ceil(($endY - $dist_y));
	$p4x = ceil(($startX - $dist_x));
	$p4y = ceil(($startY - $dist_y));

	$array = array(0 => $p1x, $p1y, $p2x, $p2y, $p3x, $p3y, $p4x, $p4y);
	imagefilledpolygon($img, $array, (count($array) / 2), $colour);
	}

	public function isJson($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
	}




    /**
     *  Random string for authentication
     */
    public static function random_string($length) {

        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[CommonFunctions::crypto_rand_secure(0, strlen($codeAlphabet))];
        }
        return $token;
    }

    /**
     *
     * @param <type> $min
     * @param <type> $max
     * @return <type>
     */
    public static function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0)
            return $min; // not so random...
 $log = log($range, 2);
        $bytes = ($log / 8) + 1; // length in bytes
        $bits = $log + 1; // length in bits
        $filter = (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

  public static function createBusinessCode($str) {
       
		$string = preg_replace('/\s+/', '-', strtolower($str)); // convert multiple space into single dash
		$string = str_replace('&','and',$string); // replace '&' by 'and'
		$string = strtr($string, array('.' => '', ',' => ''));
		$string = trim(preg_replace('/-+/', '-', $string), '-'); // multiple dashed into single dash

		return $string;
    }


            public static function getValidJobs($user_model,$user_role) {
                $user_id = $user_model->id;
                $valid_job_ids = array();
                switch ($user_role) {
                    case 'supervisor' : 
                        // check in site supervisor
                       if ($user_model->view_jobs == '0') {
                           $valid_jobs_model = JobSupervisor::model()->findAll(array("condition" => "user_id=" . $user_id));
                           foreach ($valid_jobs_model as $allocated_staff_details) {
                               $valid_job_ids[] = $allocated_staff_details->job_id;
                           }                
                       }
                        break;
                        
                    case 'site_supervisor' :
                             // check in site supervisor
                    $valid_jobs_model = JobSiteSupervisor::model()->findAll(array("condition" => "user_id=" . $user_id));
                    foreach ($valid_jobs_model as $allocated_staff_details) {
                        $valid_job_ids[] = $allocated_staff_details->job_id;
                    }            
                        break;
                        
                    case 'staff':
                    // check in stafff
                  $valid_jobs_model = JobStaff::model()->findAll(array("condition" => "user_id=" . $user_id));
                  foreach ($valid_jobs_model as $allocated_staff_details) {
                      $valid_job_ids[] = $allocated_staff_details->job_id;
                  }

                        break;
                }


		return $valid_job_ids;
            }
            
	public static function getAgentInfo($agent_id){
		$model=Agents::model()->findByPk($agent_id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    
}

?>
