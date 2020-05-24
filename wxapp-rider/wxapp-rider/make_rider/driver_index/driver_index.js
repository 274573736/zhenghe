var app = getApp();

Page({
    data: {
        flow: [ {
            title: "提交基本信息",
            des: "根据注册内容如实填写、提交完整信息（姓名、证件、证 件照等）"
        }, {
            title: "代驾平台审核",
            des: "身份证、驾驶证、综合评估以及测评审核（具体以注册城 市为准）"
        }, {
            title: "代驾平台面谈",
            des: "审核通过后，代驾平台与代驾司机进行一对一面谈沟通（了 解个人基本信息）"
        }, {
            title: "培训服务",
            des: "培训代驾司机的个人服务水平"
        }, {
            title: "代驾签约",
            des: "流程结束后进行司机与平台的合同签约，正式成为代驾司 机，并开通司机账号"
        } ]
    },
    onLoad: function(t) {},
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    confirm: function() {
        wx.navigateTo({
            url: "../driver_confirm/driver_confirm"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});