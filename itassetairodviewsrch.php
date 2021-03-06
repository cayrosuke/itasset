<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "itassetewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "itassetewmysql12.php") ?>
<?php include_once "itassetphpfn12.php" ?>
<?php include_once "itassetairodviewinfo.php" ?>
<?php include_once "itassetuserinfo.php" ?>
<?php include_once "itassetuserfn12.php" ?>
<?php

//
// Page class
//

$airodview_search = NULL; // Initialize page object first

class cairodview_search extends cairodview {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{6E5D033C-DA34-4C1B-AC0C-D8B1ECCFD39C}";

	// Table name
	var $TableName = 'airodview';

	// Page object name
	var $PageObjName = 'airodview_search';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = TRUE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (airodview)
		if (!isset($GLOBALS["airodview"]) || get_class($GLOBALS["airodview"]) == "cairodview") {
			$GLOBALS["airodview"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["airodview"];
		}

		// Table object (user)
		if (!isset($GLOBALS['user'])) $GLOBALS['user'] = new cuser();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'airodview', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (user)
		if (!isset($UserTable)) {
			$UserTable = new cuser();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanSearch()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("itassetairodviewlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("itassetlogin.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $airodview;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($airodview);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewSearchForm";
	var $IsModal = FALSE;
	var $SearchLabelClass = "col-sm-3 control-label ewLabel";
	var $SearchRightColumnClass = "col-sm-9";

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError;
		global $gbSkipHeaderFooter;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$this->CurrentAction = $objForm->GetValue("a_search");
			switch ($this->CurrentAction) {
				case "S": // Get search criteria

					// Build search string for advanced search, remove blank field
					$this->LoadSearchValues(); // Get search values
					if ($this->ValidateSearch()) {
						$sSrchStr = $this->BuildAdvancedSearch();
					} else {
						$sSrchStr = "";
						$this->setFailureMessage($gsSearchError);
					}
					if ($sSrchStr <> "") {
						$sSrchStr = $this->UrlParm($sSrchStr);
						$sSrchStr = "itassetairodviewlist.php" . "?" . $sSrchStr;
						if ($this->IsModal) {
							$row = array();
							$row["url"] = $sSrchStr;
							echo ew_ArrayToJson(array($row));
							$this->Page_Terminate();
							exit();
						} else {
							$this->Page_Terminate($sSrchStr); // Go to list page
						}
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$this->RowType = EW_ROWTYPE_SEARCH;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Build advanced search
	function BuildAdvancedSearch() {
		$sSrchUrl = "";
		$this->BuildSearchUrl($sSrchUrl, $this->assettag); // assettag
		$this->BuildSearchUrl($sSrchUrl, $this->servicetag); // servicetag
		$this->BuildSearchUrl($sSrchUrl, $this->ipaddress); // ipaddress
		$this->BuildSearchUrl($sSrchUrl, $this->employeeno); // employeeno
		$this->BuildSearchUrl($sSrchUrl, $this->employeename); // employeename
		$this->BuildSearchUrl($sSrchUrl, $this->type); // type
		$this->BuildSearchUrl($sSrchUrl, $this->model); // model
		$this->BuildSearchUrl($sSrchUrl, $this->location); // location
		$this->BuildSearchUrl($sSrchUrl, $this->officelicense); // officelicense
		$this->BuildSearchUrl($sSrchUrl, $this->datereceived); // datereceived
		$this->BuildSearchUrl($sSrchUrl, $this->serialcode); // serialcode
		$this->BuildSearchUrl($sSrchUrl, $this->latestupdate); // latestupdate
		if ($sSrchUrl <> "") $sSrchUrl .= "&";
		$sSrchUrl .= "cmd=search";
		return $sSrchUrl;
	}

	// Build search URL
	function BuildSearchUrl(&$Url, &$Fld, $OprOnly=FALSE) {
		global $objForm;
		$sWrk = "";
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $objForm->GetValue("x_$FldParm");
		$FldOpr = $objForm->GetValue("z_$FldParm");
		$FldCond = $objForm->GetValue("v_$FldParm");
		$FldVal2 = $objForm->GetValue("y_$FldParm");
		$FldOpr2 = $objForm->GetValue("w_$FldParm");
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($FldOpr == "BETWEEN") {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal) && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			}
		} else {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal));
			if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $lFldDataType)) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL" || ($FldOpr <> "" && $OprOnly && ew_IsValidOpr($FldOpr, $lFldDataType))) {
				$sWrk = "z_" . $FldParm . "=" . urlencode($FldOpr);
			}
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $lFldDataType)) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&w_" . $FldParm . "=" . urlencode($FldOpr2);
			} elseif ($FldOpr2 == "IS NULL" || $FldOpr2 == "IS NOT NULL" || ($FldOpr2 <> "" && $OprOnly && ew_IsValidOpr($FldOpr2, $lFldDataType))) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "w_" . $FldParm . "=" . urlencode($FldOpr2);
			}
		}
		if ($sWrk <> "") {
			if ($Url <> "") $Url .= "&";
			$Url .= $sWrk;
		}
	}

	function SearchValueIsNumeric($Fld, $Value) {
		if (ew_IsFloatFormat($Fld->FldType)) $Value = ew_StrToFloat($Value);
		return is_numeric($Value);
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// assettag

		$this->assettag->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_assettag"));
		$this->assettag->AdvancedSearch->SearchOperator = $objForm->GetValue("z_assettag");

		// servicetag
		$this->servicetag->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_servicetag"));
		$this->servicetag->AdvancedSearch->SearchOperator = $objForm->GetValue("z_servicetag");

		// ipaddress
		$this->ipaddress->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_ipaddress"));
		$this->ipaddress->AdvancedSearch->SearchOperator = $objForm->GetValue("z_ipaddress");

		// employeeno
		$this->employeeno->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_employeeno"));
		$this->employeeno->AdvancedSearch->SearchOperator = $objForm->GetValue("z_employeeno");

		// employeename
		$this->employeename->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_employeename"));
		$this->employeename->AdvancedSearch->SearchOperator = $objForm->GetValue("z_employeename");

		// type
		$this->type->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_type"));
		$this->type->AdvancedSearch->SearchOperator = $objForm->GetValue("z_type");

		// model
		$this->model->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_model"));
		$this->model->AdvancedSearch->SearchOperator = $objForm->GetValue("z_model");

		// location
		$this->location->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_location"));
		$this->location->AdvancedSearch->SearchOperator = $objForm->GetValue("z_location");

		// officelicense
		$this->officelicense->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_officelicense"));
		$this->officelicense->AdvancedSearch->SearchOperator = $objForm->GetValue("z_officelicense");

		// datereceived
		$this->datereceived->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_datereceived"));
		$this->datereceived->AdvancedSearch->SearchOperator = $objForm->GetValue("z_datereceived");
		$this->datereceived->AdvancedSearch->SearchCondition = $objForm->GetValue("v_datereceived");
		$this->datereceived->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_datereceived"));
		$this->datereceived->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_datereceived");

		// serialcode
		$this->serialcode->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_serialcode"));
		$this->serialcode->AdvancedSearch->SearchOperator = $objForm->GetValue("z_serialcode");

		// latestupdate
		$this->latestupdate->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_latestupdate"));
		$this->latestupdate->AdvancedSearch->SearchOperator = $objForm->GetValue("z_latestupdate");
		$this->latestupdate->AdvancedSearch->SearchCondition = $objForm->GetValue("v_latestupdate");
		$this->latestupdate->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_latestupdate"));
		$this->latestupdate->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_latestupdate");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// no
		// assettag
		// servicetag
		// ipaddress
		// employeeno
		// employeename
		// company
		// department
		// type
		// model
		// location
		// alternateIP
		// operatingsystem
		// remarks
		// officelicense
		// datereceived
		// serialcode
		// latestupdate

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// assettag
		$this->assettag->ViewValue = $this->assettag->CurrentValue;
		$this->assettag->ViewCustomAttributes = "";

		// servicetag
		$this->servicetag->ViewValue = $this->servicetag->CurrentValue;
		$this->servicetag->ViewCustomAttributes = "";

		// ipaddress
		$this->ipaddress->ViewValue = $this->ipaddress->CurrentValue;
		$this->ipaddress->ViewCustomAttributes = "";

		// employeeno
		$this->employeeno->ViewValue = $this->employeeno->CurrentValue;
		$this->employeeno->ViewCustomAttributes = "";

		// employeename
		$this->employeename->ViewValue = $this->employeename->CurrentValue;
		$this->employeename->ViewCustomAttributes = "";

		// company
		$this->company->ViewValue = $this->company->CurrentValue;
		$this->company->ViewCustomAttributes = "";

		// department
		$this->department->ViewValue = $this->department->CurrentValue;
		$this->department->ViewCustomAttributes = "";

		// type
		if (strval($this->type->CurrentValue) <> "") {
			$this->type->ViewValue = $this->type->OptionCaption($this->type->CurrentValue);
		} else {
			$this->type->ViewValue = NULL;
		}
		$this->type->ViewCustomAttributes = "";

		// model
		$this->model->ViewValue = $this->model->CurrentValue;
		$this->model->ViewCustomAttributes = "";

		// location
		$this->location->ViewValue = $this->location->CurrentValue;
		$this->location->ViewCustomAttributes = "";

		// alternateIP
		$this->alternateIP->ViewValue = $this->alternateIP->CurrentValue;
		$this->alternateIP->ViewCustomAttributes = "";

		// operatingsystem
		$this->operatingsystem->ViewValue = $this->operatingsystem->CurrentValue;
		$this->operatingsystem->ViewCustomAttributes = "";

		// officelicense
		$this->officelicense->ViewValue = $this->officelicense->CurrentValue;
		$this->officelicense->ViewCustomAttributes = "";

		// datereceived
		$this->datereceived->ViewValue = $this->datereceived->CurrentValue;
		$this->datereceived->ViewValue = ew_FormatDateTime($this->datereceived->ViewValue, 7);
		$this->datereceived->ViewCustomAttributes = "";

		// serialcode
		$this->serialcode->ViewValue = $this->serialcode->CurrentValue;
		$this->serialcode->ViewCustomAttributes = "";

		// latestupdate
		$this->latestupdate->ViewValue = $this->latestupdate->CurrentValue;
		$this->latestupdate->ViewValue = ew_FormatDateTime($this->latestupdate->ViewValue, 7);
		$this->latestupdate->ViewCustomAttributes = "";

			// assettag
			$this->assettag->LinkCustomAttributes = "";
			$this->assettag->HrefValue = "";
			$this->assettag->TooltipValue = "";

			// servicetag
			$this->servicetag->LinkCustomAttributes = "";
			$this->servicetag->HrefValue = "";
			$this->servicetag->TooltipValue = "";

			// ipaddress
			$this->ipaddress->LinkCustomAttributes = "";
			$this->ipaddress->HrefValue = "";
			$this->ipaddress->TooltipValue = "";

			// employeeno
			$this->employeeno->LinkCustomAttributes = "";
			$this->employeeno->HrefValue = "";
			$this->employeeno->TooltipValue = "";

			// employeename
			$this->employeename->LinkCustomAttributes = "";
			$this->employeename->HrefValue = "";
			$this->employeename->TooltipValue = "";

			// type
			$this->type->LinkCustomAttributes = "";
			$this->type->HrefValue = "";
			$this->type->TooltipValue = "";

			// model
			$this->model->LinkCustomAttributes = "";
			$this->model->HrefValue = "";
			$this->model->TooltipValue = "";

			// location
			$this->location->LinkCustomAttributes = "";
			$this->location->HrefValue = "";
			$this->location->TooltipValue = "";

			// officelicense
			$this->officelicense->LinkCustomAttributes = "";
			$this->officelicense->HrefValue = "";
			$this->officelicense->TooltipValue = "";

			// datereceived
			$this->datereceived->LinkCustomAttributes = "";
			$this->datereceived->HrefValue = "";
			$this->datereceived->TooltipValue = "";

			// serialcode
			$this->serialcode->LinkCustomAttributes = "";
			$this->serialcode->HrefValue = "";
			$this->serialcode->TooltipValue = "";

			// latestupdate
			$this->latestupdate->LinkCustomAttributes = "";
			$this->latestupdate->HrefValue = "";
			$this->latestupdate->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// assettag
			$this->assettag->EditAttrs["class"] = "form-control";
			$this->assettag->EditCustomAttributes = "";
			$this->assettag->EditValue = ew_HtmlEncode($this->assettag->AdvancedSearch->SearchValue);
			$this->assettag->PlaceHolder = ew_RemoveHtml($this->assettag->FldCaption());

			// servicetag
			$this->servicetag->EditAttrs["class"] = "form-control";
			$this->servicetag->EditCustomAttributes = "";
			$this->servicetag->EditValue = ew_HtmlEncode($this->servicetag->AdvancedSearch->SearchValue);
			$this->servicetag->PlaceHolder = ew_RemoveHtml($this->servicetag->FldCaption());

			// ipaddress
			$this->ipaddress->EditAttrs["class"] = "form-control";
			$this->ipaddress->EditCustomAttributes = "";
			$this->ipaddress->EditValue = ew_HtmlEncode($this->ipaddress->AdvancedSearch->SearchValue);
			$this->ipaddress->PlaceHolder = ew_RemoveHtml($this->ipaddress->FldCaption());

			// employeeno
			$this->employeeno->EditAttrs["class"] = "form-control";
			$this->employeeno->EditCustomAttributes = "";
			$this->employeeno->EditValue = ew_HtmlEncode($this->employeeno->AdvancedSearch->SearchValue);
			$this->employeeno->PlaceHolder = ew_RemoveHtml($this->employeeno->FldCaption());

			// employeename
			$this->employeename->EditAttrs["class"] = "form-control";
			$this->employeename->EditCustomAttributes = "";
			$this->employeename->EditValue = ew_HtmlEncode($this->employeename->AdvancedSearch->SearchValue);
			$this->employeename->PlaceHolder = ew_RemoveHtml($this->employeename->FldCaption());

			// type
			$this->type->EditAttrs["class"] = "form-control";
			$this->type->EditCustomAttributes = "";
			$this->type->EditValue = $this->type->Options(TRUE);

			// model
			$this->model->EditAttrs["class"] = "form-control";
			$this->model->EditCustomAttributes = "";
			$this->model->EditValue = ew_HtmlEncode($this->model->AdvancedSearch->SearchValue);
			$this->model->PlaceHolder = ew_RemoveHtml($this->model->FldCaption());

			// location
			$this->location->EditAttrs["class"] = "form-control";
			$this->location->EditCustomAttributes = "";
			$this->location->EditValue = ew_HtmlEncode($this->location->AdvancedSearch->SearchValue);
			$this->location->PlaceHolder = ew_RemoveHtml($this->location->FldCaption());

			// officelicense
			$this->officelicense->EditAttrs["class"] = "form-control";
			$this->officelicense->EditCustomAttributes = "";
			$this->officelicense->EditValue = ew_HtmlEncode($this->officelicense->AdvancedSearch->SearchValue);
			$this->officelicense->PlaceHolder = ew_RemoveHtml($this->officelicense->FldCaption());

			// datereceived
			$this->datereceived->EditAttrs["class"] = "form-control";
			$this->datereceived->EditCustomAttributes = "";
			$this->datereceived->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->datereceived->AdvancedSearch->SearchValue, 7), 7));
			$this->datereceived->PlaceHolder = ew_RemoveHtml($this->datereceived->FldCaption());
			$this->datereceived->EditAttrs["class"] = "form-control";
			$this->datereceived->EditCustomAttributes = "";
			$this->datereceived->EditValue2 = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->datereceived->AdvancedSearch->SearchValue2, 7), 7));
			$this->datereceived->PlaceHolder = ew_RemoveHtml($this->datereceived->FldCaption());

			// serialcode
			$this->serialcode->EditAttrs["class"] = "form-control";
			$this->serialcode->EditCustomAttributes = "";
			$this->serialcode->EditValue = ew_HtmlEncode($this->serialcode->AdvancedSearch->SearchValue);
			$this->serialcode->PlaceHolder = ew_RemoveHtml($this->serialcode->FldCaption());

			// latestupdate
			$this->latestupdate->EditAttrs["class"] = "form-control";
			$this->latestupdate->EditCustomAttributes = "";
			$this->latestupdate->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->latestupdate->AdvancedSearch->SearchValue, 7), 7));
			$this->latestupdate->PlaceHolder = ew_RemoveHtml($this->latestupdate->FldCaption());
			$this->latestupdate->EditAttrs["class"] = "form-control";
			$this->latestupdate->EditCustomAttributes = "";
			$this->latestupdate->EditValue2 = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->latestupdate->AdvancedSearch->SearchValue2, 7), 7));
			$this->latestupdate->PlaceHolder = ew_RemoveHtml($this->latestupdate->FldCaption());
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckEuroDate($this->datereceived->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->datereceived->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->datereceived->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->datereceived->FldErrMsg());
		}

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->assettag->AdvancedSearch->Load();
		$this->servicetag->AdvancedSearch->Load();
		$this->ipaddress->AdvancedSearch->Load();
		$this->employeeno->AdvancedSearch->Load();
		$this->employeename->AdvancedSearch->Load();
		$this->type->AdvancedSearch->Load();
		$this->model->AdvancedSearch->Load();
		$this->location->AdvancedSearch->Load();
		$this->officelicense->AdvancedSearch->Load();
		$this->datereceived->AdvancedSearch->Load();
		$this->serialcode->AdvancedSearch->Load();
		$this->latestupdate->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("itassetairodviewlist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($airodview_search)) $airodview_search = new cairodview_search();

// Page init
$airodview_search->Page_Init();

// Page main
$airodview_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$airodview_search->Page_Render();
?>
<?php include_once "itassetheader.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($airodview_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fairodviewsearch = new ew_Form("fairodviewsearch", "search");
<?php } else { ?>
var CurrentForm = fairodviewsearch = new ew_Form("fairodviewsearch", "search");
<?php } ?>

