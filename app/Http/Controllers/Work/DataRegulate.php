<?php

namespace App\Http\Controllers\Work;

use App\Http\Controllers\Controller;
use App\Http\Controllers\System\DataProcessing;
use App\Http\Controllers\System\Export;
use App\Http\Controllers\System\ProjectControl;
use App\Models\OA_Class;
use App\Models\OA_Data;
use App\Models\OA_Project;
use App\Models\OA_Tmp;
use App\Models\OA_User;
use Illuminate\Http\Request;

class DataRegulate extends Controller
{
    public function DataRegulate(Request $request)
    {
        if(empty($request['class']))
        {
            return redirect('/work/data_regulate?class=1,2,3');
        }
        else
            return $this->Show($request, 1);
    }

    public function DataView(Request $request)
    {

        if(empty($request['class']))
        {
            return redirect('/work/data_view?class=1,2,3');
        }
        else
            return $this->Show($request, 0);
    }

    public function DataViewCheck()
    {
        $strIn = '';
        if(empty($_POST['class']))
            $need = [1,2,3];
        else
            $need = $_POST['class'];

        if(!in_array(-1, $need))
            foreach($need as $key => $i)
            {
                if($key == 0)
                    $strIn = $i;
                else
                    $strIn = $strIn.','.$i;
            }
        else
            $strIn = '1,2,3';

        if(!empty($_POST['sort']) && $_POST['sort'][0] == 1)
            return redirect('/work/data_view?class='.$strIn.'&sort=1');

        else
            return redirect('/work/data_view?class='.$strIn);

    }

    public function Show($request, $mode)
    {
        $need = explode(',', str_replace(' ', '', $request['class'])); // php 7+
        $needStr = $request['class'];
        if(!($need === false))
        {
            $dbc = new OA_Class();
            $dbp = new OA_Project();
            $dp = new DataProcessing();

            $needCid = array();

            if(!in_array(1, $need) && !in_array(2, $need) && !in_array(3, $need))
                return redirect('/system/work_error?cause=Url????????????????????????????????????????????????????????????');

            if($mode == 1)
                $str = ' | ????????????(???????????????)???';
            else
                $str = ' | ???????????????';

            foreach($need as $item)
            {
                $needCid = array_merge($needCid, $dbc->GetAllCidByGrade($item));
                $str .= '???'.$item.'?????? ';
            }


            $data = array();
            $sort = 0;

            if(!empty($request['sort']) && $request['sort'] == 1)
            {
                $tmpData = $dp->SortAllData($dp->AllDataCalculate());
                $str .= ' | ??????:???';
                $sort = 1;
            }

            else
            {
                $tmpData = $dp->AllDataCalculate();
                $str .= ' | ??????:???';
            }


            if($tmpData[0])
                $tmp = $tmpData[1];
            else
                return redirect('/system/work_error?cause='.$tmpData[1]); // ????????????


            foreach($tmp as $key=>$item)
            {
                if($key != 0)
                    if(in_array($item[0], $needCid))
                        $data[] = $item;
            }

            $head = $tmp[0];

            if(!empty($request['export']) && $request['export'] == 'download')
            {
                if(sizeof($need) == 3)
                    if(!empty($request['sort']) && $request['sort'] == 1)
                        $fileName = '??????????????????(??????).xlsx';
                    else
                        $fileName = '??????????????????(??????).xlsx';

                else
                    if(!empty($request['sort']) && $request['sort'] == 1)
                        $fileName = '??????????????????(??????).xlsx';
                    else
                        $fileName = '??????????????????(??????).xlsx';

                return (new Export())->DataResultToExcel($tmp, $need, $fileName);
            }

            return view('work.dataView', compact('data', 'mode', 'head', 'str', 'dbc', 'dbp', 'needStr', 'sort'));
        }
        else
        {
            return redirect('/system/work_error?cause=Url????????????????????????????????????????????????????????????');
        }
    }

    public function DataRegulateCheck()
    {
        $strIn = '';
        if(empty($_POST['class']))
            $need = [1,2,3];
        else
            $need = $_POST['class'];

        if(!in_array(-1, $need))
            foreach($need as $key => $i)
            {
                if($key == 0)
                    $strIn = $i;
                else
                    $strIn = $strIn.','.$i;
            }
        else
            $strIn = '1,2,3';

        if(!empty($_POST['sort']) && $_POST['sort'][0] == 1)
            return redirect('/work/data_regulate?class='.$strIn.'&sort=1');

        else
            return redirect('/work/data_regulate?class='.$strIn);
    }

    public function DataRegulateEditCheck(Request $request)
    {
        if(empty($request['cid']))
        {
            return redirect('/system/work_error?cause=Url??????????????????????????????????????????????????????');
        }
        elseif(!empty($request['cmd']) && !empty($request['did']))
        {
            if($request['cmd'] == 'del')
            {
                (new OA_Data())->DelDataByDid((int)$request['did']);
                return redirect('/system/work_success?text=?????????&redirect=work/data_regulate');
            }

            elseif($request['cmd'] == 'again')
            {
                (new OA_Tmp())->AddOneByData((new OA_Data())->GetByDid((int)$request['did']), 4);
                (new OA_Data())->DelDataByDid((int)$request['did']);
                return redirect('/system/work_success?text=???????????????&redirect=work/data_regulate');
            }
            else
                return redirect('/system/work_error?cause=Url??????????????????????????????????????????????????????');
        }
        else
        {
            $dbu = new OA_user();
//        $dbu->GetUsernameByUid();
            $dbc = new OA_Class();
//        $dbc->GetNameByCid();
            $dbp = new OA_Project();
//        $dbp->GetNameByPid();

            $data = (new OA_Data())->ListAll();

            $tmpData = (new DataProcessing())->FormattingDataToString($data);

            if(is_numeric($request['cid']))
                $cid = (int)$request['cid'];
            else
                return redirect('/system/work_error?cause=??????????????????????????????cid???????????????????????????????????????');

            return view('work.dataEdit', compact('data', 'tmpData', 'dbp', 'dbu', 'dbc', 'cid'));
        }
    }
}
