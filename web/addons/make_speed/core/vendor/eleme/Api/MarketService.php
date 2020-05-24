<?php

namespace ElemeOpenApi\Api;

/**
 * 服务市场服务
 */
class MarketService extends RpcService
{

    /** 同步某一段时间内的服务市场消息
     * @param $start 开始时间
     * @param $end 结束时间
     * @param $offset 消息偏移量
     * @param $limit 查询消息数
     * @return mixed
     */
    public function sync_market_messages($start, $end, $offset, $limit)
    {
        return $this->client->call("eleme.market.syncMarketMessages", array("start" => $start, "end" => $end, "offset" => $offset, "limit" => $limit));
    }

    /** 创建内购项目订单
     * @param $request 创建订单请求信息
     * @return mixed
     */
    public function create_order($request)
    {
        return $this->client->call("eleme.market.createOrder", array("request" => $request));
    }

    /** 查询服务市场订单
     * @param $order_no 服务市场订单编号
     * @return mixed
     */
    public function query_order($order_no)
    {
        return $this->client->call("eleme.market.queryOrder", array("orderNo" => $order_no));
    }

    /** 服务市场确认订单
     * @param $order_no 服务市场订单编号
     * @return mixed
     */
    public function confirm_order($order_no)
    {
        return $this->client->call("eleme.market.confirmOrder", array("orderNo" => $order_no));
    }

}