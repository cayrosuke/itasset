<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "itassetewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "itassetewmysql12.php") ?>
<?php include_once "itassetphpfn12.php" ?>
<?php

// Global variable for table object
$SMEA_Inventory_Report = NULL;

//
// Table class for SMEA Inventory Report
//
class cSMEA_Inventory_Report extends cTableBase {
	var $no;
	var $assettag;
	var $servicetag;
	var $ipaddress;
	var $employeeno;
	var $employeename;
	var $company;
	var $department;
	var $type;
	var $model;
	var $location;
	var $alternateIP;
	var $officelicense;
	var $operatingsystem;
	var $remarks;
	var $datereceived;
	var $serialcode;
	var $latestupdate;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'SMEA_Inventory_Report';
		$this->TableName = 'SMEA Inventory Report';
		$this->TableType = 'REPORT';

		// Update Table
		$this->UpdateTable = "assetmaster";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->UserIDAllowSecurity = 0; // User ID Allow

		// no
		$this->no = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_no', 'no', '`no`', '`no`', 3, -1, FALSE, '`no`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->no->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['no'] = &$this->no;

		// assettag
		$this->assettag = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_assettag', 'assettag', '`assettag`', '`assettag`', 200, -1, FALSE, '`assettag`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['assettag'] = &$this->assettag;

		// servicetag
		$this->servicetag = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_servicetag', 'servicetag', '`servicetag`', '`servicetag`', 200, -1, FALSE, '`servicetag`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['servicetag'] = &$this->servicetag;

		// ipaddress
		$this->ipaddress = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_ipaddress', 'ipaddress', '`ipaddress`', '`ipaddress`', 200, -1, FALSE, '`ipaddress`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['ipaddress'] = &$this->ipaddress;

		// employeeno
		$this->employeeno = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_employeeno', 'employeeno', '`employeeno`', '`employeeno`', 200, -1, FALSE, '`employeeno`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['employeeno'] = &$this->employeeno;

		// employeename
		$this->employeename = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_employeename', 'employeename', '`employeename`', '`employeename`', 200, -1, FALSE, '`employeename`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['employeename'] = &$this->employeename;

		// company
		$this->company = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_company', 'company', 'assetmaster.company', 'assetmaster.company', 200, -1, FALSE, 'assetmaster.company', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->company->OptionCount = 9;
		$this->fields['company'] = &$this->company;

		// department
		$this->department = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_department', 'department', '`department`', '`department`', 200, -1, FALSE, '`department`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['department'] = &$this->department;

		// type
		$this->type = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_type', 'type', '`type`', '`type`', 200, -1, FALSE, '`type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['type'] = &$this->type;

		// model
		$this->model = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_model', 'model', '`model`', '`model`', 200, -1, FALSE, '`model`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['model'] = &$this->model;

		// location
		$this->location = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_location', 'location', '`location`', '`location`', 200, -1, FALSE, '`location`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['location'] = &$this->location;

		// alternateIP
		$this->alternateIP = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_alternateIP', 'alternateIP', '`alternateIP`', '`alternateIP`', 200, -1, FALSE, '`alternateIP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['alternateIP'] = &$this->alternateIP;

		// officelicense
		$this->officelicense = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_officelicense', 'officelicense', '`officelicense`', '`officelicense`', 200, -1, FALSE, '`officelicense`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['officelicense'] = &$this->officelicense;

		// operatingsystem
		$this->operatingsystem = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_operatingsystem', 'operatingsystem', '`operatingsystem`', '`operatingsystem`', 200, -1, FALSE, '`operatingsystem`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['operatingsystem'] = &$this->operatingsystem;

		// remarks
		$this->remarks = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_remarks', 'remarks', '`remarks`', '`remarks`', 201, -1, FALSE, '`remarks`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['remarks'] = &$this->remarks;

