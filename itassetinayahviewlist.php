<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "itassetewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "itassetewmysql12.php") ?>
<?php include_once "itassetphpfn12.php" ?>
<?php include_once "itassetinayahviewinfo.php" ?>
<?php include_once "itassetuserinfo.php" ?>
<?php include_once "itassetuserfn12.php" ?>
<?php

//
// Page class
//

$inayahview_list = NULL; // Initialize page object first

class cinayahview_list extends cinayahview {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{6E5D033C-DA34-4C1B-AC0C-D8B1ECCFD39C}";

	// Table name
	var $TableName = 'inayahview';

	// Page object name
	var $PageObjName = 'inayahview_list';

	// Grid form hidden field names
	var $FormName = 'finayahviewlist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (inayahview)
		if (!isset($GLOBALS["inayahview"]) || get_class($GLOBALS["inayahview"]) == "cinayahview") {
			$GLOBALS["inayahview"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["inayahview"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "itassetinayahviewadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "itassetinayahviewdelete.php";
		$this->MultiUpdateUrl = "itassetinayahviewupdate.php";

		// Table object (user)
		if (!isset($GLOBALS['user'])) $GLOBALS['user'] = new cuser();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'inayahview', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (user)
		if (!isset($UserTable)) {
			$UserTable = new cuser();
			$UserTableConn = Conn($UserTable->DBID);
		}

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption finayahviewlistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->no->Visible = !$this->IsAddOrEdit();

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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
		global $EW_EXPORT, $inayahview;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($inayahview);
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 10;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore filter list
			$this->RestoreFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 10; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 10; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 0) {
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->no->AdvancedSearch->ToJSON(), ","); // Field no
		$sFilterList = ew_Concat($sFilterList, $this->assettag->AdvancedSearch->ToJSON(), ","); // Field assettag
		$sFilterList = ew_Concat($sFilterList, $this->servicetag->AdvancedSearch->ToJSON(), ","); // Field servicetag
		$sFilterList = ew_Concat($sFilterList, $this->ipaddress->AdvancedSearch->ToJSON(), ","); // Field ipaddress
		$sFilterList = ew_Concat($sFilterList, $this->employeeno->AdvancedSearch->ToJSON(), ","); // Field employeeno
		$sFilterList = ew_Concat($sFilterList, $this->employeename->AdvancedSearch->ToJSON(), ","); // Field employeename
		$sFilterList = ew_Concat($sFilterList, $this->company->AdvancedSearch->ToJSON(), ","); // Field company
		$sFilterList = ew_Concat($sFilterList, $this->department->AdvancedSearch->ToJSON(), ","); // Field department
		$sFilterList = ew_Concat($sFilterList, $this->type->AdvancedSearch->ToJSON(), ","); // Field type
		$sFilterList = ew_Concat($sFilterList, $this->model->AdvancedSearch->ToJSON(), ","); // Field model
		$sFilterList = ew_Concat($sFilterList, $this->location->AdvancedSearch->ToJSON(), ","); // Field location
		$sFilterList = ew_Concat($sFilterList, $this->alternateIP->AdvancedSearch->ToJSON(), ","); // Field alternateIP
		$sFilterList = ew_Concat($sFilterList, $this->officelicense->AdvancedSearch->ToJSON(), ","); // Field officelicense
		$sFilterList = ew_Concat($sFilterList, $this->operatingsystem->AdvancedSearch->ToJSON(), ","); // Field operatingsystem
		$sFilterList = ew_Concat($sFilterList, $this->remarks->AdvancedSearch->ToJSON(), ","); // Field remarks
		$sFilterList = ew_Concat($sFilterList, $this->datereceived->AdvancedSearch->ToJSON(), ","); // Field datereceived
		$sFilterList = ew_Concat($sFilterList, $this->serialcode->AdvancedSearch->ToJSON(), ","); // Field serialcode
		$sFilterList = ew_Concat($sFilterList, $this->latestupdate->AdvancedSearch->ToJSON(), ","); // Field latestupdate
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}

		// Return filter list in json
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field no
		$this->no->AdvancedSearch->SearchValue = @$filter["x_no"];
		$this->no->AdvancedSearch->SearchOperator = @$filter["z_no"];
		$this->no->AdvancedSearch->SearchCondition = @$filter["v_no"];
		$this->no->AdvancedSearch->SearchValue2 = @$filter["y_no"];
		$this->no->AdvancedSearch->SearchOperator2 = @$filter["w_no"];
		$this->no->AdvancedSearch->Save();

		// Field assettag
		$this->assettag->AdvancedSearch->SearchValue = @$filter["x_assettag"];
		$this->assettag->AdvancedSearch->SearchOperator = @$filter["z_assettag"];
		$this->assettag->AdvancedSearch->SearchCondition = @$filter["v_assettag"];
		$this->assettag->AdvancedSearch->SearchValue2 = @$filter["y_assettag"];
		$this->assettag->AdvancedSearch->SearchOperator2 = @$filter["w_assettag"];
		$this->assettag->AdvancedSearch->Save();

		// Field servicetag
		$this->servicetag->AdvancedSearch->SearchValue = @$filter["x_servicetag"];
		$this->servicetag->AdvancedSearch->SearchOperator = @$filter["z_servicetag"];
		$this->servicetag->AdvancedSearch->SearchCondition = @$filter["v_servicetag"];
		$this->servicetag->AdvancedSearch->SearchValue2 = @$filter["y_servicetag"];
		$this->servicetag->AdvancedSearch->SearchOperator2 = @$filter["w_servicetag"];
		$this->servicetag->AdvancedSearch->Save();

		// Field ipaddress
		$this->ipaddress->AdvancedSearch->SearchValue = @$filter["x_ipaddress"];
		$this->ipaddress->AdvancedSearch->SearchOperator = @$filter["z_ipaddress"];
		$this->ipaddress->AdvancedSearch->SearchCondition = @$filter["v_ipaddress"];
		$this->ipaddress->AdvancedSearch->SearchValue2 = @$filter["y_ipaddress"];
		$this->ipaddress->AdvancedSearch->SearchOperator2 = @$filter["w_ipaddress"];
		$this->ipaddress->AdvancedSearch->Save();

		// Field employeeno
		$this->employeeno->AdvancedSearch->SearchValue = @$filter["x_employeeno"];
		$this->employeeno->AdvancedSearch->SearchOperator = @$filter["z_employeeno"];
		$this->employeeno->AdvancedSearch->SearchCondition = @$filter["v_employeeno"];
		$this->employeeno->AdvancedSearch->SearchValue2 = @$filter["y_employeeno"];
		$this->employeeno->AdvancedSearch->SearchOperator2 = @$filter["w_employeeno"];
		$this->employeeno->AdvancedSearch->Save();

		// Field employeename
		$this->employeename->AdvancedSearch->SearchValue = @$filter["x_employeename"];
		$this->employeename->AdvancedSearch->SearchOperator = @$filter["z_employeename"];
		$this->employeename->AdvancedSearch->SearchCondition = @$filter["v_employeename"];
		$this->employeename->AdvancedSearch->SearchValue2 = @$filter["y_employeename"];
		$this->employeename->AdvancedSearch->SearchOperator2 = @$filter["w_employeename"];
		$this->employeename->AdvancedSearch->Save();

		// Field company
		$this->company->AdvancedSearch->SearchValue = @$filter["x_company"];
		$this->company->AdvancedSearch->SearchOperator = @$filter["z_company"];
		$this->company->AdvancedSearch->SearchCondition = @$filter["v_company"];
		$this->company->AdvancedSearch->SearchValue2 = @$filter["y_company"];
		$this->company->AdvancedSearch->SearchOperator2 = @$filter["w_company"];
		$this->company->AdvancedSearch->Save();

		// Field department
		$this->department->AdvancedSearch->SearchValue = @$filter["x_department"];
		$this->department->AdvancedSearch->SearchOperator = @$filter["z_department"];
		$this->department->AdvancedSearch->SearchCondition = @$filter["v_department"];
		$this->department->AdvancedSearch->SearchValue2 = @$filter["y_department"];
		$this->department->AdvancedSearch->SearchOperator2 = @$filter["w_department"];
		$this->department->AdvancedSearch->Save();

		// Field type
		$this->type->AdvancedSearch->SearchValue = @$filter["x_type"];
		$this->type->AdvancedSearch->SearchOperator = @$filter["z_type"];
		$this->type->AdvancedSearch->SearchCondition = @$filter["v_type"];
		$this->type->AdvancedSearch->SearchValue2 = @$filter["y_type"];
		$this->type->AdvancedSearch->SearchOperator2 = @$filter["w_type"];
		$this->type->AdvancedSearch->Save();

		// Field model
		$this->model->AdvancedSearch->SearchValue = @$filter["x_model"];
		$this->model->AdvancedSearch->SearchOperator = @$filter["z_model"];
		$this->model->AdvancedSearch->SearchCondition = @$filter["v_model"];
		$this->model->AdvancedSearch->SearchValue2 = @$filter["y_model"];
		$this->model->AdvancedSearch->SearchOperator2 = @$filter["w_model"];
		$this->model->AdvancedSearch->Save();

		// Field location
		$this->location->AdvancedSearch->SearchValue = @$filter["x_location"];
		$this->location->AdvancedSearch->SearchOperator = @$filter["z_location"];
		$this->location->AdvancedSearch->SearchCondition = @$filter["v_location"];
		$this->location->AdvancedSearch->SearchValue2 = @$filter["y_location"];
		$this->location->AdvancedSearch->SearchOperator2 = @$filter["w_location"];
		$this->location->AdvancedSearch->Save();

		// Field alternateIP
		$this->alternateIP->AdvancedSearch->SearchValue = @$filter["x_alternateIP"];
		$this->alternateIP->AdvancedSearch->SearchOperator = @$filter["z_alternateIP"];
		$this->alternateIP->AdvancedSearch->SearchCondition = @$filter["v_alternateIP"];
		$this->alternateIP->AdvancedSearch->SearchValue2 = @$filter["y_alternateIP"];
		$this->alternateIP->AdvancedSearch->SearchOperator2 = @$filter["w_alternateIP"];
		$this->alternateIP->AdvancedSearch->Save();

		// Field officelicense
		$this->officelicense->AdvancedSearch->SearchValue = @$filter["x_officelicense"];
		$this->officelicense->AdvancedSearch->SearchOperator = @$filter["z_officelicense"];
		$this->officelicense->AdvancedSearch->SearchCondition = @$filter["v_officelicense"];
		$this->officelicense->AdvancedSearch->SearchValue2 = @$filter["y_officelicense"];
		$this->officelicense->AdvancedSearch->SearchOperator2 = @$filter["w_officelicense"];
		$this->officelicense->AdvancedSearch->Save();

		// Field operatingsystem
		$this->operatingsystem->AdvancedSearch->SearchValue = @$filter["x_operatingsystem"];
		$this->operatingsystem->AdvancedSearch->SearchOperator = @$filter["z_operatingsystem"];
		$this->operatingsystem->AdvancedSearch->SearchCondition = @$filter["v_operatingsystem"];
		$this->operatingsystem->AdvancedSearch->SearchValue2 = @$filter["y_operatingsystem"];
		$this->operatingsystem->AdvancedSearch->SearchOperator2 = @$filter["w_operatingsystem"];
		$this->operatingsystem->AdvancedSearch->Save();

		// Field remarks
		$this->remarks->AdvancedSearch->SearchValue = @$filter["x_remarks"];
		$this->remarks->AdvancedSearch->SearchOperator = @$filter["z_remarks"];
		$this->remarks->AdvancedSearch->SearchCondition = @$filter["v_remarks"];
		$this->remarks->AdvancedSearch->SearchValue2 = @$filter["y_remarks"];
		$this->remarks->AdvancedSearch->SearchOperator2 = @$filter["w_remarks"];
		$this->remarks->AdvancedSearch->Save();

		// Field datereceived
		$this->datereceived->AdvancedSearch->SearchValue = @$filter["x_datereceived"];
		$this->datereceived->AdvancedSearch->SearchOperator = @$filter["z_datereceived"];
		$this->datereceived->AdvancedSearch->SearchCondition = @$filter["v_datereceived"];
		$this->datereceived->AdvancedSearch->SearchValue2 = @$filter["y_datereceived"];
		$this->datereceived->AdvancedSearch->SearchOperator2 = @$filter["w_datereceived"];
		$this->datereceived->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);

