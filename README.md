#RunFramework
自己整理的一款框架，支持千万级别数据扩展，为千万级别数据而生。
包括很简单的就可以实现数据库集群，缓存的应用。

#框架运行需求
在apache配置虚拟主机
在httpd-vhost.conf里面添加

<VirtualHost 127.0.0.1:80>

	#项目位置

    DocumentRoot "C:/wamp/www/run/admin"

    ServerName www.run.com

    DirectoryIndex index.php index.html 

</VirtualHost>

在hosts里面添加（host文件位置：C:\Windows\System32\drivers\etc\hosts）
127.0.0.1       www.run.com


 **需要openssl扩展** 

 **需要pdo扩展** 

 **需要memcahce扩展,并且安装memcache在你的服务器** 

 **需要在php.ini文件里面把 short_open_tag 设置成On** 

 **如果可以最好把redis也安装上去，框架会有涉及redis的东西**

了解extract()这个函数的作用，如果不了解，你会觉得变量莫名其妙的就出来。
如果页面显示空白或者报错，可以到/log/ 下面查看错误日志来排除错误
缓存必须要了解，不然你调试起来会莫名其妙，怎么都找不到原因        

此框架调试的时候一定要注意缓存问题，在强调一下，一定要注意缓存，不然你会寸步难行，特别是调试的时候

此框架可以快速的搭建数据库和缓存集群，简单配置就可以支持千万级别的数据

联系方式:jimmywsq@163.com

安装完成后登陆用户名 admin  密码 123
