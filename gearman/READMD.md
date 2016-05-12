
## Linux中**`Gearman`**安装与使用，分布式消息队列

```txt
概况
   Gearman是一个用来把工作委派给其他机器、分布式的调用更适合做某项工作的机器、并发的做某项工作在多个调用间做负载均衡、或用来在调用其它语言的函数的系统。

组成
 Gearman是一个分发任务的程序架构，由三部分组成：
1）Gearman client：提供gearman client API给应用程序调用。API可以使用C,PHP,PERL,MYSQL UDF等待呢个语言，它是请求的发起者。
2）Gearman job server：将客户端的请求分发到各个gearman worker的调度者，相当于中央控制器，但它不处理具体业务逻辑。
3）Gearman worker：提供gearman worker API给应用程序调用，具体负责客户端的请求，并将处理结果返回给客户端。\

Gearman下载
    1)官网
    http://gearman.org/


    2）官网下载
    https://launchpad.net/gearmand

    3）官网使用向导
    http://gearman.org/getting-started/

安装gearmand

安装php扩展

Gearman启动停止
测试启动
1)sudo ldconfig

2)启动gearmand: gearmand -d &

3）查是否运行
# ps axu | grep gearmand

4）查看监听端口
# netstat -anp | grep 4730

5）停止，直接kill掉进程。

从PHP使用Gearman

创建Worker

启动Worker端
  如果处理的数据量大，可以执行以下脚本多次，即启动多个Worker端。
   # nohup php worker.php > tmp.txt &
   单次
   # php worker.php > tmp.txt &

创建Client


```