		// Field serialcode
		$this->serialcode->AdvancedSearch->SearchValue = @$filter["x_serialcode"];
		$this->serialcode->AdvancedSearch->SearchOperator = @$filter["z_serialcode"];
		$this->serialcode->AdvancedSearch->SearchCondition = @$filter["v_serialcode"];
		$this->serialcode->AdvancedSearch->SearchValue2 = @$filter["y_serialcode"];
		$this->serialcode->AdvancedSearch->SearchOperator2 = @$filter["w_serialcode"];
		$this->serialcode->AdvancedSearch->Save();

		// Field latestupdate
		$this->latestupdate->AdvancedSearch->SearchValue = @$filter["x_latestupdate"];
		$this->latestupdate->AdvancedSearch->SearchOperator = @$filter["z_latestupdate"];
		$this->latestupdate->AdvancedSearch->SearchCondition = @$filter["v_latestupdate"];
		$this->latestupdate->AdvancedSearch->SearchValue2 = @$filter["y_latestupdate"];
		$this->latestupdate->AdvancedSearch->SearchOperator2 = @$filter["w_latestupdate"];
		$this->latestupdate->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->assettag, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->servicetag, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ipaddress, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->employeeno, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->employeename, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->company, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->department, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->type, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->model, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->location, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->alternateIP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->officelicense, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->operatingsystem, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->remarks, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->serialcode, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $arKeywords, $type) {
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if (EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace(EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual && $Fld->FldVirtualSearch) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->no); // no
			$this->UpdateSort($this->assettag); // assettag
			$this->UpdateSort($this->servicetag); // servicetag
			$this->UpdateSort($this->ipaddress); // ipaddress
			$this->UpdateSort($this->employeeno); // employeeno
			$this->UpdateSort($this->employeename); // employeename
			$this->UpdateSort($this->company); // company
			$this->UpdateSort($this->department); // department
			$this->UpdateSort($this->type); // type
			$this->UpdateSort($this->model); // model
			$this->UpdateSort($this->location); // location
			$this->UpdateSort($this->alternateIP); // alternateIP
			$this->UpdateSort($this->officelicense); // officelicense
			$this->UpdateSort($this->operatingsystem); // operatingsystem
			$this->UpdateSort($this->datereceived); // datereceived
			$this->UpdateSort($this->serialcode); // serialcode
				$this->UpdateSort($this->latestupdate); // latestupdate
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->no->setSort("");
				$this->assettag->setSort("");
				$this->servicetag->setSort("");
				$this->ipaddress->setSort("");
				$this->employeeno->setSort("");
				$this->employeename->setSort("");
				$this->company->setSort("");
				$this->department->setSort("");
				$this->type->setSort("");
				$this->model->setSort("");
				$this->location->setSort("");
				$this->alternateIP->setSort("");
				$this->officelicense->setSort("");
				$this->operatingsystem->setSort("");
				$this->datereceived->setSort("");
				$this->serialcode->setSort("");
				$this->latestupdate->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt) {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"finayahviewlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"finayahviewlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.finayahviewlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"finayahviewlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
		$this->officelicense->setDbValue($rs->fields('officelicense'));
		$this->operatingsystem->setDbValue($rs->fields('operatingsystem'));
		$this->remarks->setDbValue($rs->fields('remarks'));
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
		$this->officelicense->DbValue = $row['officelicense'];
		$this->operatingsystem->DbValue = $row['operatingsystem'];
		$this->remarks->DbValue = $row['remarks'];
		$this->datereceived->DbValue = $row['datereceived'];
			$this->serialcode->DbValue = $row['serialcode'];
			$this->latestupdate->DbValue = $row['latestupdate'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;

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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		// officelicense
		// operatingsystem
		// remarks
		// datereceived
		// serialcode
		// latestupdate

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// no
		$this->no->ViewValue = $this->no->CurrentValue;
		$this->no->ViewCustomAttributes = "";

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
		$this->type->ViewValue = $this->type->CurrentValue;
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

		// officelicense
		$this->officelicense->ViewValue = $this->officelicense->CurrentValue;
		$this->officelicense->ViewCustomAttributes = "";

		// operatingsystem
		$this->operatingsystem->ViewValue = $this->operatingsystem->CurrentValue;
		$this->operatingsystem->ViewCustomAttributes = "";

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

			// no
			$this->no->LinkCustomAttributes = "";
			$this->no->HrefValue = "";
			$this->no->TooltipValue = "";

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

			// officelicense
			$this->officelicense->LinkCustomAttributes = "";
			$this->officelicense->HrefValue = "";
			$this->officelicense->TooltipValue = "";

			// operatingsystem
			$this->operatingsystem->LinkCustomAttributes = "";
			$this->operatingsystem->HrefValue = "";
			$this->operatingsystem->TooltipValue = "";

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

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_inayahview\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_inayahview',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.finayahviewlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = TRUE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		if ($this->Export == "email") {
			echo $this->ExportEmail($Doc->Text);
		} else {
			$Doc->Export();
		}
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $Language;
		$sSender = @$_POST["sender"];
		$sRecipient = @$_POST["recipient"];
		$sCc = @$_POST["cc"];
		$sBcc = @$_POST["bcc"];
		$sContentType = @$_POST["contenttype"];

		// Subject
		$sSubject = ew_StripSlashes(@$_POST["subject"]);
		$sEmailSubject = $sSubject;

		// Message
		$sContent = ew_StripSlashes(@$_POST["message"]);
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterSenderEmail") . "</p>";
		}
		if (!ew_CheckEmail($sSender)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperSenderEmail") . "</p>";
		}

		// Check recipient
		if (!ew_CheckEmailList($sRecipient, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperRecipientEmail") . "</p>";
		}

		// Check cc
		if (!ew_CheckEmailList($sCc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperCcEmail") . "</p>";
		}

		// Check bcc
		if (!ew_CheckEmailList($sBcc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperBccEmail") . "</p>";
		}

		// Check email sent count
		if (!isset($_SESSION[EW_EXPORT_EMAIL_COUNTER]))
			$_SESSION[EW_EXPORT_EMAIL_COUNTER] = 0;
		if (intval($_SESSION[EW_EXPORT_EMAIL_COUNTER]) > EW_MAX_EMAIL_SENT_COUNT) {
			return "<p class=\"text-danger\">" . $Language->Phrase("ExceedMaxEmailExport") . "</p>";
		}

		// Send email
		$Email = new cEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		if ($sEmailMessage <> "") {
			$sEmailMessage = ew_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		if ($sContentType == "url") {
			$sUrl = ew_ConvertFullUrl(ew_CurrentPage() . "?" . $this->ExportQueryString());
			$sEmailMessage .= $sUrl; // Send URL only
		} else {
			foreach ($gTmpImages as $tmpimage)
				$Email->AddEmbeddedImage($tmpimage);
			$sEmailMessage .= ew_CleanEmailContent($EmailContent); // Send HTML
		}
		$Email->Content = $sEmailMessage; // Content
		$EventArgs = array();
		if ($this->Recordset) {
			$this->RecCnt = $this->StartRec - 1;
			$this->Recordset->MoveFirst();
			if ($this->StartRec > 1)
				$this->Recordset->Move($this->StartRec - 1);
			$EventArgs["rs"] = &$this->Recordset;
		}
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count
			$_SESSION[EW_EXPORT_EMAIL_COUNTER]++;

			// Sent email success
			return "<p class=\"text-success\">" . $Language->Phrase("SendEmailSuccess") . "</p>"; // Set up success message
		} else {

			// Sent email failure
			return "<p class=\"text-danger\">" . $Email->SendErrDescription . "</p>";
		}
	}

	// Export QueryString
	function ExportQueryString() {

		// Initialize
		$sQry = "export=html";

		// Build QueryString for search
		if ($this->BasicSearch->getKeyword() <> "") {
			$sQry .= "&" . EW_TABLE_BASIC_SEARCH . "=" . urlencode($this->BasicSearch->getKeyword()) . "&" . EW_TABLE_BASIC_SEARCH_TYPE . "=" . urlencode($this->BasicSearch->getType());
		}

		// Build QueryString for pager
		$sQry .= "&" . EW_TABLE_REC_PER_PAGE . "=" . urlencode($this->getRecordsPerPage()) . "&" . EW_TABLE_START_REC . "=" . urlencode($this->getStartRecordNumber());
		return $sQry;
	}

	// Add search QueryString
	function AddSearchQueryString(&$Qry, &$Fld) {
		$FldSearchValue = $Fld->AdvancedSearch->getValue("x");
		$FldParm = substr($Fld->FldVar,2);
		if (strval($FldSearchValue) <> "") {
			$Qry .= "&x_" . $FldParm . "=" . urlencode($FldSearchValue) .
				"&z_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("z"));
		}
		$FldSearchValue2 = $Fld->AdvancedSearch->getValue("y");
		if (strval($FldSearchValue2) <> "") {
			$Qry .= "&v_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("v")) .
				"&y_" . $FldParm . "=" . urlencode($FldSearchValue2) .
				"&w_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("w"));
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

	    //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($inayahview_list)) $inayahview_list = new cinayahview_list();

// Page init
$inayahview_list->Page_Init();

// Page main
$inayahview_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$inayahview_list->Page_Render();
?>
<?php include_once "itassetheader.php" ?>
<?php if ($inayahview->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = finayahviewlist = new ew_Form("finayahviewlist", "list");
finayahviewlist.FormKeyCountName = '<?php echo $inayahview_list->FormKeyCountName ?>';

// Form_CustomValidate event
finayahviewlist.Form_CustomValidate =
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
finayahviewlist.ValidateRequired = true;
<?php } else { ?>
finayahviewlist.ValidateRequired = false;
<?php } ?>

// Dynamic selection lists
finayahviewlist.Lists["x_company"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
finayahviewlist.Lists["x_company"].Options = <?php echo json_encode($inayahview->company->Options()) ?>;

// Form object for search
var CurrentSearchForm = finayahviewlistsrch = new ew_Form("finayahviewlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($inayahview->Export == "") { ?>
<div class="ewToolbar">
<?php if ($inayahview->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($inayahview_list->TotalRecs > 0 && $inayahview_list->ExportOptions->Visible()) { ?>
<?php $inayahview_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($inayahview_list->SearchOptions->Visible()) { ?>
<?php $inayahview_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($inayahview_list->FilterOptions->Visible()) { ?>
<?php $inayahview_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($inayahview->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $inayahview_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($inayahview_list->TotalRecs <= 0)
			$inayahview_list->TotalRecs = $inayahview->SelectRecordCount();
	} else {
		if (!$inayahview_list->Recordset && ($inayahview_list->Recordset = $inayahview_list->LoadRecordset()))
			$inayahview_list->TotalRecs = $inayahview_list->Recordset->RecordCount();
	}
	$inayahview_list->StartRec = 1;
	if ($inayahview_list->DisplayRecs <= 0 || ($inayahview->Export <> "" && $inayahview->ExportAll)) // Display all records
		$inayahview_list->DisplayRecs = $inayahview_list->TotalRecs;
	if (!($inayahview->Export <> "" && $inayahview->ExportAll))
		$inayahview_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$inayahview_list->Recordset = $inayahview_list->LoadRecordset($inayahview_list->StartRec-1, $inayahview_list->DisplayRecs);

	// Set no record found message
	if ($inayahview->CurrentAction == "" && $inayahview_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$inayahview_list->setWarningMessage($Language->Phrase("NoPermission"));
		if ($inayahview_list->SearchWhere == "0=101")
			$inayahview_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$inayahview_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$inayahview_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($inayahview->Export == "" && $inayahview->CurrentAction == "") { ?>
<form name="finayahviewlistsrch" id="finayahviewlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($inayahview_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="finayahviewlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="inayahview">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($inayahview_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($inayahview_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $inayahview_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($inayahview_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($inayahview_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($inayahview_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($inayahview_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $inayahview_list->ShowPageHeader(); ?>
<?php
$inayahview_list->ShowMessage();
?>
<?php if ($inayahview_list->TotalRecs > 0 || $inayahview->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<?php if ($inayahview->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($inayahview->CurrentAction <> "gridadd" && $inayahview->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($inayahview_list->Pager)) $inayahview_list->Pager = new cNumericPager($inayahview_list->StartRec, $inayahview_list->DisplayRecs, $inayahview_list->TotalRecs, $inayahview_list->RecRange) ?>
<?php if ($inayahview_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<div class="ewNumericPage"><ul class="pagination">
	<?php if ($inayahview_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $inayahview_list->PageUrl() ?>start=<?php echo $inayahview_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($inayahview_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $inayahview_list->PageUrl() ?>start=<?php echo $inayahview_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($inayahview_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $inayahview_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($inayahview_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $inayahview_list->PageUrl() ?>start=<?php echo $inayahview_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($inayahview_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $inayahview_list->PageUrl() ?>start=<?php echo $inayahview_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $inayahview_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $inayahview_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $inayahview_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($inayahview_list->TotalRecs > 0) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="inayahview">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm" onchange="this.form.submit();">
<option value="10"<?php if ($inayahview_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($inayahview_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($inayahview_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($inayahview_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($inayahview->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($inayahview_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="finayahviewlist" id="finayahviewlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($inayahview_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $inayahview_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="inayahview">
<div id="gmp_inayahview" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($inayahview_list->TotalRecs > 0) { ?>
<table id="tbl_inayahviewlist" class="table ewTable">
<?php echo $inayahview->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$inayahview_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$inayahview_list->RenderListOptions();

// Render list options (header, left)
$inayahview_list->ListOptions->Render("header", "left");
?>
<?php if ($inayahview->no->Visible) { // no ?>
	<?php if ($inayahview->SortUrl($inayahview->no) == "") { ?>
		<th data-name="no"><div id="elh_inayahview_no" class="inayahview_no"><div class="ewTableHeaderCaption"><?php echo $inayahview->no->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->no) ?>',1);"><div id="elh_inayahview_no" class="inayahview_no">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->no->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->no->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->no->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($inayahview->assettag->Visible) { // assettag ?>
	<?php if ($inayahview->SortUrl($inayahview->assettag) == "") { ?>
		<th data-name="assettag"><div id="elh_inayahview_assettag" class="inayahview_assettag"><div class="ewTableHeaderCaption"><?php echo $inayahview->assettag->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="assettag"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->assettag) ?>',1);"><div id="elh_inayahview_assettag" class="inayahview_assettag">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->assettag->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->assettag->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->assettag->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($inayahview->servicetag->Visible) { // servicetag ?>
	<?php if ($inayahview->SortUrl($inayahview->servicetag) == "") { ?>
		<th data-name="servicetag"><div id="elh_inayahview_servicetag" class="inayahview_servicetag"><div class="ewTableHeaderCaption"><?php echo $inayahview->servicetag->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="servicetag"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->servicetag) ?>',1);"><div id="elh_inayahview_servicetag" class="inayahview_servicetag">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->servicetag->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->servicetag->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->servicetag->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($inayahview->ipaddress->Visible) { // ipaddress ?>
	<?php if ($inayahview->SortUrl($inayahview->ipaddress) == "") { ?>
		<th data-name="ipaddress"><div id="elh_inayahview_ipaddress" class="inayahview_ipaddress"><div class="ewTableHeaderCaption"><?php echo $inayahview->ipaddress->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ipaddress"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->ipaddress) ?>',1);"><div id="elh_inayahview_ipaddress" class="inayahview_ipaddress">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->ipaddress->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->ipaddress->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->ipaddress->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($inayahview->employeeno->Visible) { // employeeno ?>
	<?php if ($inayahview->SortUrl($inayahview->employeeno) == "") { ?>
		<th data-name="employeeno"><div id="elh_inayahview_employeeno" class="inayahview_employeeno"><div class="ewTableHeaderCaption"><?php echo $inayahview->employeeno->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="employeeno"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->employeeno) ?>',1);"><div id="elh_inayahview_employeeno" class="inayahview_employeeno">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->employeeno->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->employeeno->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->employeeno->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($inayahview->employeename->Visible) { // employeename ?>
	<?php if ($inayahview->SortUrl($inayahview->employeename) == "") { ?>
		<th data-name="employeename"><div id="elh_inayahview_employeename" class="inayahview_employeename"><div class="ewTableHeaderCaption"><?php echo $inayahview->employeename->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="employeename"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->employeename) ?>',1);"><div id="elh_inayahview_employeename" class="inayahview_employeename">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->employeename->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->employeename->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->employeename->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($inayahview->company->Visible) { // company ?>
	<?php if ($inayahview->SortUrl($inayahview->company) == "") { ?>
		<th data-name="company"><div id="elh_inayahview_company" class="inayahview_company"><div class="ewTableHeaderCaption"><?php echo $inayahview->company->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="company"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->company) ?>',1);"><div id="elh_inayahview_company" class="inayahview_company">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->company->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->company->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->company->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($inayahview->department->Visible) { // department ?>
	<?php if ($inayahview->SortUrl($inayahview->department) == "") { ?>
		<th data-name="department"><div id="elh_inayahview_department" class="inayahview_department"><div class="ewTableHeaderCaption"><?php echo $inayahview->department->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="department"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->department) ?>',1);"><div id="elh_inayahview_department" class="inayahview_department">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->department->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->department->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->department->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($inayahview->type->Visible) { // type ?>
	<?php if ($inayahview->SortUrl($inayahview->type) == "") { ?>
		<th data-name="type"><div id="elh_inayahview_type" class="inayahview_type"><div class="ewTableHeaderCaption"><?php echo $inayahview->type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="type"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->type) ?>',1);"><div id="elh_inayahview_type" class="inayahview_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->type->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($inayahview->model->Visible) { // model ?>
	<?php if ($inayahview->SortUrl($inayahview->model) == "") { ?>
		<th data-name="model"><div id="elh_inayahview_model" class="inayahview_model"><div class="ewTableHeaderCaption"><?php echo $inayahview->model->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="model"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->model) ?>',1);"><div id="elh_inayahview_model" class="inayahview_model">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->model->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->model->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->model->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($inayahview->location->Visible) { // location ?>
	<?php if ($inayahview->SortUrl($inayahview->location) == "") { ?>
		<th data-name="location"><div id="elh_inayahview_location" class="inayahview_location"><div class="ewTableHeaderCaption"><?php echo $inayahview->location->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="location"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->location) ?>',1);"><div id="elh_inayahview_location" class="inayahview_location">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->location->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->location->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->location->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($inayahview->alternateIP->Visible) { // alternateIP ?>
	<?php if ($inayahview->SortUrl($inayahview->alternateIP) == "") { ?>
		<th data-name="alternateIP"><div id="elh_inayahview_alternateIP" class="inayahview_alternateIP"><div class="ewTableHeaderCaption"><?php echo $inayahview->alternateIP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="alternateIP"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->alternateIP) ?>',1);"><div id="elh_inayahview_alternateIP" class="inayahview_alternateIP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->alternateIP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->alternateIP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->alternateIP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($inayahview->officelicense->Visible) { // officelicense ?>
	<?php if ($inayahview->SortUrl($inayahview->officelicense) == "") { ?>
		<th data-name="officelicense"><div id="elh_inayahview_officelicense" class="inayahview_officelicense"><div class="ewTableHeaderCaption"><?php echo $inayahview->officelicense->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="officelicense"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->officelicense) ?>',1);"><div id="elh_inayahview_officelicense" class="inayahview_officelicense">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->officelicense->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->officelicense->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->officelicense->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($inayahview->operatingsystem->Visible) { // operatingsystem ?>
	<?php if ($inayahview->SortUrl($inayahview->operatingsystem) == "") { ?>
		<th data-name="operatingsystem"><div id="elh_inayahview_operatingsystem" class="inayahview_operatingsystem"><div class="ewTableHeaderCaption"><?php echo $inayahview->operatingsystem->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="operatingsystem"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->operatingsystem) ?>',1);"><div id="elh_inayahview_operatingsystem" class="inayahview_operatingsystem">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->operatingsystem->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->operatingsystem->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->operatingsystem->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($inayahview->datereceived->Visible) { // datereceived ?>
	<?php if ($inayahview->SortUrl($inayahview->datereceived) == "") { ?>
		<th data-name="datereceived"><div id="elh_inayahview_datereceived" class="inayahview_datereceived"><div class="ewTableHeaderCaption"><?php echo $inayahview->datereceived->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="datereceived"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->datereceived) ?>',1);"><div id="elh_inayahview_datereceived" class="inayahview_datereceived">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->datereceived->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->datereceived->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->datereceived->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php } ?>
<?php if ($inayahview->serialcode->Visible) { // serialcode ?>
<?php if ($inayahview->SortUrl($inayahview->serialcode) == "") { ?>
	<th data-name="serialcode"><div id="elh_inayahview_serialcode" class="inayahview_serialcode"><div class="ewTableHeaderCaption"><?php echo $inayahview->serialcode->FldCaption() ?></div></div></th>
<?php } else { ?>
	<th data-name="serialcode"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->serialcode) ?>',1);"><div id="elh_inayahview_serialcode" class="inayahview_serialcode">
		<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->serialcode->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->serialcode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->serialcode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
			</div></div></th>
		<?php } ?>
	<?php } ?>
<?php if ($inayahview->latestupdate->Visible) { // latestupdate ?>
		<?php if ($inayahview->SortUrl($inayahview->latestupdate) == "") { ?>
			<th data-name="latestupdate"><div id="elh_inayahview_latestupdate" class="inayahview_latestupdate"><div class="ewTableHeaderCaption"><?php echo $inayahview->latestupdate->FldCaption() ?></div></div></th>
		<?php } else { ?>
			<th data-name="latestupdate"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $inayahview->SortUrl($inayahview->latestupdate) ?>',1);"><div id="elh_inayahview_latestupdate" class="inayahview_latestupdate">
				<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $inayahview->latestupdate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($inayahview->latestupdate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($inayahview->latestupdate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
					</div></div></th>
<?php } ?>
<?php

// Render list options (header, right)
$inayahview_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($inayahview->ExportAll && $inayahview->Export <> "") {
	$inayahview_list->StopRec = $inayahview_list->TotalRecs;
} else {

	// Set the last record to display
	if ($inayahview_list->TotalRecs > $inayahview_list->StartRec + $inayahview_list->DisplayRecs - 1)
		$inayahview_list->StopRec = $inayahview_list->StartRec + $inayahview_list->DisplayRecs - 1;
	else
		$inayahview_list->StopRec = $inayahview_list->TotalRecs;
}
$inayahview_list->RecCnt = $inayahview_list->StartRec - 1;
if ($inayahview_list->Recordset && !$inayahview_list->Recordset->EOF) {
	$inayahview_list->Recordset->MoveFirst();
	$bSelectLimit = $inayahview_list->UseSelectLimit;
	if (!$bSelectLimit && $inayahview_list->StartRec > 1)
		$inayahview_list->Recordset->Move($inayahview_list->StartRec - 1);
} elseif (!$inayahview->AllowAddDeleteRow && $inayahview_list->StopRec == 0) {
	$inayahview_list->StopRec = $inayahview->GridAddRowCount;
}

// Initialize aggregate
$inayahview->RowType = EW_ROWTYPE_AGGREGATEINIT;
$inayahview->ResetAttrs();
$inayahview_list->RenderRow();
while ($inayahview_list->RecCnt < $inayahview_list->StopRec) {
	$inayahview_list->RecCnt++;
	if (intval($inayahview_list->RecCnt) >= intval($inayahview_list->StartRec)) {
		$inayahview_list->RowCnt++;

		// Set up key count
		$inayahview_list->KeyCount = $inayahview_list->RowIndex;

		// Init row class and style
		$inayahview->ResetAttrs();
		$inayahview->CssClass = "";
		if ($inayahview->CurrentAction == "gridadd") {
		} else {
			$inayahview_list->LoadRowValues($inayahview_list->Recordset); // Load row values
		}
		$inayahview->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$inayahview->RowAttrs = array_merge($inayahview->RowAttrs, array('data-rowindex'=>$inayahview_list->RowCnt, 'id'=>'r' . $inayahview_list->RowCnt . '_inayahview', 'data-rowtype'=>$inayahview->RowType));

		// Render row
		$inayahview_list->RenderRow();

		// Render list options
		$inayahview_list->RenderListOptions();
?>
	<tr<?php echo $inayahview->RowAttributes() ?>>
<?php

// Render list options (body, left)
$inayahview_list->ListOptions->Render("body", "left", $inayahview_list->RowCnt);
?>
	<?php if ($inayahview->no->Visible) { // no ?>
		<td data-name="no"<?php echo $inayahview->no->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_no" class="inayahview_no">
<span<?php echo $inayahview->no->ViewAttributes() ?>>
<?php echo $inayahview->no->ListViewValue() ?></span>
</span>
<a id="<?php echo $inayahview_list->PageObjName . "_row_" . $inayahview_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($inayahview->assettag->Visible) { // assettag ?>
		<td data-name="assettag"<?php echo $inayahview->assettag->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_assettag" class="inayahview_assettag">
<span<?php echo $inayahview->assettag->ViewAttributes() ?>>
<?php echo $inayahview->assettag->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($inayahview->servicetag->Visible) { // servicetag ?>
		<td data-name="servicetag"<?php echo $inayahview->servicetag->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_servicetag" class="inayahview_servicetag">
<span<?php echo $inayahview->servicetag->ViewAttributes() ?>>
<?php echo $inayahview->servicetag->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($inayahview->ipaddress->Visible) { // ipaddress ?>
		<td data-name="ipaddress"<?php echo $inayahview->ipaddress->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_ipaddress" class="inayahview_ipaddress">
<span<?php echo $inayahview->ipaddress->ViewAttributes() ?>>
<?php echo $inayahview->ipaddress->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($inayahview->employeeno->Visible) { // employeeno ?>
		<td data-name="employeeno"<?php echo $inayahview->employeeno->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_employeeno" class="inayahview_employeeno">
<span<?php echo $inayahview->employeeno->ViewAttributes() ?>>
<?php echo $inayahview->employeeno->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($inayahview->employeename->Visible) { // employeename ?>
		<td data-name="employeename"<?php echo $inayahview->employeename->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_employeename" class="inayahview_employeename">
<span<?php echo $inayahview->employeename->ViewAttributes() ?>>
<?php echo $inayahview->employeename->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($inayahview->company->Visible) { // company ?>
		<td data-name="company"<?php echo $inayahview->company->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_company" class="inayahview_company">
<span<?php echo $inayahview->company->ViewAttributes() ?>>
<?php echo $inayahview->company->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($inayahview->department->Visible) { // department ?>
		<td data-name="department"<?php echo $inayahview->department->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_department" class="inayahview_department">
<span<?php echo $inayahview->department->ViewAttributes() ?>>
<?php echo $inayahview->department->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($inayahview->type->Visible) { // type ?>
		<td data-name="type"<?php echo $inayahview->type->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_type" class="inayahview_type">
<span<?php echo $inayahview->type->ViewAttributes() ?>>
<?php echo $inayahview->type->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($inayahview->model->Visible) { // model ?>
		<td data-name="model"<?php echo $inayahview->model->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_model" class="inayahview_model">
<span<?php echo $inayahview->model->ViewAttributes() ?>>
<?php echo $inayahview->model->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($inayahview->location->Visible) { // location ?>
		<td data-name="location"<?php echo $inayahview->location->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_location" class="inayahview_location">
<span<?php echo $inayahview->location->ViewAttributes() ?>>
<?php echo $inayahview->location->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($inayahview->alternateIP->Visible) { // alternateIP ?>
		<td data-name="alternateIP"<?php echo $inayahview->alternateIP->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_alternateIP" class="inayahview_alternateIP">
<span<?php echo $inayahview->alternateIP->ViewAttributes() ?>>
<?php echo $inayahview->alternateIP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($inayahview->officelicense->Visible) { // officelicense ?>
		<td data-name="officelicense"<?php echo $inayahview->officelicense->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_officelicense" class="inayahview_officelicense">
<span<?php echo $inayahview->officelicense->ViewAttributes() ?>>
<?php echo $inayahview->officelicense->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($inayahview->operatingsystem->Visible) { // operatingsystem ?>
		<td data-name="operatingsystem"<?php echo $inayahview->operatingsystem->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_operatingsystem" class="inayahview_operatingsystem">
<span<?php echo $inayahview->operatingsystem->ViewAttributes() ?>>
<?php echo $inayahview->operatingsystem->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($inayahview->datereceived->Visible) { // datereceived ?>
		<td data-name="datereceived"<?php echo $inayahview->datereceived->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_datereceived" class="inayahview_datereceived">
<span<?php echo $inayahview->datereceived->ViewAttributes() ?>>
<?php echo $inayahview->datereceived->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($inayahview->serialcode->Visible) { // serialcode ?>
	<td data-name="serialcode"<?php echo $inayahview->serialcode->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_serialcode" class="inayahview_serialcode">
<span<?php echo $inayahview->serialcode->ViewAttributes() ?>>
<?php echo $inayahview->serialcode->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($inayahview->latestupdate->Visible) { // latestupdate ?>
	<td data-name="latestupdate"<?php echo $inayahview->latestupdated->CellAttributes() ?>>
<span id="el<?php echo $inayahview_list->RowCnt ?>_inayahview_latestupdate" class="inayahview_latestupdate">
<span<?php echo $inayahview->latestupdate->ViewAttributes() ?>>
<?php echo $inayahview->latestupdate->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$inayahview_list->ListOptions->Render("body", "right", $inayahview_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($inayahview->CurrentAction <> "gridadd")
		$inayahview_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($inayahview->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($inayahview_list->Recordset)
	$inayahview_list->Recordset->Close();
?>
<?php if ($inayahview->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($inayahview->CurrentAction <> "gridadd" && $inayahview->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($inayahview_list->Pager)) $inayahview_list->Pager = new cNumericPager($inayahview_list->StartRec, $inayahview_list->DisplayRecs, $inayahview_list->TotalRecs, $inayahview_list->RecRange) ?>
<?php if ($inayahview_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<div class="ewNumericPage"><ul class="pagination">
	<?php if ($inayahview_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $inayahview_list->PageUrl() ?>start=<?php echo $inayahview_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($inayahview_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $inayahview_list->PageUrl() ?>start=<?php echo $inayahview_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($inayahview_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $inayahview_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($inayahview_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $inayahview_list->PageUrl() ?>start=<?php echo $inayahview_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($inayahview_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $inayahview_list->PageUrl() ?>start=<?php echo $inayahview_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $inayahview_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $inayahview_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $inayahview_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($inayahview_list->TotalRecs > 0) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="inayahview">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm" onchange="this.form.submit();">
<option value="10"<?php if ($inayahview_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($inayahview_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($inayahview_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($inayahview_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($inayahview->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($inayahview_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($inayahview_list->TotalRecs == 0 && $inayahview->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($inayahview_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($inayahview->Export == "") { ?>
<script type="text/javascript">
finayahviewlistsrch.Init();
finayahviewlistsrch.FilterList = <?php echo $inayahview_list->GetFilterList() ?>;
finayahviewlist.Init();
</script>
<?php } ?>
<?php
$inayahview_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($inayahview->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "itassetfooter.php" ?>
<?php
$inayahview_list->Page_Terminate();
?>
