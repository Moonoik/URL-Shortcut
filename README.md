# URL Shortcut

URL Shortcut은 긴 URL 주소를 짧게 만들어 주는 기능을 말한다.

  - .htaccess - 디렉토리 설정 변경
  - index.php - URL Shortcut 기능이 구현되어 있는 PHP 파일

### Installation

```sh
$ mysql -uDB유저 -pDB비밀번호 DB명
mysql> CREATE TABLE shortcut ( idx bigint(11) auto_increment primary key, url text, shortcut text );
mysql> exit
```

### Demo

* [HEPSTARKR]

### License
MIT

   [HEPSTARKR]: <https://hepstar.kr/fb/?md=create>
