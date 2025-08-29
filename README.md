# 青步健跑微信小程序后端程序


## 小程序代码

<https://github.com/xuribb/qingbujianpao>


## 项目介绍

1. 本项目采用ThinkPHP8 + MongoDB数据库开发。

2. 本项目采用了 *和风天气API* 来获取用户地理位置和当前天气。


## MongoDB数据库配置

1. 创建一个数据库
2. 创建 `user` 集合，并为 `openid` 字段设置文本索引
3. 创建 `record` 集合，并为 `openid` 字段设置文本索引


## 项目部署

0. 运行环境：PHP8(fileinfo扩展，putenv函数)、MongoDB

1. 请配置 `.env.example` 文件信息到 `.env`;

2. 运行目录和伪静态参考ThinkPHP

3. 请给网站配置TSL/SSL证书


## 欢迎评论留言，提建议~
