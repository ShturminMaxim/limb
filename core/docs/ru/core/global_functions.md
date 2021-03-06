# Глобальные функции Limb3 из пакета CORE
Пакет CORE содержит набор следующих служебных функций:

## Функции для подключения классов и отложенной загрузки кода ( lmb_require_* )
Функция | Назначение | Пример использования
--------|------------|---------------------
lmb_require($file_path, $optional = false) | Типичное назначение данной функции — пометить какой-либо файл с классом для [отложенной загрузки](./lazy_include.md), которая произойдет в autoload. Однако реальная работа этой функции будет зависеть от того, какой парамет в нее пришел в $file_path. Если пришел путь до файла с Limb3 классов, например, limb/core/src/lmbObject.class.php, тогда lmb_require запомнит, что класс lmbObject лежит в файле limb/core/src/lmbObject.class.php и при необходимости подключит его. Если пришел путь в виде limb/core/src/*.class.php, то lmb_require найдет и пометит для себя все файлы классов, находящиеся в данной директории. Если же парамет $file_path имеет иной вид, без суффикса .class.php, тогда lmb_require() работает полностью как обычная php-функция require_once(). Обратите внимание, что lmb_require, если использована * (звездочка) не ищет файлы рекурсивно вниз по иерархии) Если параметр $optional = true, то это означает, что подключение файла опционально и не найденный файл не вызовет ошибки. | lmb_require('limb/core/common.inc.php')
lmb_require_optional($file_path) | Алиас для вызова lmb_require($file_path, true) | |
lmb_autoload($path) | Функция для подключение файла класса ранее помеченного к загрузке через lmb_require(). Эта функция автоматически подключается как одна из autoload-функции при помощи spl_autoload_register() в файле common.inc.php | |

## Функции для подключения пакетов ( lmb_package_* )

Пример подключения пакета находится во [введении в пакетную систему Limb](../../../../docs/ru/packages_architecture.md).

Функция | Описание | Пример
--------|----------|-------
void **lmb_package_require** ( string *$package_name* [, string *$custom_packages_dir* = ''] ) | Подключение пакета **$package_name**. Если указан дополнительный параметр **$custom_package_dir**, то подключается пакет из этой директории. Иначе используется значение переменной окружения LIMB_PACKAGES_DIR. | lmb_package_require('active_record'); lmb_package_require('ldap_auth', '/usr/local/lib/php/auth');
void **lmb_package_register** ( string *$package_name* ) | Регистрация пакета **$package_name**, как подключенного. | lmb_package_register(ldap_auth', dirname(FILE));
bool **lmb_package_registered** ( string *$package_name* ) | Проверка подключения пакета **$package_name**. | lmb_package_registered('ldap_auth');
array **lmb_packages_list** ( void ) | Возвращает список подключенных пакетов. | lmb_packages_list();
string **lmb_package_get_path** ( string *$package_name* ) | Возвращает путь до указанного пакета, зарегистрированного в системе. | lmb_package_get_path('ldap_auth');
void **lmb_require_package_class** ( string *$package_name*, string *$class_name* ) | Подключает класс из директории src пакета. | lmb_package_get_path('ldap_auth', 'AuthService');

## Функции для работы с переменными окружения ( lmb_env_* )
Функция | Описание
--------|---------
**lmb_env_set** ( string *$name*, mixed *$value* ); | Устанавливает переменную окружения
**lmb_env_setor** ( string *$name*, mixed *$value* ); | Устанавливает переменную, если она не была установлена ранее
mixed **lmb_env_get** ( string *$name*, [ mixed *$def* ] ); | Возвращает значение переменной. Параметр **$def** возвращается в том случае, если переменная не определена
bool **lmb_env_has** ( string *$name* ); | Возвращает **true**, если переменная определена, и **false** в противном случае
**lmb_env_remove** ( string *$name* ); | Удаляет переменную
**lmb_env_trace** ( string *$name* ); | Включает «слежение» за переменной
**lmb_env_trace_has** ( string *$name* ); | Возвращает **true**, если за переменной ведется «слежение», и **false** в противном случае
**lmb_env_show** ( ); | Выводит результат «слежения»

Пример работы с переменными окружения:

    var_dump(lmb_env_get('foo')); // null
    var_dump(lmb_env_has('foo')); // false
 
    lmb_env_set('foo', 'bar');
    var_dump(lmb_env_get('foo')); // bar
    var_dump(lmb_env_has('foo')); // true
 
    lmb_env_setor('foo', 'baz');
    var_dump(lmb_env_get('foo')); // bar
 
    lmb_env_remove('foo');
    var_dump(lmb_env_get('foo')); // null
    var_dump(lmb_env_has('foo')); // false
 
    lmb_env_trace('foo');
    lmb_env_set('foo', 'zoo');
    var_dump(lmb_env_trace_show('foo')); // Called example.php@20 lmb_env_set('foo', 'zoo')

## Функции для перевода из одного стиля написания строк в другой
Функция | Назначение | Пример использования
--------|------------|---------------------
string **string lmb_under_scores** ( string *$string* ) | Переводит строку в under_scores | lmb_under_scores('MyData'); /* вернет my_data */
string **lmb_camel_case** ( string *$string* ) | Переводит строку в CamelCase | lmb_camel_case('my_data'); /* вернет MyData */
string **lmb_humanize** ( string *$string* ) | Переводит строку в «удобную для просмотра человеком» | lmb_humanize('MyData'); /* вернет my data */
string **lmb_plural** ( string *$word* ) | Переводит слово во множественное число на английском языке | lmb_plural('half'); /* вернет halves */

## Функции для работы с относительными путями с учетом include_path
Функция | Назначение | Пример использования
--------|------------|---------------------
**lmb_is_path_absolute($path)** | Возращает true, если $path — абсолютный. Реализована достаточно тривиальная проверка, но которой хватает в 99% случаев. | lmb_is_path_absolute('limb/core/common.inc.php') /* вернет false */
**lmb_get_include_path_items()** | Возвращает в виде массива элементы include_path | lmb_get_include_path_items();
**lmb_is_readable($path)** | Возвращает true, если файл существует. Учитывает то, что путь до файла может быть относительным include_path. Необходимость этой функции появилась из-за того, что php-функция file_exists() не учитывает include_path, а fopen() — учитывает. | lmb_is_readable('limb/core/common.inc.php');
**lmb_resolve_include_path($path)** | Находит абсолютный путь до файла по относительному имени с учетом include_path | lmb_resolve_include_path('limb/core/common.inc.php'); /* вернет что-то типа /var/dev/limb/core/common.inc.php */
**lmb_glob($glob)** | Аналог php-glob() с тем отличием, что если дан относительный путь, то он будет рассмотрен у учетом include_path, и функция в этом случае вернет объединенный результат | lmb_glob('limb/*/src/');

## Дополнительные служебные функции
Функция | Назначение | Пример использования
--------|------------|---------------------
**lmb_var_dump($obj, $echo = false)** | Выводит или возвращает (завис от параметра echo) значение var_dump от $obj | lmb_var_dump($my_object);
