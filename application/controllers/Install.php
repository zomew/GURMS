<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 系统安装控制器
* @author Jamers
* @since 2016.5.17
* @license    http://opensource.org/licenses/MIT    MIT License
*/
class Install extends CI_Controller {
    private $dbconfig;
    private $table = array();    
    public function index() {
        $file = APPPATH."/config/installed.php";
        $this->dbconfig = APPPATH."/config/database.php";
        if (file_exists($file)) {
            $_SESSION['msg'] = '系统已安装，不能重复安装，请直接使用';
            header("Location: /\n");
            exit();
        }else{
            $step = intval($this->input->post('step'));
            if ($step == 0) {
                //首页
                $this->load->view('install');
            }elseif ($step == 1) {
                //安装过程
                if (! $this->create_db_config()) {
                    exit("数据配置文件无法写入，请检查相应权限({$this->dbconfig})");
                }
                
                $this->load->database();
                if ($this->db->db_connect()) {
                    $this->load->dbforge();
                    $clean = (intval($this->input->post('clean'))==1 ? true:false);
                    $this->createtable($clean);
                    $this->insertadmin();
                    file_put_contents($file,date('Y-m-d H:i:s'));
                    exit("系统已安装完成，请<a href='/'>点击这里</a>跳转到首页");
                }else{
                    exit('数据库连接失败，请检查参数后重新安装！');
                }
            }
        }
    }
    
    private function create_db_config() {
        $host = trim($this->input->post('host'));
        $user = trim($this->input->post('user'));
        $pass = $this->input->post('pass');
        $name = trim($this->input->post('name'));
        $prefix = trim($this->input->post('prefix'));
        
        $data = <<<EOT
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|    ['dsn']      The full DSN string describe a connection to the database.
|    ['hostname'] The hostname of your database server.
|    ['username'] The username used to connect to the database
|    ['password'] The password used to connect to the database
|    ['database'] The name of the database you want to connect to
|    ['dbdriver'] The database driver. e.g.: mysqli.
|            Currently supported:
|                 cubrid, ibase, mssql, mysql, mysqli, oci8,
|                 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|    ['dbprefix'] You can add an optional prefix, which will be added
|                 to the table name when using the  Query Builder class
|    ['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|    ['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|    ['cache_on'] TRUE/FALSE - Enables/disables query caching
|    ['cachedir'] The path to the folder where cache files should be stored
|    ['char_set'] The character set used in communicating with the database
|    ['dbcollat'] The character collation used in communicating with the database
|                 NOTE: For MySQL and MySQLi databases, this setting is only used
|                  as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|                 (and in table creation queries made with DB Forge).
|                  There is an incompatibility in PHP with mysql_real_escape_string() which
|                  can make your site vulnerable to SQL injection if you are using a
|                  multi-byte character set and are running versions lower than these.
|                  Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|    ['swap_pre'] A default table prefix that should be swapped with the dbprefix
|    ['encrypt']  Whether or not to use an encrypted connection.
|
|            'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE
|            'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
|
|                'ssl_key'    - Path to the private key file
|                'ssl_cert'   - Path to the public key certificate file
|                'ssl_ca'     - Path to the certificate authority file
|                'ssl_capath' - Path to a directory containing trusted CA certificats in PEM format
|                'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
|                'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not ('mysqli' only)
|
|    ['compress'] Whether or not to use client compression (MySQL only)
|    ['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|                            - good for ensuring strict SQL while developing
|    ['ssl_options']    Used to set various SSL options that can be used when making SSL connections.
|    ['failover'] array - A array with 0 or more data for connections if the main should fail.
|    ['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
|                 NOTE: Disabling this will also effectively disable both
|                 \$this->db->last_query() and profiling of DB queries.
|                 When you run a query, with this setting set to TRUE (default),
|                 CodeIgniter will store the SQL statement for debugging purposes.
|                 However, this may cause high memory usage, especially if you run
|                 a lot of SQL queries ... disable this to avoid that problem.
|
| The \$active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The \$query_builder variables lets you determine whether or not to load
| the query builder class.
*/
\$active_group = 'default';
\$query_builder = TRUE;

\$db['default'] = array(
    'dsn'    => '',
    'hostname' => '{$host}',
    'username' => '{$user}',
    'password' => '{$pass}',
    'database' => '{$name}',
    'dbdriver' => 'mysqli',
    'dbprefix' => '{$prefix}',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
EOT;
        $this->table = array(
        'perm'  =>  "
CREATE TABLE  IF NOT EXISTS `{$prefix}perm` (
  `id` int(11) NOT NULL,
  `perm` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
        'session'   =>  "
CREATE TABLE  IF NOT EXISTS `{$prefix}session` (
  `session_id` varchar(32) NOT NULL,
  `session_ip` varchar(15) DEFAULT NULL,
  `session_member_name` varchar(16) DEFAULT NULL,
  `session_member_id` int(11) DEFAULT NULL,
  `session_member_key` varchar(32) DEFAULT NULL,
  `session_login_time` int(11) DEFAULT NULL,
  `session_running_time` int(11) DEFAULT NULL,
  `session_member_group` varchar(16) DEFAULT NULL,
  `session_login_type` varchar(16) DEFAULT NULL,
  `session_browser` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
        'users' =>  "
CREATE TABLE  IF NOT EXISTS `{$prefix}users` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(16) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `name` varchar(16) DEFAULT NULL,
  `lastlogin` int(11) DEFAULT NULL,
  `enable` tinyint(4) DEFAULT NULL,
  `isadmin` tinyint(4) DEFAULT NULL,
  `member_login_key` varchar(32) DEFAULT NULL,
  `member_login_key_expire` int(11) DEFAULT NULL,
  `mgroup` int(11) DEFAULT NULL,
  `wtid` varchar(16) DEFAULT NULL,
  `last_activity` int(11) DEFAULT NULL,
  PRIMARY KEY (`UID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
            'group' => "
CREATE TABLE IF NOT EXISTS `{$prefix}group` (
`id`  int NOT NULL AUTO_INCREMENT ,
`name`  varchar(200) NOT NULL COMMENT '组名' ,
`perm`  text NULL COMMENT '组别权限' ,
`status` tinyint(4) NULL DEFAULT 1 COMMENT '状态：1正常 0禁用',
`memo` varchar(100) NULL COMMENT '备注',
PRIMARY KEY (`id`),
INDEX `i_id` (`id`) 
);
            ",
    );

        return file_put_contents($this->dbconfig,$data);
    }
    
    private function createtable($clean = false) {
        foreach ($this->table as $k=>$v) {
            if ($clean) {
                if ($k) {
                    $this->dbforge->drop_table($k,true);
                }
            }
            $this->db->query($v);
        }
    }
    
    private function insertadmin() {
        $u = array( 'user'  =>  trim($this->input->post('admin')),
                    'pass'  =>  hash('sha256',$this->input->post('password1')),
                    'name'  =>  '管理员',
                    'enable'=>  1,
                    'isadmin'=> 1,
                    'wtid'  =>  'Admin',
        );
        $this->db->insert('users',$u);
    }
}

