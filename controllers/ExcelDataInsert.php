<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ExcelDataInsert extends CI_Controller
{

public function __construct() {
        parent::__construct();
                $this->load->library('excel');//load PHPExcel library 
		// $this->load->model('upload_model');//To Upload file in a directory
                $this->load->model('excel_data_insert_model');
}	
	
public	function ExcelDataAdd()	{  
//Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)	 
         $configUpload['upload_path'] = FCPATH.'uploads/excel/';
         $configUpload['allowed_types'] = 'xls|xlsx|csv';
         $configUpload['max_size'] = '5000';
         $this->load->library('upload', $configUpload);
         $this->upload->do_upload('userfile');	
         $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
         $file_name = $upload_data['file_name']; //uploded file name
		    $extension=$upload_data['file_ext'];    // uploded file extension
		
//$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
 $objReader= PHPExcel_IOFactory::createReader('Excel2007');	// For excel 2007 	  
          //Set to read only
          $objReader->setReadDataOnly(true); 		  
        //Load excel file
		 $objPHPExcel=$objReader->load(FCPATH.'uploads/excel/'.$file_name);		 
         $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel      	 
         $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);                
          //loop from first data untill last data
          for($i=2;$i<=$totalrows;$i++)
          {
              $AccountNo =  $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();			
              $CardNo =  $objWorksheet->getCellByColumnAndRow(1,$i)->getValue(); //Excel Column 1
      			  $Name =  $objWorksheet->getCellByColumnAndRow(2,$i)->getValue(); //Excel Column 2
      			  $NameOnCard = $objWorksheet->getCellByColumnAndRow(3,$i)->getValue(); //Excel Column 3
      			  $Address1 = $objWorksheet->getCellByColumnAndRow(4,$i)->getValue(); //Excel Column 4
              $Address2 =  $objWorksheet->getCellByColumnAndRow(5,$i)->getValue();     
              $Address3 =  $objWorksheet->getCellByColumnAndRow(6,$i)->getValue(); //Excel Column 1
              $Address4 =  $objWorksheet->getCellByColumnAndRow(7,$i)->getValue(); //Excel Column 2
              $City = $objWorksheet->getCellByColumnAndRow(8,$i)->getValue(); //Excel Column 3
              $State = $objWorksheet->getCellByColumnAndRow(9,$i)->getValue(); //Excel Column 4
              $Postcode =  $objWorksheet->getCellByColumnAndRow(10,$i)->getValue();     
              $Email =  $objWorksheet->getCellByColumnAndRow(11,$i)->getValue(); //Excel Column 1
              $Phonehome =  $objWorksheet->getCellByColumnAndRow(12,$i)->getValue(); //Excel Column 2
              $Phoneoffice = $objWorksheet->getCellByColumnAndRow(13,$i)->getValue(); //Excel Column 3
              $Phonemobile = $objWorksheet->getCellByColumnAndRow(14,$i)->getValue(); //Excel Column 4
              $FaxNo =  $objWorksheet->getCellByColumnAndRow(15,$i)->getValue();     
              $Issuedate =  $objWorksheet->getCellByColumnAndRow(16,$i)->getValue(); //Excel Column 1
              $Expirydate =  $objWorksheet->getCellByColumnAndRow(17,$i)->getValue(); //Excel Column 2
              $Cardtype = $objWorksheet->getCellByColumnAndRow(18,$i)->getValue(); //Excel Column 3
              $Title = $objWorksheet->getCellByColumnAndRow(19,$i)->getValue(); //Excel Column 4
              $ICNo =  $objWorksheet->getCellByColumnAndRow(20,$i)->getValue();     
              $OldICNo =  $objWorksheet->getCellByColumnAndRow(21,$i)->getValue(); //Excel Column 1
              $Occupation =  $objWorksheet->getCellByColumnAndRow(22,$i)->getValue(); //Excel Column 2
              $Employer = $objWorksheet->getCellByColumnAndRow(23,$i)->getValue(); //Excel Column 3
              $Birthdate = $objWorksheet->getCellByColumnAndRow(24,$i)->getValue(); //Excel Column 4
              $Principal =  $objWorksheet->getCellByColumnAndRow(25,$i)->getValue();     
              $Active =  $objWorksheet->getCellByColumnAndRow(26,$i)->getValue(); //Excel Column 1
              $Nationality =  $objWorksheet->getCellByColumnAndRow(27,$i)->getValue(); //Excel Column 2
              $PointsBalance = $objWorksheet->getCellByColumnAndRow(28,$i)->getValue(); //Excel Column 3
              $ExpiryDate = $objWorksheet->getCellByColumnAndRow(29,$i)->getValue(); //Excel Column 4
              $IssueDate =  $objWorksheet->getCellByColumnAndRow(30,$i)->getValue();     
              $Branch =  $objWorksheet->getCellByColumnAndRow(31,$i)->getValue(); //Excel Column 1
			  
              $data_user=array(
                'AccountNo'=>$AccountNo, 
                'CardNo'=>$CardNo ,
                'Name'=>$Name ,
                'NameOnCard'=>$NameOnCard , 
                'Address1'=>$Address1,
                'Address2'=>$Address2, 
                'Address3'=>$Address3 ,
                'Address4'=>$Address4 ,
                'City'=>$City , 
                'State'=>$State,
                'Postcode'=>$Postcode, 
                'Email'=>$Email ,
                'Phonehome'=>$Phonehome ,
                'Phoneoffice'=>$Phoneoffice , 
                'Phonemobile'=>$Phonemobile,
                'FaxNo'=>$FaxNo, 
                'Issuedate'=>$Issuedate ,
                'Expirydate'=>$Expirydate ,
                'Cardtype'=>$Cardtype , 
                'Title'=>$Title,
                'ICNo'=>$ICNo, 
                'OldICNo'=>$OldICNo ,
                'Occupation'=>$Occupation ,
                'Employer'=>$Employer , 
                'Birthdate'=>$Birthdate,
                'Principal'=>$Principal, 
                'Active'=>$Active ,
                'Nationality'=>$Nationality ,
                'PointsBalance'=>$PointsBalance , 
                'ExpiryDate'=>$ExpiryDate,
                'IssueDate'=>$IssueDate, 
                'Branch'=>$Branch 
              );
      			  $this->excel_data_insert_model->Add_User($data_user);
              
						  
          }
             unlink('././uploads/excel/'.$file_name); //File Deleted After uploading in database .	
             $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Import Succes<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');		 
             // redirect(base_url() . "Export_excel_c");
	           redirect('Export_excel_c');
       
     }
	
}
?>