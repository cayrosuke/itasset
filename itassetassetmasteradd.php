<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "itassetewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "itassetewmysql12.php") ?>
<?php include_once "itassetphpfn12.php" ?>
<?php include_once "itassetassetmasterinfo.php" ?>
<?php include_once "itassetuserinfo.php" ?>
<?php include_once "itassetuserfn12.php" ?>
<?php

//
// Page class
//

$assetmaster_add = NULL; // Initialize page object first

class cassetmaster_add extends cassetmaster {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{6E5D033C-DA34-4C1B-AC0C-D8B1ECCFD39C}";

	// Table name
	var $TableName = 'assetmaster';

	// Page object name
	var $PageObjName = 'assetmaster_add';

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

		// Table object (assetmaster)
		if (!isset($GLOBALS["assetmaster"]) || get_class($GLOBALS["assetmaster"]) == "cassetmaster") {
			$GLOBALS["assetmaster"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["assetmaster"];
		}

		// Table object (user)
		if (!isset($GLOBALS['user'])) $GLOBALS['user'] = new cuser();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'assetmaster', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("itassetassetmasterlist.php"));
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $assetmaster;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($assetmaster);
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["no"] != "") {
				$this->no->setQueryStringValue($_GET["no"]);
				$this->setKey("no", $this->no->CurrentValue); // Set up key
			} else {
				$this->setKey("no", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("itassetassetmasterlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "itassetassetmasterlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "itassetassetmasterview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		if ($this->CurrentAction == "F") { // Confirm page
			$this->RowType = EW_ROWTYPE_VIEW; // Render view type
		} else {
			$this->RowType = EW_ROWTYPE_ADD; // Render add type
		}

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->assettag->CurrentValue = NULL;
		$this->assettag->OldValue = $this->assettag->CurrentValue;
		$this->servicetag->CurrentValue = NULL;
		$this->servicetag->OldValue = $this->servicetag->CurrentValue;
		$this->ipaddress->CurrentValue = NULL;
		$this->ipaddress->OldValue = $this->ipaddress->CurrentValue;
		$this->employeeno->CurrentValue = NULL;
		$this->employeeno->OldValue = $this->employeeno->CurrentValue;
		$this->employeename->CurrentValue = NULL;
		$this->employeename->OldValue = $this->employeename->CurrentValue;
		$this->company->CurrentValue = NULL;
		$this->company->OldValue = $this->company->CurrentValue;
		$this->department->CurrentValue = NULL;
		$this->department->OldValue = $this->department->CurrentValue;
		$this->type->CurrentValue = NULL;
		$this->type->OldValue = $this->type->CurrentValue;
		$this->model->CurrentValue = NULL;
		$this->model->OldValue = $this->model->CurrentValue;
		$this->location->CurrentValue = NULL;
		$this->location->OldValue = $this->location->CurrentValue;
		$this->alternateIP->CurrentValue = NULL;
		$this->alternateIP->OldValue = $this->alternateIP->CurrentValue;
		$this->operatingsystem->CurrentValue = NULL;
		$this->operatingsystem->OldValue = $this->operatingsystem->CurrentValue;
		$this->remarks->CurrentValue = NULL;
		$this->remarks->OldValue = $this->remarks->CurrentValue;
		$this->officelicense->CurrentValue = NULL;
		$this->officelicense->OldValue = $this->officelicense->CurrentValue;
		$this->datereceived->CurrentValue = NULL;
		$this->datereceived->OldValue = $this->datereceived->CurrentValue;
		$this->serialcode->CurrentValue = NULL;
		$this->serialcode->OldValue = $this->serialcode->CurrentValue;
		$this->latestupdate->CurrentValue = NULL;
		$this->latestupdate->OldValue = $this->latestupdate->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->assettag->FldIsDetailKey) {
			$this->assettag->setFormValue($objForm->GetValue("x_assettag"));
		}
		if (!$this->servicetag->FldIsDetailKey) {
			$this->servicetag->setFormValue($objForm->GetValue("x_servicetag"));
		}
		if (!$this->ipaddress->FldIsDetailKey) {
			$this->ipaddress->setFormValue($objForm->GetValue("x_ipaddress"));
		}
		if (!$this->employeeno->FldIsDetailKey) {
			$this->employeeno->setFormValue($objForm->GetValue("x_employeeno"));
		}
		if (!$this->employeename->FldIsDetailKey) {
			$this->employeename->setFormValue($objForm->GetValue("x_employeename"));
		}
		if (!$this->company->FldIsDetailKey) {
			$this->company->setFormValue($objForm->GetValue("x_company"));
		}
		if (!$this->department->FldIsDetailKey) {
			$this->department->setFormValue($objForm->GetValue("x_department"));
		}
		if (!$this->type->FldIsDetailKey) {
			$this->type->setFormValue($objForm->GetValue("x_type"));
		}
		if (!$this->model->FldIsDetailKey) {
			$this->model->setFormValue($objForm->GetValue("x_model"));
		}
		if (!$this->location->FldIsDetailKey) {
			$this->location->setFormValue($objForm->GetValue("x_location"));
		}
		if (!$this->alternateIP->FldIsDetailKey) {
			$this->alternateIP->setFormValue($objForm->GetValue("x_alternateIP"));
		}
		if (!$this->operatingsystem->FldIsDetailKey) {
			$this->operatingsystem->setFormValue($objForm->GetValue("x_operatingsystem"));
		}
		if (!$this->remarks->FldIsDetailKey) {
			$this->remarks->setFormValue($objForm->GetValue("x_remarks"));
		}
		if (!$this->officelicense->FldIsDetailKey) {
			$this->officelicense->setFormValue($objForm->GetValue("x_officelicense"));
		}
		if (!$this->datereceived->FldIsDetailKey) {
			$this->datereceived->setFormValue($objForm->GetValue("x_datereceived"));
			$this->datereceived->CurrentValue = ew_UnFormatDateTime($this->datereceived->CurrentValue, 7);
		}
		if (!$this->serialcode->FldIsDetailKey) {
			$this->serialcode->setFormValue($objForm->GetValue("x_serialcode"));
		}
		if (!$this->latestupdate->FldIsDetailKey) {
			$this->latestupdate->setFormValue($objForm->GetValue("x_latestupdate"));
			$this->latestupdate->CurrentValue = ew_UnFormatDateTime($this->latestupdate->CurrentValue, 7);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->assettag->CurrentValue = $this->assettag->FormValue;
		$this->servicetag->CurrentValue = $this->servicetag->FormValue;
		$this->ipaddress->CurrentValue = $this->ipaddress->FormValue;
		$this->employeeno->CurrentValue = $this->employeeno->FormValue;
		$this->employeename->CurrentValue = $this->employeename->FormValue;
		$this->company->CurrentValue = $this->company->FormValue;
		$this->department->CurrentValue = $this->department->FormValue;
		$this->type->CurrentValue = $this->type->FormValue;
		$this->model->CurrentValue = $this->model->FormValue;
		$this->location->CurrentValue = $this->location->FormValue;
		$this->alternateIP->CurrentValue = $this->alternateIP->FormValue;
		$this->operatingsystem->CurrentValue = $this->operatingsystem->FormValue;
		$this->remarks->CurrentValue = $this->remarks->FormValue;
		$this->officelicense->CurrentValue = $this->officelicense->FormValue;
		$this->datereceived->CurrentValue = $this->datereceived->FormValue;
		$this->datereceived->CurrentValue = ew_UnFormatDateTime($this->datereceived->CurrentValue, 7);
		$this->serialcode->CurrentValue = $this->serialcode->FormValue;
		$this->latestupdate->CurrentValue = $this->latestupdate->FormValue;
		$this->latestupdate->CurrentValue = ew_UnFormatDateTime($this->latestupdate->CurrentValue, 7);

	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->no->setDbValue($rs->fields('no'));
		$this->assettag->setDbValue($rs->fields('assettag'));
		$this->servicetag->setDbValue($rs->fields('servicetag'));
		$this->ipaddress->setDbValue($rs->fields('ipaddress'));
		$this->employeeno->setDbValue($rs->fields('employeeno'));
		$this->employeename->setDbValue($rs->fields('employeename'));
		$this->company->setDbValue($rs->fields('company'));
		$this->department->setDbValue($rs->fields('department'));
		$this->type->setDbValue($rs->fields('type'));
		$this->model->setDbValue($rs->fields('model'));
		$this->location->setDbValue($rs->fields('location'));
		$this->alternateIP->setDbValue($rs->fields('alternateIP'));
		$this->operatingsystem->setDbValue($rs->fields('operatingsystem'));
		$this->remarks->setDbValue($rs->fields('remarks'));
		$this->officelicense->setDbValue($rs->fields('officelicense'));
		$this->datereceived->setDbValue($rs->fields('datereceived'));
		$this->serialcode->setDbValue($rs->fields('serialcode'));
		$this->latestupdate->setDbValue($rs->fields('latestupdate'));
	}
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->no->DbValue = $row['no'];
		$this->assettag->DbValue = $row['assettag'];
		$this->servicetag->DbValue = $row['servicetag'];
		$this->ipaddress->DbValue = $row['ipaddress'];
		$this->employeeno->DbValue = $row['employeeno'];
		$this->employeename->DbValue = $row['employeename'];
		$this->company->DbValue = $row['company'];
		$this->department->DbValue = $row['department'];
		$this->type->DbValue = $row['type'];
		$this->model->DbValue = $row['model'];
		$this->location->DbValue = $row['location'];
		$this->alternateIP->DbValue = $row['alternateIP'];
		$this->operatingsystem->DbValue = $row['operatingsystem'];
		$this->remarks->DbValue = $row['remarks'];
		$this->officelicense->DbValue = $row['officelicense'];
		$this->datereceived->DbValue = $row['datereceived'];
		$this->serialcode->DbValue = $row['serialcode'];
		$this->latestupdate->DbValue = $row['latestupdate'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("no")) <> "")
			$this->no->CurrentValue = $this->getKey("no"); // no
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
		if (strval($this->company->CurrentValue) <> "") {
			$this->company->ViewValue = $this->company->OptionCaption($this->company->CurrentValue);
		} else {
			$this->company->ViewValue = NULL;
		}
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

		// remarks
		$this->remarks->ViewValue = $this->remarks->CurrentValue;
		$this->remarks->ViewCustomAttributes = "";

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

			// company
			$this->company->LinkCustomAttributes = "";
			$this->company->HrefValue = "";
			$this->company->TooltipValue = "";

			// department
			$this->department->LinkCustomAttributes = "";
			$this->department->HrefValue = "";
			$this->department->TooltipValue = "";

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

			// alternateIP
			$this->alternateIP->LinkCustomAttributes = "";
			$this->alternateIP->HrefValue = "";
			$this->alternateIP->TooltipValue = "";

			// operatingsystem
			$this->operatingsystem->LinkCustomAttributes = "";
			$this->operatingsystem->HrefValue = "";
			$this->operatingsystem->TooltipValue = "";

			// remarks
			$this->remarks->LinkCustomAttributes = "";
			$this->remarks->HrefValue = "";
			$this->remarks->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// assettag
			$this->assettag->EditAttrs["class"] = "form-control";
			$this->assettag->EditCustomAttributes = "";
			$this->assettag->EditValue = ew_HtmlEncode($this->assettag->CurrentValue);
			$this->assettag->PlaceHolder = ew_RemoveHtml($this->assettag->FldCaption());

			// servicetag
			$this->servicetag->EditAttrs["class"] = "form-control";
			$this->servicetag->EditCustomAttributes = "";
			$this->servicetag->EditValue = ew_HtmlEncode($this->servicetag->CurrentValue);
			$this->servicetag->PlaceHolder = ew_RemoveHtml($this->servicetag->FldCaption());

			// ipaddress
			$this->ipaddress->EditAttrs["class"] = "form-control";
			$this->ipaddress->EditCustomAttributes = "";
			$this->ipaddress->EditValue = ew_HtmlEncode($this->ipaddress->CurrentValue);
			$this->ipaddress->PlaceHolder = ew_RemoveHtml($this->ipaddress->FldCaption());

			// employeeno
			$this->employeeno->EditAttrs["class"] = "form-control";
			$this->employeeno->EditCustomAttributes = "";
			$this->employeeno->EditValue = ew_HtmlEncode($this->employeeno->CurrentValue);
			$this->employeeno->PlaceHolder = ew_RemoveHtml($this->employeeno->FldCaption());

			// employeename
			$this->employeename->EditAttrs["class"] = "form-control";
			$this->employeename->EditCustomAttributes = "";
			$this->employeename->EditValue = ew_HtmlEncode($this->employeename->CurrentValue);
			$this->employeename->PlaceHolder = ew_RemoveHtml($this->employeename->FldCaption());

			// company
			$this->company->EditAttrs["class"] = "form-control";
			$this->company->EditCustomAttributes = "";
			$this->company->EditValue = $this->company->Options(TRUE);

			// department
			$this->department->EditAttrs["class"] = "form-control";
			$this->department->EditCustomAttributes = "";
			$this->department->EditValue = ew_HtmlEncode($this->department->CurrentValue);
			$this->department->PlaceHolder = ew_RemoveHtml($this->department->FldCaption());

			// type
			$this->type->EditAttrs["class"] = "form-control";
			$this->type->EditCustomAttributes = "";
			$this->type->EditValue = $this->type->Options(TRUE);

			// model
			$this->model->EditAttrs["class"] = "form-control";
			$this->model->EditCustomAttributes = "";
			$this->model->EditValue = ew_HtmlEncode($this->model->CurrentValue);
			$this->model->PlaceHolder = ew_RemoveHtml($this->model->FldCaption());

			// location
			$this->location->EditAttrs["class"] = "form-control";
			$this->location->EditCustomAttributes = "";
			$this->location->EditValue = ew_HtmlEncode($this->location->CurrentValue);
			$this->location->PlaceHolder = ew_RemoveHtml($this->location->FldCaption());

			// alternateIP
			$this->alternateIP->EditAttrs["class"] = "form-control";
			$this->alternateIP->EditCustomAttributes = "";
			$this->alternateIP->EditValue = ew_HtmlEncode($this->alternateIP->CurrentValue);
			$this->alternateIP->PlaceHolder = ew_RemoveHtml($this->alternateIP->FldCaption());

			// operatingsystem
			$this->operatingsystem->EditAttrs["class"] = "form-control";
			$this->operatingsystem->EditCustomAttributes = "";
			$this->operatingsystem->EditValue = ew_HtmlEncode($this->operatingsystem->CurrentValue);
			$this->operatingsystem->PlaceHolder = ew_RemoveHtml($this->operatingsystem->FldCaption());

			// remarks
			$this->remarks->EditAttrs["class"] = "form-control";
			$this->remarks->EditCustomAttributes = "";
			$this->remarks->EditValue = ew_HtmlEncode($this->remarks->CurrentValue);
			$this->remarks->PlaceHolder = ew_RemoveHtml($this->remarks->FldCaption());

			// officelicense
			$this->officelicense->EditAttrs["class"] = "form-control";
			$this->officelicense->EditCustomAttributes = "";
			$this->officelicense->EditValue = ew_HtmlEncode($this->officelicense->CurrentValue);
			$this->officelicense->PlaceHolder = ew_RemoveHtml($this->officelicense->FldCaption());

			// datereceived
			$this->datereceived->EditAttrs["class"] = "form-control";
			$this->datereceived->EditCustomAttributes = "";
			$this->datereceived->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->datereceived->CurrentValue, 7));
			$this->datereceived->PlaceHolder = ew_RemoveHtml($this->datereceived->FldCaption());

			// serialcode
			$this->serialcode->EditAttrs["class"] = "form-control";
			$this->serialcode->EditCustomAttributes = "";
			$this->serialcode->EditValue = ew_HtmlEncode($this->serialcode->CurrentValue);
			$this->serialcode->PlaceHolder = ew_RemoveHtml($this->serialcode->FldCaption());

			// latestupdate
			$this->latestupdate->EditAttrs["class"] = "form-control";
			$this->latestupdate->EditCustomAttributes = "";
			$this->latestupdate->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->latestupdate->CurrentValue, 7));
			$this->latestupdate->PlaceHolder = ew_RemoveHtml($this->latestupdate->FldCaption());

			// Add refer script
			// assettag

			$this->assettag->LinkCustomAttributes = "";
			$this->assettag->HrefValue = "";

			// servicetag
			$this->servicetag->LinkCustomAttributes = "";
			$this->servicetag->HrefValue = "";

			// ipaddress
			$this->ipaddress->LinkCustomAttributes = "";
			$this->ipaddress->HrefValue = "";

			// employeeno
			$this->employeeno->LinkCustomAttributes = "";
			$this->employeeno->HrefValue = "";

			// employeename
			$this->employeename->LinkCustomAttributes = "";
			$this->employeename->HrefValue = "";

			// company
			$this->company->LinkCustomAttributes = "";
			$this->company->HrefValue = "";

			// department
			$this->department->LinkCustomAttributes = "";
			$this->department->HrefValue = "";

			// type
			$this->type->LinkCustomAttributes = "";
			$this->type->HrefValue = "";

			// model
			$this->model->LinkCustomAttributes = "";
			$this->model->HrefValue = "";

			// location
			$this->location->LinkCustomAttributes = "";
			$this->location->HrefValue = "";

			// alternateIP
			$this->alternateIP->LinkCustomAttributes = "";
			$this->alternateIP->HrefValue = "";

			// operatingsystem
			$this->operatingsystem->LinkCustomAttributes = "";
			$this->operatingsystem->HrefValue = "";

			// remarks
			$this->remarks->LinkCustomAttributes = "";
			$this->remarks->HrefValue = "";

			// officelicense
			$this->officelicense->LinkCustomAttributes = "";
			$this->officelicense->HrefValue = "";

			// datereceived
			$this->datereceived->LinkCustomAttributes = "";
			$this->datereceived->HrefValue = "";

			// serialcode
			$this->serialcode->LinkCustomAttributes = "";
			$this->serialcode->HrefValue = "";

			// latestupdate
			$this->latestupdate->LinkCustomAttributes = "";
			$this->latestupdate->HrefValue = "";
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

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckEuroDate($this->datereceived->FormValue)) {
			ew_AddMessage($gsFormError, $this->datereceived->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// assettag
		$this->assettag->SetDbValueDef($rsnew, $this->assettag->CurrentValue, NULL, FALSE);

		// servicetag
		$this->servicetag->SetDbValueDef($rsnew, $this->servicetag->CurrentValue, NULL, FALSE);

		// ipaddress
		$this->ipaddress->SetDbValueDef($rsnew, $this->ipaddress->CurrentValue, NULL, FALSE);

		// employeeno
		$this->employeeno->SetDbValueDef($rsnew, $this->employeeno->CurrentValue, NULL, FALSE);

		// employeename
		$this->employeename->SetDbValueDef($rsnew, $this->employeename->CurrentValue, NULL, FALSE);

		// company
		$this->company->SetDbValueDef($rsnew, $this->company->CurrentValue, NULL, FALSE);

		// department
		$this->department->SetDbValueDef($rsnew, $this->department->CurrentValue, NULL, FALSE);

		// type
		$this->type->SetDbValueDef($rsnew, $this->type->CurrentValue, NULL, FALSE);

		// model
		$this->model->SetDbValueDef($rsnew, $this->model->CurrentValue, NULL, FALSE);

		// location
		$this->location->SetDbValueDef($rsnew, $this->location->CurrentValue, NULL, FALSE);

		// alternateIP
		$this->alternateIP->SetDbValueDef($rsnew, $this->alternateIP->CurrentValue, NULL, FALSE);

		// operatingsystem
		$this->operatingsystem->SetDbValueDef($rsnew, $this->operatingsystem->CurrentValue, NULL, FALSE);

		// remarks
		$this->remarks->SetDbValueDef($rsnew, $this->remarks->CurrentValue, NULL, FALSE);

		// officelicense
		$this->officelicense->SetDbValueDef($rsnew, $this->officelicense->CurrentValue, NULL, FALSE);

		// datereceived
		$this->datereceived->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->datereceived->CurrentValue, 7), NULL, FALSE);

		// serialcode
		$this->serialcode->SetDbValueDef($rsnew, $this->serialcode->CurrentValue, NULL, FALSE);

		// latestupdate
		$this->latestupdate->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->latestupdate->CurrentValue, 7), NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->no->setDbValue($conn->Insert_ID());
				$rsnew['no'] = $this->no->DbValue;
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("itassetassetmasterlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($assetmaster_add)) $assetmaster_add = new cassetmaster_add();

// Page init
$assetmaster_add->Page_Init();

// Page main
$assetmaster_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$assetmaster_add->Page_Render();
?>
<?php include_once "itassetheader.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fassetmasteradd = new ew_Form("fassetmasteradd", "add");

// Validate form
fassetmasteradd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_datereceived");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($assetmaster->datereceived->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fassetmasteradd.Form_CustomValidate =
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fassetmasteradd.ValidateRequired = true;
<?php } else { ?>
fassetmasteradd.ValidateRequired = false;
<?php } ?>