// Form_CustomValidate event
fairodviewsearch.Form_CustomValidate =
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fairodviewsearch.ValidateRequired = true;
<?php } else { ?>
fairodviewsearch.ValidateRequired = false;
<?php } ?>

// Dynamic selection lists
fairodviewsearch.Lists["x_type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fairodviewsearch.Lists["x_type"].Options = <?php echo json_encode($airodview->type->Options()) ?>;

// Form object for search
// Validate function for search

fairodviewsearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_datereceived");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($airodview->datereceived->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$airodview_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $airodview_search->ShowPageHeader(); ?>
<?php
$airodview_search->ShowMessage();
?>
<form name="fairodviewsearch" id="fairodviewsearch" class="<?php echo $airodview_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($airodview_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $airodview_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="airodview">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($airodview_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($airodview->assettag->Visible) { // assettag ?>
	<div id="r_assettag" class="form-group">
		<label for="x_assettag" class="<?php echo $airodview_search->SearchLabelClass ?>"><span id="elh_airodview_assettag"><?php echo $airodview->assettag->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_assettag" id="z_assettag" value="="></p>
		</label>
		<div class="<?php echo $airodview_search->SearchRightColumnClass ?>"><div<?php echo $airodview->assettag->CellAttributes() ?>>
			<span id="el_airodview_assettag">
<input type="text" data-table="airodview" data-field="x_assettag" name="x_assettag" id="x_assettag" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($airodview->assettag->getPlaceHolder()) ?>" value="<?php echo $airodview->assettag->EditValue ?>"<?php echo $airodview->assettag->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($airodview->servicetag->Visible) { // servicetag ?>
	<div id="r_servicetag" class="form-group">
		<label for="x_servicetag" class="<?php echo $airodview_search->SearchLabelClass ?>"><span id="elh_airodview_servicetag"><?php echo $airodview->servicetag->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_servicetag" id="z_servicetag" value="="></p>
		</label>
		<div class="<?php echo $airodview_search->SearchRightColumnClass ?>"><div<?php echo $airodview->servicetag->CellAttributes() ?>>
			<span id="el_airodview_servicetag">
<input type="text" data-table="airodview" data-field="x_servicetag" name="x_servicetag" id="x_servicetag" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($airodview->servicetag->getPlaceHolder()) ?>" value="<?php echo $airodview->servicetag->EditValue ?>"<?php echo $airodview->servicetag->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($airodview->ipaddress->Visible) { // ipaddress ?>
	<div id="r_ipaddress" class="form-group">
		<label for="x_ipaddress" class="<?php echo $airodview_search->SearchLabelClass ?>"><span id="elh_airodview_ipaddress"><?php echo $airodview->ipaddress->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_ipaddress" id="z_ipaddress" value="="></p>
		</label>
		<div class="<?php echo $airodview_search->SearchRightColumnClass ?>"><div<?php echo $airodview->ipaddress->CellAttributes() ?>>
			<span id="el_airodview_ipaddress">
<input type="text" data-table="airodview" data-field="x_ipaddress" name="x_ipaddress" id="x_ipaddress" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($airodview->ipaddress->getPlaceHolder()) ?>" value="<?php echo $airodview->ipaddress->EditValue ?>"<?php echo $airodview->ipaddress->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($airodview->employeeno->Visible) { // employeeno ?>
	<div id="r_employeeno" class="form-group">
		<label for="x_employeeno" class="<?php echo $airodview_search->SearchLabelClass ?>"><span id="elh_airodview_employeeno"><?php echo $airodview->employeeno->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_employeeno" id="z_employeeno" value="="></p>
		</label>
		<div class="<?php echo $airodview_search->SearchRightColumnClass ?>"><div<?php echo $airodview->employeeno->CellAttributes() ?>>
			<span id="el_airodview_employeeno">
<input type="text" data-table="airodview" data-field="x_employeeno" name="x_employeeno" id="x_employeeno" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($airodview->employeeno->getPlaceHolder()) ?>" value="<?php echo $airodview->employeeno->EditValue ?>"<?php echo $airodview->employeeno->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($airodview->employeename->Visible) { // employeename ?>
	<div id="r_employeename" class="form-group">
		<label for="x_employeename" class="<?php echo $airodview_search->SearchLabelClass ?>"><span id="elh_airodview_employeename"><?php echo $airodview->employeename->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_employeename" id="z_employeename" value="LIKE"></p>
		</label>
		<div class="<?php echo $airodview_search->SearchRightColumnClass ?>"><div<?php echo $airodview->employeename->CellAttributes() ?>>
			<span id="el_airodview_employeename">
<input type="text" data-table="airodview" data-field="x_employeename" name="x_employeename" id="x_employeename" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($airodview->employeename->getPlaceHolder()) ?>" value="<?php echo $airodview->employeename->EditValue ?>"<?php echo $airodview->employeename->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($airodview->type->Visible) { // type ?>
	<div id="r_type" class="form-group">
		<label for="x_type" class="<?php echo $airodview_search->SearchLabelClass ?>"><span id="elh_airodview_type"><?php echo $airodview->type->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_type" id="z_type" value="="></p>
		</label>
		<div class="<?php echo $airodview_search->SearchRightColumnClass ?>"><div<?php echo $airodview->type->CellAttributes() ?>>
			<span id="el_airodview_type">
<select data-table="airodview" data-field="x_type" data-value-separator="<?php echo ew_HtmlEncode(is_array($airodview->type->DisplayValueSeparator) ? json_encode($airodview->type->DisplayValueSeparator) : $airodview->type->DisplayValueSeparator) ?>" id="x_type" name="x_type"<?php echo $airodview->type->EditAttributes() ?>>
<?php
if (is_array($airodview->type->EditValue)) {
	$arwrk = $airodview->type->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($airodview->type->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $airodview->type->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($airodview->type->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($airodview->type->CurrentValue) ?>" selected><?php echo $airodview->type->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($airodview->model->Visible) { // model ?>
	<div id="r_model" class="form-group">
		<label for="x_model" class="<?php echo $airodview_search->SearchLabelClass ?>"><span id="elh_airodview_model"><?php echo $airodview->model->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_model" id="z_model" value="LIKE"></p>
		</label>
		<div class="<?php echo $airodview_search->SearchRightColumnClass ?>"><div<?php echo $airodview->model->CellAttributes() ?>>
			<span id="el_airodview_model">
<input type="text" data-table="airodview" data-field="x_model" name="x_model" id="x_model" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($airodview->model->getPlaceHolder()) ?>" value="<?php echo $airodview->model->EditValue ?>"<?php echo $airodview->model->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($airodview->location->Visible) { // location ?>
	<div id="r_location" class="form-group">
		<label for="x_location" class="<?php echo $airodview_search->SearchLabelClass ?>"><span id="elh_airodview_location"><?php echo $airodview->location->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_location" id="z_location" value="LIKE"></p>
		</label>
		<div class="<?php echo $airodview_search->SearchRightColumnClass ?>"><div<?php echo $airodview->location->CellAttributes() ?>>
			<span id="el_airodview_location">
<input type="text" data-table="airodview" data-field="x_location" name="x_location" id="x_location" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($airodview->location->getPlaceHolder()) ?>" value="<?php echo $airodview->location->EditValue ?>"<?php echo $airodview->location->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($airodview->officelicense->Visible) { // officelicense ?>
	<div id="r_officelicense" class="form-group">
		<label for="x_officelicense" class="<?php echo $airodview_search->SearchLabelClass ?>"><span id="elh_airodview_officelicense"><?php echo $airodview->officelicense->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_officelicense" id="z_officelicense" value="="></p>
		</label>
		<div class="<?php echo $airodview_search->SearchRightColumnClass ?>"><div<?php echo $airodview->officelicense->CellAttributes() ?>>
			<span id="el_airodview_officelicense">
<input type="text" data-table="airodview" data-field="x_officelicense" name="x_officelicense" id="x_officelicense" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($airodview->officelicense->getPlaceHolder()) ?>" value="<?php echo $airodview->officelicense->EditValue ?>"<?php echo $airodview->officelicense->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($airodview->datereceived->Visible) { // datereceived ?>
	<div id="r_datereceived" class="form-group">
		<label for="x_datereceived" class="<?php echo $airodview_search->SearchLabelClass ?>"><span id="elh_airodview_datereceived"><?php echo $airodview->datereceived->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("BETWEEN") ?><input type="hidden" name="z_datereceived" id="z_datereceived" value="BETWEEN"></p>
		</label>
		<div class="<?php echo $airodview_search->SearchRightColumnClass ?>"><div<?php echo $airodview->datereceived->CellAttributes() ?>>
			<span id="el_airodview_datereceived">
<input type="text" data-table="airodview" data-field="x_datereceived" data-format="7" name="x_datereceived" id="x_datereceived" placeholder="<?php echo ew_HtmlEncode($airodview->datereceived->getPlaceHolder()) ?>" value="<?php echo $airodview->datereceived->EditValue ?>"<?php echo $airodview->datereceived->EditAttributes() ?>>
<?php if (!$airodview->datereceived->ReadOnly && !$airodview->datereceived->Disabled && !isset($airodview->datereceived->EditAttrs["readonly"]) && !isset($airodview->datereceived->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fairodviewsearch", "x_datereceived", "%d-%m-%Y");
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_datereceived">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_airodview_datereceived" class="btw1_datereceived">
<input type="text" data-table="airodview" data-field="x_datereceived" data-format="7" name="y_datereceived" id="y_datereceived" placeholder="<?php echo ew_HtmlEncode($airodview->datereceived->getPlaceHolder()) ?>" value="<?php echo $airodview->datereceived->EditValue2 ?>"<?php echo $airodview->datereceived->EditAttributes() ?>>
<?php if (!$airodview->datereceived->ReadOnly && !$airodview->datereceived->Disabled && !isset($airodview->datereceived->EditAttrs["readonly"]) && !isset($airodview->datereceived->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fairodviewsearch", "y_datereceived", "%d-%m-%Y");
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($airodview->serialcode->Visible) { // serialcode ?>
	<div id="r_serialcode" class="form-group">
		<label for="x_serialcode" class="<?php echo $airodview_search->SearchLabelClass ?>"><span id="elh_airodview_serialcode"><?php echo $airodview->serialcode->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_serialcode" id="z_serialcode" value="="></p>
		</label>
		<div class="<?php echo $airodview_search->SearchRightColumnClass ?>"><div<?php echo $airodview->serialcode->CellAttributes() ?>>
			<span id="el_airodview_serialcode">
<input type="text" data-table="airodview" data-field="x_serialcode" name="x_serialcode" id="x_serialcode" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($airodview->serialcode->getPlaceHolder()) ?>" value="<?php echo $airodview->serialcode->EditValue ?>"<?php echo $airodview->serialcode->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($airodview->latestupdate->Visible) { // latestupdate ?>
	<div id="r_latestupdate" class="form-group">
		<label for="x_latestupdate" class="<?php echo $airodview_search->SearchLabelClass ?>"><span id="elh_airodview_latestupdate"><?php echo $airodview->latestupdate->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("BETWEEN") ?><input type="hidden" name="z_latestupdate" id="z_latestupdate" value="BETWEEN"></p>
		</label>
		<div class="<?php echo $airodview_search->SearchRightColumnClass ?>"><div<?php echo $airodview->latestupdate->CellAttributes() ?>>
			<span id="el_airodview_latestupdate">
<input type="text" data-table="airodview" data-field="x_latestupdate" data-format="7" name="x_latestupdate" id="x_latestupdate" placeholder="<?php echo ew_HtmlEncode($airodview->latestupdate->getPlaceHolder()) ?>" value="<?php echo $airodview->latestupdate->EditValue ?>"<?php echo $airodview->latestupdate->EditAttributes() ?>>
<?php if (!$airodview->latestupdate->ReadOnly && !$airodview->latestupdate->Disabled && !isset($airodview->latestupdate->EditAttrs["readonly"]) && !isset($airodview->latestupdate->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fairodviewsearch", "x_latestupdate", "%d-%m-%Y");
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_latestupdate">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_airodview_latestupdate" class="btw1_latestupdate">
<input type="text" data-table="airodview" data-field="x_latestupdate" data-format="7" name="y_latestupdate" id="y_latestupdate" placeholder="<?php echo ew_HtmlEncode($airodview->latestupdate->getPlaceHolder()) ?>" value="<?php echo $airodview->latestupdate->EditValue2 ?>"<?php echo $airodview->latestupdate->EditAttributes() ?>>
<?php if (!$airodview->latestupdate->ReadOnly && !$airodview->latestupdate->Disabled && !isset($airodview->latestupdate->EditAttrs["readonly"]) && !isset($airodview->latestupdate->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fairodviewsearch", "y_latestupdate", "%d-%m-%Y");
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$airodview_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fairodviewsearch.Init();
</script>
<?php
$airodview_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "itassetfooter.php" ?>
<?php
$airodview_search->Page_Terminate();
?>