		// datereceived
		$this->datereceived = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_datereceived', 'datereceived', '`datereceived`', 'DATE_FORMAT(`datereceived`, \'%d-%m-%Y\')', 133, 7, FALSE, '`datereceived`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->datereceived->FldDefaultErrMsg = str_replace("%s", "-", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['datereceived'] = &$this->datereceived;

		// serialcode
		$this->serialcode = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_serialcode', 'serialcode', '`serialcode`', '`serialcode`', 200, -1, FALSE, '`serialcode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['serialcode'] = &$this->serialcode;

		// latestupdate
		$this->latestupdate = new cField('SMEA_Inventory_Report', 'SMEA Inventory Report', 'x_latestupdate', 'latestupdate', '`latestupdate`', 'DATE_FORMAT(`latestupdate`, \'%d-%m-%Y\')', 133, 7, FALSE, '`latestupdate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->latestupdate->FldDefaultErrMsg = str_replace("%s", "-", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['latestupdate'] = &$this->latestupdate;
	}

	// Report group level SQL
	var $_SqlGroupSelect = "";

	function getSqlGroupSelect() { // Select
		return ($this->_SqlGroupSelect <> "") ? $this->_SqlGroupSelect : "SELECT DISTINCT `type` FROM assetmaster";
	}

	function SqlGroupSelect() { // For backward compatibility
    	return $this->getSqlGroupSelect();
	}

	function setSqlGroupSelect($v) {
    	$this->_SqlGroupSelect = $v;
	}
	var $_SqlGroupWhere = "";

	function getSqlGroupWhere() { // Where
		return ($this->_SqlGroupWhere <> "") ? $this->_SqlGroupWhere : "assetmaster.company = 'SMEA'";
	}

	function SqlGroupWhere() { // For backward compatibility
    	return $this->getSqlGroupWhere();
	}

	function setSqlGroupWhere($v) {
    	$this->_SqlGroupWhere = $v;
	}
	var $_SqlGroupGroupBy = "";

	function getSqlGroupGroupBy() { // Group By
		return ($this->_SqlGroupGroupBy <> "") ? $this->_SqlGroupGroupBy : "";
	}

	function SqlGroupGroupBy() { // For backward compatibility
    	return $this->getSqlGroupGroupBy();
	}

	function setSqlGroupGroupBy($v) {
    	$this->_SqlGroupGroupBy = $v;
	}
	var $_SqlGroupHaving = "";

	function getSqlGroupHaving() { // Having
		return ($this->_SqlGroupHaving <> "") ? $this->_SqlGroupHaving : "";
	}

	function SqlGroupHaving() { // For backward compatibility
    	return $this->getSqlGroupHaving();
	}

	function setSqlGroupHaving($v) {
    	$this->_SqlGroupHaving = $v;
	}
	var $_SqlGroupOrderBy = "";

	function getSqlGroupOrderBy() { // Order By
		return ($this->_SqlGroupOrderBy <> "") ? $this->_SqlGroupOrderBy : "`type` ASC";
	}

	function SqlGroupOrderBy() { // For backward compatibility
    	return $this->getSqlGroupOrderBy();
	}

	function setSqlGroupOrderBy($v) {
    	$this->_SqlGroupOrderBy = $v;
	}

	// Report detail level SQL
	var $_SqlDetailSelect = "";

	function getSqlDetailSelect() { // Select
		return ($this->_SqlDetailSelect <> "") ? $this->_SqlDetailSelect : "SELECT * FROM assetmaster";
	}

	function SqlDetailSelect() { // For backward compatibility
    	return $this->getSqlDetailSelect();
	}

	function setSqlDetailSelect($v) {
    	$this->_SqlDetailSelect = $v;
	}
	var $_SqlDetailWhere = "";

	function getSqlDetailWhere() { // Where
		return ($this->_SqlDetailWhere <> "") ? $this->_SqlDetailWhere : "assetmaster.company = 'SMEA'";
	}

	function SqlDetailWhere() { // For backward compatibility
    	return $this->getSqlDetailWhere();
	}

	function setSqlDetailWhere($v) {
    	$this->_SqlDetailWhere = $v;
	}
	var $_SqlDetailGroupBy = "";

	function getSqlDetailGroupBy() { // Group By
		return ($this->_SqlDetailGroupBy <> "") ? $this->_SqlDetailGroupBy : "";
	}

	function SqlDetailGroupBy() { // For backward compatibility
    	return $this->getSqlDetailGroupBy();
	}

	function setSqlDetailGroupBy($v) {
    	$this->_SqlDetailGroupBy = $v;
	}
	var $_SqlDetailHaving = "";

	function getSqlDetailHaving() { // Having
		return ($this->_SqlDetailHaving <> "") ? $this->_SqlDetailHaving : "";
	}

	function SqlDetailHaving() { // For backward compatibility
    	return $this->getSqlDetailHaving();
	}

	function setSqlDetailHaving($v) {
    	$this->_SqlDetailHaving = $v;
	}
	var $_SqlDetailOrderBy = "";

	function getSqlDetailOrderBy() { // Order By
		return ($this->_SqlDetailOrderBy <> "") ? $this->_SqlDetailOrderBy : "";
	}

	function SqlDetailOrderBy() { // For backward compatibility
    	return $this->getSqlDetailOrderBy();
	}

	function setSqlDetailOrderBy($v) {
    	$this->_SqlDetailOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Report group SQL
	function GroupSQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = "";
		return ew_BuildSelectSql($this->getSqlGroupSelect(), $this->getSqlGroupWhere(),
			 $this->getSqlGroupGroupBy(), $this->getSqlGroupHaving(),
			 $this->getSqlGroupOrderBy(), $sFilter, $sSort);
	}

	// Report detail SQL
	function DetailSQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = "";
		return ew_BuildSelectSql($this->getSqlDetailSelect(), $this->getSqlDetailWhere(),
			$this->getSqlDetailGroupBy(), $this->getSqlDetailHaving(),
			$this->getSqlDetailOrderBy(), $sFilter, $sSort);
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "itassetlogin.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "itassetsmea_inventory_reportreport.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "itassetsmea_inventory_reportreport.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "?" . $this->UrlParm($parm);
		else
			$url = "";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
<?php include_once "itassetuserinfo.php" ?>
<?php include_once "itassetuserfn12.php" ?>
<?php

//
// Page class
//

$SMEA_Inventory_Report_report = NULL; // Initialize page object first

class cSMEA_Inventory_Report_report extends cSMEA_Inventory_Report {

	// Page ID
	var $PageID = 'report';

	// Project ID
	var $ProjectID = "{6E5D033C-DA34-4C1B-AC0C-D8B1ECCFD39C}";

	// Table name
	var $TableName = 'SMEA Inventory Report';

	// Page object name
	var $PageObjName = 'SMEA_Inventory_Report_report';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
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
		return TRUE;
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

		// Table object (SMEA_Inventory_Report)
		if (!isset($GLOBALS["SMEA_Inventory_Report"]) || get_class($GLOBALS["SMEA_Inventory_Report"]) == "cSMEA_Inventory_Report") {
			$GLOBALS["SMEA_Inventory_Report"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["SMEA_Inventory_Report"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";

		// Table object (user)
		if (!isset($GLOBALS['user'])) $GLOBALS['user'] = new cuser();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'report', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'SMEA Inventory Report', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (user)
		if (!isset($UserTable)) {
			$UserTable = new cuser();
			$UserTableConn = Conn($UserTable->DBID);
		}

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";
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
		if (!$Security->CanReport()) {
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
		global $EW_EXPORT_REPORT;
		if ($this->Export <> "" && array_key_exists($this->Export, $EW_EXPORT_REPORT)) {
			$sContent = ob_get_contents();
			$fn = $EW_EXPORT_REPORT[$this->Export];
			$this->$fn($sContent);
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
	var $ExportOptions; // Export options
	var $RecCnt = 0;
	var $RowCnt = 0; // For custom view tag
	var $ReportSql = "";
	var $ReportFilter = "";
	var $DefaultFilter = "";
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $MasterRecordExists;
	var $Command;
	var $DtlRecordCount;
	var $ReportGroups;
	var $ReportCounts;
	var $LevelBreak;
	var $ReportTotals;
	var $ReportMaxs;
	var $ReportMins;
	var $Recordset;
	var $DetailRecordset;
	var $RecordExists;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		$this->ReportGroups = &ew_InitArray(2, NULL);
		$this->ReportCounts = &ew_InitArray(2, 0);
		$this->LevelBreak = &ew_InitArray(2, FALSE);
		$this->ReportTotals = &ew_Init2DArray(2, 15, 0);
		$this->ReportMaxs = &ew_Init2DArray(2, 15, 0);
		$this->ReportMins = &ew_Init2DArray(2, 15, 0);

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
	}

	// Check level break
	function ChkLvlBreak() {
		$this->LevelBreak[1] = FALSE;
		if ($this->RecCnt == 0) { // Start Or End of Recordset
			$this->LevelBreak[1] = TRUE;
		} else {
			if (!ew_CompareValue($this->type->CurrentValue, $this->ReportGroups[0])) {
				$this->LevelBreak[1] = TRUE;
			}
		}
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
		// officelicense
		// operatingsystem
		// remarks
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

		// remarks
		$this->remarks->ViewValue = $this->remarks->CurrentValue;
		$this->remarks->ViewCustomAttributes = "";

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

			// officelicense
			$this->officelicense->LinkCustomAttributes = "";
			$this->officelicense->HrefValue = "";
			$this->officelicense->TooltipValue = "";

			// operatingsystem
			$this->operatingsystem->LinkCustomAttributes = "";
			$this->operatingsystem->HrefValue = "";
			$this->operatingsystem->TooltipValue = "";

			// remarks
			$this->remarks->LinkCustomAttributes = "";
			$this->remarks->HrefValue = "";
			$this->remarks->TooltipValue = "";

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

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("report", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Export report to HTML
	function ExportReportHtml($html) {

		//global $gsExportFile;
		//header('Content-Type: text/html' . (EW_CHARSET <> '' ? ';charset=' . EW_CHARSET : ''));
		//header('Content-Disposition: attachment; filename=' . $gsExportFile . '.html');
		//echo $html;

	}

	// Export report to WORD
	function ExportReportWord($html) {
		global $gsExportFile;
		header('Content-Type: application/vnd.ms-word' . (EW_CHARSET <> '' ? ';charset=' . EW_CHARSET : ''));
		header('Content-Disposition: attachment; filename=' . $gsExportFile . '.doc');
		echo $html;
	}

	// Export report to EXCEL
	function ExportReportExcel($html) {
		global $gsExportFile;
		header('Content-Type: application/vnd.ms-excel' . (EW_CHARSET <> '' ? ';charset=' . EW_CHARSET : ''));
		header('Content-Disposition: attachment; filename=' . $gsExportFile . '.xls');
		echo $html;
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
if (!isset($SMEA_Inventory_Report_report)) $SMEA_Inventory_Report_report = new cSMEA_Inventory_Report_report();

// Page init
$SMEA_Inventory_Report_report->Page_Init();

// Page main
$SMEA_Inventory_Report_report->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$SMEA_Inventory_Report_report->Page_Render();
?>
<?php include_once "itassetheader.php" ?>
<?php if ($SMEA_Inventory_Report->Export == "") { ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<div class="ewToolbar">
<?php if ($SMEA_Inventory_Report->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($SMEA_Inventory_Report->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
$SMEA_Inventory_Report_report->DefaultFilter = "";
$SMEA_Inventory_Report_report->ReportFilter = $SMEA_Inventory_Report_report->DefaultFilter;
if (!$Security->CanReport()) {
	if ($SMEA_Inventory_Report_report->ReportFilter <> "") $SMEA_Inventory_Report_report->ReportFilter .= " AND ";
	$SMEA_Inventory_Report_report->ReportFilter .= "(0=1)";
}
if ($SMEA_Inventory_Report_report->DbDetailFilter <> "") {
	if ($SMEA_Inventory_Report_report->ReportFilter <> "") $SMEA_Inventory_Report_report->ReportFilter .= " AND ";
	$SMEA_Inventory_Report_report->ReportFilter .= "(" . $SMEA_Inventory_Report_report->DbDetailFilter . ")";
}
$ReportConn = &$SMEA_Inventory_Report_report->Connection();

// Set up filter and load Group level sql
$SMEA_Inventory_Report->CurrentFilter = $SMEA_Inventory_Report_report->ReportFilter;
$SMEA_Inventory_Report_report->ReportSql = $SMEA_Inventory_Report->GroupSQL();

// Load recordset
$SMEA_Inventory_Report_report->Recordset = $ReportConn->Execute($SMEA_Inventory_Report_report->ReportSql);
$SMEA_Inventory_Report_report->RecordExists = !$SMEA_Inventory_Report_report->Recordset->EOF;
?>
<?php if ($SMEA_Inventory_Report->Export == "") { ?>
<?php if ($SMEA_Inventory_Report_report->RecordExists) { ?>
<div class="ewViewExportOptions"><?php $SMEA_Inventory_Report_report->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php } ?>
<?php $SMEA_Inventory_Report_report->ShowPageHeader(); ?>
<table class="ewReportTable">
<?php

// Get First Row
if ($SMEA_Inventory_Report_report->RecordExists) {
	$SMEA_Inventory_Report->type->setDbValue($SMEA_Inventory_Report_report->Recordset->fields('type'));
	$SMEA_Inventory_Report_report->ReportGroups[0] = $SMEA_Inventory_Report->type->DbValue;
}
$SMEA_Inventory_Report_report->RecCnt = 0;
$SMEA_Inventory_Report_report->ReportCounts[0] = 0;
$SMEA_Inventory_Report_report->ChkLvlBreak();
while (!$SMEA_Inventory_Report_report->Recordset->EOF) {

	// Render for view
	$SMEA_Inventory_Report->RowType = EW_ROWTYPE_VIEW;
	$SMEA_Inventory_Report->ResetAttrs();
	$SMEA_Inventory_Report_report->RenderRow();

	// Show group headers
	if ($SMEA_Inventory_Report_report->LevelBreak[1]) { // Reset counter and aggregation
?>
	<tr><td class="ewGroupField"><?php echo $SMEA_Inventory_Report->type->FldCaption() ?></td>
	<td colspan=14 class="ewGroupName">
<span<?php echo $SMEA_Inventory_Report->type->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->type->ViewValue ?></span>
</td></tr>
<?php
	}

	// Get detail records
	$SMEA_Inventory_Report_report->ReportFilter = $SMEA_Inventory_Report_report->DefaultFilter;
	if ($SMEA_Inventory_Report_report->ReportFilter <> "") $SMEA_Inventory_Report_report->ReportFilter .= " AND ";
	if (is_null($SMEA_Inventory_Report->type->CurrentValue)) {
		$SMEA_Inventory_Report_report->ReportFilter .= "(`type` IS NULL)";
	} else {
		$SMEA_Inventory_Report_report->ReportFilter .= "(`type` = " . ew_QuotedValue($SMEA_Inventory_Report->type->CurrentValue, EW_DATATYPE_STRING, $SMEA_Inventory_Report_report->DBID) . ")";
	}
	if ($SMEA_Inventory_Report_report->DbDetailFilter <> "") {
		if ($SMEA_Inventory_Report_report->ReportFilter <> "")
			$SMEA_Inventory_Report_report->ReportFilter .= " AND ";
		$SMEA_Inventory_Report_report->ReportFilter .= "(" . $SMEA_Inventory_Report_report->DbDetailFilter . ")";
	}
	if (!$Security->CanReport()) {
		if ($sFilter <> "") $sFilter .= " AND ";
		$sFilter .= "(0=1)";
	}

	// Set up detail SQL
	$SMEA_Inventory_Report->CurrentFilter = $SMEA_Inventory_Report_report->ReportFilter;
	$SMEA_Inventory_Report_report->ReportSql = $SMEA_Inventory_Report->DetailSQL();

	// Load detail records
	$SMEA_Inventory_Report_report->DetailRecordset = $ReportConn->Execute($SMEA_Inventory_Report_report->ReportSql);
	$SMEA_Inventory_Report_report->DtlRecordCount = $SMEA_Inventory_Report_report->DetailRecordset->RecordCount();

	// Initialize aggregates
	if (!$SMEA_Inventory_Report_report->DetailRecordset->EOF) {
		$SMEA_Inventory_Report_report->RecCnt++;
	}
	if ($SMEA_Inventory_Report_report->RecCnt == 1) {
		$SMEA_Inventory_Report_report->ReportCounts[0] = 0;
	}
	for ($i = 1; $i <= 1; $i++) {
		if ($SMEA_Inventory_Report_report->LevelBreak[$i]) { // Reset counter and aggregation
			$SMEA_Inventory_Report_report->ReportCounts[$i] = 0;
		}
	}
	$SMEA_Inventory_Report_report->ReportCounts[0] += $SMEA_Inventory_Report_report->DtlRecordCount;
	$SMEA_Inventory_Report_report->ReportCounts[1] += $SMEA_Inventory_Report_report->DtlRecordCount;
	if ($SMEA_Inventory_Report_report->RecordExists) {
?>
	<tr>
		<td><div class="ewGroupIndent"></div></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->assettag->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->servicetag->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->ipaddress->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->employeeno->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->employeename->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->company->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->department->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->model->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->location->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->alternateIP->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->officelicense->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->operatingsystem->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->remarks->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->datereceived->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->serialcode->FldCaption() ?></td>
			<td class="ewGroupHeader"><?php echo $SMEA_Inventory_Report->latestupdate->FldCaption() ?></td>
	</tr>
<?php
	}
	while (!$SMEA_Inventory_Report_report->DetailRecordset->EOF) {
		$SMEA_Inventory_Report_report->RowCnt++;
		$SMEA_Inventory_Report->assettag->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('assettag'));
		$SMEA_Inventory_Report->servicetag->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('servicetag'));
		$SMEA_Inventory_Report->ipaddress->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('ipaddress'));
		$SMEA_Inventory_Report->employeeno->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('employeeno'));
		$SMEA_Inventory_Report->employeename->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('employeename'));
		$SMEA_Inventory_Report->company->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('company'));
		$SMEA_Inventory_Report->department->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('department'));
		$SMEA_Inventory_Report->model->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('model'));
		$SMEA_Inventory_Report->location->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('location'));
		$SMEA_Inventory_Report->alternateIP->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('alternateIP'));
		$SMEA_Inventory_Report->officelicense->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('officelicense'));
		$SMEA_Inventory_Report->operatingsystem->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('operatingsystem'));
		$SMEA_Inventory_Report->remarks->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('remarks'));
		$SMEA_Inventory_Report->datereceived->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('datereceived'));
			$SMEA_Inventory_Report->serialcode->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('serialcode'));
			$SMEA_Inventory_Report->latestupdate->setDbValue($SMEA_Inventory_Report_report->DetailRecordset->fields('latestupdate'));

