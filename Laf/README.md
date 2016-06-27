## Laf PHP Framework

Laf is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, and caching.

Laf aims to make the development process a pleasing one for the developer without sacrificing application functionality. Happy developers make the best code. To this end, we've attempted to combine the very best of what we have seen in other web frameworks, including frameworks implemented in other languages, such as Ruby on Rails, ASP.NET MVC, and Sinatra.

Laf is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation


### Contributing To Laf


### License

The Laf framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)




### 封装思路
CI 框架提供的基础组件库叫  helpers ，Laravel 使用  illuminate/support  包提供一些可重用的系统函数。

实际上 “illuminate/support” 这个包已经被我们的 ORM 包 “illuminate/database” 依赖了.这个包的中文文档见：http://laravel-
china.org/docs/helpers