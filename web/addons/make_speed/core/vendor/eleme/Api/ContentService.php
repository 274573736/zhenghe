<?php

namespace ElemeOpenApi\Api;

/**
 * 视频服务
 */
class ContentService extends RpcService
{

    /** 建立视频与相对应的业务的关联关系
     * @param $video_id 视频Id
     * @param $biz_id 业务Id(如业务类型为GOOD，业务Id为商品Id)
     * @param $bind_biz_type 业务类型
     * @return mixed
     */
    public function set_video_bind_relation($video_id, $biz_id, $bind_biz_type)
    {
        return $this->client->call("eleme.content.setVideoBindRelation", array("videoId" => $video_id, "bizId" => $biz_id, "bindBizType" => $bind_biz_type));
    }

    /** 取消视频与对应业务的关联关系
     * @param $video_id 视频Id
     * @param $biz_id 业务Id(如业务类型为GOOD，业务Id为商品Id)
     * @param $bind_biz_type 业务类型
     * @return mixed
     */
    public function unset_video_bind_relation($video_id, $biz_id, $bind_biz_type)
    {
        return $this->client->call("eleme.content.unsetVideoBindRelation", array("videoId" => $video_id, "bizId" => $biz_id, "bindBizType" => $bind_biz_type));
    }

    /** 通过视频id查询视频信息
     * @param $video_id 视频Id
     * @return mixed
     */
    public function get_video_info($video_id)
    {
        return $this->client->call("eleme.content.getVideoInfo", array("videoId" => $video_id));
    }

    /** 通过视频id获取所有相关联的业务关系
     * @param $video_id 视频Id
     * @return mixed
     */
    public function get_video_bind_info($video_id)
    {
        return $this->client->call("eleme.content.getVideoBindInfo", array("videoId" => $video_id));
    }

}