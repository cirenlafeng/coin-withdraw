<h2>
    部署须知：
</h2>
<p>
    1.需要在项目根目录下执行composer update 获取依赖包
</p>
<p>
    2.复制.env.example 为 .env 并编辑数据库名账号密码等
</p>
<p>
    3.确保 /bootstrap 和 /storage 目录有可写权限
</p>
<p>
    4.新建数据库的编码格式需为：utf8mb4_general_ci
</p>
<p>
    5.生产服请使用release分支
</p>
<p>
	在.env最下面添加以下4个配置项：
</p>
<p>
API_KEY=(撒币平台接口的KEY，我来提供)<br>
CALLBACK_DOMAIN=(撒币平台的域名，格式：http://xxx.xxx.com 结尾不要斜杠)<br>
BTC_EXCHANGE_DOMAIN=(交易所平台的域名，格式：http://xxx.xxx.com 结尾不要斜杠)<br>
BTC_API_KEY=(交易所平台接口的KEY，我来提供)<br>
</p>