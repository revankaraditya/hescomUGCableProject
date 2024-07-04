<?php 

$tables = array(
    1 => array(
        'primary_fault_category' => 'PFID, PFNAME'
    ),
    2 => array(
        'secondary_fault_category' => 'CID, FNAME, PFID'
    ),
    3 => array(
        'fault_resolution_steps' => 'SLNO, CID, FSID, NAME'
    ),
    4 => array(
        'usertype' => 'UTNO, USERTYPE'
    ),
    5 => array(
        'users' => 'UID, UTNO, NAME, EMAIL, USERNAME, PASSWORD, PHONE, CDATE'
    ),
    6 => array(
        'fault_records' => 'FID, CID, UID, FAULT_CODE, FAULT_TITLE, FEEDER_NAME, FROM, TO, REASON, DTC_NAME, RMU_LOCATION, CRDATE, STATUS'
    ),
    7 => array(
        'fault_status' => 'SLNO, FID, CID, FSID, MDATE, STATUS'
    )
);