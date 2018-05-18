<?php
return array(
    //项目缓存前缀
    'REDIS_INDEX' => 'Studio-V3_',

    //答题模块
    'QA'          => array(
        //是否开启用户验证
        'QA_CHECK_APP_USER_ID'                => 'QaCheckAppUserId',
        //基本分数
        'QA_BASE_SCORE'                       => 100,
        //用户信息队列
        'QA_USER_QUEUE'                       => 'QaUserQueue',
        //用户信息Hash列表
        'QA_USER_INFO'                        => 'QaUserInfo',
        //奖品队列
        'QA_LUCKY_PRIZE_QUEUE'                => 'QaLuckyPrizeQueue',
        //奖品领取记录
        'QA_LUCKY_USER_GET_PRIZE'             => 'QaLuckyUserGetPrize',
        //奖品领取队列
        'QA_LUCKY_USER_GET_PRIZE_QUEUE'       => 'QaLuckyUserGetPrizeQueue',
        //奖品领取备份队列
        'QA_LUCKY_USER_GET_PRIZE_CLONE_QUEUE' => 'QaLuckyUserGetPrizeCloneQueue',
        //每轮中奖用户榜单
        'GROUP_QA_LUCKY_USER'                 => 'GroupQaLuckyUser',
        //每期中奖用户队列
        'STAGE_QA_LUCKY_USER'                 => 'StageQaLuckyUser',
        //总中奖用户队列
        'TOTAL_QA_LUCKY_USER'                 => 'TotalQaLuckyUser',
        //每期参与答题人数基数
        'STAGE_USER_JOIN_BASE'                => 'StageQaUserJoinBase',
        //每轮参与答题人数基数
        'GROUP_USER_JOIN_BASE'                => 'GroupQaUserJoinBase',
        //推送答题时间偏移量
        'PUSH_OFFSET'                         => 'QaPushOffset',
        //题目HASH列表
        'QA_LIST'                             => 'QaList',
        //期数信息Hash列表
        'QA_STAGE_INFO'                       => 'QaStageInfo',
        //分组信息Hash列表
        'QA_GROUP_INFO'                       => 'QaGroupInfo',
        //当前推送题目
        'QA_CURRENT'                          => 'QaCurrent',
        //提交答案队列
        'QA_ANSWER_QUEUE'                     => 'QaAnswerQueue',
        //提交答案备份队列
        'QA_ANSWER_CLONE_QUEUE'               => 'QaAnswerCloneQueue',
        //每期推送分组记录
        'QA_USED_STAGE_GROUP'                 => 'QaUsedStageGroup',
        //提交记录
        'QA_ANSWER_ONCE_LOG'                  => 'QaAnswerOnceLog',
        //单题记录
        'ONE_QA_ANSWER_LOG'                   => 'OneQaAnswerLog',
        //分组记录
        'GROUP_QA_ANSWER_LOG'                 => 'GroupQaAnswerLog',
        //分期记录
        'STAGE_QA_ANSWER_LOG'                 => 'StageQaAnswerLog',
        //'总记录'
        'TOTAL_QA_ANSWER_LOG'                 => 'TotalQaAnswerLog',
        //单题排行
        'ONE_QA_RANKING_LIST'                 => 'OneQaRankingList',
        //分组排行
        'GROUP_QA_RANKING_LIST'               => 'GroupQaRankingList',
        //期数排行
        'STAGE_QA_RANKING_LIST'               => 'StageQaRankingList',
        //总排行
        'TOTAL_QA_RANKING_LIST'               => 'TotalQaRankingList',
        //命令
        'CMD'                                 => array(
            'PUSH_QA'        => 'FT',
            'PUSH_QA_ANSWER' => 'FDA',
        ),
        //服务器地址
        'QA_SERVER'                           => 'QaServerPath',
        'QA_SERVER_PATH'                      => array(
            'TIME' => 'time'
        ),
        //短信通知
        'SMS_NOTICE'                          => 'SmsNotice',
        'SMS_PHONES'                          => 'SmsPhones',
        'SMS_LAST_SEND'                       => 'SmsLastSend'
    ),
);
