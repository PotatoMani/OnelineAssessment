<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OA_Tmp extends Model
{
    use HasFactory;

    protected $table = 'OA_Tmp';
    public $timestamps = false;
    protected $primaryKey = 'tid';

    /**
     * @param $pid
     * @param $uid
     * @param $data
     * @param $status
     * @return bool
     */
    public function AddOne($pid, $uid, $cid, $data, $status): bool
    {
        $this->insert([
            'pid'=>$pid,
            'uid'=>$uid,
            'cid'=>$cid,
            'data'=>$data,
            'update_at'=>time(),
            'status'=>$status
        ]);
        return 1;
    }

    /**
     * @param $cid
     * @return bool
     */
    public function CheckEmptyByCid($cid): bool
    {
        if($this->where('cid', $cid)->value('cid') == null)
            return true;
        else
            return false;
    }

    /**
     * @return array
     */
    public function ListAll(): array
    {
        $data = $this->get();
        $result = array();
        foreach($data as $val)
        {
            $js = json_decode($val->data, true);
            $result[] = [
                'tid'=>$val->tid,
                'pid'=>$val->pid,
                'uid'=>$val->uid,
                'cid'=>$val->cid,
                'data'=>$js,
                'update_at'=>$val->update_at,
                'status'=>$val->status
            ];
        }
        return $result;
    }

    /**
     * @param $tid
     * @return mixed
     */
    public function GetByTid($tid)
    {
        return $this->where('tid', $tid)->first();
    }

    /**
     * @param $tid
     * @return mixed
     */
    public function ChangeStatusByTid($tid): bool
    {
        if($this->where('tid', $tid)->value('status') == 2)
            return true;
        else
            return $this->where('tid', $tid)
                ->update(['status' => 2]);
    }

    /**
     * @param $OA_Data
     * @param $status
     * @return mixed
     */
    public function AddOneByData($OA_Data, $status)
    {

        return $this->insert([
            'pid' => $OA_Data->pid,
            'uid' => $OA_Data->uid,
            'cid' => $OA_Data->cid,
            'data' => $OA_Data->data,
            'status'=>$status,
            'update_at' => $OA_Data->update_at
        ]);
    }

    /**
     * @param $tid
     * @return mixed
     */
    public function DelByTid($tid)
    {
        return $this->where('tid', $tid)->delete();
    }
}
