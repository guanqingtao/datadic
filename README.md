# datadic
这是一个web版本的数据字典。由于数据结构经常变更，维护文档变得十分麻烦。于是想做个web版的数据字典。数据机构变更什么的就让程序去完成变更吧，也算是解放dba的部分压力了。
这个东东使用thinkphp3.2作为开发框架的，同学们可以到http://www.thinkphp.cn/了解。基本上安装好现在比较流行的lamp环境就可以运行了。
假设已经安装好环境了，部署方法如下：
1、将datadic整个文件放到你的www目录下
2、导入datadic.sql到你的数据库
3、修改datadic/Application/Common/Conf/config.php 文件：
   其中'DB_CONFIG1'是你本地的数据库
   'DB_CONFIG2'这个是另外的数据源，暂时不必理--开始想直接填生产的数据库，但基于安全不要这样了。
   'DB_MONGO1'这个是mongodb的数据源，如要监控mongodb，则配上。datadic可以监控mongodb的慢查询。其他的功能可以自己加的。
   'evn' 这个其实是个变量，只是在前端给予输出的变量
4、datadic可以监控mysql的慢查询，实际上原理是通过pt-query-digest工具将slow-sql分析出来放到数据库里面，再通过php读出来而已。

再说说同步表结构的原理，其实datadic是到目标数据库的information_schema下，查询TABLES和COLUMNS两个表得到表结构的，在用同样的方法到源数据库下查询，得到结果后放到本地数据库。
