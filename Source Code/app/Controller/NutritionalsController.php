<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		08/03/2014
##  Description :		This file contains function for Nutritional
## *****************************************************************

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/members-controller.html
 */
	class NutritionalsController extends AppController {

		public $name 		= 'Nutritionals';
		public $helpers 	= array('Html','Session','Cksource');
		public $uses 		= array('Country','Member','Club','Trainer','CertificationOrganization','Certification','Degree','Package','Nutritional');
	public $components  = array('Upload');		
	
		public function admin_add(){
			
				
			
		
			
			if(!empty($this->data)) {
		
				$this->Nutritional->set($this->data);
				if($this->Nutritional->validates()) {
						
					    if( !empty($this->data["Nutritional"]["guide_file"]) ) {
							$filename = $this->data["Nutritional"]["guide_file"]["name"];
							$target = $this->config["upload_path"];
							$this->Upload->upload($this->data["Nutritional"]["guide_file"], $target, null, null);
  					        $this->request->data["Nutritional"]["guide_file"] = $this->Upload->result; 					
						}else{	
							
							unset($this->request->data["Nutritional"]["guide_file"]);
							$this->request->data["Nutritional"]["guide_file"] = '';							
					    }
					    $this->request->data["Nutritional"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Nutritional"]["modification_date"] 		    = date("Y-m-d h:i:s");
					    	
						if($this->Nutritional->save($this->data)) {				
							$this->Session->setFlash('Nutritional Guide has been created successfully.');
							$this->redirect('/admin/nutritionals/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_view(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("nutritionalInfo",$this->Nutritional->find("first",array("conditions"=>array("Nutritional.id"=>$this->params["pass"][0]))));
				
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_edit($id = null)
		{
			
			
			
			if(!empty($this->data)){
			
			$this->Nutritional->set($this->data);
			$this->Nutritional->id = $this->data['Nutritional']['id'];		
			
							
			if($this->Nutritional->validates()) {
				
			if(!empty($this->request->data["Nutritional"]["guide_file"]["name"]))
				{
					$filename = $this->request->data["Nutritional"]["guide_file"]["name"];
					$target = $this->config["upload_path"];
					$this->Upload->upload($this->data["Nutritional"]["guide_file"], $target, null, null);
  					$this->request->data["Nutritional"]["guide_file"] = $this->Upload->result; 
  					$picPath = $this->config["upload_path"].$this->request->data["Nutritional"]["old_file"];
					@unlink($picPath);
				}else{	
					
					if(!empty($this->request->data["Nutritional"]["old_file"])){
						$this->request->data["Nutritional"]["logo"] = $this->request->data["Nutritional"]["old_file"];			
					}
					else{
						$this->request->data["Nutritional"]["guide_file"] = "";
					}
				}
				$this->request->data["Nutritional"]["modification_date"] 		    = date("Y-m-d h:i:s");
				if($this->Nutritional->save($this->data)) {
					$this->Session->setFlash('Nutritional Guide has been updated successfully.');
					$this->redirect('/admin/nutritionals/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
				$this->request->data["Nutritional"]["guide_file"]=$this->request->data["Nutritional"]["old_file"];				
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Nutritional->id = $id;
						$this->request->data = $this->Nutritional->read();
					} else {
						$this->Session->setFlash('Invalid Nutritional id.');
						$this->redirect('/admin/nutritionals/');
				}
			}	
		}
		
		public function admin_index($status = null)
		{			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by Guide Name...") ) {					
					$conditions["OR"] = array(
												"Nutritional.guide_name LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['Nutritional']['statusTop']) ) {
							$action = $this->data['Nutritional']['statusTop'];
						}elseif( !empty($this->data['Nutritional']['status'])) {
							$action = $this->data['Nutritional']['status'];
						}
						
						if(isset($this->data['Nutritional']['id']) && count($this->data['Nutritional']['id']) > 0) {
							$this->update_status(trim($action), $this->data['Nutritional']['id'], count($this->data['Nutritional']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by Guide Name...') && $this->data["submit"]=='Search'){
								$this->Session->setFlash('Please enter keyword to perform search.');
							}
							else{
								$this->Session->setFlash('Please select any checkbox to perform any action.');
							}
						}
				}
			}
			
			if( !empty($this->params["named"]["keyword"]) ) {
				$conditions["OR"] = array(
									"Nutritional.guide_name LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('Nutritional.guide_name' => 'ASC'));
			$nutritionals = $this->paginate('Nutritional'); //default take the current
			$this->set('nutritionals', $nutritionals);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['Nutritional']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['Nutritional']['options']['page']);
		}
		
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Nutritional->id = $ids[$ctr];
						$this->Nutritional->saveField("status", '1');
					}
					$this->Session->setFlash('Nutritional(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Nutritional->id = $ids[$ctr];
						$this->Nutritional->saveField("status", '0');
					}
					$this->Session->setFlash('Nutritional(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->Nutritional->create();
						$this->Nutritional->id = $ids[$i];
						
						$this->Nutritional->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Nutritional(s) has been deleted successfully.');
					break;
			}
		}
		
				
		function removePicNguide() {
				
			$this->layout = '';
			$this->render = false;
		
			if($this->data) {
				
				$userPic = $this->Nutritional->find("first",array("fields"=>array("guide_file"),"conditions"=>array("Nutritional.id"=>$this->data["id"])));
				$picPath = $this->config["upload_path"].$userPic["Nutritional"]["guide_file"];
				unlink($picPath);
				
				$data["guide_file"] = null;
				if( $this->Nutritional->updateAll($data,array("Nutritional.id"=>$this->data["id"])) ) {
					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully updated");
				}else{
					$response = array("responseclassName"=>"nFailure","errorMsg"=>"unable to process the request");
				}
				echo json_encode($response);
				exit;	
			}
		
		}
		
		
		
	}