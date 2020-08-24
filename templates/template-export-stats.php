<?php
// print your data here. note the following:
// - cells/columns are separated by tabs ("\t")
// - rows are separated by newlines ("\n")

$filename = sanitize_title('fullinpark-stats-'.date('d-m-Y'));
header( "Content-Type: application/vnd.ms-excel" );
header( "Content-disposition: attachment; filename={$filename}.xls" );
