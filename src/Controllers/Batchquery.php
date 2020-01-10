<?php

namespace Rajbatch\Batchquery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Batchquery extends Controller
{
    public function batchUpdate($index='',$table='',$set=[],$clientData=[])
    {   

        try {
            $caseVal = [];
            $setP    = [];
            $caseP   = [];
            $final   = [];
            $alIndx  = [];
            $Qtext   = '';
            $END     = ' END,';

            if($index == ''){
                $index = 'id';
            }
            if($table == ''){
                return "Please specify the table name you want to update";
            }elseif ($set == []) {
                return "Please set which field needs to change";
            }elseif ($clientData == []) {
                return "Please provide proper data and be ensure that it has the Index field and those fields which you want to update";
            }
            $setCount = count($set);
            for($k=0;$k<$setCount;$k++){
                $final[$k] = [];
            }
            foreach($clientData as $key=>$val){
                $i = 0;
                foreach($val as $column=>$value){
                    if($column == $index){
                        $inVal = $value;
                        array_push($alIndx,$value); 
                    }
                    if(in_array($column, $set)){
                        $setText ="`{$column}`= CASE `{$index}`";
                        if(!in_array($setText, $setP)){
                            $setP[] = $setText;
                        }
                        
                        if ($i == $setCount) {
                            $i = 0;
                        }
                        $caseP = "WHEN {$inVal} THEN '{$value}'";
                        if(in_array($setP[$i], $final[$i])){
                            array_push($final[$i],$caseP);
                        }else{
                            array_push($final[$i],$setP[$i],$caseP);
                        }
                        $i++;
                    }
                }
            }
            foreach ($final as $key => $value) {
                $caseVal  = implode(' ',$value);
                $Qtext .= $caseVal.$END;
            }
            $WHERE = implode(',',$alIndx);
            $response = \DB::update("UPDATE `{$table}` SET {$Qtext}`updated_at`=now() WHERE `{$index}` IN ({$WHERE})");
            if($response){
                $resD = [
                    'success' => true,
                    'failed'  => 0,
                    'message' => "Update successfull. {$response} rows affected.",
                ];
            }else{
                $resD = [
                    'success' => 0,
                    'failed'  => true,
                    'message' => "Update failed. {$response} rows affected.",
                ];
            }
            return $resD;
        }
        catch(\Exception $e) {
          //echo 'Message: ' .$e->getMessage();
            $resD = [
                    'success' => 0,
                    'failed'  => true,
                    'message' => $e->getMessage(),
                ];
          return $resD;
        }
    }

    public function batchInsert($table='',$clientData=[])
    {
        try{
            $akey      = '';
            $value    = '';
            $allValue = [];
            if($table == ''){
                return "Please specify the table name you want to update";
            }elseif ($clientData == []) {
                return "Please provide proper data and be ensure that it has the Index field and those fields which you want to update";
            }
            foreach($clientData as $key=>$val){
                
                if($akey){
                    if($akey == array_keys($val)){
                        $allField = implode(',', $akey);
                        $keystring = '('.$allField.')';
                        $valstring = $this->allValSet($val);
                        array_push($allValue, $valstring);
                    }else{
                        return "All key in the array are not same.Please check your array() carefully";
                    }
                }else{
                    $akey  = array_keys($val);
                    $allField = implode(',', $akey);
                    $keystring = '('.$allField.')';
                    $valstring = $this->allValSet($val);
                    array_push($allValue, $valstring);
                }
            }
            $FinalValues = implode(',', $allValue);
            $response = \DB::insert("INSERT INTO `{$table}` {$keystring} VALUES{$FinalValues}");
            if($response==1){
                $resD = [
                    'success' => true,
                    'failed'  => 0,
                    'message' => "Insert successfull",
                ];
            }else{
                $resD = [
                    'success' => 0,
                    'failed'  => true,
                    'message' => "Insert failed",
                ];
            }
            return $resD;
        }catch(\Exception $e) {
            $resD = [
                    'success' => 0,
                    'failed'  => true,
                    'message' => $e->getMessage(),
                ];
          return $resD;
        }       
    }

    public function allValSet($val='')
    {
        if($val){
            $value = array_values($val);
            foreach ($value as $as => $da) {
                $sval  = "'".$da."'";
                unset($value[$as]);
                array_push($value, $sval);
            }
            $implodeVal = implode(",",$value);
            $valstring = '('.$implodeVal.')';
            return $valstring;
        }
    }
}
