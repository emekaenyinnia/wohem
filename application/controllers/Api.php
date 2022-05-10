<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
/*
* This class handles some of the requests from the android client app
*/
class Api extends BaseController {

	public function __construct()
    {
        parent::__construct();
				$this->check_headers();
    }

		function test_email(){
			$this->sendMail("wohemintl2022@gmail.com","test email","Hello ");
		}

    //discover media
		function discover(){
			  $data = $this->get_data();
				$this->load->model('inbox_model');
				$this->load->model('livestreams_model');
				$this->load->model('radio_model');
				$this->load->model('events_model');
				$this->load->model('settings_model');
				$this->load->model('media_model');
				$arraydata = [];

				//$last_seen_event = isset($data->last_seen_event)?filter_var($data->last_seen_event, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH):0;
				$last_seen_inbox = isset($data->last_seen_inbox)?filter_var($data->last_seen_inbox, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):0;
				$email = isset($data->email)?filter_var($data->email, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"null";

				$livestreams = $this->livestreams_model->getLiveStreams();
				$radios = $this->radio_model->getRadio();
				$facebook_page = $this->settings_model->getFacebookPage();
				$youtube_page = $this->settings_model->getYoutubePage();
				$twitter_page = $this->settings_model->getTwitterPage();
				$instagram_page = $this->settings_model->getInstagramPage();
				$ads_interval = $this->settings_model->getAdvertsInterval();
				$events = $this->events_model->get_total_events(date("Y-m-d"));
				$inbox = $this->inbox_model->get_total_inbox($last_seen_inbox);

				$website_url = $this->settings_model->getWebsiteUrl();
				$image_one = $this->settings_model->getHomePageImage("image_one");
				$image_two = $this->settings_model->getHomePageImage("image_two");
				$image_three = $this->settings_model->getHomePageImage("image_three");
				$image_four = $this->settings_model->getHomePageImage("image_four");
				$image_five = $this->settings_model->getHomePageImage("image_five");
				$image_six = $this->settings_model->getHomePageImage("image_six");
				$image_seven = $this->settings_model->getHomePageImage("image_seven");
				$image_eight = $this->settings_model->getHomePageImage("image_eight");
				$slider_media = $this->media_model->fetchRandom($email);

				// echo json_encode(array("status" => "success"
				// ,"slider_media" => $slider_media
				// ,"livestream" => $livestreams
				// ,"facebook_page" => $facebook_page
				// ,"youtube_page" => $youtube_page
				// ,"twitter_page" => $twitter_page
				// ,"instagram_page" => $instagram_page
				// ,"ads_interval" => $ads_interval
				// ,"inbox" => $inbox
				// ,"website_url" => $website_url
				// ,"image_one" => $image_one
				// ,"image_two" => $image_two
				// ,"image_three" => $image_three
				// ,"image_four" => $image_four
				// ,"image_five" => $image_five
				// ,"image_six" => $image_six
				// ,"image_seven" => $image_seven
				// ,"image_eight" => $image_eight
				// ,"events" => $events
				// ,"radios" => $radios));

				$arraydata = array(
				"slider_media" => $slider_media
				,"livestream" => $livestreams
				,"facebook_page" => $facebook_page
				,"youtube_page" => $youtube_page
				,"twitter_page" => $twitter_page
				,"instagram_page" => $instagram_page
				,"ads_interval" => $ads_interval
				,"inbox" => $inbox
				,"website_url" => $website_url
				,"image_one" => $image_one
				,"image_two" => $image_two
				,"image_three" => $image_three
				,"image_four" => $image_four
				,"image_five" => $image_five
				,"image_six" => $image_six
				,"image_seven" => $image_seven
				,"image_eight" => $image_eight
				,"events" => $events
				,"radios" => $radios);
			
				$this->response("success", $arraydata);
		}

		//categories listing
		function devotionals(){
			$data = $this->get_data();
		  $this->load->model('devotionals_model');
		  $date = isset($data->date)?filter_var($data->date, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):date("Y-m-d");
			$devotional = $this->devotionals_model->getDevotional(date('Y-m-d', strtotime($date)));
			if($devotional){
				$this->response("success", $devotional);
				exit;
			}else{
				$this->response("error", "no devotional found");
				exit;
			}
		}

			function fetch_about()
			{
				$this->load->model('About_model');
				$data = $this->About_model->AboutChurch();
				if($data){
					$this->response("success", $data);
					exit;
				}else{
					$this->response("error", "no devotional found");
					exit;
				}
			}
			
		//fetch radios
		function fetch_radios(){
				$data = $this->get_data();
				$results = [];
				$arraydata = [];
				$isLastPage = false;
				$page = 0;
				if(isset($data->page)){
					$page = $data->page;
				}
				$this->load->model('radio_model');
				$results = $this->radio_model->fetchRadio($page);
				$total_items = $this->radio_model->get_total_radio();
				$isLastPage = (($page + 1) * 20) >= $total_items;
				$arraydata = array("status" => "ok","radios" => $results,"isLastPage" => $isLastPage);
				$this->response("success", $arraydata );
				exit;
				// echo json_encode(array("status" => "ok","radios" => $results,"isLastPage" => $isLastPage));
		}

		//fetch albums
		function fetch_events_date(){
			   $data = $this->get_data();
			   $date = isset($data->date)?filter_var($data->date, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):date("Y-m-d");
				$this->load->model('events_model');
				$results = $this->events_model->fetchEvents(date('Y-m-d', strtotime($date)));
				if(empty($results) || $results == []){
			 	$this->response('error',  'No event found.');
					exit;
				}
			 	$this->response($this->events_model->status,  $results);
				exit;
		}

		function fetch_events_title(){
			$data = $this->get_data();
			$title = isset($data->title)?filter_var($data->title, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):'';
			 $this->load->model('events_model');
			 $results = $this->events_model->fetchvideotitle($title);
			 if(empty($title ) || $results == []){
			 	$this->response('error',  'No event found.');
				 exit;
			 }
			
		 $this->response($this->events_model->status,  $results);
			 exit;
	 }

		//categories listing
		function categories(){
			  $data = $this->get_data();
				$this->load->model('categories_model');
				$categories = $this->categories_model->categoriesListing();
				$this->response("success", $categories);
				// echo json_encode(array("status" => "ok","categories" => $categories));
				exit;
		}

		//fetch audios/videos
		function fetch_media(){
			$arraydata = [];
			$data = $this->get_data();
			$results = [];
			$isLastPage = false;
			if(isset($data->media_type)){
				$email = isset($data->email)?filter_var($data->email, FILTER_SANITIZE_EMAIL, FILTER_FLAG_STRIP_HIGH):"null";
				$type = $data->media_type;
				$page = 0;
				if(isset($data->page)){
		  $page = $data->page;
		}   
			if($results){
				$this->response("error", "no data found");
				exit;
			}

				$this->load->model('media_model');
				$results = $this->media_model->fetch_media($type,$page,$email);
				$total_items = $this->media_model->get_total_media($type);
				$isLastPage = (($page + 1) * 20) >= $total_items;
			}
			
			$arraydata = array("media" => $results,"isLastPage" => $isLastPage);
			$this->response("success", $arraydata);
			exit;
	}

		function fetch_searched_media()
		{
			$data = $this->get_data();
			$results = [];
			$isLastPage = false;
			if(isset($data->media_type)){
				$title = isset($data->title)?filter_var($data->title, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
				$type = $data->media_type;
				$page = 0;
				if(isset($data->page)){
					$page = $data->page;
				  }
			$this->load->model('media_model');
			$results = $this->media_model->fetchvideotitle($title);
			$total_items = $this->media_model->get_total_media($type);
			$isLastPage = (($page + 1) * 20) >= $total_items;
			if(empty($title ) || $results == []){
				$this->response('error',  'No event found.');
				exit;
			}
			$arraydata = array("media" => $results,"isLastPage" => $isLastPage);
			$this->response($this->media_model->status,  $arraydata);
			exit;
		}
		}

		//fetch audios/videos
		function fetch_hymns(){
				$arraydata = [];
				$data = $this->get_data();
				// $results = [];
				$isLastPage = false;
				$query = isset($data->query)?filter_var($data->query, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
				$page = 0;
				if(isset($data->page)){
					$page = $data->page;
				}

				$this->load->model('hymns_model');
				$results = $this->hymns_model->fetch_hymns($page,$query);
				$total_items = $this->hymns_model->get_total_hymns($query);
				$isLastPage = (($page + 1) * 20) >= $total_items;
				if(empty($results)){
					$this->response("error", "no hymn found");
					exit;
				}	

				$arraydata = array("hymns" => $results,"isLastPage" => $isLastPage);
				$this->response("success", $arraydata);
				exit;
		}
	
		//fetch inbox
		function fetch_inbox(){
			$data = $this->get_data();
			$results = [];
			$arraydata = [];
			$isLastPage = false;
			$page = 0;
			if(isset($data->page)){
				$page = $data->page;
			}
			$this->load->model('inbox_model');
			$results = $this->inbox_model->fetchInbox($page);
			$total_items = $this->inbox_model->get_total_inbox();
			$isLastPage = (($page + 1) * 20) >= $total_items;
			$arraydata = array("isLastPage" => $isLastPage,"inbox" => $results);
			$this->response("success", $arraydata);
			exit;
		}

		//fetch categories audios/videos
		function fetch_categories_media(){
				$data = $this->get_data();
				$results = [];
				$arraydata = [];
				$subcategories = [];
				$isLastPage = false;
				if(isset($data->category)){
					$email = isset($data->email)?filter_var($data->email, FILTER_SANITIZE_EMAIL, FILTER_FLAG_STRIP_HIGH):"null";
					$category = $data->category;
					$version = isset($data->version)?$data->version:"v1";
					$page = 0;
					if(isset($data->page)){
	          $page = $data->page;
	        }
					$sub = 0;
					if(isset($data->sub)){
	          $sub = $data->sub;
	        }
					$media_type = "all";
					if(isset($data->media_type)){
	          $media_type = $data->media_type;
	        }
					$this->load->model('media_model');
					$results = $this->media_model->fetch_categories_media($category,$page,$email,$sub,$media_type);
					$total_items = $this->media_model->total_categories_media($category,$sub,$media_type);
					$isLastPage = (($page + 1) * 20) >= $total_items;

					if($page==0){
						$this->load->model('categories_model');
						$subcategories = $this->categories_model->subcategoriesListing($category);
					}
				} 
				$arraydata = array("subcategories" => $subcategories,"isLastPage" => $isLastPage,"media" => $results);
				$this->response("success", $arraydata);
				exit;
		}


		//fetch categories audios/videos
		function getTrendingMedia(){
				$data = $this->get_data();
				$results = [];
				$arraydata = [];
				$isLastPage = false;
				$email = isset($data->email)?filter_var($data->email, FILTER_SANITIZE_EMAIL, FILTER_FLAG_STRIP_HIGH):"null";
				$version = isset($data->version)?$data->version:"v1";
				$page = 0;
				if(isset($data->page)){
					$page = $data->page;
				}

				$this->load->model('media_model');
				$results = $this->media_model->getTrendingMedia($page,$email,"",$version);
				$total_items = $this->media_model->total_trending_media($version);
				$isLastPage = (($page + 1) * 20) >= $total_items;
				$arraydata = array("isLastPage" => $isLastPage,"media" => $results);
				$this->response("success", $arraydata);
				exit;
			
		}

		//process user like or unlike media
				public function update_media_total_views(){
					$data = $this->get_data();
					$this->load->model('media_model');
					if(!empty($data)){
						  $media = isset($data->media)?filter_var($data->media, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";

						  if($media !=""){
								 $this->media_model->update_media_total_views($media);
						  }
					 }
					//  echo json_encode(array("status" => $this->media_model->status));
					 $this->response($this->media_model->status, "");
					 exit;
				}

				//process user like or unlike media
						public function update_ebooks_articles_views(){
							$data = $this->get_data();
							$id = isset($data->id)?filter_var($data->id, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
							$type = isset($data->type)?filter_var($data->type, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
							if($type=="ebooks"){
								 	$this->load->model('ebooks_model');
								 $this->ebooks_model->update_ebooks_total_views($id);
							}else if($type=="articles"){
								 	$this->load->model('articles_model');
								 $this->articles_model->update_articles_total_views($id);
							}
							//  echo json_encode(array("status" => "ok"));
							 $this->response("success", "");
							 exit;
						}

//process user like or unlike media
		public function likeunlikemedia(){
			$data = $this->get_data();
			$this->load->model('media_model');
			if(!empty($data)){
				  $email = isset($data->email)?filter_var($data->email, FILTER_SANITIZE_EMAIL, FILTER_FLAG_STRIP_HIGH):"";
				  $media = isset($data->media)?filter_var($data->media, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
					$action = isset($data->action)?filter_var($data->action, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";

				  if($email!="" && $media !=""){
						 $this->media_model->likeunlikemedia($media,$email,$action);
				  }
			 }
			 $this->response($this->media_model->status, $this->media_model->message);
			 exit;
			//  echo json_encode(array("status" => $this->media_model->status,"message" => $this->media_model->message));
		}

//get total likes and comments for a media
		public function getmediatotallikesandcommentsviews(){
			$data = $this->get_data();
			$this->load->model('media_model');
			$total_likes = 0;
			$total_comments = 0;
			if(!empty($data)){
				  $media = isset($data->media)?filter_var($data->media, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";

				  if($media !=""){
						 $total_comments = $this->media_model->get_total_comments($media);
						 $total_likes = $this->media_model->getMediaTotalLikes($media);
						 $total_views = $this->media_model->getMediaTotalViews($media);
				  }
			 }
			 $arraydata = [];
			 $arraydata = array("total_likes" => $total_likes
			 ,"total_comments" => $total_comments
		   ,"total_views" => $total_views);
			 $this->response("success", $arraydata);
			 exit;
		}

    //search audios/videos
		function search(){
				$data = $this->get_data();
				$result = [];
				if(isset($data->query)){
					$email = isset($data->email)?filter_var($data->email, FILTER_SANITIZE_EMAIL, FILTER_FLAG_STRIP_HIGH):"null";
					$query = $data->query;

					$offset = 0;
					if(isset($data->offset)){
	          $offset = $data->offset;
	        }
					$this->load->model('search_model');
					$result = $this->search_model->searchListing($query,$offset,$email);
				}
				$this->response("success", $result);
				exit;
		}

		//download media
		function download(){
			$this->load->model('download_model');
			if(isset($_GET['m'])){
				$this->download_model->load($_GET['m']);
			}else{
				echo "invalid url";
			}
		}

	//store user fcm token
	function storeFcmToken(){
			$data = $this->get_data();
			$this->load->model('fcm_model');
			if(isset($data->token) && $data->token!=""){
				$token = $data->token;
				$version = isset($data->version)?$data->version:"v1";
				$data = array("token"=>$token,"app_version"=>$version);
			  $this->fcm_model->storeUserFcmToken($data);
			}
			$this->response( $this->fcm_model->status, $this->fcm_model->message);
			exit;
	}

	//store user fcm token
	function updateFcmToken(){
			$data = $this->get_data();
			$this->load->model('fcm_model');
			if(isset($data->token) && $data->token!=""){
				$token = $data->token;
				$version = isset($data->token)?$data->token:"v1";
			  $this->fcm_model->updateUserFcmToken($token,$version);
			}
			$this->response( $this->fcm_model->status, $this->fcm_model->message);
			exit;
	}

	function send_feedback(){
		$data = $this->get_data();
			if(!empty($data)){
				  $name = isset($data->name)?filter_var($data->name, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
					$email = isset($data->email)?filter_var($data->email, FILTER_SANITIZE_EMAIL, FILTER_FLAG_STRIP_HIGH):"";
					$phone = isset($data->phone)?filter_var($data->phone, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
				    $message = isset($data->message)?filter_var($data->message, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";

					//check for empty or invalid fields
					$_name_error = $name==""?"Name is empty!":"";
					$_email_error = $this->validateEmail($email)==TRUE?"":"Email Address Is not valid!";
					$_password_error = $message==""?"Message is empty!":"";
					if($_name_error !="" || $_email_error !="" || $_password_error != ""){
						 $this->response("error",$_name_error."\n".$_email_error."\n".$_password_error);
                         exit;
					}
					$subject = "App Feedback";
						 $htmlContent = '<p>From '.$name.',</p>';
				         $htmlContent = '<p>Email '.$email.',</p>';
				         $phone = '<p>From '.$phone.',</p>';
						 $htmlContent .= '<br><br>';
						 $htmlContent .= '<p>'.$message.'</p>';
						 $this->sendMail($email,$subject,$htmlContent);
			 }
			 $this->response("ok","Thank your feedback, We will attend to it shortly");
	}

	public function get_article_content(){
		$data = $this->get_data();
		if(!empty($data)){
				$id = isset($data->id)?$data->id:0;
				if($data->type == "inbox"){
					$this->load->model('inbox_model');
					$content = $this->inbox_model->getArticleContent($id);
				}else{
					$this->load->model('events_model');
					$content = $this->events_model->getArticleContent($id);
				}
				$this->response('success', $content);
				exit;
		 }else{
			$this->response('error', 'no content');
				exit;
		 }
	}

	public function saveDonation(){
		 $data = $this->get_data();
		 //var_dump($data); die;
		 if(!empty($data)){
			 $reason = isset($data->reason)?filter_var($data->reason, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
			 $method = isset($data->method)?filter_var($data->method, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
			 $email = isset($data->email)?filter_var($data->email, FILTER_SANITIZE_EMAIL, FILTER_FLAG_STRIP_HIGH):"";
			 $name = isset($data->name)?filter_var($data->name, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
			 $amount = isset($data->amount)?filter_var($data->amount, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):0;
			 $reference = isset($data->reference)?filter_var($data->reference,FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";

			 $this->load->model('donations_model');
			 $pay_ref['email'] = $email;
			 $pay_ref['name'] = $name;
			 $pay_ref['reason'] = $reason;
			 $pay_ref['reference'] = $reference;
			 $pay_ref['amount'] = $amount;
			 $pay_ref['method'] = $method;
				$this->donations_model->recordDonation($pay_ref);

			$this->response($this->donations_model->status,  $this->donations_model->message);
			//  echo json_encode(array("status" => $this->donations_model->status,"message" => $this->donations_model->message));
			 exit;
	 }else{
		 $this->response("error", "No data found for this transaction");
		 exit;
		//  echo json_encode(array("status" => "error","message" => "No data found for this transaction"));
	 }

 }
 	// function for Meeting Pastor 
		public function meet_pastor ()
		{
			$data = $this->Booking_data();
			if(!empty($data)){
				$name = isset($data->name)?filter_var($data->name, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
				$time = isset($data->time)?filter_var($data->time,FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
				$meetingDate = isset($data->meetingDate)?filter_var($data->meetingDate, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
					//check for empty or invalid fields
					$_name_error = $name==""?"Name is empty!":"";
					$_time_error = $time==""?"time is Required!":"";
					$_meetingDate_error = $meetingDate==""?"Meeting Date is Required!":"";

					if($_name_error !="" || $_time_error !="" || $_meetingDate_error != "" ){
						$this->response("error",$_name_error."/n".$_time_error."/n".$_meetingDate_error);
						exit;
				   }
				   $this->load->model('Booking');
				   $this->Booking->meetPastorInfo($name, $time, $meetingDate);
				   if(!$this->Booking->status == "status"){
					return $this->response( $this->Booking->message, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE );
					exit;
						   }
						   $this->response($this->Booking->status, $this->Booking->message);
						   exit;
			}
			else { 
			
				$this->response($this->Booking->status, $this->Booking->message);
				exit;
			}
		
		}

		// method for Testimony
		public function testimony ()
		 {	
		  	$booking_type = 'tbl_testimony';
			$data = $this->Booking_data();
			if(!empty($data)){
				$dataArray = $this->Booking_data_validation($data);
				$this->passingdata($dataArray, $booking_type);
				return 	$this->loadResponseMessage();
				exit;
			
			}
			// echo json_encode(array("status" => "500 server error ","message" => "no data has been passed"));
			$this->response("error", "no data has been passed" );
			exit;

		}

		
		// method for Prayer Request 
		public function prayer_request ()
		{	
			$booking_type = 'tbl_prayer_request';
			$data = $this->Booking_data ();

			if(!empty($data)) {
				$dataArray = $this->Booking_data_validation($data);
				$this->passingdata($dataArray, $booking_type);
				 	$this->loadResponseMessage();
					exit;
			}
			echo json_encode(array("status" => "403 ","message" => "no data has been passed"));
		}


		
		public function passingdata ($dataArray, $booking_type) {
				list($name,  $guestormember,  $messagebox,  $audio, $video) = $dataArray;
				$this->load->model('Booking');
				return $this->Booking->Store_Booking( $name,  $guestormember,  $messagebox,  $audio, $video, $booking_type);
		}


		// this function is used for validating the values of the fields that a passed into the json strings and can 
		// only be used for prayer_request and testimony method in this class
		public function Booking_data_validation( $data) 
		{
			$value = [];
				$name = $this->validatefield($data->name);
				$guestormember =  $this->validatefield($data->guestormember);
				$messagebox = $this->validatefield($data->messagebox);
				// $audio = isset($data->audio)?filter_var($data->audio, FILTER_SANITIZE_URL, FILTER_FLAG_STRIP_HIGH):"";
				// $video = isset($data->video)?filter_var($data->video, FILTER_SANITIZE_URL, FILTER_FLAG_STRIP_HIGH):"";
				$audio = isset($data->audio)?$data->audio:"";
				$video = isset($data->video)?$data->video:"";

				$video = $video==""?"null": $video;
				$audio = $audio==""?"null": $audio;
					$_guestormember_error = $guestormember==""?"field is Required!":"";
					$_messagebox_error = $messagebox==""?"Message is Required!":"";
					
					if($_guestormember_error !="" || $_messagebox_error !=""  ){
						$this->response("error",$_messagebox_error."/n".$_guestormember_error);
						exit;
				   }
				   		 array_push($value, $name, $guestormember, $messagebox, $audio, $video);
						   return $value;
				  		
		}

		public function Send_reported_issue ()
		{
			$data = $this->get_data();
			if(empty($data)){
				$this->response("error", "a field might be empty");
				exit;
			}else{
				$name = isset($data->name)?filter_var($data->name,  FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
				$message = isset($data->message)?filter_var($data->message, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
				
				$_name_error = $name==""?"Name is empty!":"";
				$_message_error = $message==""?"Message is empty!":"";
				if($_name_error !="" || $_message_error != ""){
					$this->response("error",$_name_error."\n".$_message_error);
					exit;
			   } else{
			   		$this->load->model('Report_model');
				  	 $this->Report_model->meetPastorInfo($name, $message);
				   	   if(! $this->Report_model->status == "success"){
					$this->response( $this->Report_model->status,  $this->Report_model->message);
					exit;
						   }
						   $this->response( $this->Report_model->status,  $this->Report_model->message);
						   exit;
						}
			}

	}

		public function validateField($field) {
			$data = isset($field)?filter_var($field, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH):"";
			return $data;
		}
		
		// This method is to load the  message comming from the model class (Booking) 
		public function loadResponseMessage()
		{
			if(!$this->Booking->status == "success"){
				
				// $this->response($this->Booking->status, $this->Booking->message);
				return $this->response( $this->Booking->message, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE );
				exit;
			  }
				
				  $this->response($this->Booking->status, $this->Booking->message);
				  exit;
		}

		public function church_account ()
		{
			$this->load->model('Church_Account_model');
			$Church_Account = $this->Church_Account_model->churchaccountsListing();
			if(empty($Church_Account)){
				$this->response($this->Church_Account_model->status, $this->Booking->message);
				exit;
			}
			$this->response($this->Church_Account_model->status, $Church_Account);
			// echo json_encode(array("status" => "ok","Church Account" => $Church_Account));
			exit;
		}

		
		public function church_branches ()
	{	$this->load->model("branches_model");
		$branches = $this->branches_model->branchesListing();
		if(empty($branches)){
			$this->response('error', 'No branch found');
			exit;
		}
		else{
			$this->response('success', $branches );
			exit;
		}
	}

}

