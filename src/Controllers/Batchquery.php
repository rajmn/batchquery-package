<?php

namespace Rajbatch\Batchquery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Batchquery extends Controller
{
    public function batchUpdate(Request $request)
    {   
        $caseVal = [];
        $setP    = [];
        $caseP   = [];
        $final   = [];
        $alIndx  = [];
        $Qtext   = '';
        $END     = '';
        $clientData    = [
            [
                'id'=>2,
                'status'=>5,
                'name'  =>'Prasun'
            ],
            [
                'id'=>3,
                'status'=>5,
                'name'  =>'Kumar'
            ],
            [
                'id'=>4,
                'status'=>5,
                'name'  =>'Mondal'
            ],
        ];
        //*** Needs to be set by Client ***//
        $index  = 'id';
        $table  = 'books';
        $set    = ['status','name'];
        /*************************************/
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
            if($Qtext!=''){
                $END = ' END,';
            }
            $Qtext = $Qtext.$END.$caseVal.$END;
        }
        $WHERE = implode(',',$alIndx);
        return \DB::update("UPDATE `{$table}` SET {$Qtext}`updated_at`=now() WHERE `{$index}` IN ({$WHERE})");
    }
}
