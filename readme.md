# Laravel  EasyUI 构建的后台管理

可以快速构建一个后台管理，中文项目，本实例依赖`zizaco/Entrust`laravel扩展包。

## 实现功能
1. 管理员管理
2. 角色管理
3. 权限管理
4. 菜单管理
5. 操作管理

## 安装
1. 利用 composer 安装依赖
` composer install`
2. 利用.env文件配置数据库
- 复制`.env.example`，重命名`.env`，根据自己情况编辑如下所示的项
```
DB_CONNECTION=mysql
DB_HOST=IP地址
DB_PORT=端口
DB_DATABASE=数据库名
DB_USERNAME=用户名
DB_PASSWORD=密码

## Entrust 角色权限包 需要缓存的驱动是 memcached 或者是 array
CACHE_DRIVER=array
## 管理员新建用户系统自动分配的默认密码
DEFAULT_PSW=123456
```
3. 生成表
`php artisan migrate`
4. 生成基础数据
```
php artisan db:seed
```
