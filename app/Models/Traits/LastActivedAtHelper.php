<?php
/**
 * Created by PhpStorm.
 * User: denny
 * Date: 2019-06-20
 * Time: 16:50
 */

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

trait LastActivedAtHelper
{

    protected $hash_prefix = 'larabbs_last_actived_at_';
    protected $field_prefix = 'user_';

    /**
     * 记录用户数据
     */
    public function recordLastActivedAt()
    {
        //redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-10
        $hash = $this->hash_prefix . Carbon::now()->toDateString();
        // 字段名称，如：user_1
        $field = $this->field_prefix . $this->id;
        // 当前时间，如：2017-10-21 08：35：15
        $now = Carbon::now()->toDateTimeString();
        // 数据写入 Redis，字段已存在会被更新
        Redis::hSet($hash, $field, $now);
    }

    /**
     * 同步用户数据
     */
    public function syscUserActivedAt()
    {
        $hash = $this->getHashFromDateString(Carbon::yesterday()->toDateString());
        //从redis中获取所有哈希表的数据
        $dataList = Redis::hGetALL($hash);

        // 遍历，并同步到数据库中
        foreach ($dataList as $key => $actived_at) {
            // 会将`user_1`转换为1
            $user_id = str_replace($this->field_prefix, '', $key);
            // 只有当用户存在是才更新到数据库中
            if ($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }
        // 以数据为中心的存储，即已同步，即可删除
        Redis::del($hash);

    }

    /**
     * 获取最新活动时间
     *
     * @param $value
     * @return Carbon
     */
    public function getLastActivedAtAttribute($value)
    {

        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        $field = $this->getHashField();

        $dateteime = Redis::hGet($hash, $field) ?:  $value;

        if ($dateteime) {
            return new Carbon($dateteime);
        } else {

            return $this->created_at;
        }
    }

    /**
     * 获得hash表命名
     *
     * @param $date
     * @return string
     */
    protected function getHashFromDateString($date)
    {
        return $this->hash_prefix . $date;
    }

    /**
     * 获得字段名称
     *
     * @return string
     */
    protected function getHashField()
    {
        return $this->field_prefix . $this->id;
    }
}
