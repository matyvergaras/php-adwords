<?php
	require_once 'init.php';
    require_once 'ReportUtils.php';
    require_once 'SimpleOAuth2Handler.php';
    require_once 'ReportUtils.php';
	class Traedatos
	{
		private $user;

		public function __construct()
		{
			
		}

		public function setUser($user)
		{
			$this->user = $user;
		}

		public function creaUsuario($data)
		{
			$credentials = array(
		        "client_id" => '851197242710-eddgs40lafgm0mvf9pbf8i7q6jogn8da.apps.googleusercontent.com',
		        "client_secret" => 'nihInc57wWFw3ocgcZGdR-RI'
		    );

		    $this->user = new AdWordsUser();
		    $this->user->SetUserAgent("audience.ltda@gmail.com");
		    $this->user->SetDeveloperToken('3QNYmQcux02171LvdXAXHQ');
		    $this->user->SetOAuth2Info($credentials);
		    

		    $handler = new SimpleOAuth2Handler();
		    $access_token = $handler->GetAccessToken($credentials, $data, 'http://www.audience.cl/adwords/inicio/obtenercampanas.php');

		    $credentials = array(
		        "client_id" => '851197242710-eddgs40lafgm0mvf9pbf8i7q6jogn8da.apps.googleusercontent.com',
		        "client_secret" => 'nihInc57wWFw3ocgcZGdR-RI',
		        "access_token" => $access_token["access_token"]
		    );
		    $this->user->SetOAuth2Info($credentials);
		    
		    $customerService = $this->user->GetService('CustomerService', ADWORDS_VERSION);
		    $cust = $customerService->getCustomers();
		    //echo "Customer: ".$cust[0]->customerId;
		    $this->user->SetClientCustomerId($cust[0]->customerId);
		}

		public function creaUsuarioUserId($userId)
		{
			$this->user->SetClientCustomerId($userId);
		}

		public function getUser()
		{
			return $this->user;
		}

		public function primerosDatosUno($user)
		{
			$filePath = "reportes/firstdata".$this->user->GetClientCustomerId().".csv";
		    $user->GetService('ReportDefinitionService', ADWORDS_VERSION);

		    $selector = new Selector();
		    $selector->fields = array('Ctr', 'AveragePosition', 'AdNetworkType1');

		    $reportDefinition = new ReportDefinition();
		    $reportDefinition->selector = $selector;
		    $reportDefinition->reportName = 'Performance Report';
		    $reportDefinition->dateRangeType = 'LAST_30_DAYS';
		    $reportDefinition->reportType = 'ACCOUNT_PERFORMANCE_REPORT';
		    $reportDefinition->downloadFormat = 'CSV';

		    $options = array('returnMoneyInMicros' => TRUE);

		    $ReportUtils = new ReportUtils();
			$ReportUtils->DownloadReport($reportDefinition, $filePath, $user, $options);
		    //ReportUtils::DownloadReport($reportDefinition, $filePath, $user, $options);
		    $fp = fopen($filePath, "r");
		    $cont = 0;
		    $datos = Array();
		    $ctrAux = 0;
		    while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) 
		    {
		      	foreach($data as $row) 
			    {
			        $arre = explode(",",$row);
			    	if($cont == 2)
			    	{
			    		if(strcmp($arre[2], "Search Network") == 0)
			    		{
				    		$datos[0] = $arre[0];
			            	$datos[1] = $arre[1];
		            	}
		            	else
		            	{
		            		$ctrAux = $arre[0];
		            	}
		            }
		            if($cont == 3)
		            {
		            	if(strcmp($arre[2], "Search Network") == 0)
		            	{
		            		$datos[0] = $arre[0];
			            	$datos[1] = $arre[1];
			            	$datos[2] = $ctrAux;
		            	}
		            	else
		            		$datos[2] = $arre[0];
		            	fclose($fp);
		            	unlink($filePath);
		            	return $datos;
		            }

		          	$cont++;
			    }
		    }
		    fclose($fp);
		    unlink($filePath);
		}

		public function primerosDatosDos($user)
		{
			$filePath = "reportes/seconddata".$this->user->GetClientCustomerId().".csv";
		    $user->GetService('ReportDefinitionService', ADWORDS_VERSION);

		    $selector = new Selector();
		    $selector->fields = array('SearchBudgetLostImpressionShare', 'SearchImpressionShare', 'AdNetworkType1');

		    $reportDefinition = new ReportDefinition();
		    $reportDefinition->selector = $selector;
		    $reportDefinition->reportName = 'Performance Report';
		    $reportDefinition->dateRangeType = 'LAST_30_DAYS';
		    $reportDefinition->reportType = 'ACCOUNT_PERFORMANCE_REPORT';
		    $reportDefinition->downloadFormat = 'CSV';

		    $options = array('returnMoneyInMicros' => TRUE);

		    $ReportUtils = new ReportUtils();
			$ReportUtils->DownloadReport($reportDefinition, $filePath, $user, $options);
		    //ReportUtils::DownloadReport($reportDefinition, $filePath, $user, $options);
		    $fp = fopen($filePath, "r");
		    $cont = 0;
		    $datos = Array();
		    while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) 
		    {
		      	foreach($data as $row) 
			    {
			        $arre = explode(",",$row);
			    	if($cont > 1)
			    	{
			    		if(strcmp($arre[2], "Search Network") == 0)
			    		{	
			    			$datos[0] = $arre[0];
			    			$datos[1] = $arre[1];
			    		}
			    	}
					$cont++;
			    }
		    }
		    fclose($fp);
		    unlink($filePath);
		    return $datos;
		}

		public function segundosDatos($user)
		{
			$filePath = "reportes/thirddata".$this->user->GetClientCustomerId().".csv";
	        $user->GetService('ReportDefinitionService', ADWORDS_VERSION);

	        $selector = new Selector();
	        $selector->fields = array('Id', 'DisplayName', 'QualityScore', 'AdNetworkType1');
	        $reportDefinition = new ReportDefinition();
	        $reportDefinition->selector = $selector;
	        $reportDefinition->reportName = 'CTR';
	        $reportDefinition->dateRangeType = 'LAST_30_DAYS';
	        $reportDefinition->reportType = 'CRITERIA_PERFORMANCE_REPORT';
	        $reportDefinition->downloadFormat = 'CSV';

	        $options = array('returnMoneyInMicros' => TRUE);

	        
	        $ReportUtils = new ReportUtils();
			$ReportUtils->DownloadReport($reportDefinition, $filePath, $user, $options);
	        //ReportUtils::DownloadReport($reportDefinition, $filePath, $user, $options);

	        $fp = fopen($filePath, "r");
	        $cont = 0;
	        $cuentaKeywords = 0;
	        $acumulaQuality = 0;
	      	$qualityPromedio = 0;

	        while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) 
	        {
	            foreach($data as $row) 
	        	{
	            	$arre = explode(",",$row);
	          		if($arre[2] >= 0 && $arre[2] <= 10 && strcmp($arre[3], "Search Network") == 0)
	          		{
	            		$cuentaKeywords++;
	            		$acumulaQuality += $arre[2];
	          		}
	        	}
	        }
	        fclose($fp);
	        unlink($filePath);
	        if($cuentaKeywords != 0)
	        	return $qualityPromedio = $acumulaQuality / $cuentaKeywords;
	        else
	        	return 0;
		}

		public function tercerosDatos($user)
		{
			$filePath = "reportes/fourthdata".$this->user->GetClientCustomerId().".csv";
	        $user->GetService('ReportDefinitionService', ADWORDS_VERSION);

	        $selector = new Selector();
	        $selector->fields = array('Id', 'KeywordMatchType', 'IsNegative', 'AdNetworkType1');

	        $reportDefinition = new ReportDefinition();
	        $reportDefinition->selector = $selector;
	        $reportDefinition->reportName = 'CTR';
	        $reportDefinition->dateRangeType = 'LAST_30_DAYS';
	        $reportDefinition->reportType = 'KEYWORDS_PERFORMANCE_REPORT';
	        $reportDefinition->downloadFormat = 'CSV';

	        $options = array('returnMoneyInMicros' => TRUE);

	        $ReportUtils = new ReportUtils();
			$ReportUtils->DownloadReport($reportDefinition, $filePath, $user, $options);
	        //ReportUtils::DownloadReport($reportDefinition, $filePath, $user, $options);

	        $fp = fopen($filePath, "r");
	        $cont = 0;
	        $frase = 0;
	        $exacta = 0;
	        $amplia = 0;
	        $Pfrase = 0;
	        $Pexacta = 0;
	        $Pamplia = 0;
	        $negativas = 0;
	        $cicle = 0;
	        while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) 
	        {
	        	foreach($data as $row) 
	            {
		            $arre = explode(",",$row);
		            switch($arre[1])
		            {
		                case "Phrase":
		                	if(strcmp($arre[3], "Search Network") == 0)
		                	{
		                		$frase++;
		                  		$cont++;
		                	}
		                break;
		                case "Exact":
		                  if(strcmp($arre[3], "Search Network") == 0)
		                	{
		                		$exacta++;
		                  		$cont++;
		                	}
		                break;
		                case "Broad":
		                  if(strcmp($arre[3], "Search Network") == 0)
		                	{
		                		$amplia++;
		                  		$cont++;
		                	}
		                break;
		            }

		            if($arre[2])
			        	$negativas++;
			    }
	        }

	        if($cont !=0)
	        {
		        $Pfrase = $frase * 100 / $cont;
		        $Pamplia = $amplia * 100 / $cont;
		        $Pexacta = $exacta * 100 / $cont;
	    	}
	        $datos = Array($Pfrase, $Pamplia, $Pexacta, $negativas);
	        fclose($fp);
	        //unlink($filePath);
	        return $datos;	        
	    }

	    public function cuartosDatos($user)
	    {
	    	$filePath = "reportes/fifthdata".$this->user->GetClientCustomerId().".csv";
		    $user->GetService('ReportDefinitionService', ADWORDS_VERSION);

		    $selector = new Selector();
		    $selector->fields = array('CampaignName', 'ServingStatus', 'CampaignStatus');

		    $reportDefinition = new ReportDefinition();
		    $reportDefinition->selector = $selector;
		    $reportDefinition->reportName = 'Performance Report';
		    $reportDefinition->dateRangeType = 'LAST_30_DAYS';
		    $reportDefinition->reportType = 'CAMPAIGN_PERFORMANCE_REPORT';
		    $reportDefinition->downloadFormat = 'CSV';

		    $options = array('returnMoneyInMicros' => TRUE);

		    $ReportUtils = new ReportUtils();
			$ReportUtils->DownloadReport($reportDefinition, $filePath, $user, $options);
		    //ReportUtils::DownloadReport($reportDefinition, $filePath, $user, $options);

		    $fp = fopen($filePath, "r");
	        $cont = 0;
	        $enabled = 0;
	        while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) 
	        {
	        	foreach($data as $row) 
	            {
		            $arre = explode(",",$row);
		            if(strcmp($arre[1], "eligible") == 0 && strcmp($arre[2], "enabled") == 0)
		            	$enabled++;
	            }
	        }
	        fclose($fp);
	        unlink($filePath);
	        return $enabled;
	    }

	    public function quintosDatos($user)
	    {
	    	$filePath = "reportes/sixthdata".$this->user->GetClientCustomerId().".csv";
	        $user->GetService('ReportDefinitionService', ADWORDS_VERSION);

	        $selector = new Selector();
	        $selector->fields = array('Id');
	        $reportDefinition = new ReportDefinition();
	        $reportDefinition->selector = $selector;
	        $reportDefinition->reportName = 'CTR';
	        $reportDefinition->dateRangeType = 'LAST_30_DAYS';
	        $reportDefinition->reportType = 'CAMPAIGN_NEGATIVE_KEYWORDS_PERFORMANCE_REPORT';
	        $reportDefinition->downloadFormat = 'CSV';

	        $options = array('returnMoneyInMicros' => TRUE);

	        
	        $ReportUtils = new ReportUtils();
			$ReportUtils->DownloadReport($reportDefinition, $filePath, $user, $options);
	        //ReportUtils::DownloadReport($reportDefinition, $filePath, $user, $options);

	        $fp = fopen($filePath, "r");
	        $cont = 0;
	      
	        while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) 
	        {
	            foreach($data as $row) 
	        	{
	            	$arre = explode(",",$row);
	          		$cont++;
	        	}
	        }
	        fclose($fp);
	        unlink($filePath);
	        return ($cont - 2);
	    }

	    public function esMcc($user)
	    {
	    	try
	    	{
		    	$filePath = "reportes/mcc".$this->user->GetClientCustomerId().".csv";
			    $user->GetService('ManagedCustomerService', ADWORDS_VERSION);

			    $selector = new Selector();
			    $selector->fields = array('CanManageClients');

			    $reportDefinition = new ReportDefinition();
			    $reportDefinition->selector = $selector;
			    $reportDefinition->reportName = 'Performance Report';
			    $reportDefinition->dateRangeType = 'LAST_30_DAYS';
			    $reportDefinition->reportType = 'ACCOUNT_PERFORMANCE_REPORT';
			    $reportDefinition->downloadFormat = 'CSV';

			    $options = array('returnMoneyInMicros' => TRUE);

			    $ReportUtils = new ReportUtils();
			    $ReportUtils->DownloadReport($reportDefinition, $filePath, $user, $options);
			    //ReportUtils::DownloadReport($reportDefinition, $filePath, $user, $options);
			    $fp = fopen($filePath, "r");
			    $cont = 0;
			    while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) 
			    {
			      	foreach($data as $row) 
				    {
				        $arre = explode(",",$row);
				    	if($cont == 2)
				    	{
				    		fclose($fp);
				    		unlink($filePath);
				    		return $arre[0];
				    	}

			          	$cont++;
				    }
			    }
			}
			catch(Exception $e)
			{
				return "true";
			}
	    }

	    public function muestraCuentas($user)
	    {
	    	$managedCustomerService = $user->GetService('ManagedCustomerService');
		    $selector = new Selector();
		    $selector->fields = array('CustomerId',  'Name', 'CanManageClients');
		    $graph = $managedCustomerService->get($selector);
		    $entries = $graph->entries;

		    $result = "<script type='text/javascript'>";
		    $result .= "function enviar(){";
		    $result .= "document.forms[0].submit();";
		    $result .= "}";
		    $result .= "</script>";
		    
		    $result .= "<form action='obtenercampanas.php' method='post'>";
		    $result .= "<select name='clientid' onchange='enviar()'>";
		    $result .= "<option value='0'>Seleccione una cuenta</option>";
		    foreach ($entries as $key => $value) {
		      if($value->canManageClients!=1 && $value->name != ""){
		        $result .= "<option value='".$value->customerId."'>";
		        	$result .= $value->name;
		        $result .= "</option>";
		      }
		    }
		    $result .= "</select>";
		    $result .= "</form>";
		    return $result;
	    }
	}
?>