// Dynamic selection lists
fassetmasteradd.Lists["x_company"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fassetmasteradd.Lists["x_company"].Options = <?php echo json_encode($assetmaster->company->Options()) ?>;
fassetmasteradd.Lists["x_type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fassetmasteradd.Lists["x_type"].Options = <?php echo json_encode($assetmaster->type->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $assetmaster_add->ShowPageHeader(); ?>
<?php
$assetmaster_add->ShowMessage();
?>
<form name="fassetmasteradd" id="fassetmasteradd" class="<?php echo $assetmaster_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($assetmaster_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $assetmaster_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="assetmaster">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($assetmaster->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } ?>
<div>
<?php if ($assetmaster->assettag->Visible) { // assettag ?>
	<div id="r_assettag" class="form-group">
		<label id="elh_assetmaster_assettag" for="x_assettag" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->assettag->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->assettag->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_assettag">
<input type="text" data-table="assetmaster" data-field="x_assettag" name="x_assettag" id="x_assettag" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($assetmaster->assettag->getPlaceHolder()) ?>" value="<?php echo $assetmaster->assettag->EditValue ?>"<?php echo $assetmaster->assettag->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_assetmaster_assettag">
<span<?php echo $assetmaster->assettag->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->assettag->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_assettag" name="x_assettag" id="x_assettag" value="<?php echo ew_HtmlEncode($assetmaster->assettag->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->assettag->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->servicetag->Visible) { // servicetag ?>
	<div id="r_servicetag" class="form-group">
		<label id="elh_assetmaster_servicetag" for="x_servicetag" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->servicetag->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->servicetag->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_servicetag">
<input type="text" data-table="assetmaster" data-field="x_servicetag" name="x_servicetag" id="x_servicetag" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($assetmaster->servicetag->getPlaceHolder()) ?>" value="<?php echo $assetmaster->servicetag->EditValue ?>"<?php echo $assetmaster->servicetag->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_assetmaster_servicetag">
<span<?php echo $assetmaster->servicetag->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->servicetag->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_servicetag" name="x_servicetag" id="x_servicetag" value="<?php echo ew_HtmlEncode($assetmaster->servicetag->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->servicetag->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->ipaddress->Visible) { // ipaddress ?>
	<div id="r_ipaddress" class="form-group">
		<label id="elh_assetmaster_ipaddress" for="x_ipaddress" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->ipaddress->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->ipaddress->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_ipaddress">
<input type="text" data-table="assetmaster" data-field="x_ipaddress" name="x_ipaddress" id="x_ipaddress" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($assetmaster->ipaddress->getPlaceHolder()) ?>" value="<?php echo $assetmaster->ipaddress->EditValue ?>"<?php echo $assetmaster->ipaddress->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_assetmaster_ipaddress">
<span<?php echo $assetmaster->ipaddress->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->ipaddress->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_ipaddress" name="x_ipaddress" id="x_ipaddress" value="<?php echo ew_HtmlEncode($assetmaster->ipaddress->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->ipaddress->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->employeeno->Visible) { // employeeno ?>
	<div id="r_employeeno" class="form-group">
		<label id="elh_assetmaster_employeeno" for="x_employeeno" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->employeeno->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->employeeno->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_employeeno">
<input type="text" data-table="assetmaster" data-field="x_employeeno" name="x_employeeno" id="x_employeeno" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($assetmaster->employeeno->getPlaceHolder()) ?>" value="<?php echo $assetmaster->employeeno->EditValue ?>"<?php echo $assetmaster->employeeno->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_assetmaster_employeeno">
<span<?php echo $assetmaster->employeeno->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->employeeno->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_employeeno" name="x_employeeno" id="x_employeeno" value="<?php echo ew_HtmlEncode($assetmaster->employeeno->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->employeeno->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->employeename->Visible) { // employeename ?>
	<div id="r_employeename" class="form-group">
		<label id="elh_assetmaster_employeename" for="x_employeename" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->employeename->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->employeename->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_employeename">
<input type="text" data-table="assetmaster" data-field="x_employeename" name="x_employeename" id="x_employeename" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($assetmaster->employeename->getPlaceHolder()) ?>" value="<?php echo $assetmaster->employeename->EditValue ?>"<?php echo $assetmaster->employeename->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_assetmaster_employeename">
<span<?php echo $assetmaster->employeename->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->employeename->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_employeename" name="x_employeename" id="x_employeename" value="<?php echo ew_HtmlEncode($assetmaster->employeename->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->employeename->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->company->Visible) { // company ?>
	<div id="r_company" class="form-group">
		<label id="elh_assetmaster_company" for="x_company" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->company->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->company->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_company">
<select data-table="assetmaster" data-field="x_company" data-value-separator="<?php echo ew_HtmlEncode(is_array($assetmaster->company->DisplayValueSeparator) ? json_encode($assetmaster->company->DisplayValueSeparator) : $assetmaster->company->DisplayValueSeparator) ?>" id="x_company" name="x_company"<?php echo $assetmaster->company->EditAttributes() ?>>
<?php
if (is_array($assetmaster->company->EditValue)) {
	$arwrk = $assetmaster->company->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($assetmaster->company->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $assetmaster->company->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($assetmaster->company->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($assetmaster->company->CurrentValue) ?>" selected><?php echo $assetmaster->company->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php } else { ?>
<span id="el_assetmaster_company">
<span<?php echo $assetmaster->company->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->company->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_company" name="x_company" id="x_company" value="<?php echo ew_HtmlEncode($assetmaster->company->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->company->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->department->Visible) { // department ?>
	<div id="r_department" class="form-group">
		<label id="elh_assetmaster_department" for="x_department" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->department->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->department->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_department">
<input type="text" data-table="assetmaster" data-field="x_department" name="x_department" id="x_department" size="30" maxlength="75" placeholder="<?php echo ew_HtmlEncode($assetmaster->department->getPlaceHolder()) ?>" value="<?php echo $assetmaster->department->EditValue ?>"<?php echo $assetmaster->department->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_assetmaster_department">
<span<?php echo $assetmaster->department->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->department->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_department" name="x_department" id="x_department" value="<?php echo ew_HtmlEncode($assetmaster->department->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->department->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->type->Visible) { // type ?>
	<div id="r_type" class="form-group">
		<label id="elh_assetmaster_type" for="x_type" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->type->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->type->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_type">
<select data-table="assetmaster" data-field="x_type" data-value-separator="<?php echo ew_HtmlEncode(is_array($assetmaster->type->DisplayValueSeparator) ? json_encode($assetmaster->type->DisplayValueSeparator) : $assetmaster->type->DisplayValueSeparator) ?>" id="x_type" name="x_type"<?php echo $assetmaster->type->EditAttributes() ?>>
<?php
if (is_array($assetmaster->type->EditValue)) {
	$arwrk = $assetmaster->type->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($assetmaster->type->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $assetmaster->type->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($assetmaster->type->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($assetmaster->type->CurrentValue) ?>" selected><?php echo $assetmaster->type->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php } else { ?>
<span id="el_assetmaster_type">
<span<?php echo $assetmaster->type->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->type->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_type" name="x_type" id="x_type" value="<?php echo ew_HtmlEncode($assetmaster->type->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->model->Visible) { // model ?>
	<div id="r_model" class="form-group">
		<label id="elh_assetmaster_model" for="x_model" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->model->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->model->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_model">
<input type="text" data-table="assetmaster" data-field="x_model" name="x_model" id="x_model" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($assetmaster->model->getPlaceHolder()) ?>" value="<?php echo $assetmaster->model->EditValue ?>"<?php echo $assetmaster->model->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_assetmaster_model">
<span<?php echo $assetmaster->model->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->model->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_model" name="x_model" id="x_model" value="<?php echo ew_HtmlEncode($assetmaster->model->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->model->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->location->Visible) { // location ?>
	<div id="r_location" class="form-group">
		<label id="elh_assetmaster_location" for="x_location" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->location->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->location->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_location">
<input type="text" data-table="assetmaster" data-field="x_location" name="x_location" id="x_location" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($assetmaster->location->getPlaceHolder()) ?>" value="<?php echo $assetmaster->location->EditValue ?>"<?php echo $assetmaster->location->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_assetmaster_location">
<span<?php echo $assetmaster->location->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->location->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_location" name="x_location" id="x_location" value="<?php echo ew_HtmlEncode($assetmaster->location->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->location->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->alternateIP->Visible) { // alternateIP ?>
	<div id="r_alternateIP" class="form-group">
		<label id="elh_assetmaster_alternateIP" for="x_alternateIP" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->alternateIP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->alternateIP->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_alternateIP">
<input type="text" data-table="assetmaster" data-field="x_alternateIP" name="x_alternateIP" id="x_alternateIP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($assetmaster->alternateIP->getPlaceHolder()) ?>" value="<?php echo $assetmaster->alternateIP->EditValue ?>"<?php echo $assetmaster->alternateIP->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_assetmaster_alternateIP">
<span<?php echo $assetmaster->alternateIP->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->alternateIP->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_alternateIP" name="x_alternateIP" id="x_alternateIP" value="<?php echo ew_HtmlEncode($assetmaster->alternateIP->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->alternateIP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->operatingsystem->Visible) { // operatingsystem ?>
	<div id="r_operatingsystem" class="form-group">
		<label id="elh_assetmaster_operatingsystem" for="x_operatingsystem" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->operatingsystem->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->operatingsystem->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_operatingsystem">
<input type="text" data-table="assetmaster" data-field="x_operatingsystem" name="x_operatingsystem" id="x_operatingsystem" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($assetmaster->operatingsystem->getPlaceHolder()) ?>" value="<?php echo $assetmaster->operatingsystem->EditValue ?>"<?php echo $assetmaster->operatingsystem->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_assetmaster_operatingsystem">
<span<?php echo $assetmaster->operatingsystem->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->operatingsystem->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_operatingsystem" name="x_operatingsystem" id="x_operatingsystem" value="<?php echo ew_HtmlEncode($assetmaster->operatingsystem->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->operatingsystem->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->remarks->Visible) { // remarks ?>
	<div id="r_remarks" class="form-group">
		<label id="elh_assetmaster_remarks" for="x_remarks" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->remarks->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->remarks->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_remarks">
<textarea data-table="assetmaster" data-field="x_remarks" name="x_remarks" id="x_remarks" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($assetmaster->remarks->getPlaceHolder()) ?>"<?php echo $assetmaster->remarks->EditAttributes() ?>><?php echo $assetmaster->remarks->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el_assetmaster_remarks">
<span<?php echo $assetmaster->remarks->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->remarks->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_remarks" name="x_remarks" id="x_remarks" value="<?php echo ew_HtmlEncode($assetmaster->remarks->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->remarks->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->officelicense->Visible) { // officelicense ?>
	<div id="r_officelicense" class="form-group">
		<label id="elh_assetmaster_officelicense" for="x_officelicense" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->officelicense->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->officelicense->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_officelicense">
<input type="text" data-table="assetmaster" data-field="x_officelicense" name="x_officelicense" id="x_officelicense" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($assetmaster->officelicense->getPlaceHolder()) ?>" value="<?php echo $assetmaster->officelicense->EditValue ?>"<?php echo $assetmaster->officelicense->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_assetmaster_officelicense">
<span<?php echo $assetmaster->officelicense->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->officelicense->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_officelicense" name="x_officelicense" id="x_officelicense" value="<?php echo ew_HtmlEncode($assetmaster->officelicense->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->officelicense->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->datereceived->Visible) { // datereceived ?>
	<div id="r_datereceived" class="form-group">
		<label id="elh_assetmaster_datereceived" for="x_datereceived" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->datereceived->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->datereceived->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_datereceived">
<input type="text" data-table="assetmaster" data-field="x_datereceived" data-format="7" name="x_datereceived" id="x_datereceived" placeholder="<?php echo ew_HtmlEncode($assetmaster->datereceived->getPlaceHolder()) ?>" value="<?php echo $assetmaster->datereceived->EditValue ?>"<?php echo $assetmaster->datereceived->EditAttributes() ?>>
<?php if (!$assetmaster->datereceived->ReadOnly && !$assetmaster->datereceived->Disabled && !isset($assetmaster->datereceived->EditAttrs["readonly"]) && !isset($assetmaster->datereceived->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fassetmasteradd", "x_datereceived", "%d-%m-%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_assetmaster_datereceived">
<span<?php echo $assetmaster->datereceived->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->datereceived->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_datereceived" name="x_datereceived" id="x_datereceived" value="<?php echo ew_HtmlEncode($assetmaster->datereceived->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->datereceived->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->serialcode->Visible) { // serialcode ?>
	<div id="r_serialcode" class="form-group">
		<label id="elh_assetmaster_serialcode" for="x_serialcode" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->serialcode->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->serialcode->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_serialcode">
<input type="text" data-table="assetmaster" data-field="x_serialcode" name="x_serialcode" id="x_serialcode" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($assetmaster->serialcode->getPlaceHolder()) ?>" value="<?php echo $assetmaster->serialcode->EditValue ?>"<?php echo $assetmaster->serialcode->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_assetmaster_serialcode">
<span<?php echo $assetmaster->serialcode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->serialcode->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_serialcode" name="x_serialcode" id="x_serialcode" value="<?php echo ew_HtmlEncode($assetmaster->serialcode->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->serialcode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($assetmaster->latestupdate->Visible) { // latestupdate ?>
	<div id="r_latestupdate" class="form-group">
		<label id="elh_assetmaster_latestupdate" for="x_latestupdate" class="col-sm-2 control-label ewLabel"><?php echo $assetmaster->latestupdate->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $assetmaster->latestupdate->CellAttributes() ?>>
<?php if ($assetmaster->CurrentAction <> "F") { ?>
<span id="el_assetmaster_latestupdate">
<input type="text" data-table="assetmaster" data-field="x_latestupdate" data-format="7" name="x_latestupdate" id="x_latestupdate" placeholder="<?php echo ew_HtmlEncode($assetmaster->latestupdate->getPlaceHolder()) ?>" value="<?php echo $assetmaster->latestupdate->EditValue ?>"<?php echo $assetmaster->latestupdate->EditAttributes() ?>>
<?php if (!$assetmaster->latestupdate->ReadOnly && !$assetmaster->latestupdate->Disabled && !isset($assetmaster->latestupdate->EditAttrs["readonly"]) && !isset($assetmaster->latestupdate->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fassetmasteradd", "x_latestupdate", "%d-%m-%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_assetmaster_latestupdate">
<span<?php echo $assetmaster->latestupdate->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $assetmaster->latestupdate->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="assetmaster" data-field="x_latestupdate" name="x_latestupdate" id="x_latestupdate" value="<?php echo ew_HtmlEncode($assetmaster->latestupdate->FormValue) ?>">
<?php } ?>
<?php echo $assetmaster->latestupdate->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<?php if ($assetmaster->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_add.value='F';"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $assetmaster_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_add.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
	</div>
</div>
</form>
<script type="text/javascript">
fassetmasteradd.Init();
</script>
<?php
$assetmaster_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "itassetfooter.php" ?>
<?php
$assetmaster_add->Page_Terminate();
?>