		// Render for view
		$SMEA_Inventory_Report->RowType = EW_ROWTYPE_VIEW;
		$SMEA_Inventory_Report->ResetAttrs();
		$SMEA_Inventory_Report_report->RenderRow();
?>
	<tr>
		<td><div class="ewGroupIndent"></div></td>
		<td<?php echo $SMEA_Inventory_Report->assettag->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->assettag->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->assettag->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->servicetag->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->servicetag->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->servicetag->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->ipaddress->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->ipaddress->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->ipaddress->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->employeeno->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->employeeno->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->employeeno->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->employeename->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->employeename->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->employeename->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->company->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->company->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->company->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->department->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->department->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->department->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->model->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->model->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->model->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->location->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->location->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->location->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->alternateIP->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->alternateIP->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->alternateIP->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->officelicense->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->officelicense->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->officelicense->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->operatingsystem->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->operatingsystem->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->operatingsystem->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->remarks->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->remarks->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->remarks->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->datereceived->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->datereceived->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->datereceived->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->serialcode->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->serialcode->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->serialcode->ViewValue ?></span>
</td>
		<td<?php echo $SMEA_Inventory_Report->latestupdate->CellAttributes() ?>>
<span<?php echo $SMEA_Inventory_Report->latestupdate->ViewAttributes() ?>>
<?php echo $SMEA_Inventory_Report->latestupdate->ViewValue ?></span>
</td>
	</tr>
<?php
		$SMEA_Inventory_Report_report->DetailRecordset->MoveNext();
	}
	$SMEA_Inventory_Report_report->DetailRecordset->Close();

	// Save old group data
	$SMEA_Inventory_Report_report->ReportGroups[0] = $SMEA_Inventory_Report->type->CurrentValue;

	// Get next record
	$SMEA_Inventory_Report_report->Recordset->MoveNext();
	if ($SMEA_Inventory_Report_report->Recordset->EOF) {
		$SMEA_Inventory_Report_report->RecCnt = 0; // EOF, force all level breaks
	} else {
		$SMEA_Inventory_Report->type->setDbValue($SMEA_Inventory_Report_report->Recordset->fields('type'));
	}
	$SMEA_Inventory_Report_report->ChkLvlBreak();

	// Show footers
	if ($SMEA_Inventory_Report_report->LevelBreak[1]) {
		$SMEA_Inventory_Report->type->CurrentValue = $SMEA_Inventory_Report_report->ReportGroups[0];

		// Render row for view
		$SMEA_Inventory_Report->RowType = EW_ROWTYPE_VIEW;
		$SMEA_Inventory_Report->ResetAttrs();
		$SMEA_Inventory_Report_report->RenderRow();
		$SMEA_Inventory_Report->type->CurrentValue = $SMEA_Inventory_Report->type->DbValue;
?>
	<tr><td colspan=15 class="ewGroupSummary"><?php echo $Language->Phrase("RptSumHead") ?>&nbsp;<?php echo $SMEA_Inventory_Report->type->FldCaption() ?>:&nbsp;<?php echo $SMEA_Inventory_Report->type->ViewValue ?> (<?php echo ew_FormatNumber($SMEA_Inventory_Report_report->ReportCounts[1],0) ?> <?php echo $Language->Phrase("RptDtlRec") ?>)</td></tr>
	<tr><td colspan=15>&nbsp;<br></td></tr>
<?php
}
}

// Close recordset
$SMEA_Inventory_Report_report->Recordset->Close();
?>
<?php if ($SMEA_Inventory_Report_report->RecordExists) { ?>
	<tr><td colspan=15>&nbsp;<br></td></tr>
	<tr><td colspan=15 class="ewGrandSummary"><?php echo $Language->Phrase("RptGrandTotal") ?>&nbsp;(<?php echo ew_FormatNumber($SMEA_Inventory_Report_report->ReportCounts[0], 0) ?>&nbsp;<?php echo $Language->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
<?php if ($SMEA_Inventory_Report_report->RecordExists) { ?>
	<tr><td colspan=15>&nbsp;<br></td></tr>
<?php } else { ?>
	<tr><td><?php echo $Language->Phrase("NoRecord") ?></td></tr>
<?php } ?>
</table>
<?php
$SMEA_Inventory_Report_report->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($SMEA_Inventory_Report->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "itassetfooter.php" ?>
<?php
$SMEA_Inventory_Report_report->Page_Terminate();
?>
