<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "itassetewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "itassetewmysql12.php") ?>
<?php include_once "itassetphpfn12.php" ?>
<?php include_once "itassetuserinfo.php" ?>
<?php include_once "itassetuserfn12.php" ?>
<?php

//
// Page class
//

$default = NULL; // Initialize page object first

class cdefault {

	// Page ID
	var $PageID = 'default';

	// Project ID
	var $ProjectID = "{6E5D033C-DA34-4C1B-AC0C-D8B1ECCFD39C}";

	// Page object name
	var $PageObjName = 'default';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
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

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'default', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

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

	//
	// Page main
	//
	function Page_Main() {
		global $Security, $Language;
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadUserLevel(); // Load User Level
		if ($Security->AllowList(CurrentProjectID() . 'assetmaster'))
		$this->Page_Terminate("itassetassetmasterlist.php"); // Exit and go to default page
		if ($Security->AllowList(CurrentProjectID() . 'user'))
			$this->Page_Terminate("itassetuserlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'aaeview'))
			$this->Page_Terminate("itassetaaeviewlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'AAE All Inventory Report'))
			$this->Page_Terminate("itassetaae_all_inventory_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'airodview'))
			$this->Page_Terminate("itassetairodviewlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'AIROD All Inventory Report'))
			$this->Page_Terminate("itassetairod_all_inventory_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'atpview'))
			$this->Page_Terminate("itassetatpviewlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'ATP All Inventory Report'))
			$this->Page_Terminate("itassetatp_all_inventory_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'AERO All Inventory Report'))
			$this->Page_Terminate("itassetaero_all_inventory_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Airod Desktop'))
			$this->Page_Terminate("itassetairod_desktopreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Airod Laptop Report'))
			$this->Page_Terminate("itassetairod_laptop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Airod Printer Report'))
			$this->Page_Terminate("itassetairod_printer_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Airod Server Report'))
			$this->Page_Terminate("itassetairod_server_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Airod Switch Report'))
			$this->Page_Terminate("itassetairod_switch_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'AAE Desktop Report'))
			$this->Page_Terminate("itassetaae_desktop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'AAE Laptop Report'))
			$this->Page_Terminate("itassetaae_laptop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'AAE Printer Report'))
			$this->Page_Terminate("itassetaae_printer_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'AAE Server Report'))
			$this->Page_Terminate("itassetaae_server_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Nadi Inventory Report'))
			$this->Page_Terminate("itassetnadi_inventory_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Airod Projector'))
			$this->Page_Terminate("itassetairod_projectorreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'nadiview'))
			$this->Page_Terminate("itassetnadiviewlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'Nadi Projector Report'))
			$this->Page_Terminate("itassetnadi_projector_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Nadi Desktop Report'))
			$this->Page_Terminate("itassetnadi_desktop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Nadi Laptop Report'))
			$this->Page_Terminate("itassetnadi_laptop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Nadi Printer Report'))
			$this->Page_Terminate("itassetnadi_printer_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Nadi Switch Report'))
			$this->Page_Terminate("itassetnadi_switch_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Nadi Storage Report'))
			$this->Page_Terminate("itassetnadi_storage_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Nadi Server Report'))
			$this->Page_Terminate("itassetnadi_server_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'AAE Storage Report'))
			$this->Page_Terminate("itassetaae_storage_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'AAE Switch Report'))
			$this->Page_Terminate("itassetaae_switch_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'AAE Projector Report'))
			$this->Page_Terminate("itassetaae_projector_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'ATP Laptop Report'))
			$this->Page_Terminate("itassetatp_laptop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'ATP Desktop Report'))
			$this->Page_Terminate("itassetatp_desktop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'ATP Printer Report'))
			$this->Page_Terminate("itassetatp_printer_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'ATP Server Report'))
			$this->Page_Terminate("itassetatp_server_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'ATP Switch Report'))
			$this->Page_Terminate("itassetatp_switch_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'adcview'))
			$this->Page_Terminate("itassetadcviewlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'inayahview'))
			$this->Page_Terminate("itassetinayahviewlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'Inayah Inventory Report'))
			$this->Page_Terminate("itassetinayah_inventory_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Inayah Desktop Report'))
			$this->Page_Terminate("itassetinayah_desktop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Inayah Laptop Report'))
			$this->Page_Terminate("itassetinayah_laptop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Inayah Printer Report'))
			$this->Page_Terminate("itassetinayah_printer_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Inayah Server Report'))
			$this->Page_Terminate("itassetinayah_server_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Inayah Switch Report'))
			$this->Page_Terminate("itassetinayah_switch_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'ADC Desktop Report'))
			$this->Page_Terminate("itassetadc_desktop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'ADC Laptop Report'))
			$this->Page_Terminate("itassetadc_laptop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'ADC Printer Report'))
			$this->Page_Terminate("itassetadc_printer_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'ADC Server Report'))
			$this->Page_Terminate("itassetadc_server_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'ADC Inventory Report'))
			$this->Page_Terminate("itassetadc_inventory_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEAview'))
			$this->Page_Terminate("itassetsmeaviewlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEOView'))
			$this->Page_Terminate("itassetsmeoviewlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEA Inventory Report'))
			$this->Page_Terminate("itassetsmea_inventory_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEA Desktop Report'))
			$this->Page_Terminate("itassetsmea_desktop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEA Laptop Report'))
			$this->Page_Terminate("itassetsmea_laptop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEA Printer Report'))
			$this->Page_Terminate("itassetsmea_printer_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEA Server Report'))
			$this->Page_Terminate("itassetsmea_server_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEA Switch Report'))
			$this->Page_Terminate("itassetsmea_switch_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEA Storage Report'))
			$this->Page_Terminate("itassetsmea_storage_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEA Projector Report'))
			$this->Page_Terminate("itassetsmea_projector_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEO Inventory Report'))
			$this->Page_Terminate("itassetsmeo_inventory_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEO Desktop Report'))
			$this->Page_Terminate("itassetsmeo_desktop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEO Laptop Report'))
			$this->Page_Terminate("itassetsmeo_laptop_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEO Server Report'))
			$this->Page_Terminate("itassetsmeo_server_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEO Printer Report'))
			$this->Page_Terminate("itassetsmeo_printer_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEO Switch Report'))
			$this->Page_Terminate("itassetsmeo_switch_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEO Storage Report'))
			$this->Page_Terminate("itassetsmeo_storage_reportreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'SMEO Projector Report'))
			$this->Page_Terminate("itassetsmeo_projector_reportreport.php");
		if ($Security->IsLoggedIn()) {
			$this->setFailureMessage($Language->Phrase("NoPermission") . "<br><br><a href=\"itassetlogout.php\">" . $Language->Phrase("BackToLogin") . "</a>");
		} else {
			$this->Page_Terminate("itassetlogin.php"); // Exit and go to login page
		}
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
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($default)) $default = new cdefault();

// Page init
$default->Page_Init();

// Page main
$default->Page_Main();
?>
<?php include_once "itassetheader.php" ?>
<?php
$default->ShowMessage();
?>
<?php include_once "itassetfooter.php" ?>
<?php
$default->Page_Terminate();
?>
