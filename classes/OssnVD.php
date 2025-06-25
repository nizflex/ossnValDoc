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
class OssnVD extends OssnObject {
		/**
		 * Add a new vd in system.
		 *
		 * @return bool;
		 */
		public function addNewVD($params) {
				self::initAttributes();

				//Updating DB table: ossn_object
				$this->title          = $params['user_token'];
				$this->owner_guid = $params['user_guid'];
				$this->type       = 'site';
				$this->subtype    = 'Validation_Document';
				if(empty($_FILES['validation_doc']['tmp_name'])) {
						return false;
				}
				
				//Updating DB table: ossn_entities & ossn_entities_metadata
				if($this->addObject()) {
						if(isset($_FILES['validation_doc'])) {
								$this->OssnFile->owner_guid = $this->getObjectId();
								$this->OssnFile->type       = 'object';
								$this->OssnFile->subtype    = 'Validation_Document';
								$this->OssnFile->setFile('validation_doc');
								$this->OssnFile->setExtension(array(
										'jpg',
										'png',
										'jpeg',
										'jfif',
										'gif',
										'pdf',
								));
								$this->OssnFile->setPath('ossnValDoc/images/');
								if(ossn_file_is_cdn_storage_enabled()) {
										$this->OssnFile->setStore('cdn');
								}
								$this->OssnFile->addFile();
						}
						return true;
				}
				return false;
		}

		/**
		 * Initialize the objects.
		 *
		 * @return void;
		 */
		public function initAttributes() {
				$this->OssnDatabase = new OssnDatabase();
				$this->OssnFile     = new OssnFile();
				$this->data         = new stdClass();
		}

		/**
		 * Get user vds.
		 *
		 * @param array $params option values
		 * @param boolean $random do you wanted to see vds in ramdom order?
		 *
		 * @return array|boolean|integer
		 */
		public function getVds($guid,array $params = array()) {
				$options = array(
						'owner_guid' => $guid,
						'type'       => 'site',
						'subtype'    => 'Validation_Document',
				);
				
				$args = array_merge($options, $params);
				return $this->searchObject($args);
		}
		
		/**
		 * Get vd entity
		 *
		 * @param (int) $guid vd guid
		 *
		 * @return object;
		 */
		public function getVd($guid) {
				$this->object_guid = $guid;
				return $this->getObjectById();
		}
		
		/**
		 * Delete vd
		 *
		 * @param (int) $vd vd guid
		 *
		 * @return bool;
		 */
		public function deleteVd($vd) {
				if($this->deleteObject($vd)) {
						return true;
				}
				return false;
		}
		
		/**
		 * Get vds photo URL
		 *
		 * @return string|bool
		 */
		public function getVDURL() {
				if(isset($this->{'file:Validation_Document'})) {
						$image = md5($this->guid) . '.jpg';
						if(!isset($this->time_updated)){
							$this->time_updated = $this->time_created;	
						}
						
						return ossn_add_cache_to_url(ossn_site_url("pending_validations/photo/{$this->guid}/{$this->time_updated}/{$image}"));
				}
				return false;
		}
		
		/**
		 * Get vds photo file
		 *
		 * @return string|object
		 */
		public function getVDFile() {
				$file   = new OssnFile();
				$search = $file->searchFiles(array(
						'limit'      => 1,
						'owner_guid' => $this->guid,
						'type'       => 'object',
						'subtype'    => 'Validation_Document',
				));
				if($search) {
						return $search[0];
				}
				return false;
		}

} //class
