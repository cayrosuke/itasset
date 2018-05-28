<?php

// Global variable for table object
$atpview = NULL;

//
// Table class for atpview
//
class catpview extends cTable {
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
	var $operatingsystem;
	var $remarks;
	var $officelicense;
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
		$this->TableVar = 'atpview';
		$this->TableName = 'atpview';
		$this->TableType = 'CUSTOMVIEW';

		// Update Table
		$this->UpdateTable = "assetmaster";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// no
		$this->no = new cField('atpview', 'atpview', 'x_no', 'no', '`no`', '`no`', 3, -1, FALSE, '`no`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->no->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['no'] = &$this->no;

		// assettag
		$this->assettag = new cField('atpview', 'atpview', 'x_assettag', 'assettag', '`assettag`', '`assettag`', 200, -1, FALSE, '`assettag`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['assettag'] = &$this->assettag;

		// servicetag
		$this->servicetag = new cField('atpview', 'atpview', 'x_servicetag', 'servicetag', '`servicetag`', '`servicetag`', 200, -1, FALSE, '`servicetag`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['servicetag'] = &$this->servicetag;

		// ipaddress
		$this->ipaddress = new cField('atpview', 'atpview', 'x_ipaddress', 'ipaddress', '`ipaddress`', '`ipaddress`', 200, -1, FALSE, '`ipaddress`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['ipaddress'] = &$this->ipaddress;

		// employeeno
		$this->employeeno = new cField('atpview', 'atpview', 'x_employeeno', 'employeeno', '`employeeno`', '`employeeno`', 200, -1, FALSE, '`employeeno`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['employeeno'] = &$this->employeeno;

		// employeename
		$this->employeename = new cField('atpview', 'atpview', 'x_employeename', 'employeename', '`employeename`', '`employeename`', 200, -1, FALSE, '`employeename`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['employeename'] = &$this->employeename;

		// company
		$this->company = new cField('atpview', 'atpview', 'x_company', 'company', '`company`', '`company`', 200, -1, FALSE, '`company`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['company'] = &$this->company;

		// department
		$this->department = new cField('atpview', 'atpview', 'x_department', 'department', '`department`', '`department`', 200, -1, FALSE, '`department`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['department'] = &$this->department;

		// type
		$this->type = new cField('atpview', 'atpview', 'x_type', 'type', '`type`', '`type`', 200, -1, FALSE, '`type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->type->OptionCount = 6;
		$this->fields['type'] = &$this->type;

		// model
		$this->model = new cField('atpview', 'atpview', 'x_model', 'model', '`model`', '`model`', 200, -1, FALSE, '`model`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['model'] = &$this->model;

		// location
		$this->location = new cField('atpview', 'atpview', 'x_location', 'location', '`location`', '`location`', 200, -1, FALSE, '`location`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['location'] = &$this->location;

		// alternateIP
		$this->alternateIP = new cField('atpview', 'atpview', 'x_alternateIP', 'alternateIP', '`alternateIP`', '`alternateIP`', 200, -1, FALSE, '`alternateIP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['alternateIP'] = &$this->alternateIP;

		// operatingsystem
		$this->operatingsystem = new cField('atpview', 'atpview', 'x_operatingsystem', 'operatingsystem', '`operatingsystem`', '`operatingsystem`', 200, -1, FALSE, '`operatingsystem`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['operatingsystem'] = &$this->operatingsystem;

		// remarks
		$this->remarks = new cField('atpview', 'atpview', 'x_remarks', 'remarks', '`remarks`', '`remarks`', 201, -1, FALSE, '`remarks`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['remarks'] = &$this->remarks;

		// officelicense
		$this->officelicense = new cField('atpview', 'atpview', 'x_officelicense', 'officelicense', '`officelicense`', '`officelicense`', 200, -1, FALSE, '`officelicense`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['officelicense'] = &$this->officelicense;

		// datereceived
		$this->datereceived = new cField('atpview', 'atpview', 'x_datereceived', 'datereceived', '`datereceived`', 'DATE_FORMAT(`datereceived`, \'%d-%m-%Y\')', 133, 7, FALSE, '`datereceived`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->datereceived->FldDefaultErrMsg = str_replace("%s", "-", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['datereceived'] = &$this->datereceived;

		// serialcode
		$this->serialcode = new cField('atpview', 'atpview', 'x_serialcode', 'serialcode', '`serialcode`', '`serialcode`', 200, -1, FALSE, '`serialcode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['serialcode'] = &$this->serialcode;

		// latestupdate
		$this->latestupdate = new cField('atpview', 'atpview', 'x_latestupdate', 'latestupdate', '`latestupdate`', 'DATE_FORMAT(`latestupdate`, \'%d-%m-%Y\')', 133, 7, FALSE, '`latestupdate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->latestupdate->FldDefaultErrMsg = str_replace("%s", "-", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['latestupdate'] = &$this->latestupdate;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "assetmaster";
	}

	function SqlFrom() { // For backward compatibility
    	return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
    	$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
    	return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
    	$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "company = 'ATP'";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
    	return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
    	$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
    	return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
    	$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
    	return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
    	$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
    	return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
    	$this->_SqlOrderBy = $v;
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

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		return $sKeyFilter;
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
			return "itassetatpviewlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "itassetatpviewlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("itassetatpviewview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("itassetatpviewview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "itassetatpviewadd.php?" . $this->UrlParm($parm);
		else
			$url = "itassetatpviewadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("itassetatpviewedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("itassetatpviewadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("itassetatpviewdelete.php", $this->UrlParm());
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

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
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

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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


		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// no
		$this->no->EditAttrs["class"] = "form-control";
		$this->no->EditCustomAttributes = "";
		$this->no->EditValue = $this->no->CurrentValue;
		$this->no->PlaceHolder = ew_RemoveHtml($this->no->FldCaption());

		// assettag
		$this->assettag->EditAttrs["class"] = "form-control";
		$this->assettag->EditCustomAttributes = "";
		$this->assettag->EditValue = $this->assettag->CurrentValue;
		$this->assettag->PlaceHolder = ew_RemoveHtml($this->assettag->FldCaption());

		// servicetag
		$this->servicetag->EditAttrs["class"] = "form-control";
		$this->servicetag->EditCustomAttributes = "";
		$this->servicetag->EditValue = $this->servicetag->CurrentValue;
		$this->servicetag->PlaceHolder = ew_RemoveHtml($this->servicetag->FldCaption());

		// ipaddress
		$this->ipaddress->EditAttrs["class"] = "form-control";
		$this->ipaddress->EditCustomAttributes = "";
		$this->ipaddress->EditValue = $this->ipaddress->CurrentValue;
		$this->ipaddress->PlaceHolder = ew_RemoveHtml($this->ipaddress->FldCaption());

		// employeeno
		$this->employeeno->EditAttrs["class"] = "form-control";
		$this->employeeno->EditCustomAttributes = "";
		$this->employeeno->EditValue = $this->employeeno->CurrentValue;
		$this->employeeno->PlaceHolder = ew_RemoveHtml($this->employeeno->FldCaption());

		// employeename
		$this->employeename->EditAttrs["class"] = "form-control";
		$this->employeename->EditCustomAttributes = "";
		$this->employeename->EditValue = $this->employeename->CurrentValue;
		$this->employeename->PlaceHolder = ew_RemoveHtml($this->employeename->FldCaption());

		// company
		$this->company->EditAttrs["class"] = "form-control";
		$this->company->EditCustomAttributes = "";
		$this->company->EditValue = $this->company->CurrentValue;
		$this->company->PlaceHolder = ew_RemoveHtml($this->company->FldCaption());

		// department
		$this->department->EditAttrs["class"] = "form-control";
		$this->department->EditCustomAttributes = "";
		$this->department->EditValue = $this->department->CurrentValue;
		$this->department->PlaceHolder = ew_RemoveHtml($this->department->FldCaption());

		// type
		$this->type->EditAttrs["class"] = "form-control";
		$this->type->EditCustomAttributes = "";
		$this->type->EditValue = $this->type->Options(TRUE);

		// model
		$this->model->EditAttrs["class"] = "form-control";
		$this->model->EditCustomAttributes = "";
		$this->model->EditValue = $this->model->CurrentValue;
		$this->model->PlaceHolder = ew_RemoveHtml($this->model->FldCaption());

		// location
		$this->location->EditAttrs["class"] = "form-control";
		$this->location->EditCustomAttributes = "";
		$this->location->EditValue = $this->location->CurrentValue;
		$this->location->PlaceHolder = ew_RemoveHtml($this->location->FldCaption());

		// alternateIP
		$this->alternateIP->EditAttrs["class"] = "form-control";
		$this->alternateIP->EditCustomAttributes = "";
		$this->alternateIP->EditValue = $this->alternateIP->CurrentValue;
		$this->alternateIP->PlaceHolder = ew_RemoveHtml($this->alternateIP->FldCaption());

		// operatingsystem
		$this->operatingsystem->EditAttrs["class"] = "form-control";
		$this->operatingsystem->EditCustomAttributes = "";
		$this->operatingsystem->EditValue = $this->operatingsystem->CurrentValue;
		$this->operatingsystem->PlaceHolder = ew_RemoveHtml($this->operatingsystem->FldCaption());

		// remarks
		$this->remarks->EditAttrs["class"] = "form-control";
		$this->remarks->EditCustomAttributes = "";
		$this->remarks->EditValue = $this->remarks->CurrentValue;
		$this->remarks->PlaceHolder = ew_RemoveHtml($this->remarks->FldCaption());

		// officelicense
		$this->officelicense->EditAttrs["class"] = "form-control";
		$this->officelicense->EditCustomAttributes = "";
		$this->officelicense->EditValue = $this->officelicense->CurrentValue;
		$this->officelicense->PlaceHolder = ew_RemoveHtml($this->officelicense->FldCaption());

		// datereceived
		$this->datereceived->EditAttrs["class"] = "form-control";
		$this->datereceived->EditCustomAttributes = "";
		$this->datereceived->EditValue = ew_FormatDateTime($this->datereceived->CurrentValue, 7);
		$this->datereceived->PlaceHolder = ew_RemoveHtml($this->datereceived->FldCaption());

		// serialcode
		$this->serialcode->EditAttrs["class"] = "form-control";
		$this->serialcode->EditCustomAttributes = "";
		$this->serialcode->EditValue = $this->serialcode->CurrentValue;
		$this->serialcode->PlaceHolder = ew_RemoveHtml($this->serialcode->FldCaption());

		// latestupdate
		$this->latestupdate->EditAttrs["class"] = "form-control";
		$this->latestupdate->EditCustomAttributes = "";
		$this->latestupdate->EditValue = ew_FormatDateTime($this->latestupdate->CurrentValue, 7);
		$this->latestupdate->PlaceHolder = ew_RemoveHtml($this->latestupdate->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->assettag->Exportable) $Doc->ExportCaption($this->assettag);
					if ($this->servicetag->Exportable) $Doc->ExportCaption($this->servicetag);
					if ($this->ipaddress->Exportable) $Doc->ExportCaption($this->ipaddress);
					if ($this->employeeno->Exportable) $Doc->ExportCaption($this->employeeno);
					if ($this->employeename->Exportable) $Doc->ExportCaption($this->employeename);
					if ($this->company->Exportable) $Doc->ExportCaption($this->company);
					if ($this->department->Exportable) $Doc->ExportCaption($this->department);
					if ($this->type->Exportable) $Doc->ExportCaption($this->type);
					if ($this->model->Exportable) $Doc->ExportCaption($this->model);
					if ($this->location->Exportable) $Doc->ExportCaption($this->location);
					if ($this->alternateIP->Exportable) $Doc->ExportCaption($this->alternateIP);
					if ($this->operatingsystem->Exportable) $Doc->ExportCaption($this->operatingsystem);
					if ($this->remarks->Exportable) $Doc->ExportCaption($this->remarks);
					if ($this->officelicense->Exportable) $Doc->ExportCaption($this->officelicense);
					if ($this->datereceived->Exportable) $Doc->ExportCaption($this->datereceived);
					if ($this->serialcode->Exportable) $Doc->ExportCaption($this->serialcode);
					if ($this->latestupdate->Exportable) $Doc->ExportCaption($this->latestupdate);
				} else {
					if ($this->assettag->Exportable) $Doc->ExportCaption($this->assettag);
					if ($this->servicetag->Exportable) $Doc->ExportCaption($this->servicetag);
					if ($this->ipaddress->Exportable) $Doc->ExportCaption($this->ipaddress);
					if ($this->employeeno->Exportable) $Doc->ExportCaption($this->employeeno);
					if ($this->employeename->Exportable) $Doc->ExportCaption($this->employeename);
					if ($this->company->Exportable) $Doc->ExportCaption($this->company);
					if ($this->department->Exportable) $Doc->ExportCaption($this->department);
					if ($this->type->Exportable) $Doc->ExportCaption($this->type);
					if ($this->model->Exportable) $Doc->ExportCaption($this->model);
					if ($this->location->Exportable) $Doc->ExportCaption($this->location);
					if ($this->alternateIP->Exportable) $Doc->ExportCaption($this->alternateIP);
					if ($this->operatingsystem->Exportable) $Doc->ExportCaption($this->operatingsystem);
					if ($this->officelicense->Exportable) $Doc->ExportCaption($this->officelicense);
					if ($this->datereceived->Exportable) $Doc->ExportCaption($this->datereceived);
					if ($this->serialcode->Exportable) $Doc->ExportCaption($this->serialcode);
					if ($this->latestupdate->Exportable) $Doc->ExportCaption($this->latestupdate);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->assettag->Exportable) $Doc->ExportField($this->assettag);
						if ($this->servicetag->Exportable) $Doc->ExportField($this->servicetag);
						if ($this->ipaddress->Exportable) $Doc->ExportField($this->ipaddress);
						if ($this->employeeno->Exportable) $Doc->ExportField($this->employeeno);
						if ($this->employeename->Exportable) $Doc->ExportField($this->employeename);
						if ($this->company->Exportable) $Doc->ExportField($this->company);
						if ($this->department->Exportable) $Doc->ExportField($this->department);
						if ($this->type->Exportable) $Doc->ExportField($this->type);
						if ($this->model->Exportable) $Doc->ExportField($this->model);
						if ($this->location->Exportable) $Doc->ExportField($this->location);
						if ($this->alternateIP->Exportable) $Doc->ExportField($this->alternateIP);
						if ($this->operatingsystem->Exportable) $Doc->ExportField($this->operatingsystem);
						if ($this->remarks->Exportable) $Doc->ExportField($this->remarks);
						if ($this->officelicense->Exportable) $Doc->ExportField($this->officelicense);
						if ($this->datereceived->Exportable) $Doc->ExportField($this->datereceived);
						if ($this->serialcode->Exportable) $Doc->ExportField($this->serialcode);
						if ($this->latestupdate->Exportable) $Doc->ExportField($this->latestupdate);
					} else {
						if ($this->assettag->Exportable) $Doc->ExportField($this->assettag);
						if ($this->servicetag->Exportable) $Doc->ExportField($this->servicetag);
						if ($this->ipaddress->Exportable) $Doc->ExportField($this->ipaddress);
						if ($this->employeeno->Exportable) $Doc->ExportField($this->employeeno);
						if ($this->employeename->Exportable) $Doc->ExportField($this->employeename);
						if ($this->company->Exportable) $Doc->ExportField($this->company);
						if ($this->department->Exportable) $Doc->ExportField($this->department);
						if ($this->type->Exportable) $Doc->ExportField($this->type);
						if ($this->model->Exportable) $Doc->ExportField($this->model);
						if ($this->location->Exportable) $Doc->ExportField($this->location);
						if ($this->alternateIP->Exportable) $Doc->ExportField($this->alternateIP);
						if ($this->operatingsystem->Exportable) $Doc->ExportField($this->operatingsystem);
						if ($this->officelicense->Exportable) $Doc->ExportField($this->officelicense);
						if ($this->datereceived->Exportable) $Doc->ExportField($this->datereceived);
						if ($this->serialcode->Exportable) $Doc->ExportField($this->serialcode);
						if ($this->latestupdate->Exportable) $Doc->ExportField($this->latestupdate);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

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
