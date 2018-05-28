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

$assetmaster_delete = NULL; // Initialize page object first

class cassetmaster_delete extends cassetmaster {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{6E5D033C-DA34-4C1B-AC0C-D8B1ECCFD39C}";

	// Table name
	var $TableName = 'assetmaster';

	// Page object name
	var $PageObjName = 'assetmaster_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("itassetassetmasterlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("itassetlogin.php"));
		}
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("itassetassetmasterlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in assetmaster class, assetmasterinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// no

		$this->no->CellCssStyle = "white-space: nowrap;";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['no'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("itassetassetmasterlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($assetmaster_delete)) $assetmaster_delete = new cassetmaster_delete();

// Page init
$assetmaster_delete->Page_Init();

// Page main
$assetmaster_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$assetmaster_delete->Page_Render();
?>
<?php include_once "itassetheader.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fassetmasterdelete = new ew_Form("fassetmasterdelete", "delete");

// Form_CustomValidate event
fassetmasterdelete.Form_CustomValidate =
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fassetmasterdelete.ValidateRequired = true;
<?php } else { ?>
fassetmasterdelete.ValidateRequired = false;
<?php } ?>

// Dynamic selection lists
fassetmasterdelete.Lists["x_company"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fassetmasterdelete.Lists["x_company"].Options = <?php echo json_encode($assetmaster->company->Options()) ?>;
fassetmasterdelete.Lists["x_type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fassetmasterdelete.Lists["x_type"].Options = <?php echo json_encode($assetmaster->type->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($assetmaster_delete->Recordset = $assetmaster_delete->LoadRecordset())
	$assetmaster_deleteTotalRecs = $assetmaster_delete->Recordset->RecordCount(); // Get record count
if ($assetmaster_deleteTotalRecs <= 0) { // No record found, exit
	if ($assetmaster_delete->Recordset)
		$assetmaster_delete->Recordset->Close();
	$assetmaster_delete->Page_Terminate("itassetassetmasterlist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $assetmaster_delete->ShowPageHeader(); ?>
<?php
$assetmaster_delete->ShowMessage();
?>
<form name="fassetmasterdelete" id="fassetmasterdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($assetmaster_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $assetmaster_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="assetmaster">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($assetmaster_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $assetmaster->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($assetmaster->assettag->Visible) { // assettag ?>
		<th><span id="elh_assetmaster_assettag" class="assetmaster_assettag"><?php echo $assetmaster->assettag->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->servicetag->Visible) { // servicetag ?>
		<th><span id="elh_assetmaster_servicetag" class="assetmaster_servicetag"><?php echo $assetmaster->servicetag->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->ipaddress->Visible) { // ipaddress ?>
		<th><span id="elh_assetmaster_ipaddress" class="assetmaster_ipaddress"><?php echo $assetmaster->ipaddress->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->employeeno->Visible) { // employeeno ?>
		<th><span id="elh_assetmaster_employeeno" class="assetmaster_employeeno"><?php echo $assetmaster->employeeno->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->employeename->Visible) { // employeename ?>
		<th><span id="elh_assetmaster_employeename" class="assetmaster_employeename"><?php echo $assetmaster->employeename->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->company->Visible) { // company ?>
		<th><span id="elh_assetmaster_company" class="assetmaster_company"><?php echo $assetmaster->company->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->department->Visible) { // department ?>
		<th><span id="elh_assetmaster_department" class="assetmaster_department"><?php echo $assetmaster->department->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->type->Visible) { // type ?>
		<th><span id="elh_assetmaster_type" class="assetmaster_type"><?php echo $assetmaster->type->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->model->Visible) { // model ?>
		<th><span id="elh_assetmaster_model" class="assetmaster_model"><?php echo $assetmaster->model->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->location->Visible) { // location ?>
		<th><span id="elh_assetmaster_location" class="assetmaster_location"><?php echo $assetmaster->location->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->alternateIP->Visible) { // alternateIP ?>
		<th><span id="elh_assetmaster_alternateIP" class="assetmaster_alternateIP"><?php echo $assetmaster->alternateIP->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->operatingsystem->Visible) { // operatingsystem ?>
		<th><span id="elh_assetmaster_operatingsystem" class="assetmaster_operatingsystem"><?php echo $assetmaster->operatingsystem->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->officelicense->Visible) { // officelicense ?>
		<th><span id="elh_assetmaster_officelicense" class="assetmaster_officelicense"><?php echo $assetmaster->officelicense->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->datereceived->Visible) { // datereceived ?>
		<th><span id="elh_assetmaster_datereceived" class="assetmaster_datereceived"><?php echo $assetmaster->datereceived->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->serialcode->Visible) { // serialcode ?>
		<th><span id="elh_assetmaster_serialcode" class="assetmaster_serialcode"><?php echo $assetmaster->serialcode->FldCaption() ?></span></th>
<?php } ?>
<?php if ($assetmaster->latestupdate->Visible) { // latestupdate ?>
		<th><span id="elh_assetmaster_latestupdate" class="assetmaster_latestupdate"><?php echo $assetmaster->latestupdate->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$assetmaster_delete->RecCnt = 0;
$i = 0;
while (!$assetmaster_delete->Recordset->EOF) {
	$assetmaster_delete->RecCnt++;
	$assetmaster_delete->RowCnt++;

	// Set row properties
	$assetmaster->ResetAttrs();
	$assetmaster->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$assetmaster_delete->LoadRowValues($assetmaster_delete->Recordset);

	// Render row
	$assetmaster_delete->RenderRow();
?>
	<tr<?php echo $assetmaster->RowAttributes() ?>>
<?php if ($assetmaster->assettag->Visible) { // assettag ?>
		<td<?php echo $assetmaster->assettag->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_assettag" class="assetmaster_assettag">
<span<?php echo $assetmaster->assettag->ViewAttributes() ?>>
<?php echo $assetmaster->assettag->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->servicetag->Visible) { // servicetag ?>
		<td<?php echo $assetmaster->servicetag->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_servicetag" class="assetmaster_servicetag">
<span<?php echo $assetmaster->servicetag->ViewAttributes() ?>>
<?php echo $assetmaster->servicetag->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->ipaddress->Visible) { // ipaddress ?>
		<td<?php echo $assetmaster->ipaddress->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_ipaddress" class="assetmaster_ipaddress">
<span<?php echo $assetmaster->ipaddress->ViewAttributes() ?>>
<?php echo $assetmaster->ipaddress->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->employeeno->Visible) { // employeeno ?>
		<td<?php echo $assetmaster->employeeno->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_employeeno" class="assetmaster_employeeno">
<span<?php echo $assetmaster->employeeno->ViewAttributes() ?>>
<?php echo $assetmaster->employeeno->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->employeename->Visible) { // employeename ?>
		<td<?php echo $assetmaster->employeename->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_employeename" class="assetmaster_employeename">
<span<?php echo $assetmaster->employeename->ViewAttributes() ?>>
<?php echo $assetmaster->employeename->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->company->Visible) { // company ?>
		<td<?php echo $assetmaster->company->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_company" class="assetmaster_company">
<span<?php echo $assetmaster->company->ViewAttributes() ?>>
<?php echo $assetmaster->company->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->department->Visible) { // department ?>
		<td<?php echo $assetmaster->department->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_department" class="assetmaster_department">
<span<?php echo $assetmaster->department->ViewAttributes() ?>>
<?php echo $assetmaster->department->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->type->Visible) { // type ?>
		<td<?php echo $assetmaster->type->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_type" class="assetmaster_type">
<span<?php echo $assetmaster->type->ViewAttributes() ?>>
<?php echo $assetmaster->type->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->model->Visible) { // model ?>
		<td<?php echo $assetmaster->model->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_model" class="assetmaster_model">
<span<?php echo $assetmaster->model->ViewAttributes() ?>>
<?php echo $assetmaster->model->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->location->Visible) { // location ?>
		<td<?php echo $assetmaster->location->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_location" class="assetmaster_location">
<span<?php echo $assetmaster->location->ViewAttributes() ?>>
<?php echo $assetmaster->location->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->alternateIP->Visible) { // alternateIP ?>
		<td<?php echo $assetmaster->alternateIP->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_alternateIP" class="assetmaster_alternateIP">
<span<?php echo $assetmaster->alternateIP->ViewAttributes() ?>>
<?php echo $assetmaster->alternateIP->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->operatingsystem->Visible) { // operatingsystem ?>
		<td<?php echo $assetmaster->operatingsystem->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_operatingsystem" class="assetmaster_operatingsystem">
<span<?php echo $assetmaster->operatingsystem->ViewAttributes() ?>>
<?php echo $assetmaster->operatingsystem->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->officelicense->Visible) { // officelicense ?>
		<td<?php echo $assetmaster->officelicense->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_officelicense" class="assetmaster_officelicense">
<span<?php echo $assetmaster->officelicense->ViewAttributes() ?>>
<?php echo $assetmaster->officelicense->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->datereceived->Visible) { // datereceived ?>
		<td<?php echo $assetmaster->datereceived->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_datereceived" class="assetmaster_datereceived">
<span<?php echo $assetmaster->datereceived->ViewAttributes() ?>>
<?php echo $assetmaster->datereceived->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->serialcode->Visible) { // serialcode ?>
		<td<?php echo $assetmaster->serialcode->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_serialcode" class="assetmaster_serialcode">
<span<?php echo $assetmaster->serialcode->ViewAttributes() ?>>
<?php echo $assetmaster->serialcode->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($assetmaster->latestupdate->Visible) { // latestupdate ?>
		<td<?php echo $assetmaster->latestupdate->CellAttributes() ?>>
<span id="el<?php echo $assetmaster_delete->RowCnt ?>_assetmaster_latestupdate" class="assetmaster_latestupdate">
<span<?php echo $assetmaster->latestupdate->ViewAttributes() ?>>
<?php echo $assetmaster->latestupdate->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$assetmaster_delete->Recordset->MoveNext();
}
$assetmaster_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $assetmaster_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fassetmasterdelete.Init();
</script>
<?php
$assetmaster_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "itassetfooter.php" ?>
<?php
$assetmaster_delete->Page_Terminate();
?>
