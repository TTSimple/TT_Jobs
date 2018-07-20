# cron

### 1：

`config.ini` 放到 `App/Cron/Conf` 里面

### 2：

给 `App/Cron/Runtime` 目录科协权限

### 3：

切换到 `699pic_cron` 目录下

执行命令

```$xslt
php App/Cron/bin/swoole_server start --d
```