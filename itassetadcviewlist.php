<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "itassetewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "itassetewmysql12.php") ?>
<?php include_once "itassetphpfn12.php" ?>
<?php include_once "itassetadcviewinfo.php" ?>
<?php include_once "itassetuserinfo.php" ?>
<?php include_once "itassetuserfn12.php" ?>
<?php

//
// Page class
//

$adcview_list = NULL; // Initialize page object first

class cadcview_list extends cadcview {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{6E5D033C-DA34-4C1B-AC0C-D8B1ECCFD39C}";

	// Table name
	var $TableName = 'adcview';

	// Page object name
	var $PageObjName = 'adcview_list';

	// Grid form hidden field names
	var $FormName = 'fadcviewlist';
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

		// Table object (adcview)
		if (!isset($GLOBALS["adcview"]) || get_class($GLOBALS["adcview"]) == "cadcview") {
			$GLOBALS["adcview"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["adcview"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "itassetadcviewadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "itassetadcviewdelete.php";
		$this->MultiUpdateUrl = "itassetadcviewupdate.php";

		// Table object (user)
		if (!isset($GLOBALS['user'])) $GLOBALS['user'] = new cuser();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'adcview', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fadcviewlistsrch";

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
		global $EW_EXPORT, $adcview;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($adcview);
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
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Restore filter list
			$this->RestoreFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

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

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
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

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
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
		$sFilterList = ew_Concat($sFilterList, $this->assettag->AdvancedSearch->ToJSON(), ","); // Field assettag
		$sFilterList = ew_Concat($sFilterList, $this->servicetag->AdvancedSearch->ToJSON(), ","); // Field servicetag
		$sFilterList = ew_Concat($sFilterList, $this->ipaddress->AdvancedSearch->ToJSON(), ","); // Field ipaddress
		$sFilterList = ew_Concat($sFilterList, $this->employeeno->AdvancedSearch->ToJSON(), ","); // Field employeeno
		$sFilterList = ew_Concat($sFilterList, $this->employeename->AdvancedSearch->ToJSON(), ","); // Field employeename
		$sFilterList = ew_Concat($sFilterList, $this->type->AdvancedSearch->ToJSON(), ","); // Field type
		$sFilterList = ew_Concat($sFilterList, $this->model->AdvancedSearch->ToJSON(), ","); // Field model
		$sFilterList = ew_Concat($sFilterList, $this->location->AdvancedSearch->ToJSON(), ","); // Field location
		$sFilterList = ew_Concat($sFilterList, $this->serialcode->AdvancedSearch->ToJSON(), ","); // Field officelicense
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

		// Field officelicense
		$this->officelicense->AdvancedSearch->SearchValue = @$filter["x_officelicense"];
		$this->officelicense->AdvancedSearch->SearchOperator = @$filter["z_officelicense"];
		$this->officelicense->AdvancedSearch->SearchCondition = @$filter["v_officelicense"];
		$this->officelicense->AdvancedSearch->SearchValue2 = @$filter["y_officelicense"];
		$this->officelicense->AdvancedSearch->SearchOperator2 = @$filter["w_officelicense"];
		$this->officelicense->AdvancedSearch->Save();

		// Field datereceived
		$this->datereceived->AdvancedSearch->SearchValue = @$filter["x_datereceived"];
		$this->datereceived->AdvancedSearch->SearchOperator = @$filter["z_datereceived"];
		$this->datereceived->AdvancedSearch->SearchCondition = @$filter["v_datereceived"];
		$this->datereceived->AdvancedSearch->SearchValue2 = @$filter["y_datereceived"];
		$this->datereceived->AdvancedSearch->SearchOperator2 = @$filter["w_datereceived"];
		$this->datereceived->AdvancedSearch->Save();

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

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->assettag, $Default, FALSE); // assettag
		$this->BuildSearchSql($sWhere, $this->servicetag, $Default, FALSE); // servicetag
		$this->BuildSearchSql($sWhere, $this->ipaddress, $Default, FALSE); // ipaddress
		$this->BuildSearchSql($sWhere, $this->employeeno, $Default, FALSE); // employeeno
		$this->BuildSearchSql($sWhere, $this->employeename, $Default, FALSE); // employeename
		$this->BuildSearchSql($sWhere, $this->type, $Default, FALSE); // type
		$this->BuildSearchSql($sWhere, $this->model, $Default, FALSE); // model
		$this->BuildSearchSql($sWhere, $this->location, $Default, FALSE); // location
		$this->BuildSearchSql($sWhere, $this->officelicense, $Default, FALSE); // officelicense
		$this->BuildSearchSql($sWhere, $this->datereceived, $Default, FALSE); // datereceived
		$this->BuildSearchSql($sWhere, $this->serialcode, $Default, FALSE); // serialcode
		$this->BuildSearchSql($sWhere, $this->latestupdate, $Default, FALSE); // latestupdate

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->assettag->AdvancedSearch->Save(); // assettag
			$this->servicetag->AdvancedSearch->Save(); // servicetag
			$this->ipaddress->AdvancedSearch->Save(); // ipaddress
			$this->employeeno->AdvancedSearch->Save(); // employeeno
			$this->employeename->AdvancedSearch->Save(); // employeename
			$this->type->AdvancedSearch->Save(); // type
			$this->model->AdvancedSearch->Save(); // model
			$this->location->AdvancedSearch->Save(); // location
			$this->officelicense->AdvancedSearch->Save(); // officelicense
			$this->datereceived->AdvancedSearch->Save(); // datereceived
			$this->serialcode->AdvancedSearch->Save(); // serialcode
			$this->latestupdate->AdvancedSearch->Save(); // latestupdate
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
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
		$this->BuildBasicSearchSQL($sWhere, $this->operatingsystem, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->remarks, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->officelicense, $arKeywords, $type);
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
		if ($this->assettag->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->servicetag->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->ipaddress->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->employeeno->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->employeename->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->type->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->model->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->location->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->officelicense->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->datereceived->AdvancedSearch->IssetSession())
			return TRUE;
			if ($this->serialcode->AdvancedSearch->IssetSession())
				return TRUE;
			if ($this->latestupdate->AdvancedSearch->IssetSession())
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->assettag->AdvancedSearch->UnsetSession();
		$this->servicetag->AdvancedSearch->UnsetSession();
		$this->ipaddress->AdvancedSearch->UnsetSession();
		$this->employeeno->AdvancedSearch->UnsetSession();
		$this->employeename->AdvancedSearch->UnsetSession();
		$this->type->AdvancedSearch->UnsetSession();
		$this->model->AdvancedSearch->UnsetSession();
		$this->location->AdvancedSearch->UnsetSession();
		$this->officelicense->AdvancedSearch->UnsetSession();
		$this->datereceived->AdvancedSearch->UnsetSession();
		$this->serialcode->AdvancedSearch->UnsetSession();
		$this->latestupdate->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
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

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
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
			$this->UpdateSort($this->operatingsystem); // operatingsystem
			$this->UpdateSort($this->officelicense); // officelicense
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
				$this->operatingsystem->setSort("");
				$this->officelicense->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fadcviewlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fadcviewlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fadcviewlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fadcviewlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		if (ew_IsMobile())
			$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"itassetadcviewsrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		else
			$item->Body = "<button type=\"button\" class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" onclick=\"ew_SearchDialogShow({lnk:this,url:'itassetadcviewsrch.php'});\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

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

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// assettag

		$this->assettag->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_assettag"]);
		if ($this->assettag->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->assettag->AdvancedSearch->SearchOperator = @$_GET["z_assettag"];

		// servicetag
		$this->servicetag->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_servicetag"]);
		if ($this->servicetag->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->servicetag->AdvancedSearch->SearchOperator = @$_GET["z_servicetag"];

		// ipaddress
		$this->ipaddress->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_ipaddress"]);
		if ($this->ipaddress->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->ipaddress->AdvancedSearch->SearchOperator = @$_GET["z_ipaddress"];

		// employeeno
		$this->employeeno->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_employeeno"]);
		if ($this->employeeno->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->employeeno->AdvancedSearch->SearchOperator = @$_GET["z_employeeno"];

		// employeename
		$this->employeename->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_employeename"]);
		if ($this->employeename->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->employeename->AdvancedSearch->SearchOperator = @$_GET["z_employeename"];

		// type
		$this->type->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_type"]);
		if ($this->type->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->type->AdvancedSearch->SearchOperator = @$_GET["z_type"];

		// model
		$this->model->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_model"]);
		if ($this->model->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->model->AdvancedSearch->SearchOperator = @$_GET["z_model"];

		// location
		$this->location->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_location"]);
		if ($this->location->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->location->AdvancedSearch->SearchOperator = @$_GET["z_location"];

		// officelicense
		$this->officelicense->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_officelicense"]);
		if ($this->officelicense->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->officelicense->AdvancedSearch->SearchOperator = @$_GET["z_officelicense"];

		// datereceived
		$this->datereceived->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_datereceived"]);
		if ($this->datereceived->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->datereceived->AdvancedSearch->SearchOperator = @$_GET["z_datereceived"];
		$this->datereceived->AdvancedSearch->SearchCondition = @$_GET["v_datereceived"];
		$this->datereceived->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_datereceived"]);
		if ($this->datereceived->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->datereceived->AdvancedSearch->SearchOperator2 = @$_GET["w_datereceived"];

		// serialcode
		$this->serialcode->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_serialcode"]);
		if ($this->serialcode->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->serialcode->AdvancedSearch->SearchOperator = @$_GET["z_serialcode"];

		// latestupdate
		$this->latestupdate->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_latestupdate"]);
		if ($this->latestupdate->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->latestupdate->AdvancedSearch->SearchOperator = @$_GET["z_latestupdate"];
		$this->latestupdate->AdvancedSearch->SearchCondition = @$_GET["v_latestupdate"];
		$this->latestupdate->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_latestupdate"]);
		if ($this->latestupdate->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->latestupdate->AdvancedSearch->SearchOperator2 = @$_GET["w_latestupdate"];
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

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
		$item->Body = "<button id=\"emf_adcview\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_adcview',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fadcviewlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$this->AddSearchQueryString($sQry, $this->assettag); // assettag
		$this->AddSearchQueryString($sQry, $this->servicetag); // servicetag
		$this->AddSearchQueryString($sQry, $this->ipaddress); // ipaddress
		$this->AddSearchQueryString($sQry, $this->employeeno); // employeeno
		$this->AddSearchQueryString($sQry, $this->employeename); // employeename
		$this->AddSearchQueryString($sQry, $this->type); // type
		$this->AddSearchQueryString($sQry, $this->model); // model
		$this->AddSearchQueryString($sQry, $this->location); // location
		$this->AddSearchQueryString($sQry, $this->officelicense); // officelicense
		$this->AddSearchQueryString($sQry, $this->datereceived); // datereceived
		$this->AddSearchQueryString($sQry, $this->serialcode); // serialcode
		$this->AddSearchQueryString($sQry, $this->latestupdate); // latestupdate

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
if (!isset($adcview_list)) $adcview_list = new cadcview_list();

// Page init
$adcview_list->Page_Init();

// Page main
$adcview_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$adcview_list->Page_Render();
?>
<?php include_once "itassetheader.php" ?>
<?php if ($adcview->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fadcviewlist = new ew_Form("fadcviewlist", "list");
fadcviewlist.FormKeyCountName = '<?php echo $adcview_list->FormKeyCountName ?>';

// Form_CustomValidate event
fadcviewlist.Form_CustomValidate =
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fadcviewlist.ValidateRequired = true;
<?php } else { ?>
fadcviewlist.ValidateRequired = false;
<?php } ?>

// Dynamic selection lists
fadcviewlist.Lists["x_type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fadcviewlist.Lists["x_type"].Options = <?php echo json_encode($adcview->type->Options()) ?>;

// Form object for search
var CurrentSearchForm = fadcviewlistsrch = new ew_Form("fadcviewlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($adcview->Export == "") { ?>
<div class="ewToolbar">
<?php if ($adcview->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($adcview_list->TotalRecs > 0 && $adcview_list->ExportOptions->Visible()) { ?>
<?php $adcview_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($adcview_list->SearchOptions->Visible()) { ?>
<?php $adcview_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($adcview_list->FilterOptions->Visible()) { ?>
<?php $adcview_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($adcview->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $adcview_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($adcview_list->TotalRecs <= 0)
			$adcview_list->TotalRecs = $adcview->SelectRecordCount();
	} else {
		if (!$adcview_list->Recordset && ($adcview_list->Recordset = $adcview_list->LoadRecordset()))
			$adcview_list->TotalRecs = $adcview_list->Recordset->RecordCount();
	}
	$adcview_list->StartRec = 1;
	if ($adcview_list->DisplayRecs <= 0 || ($adcview->Export <> "" && $adcview->ExportAll)) // Display all records
		$adcview_list->DisplayRecs = $adcview_list->TotalRecs;
	if (!($adcview->Export <> "" && $adcview->ExportAll))
		$adcview_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$adcview_list->Recordset = $adcview_list->LoadRecordset($adcview_list->StartRec-1, $adcview_list->DisplayRecs);

	// Set no record found message
	if ($adcview->CurrentAction == "" && $adcview_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$adcview_list->setWarningMessage($Language->Phrase("NoPermission"));
		if ($adcview_list->SearchWhere == "0=101")
			$adcview_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$adcview_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$adcview_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($adcview->Export == "" && $adcview->CurrentAction == "") { ?>
<form name="fadcviewlistsrch" id="fadcviewlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($adcview_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fadcviewlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="adcview">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($adcview_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($adcview_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $adcview_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($adcview_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($adcview_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($adcview_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($adcview_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $adcview_list->ShowPageHeader(); ?>
<?php
$adcview_list->ShowMessage();
?>
<?php if ($adcview_list->TotalRecs > 0 || $adcview->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<?php if ($adcview->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($adcview->CurrentAction <> "gridadd" && $adcview->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($adcview_list->Pager)) $adcview_list->Pager = new cNumericPager($adcview_list->StartRec, $adcview_list->DisplayRecs, $adcview_list->TotalRecs, $adcview_list->RecRange) ?>
<?php if ($adcview_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<div class="ewNumericPage"><ul class="pagination">
	<?php if ($adcview_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $adcview_list->PageUrl() ?>start=<?php echo $adcview_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($adcview_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $adcview_list->PageUrl() ?>start=<?php echo $adcview_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($adcview_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $adcview_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($adcview_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $adcview_list->PageUrl() ?>start=<?php echo $adcview_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($adcview_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $adcview_list->PageUrl() ?>start=<?php echo $adcview_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $adcview_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $adcview_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $adcview_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($adcview_list->TotalRecs > 0) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="adcview">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm" onchange="this.form.submit();">
<option value="10"<?php if ($adcview_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($adcview_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($adcview_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($adcview_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($adcview->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($adcview_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fadcviewlist" id="fadcviewlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($adcview_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $adcview_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="adcview">
<div id="gmp_adcview" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($adcview_list->TotalRecs > 0) { ?>
<table id="tbl_adcviewlist" class="table ewTable">
<?php echo $adcview->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$adcview_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$adcview_list->RenderListOptions();

// Render list options (header, left)
$adcview_list->ListOptions->Render("header", "left");
?>
<?php if ($adcview->assettag->Visible) { // assettag ?>
	<?php if ($adcview->SortUrl($adcview->assettag) == "") { ?>
		<th data-name="assettag"><div id="elh_adcview_assettag" class="adcview_assettag"><div class="ewTableHeaderCaption"><?php echo $adcview->assettag->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="assettag"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->assettag) ?>',1);"><div id="elh_adcview_assettag" class="adcview_assettag">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->assettag->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($adcview->assettag->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->assettag->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adcview->servicetag->Visible) { // servicetag ?>
	<?php if ($adcview->SortUrl($adcview->servicetag) == "") { ?>
		<th data-name="servicetag"><div id="elh_adcview_servicetag" class="adcview_servicetag"><div class="ewTableHeaderCaption"><?php echo $adcview->servicetag->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="servicetag"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->servicetag) ?>',1);"><div id="elh_adcview_servicetag" class="adcview_servicetag">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->servicetag->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($adcview->servicetag->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->servicetag->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adcview->ipaddress->Visible) { // ipaddress ?>
	<?php if ($adcview->SortUrl($adcview->ipaddress) == "") { ?>
		<th data-name="ipaddress"><div id="elh_adcview_ipaddress" class="adcview_ipaddress"><div class="ewTableHeaderCaption"><?php echo $adcview->ipaddress->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ipaddress"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->ipaddress) ?>',1);"><div id="elh_adcview_ipaddress" class="adcview_ipaddress">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->ipaddress->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($adcview->ipaddress->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->ipaddress->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adcview->employeeno->Visible) { // employeeno ?>
	<?php if ($adcview->SortUrl($adcview->employeeno) == "") { ?>
		<th data-name="employeeno"><div id="elh_adcview_employeeno" class="adcview_employeeno"><div class="ewTableHeaderCaption"><?php echo $adcview->employeeno->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="employeeno"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->employeeno) ?>',1);"><div id="elh_adcview_employeeno" class="adcview_employeeno">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->employeeno->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($adcview->employeeno->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->employeeno->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adcview->employeename->Visible) { // employeename ?>
	<?php if ($adcview->SortUrl($adcview->employeename) == "") { ?>
		<th data-name="employeename"><div id="elh_adcview_employeename" class="adcview_employeename"><div class="ewTableHeaderCaption"><?php echo $adcview->employeename->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="employeename"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->employeename) ?>',1);"><div id="elh_adcview_employeename" class="adcview_employeename">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->employeename->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($adcview->employeename->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->employeename->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adcview->company->Visible) { // company ?>
	<?php if ($adcview->SortUrl($adcview->company) == "") { ?>
		<th data-name="company"><div id="elh_adcview_company" class="adcview_company"><div class="ewTableHeaderCaption"><?php echo $adcview->company->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="company"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->company) ?>',1);"><div id="elh_adcview_company" class="adcview_company">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->company->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($adcview->company->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->company->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adcview->department->Visible) { // department ?>
	<?php if ($adcview->SortUrl($adcview->department) == "") { ?>
		<th data-name="department"><div id="elh_adcview_department" class="adcview_department"><div class="ewTableHeaderCaption"><?php echo $adcview->department->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="department"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->department) ?>',1);"><div id="elh_adcview_department" class="adcview_department">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->department->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($adcview->department->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->department->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adcview->type->Visible) { // type ?>
	<?php if ($adcview->SortUrl($adcview->type) == "") { ?>
		<th data-name="type"><div id="elh_adcview_type" class="adcview_type"><div class="ewTableHeaderCaption"><?php echo $adcview->type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="type"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->type) ?>',1);"><div id="elh_adcview_type" class="adcview_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($adcview->type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adcview->model->Visible) { // model ?>
	<?php if ($adcview->SortUrl($adcview->model) == "") { ?>
		<th data-name="model"><div id="elh_adcview_model" class="adcview_model"><div class="ewTableHeaderCaption"><?php echo $adcview->model->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="model"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->model) ?>',1);"><div id="elh_adcview_model" class="adcview_model">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->model->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($adcview->model->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->model->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adcview->location->Visible) { // location ?>
	<?php if ($adcview->SortUrl($adcview->location) == "") { ?>
		<th data-name="location"><div id="elh_adcview_location" class="adcview_location"><div class="ewTableHeaderCaption"><?php echo $adcview->location->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="location"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->location) ?>',1);"><div id="elh_adcview_location" class="adcview_location">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->location->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($adcview->location->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->location->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adcview->alternateIP->Visible) { // alternateIP ?>
	<?php if ($adcview->SortUrl($adcview->alternateIP) == "") { ?>
		<th data-name="alternateIP"><div id="elh_adcview_alternateIP" class="adcview_alternateIP"><div class="ewTableHeaderCaption"><?php echo $adcview->alternateIP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="alternateIP"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->alternateIP) ?>',1);"><div id="elh_adcview_alternateIP" class="adcview_alternateIP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->alternateIP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($adcview->alternateIP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->alternateIP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adcview->operatingsystem->Visible) { // operatingsystem ?>
	<?php if ($adcview->SortUrl($adcview->operatingsystem) == "") { ?>
		<th data-name="operatingsystem"><div id="elh_adcview_operatingsystem" class="adcview_operatingsystem"><div class="ewTableHeaderCaption"><?php echo $adcview->operatingsystem->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="operatingsystem"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->operatingsystem) ?>',1);"><div id="elh_adcview_operatingsystem" class="adcview_operatingsystem">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->operatingsystem->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($adcview->operatingsystem->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->operatingsystem->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adcview->officelicense->Visible) { // officelicense ?>
	<?php if ($adcview->SortUrl($adcview->officelicense) == "") { ?>
		<th data-name="officelicense"><div id="elh_adcview_officelicense" class="adcview_officelicense"><div class="ewTableHeaderCaption"><?php echo $adcview->officelicense->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="officelicense"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->officelicense) ?>',1);"><div id="elh_adcview_officelicense" class="adcview_officelicense">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->officelicense->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($adcview->officelicense->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->officelicense->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adcview->datereceived->Visible) { // datereceived ?>
	<?php if ($adcview->SortUrl($adcview->datereceived) == "") { ?>
		<th data-name="datereceived"><div id="elh_adcview_datereceived" class="adcview_datereceived"><div class="ewTableHeaderCaption"><?php echo $adcview->datereceived->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="datereceived"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->datereceived) ?>',1);"><div id="elh_adcview_datereceived" class="adcview_datereceived">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->datereceived->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($adcview->datereceived->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->datereceived->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
 <?php } ?>
<?php } ?>
<?php if ($adcview->serialcode->Visible) { // serialcode ?>
	<?php if ($adcview->SortUrl($adcview->serialcode) == "") { ?>
		<th data-name="serialcode"><div id="elh_adcview_serialcode" class="adcview_serialcode"><div class="ewTableHeaderCaption"><?php echo $adcview->serialcode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="serialcode"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->serialcode) ?>',1);"><div id="elh_adcview_serialcode" class="adcview_serialcode">
				<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->serialcode->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($adcview->serialcode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->serialcode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
				</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($adcview->latestupdate->Visible) { // latestupdate ?>
	<?php if ($adcview->SortUrl($adcview->latestupdate) == "") { ?>
		<th data-name="latestupdate"><div id="elh_adcview_latestupdate" class="adcview_latestupdate"><div class="ewTableHeaderCaption"><?php echo $adcview->latestupdate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="latestupdate"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $adcview->SortUrl($adcview->latestupdate) ?>',1);"><div id="elh_adcview_latestupdate" class="adcview_latestupdate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $adcview->latestupdate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($adcview->latestupdate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($adcview->latestupdate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
				</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$adcview_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($adcview->ExportAll && $adcview->Export <> "") {
	$adcview_list->StopRec = $adcview_list->TotalRecs;
} else {

	// Set the last record to display
	if ($adcview_list->TotalRecs > $adcview_list->StartRec + $adcview_list->DisplayRecs - 1)
		$adcview_list->StopRec = $adcview_list->StartRec + $adcview_list->DisplayRecs - 1;
	else
		$adcview_list->StopRec = $adcview_list->TotalRecs;
}
$adcview_list->RecCnt = $adcview_list->StartRec - 1;
if ($adcview_list->Recordset && !$adcview_list->Recordset->EOF) {
	$adcview_list->Recordset->MoveFirst();
	$bSelectLimit = $adcview_list->UseSelectLimit;
	if (!$bSelectLimit && $adcview_list->StartRec > 1)
		$adcview_list->Recordset->Move($adcview_list->StartRec - 1);
} elseif (!$adcview->AllowAddDeleteRow && $adcview_list->StopRec == 0) {
	$adcview_list->StopRec = $adcview->GridAddRowCount;
}

// Initialize aggregate
$adcview->RowType = EW_ROWTYPE_AGGREGATEINIT;
$adcview->ResetAttrs();
$adcview_list->RenderRow();
while ($adcview_list->RecCnt < $adcview_list->StopRec) {
	$adcview_list->RecCnt++;
	if (intval($adcview_list->RecCnt) >= intval($adcview_list->StartRec)) {
		$adcview_list->RowCnt++;

		// Set up key count
		$adcview_list->KeyCount = $adcview_list->RowIndex;

		// Init row class and style
		$adcview->ResetAttrs();
		$adcview->CssClass = "";
		if ($adcview->CurrentAction == "gridadd") {
		} else {
			$adcview_list->LoadRowValues($adcview_list->Recordset); // Load row values
		}
		$adcview->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$adcview->RowAttrs = array_merge($adcview->RowAttrs, array('data-rowindex'=>$adcview_list->RowCnt, 'id'=>'r' . $adcview_list->RowCnt . '_adcview', 'data-rowtype'=>$adcview->RowType));

		// Render row
		$adcview_list->RenderRow();

		// Render list options
		$adcview_list->RenderListOptions();
?>
	<tr<?php echo $adcview->RowAttributes() ?>>
<?php

// Render list options (body, left)
$adcview_list->ListOptions->Render("body", "left", $adcview_list->RowCnt);
?>
	<?php if ($adcview->assettag->Visible) { // assettag ?>
		<td data-name="assettag"<?php echo $adcview->assettag->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_assettag" class="adcview_assettag">
<span<?php echo $adcview->assettag->ViewAttributes() ?>>
<?php echo $adcview->assettag->ListViewValue() ?></span>
</span>
<a id="<?php echo $adcview_list->PageObjName . "_row_" . $adcview_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($adcview->servicetag->Visible) { // servicetag ?>
		<td data-name="servicetag"<?php echo $adcview->servicetag->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_servicetag" class="adcview_servicetag">
<span<?php echo $adcview->servicetag->ViewAttributes() ?>>
<?php echo $adcview->servicetag->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($adcview->ipaddress->Visible) { // ipaddress ?>
		<td data-name="ipaddress"<?php echo $adcview->ipaddress->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_ipaddress" class="adcview_ipaddress">
<span<?php echo $adcview->ipaddress->ViewAttributes() ?>>
<?php echo $adcview->ipaddress->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($adcview->employeeno->Visible) { // employeeno ?>
		<td data-name="employeeno"<?php echo $adcview->employeeno->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_employeeno" class="adcview_employeeno">
<span<?php echo $adcview->employeeno->ViewAttributes() ?>>
<?php echo $adcview->employeeno->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($adcview->employeename->Visible) { // employeename ?>
		<td data-name="employeename"<?php echo $adcview->employeename->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_employeename" class="adcview_employeename">
<span<?php echo $adcview->employeename->ViewAttributes() ?>>
<?php echo $adcview->employeename->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($adcview->company->Visible) { // company ?>
		<td data-name="company"<?php echo $adcview->company->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_company" class="adcview_company">
<span<?php echo $adcview->company->ViewAttributes() ?>>
<?php echo $adcview->company->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($adcview->department->Visible) { // department ?>
		<td data-name="department"<?php echo $adcview->department->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_department" class="adcview_department">
<span<?php echo $adcview->department->ViewAttributes() ?>>
<?php echo $adcview->department->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($adcview->type->Visible) { // type ?>
		<td data-name="type"<?php echo $adcview->type->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_type" class="adcview_type">
<span<?php echo $adcview->type->ViewAttributes() ?>>
<?php echo $adcview->type->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($adcview->model->Visible) { // model ?>
		<td data-name="model"<?php echo $adcview->model->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_model" class="adcview_model">
<span<?php echo $adcview->model->ViewAttributes() ?>>
<?php echo $adcview->model->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($adcview->location->Visible) { // location ?>
		<td data-name="location"<?php echo $adcview->location->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_location" class="adcview_location">
<span<?php echo $adcview->location->ViewAttributes() ?>>
<?php echo $adcview->location->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($adcview->alternateIP->Visible) { // alternateIP ?>
		<td data-name="alternateIP"<?php echo $adcview->alternateIP->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_alternateIP" class="adcview_alternateIP">
<span<?php echo $adcview->alternateIP->ViewAttributes() ?>>
<?php echo $adcview->alternateIP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($adcview->operatingsystem->Visible) { // operatingsystem ?>
		<td data-name="operatingsystem"<?php echo $adcview->operatingsystem->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_operatingsystem" class="adcview_operatingsystem">
<span<?php echo $adcview->operatingsystem->ViewAttributes() ?>>
<?php echo $adcview->operatingsystem->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($adcview->officelicense->Visible) { // officelicense ?>
		<td data-name="officelicense"<?php echo $adcview->officelicense->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_officelicense" class="adcview_officelicense">
<span<?php echo $adcview->officelicense->ViewAttributes() ?>>
<?php echo $adcview->officelicense->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($adcview->datereceived->Visible) { // datereceived ?>
		<td data-name="datereceived"<?php echo $adcview->datereceived->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_datereceived" class="adcview_datereceived">
<span<?php echo $adcview->datereceived->ViewAttributes() ?>>
<?php echo $adcview->datereceived->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($adcview->serialcode->Visible) { // serialcode ?>
	<td data-name="serialcode"<?php echo $adcview->serialcode->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_serialcode" class="adcview_serialcode">
<span<?php echo $adcview->serialcode->ViewAttributes() ?>>
<?php echo $adcview->serialcode->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($adcview->latestupdate->Visible) { // latestupdate ?>
	<td data-name="latestupdate"<?php echo $adcview->latestupdate->CellAttributes() ?>>
<span id="el<?php echo $adcview_list->RowCnt ?>_adcview_latestupdate" class="adcview_latestupdate">
<span<?php echo $adcview->latestupdate->ViewAttributes() ?>>
<?php echo $adcview->latestupdate->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$adcview_list->ListOptions->Render("body", "right", $adcview_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($adcview->CurrentAction <> "gridadd")
		$adcview_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($adcview->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($adcview_list->Recordset)
	$adcview_list->Recordset->Close();
?>
<?php if ($adcview->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($adcview->CurrentAction <> "gridadd" && $adcview->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($adcview_list->Pager)) $adcview_list->Pager = new cNumericPager($adcview_list->StartRec, $adcview_list->DisplayRecs, $adcview_list->TotalRecs, $adcview_list->RecRange) ?>
<?php if ($adcview_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<div class="ewNumericPage"><ul class="pagination">
	<?php if ($adcview_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $adcview_list->PageUrl() ?>start=<?php echo $adcview_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($adcview_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $adcview_list->PageUrl() ?>start=<?php echo $adcview_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($adcview_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $adcview_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($adcview_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $adcview_list->PageUrl() ?>start=<?php echo $adcview_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($adcview_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $adcview_list->PageUrl() ?>start=<?php echo $adcview_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $adcview_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $adcview_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $adcview_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($adcview_list->TotalRecs > 0) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="adcview">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm" onchange="this.form.submit();">
<option value="10"<?php if ($adcview_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($adcview_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($adcview_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($adcview_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($adcview->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($adcview_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($adcview_list->TotalRecs == 0 && $adcview->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($adcview_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($adcview->Export == "") { ?>
<script type="text/javascript">
fadcviewlistsrch.Init();
fadcviewlistsrch.FilterList = <?php echo $adcview_list->GetFilterList() ?>;
fadcviewlist.Init();
</script>
<?php } ?>
<?php
$adcview_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($adcview->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "itassetfooter.php" ?>
<?php
$adcview_list->Page_Terminate();
?>
