<?php
/** Code By Yudha_Ard | 2022-03-24 **/
  function formatRp($input){
    $rp = number_format($input,2,',','.');
    return $rp;
  }
  echo "=========================================================\n";
  echo "API KEY : ";
  $input_apiKey = fopen("php://stdin","r");
  $iak = trim(fgets($input_apiKey));
  echo "=========================================================\n";

  echo "[ DISBURSEMENT, PAYMENT, REMITTANCE_PAYOUT, TRANSFER, REFUND ]\n";
  echo "TYPE    : ";
  $input_type = fopen("php://stdin","r");
  $it = trim(fgets($input_type));
  echo "=========================================================\n";

  if($it == "DISBURSEMENT" || $it == "REMITTANCE_PAYOUT") {
      echo "[ BANK, CASH ]\n";
  } else if ($it == "PAYMENT") {
      echo "[ CARDS, CARDLESS_CREDIT, DIRECT_DEBIT, EWALLET, PAYLATER, QR_CODE, RETAIL_OUTLET, VIRTUAL_ACCOUNT ]\n";
  } else if ($it == "TRANSFER"){
      echo "[ XENPLATFORM ]\n";
  } else {
     echo "Pilihan Tidak Ada\n";
  }

  echo "=========================================================\n";
  echo "CHANNEL CATEGORY : ";
  $input_channel_category = fopen("php://stdin","r");
  $icc = trim(fgets($input_channel_category));
  echo "=========================================================\n";

  echo "[ PENDING, SUCCESS, FAILED, VOIDED, REVERSED ]\n";
  echo "STATUS  : ";
  $input_status = fopen("php://stdin","r");
  $is = trim(fgets($input_status));
  echo "=========================================================\n";

  echo "LIMIT   : ";
  $input_limit = fopen("php://stdin","r");
  $il = trim(fgets($input_limit));

  $url = "https://api.xendit.co/transactions?types=".$it."&statuses=".$is."&channel_categories=".$icc."&limit=".$il."";
  $apiKey = $iak;
  

  $headers = [];

  $curl = curl_init();

  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_USERPWD, $apiKey.":");
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 
  $res = curl_exec($curl);
  curl_close($curl);

  $dataRes = json_decode($res, true);
  if(is_null($dataRes)) { 
        echo "================================================\n";
        echo "  Null Data !\n";
        echo "================================================\n";
    } else if(empty($dataRes["data"])) {
        echo "================================================\n";
        echo "  Empty Data !\n";
        echo "================================================\n";
    } else {

    $datas = [];
    foreach($dataRes['data'] as $key => $value) {
        $datas[$key]['id'] = $value['id'];
        $datas[$key]['product_id'] = $value['product_id'];
        $datas[$key]['type'] = $value['type'];
        $datas[$key]['status'] = $value['status'];
        $datas[$key]['channel_category'] = $value['channel_category'];
        $datas[$key]['channel_code'] = $value['channel_code'];
        $datas[$key]['reference_id'] = $value['reference_id'];
        $datas[$key]['account_identifier'] = $value['account_identifier'];
        $datas[$key]['currency'] = $value['currency'];
        $datas[$key]['amount'] = $value['amount'];
        $datas[$key]['net_amount'] = $value['net_amount'];
        $datas[$key]['cashflow'] = $value['cashflow'];
        $datas[$key]['business_id'] = $value['business_id'];
        $datas[$key]['created'] = $value['created'];
        $datas[$key]['updated'] = $value['updated'];
        $datas[$key]['fee']['xendit_fee'] = $value['fee']['xendit_fee'];
        $datas[$key]['fee']['value_added_tax'] = $value['fee']['value_added_tax'];
        $datas[$key]['fee']['xendit_withholding_tax'] = $value['fee']['xendit_withholding_tax'];
        $datas[$key]['fee']['third_party_withholding_tax'] = $value['fee']['third_party_withholding_tax'];
        
    }
  
    foreach($datas as $key=>$node) {

        echo "id                           : ".$node["id"]."\n";
        echo "product_id                   : ".$node["product_id"]."\n";
        echo "type                         : ".$node["type"]."\n";
        echo "status                       : ".$node["status"]."\n";
        echo "channel_category             : ".$node["channel_category"]."\n";
        echo "channel_code                 : ".$node["channel_code"]."\n";
        echo "reference_id                 : ".$node["reference_id"]."\n";
        echo "account_identifier           : ".$node["account_identifier"]."\n";
        echo "currency                     : ".$node["currency"]."\n";
        echo "amount                       : Rp.".formatRp($node["amount"])."\n";
        echo "net_amount                   : Rp.".formatRp($node["net_amount"])."\n";
        echo "cashflow                     : ".$node["cashflow"]."\n";
        echo "business_id                  : ".$node["business_id"]."\n";
        echo "created                      : ".$node["created"]."\n";
        echo "updated                      : ".$node["updated"]."\n";
        echo "xendit_fee                   : Rp.".formatRp($node["fee"]["xendit_fee"])."\n";
        echo "value_added_tax              : Rp.".formatRp($node["fee"]["value_added_tax"])."\n";
        echo "xendit_withholding_tax       : Rp.".formatRp($node["fee"]["xendit_withholding_tax"])."\n";
        echo "third_party_withholding_tax  : Rp.".formatRp($node["fee"]["third_party_withholding_tax"])."\n";
        echo "status                       : ".$node["status"]."\n=========================================================\n";

    }
  }

 ?>