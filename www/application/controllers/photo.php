<?php defined('SYSPATH') OR die('No direct access allowed.');

require_once(Kohana::find_file('libraries', 'phpFlickr', TRUE, 'php'));
class Photo_Controller extends Common_Controller {

	public function upload()
	{
		#TODO add a naunce etc for security
		$this->auto_render = FALSE;
		$upload_successful = FALSE;
		$error_messages = array();
		$file_validator = Validation::factory($_FILES);
		$file_validator->add_rules('photo', 'upload::valid', 'upload::required', 'upload::type[gif,jpg,,png]', 'upload::size[8M]');
		$v = $file_validator->validate();
		
		if ($v) {
			$filename = upload::save('photo');
			$copy = array(
				Photo_Model::$before_type => 'Bald for the Cure Before Shot',
				Photo_Model::$after_type => 'Bald for the Cure After Shot',
			);
			
			$title = '';
			$tags = array(Kohana::config('site.flickrtag'));
			$photo_type = $this->input->post('photo_type');
			if (Photo_Model::$before_type == $photo_type ||
				Photo_Model::$after_type == $photo_type) {
				$title = $copy[$photo_type];
				array_push($tags, Photo_Model::$flickrtags[$photo_type]);
			}
			
			
			$new_photo_id = flickr::uploadSync($filename, $title, '', implode(' ', $tags));
			
			if ($new_photo_id) {
				$f = flickr::makeFlickr();
				/* Using getSizes instead of getInfo for now... if we want title, descriptin, etc we'll need this.
				$new_photo_info = $f->photos_getInfo($new_photo_id);
				
				if ($new_photo_info) {*/
					# Enough info to save at this point... but let's try to find the best image size
					# and get actual width and height, otherwise we'll record them as 0 and go with Medium
				$photo = ORM::factory('photo');
				$photo->user_id = $_SESSION['userid'];
				$photo->{'type'} = $photo_type;
				$photo->page = '';
				$photo->url = '';
				/*
				if (array_key_exists('urls', $new_photo_info) &&
					array_key_exists('url', $new_photo_info['urls']) &&
					array_key_exists('_content', $new_photo_info['urls']['url'][0])) {
					$photo->page = $new_photo_info['urls']['url'][0]['_content'];
				} else {
					Kohana::log('alert', "Didn't see a photo page url");
				}*/
					
				$photo->width = 0;
				$photo->height = 0;
					
				$sizes = $f->photos_getSizes($new_photo_id);
				
				$sawMedium = FALSE;
				if ($sizes) {
					foreach($sizes as $size) {
						/**
						 * We record Original in case the photo is smaller than 500 pixels
						 */
						if ('Medium' == $size['label'] ||
							'Original' == $size['label']) {
							$photo->width = $size['width'];
							$photo->height = $size['height'];
							if ('' == $photo->page &&
								array_key_exists('url', $size)) {
								$photo->page = $size['url'];
							}
							if (array_key_exists('source', $size)) {
								$photo->url = $size['source'];
							}
							if ('Medium' == $size['label']) {
								$sawMedium = TRUE;
								break;	
							}
						}
					}
					if (FALSE == $sawMedium) {
						Kohana::log('alert', "We never saw a Medium from sizes " . $photo->width . "x" . $photo->height);
					}
					if ('' != $photo->url) {
						if ($photo->save()) {
							$upload_successful = TRUE;
						} else {
							array_push($error_messages, 'Unknown error after Flickr upload occurred.');
							Kohana::log('alert', "ORM save for photo wasn't successful");
						}
					} else {
						array_push($error_messages, 'Unable to get url from Flickr');
						Kohana::log('error', "Unable to save photo, no url " . Kohana::log($sizes));
					}
				} else {
					Kohana::log('error', "Call to getSizes failed " . Kohana::debug($sizes));
					array_push($error_messages, 'Unable to get photo sizes from Flickr');
				}
					
				/* Again, using getSizes so don't need this. Could be a backup way from
				  getInfo to get an url $photo->url = flickr::url($new_photo_info);	*/
			
			} else { // from if ($new_photo_id) 
				Kohana::log('error', "Flickr Upload Sync FAILED", Kohana::debug($new_photo_id));
				array_push($error_messages, 'Unable to upload photo to Flickr');
			}
			unlink($filename);
			if ($upload_successful == TRUE) {
				url::redirect('/profile/index/' . $_SESSION['username']);
				return;
			} // else fall through
		} else {
			array_push($error_messages, 'Invalid profile photo');
			foreach($file_validator->errors() as $key => $value) {
				array_push($error_messages, $key . "-" . $value);
			}
		}
		$_SESSION['processing_error'] = $error_messages;
		url::redirect('/profile/index/' . $_SESSION['username']);
		return;
	}
}