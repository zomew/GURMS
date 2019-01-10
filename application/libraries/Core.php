<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 核心扩展专用函数
 * @author Jamers
 * @since 2014.9.29 初版 在自制框架内
 * @since 2016.5.14 移植至CI框架
 * @license    http://opensource.org/licenses/MIT    MIT License
 */
class Core {
    /**
     * 用户数组，初始化时需要传入
     *
     * @var mixed
     */
    private $member;
    public $target = array();
    public function __construct($member = array()) {
        $this->member = $member;
    }

    /**
     * 取扩展信息，加载相应资料
     *
     * @param array $act_ary
     * @return array
     */
    function get_ext_list($act_ary=array()) {
        $result = array();
        $s = array();
        $dir = array_merge(glob(APPPATH . "controllers/*.php"),glob(APPPATH . "plugin/cls_*.php"));
        //$dir = array_merge(array(APPPATH.'controllers/Demo.php'),glob(APPPATH . "plugin/cls_*.php"));
        foreach ($dir as $classname) {
            //$cls = substr($classname, strlen(APPPATH . "plugin") + 1, -4);
            $p = '%^'.preg_quote(APPPATH).'(controllers|plugin)[\\\\\/]([^\.]*)\.php$%si';
            preg_match($p, $classname,$m);
            $cls = '';
            $loc = '';
            if (isset($m[1])) $loc = $m[1];
            if (isset($m[2])) $cls = $m[2];
            if (!$cls || array_key_exists($cls, $act_ary)) {
                //如果有这个键值了，直接跳过
            } else {
                include_once($classname);
                //eval("\$mod = new {$cls}();");
                if (class_exists($cls)) {
                    if ($loc == 'plugin') {
                        $mod = new $cls();
                    }else{
                        $ary = get_class_vars($cls);
                        if (isset($ary['_list']) && isset($ary['_name']) && isset($ary['_perm'])) {
                            $mod = new _base($ary);
                        }else{
                            $mod = null;
                        }
                    }
                    $dash = '-';
                    if (isset($mod->plugin)) $dash = '/';
                    if ($mod && isset($mod->admin) && isset($mod->name) && isset($mod->perm) && ($loc != 'plugin' || method_exists($mod, 'autorun'))) {
                        //基本上都有了！
                        if (isset($mod->submenu) && ($mod->submenu)) {
                            $result['SUB'][$cls] = $mod->submenu;
                        } else {
                            $result['SUB'][$cls] = array();
                        }
                        if (isset($mod->target) && ($mod->target)) {
                            $this->target = array_merge($this->target, $mod->target);
                        }
                        if ($mod->perm == "") {
                            $result['EXT'][$cls] = $mod->list;
                        } else {
                            $result['EXT'][$cls] = $this->build_opt($mod->list, $mod->perm, $dash);
                        }
                        $result['ACT'][$cls] = $mod->list;
                        $tmp = explode(',', $mod->name);
                        $result['NAME'][$cls] = $tmp[0];
                        $result['EXECUTE'][$mod->list] = $this->check_perm($mod->list);
                        if ($mod->perm == "") {
                            $result['PERM'][$cls] = NULL;
                        } else {
                            $r = array();
                            $p = explode(',', $mod->perm);
                            if (count($tmp) - count($p) == 1) {
                                for ($i = 1; $i < count($tmp); $i++) {
                                    $dd = $mod->list . $dash . $p[$i - 1];
                                    $r[$dd] = $tmp[$i];
                                    $result['EXECUTE'][$dd] = $this->check_perm($dd, -1);
                                }
                                $result['PERM'][$cls] = $r;
                            } else {
                                $result['PERM'][$cls] = "";
                            }
                            unset($p, $r);
                        }
                        $result['ADMIN'][$cls] = $mod->admin;
                        $result['VISIBLE'][$cls] = $this->check_perm($mod->list, 1);
                        if (isset($mod->order)) {
                            $s[$cls] = $mod->order;
                        } else {
                            $s[$cls] = 100;
                        }
                        //处理自动信息
                        if (isset($mod->auto_msg) && $mod->auto_msg) {
                            if (method_exists($mod, 'auto_msg')) {
                                $result['AUTOMSG'][$cls] = $mod->auto_msg();
                            }
                        }
                    }
                    unset($mod);
                }
            }
        }
        if ($s) asort($s);
        $result['ORDER'] = $s;
        return $result;
    }
    /**
     * 传入操作符，检查是否有权限
     *
     * @param mixed $opt
     * @param mixed $show 1 显示内容, -1 实际权限
     * @return boolean
     */
    function check_perm($opt, $show = 0) {
        if ($this->member['isadmin'] === '1') {
            return true;
        }
        if ($this->get_perm($this->member['perm'], $opt, $show)) {
            return true;
        }
        return false;
    }
    /**
     * 检查是否有操作权限
     *
     * @param mixed $perms   用户权限表
     * @param mixed $opt     操作权限
     * @param mixed $show    -1 强制匹配/0 显示/1 最宽松匹配
     * @return boolean
     */
    function get_perm($perms, $opt, $show = 0) {
        $perms = str_replace('/','-',$perms);
        $opt = str_replace('/','-',$opt);
        if ($show != - 1) {
            if (strpos($opt, '-') > 0) {
                $tmp = explode('-', $opt);
                //echo "{$perms},{$tmp[0]},{$show}=";
                if ($this->get_perm($perms, $tmp[0])) {
                    return true;
                }
            }
        }
        if ($show == 0) {
            //如果是显示的话
            if (isset($tmp)) {
                $p = $tmp[0];
            } else {
                $p = $opt;
            }
            $r = (strpos(' ,' . $perms . ',', ',' . $p . '-') > 0);
            $r = $r || (strpos(' ,' . $perms . ',', ',' . $p . ',') > 0);
            return $r;
        } else {
            return (strpos(' ,' . $perms . ',', ',' . trim($opt) . ',') > 0);
        }
    }
    /**
     * 生成可操作权限清单
     *
     * @param mixed $list
     * @param mixed $perm
     * @param string $dash
     * @return string
     */
    function build_opt($list, $perm, $dash = '-') {
        $result = $list;
        if (strpos($perm, ',') > 0) {
            $tmp = explode(',', trim($perm));
            foreach ($tmp as $v) {
                if (!empty($v)) {
                    $result.= ',' . $list . $dash . $v;
                }
            }
        } else {
            $result = $result . ',' . $list . $dash . trim($perm);
        }
        return $result;
    }
    /**
     * 检查是否已经具有权限
     *
     * @param mixed $extary  所有权限数组
     * @param mixed $perm    当前权限
     * @return array
     */
    function get_checked($extary, $perm) {
        $result = array();
        foreach ($extary['ACT'] as $k => $v) {
            if ($this->get_perm($perm, $v, -1)) {
                $result[$v] = 1;
            } else {
                $result[$v] = 0;
            }
            if (count($extary['PERM'][$k]) > 0) {
                foreach ($extary['PERM'][$k] as $x => $y) {
                    if ($this->get_perm($perm, $x, -1)) {
                        $result[$x] = 1;
                    } else {
                        $result[$x] = 0;
                    }
                }
            }
        }
        return $result;
    }
    /**
     * 将所选择的权限清单连接成权限字符串
     *
     * @param mixed $ary
     * @return string
     */
    function build_str($ary) {
        $result = "";
        asort($ary);
        $ary = array_unique($ary);
        if ($ary) {
            foreach ($ary as $v) {
                $result.= ',' . $v;
            }
        }
        return $result;
    }
}

class _base {
    var $list = '';
    var $name = '';
    var $perm = '';
    var $admin = 0;
    var $submenu;
    var $target;
    var $order = 100;
    var $plugin = false;

    public function __construct($ary = array())
    {
        if (isset($ary['_list'])) $this->list = $ary['_list'];
        if (isset($ary['_name'])) $this->name = $ary['_name'];
        if (isset($ary['_perm'])) $this->perm = $ary['_perm'];
        if (isset($ary['_admin'])) $this->admin = $ary['_admin'];
        if (isset($ary['_submenu'])) $this->submenu = $ary['_submenu'];
        if (isset($ary['_target'])) $this->target = $ary['_target'];
        if (isset($ary['_order'])) $this->order = $ary['_order'];
    }
}
