<?php

/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
* @version 4.8.1
*/function adminer_errors($cc, $ec)
{
    return!!preg_match('~^(Trying to access array offset on value of type null|Undefined array key)~', $ec);
}error_reporting(6135);
set_error_handler('adminer_errors', E_WARNING);
$wc = !preg_match('~^(unsafe_raw)?$~', ini_get("filter.default"));
if ($wc || ini_get("filter.default_flags")) {
    foreach (array('_GET','_POST','_COOKIE','_SERVER') as $X) {
        $fh = filter_input_array(constant("INPUT$X"), FILTER_UNSAFE_RAW);
        if ($fh) {
            $$X = $fh;
        }
    }
}if (function_exists("mb_internal_encoding")) {
    mb_internal_encoding("8bit");
}function connection()
{
    global$g;
    return$g;
}function adminer()
{
    global$c;
    return$c;
}function version()
{
    global$fa;
    return$fa;
}function idf_unescape($v)
{
    if (!preg_match('~^[`\'"]~', $v)) {
        return$v;
    }$wd = substr($v, -1);return
    str_replace($wd . $wd, $wd, substr($v, 1, -1));
}function escape_string($X)
{
    return
    substr(q($X), 1, -1);
}function number($X)
{
    return
    preg_replace('~[^0-9]+~', '', $X);
}function number_type()
{
    return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';
}function remove_slashes($kf, $wc = false)
{
    if (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) {
        while (list($z,$X) = each($kf)) {
            foreach (
                $X as $od => $W
            ) {
                unset($kf[$z][$od]);
                if (is_array($W)) {
                    $kf[$z][stripslashes($od)] = $W;
                    $kf[]=&$kf[$z][stripslashes($od)];
                } else {
                    $kf[$z][stripslashes($od)] = ($wc ? $W : stripslashes($W));
                }
            }
        }
    }
}function bracket_escape($v, $_a = false)
{
    static $Sg = array(':' => ':1',']' => ':2','[' => ':3','"' => ':4');return
            strtr($v, ($_a ? array_flip($Sg) : $Sg));
}function min_version($uh, $Id = "", $h = null)
{
    global$g;
    if (!$h) {
        $h = $g;
    }$Sf = $h->server_info;
    if ($Id && preg_match('~([\d.]+)-MariaDB~', $Sf, $C)) {
        $Sf = $C[1];
        $uh = $Id;
    }return(version_compare($Sf, $uh) >= 0);
}function charset($g)
{
    return(min_version("5.5.3", 0, $g) ? "utf8mb4" : "utf8");
}function script($bg, $Rg = "\n")
{
    return"<script" . nonce() . ">$bg</script>$Rg";
}function script_src($kh)
{
    return"<script src='" . h($kh) . "'" . nonce() . "></script>\n";
}function nonce()
{
    return' nonce="' . get_nonce() . '"';
}function target_blank()
{
    return' target="_blank" rel="noreferrer noopener"';
}function h($lg)
{
    return
            str_replace("\0", "&#0;", htmlspecialchars($lg, ENT_QUOTES, 'utf-8'));
}function nl_br($lg)
{
    return
    str_replace("\n", "<br>", $lg);
}function checkbox($E, $Y, $Na, $sd = "", $te = "", $Ra = "", $td = "")
{
    $K = "<input type='checkbox' name='$E' value='" . h($Y) . "'" . ($Na ? " checked" : "") . ($td ? " aria-labelledby='$td'" : "") . ">" . ($te ? script("qsl('input').onclick = function () { $te };", "") : "");
    return($sd != "" || $Ra ? "<label" . ($Ra ? " class='$Ra'" : "") . ">$K" . h($sd) . "</label>" : $K);
}function optionlist($xe, $Nf = null, $oh = false)
{
    $K = "";foreach (
        $xe as $od => $W
    ) {
        $ye = array($od => $W);
        if (is_array($W)) {
            $K .= '<optgroup label="' . h($od) . '">';
            $ye = $W;
        }foreach (
            $ye as $z => $X
        ) {
            $K .= '<option' . ($oh || is_string($z) ? ' value="' . h($z) . '"' : '') . (($oh || is_string($z) ? (string)$z : $X) === $Nf ? ' selected' : '') . '>' . h($X);
        }
        if (is_array($W)) {
            $K .= '</optgroup>';
        }
    }return$K;
}function html_select($E, $xe, $Y = "", $se = true, $td = "")
{
    if ($se) {
        return"<select name='" . h($E) . "'" . ($td ? " aria-labelledby='$td'" : "") . ">" . optionlist($xe, $Y) . "</select>" . (is_string($se) ? script("qsl('select').onchange = function () { $se };", "") : "");
    }$K = "";foreach (
        $xe as $z => $X
    ) {
        $K .= "<label><input type='radio' name='" . h($E) . "' value='" . h($z) . "'" . ($z == $Y ? " checked" : "") . ">" . h($X) . "</label>";
    }
    return$K;
}function select_input($wa, $xe, $Y = "", $se = "", $Xe = "")
{
    $_g = ($xe ? "select" : "input");
    return"<$_g$wa" . ($xe ? "><option value=''>$Xe" . optionlist($xe, $Y, true) . "</select>" : " size='10' value='" . h($Y) . "' placeholder='$Xe'>") . ($se ? script("qsl('$_g').onchange = $se;", "") : "");
}function confirm($D = "", $Of = "qsl('input')")
{
    return
            script("$Of.onclick = function () { return confirm('" . ($D ? js_escape($D) : lang(0)) . "'); };", "");
}function print_fieldset($u, $Ad, $xh = false)
{
    echo"<fieldset><legend>","<a href='#fieldset-$u'>$Ad</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$u');", ""),"</legend>","<div id='fieldset-$u'" . ($xh ? "" : " class='hidden'") . ">\n";
}function bold($Ga, $Ra = "")
{
    return($Ga ? " class='active $Ra'" : ($Ra ? " class='$Ra'" : ""));
}function odd($K = ' class="odd"')
{
    static $t = 0;
    if (!$K) {
        $t = -1;
    }return($t++ % 2 ? $K : '');
}function js_escape($lg)
{
    return
            addcslashes($lg, "\r\n'\\/");
}function json_row($z, $X = null)
{
    static $xc = true;
    if ($xc) {
        echo"{";
    }if ($z != "") {
        echo($xc ? "" : ",") . "\n\t\"" . addcslashes($z, "\r\n\t\"\\/") . '": ' . ($X !== null ? '"' . addcslashes($X, "\r\n\"\\/") . '"' : 'null');
        $xc = false;
    } else {
        echo"\n}\n";
        $xc = true;
    }
}function ini_bool($cd)
{
    $X = ini_get($cd);
    return(preg_match('~^(on|true|yes)$~i', $X) || (int)$X);
}function sid()
{
    static $K;
    if ($K === null) {
        $K = (SID && !($_COOKIE && ini_bool("session.use_cookies")));
    }return$K;
}function set_password($th, $O, $V, $G)
{
    $_SESSION["pwds"][$th][$O][$V] = ($_COOKIE["adminer_key"] && is_string($G) ? array(encrypt_string($G, $_COOKIE["adminer_key"])) : $G);
}function get_password()
{
    $K = get_session("pwds");
    if (is_array($K)) {
        $K = ($_COOKIE["adminer_key"] ? decrypt_string($K[0], $_COOKIE["adminer_key"]) : false);
    }return$K;
}function q($lg)
{
    global$g;
    return$g->quote($lg);
}function get_vals($I, $d = 0)
{
    global$g;
    $K = array();
    $J = $g->query($I);
    if (is_object($J)) {
        while ($L = $J->fetch_row()) {
            $K[] = $L[$d];
        }
    }return$K;
}function get_key_vals($I, $h = null, $Vf = true)
{
    global$g;
    if (!is_object($h)) {
        $h = $g;
    }$K = array();
    $J = $h->query($I);
    if (is_object($J)) {
        while ($L = $J->fetch_row()) {
            if ($Vf) {
                $K[$L[0]] = $L[1];
            } else {
                $K[] = $L[0];
            }
        }
    }return$K;
}function get_rows($I, $h = null, $m = "<p class='error'>")
{
    global$g;
    $fb = (is_object($h) ? $h : $g);
    $K = array();
    $J = $fb->query($I);
    if (is_object($J)) {
        while ($L = $J->fetch_assoc()) {
            $K[] = $L;
        }
    } elseif (!$J && !is_object($h) && $m && defined("PAGE_HEADER")) {
        echo$m . error() . "\n";
    }return$K;
}function unique_array($L, $x)
{
    foreach (
        $x as $w
    ) {
        if (preg_match("~PRIMARY|UNIQUE~", $w["type"])) {
            $K = array();foreach ($w["columns"] as $z) {
                if (!isset($L[$z])) {
                    continue
                    2;
                }$K[$z] = $L[$z];
            }return$K;
        }
    }
}function escape_key($z)
{
    if (preg_match('(^([\w(]+)(' . str_replace("_", ".*", preg_quote(idf_escape("_"))) . ')([ \w)]+)$)', $z, $C)) {
        return$C[1] . idf_escape(idf_unescape($C[2])) . $C[3];
    }return
                    idf_escape($z);
}function where($Z, $o = array())
{
    global$g,$y;
    $K = array();
    foreach ((array)$Z["where"] as $z => $X) {
        $z = bracket_escape($z, 1);
        $d = escape_key($z);
        $K[] = $d . ($y == "sql" && is_numeric($X) && preg_match('~\.~', $X) ? " LIKE " . q($X) : ($y == "mssql" ? " LIKE " . q(preg_replace('~[_%[]~', '[\0]', $X)) : " = " . unconvert_field($o[$z], q($X))));
        if ($y == "sql" && preg_match('~char|text~', $o[$z]["type"]) && preg_match("~[^ -@]~", $X)) {
            $K[] = "$d = " . q($X) . " COLLATE " . charset($g) . "_bin";
        }
    }foreach ((array)$Z["null"] as $z) {
        $K[] = escape_key($z) . " IS NULL";
    }return
                    implode(" AND ", $K);
}function where_check($X, $o = array())
{
    parse_str($X, $Ma);
    remove_slashes(array(&$Ma));return
    where($Ma, $o);
}function where_link($t, $d, $Y, $ue = "=")
{
    return"&where%5B$t%5D%5Bcol%5D=" . urlencode($d) . "&where%5B$t%5D%5Bop%5D=" . urlencode(($Y !== null ? $ue : "IS NULL")) . "&where%5B$t%5D%5Bval%5D=" . urlencode($Y);
}function convert_fields($e, $o, $N = array())
{
    $K = "";foreach (
        $e as $z => $X
    ) {
        if ($N && !in_array(idf_escape($z), $N)) {
            continue;
        }$ua = convert_field($o[$z]);
        if ($ua) {
            $K .= ", $ua AS " . idf_escape($z);
        }
    }return$K;
}function cookie($E, $Y, $Dd = 2592000)
{
    global$ba;return
    header("Set-Cookie: $E=" . urlencode($Y) . ($Dd ? "; expires=" . gmdate("D, d M Y H:i:s", time() + $Dd) . " GMT" : "") . "; path=" . preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]) . ($ba ? "; secure" : "") . "; HttpOnly; SameSite=lax", false);
}function restart_session()
{
    if (!ini_bool("session.use_cookies")) {
        session_start();
    }
}function stop_session($zc = false)
{
    $nh = ini_bool("session.use_cookies");
    if (!$nh || $zc) {
        session_write_close();
        if ($nh && @ini_set("session.use_cookies", false) === false) {
            session_start();
        }
    }
}function &get_session($z)
{
    return$_SESSION[$z][DRIVER][SERVER][$_GET["username"]];
}function set_session($z, $X)
{
    $_SESSION[$z][DRIVER][SERVER][$_GET["username"]] = $X;
}function auth_url($th, $O, $V, $k = null)
{
    global$Kb;
    preg_match('~([^?]*)\??(.*)~', remove_from_uri(implode("|", array_keys($Kb)) . "|username|" . ($k !== null ? "db|" : "") . session_name()), $C);
    return"$C[1]?" . (sid() ? SID . "&" : "") . ($th != "server" || $O != "" ? urlencode($th) . "=" . urlencode($O) . "&" : "") . "username=" . urlencode($V) . ($k != "" ? "&db=" . urlencode($k) : "") . ($C[2] ? "&$C[2]" : "");
}function is_ajax()
{
    return($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest");
}function redirect($B, $D = null)
{
    if ($D !== null) {
        restart_session();
        $_SESSION["messages"][preg_replace('~^[^?]*~', '', ($B !== null ? $B : $_SERVER["REQUEST_URI"]))][] = $D;
    }if ($B !== null) {
        if ($B == "") {
            $B = ".";
        }header("Location: $B");
        exit;
    }
}function query_redirect($I, $B, $D, $sf = true, $jc = true, $qc = false, $Gg = "")
{
    global$g,$m,$c;
    if ($jc) {
        $hg = microtime(true);
        $qc = !$g->query($I);
        $Gg = format_time($hg);
    }$dg = "";
    if ($I) {
        $dg = $c->messageQuery($I, $Gg, $qc);
    }if ($qc) {
        $m = error() . $dg . script("messagesPrint();");return
        false;
    }if ($sf) {
        redirect($B, $D . $dg);
    }return
    true;
}function queries($I)
{
    global$g;
    static $nf = array();
    static $hg;
    if (!$hg) {
        $hg = microtime(true);
    }if ($I === null) {
        return
        array(implode("\n", $nf),format_time($hg));
    }$nf[] = (preg_match('~;$~', $I) ? "DELIMITER ;;\n$I;\nDELIMITER " : $I) . ";";
    return$g->query($I);
}function apply_queries($I, $S, $fc = 'table')
{
    foreach (
        $S as $Q
    ) {
        if (!queries("$I " . $fc($Q))) {
            return
            false;
        }
    }return
    true;
}function queries_redirect($B, $D, $sf)
{
    list($nf,$Gg) = queries(null);return
    query_redirect($nf, $B, $D, $sf, false, !$sf, $Gg);
}function format_time($hg)
{
    return
    lang(1, max(0, microtime(true) - $hg));
}function relative_uri()
{
    return
    str_replace(":", "%3a", preg_replace('~^[^?]*/([^?]*)~', '\1', $_SERVER["REQUEST_URI"]));
}function remove_from_uri($Le = "")
{
    return
    substr(preg_replace("~(?<=[?&])($Le" . (SID ? "" : "|" . session_name()) . ")=[^&]*&~", '', relative_uri() . "&"), 0, -1);
}function pagination($F, $qb)
{
    return" " . ($F == $qb ? $F + 1 : '<a href="' . h(remove_from_uri("page") . ($F ? "&page=$F" . ($_GET["next"] ? "&next=" . urlencode($_GET["next"]) : "") : "")) . '">' . ($F + 1) . "</a>");
}function get_file($z, $yb = false)
{
    $uc = $_FILES[$z];if (!$uc) {
        return
        null;
    }foreach (
        $uc as $z => $X
    ) {
        $uc[$z] = (array)$X;
    }
    $K = '';
    foreach ($uc["error"] as $z => $m) {
        if ($m) {
            return$m;
        }$E = $uc["name"][$z];
        $Og = $uc["tmp_name"][$z];
        $gb = file_get_contents($yb && preg_match('~\.gz$~', $E) ? "compress.zlib://$Og" : $Og);
        if ($yb) {
            $hg = substr($gb, 0, 3);
            if (function_exists("iconv") && preg_match("~^\xFE\xFF|^\xFF\xFE~", $hg, $yf)) {
                $gb = iconv("utf-16", "utf-8", $gb);
            } elseif ($hg == "\xEF\xBB\xBF") {
                $gb = substr($gb, 3);
            }$K .= $gb . "\n\n";
        } else {
            $K .= $gb;
        }
    }return$K;
}function upload_error($m)
{
    $Od = ($m == UPLOAD_ERR_INI_SIZE ? ini_get("upload_max_filesize") : 0);
    return($m ? lang(2) . ($Od ? " " . lang(3, $Od) : "") : lang(4));
}function repeat_pattern($Ue, $Bd)
{
    return
    str_repeat("$Ue{0,65535}", $Bd / 65535) . "$Ue{0," . ($Bd % 65535) . "}";
}function is_utf8($X)
{
    return(preg_match('~~u', $X) && !preg_match('~[\0-\x8\xB\xC\xE-\x1F]~', $X));
}function shorten_utf8($lg, $Bd = 80, $pg = "")
{
    if (!preg_match("(^(" . repeat_pattern("[\t\r\n -\x{10FFFF}]", $Bd) . ")($)?)u", $lg, $C)) {
        preg_match("(^(" . repeat_pattern("[\t\r\n -~]", $Bd) . ")($)?)", $lg, $C);
    }return
    h($C[1]) . $pg . (isset($C[2]) ? "" : "<i>â€¦</i>");
}function format_number($X)
{
    return
    strtr(number_format($X, 0, ".", lang(5)), preg_split('~~u', lang(6), -1, PREG_SPLIT_NO_EMPTY));
}function friendly_url($X)
{
    return
    preg_replace('~[^a-z0-9_]~i', '-', $X);
}function hidden_fields($kf, $Yc = array(), $df = '')
{
    $K = false;foreach (
        $kf as $z => $X
    ) {
        if (!in_array($z, $Yc)) {
            if (is_array($X)) {
                hidden_fields($X, array(), $z);
            } else {
                $K = true;
                echo'<input type="hidden" name="' . h($df ? $df . "[$z]" : $z) . '" value="' . h($X) . '">';
            }
        }
    }return$K;
}function hidden_fields_get()
{
    echo(sid() ? '<input type="hidden" name="' . session_name() . '" value="' . h(session_id()) . '">' : ''),(SERVER !== null ? '<input type="hidden" name="' . DRIVER . '" value="' . h(SERVER) . '">' : ""),'<input type="hidden" name="username" value="' . h($_GET["username"]) . '">';
}function table_status1($Q, $rc = false)
{
    $K = table_status($Q, $rc);
    return($K ? $K : array("Name" => $Q));
}function column_foreign_keys($Q)
{
    global$c;
    $K = array();
    foreach ($c->foreignKeys($Q) as $p) {
        foreach ($p["source"] as $X) {
            $K[$X][] = $p;
        }
    }return$K;
}function enum_input($U, $wa, $n, $Y, $Yb = null)
{
    global$c;
    preg_match_all("~'((?:[^']|'')*)'~", $n["length"], $Jd);
    $K = ($Yb !== null ? "<label><input type='$U'$wa value='$Yb'" . ((is_array($Y) ? in_array($Yb, $Y) : $Y === 0) ? " checked" : "") . "><i>" . lang(7) . "</i></label>" : "");
    foreach ($Jd[1] as $t => $X) {
        $X = stripcslashes(str_replace("''", "'", $X));
        $Na = (is_int($Y) ? $Y == $t + 1 : (is_array($Y) ? in_array($t + 1, $Y) : $Y === $X));
        $K .= " <label><input type='$U'$wa value='" . ($t + 1) . "'" . ($Na ? ' checked' : '') . '>' . h($c->editVal($X, $n)) . '</label>';
    }return$K;
}function input($n, $Y, $r)
{
    global$ah,$c,$y;
    $E = h(bracket_escape($n["field"]));
    echo"<td class='function'>";
    if (is_array($Y) && !$r) {
        $ta = array($Y);
        if (version_compare(PHP_VERSION, 5.4) >= 0) {
            $ta[] = JSON_PRETTY_PRINT;
        }$Y = call_user_func_array('json_encode', $ta);
        $r = "json";
    }$_f = ($y == "mssql" && $n["auto_increment"]);
    if ($_f && !$_POST["save"]) {
        $r = null;
    }$Gc = (isset($_GET["select"]) || $_f ? array("orig" => lang(8)) : array()) + $c->editFunctions($n);
    $wa = " name='fields[$E]'";if ($n["type"] == "enum") {
        echo
        h($Gc[""]) . "<td>" . $c->editInput($_GET["edit"], $n, $wa, $Y);
    } else {
        $Pc = (in_array($r, $Gc) || isset($Gc[$r]));
        echo(count($Gc) > 1 ? "<select name='function[$E]'>" . optionlist($Gc, $r === null || $Pc ? $r : "") . "</select>" . on_help("getTarget(event).value.replace(/^SQL\$/, '')", 1) . script("qsl('select').onchange = functionChange;", "") : h(reset($Gc))) . '<td>';
        $ed = $c->editInput($_GET["edit"], $n, $wa, $Y);
        if ($ed != "") {
            echo$ed;
        } elseif (preg_match('~bool~', $n["type"])) {
            echo"<input type='hidden'$wa value='0'>" . "<input type='checkbox'" . (preg_match('~^(1|t|true|y|yes|on)$~i', $Y) ? " checked='checked'" : "") . "$wa value='1'>";
        } elseif ($n["type"] == "set") {
            preg_match_all("~'((?:[^']|'')*)'~", $n["length"], $Jd);
            foreach ($Jd[1] as $t => $X) {
                $X = stripcslashes(str_replace("''", "'", $X));
                $Na = (is_int($Y) ? ($Y >> $t) & 1 : in_array($X, explode(",", $Y), true));
                echo" <label><input type='checkbox' name='fields[$E][$t]' value='" . (1 << $t) . "'" . ($Na ? ' checked' : '') . ">" . h($c->editVal($X, $n)) . '</label>';
            }
        } elseif (preg_match('~blob|bytea|raw|file~', $n["type"]) && ini_bool("file_uploads")) {
            echo"<input type='file' name='fields-$E'>";
        } elseif (($Eg = preg_match('~text|lob|memo~i', $n["type"])) || preg_match("~\n~", $Y)) {
            if ($Eg && $y != "sqlite") {
                $wa .= " cols='50' rows='12'";
            } else {
                $M = min(12, substr_count($Y, "\n") + 1);
                $wa .= " cols='30' rows='$M'" . ($M == 1 ? " style='height: 1.2em;'" : "");
            }echo"<textarea$wa>" . h($Y) . '</textarea>';
        } elseif ($r == "json" || preg_match('~^jsonb?$~', $n["type"])) {
            echo"<textarea$wa cols='50' rows='12' class='jush-js'>" . h($Y) . '</textarea>';
        } else {
            $Qd = (!preg_match('~int~', $n["type"]) && preg_match('~^(\d+)(,(\d+))?$~', $n["length"], $C) ? ((preg_match("~binary~", $n["type"]) ? 2 : 1) * $C[1] + ($C[3] ? 1 : 0) + ($C[2] && !$n["unsigned"] ? 1 : 0)) : ($ah[$n["type"]] ? $ah[$n["type"]] + ($n["unsigned"] ? 0 : 1) : 0));
            if ($y == 'sql' && min_version(5.6) && preg_match('~time~', $n["type"])) {
                $Qd += 7;
            }echo"<input" . ((!$Pc || $r === "") && preg_match('~(?<!o)int(?!er)~', $n["type"]) && !preg_match('~\[\]~', $n["full_type"]) ? " type='number'" : "") . " value='" . h($Y) . "'" . ($Qd ? " data-maxlength='$Qd'" : "") . (preg_match('~char|binary~', $n["type"]) && $Qd > 20 ? " size='40'" : "") . "$wa>";
        }echo$c->editHint($_GET["edit"], $n, $Y);
        $xc = 0;foreach (
            $Gc as $z => $X
        ) {
            if ($z === "" || !$X) {
                break;
            }$xc++;
        }if ($xc) {
            echo
            script("mixin(qsl('td'), {onchange: partial(skipOriginal, $xc), oninput: function () { this.onchange(); }});");
        }
    }
}function process_input($n)
{
    global$c,$l;
    $v = bracket_escape($n["field"]);
    $r = $_POST["function"][$v];
    $Y = $_POST["fields"][$v];if ($n["type"] == "enum") {
        if ($Y == -1) {
            return
            false;
        }if ($Y == "") {
            return"NULL";
        }return+$Y;
    }if ($n["auto_increment"] && $Y == "") {
        return
        null;
    }if ($r == "orig") {
        return(preg_match('~^CURRENT_TIMESTAMP~i', $n["on_update"]) ? idf_escape($n["field"]) : false);
    }if ($r == "NULL") {
        return"NULL";
    }if ($n["type"] == "set") {
        return
        array_sum((array)$Y);
    }if ($r == "json") {
        $r = "";
        $Y = json_decode($Y, true);if (!is_array($Y)) {
            return
            false;
        }return$Y;
    }if (preg_match('~blob|bytea|raw|file~', $n["type"]) && ini_bool("file_uploads")) {
        $uc = get_file("fields-$v");if (!is_string($uc)) {
            return
            false;
        }return$l->quoteBinary($uc);
    }return$c->processInput($n, $Y, $r);
}function fields_from_edit()
{
    global$l;
    $K = array();
    foreach ((array)$_POST["field_keys"] as $z => $X) {
        if ($X != "") {
            $X = bracket_escape($X);
            $_POST["function"][$X] = $_POST["field_funs"][$z];
            $_POST["fields"][$X] = $_POST["field_vals"][$z];
        }
    }foreach ((array)$_POST["fields"] as $z => $X) {
        $E = bracket_escape($z, 1);
        $K[$E] = array("field" => $E,"privileges" => array("insert" => 1,"update" => 1),"null" => 1,"auto_increment" => ($z == $l->primary),);
    }return$K;
}function search_tables()
{
    global$c,$g;
    $_GET["where"][0]["val"] = $_POST["query"];
    $Qf = "<ul>\n";
    foreach (table_status('', true) as $Q => $R) {
        $E = $c->tableName($R);
        if (isset($R["Engine"]) && $E != "" && (!$_POST["tables"] || in_array($Q, $_POST["tables"]))) {
            $J = $g->query("SELECT" . limit("1 FROM " . table($Q), " WHERE " . implode(" AND ", $c->selectSearchProcess(fields($Q), array())), 1));
            if (!$J || $J->fetch_row()) {
                $gf = "<a href='" . h(ME . "select=" . urlencode($Q) . "&where[0][op]=" . urlencode($_GET["where"][0]["op"]) . "&where[0][val]=" . urlencode($_GET["where"][0]["val"])) . "'>$E</a>";
                echo"$Qf<li>" . ($J ? $gf : "<p class='error'>$gf: " . error()) . "\n";
                $Qf = "";
            }
        }
    }echo($Qf ? "<p class='message'>" . lang(9) : "</ul>") . "\n";
}function dump_headers($Xc, $Xd = false)
{
    global$c;
    $K = $c->dumpHeaders($Xc, $Xd);
    $Ie = $_POST["output"];
    if ($Ie != "text") {
        header("Content-Disposition: attachment; filename=" . $c->dumpFilename($Xc) . ".$K" . ($Ie != "file" && preg_match('~^[0-9a-z]+$~', $Ie) ? ".$Ie" : ""));
    }session_write_close();
    ob_flush();
    flush();
    return$K;
}function dump_csv($L)
{
    foreach (
        $L as $z => $X
    ) {
        if (preg_match('~["\n,;\t]|^0|\.\d*0$~', $X) || $X === "") {
            $L[$z] = '"' . str_replace('"', '""', $X) . '"';
        }
    }echo
    implode(($_POST["format"] == "csv" ? "," : ($_POST["format"] == "tsv" ? "\t" : ";")), $L) . "\r\n";
}function apply_sql_function($r, $d)
{
    return($r ? ($r == "unixepoch" ? "DATETIME($d, '$r')" : ($r == "count distinct" ? "COUNT(DISTINCT " : strtoupper("$r(")) . "$d)") : $d);
}function get_temp_dir()
{
    $K = ini_get("upload_tmp_dir");
    if (!$K) {
        if (function_exists('sys_get_temp_dir')) {
            $K = sys_get_temp_dir();
        } else {
            $vc = @tempnam("", "");if (!$vc) {
                return
                false;
            }$K = dirname($vc);
            unlink($vc);
        }
    }return$K;
}function file_open_lock($vc)
{
    $q = @fopen($vc, "r+");
    if (!$q) {
        $q = @fopen($vc, "w");
        if (!$q) {
            return;
        }chmod($vc, 0660);
    }flock($q, LOCK_EX);
    return$q;
}function file_write_unlock($q, $sb)
{
    rewind($q);
    fwrite($q, $sb);
    ftruncate($q, strlen($sb));
    flock($q, LOCK_UN);
    fclose($q);
}function password_file($i)
{
    $vc = get_temp_dir() . "/adminer.key";
    $K = @file_get_contents($vc);
    if ($K || !$i) {
        return$K;
    }$q = @fopen($vc, "w");
    if ($q) {
        chmod($vc, 0660);
        $K = rand_string();
        fwrite($q, $K);
        fclose($q);
    }return$K;
}function rand_string()
{
    return
    md5(uniqid(mt_rand(), true));
}function select_value($X, $A, $n, $Fg)
{
    global$c;
    if (is_array($X)) {
        $K = "";foreach (
            $X as $od => $W
        ) {
            $K .= "<tr>" . ($X != array_values($X) ? "<th>" . h($od) : "") . "<td>" . select_value($W, $A, $n, $Fg);
        }
        return"<table cellspacing='0'>$K</table>";
    }if (!$A) {
        $A = $c->selectLink($X, $n);
    }if ($A === null) {
        if (is_mail($X)) {
            $A = "mailto:$X";
        }if (is_url($X)) {
            $A = $X;
        }
    }$K = $c->editVal($X, $n);
    if ($K !== null) {
        if (!is_utf8($K)) {
            $K = "\0";
        } elseif ($Fg != "" && is_shortable($n)) {
            $K = shorten_utf8($K, max(0, +$Fg));
        } else {
            $K = h($K);
        }
    }return$c->selectVal($K, $A, $n, $X);
}function is_mail($Vb)
{
    $va = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]';
    $Jb = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
    $Ue = "$va+(\\.$va+)*@($Jb?\\.)+$Jb";return
        is_string($Vb) && preg_match("(^$Ue(,\\s*$Ue)*\$)i", $Vb);
}function is_url($lg)
{
    $Jb = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';return
        preg_match("~^(https?)://($Jb?\\.)+$Jb(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i", $lg);
}function is_shortable($n)
{
    return
    preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~', $n["type"]);
}function count_rows($Q, $Z, $kd, $s)
{
    global$y;
    $I = " FROM " . table($Q) . ($Z ? " WHERE " . implode(" AND ", $Z) : "");
    return($kd && ($y == "sql" || count($s) == 1) ? "SELECT COUNT(DISTINCT " . implode(", ", $s) . ")$I" : "SELECT COUNT(*)" . ($kd ? " FROM (SELECT 1$I GROUP BY " . implode(", ", $s) . ") x" : $I));
}function slow_query($I)
{
    global$c,$T,$l;
    $k = $c->database();
    $Hg = $c->queryTimeout();
    $Zf = $l->slowQuery($I, $Hg);
    if (!$Zf && support("kill") && is_object($h = connect()) && ($k == "" || $h->select_db($k))) {
        $qd = $h->result(connection_id());echo'<script',nonce(),'>
var timeout = setTimeout(function () {
	ajax(\'',js_escape(ME),'script=kill\', function () {
	}, \'kill=',$qd,'&token=',$T,'\');
}, ',1000 * $Hg,');
</script>
';
    } else {
        $h = null;
    }
    ob_flush();
    flush();
    $K = @get_key_vals(($Zf ? $Zf : $I), $h, false);if ($h) {
        echo
        script("clearTimeout(timeout);");
        ob_flush();
        flush();
    }return$K;
}function get_token()
{
    $qf = rand(1, 1e6);
    return($qf ^ $_SESSION["token"]) . ":$qf";
}function verify_token()
{
    list($T,$qf) = explode(":", $_POST["token"]);
    return($qf ^ $_SESSION["token"]) == $T;
}function lzw_decompress($Da)
{
    $Gb = 256;
    $Ea = 8;
    $Ta = array();
    $Af = 0;
    $Bf = 0;for ($t = 0; $t < strlen($Da); $t++) {
        $Af = ($Af << 8) + ord($Da[$t]);
        $Bf += 8;
        if ($Bf >= $Ea) {
            $Bf -= $Ea;
            $Ta[] = $Af >> $Bf;
            $Af &= (1 << $Bf) - 1;
            $Gb++;
            if ($Gb >> $Ea) {
                $Ea++;
            }
        }
    }$Fb = range("\0", "\xFF");
    $K = "";foreach (
        $Ta as $t => $Sa
    ) {
        $Ub = $Fb[$Sa];
        if (!isset($Ub)) {
            $Ub = $Ch . $Ch[0];
        }$K .= $Ub;
        if ($t) {
            $Fb[] = $Ch . $Ub[0];
        }$Ch = $Ub;
    }return$K;
}function on_help($Za, $Xf = 0)
{
    return
    script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $Za, $Xf) }, onmouseout: helpMouseout});", "");
}function edit_form($Q, $o, $L, $ih)
{
    global$c,$y,$T,$m;
    $ug = $c->tableName(table_status1($Q, true));
    page_header(($ih ? lang(10) : lang(11)), $m, array("select" => array($Q,$ug)), $ug);
    $c->editRowPrint($Q, $o, $L, $ih);
    if ($L === false) {
        echo"<p class='error'>" . lang(12) . "\n";
    }echo'<form action="" method="post" enctype="multipart/form-data" id="form">
';
    if (!$o) {
        echo"<p class='error'>" . lang(13) . "\n";
    } else {
        echo"<table cellspacing='0' class='layout'>" . script("qsl('table').onkeydown = editingKeydown;");foreach (
            $o as $E => $n
        ) {
            echo"<tr><th>" . $c->fieldName($n);
            $zb = $_GET["set"][bracket_escape($E)];
            if ($zb === null) {
                $zb = $n["default"];
                if ($n["type"] == "bit" && preg_match("~^b'([01]*)'\$~", $zb, $yf)) {
                    $zb = $yf[1];
                }
            }$Y = ($L !== null ? ($L[$E] != "" && $y == "sql" && preg_match("~enum|set~", $n["type"]) ? (is_array($L[$E]) ? array_sum($L[$E]) : +$L[$E]) : (is_bool($L[$E]) ? +$L[$E] : $L[$E])) : (!$ih && $n["auto_increment"] ? "" : (isset($_GET["select"]) ? false : $zb)));
            if (!$_POST["save"] && is_string($Y)) {
                $Y = $c->editVal($Y, $n);
            }$r = ($_POST["save"] ? (string)$_POST["function"][$E] : ($ih && preg_match('~^CURRENT_TIMESTAMP~i', $n["on_update"]) ? "now" : ($Y === false ? null : ($Y !== null ? '' : 'NULL'))));
            if (!$_POST && !$ih && $Y == $n["default"] && preg_match('~^[\w.]+\(~', $Y)) {
                $r = "SQL";
            }if (preg_match("~time~", $n["type"]) && preg_match('~^CURRENT_TIMESTAMP~i', $Y)) {
                $Y = "";
                $r = "now";
            }input($n, $Y, $r);
            echo"\n";
        }if (!support("table")) {
            echo"<tr>" . "<th><input name='field_keys[]'>" . script("qsl('input').oninput = fieldChange;") . "<td class='function'>" . html_select("field_funs[]", $c->editFunctions(array("null" => isset($_GET["select"])))) . "<td><input name='field_vals[]'>" . "\n";
        }echo"</table>\n";
    }echo"<p>\n";
    if ($o) {
        echo"<input type='submit' value='" . lang(14) . "'>\n";
        if (!isset($_GET["select"])) {
            echo"<input type='submit' name='insert' value='" . ($ih ? lang(15) : lang(16)) . "' title='Ctrl+Shift+Enter'>\n",($ih ? script("qsl('input').onclick = function () { return !ajaxForm(this.form, '" . lang(17) . "â€¦', this); };") : "");
        }
    }echo($ih ? "<input type='submit' name='delete' value='" . lang(18) . "'>" . confirm() . "\n" : ($_POST || !$o ? "" : script("focus(qsa('td', qs('#form'))[1].firstChild);")));
    if (isset($_GET["select"])) {
        hidden_fields(array("check" => (array)$_POST["check"],"clone" => $_POST["clone"],"all" => $_POST["all"]));
    }echo'<input type="hidden" name="referer" value="',h(isset($_POST["referer"]) ? $_POST["referer"] : $_SERVER["HTTP_REFERER"]),'">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="',$T,'">
</form>
';
}if (isset($_GET["file"])) {
    if ($_SERVER["HTTP_IF_MODIFIED_SINCE"]) {
        header("HTTP/1.1 304 Not Modified");
        exit;
    }header("Expires: " . gmdate("D, d M Y H:i:s", time() + 365 * 24 * 60 * 60) . " GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: immutable");
    if ($_GET["file"] == "favicon.ico") {
        header("Content-Type: image/x-icon");echo
            lzw_decompress("\0\0\0` \0„\0\n @\0´C„è\"\0`EãQ¸àÿ‡?ÀtvM'”JdÁd\\Œb0\0Ä\"™ÀfÓˆ¤îs5›ÏçÑAXPaJ“0„¥‘8„#RŠT©‘z`ˆ#.©ÇcíXÃþÈ€?À-\0¡Im? .«M¶€\0È¯(Ì‰ýÀ/(%Œ\0");
    } elseif ($_GET["file"] == "default.css") {
        header("Content-Type: text/css; charset=utf-8");echo
            lzw_decompress("\n1Ì‡“ÙŒÞl7œ‡B1„4vb0˜Ífs‘¼ên2BÌÑ±Ù˜Þn:‡#(¼b.\rDc)ÈÈa7E„‘¤Âl¦Ã±”èi1ÌŽs˜´ç-4™‡fÓ	ÈÎi7†³¹¤Èt4…¦ÓyèZf4°i–AT«VVéf:Ï¦,:1¦QÝ¼ñb2`Ç#þ>:7Gï—1ÑØÒs°™L—XD*bv<ÜŒ#£e@Ö:4ç§!fo·Æt:<¥Üå’¾™oâÜ\niÃÅð',é»a_¤:¹iï…´ÁBvø|Nû4.5Nfi¢vpÐh¸°l¨ê¡ÖšÜO¦‰î= £OFQÐÄk\$¥Óiõ™ÀÂd2Tã¡pàÊ6„‹þ‡¡-ØZ€Žƒ Þ6½£€ðh:¬aÌ,Ž£ëî2#8Ð±#’˜6nâî†ñJˆ¢h«t…Œ±Šä4O42ô½okÞ¾*r ©€@p@†!Ä¾ÏÃôþ?Ð6À‰r[ðLÁð‹:2Bˆj§!HbóÃPä=!1V‰\"ˆ²0…¿\nSÆÆÏD7ÃìDÚ›ÃC!†!›à¦GÊŒ§ È+’=tCæ©.C¤À:+ÈÊ=ªªº²¡±å%ªcí1MR/”EÈ’4„© 2°ä± ã`Â8(áÓ¹[WäÑ=‰ySb°=Ö-Ü¹BS+É¯ÈÜý¥ø@pL4Ydã„qŠøã¦ðê¢6£3Ä¬¯¸AcÜŒèÎ¨Œk‚[&>ö•¨ZÁpkm]—u-c:Ø¸ˆNtæÎ´pÒŒŠ8è=¿#˜á[.ðÜÞ¯~ mËy‡PPá|IÖ›ùÀìQª9v[–Q•„\n–Ùrô'g‡+áTÑ2…­VÁõzä4£8÷(	¾Ey*#j¬2]­•RÒÁ‘¥)ƒÀ[N­R\$Š<>:ó­>\$;–> Ì\r»„ÎHÍÃTÈ\nw¡N åwØ£¦ì<ïËGwàöö¹\\Yó_ Rt^Œ>Ž\r}ŒÙS\rzé4=µ\nL”%Jã‹\",Z 8¸ž™i÷0u©?¨ûÑô¡s3#¨Ù‰ :ó¦ûã½–ÈÞE]xÝÒs^8Ž£K^É÷*0ÑÞwÞàÈÞ~ãö:íÑiØþv2w½ÿ±û^7ãò7£cÝÑu+U%Ž{PÜ*4Ì¼éLX./!¼‰1CÅßqx!H¹ãFdù­L¨¤¨Ä Ï`6ëè5®™f€¸Ä†¨=Høl ŒV1“›\0a2×;Ô6†àöþ_Ù‡Ä\0&ôZÜS d)KE'’€nµ[X©³\0ZÉŠÔF[P‘Þ˜@àß!‰ñYÂ,`É\"Ú·Â0Ee9yF>ËÔ9bº–ŒæF5:üˆ”\0}Ä´Š‡(\$žÓ‡ë€37Hö£è M¾A°²6R•ú{MqÝ7G ÚC™Cêm2¢(ŒCt>[ì-tÀ/&C›]êetGôÌ¬4@r>ÇÂå<šSq•/åú”QëhmšÀÐÆôãôLÀÜ#èôKË|®™„6fKPÝ\r%tÔÓV=\" SH\$} ¸)w¡,W\0F³ªu@Øb¦9‚\rr°2Ã#¬DŒ”Xƒ³ÚyOIù>»…n†Ç¢%ãù'‹Ý_Á€t\rÏ„zÄ\\1˜hl¼]Q5Mp6k†ÐÄqhÃ\$£H~Í|ÒÝ!*4ŒñòÛ`Sëý²S tíPP\\g±è7‡\n-Š:è¢ªp´•”ˆl‹Bž¦î”7Ó¨cƒ(wO0\\:•Ðw”Áp4ˆ“ò{TÚújO¤6HÃŠ¶rÕ¥q\n¦É%%¶y']\$‚”a‘ZÓ.fcÕq*-êFWºúk„zƒ°µj‘Ž°lgáŒ:‡\$\"ÞN¼\r#ÉdâÃ‚ÂÿÐscá¬Ì „ƒ\"jª\rÀ¶–¦ˆÕ’¼Ph‹1/‚œDA) ²Ý[ÀknÁp76ÁY´‰R{áM¤Pû°ò@\n-¸a·6þß[»zJH,–dl B£ho³ìò¬+‡#Dr^µ^µÙeš¼E½½– ÄœaP‰ôõJG£zàñtñ 2ÇXÙ¢´Á¿V¶×ßàÞÈ³‰ÑB_%K=E©¸bå¼¾ßÂ§kU(.!Ü®8¸œüÉI.@ŽKÍxnþ¬ü:ÃPó32«”míH		C*ì:vâTÅ\nR¹ƒ•µ‹0uÂíƒæîÒ§]Î¯˜Š”P/µJQd¥{L–Þ³:YÁ2b¼œT ñÊ3Ó4†—äcê¥V=¿†L4ÎÐrÄ!ßBðY³6Í­MeLŠªÜçœöùiÀoÐ9< G”¤Æ•Ð™Mhm^¯UÛNÀŒ·òTr5HiM”/¬nƒí³T [-<__î3/Xr(<‡¯Š†®Éô“ÌuÒ–GNX20å\r\$^‡:'9è¶O…í;×k¼†µf –N'a¶”Ç­bÅ,ËV¤ô…«1µïHI!%6@úÏ\$ÒEGÚœ¬1(mUªå…rÕ½ïßå`¡ÐiN+Ãœñ)šœä0lØÒf0Ã½[UâøVÊè-:I^ ˜\$Øs«b\re‡‘ugÉhª~9Ûßˆb˜µôÂÈfä+0¬Ô hXrÝ¬©!\$—e,±w+„÷ŒëŒ3†Ì_âA…kšù\nkÃrõÊ›cuWdYÿ\\×={.óÄ˜¢g»‰p8œt\rRZ¿vJ:²>þ£Y|+Å@À‡ƒÛCt\r€jt½6²ð%Â?àôÇŽñ’>ù/¥ÍÇðÎ9F`×•äòv~K¤áöÑRÐW‹ðz‘êlmªwLÇ9Y•*q¬xÄzñèSe®Ý›³è÷£~šDàÍá–÷x˜¾ëÉŸi7•2ÄøÑOÝ»’û_{ñú53âút˜›_ŸõzÔ3ùd)‹C¯Â\$?KÓªP%ÏÏT&þ˜&\0P×NAŽ^­~¢ƒ pÆ öÏœ“Ôõ\r\$ÞïÐÖìb*+D6ê¶¦ÏˆÞíJ\$(ÈolÞÍh&”ìKBS>¸‹ö;z¶¦xÅoz>íœÚoÄZð\nÊ‹[Ïvõ‚ËÈœµ°2õOxÙVø0fû€ú¯Þ2BlÉbkÐ6ZkµhXcdê0*ÂKTâ¯H=­•Ï€‘p0ŠlVéõèâ\r¼Œ¥nŽm¦ï)((ô:#¦âòE‰Ü:C¨CàÚâ\r¨G\rÃ©0÷…iæÚ°þ:`Z1Q\n:€à\r\0àçÈq±°ü:`¿-ÈM#}1;èþ¹‹q‘#|ñS€¾¢hl™DÄ\0fiDpëL ``™°çÑ0y€ß1…€ê\rñ=‘MQ\\¤³%oq–­\0Øñ£1¨21¬1°­ ¿±§Ñœbi:“í\r±/Ñ¢› `)šÄ0ù‘@¾Â›±ÃI1«NàCØàŠµñO±¢Zñã1±ïq1 òÑüà,å\rdIÇ¦väjí‚1 tÚBø“°â’0:…0ðð“1 A2V„ñâ0 éñ%²fi3!&Q·Rc%Òq&w%Ñì\ràVÈ#Êø™Qw`‹% ¾„Òm*r…Òy&iß+r{*²»(rg(±#(2­(ðå)R@i›-  ˆž•1\"\0Û²Rêÿ.e.rëÄ,¡ry(2ªCàè²bì!BÞ3%Òµ,R¿1²Æ&èþt€äbèa\rL“³-3á Ö ó\0æóBp—1ñ94³O'R°3*²³=\$à[£^iI;/3i©5Ò&’}17²# Ñ¹8 ¿\"ß7Ñå8ñ9*Ò23™!ó!1\\\0Ï8“­rk9±;S…23¶àÚ“*Ó:q]5S<³Á#383Ý#eÑ=¹>~9Sèž³‘rÕ)€ŒT*aŸ@Ñ–ÙbesÙÔ£:-ó€éÇ*;, Ø™3!i´›‘LÒ²ð#1 +nÀ «*²ã@³3i7´1©ž´_•F‘S;3ÏF±\rA¯é3õ>´x:ƒ \r³0ÎÔ@’-Ô/¬ÓwÓÛ7ñ„ÓS‘J3› ç.Fé\$O¤B’±—%4©+tÃ'góLq\rJt‡JôËM2\rôÍ7ñÆT@“£¾)â“£dÉ2€P>Î°€Fià²´þ\nr\0ž¸bçk(´D¶¿ãKQƒ¤´ã1ã\"2t”ôôºPè\rÃÀ,\$KCtò5ôö#ôú)¢áP#Pi.ÎU2µCæ~Þ\"ä");
    } elseif ($_GET["file"] == "functions.js") {
        header("Content-Type: text/javascript; charset=utf-8");echo
        lzw_decompress("f:›ŒgCI¼Ü\n8œÅ3)°Ë7œ…†81ÐÊx:\nOg#)Ðêr7\n\"†è´`ø|2ÌgSi–H)N¦S‘ä§\r‡\"0¹Ä@ä)Ÿ`(\$s6O!ÓèœV/=Œ' T4æ=„˜iS˜6IO G#ÒX·VCÆs¡ Z1.Ðhp8,³[¦Häµ~Cz§Éå2¹l¾c3šÍés£‘ÙI†bâ4\néF8Tà†I˜Ý©U*fz¹är0žEÆÀØyŽ¸ñfŽY.:æƒIŒÊ(Øc·áÎ‹!_l™í^·^(¶šN{S–“)rËqÁY“–lÙ¦3Š3Ú\n˜+G¥Óêyºí†Ëi¶ÂîxV3w³uhã^rØÀº´aÛ”ú¹cØè\r“¨ë(.ÂˆºChÒ<\r)èÑ£¡`æ7£íò43'm5Œ£È\nPÜ:2£P»ªŽ‹q òÿÅC“}Ä«ˆúÊÁê38‹BØ0ŽhR‰Èr(œ0¥¡b\\0ŒHr44ŒÁB!¡pÇ\$ŽrZZË2Ü‰.Éƒ(\\Ž5Ã|\nC(Î\"€P…ðø.ÐNÌRTÊÎ“Àæ>HN…8HPá\\¬7Jp~„Üû2%¡ÐOC¨1ã.ƒ§C8Î‡HÈò*ˆj°…á÷S(¹/¡ì¬6KUœÊ‡¡<2‰pOI„ôÕ`Ôäâ³ˆdOH Þ5-üÆ4ŒãpX25-Ò¢òÛˆ°z7£¸\"(°P \\32:]UÚèíâß…!]¸<·AÛÛ¤’ÐßiÚ°‹l\rÔ\0v²Î#J8«ÏwmžíÉ¤¨<ŠÉ æü%m;p#ã`XDŒø÷iZøN0Œ•È9ø¨å Áè`…ŽwJD¿¾2Ò9tŒ¢*øÎyìËNiIh\\9ÆÕèÐ:ƒ€æáxï­µyl*šÈˆÎæY Ü‡øê8’W³â?µŽÞ›3ÙðÊ!\"6å›n[¬Ê\r­*\$¶Æ§¾nzxÆ9\rì|*3×£pÞï»¶ž:(p\\;ÔËmz¢ü§9óÐÑÂŒü8N…Áj2½«Î\rÉHîH&Œ²(Ãz„Á7iÛk£ ‹Š¤‚c¤‹eòžý§tœÌÌ2:SHóÈ Ã/)–xÞ@éåt‰ri9¥½õëœ8ÏÀËïyÒ·½°ŽVÄ+^WÚ¦­¬kZæY—l·Ê£Œ4ÖÈÆ‹ª¶À¬‚ð\\EÈ{î7\0¹p†€•D€„i”-TæþÚû0l°%=Á ÐËƒ9(„5ð\n\n€n,4‡\0èa}Üƒ.°öRsï‚ª\02B\\Ûb1ŸS±\0003,ÔXPHJspåd“Kƒ CA!°2*WŸÔñÚ2\$ä+Âf^\n„1Œ´òzEƒ Iv¤\\äœ2É .*A°™”E(d±á°ÃbêÂÜ„Æ9‡‚â€ÁDh&­ª?ÄH°sQ˜2’x~nÃJ‹T2ù&ãàeRœ½™GÒQŽTwêÝ‘»õPˆâã\\ )6¦ôâœÂòsh\\3¨\0R	À'\r+*;RðHà.“!Ñ[Í'~­%t< çpÜK#Â‘æ!ñlßÌðLeŒ³œÙ,ÄÀ®&á\$	Á½`”–CXš‰Ó†0Ö­å¼û³Ä:Méh	çÚœGäÑ!&3 D<!è23„Ã?h¤J©e Úðhá\r¡m•˜ðNi¸£´Ž’†ÊNØHl7¡®v‚êWIå.´Á-Ó5Ö§ey\rEJ\ni*¼\$@ÚRU0,\$U¿E†¦ÔÔÂªu)@(tÎSJkáp!€~­‚àd`Ì>¯•\nÃ;#\rp9†jÉ¹Ü]&Nc(r€ˆ•TQUª½S·Ú\08n`«—y•b¤ÅžLÜO5‚î,¤òž‘>Ž‚†xââ±fä´’âØ+–\"ÑI€{kMÈ[\r%Æ[	¤eôaÔ1! èÿí³Ô®©F@«b)RŸ£72ˆî0¡\nW¨™±L²ÜœÒ®tdÕ+íÜ0wglø0n@òêÉ¢ÕiíM«ƒ\nA§M5nì\$E³×±NÛál©ÝŸ×ì%ª1 AÜûºú÷ÝkñrîiFB÷Ïùol,muNx-Í_ Ö¤C( fél\r1p[9x(i´BÒ–²ÛzQlüº8CÔ	´©XU Tb£ÝIÝ`•p+V\0î‹Ñ;‹CbÎÀXñ+Ï’sïü]H÷Ò[ák‹x¬G*ô†]·awnú!Å6‚òâÛÐmSí¾“IÞÍKË~/Ó¥7ÞùeeNÉòªS«/;dåA†>}l~žÏê ¨%^´fçØ¢pÚœDEîÃa·‚t\nx=ÃkÐŽ„*dºêðT—ºüûj2ŸÉjœ\n‘ É ,˜e=‘†M84ôûÔa•j@îTÃsÔänf©Ý\nî6ª\rdœ¼0ÞíôYŠ'%Ô“íÞ~	Ò¨†<ÖË–Aî‹–H¿G‚8ñ¿Îƒ\$z«ð{¶»²u2*†àa–À>»(wŒK.bP‚{…ƒoý”Â´«zµ#ë2ö8=É8>ª¤³A,°e°À…+ìCè§xõ*ÃáÒ-b=m‡™Ÿ,‹a’Ãlzkï\$Wõ,mJiæÊ§á÷+‹èý0°[¯ÿ.RÊsKùÇäXçÝZLËç2`Ì(ïCàvZ¡ÜÝÀ¶è\$×¹,åD?H±ÖNxXôó)’îŽM¨‰\$ó,Í*\nÑ£\$<qÿÅŸh!¿¹S“âƒÀŸxsA!˜:´K¥Á}Á²“ù¬£œRþšA2k·XŽp\n<÷þ¦ýëlì§Ù3¯ø¦È•VV¬}£g&YÝ!†+ó;<¸YÇóŸYE3r³ÙŽñ›Cío5¦Åù¢Õ³Ïkkþ…ø°ÖÛ£«Ït÷’Uø…­)û[ýßÁî}ïØu´«lç¢:DŸø+Ï _oãäh140ÖáÊ0ø¯bäK˜ã¬’ öþé»lGª„#ªš©êŽ†¦©ì|Udæ¶IK«êÂ7à^ìà¸@º®O\0HÅðHiŠ6\r‡Û©Ü\\cg\0öãë2ŽBÄ*eà\n€š	…zr!nWz& {H–ð'\$X  w@Ò8ëDGr*ëÄÝHå'p#ŽÄ®€¦Ô\ndü€÷,ô¥—,ü;g~¯\0Ð#€ÌŽ²EÂ\rÖI`œî'ƒð%EÒ. ]`ÊÐ›…î%&Ðîm°ý\râÞ%4S„vð#\n žfH\$%ë-Â#­ÆÑqBâíæ ÀÂQ-ôc2Š§‚&ÂÀÌ]à™ èqh\rñl]à®s ÐÑhä7±n#±‚‚Ú-àjE¯Frç¤l&dÀØÙåzìF6¸ˆÁ\" ž“|¿§¢s@ß±®åz)0rpÚ\0‚X\0¤Ùè|DL<!°ôo„*‡D¶{.B<Eª‹‹0nB(ï Ž|\r\nì^©à h³!‚Öêr\$§’(^ª~èÞÂ/pq²ÌB¨ÅOšˆðú,\\µ¨#RRÎ%ëäÍdÐHjÄ`Â ô®Ì­ Vå bS’d§iŽE‚øïoh´r<i/k\$-Ÿ\$o”¼+ÆÅ‹ÎúlÒÞO³&evÆ’¼iÒjMPA'u'ŽÎ’( M(h/+«òWD¾So·.n·.ðn¸ìê(œ(\"­À§hö&p†¨/Ë/1DÌŠçjå¨¸EèÞ&â¦€,'l\$/.,Äd¨…‚W€bbO3óB³sH :J`!“.€ª‚‡Àû¥ ,FÀÑ7(‡ÈÔ¿³û1Šlås ÖÒŽ‘²—Å¢q¢X\rÀš®ƒ~Ré°±`®Òžó®Y*ä:R¨ùrJ´·%LÏ+n¸\"ˆø\r¦ÎÍ‡H!qb¾2âLi±%ÓÞÎ¨Wj#9ÓÔObE.I:…6Á7\0Ë6+¤%°.È…Þ³a7E8VSå?(DG¨Ó³Bë%;ò¬ùÔ/<’´ú¥À\r ì´>ûMÀ°@¶¾€H DsÐ°Z[tH£Enx(ðŒ©R xñû@¯þGkjW”>ÌÂÚ#T/8®c8éQ0Ëè_ÔIIGII’!¥ðŠYEdËE´^tdéthÂ`DV!Cæ8Ž¥\r­´Ÿb“3©!3â@Ù33N}âZBó3	Ï3ä30ÚÜM(ê>‚Ê}ä\\Ñtê‚f fŒËâI\r®€ó337 XÔ\"tdÎ,\nbtNO`Pâ;­Ü•Ò­ÀÔ¯\$\n‚žßäZÑ­5U5WUµ^hoýàætÙPM/5K4Ej³KQ&53GX“Xx)Ò<5D…\rûVô\nßr¢5bÜ€\\J\">§è1S\r[-¦ÊDuÀ\rÒâ§Ã)00óYõÈË¢·k{\nµÄ#µÞ\r³^·‹|èuÜ»Uå_nïU4ÉUŠ~YtÓ\rIšÃ@ä³™R ó3:ÒuePMSè0TµwW¯XÈòòD¨ò¤KOUÜà•‡;Uõ\n OYéYÍQ,M[\0÷_ªDšÍÈW ¾J*ì\rg(]à¨\r\"ZC‰©6uê+µYóˆY6Ã´0ªqõ(Ùó8}ó3AX3T h9j¶jàfõMtåPJbqMP5>ðÈø¶©Y‡k%&\\‚1d¢ØE4À µYnÊí\$<¥U]Ó‰1‰mbÖ¶^Òõš ê\"NVéßp¶ëpõ±eMÚÞ×WéÜ¢î\\ä)\n Ë\nf7\n×2´õr8‹—=Ek7tVš‡µž7P¦¶LÉía6òòv@'‚6iàïj&>±â;­ã`Òÿa	\0pÚ¨(µJÑë)«\\¿ªnûòÄ¬m\0¼¨2€ôeqJö­PôtŒë±fjüÂ\"[\0¨·†¢X,<\\Œî¶×â÷æ·+md†å~âàš…Ñs%o°´mn×),×„æÔ‡²\r4¶Â8\r±Î¸×mE‚H]‚¦˜üÖHW­M0Dïß€—å~Ë˜K˜îE}ø¸´à|fØ^“Ü×\r>Ô-z]2s‚xD˜d[s‡tŽS¢¶\0Qf-K`­¢‚tàØ„wT¯9€æZ€à	ø\nB£9 Nb–ã<ÚBþI5o×oJñpÀÏJNdåË\rhÞÃ2\"àxæHCàÝ–:øý9Yn16Æôzr+z±ùþ\\’÷•œôm Þ±T öò ÷@Y2lQ<2O+¥%“Í.Óƒhù0AÞñ¸ŠÃZ‹2R¦À1£Š/¯hH\r¨X…ÈaNB&§ ÄM@Ö[xŒ‡Ê®¥ê–â8&LÚVÍœvà±*šj¤ÛšGHåÈ\\Ù®	™²¶&sÛ\0Qš \\\"èb °	àÄ\rBs›Éw‚	ÙážBN`š7§Co(ÙÃà¨\nÃ¨“¨1š9Ì*E˜ ñS…ÓU0Uº tš'|”m™°Þ?h[¢\$.#É5	 å	p„àyBà@Rô]£…ê@|„§{™ÀÊP\0xô/¦ w¢%¤EsBd¿§šCUš~O×·àPà@Xâ]Ô…¨Z3¨¥1¦¥{©eLY‰¡ŒÚ¢\\’(*R` 	à¦\n…ŠàŽºÌQCFÈ*Ž¹¹àéœ¬Úp†X|`N¨‚¾\$€[†‰’@ÍU¢àð¦¶àZ¥`Zd\"\\\"…‚¢£)«‡Iˆ:ètšìoDæ\0[²¨à±‚-©“ gí³‰™®*`hu%£,€”¬ãIµ7Ä«²Hóµm¤6Þ}®ºNÖÍ³\$»MµUYf&1ùŽÀ›e]pz¥§ÚI¤Åm¶G/£ ºw Ü!•\\#5¥4I¥d¹EÂhq€å¦÷Ñ¬kçx|Úk¥qDšb…z?§º‰>úƒ¾:†“[èLÒÆ¬Z°Xš®:ž¹„·ÚÇjßw5	¶Y¾0 ©Â“­¯\$\0C¢†dSg¸ë‚ {@”\n`ž	ÀÃüC ¢·»Mºµâ»²# t}xÎN„÷º‡{ºÛ°)êûCƒÊFKZÞj™Â\0PFY”BäpFk–›0<Ú>ÊD<JE™šg\rõ.“2–ü8éU@*Î5fkªÌJDìÈÉ4•TDU76É/´è¯@·‚K+„ÃöJ®ºÃÂí@Ó=ŒÜWIOD³85MšNº\$Rô\0ø5¨\ràù_ðªœìEœñÏI«Ï³Nçl£Òåy\\ô‘ˆÇqU€ÐQû ª\n@’¨€ÛºÃpš¬¨PÛ±«7Ô½N\rýR{*qmÝ\$\0R”×Ô“ŠÅåqÐÃˆ+U@ÞB¤çOf*†CË¬ºMCŽä`_ èüò½ËµNêæTâ5Ù¦C×»© ¸à\\WÃe&_XŒ_Øhå—ÂÆBœ3ÀŒÛ%ÜFW£û|™GÞ›'Å[¯Å‚À°ÙÕV Ð#^\rç¦GR€¾˜€P±ÝFg¢ûî¯ÀYi û¥Çz\nâ¨Þ+ß^/“¨€‚¼¥½\\•6èßb¼dmh×â@qíÕAhÖ),J­×W–Çcm÷em]ŽÓeÏkZb0ßåþžYñ]ymŠè‡fØe¹B;¹ÓêOÉÀwŸapDWûŒÉÜÓ{›\0˜À-2/bN¬sÖ½Þ¾Ra“Ï®h&qt\n\"ÕiöRmühzÏeø†àÜFS7µÐPPòä–¤âÜ:B§ˆâÕsm¶­Y düÞò7}3?*‚túòéÏlTÚ}˜~€„€ä=cžý¬ÖÞÇ	žÚ3…;T²LÞ5*	ñ~#µA•¾ƒ‘sŽx-7÷Žf5`Ø#\"NÓb÷¯G˜Ÿ‹õ@Üeü[ïø¤Ìs‘˜€¸-§˜M6§£qqš h€e5…\0Ò¢À±ú*àbøISÜÉÜFÎ®9}ýpÓ-øý`{ý±É–kP˜0T<„©Z9ä0<Õš\r­€;!Ãˆgº\r\nKÔ\n•‡\0Á°*½\nb7(À_¸@,îe2\rÀ]–K…+\0Éÿp C\\Ñ¢,0¬^îMÐ§šº©“@Š;X\r•ð?\$\r‡j’+ö/´¬BöæP ½‰ù¨J{\"aÍ6˜ä‰œ¹|å£\n\0»à\\5“Ð	156ÿ† .Ý[ÂUØ¯\0dè²8Yç:!Ñ²‘=ºÀX.²uCªŠŒö!Sº¸‡o…pÓBÝüÛ7¸­Å¯¡Rh­\\h‹E=úy:< :u³ó2µ80“si¦ŸTsBÛ@\$ Íé@Çu	ÈQº¦.ô‚T0M\\/ê€d+Æƒ\n‘¡=Ô°dŒÅëA¢¸¢)\r@@Âh3€–Ù8.eZa|.â7YkÐcÀ˜ñ–'D#‡¨Yò@Xq–=M¡ï44šB AM¤¯dU\"‹Hw4î(>‚¬8¨²ÃC¸?e_`ÐÅX:ÄA9Ã¸™ôp«GÐä‡Gy6½ÃF“Xr‰¡l÷1¡½Ø»B¢Ã…9Rz©õhB„{ž€™\0ëå^‚Ã-â0©%Dœ5F\"\"àÚÜÊÂ™úiÄ`ËÙnAf¨ \"tDZ\"_àV\$Ÿª!/…D€áš†ð¿µ‹´ˆÙ¦¡Ì€F,25Éj›Tëá—y\0…N¼x\rçYl¦#‘ÆEq\nÍÈB2œ\nìà6·…Ä4Ó×”!/Â\nóƒ‰Q¸½*®;)bR¸Z0\0ÄCDoŒËžŽ48À•´µ‡Ðe‘\nã¦S%\\úPIk‡(0ÁŒu/™‹G²Æ¹ŠŒ¼\\Ë} 4Fp‘žGû_÷G?)gÈotº[vžÖ\0°¸?bÀ;ªË`(•ÛŒà¶NS)\nãx=èÐ+@êÜ7ƒjú0—,ð1Ã…z™“­>0ˆ‰GcðãL…VXôƒ±ÛðÊ%À…Á„Q+øŽéoÆFõÈéÜ¶Ð>Q-ãc‘ÚÇl‰¡³¤wàÌz5G‘ê‚@(h‘cÓHõÇr?ˆšNbþ@É¨öÇø°îlx3‹U`„rwª©ÔUÃÔôtØ8Ô=Àl#òõlÿä¨‰8¥E\"Œƒ˜™O6\n˜Â1e£`\\hKf—V/Ð·PaYKçOÌý éàx‘	‰Oj„ór7¥F;´êB»‘ê£íÌ’‡¼>æÐ¦²V\rÄ–Ä|©'Jµz«¼š”#’PBä’Y5\0NC¤^\n~LrR’Ô[ÌŸRÃ¬ñgÀeZ\0x›^»i<Qã/)Ó%@Ê’™fB²HfÊ{%Pà\"\"½ø@ªþ)ò’‘“DE(iM2‚S’*ƒyòSÁ\"âñÊeÌ’1Œ«×˜\n4`Ê©>¦Q*¦Üy°n”’ž¥TäuÔâä”Ñ~%+W²XK‹Œ£Q¡[Ê”žàlPYy#DÙ¬D<«FLú³Õ@Á6']Æ‹‡û\rFÄ`±!•%\n0cÐôÀË©%c8WrpGƒ.TœDo¾UL2Ø*é|\$¬:çXt5ÆXYâIˆp#ñ ²^\nê„:‚#Dú@Ö1\r*ÈK7à@D\0Ž¸C’C£xBhÉEnKè,1\"õ*y[á#!ó×™âÙ™©Ê°l_¢/€öxË\0àÉÚ5ÐZÇÿ4\0005JÆh\"2ˆŒ‡%Y…¦a®a1SûO4ˆÊ%niøšPŒàß´qî_Ê½6¤š•~ŠÈI\\¾š‘d‰údÑøŒ®—DÜÈ”€µ3g^ãü@^6Õ„îå_ÀHD·.ksL´Ô@ÂùÉˆæn­I¦ÄÑ~Ä\r“b @¸Ó€•Nžt\0séÂ]:uðÎX€b@^°1\0½©¥2?èTÀó6dLNeÉ›+ê\0Ç:©Ð²l¡ƒz6q=Ìºx“§çN6 ÜO,%@s›0\næ\\)ÒL<òCÊ|·ž¦P¶b¢˜¼ÎA>I‹…á\"	ŒÜ^K4ü‹gIXi@P…jE©&/1@æfÜ	ÔNáºx0coaß§Áª‰ó,C'Üy#6F@¡Ð ‰H0Ç{z3t–|cXMJ.*BÐ)ZDQðå\0°ñ“T-v¥Xža*”Ý,*Ã<bÁ•Ë#xÑ˜Ýd€PÆòKG8—Æ y“K	\\#=è)ígÈ‘hŒ&È8])½CÅ\nÃ´ñÀ9¼zˆW\\’gþM 7Šˆ!Ê•¡óÆŠ–¬,Åò9ñ²Š©©\$T\"£,Š¨%.F!Ëš A»-àé”ø¹-àg¨âŠ\0002R>KEˆ'ØUÙ_IÐ÷ì³9³Ë¼¡j(Q°@Ë@ò4/¬7ô˜“'J.â‡RT…\0]KS¹D‡–Ap5¼\rÂH0!ä›Â´e	d@RÒÒà¸´Ê9¢S©;7žH‘BÀbxóJèÖ_žviÑU`@ˆµÃSAM…¯XËÏGØXiÙÓU*¬Úö€ÊõûÍ'øÝ:VòWJv£D¾ÿN'\$ìzh\$d_y§œ“Z]•™­óYÊ°³8Ø”þ¡æ]¨Pìœ*hžÔÖ§e;€ºpeû¢\$kæw§ì*7N²DTx_ÔÔ§½Giô&PÿÔ†žtÍ†¨bè\\EÆH\$iE\"cr½å0l‰?>ÁñŒ‘C(ŠW@3ÈÁ•22a´“IÁà¹Õ¡{¥B`ÜÚ³iÅ¸Go^6E\r¡ºG˜M¤p1iÙI¼¤Xª\0003Ž2ÇKü§ÓôÝzl&Ö†‰'ILÖ\\Î\"’7¤>¬j(>ãjôFG_âä& 10IÆA31=h q\0ÆFŠ«–„Ä·ŠÝ_ÂJªŒ„Ô³VÎ–º‡Ü†qÙÕš¢Ù	Âà(/¾dOC_sm§<g˜x\0’°\"ð\n@EkH\0¡Jˆ­®8€(¬¨¯km[‰‘ì¿ÁS4ð\nY40›«+L\nŠ¦À“‘ì#BÓ«bçÀ%RÖ–°µ×­‘ÀR:Æ<\$!Û¥r;œ…Ç	%|Ê¨á(€|«H‡\0àð‘ÁÐŒ°…]ÂcÒ¡=0¯íZá¨\"\"=ÖX•˜)½fëNŸ6V}FÕÚ=[Éžà§¢huô-ø±\0t¥åbW~ºõQ•ÕiJŠö—Lñ5×­q#kbž ÝWn««ÍQøTƒ!ëÂeõncSÑ[+Ö´E¯<-‡–a]ÅƒˆìYbÓ\n\nJ~ä|JÉƒ8® ìLpŸ™Áæoñ €Nä©Ü¨…J.ùÅƒSÈ¡2c9Ãj©yŸ-`a\0Äö*ìÖˆ@\0+´ØmgÉÚ6°1¤ÔMe\0ªËQ ‰_„}!Iö’GL€f)ÃXño,“ShxÂ\0000\"hð+L¥MÔÉ ªÑ˜±ÊZ	j—\0¶ µ/˜\$’¨>u*—Z9”îZå®eõ«+Jœ‰™¸tzÈËûÈþR¨KÔ¯ÐÑâDyŽÞÙqá0C—-f¢Åm‚¶¹ªBIí|’¹HB‰œsQlÀX°ƒ.ÝÅöÔ|¸cˆªÀ[–óZhZåÃl˜¨ÛxÂ@'µ ml²KrQ¶26½•]¯Ò·n§d[ÝöñŽ©‡dþ€‘\"GJ9uòûBƒo“©Zß–Õa¥²n@Áªn°lW|*gX´\nn2åF¬|x`Dk›„uPP!Q\rr‹™`W/¹ŒŸ	1æ[-o,71bUs˜¢©çN¸7²ËÉÛGq¸.\\Q\"CCT\"æ‘à–ÄÒ*?u¨ts¶‰”°Ç]áÙ©Pz[¥[YFÏ¹¢›FD3¤\"–ºÇ]uÛ)wz­:#¶ÍÝIiwŠêpÉ›»ñ{¯oÖ0nð¶Û;Õâ\\éx¸°Ø\0q·måãíª&Ø~Âîî—”7²øÀ¹9[¤HéqdL•Oº2´v|B¯tæŠ\\Æ¤‰Hd¦ëâH‘\" òìN\n\0·©GÅgÎF ¸Fˆ}\"ì­&QEK¾‘{}\ryÇŽ¾˜r×›t›Àž„ï†7ÔNuÃ³[Aøgh;S¥.Ò ‚š±Â¥|yùÏ[Õ†_bòÈ¨¬!+RñèZXù@0NééþÁP€Þì%¡jD£Â¯z	þà—[øU\"¶{e’8ôŸ>”EL4JÐ½…0›¡¦è7 €´d·¬ ÀQ^`0`œ•¯]cð<g@Ž²hy8˜íp.ef\nóÎeh‡ƒaXÚÃømSßßjBÚ˜Q\"‡\rë×ÇK3†=>ÇªAX”[,,\"'<µ›–%¶a€«Ó´Ãµ.\$ñ\0ç%\0ásV¤îËp M\$¼@já×ð>¤­}VeÄ\$@—Í„#§ªÐ(3:ø`‚UðšYÌ¶uæ¨ûˆÏâÎ@ÄV#E‰G/¸üXD\$ˆhµƒav–¼xS\"]k18a¯Ñ9dJROÓŠs‘`EJ°½§øUo³m{l¹B8¥ˆÁ(\n}ei±büø, ; N”ªÍ‡øQØ\\èÇ¸I5yR¼\$!>\\Ê‰ŒgÂuj*?n°MÓÞ²hÝø\r%Á³àU(d€¦Nµd#}špA:¬¨ý•-\\èA»*Ä4€2I€®è\rÖ£»… 0h@\\ÔµÉÀ8ð3‚rq]òùd8\"ðQ ŒÿîÆ™:cÆàyÇ4	Ïá‘šdaÂ€‡Î 6>UÛAÚÑ:½@˜2‹Ûÿ\$òeh2´ûF»§É™Ná+’ŒŸ\rþÔ€(îAr‚°d*ü\0[®#cjŠû´>!(SðÈéLˆeýTÉÆM	9\0W:™BDýø‚3JŒ¬Õ_@sÇárue‡ø¦ð»ý¬ +º'B«É}\"B\"üz2Žî‹rël»xF[èLÙË²Ea9 Êcdb½¾^,ÔUC=/2»×ò¼øì/\$CÆ#Ú÷8¡}DÀÛ×6Ï`^;6B0U7ó·_=	,ª1âj1V[¨.	H9(1ï±Æ±ÒLz¢C¸	Ç\$.AÊfhã–«¾ÍàïDrY	ýHØe~o—r19æ—Ù…\\šß„P’)\"ÃQ¹´,ÑeòöL¾”w0Ï\0§—š–Ï;wìX³Ç¨‰çqo¹ï¾~Ÿ«öçø>9ô>}²òºdc¿\0åÊg¾¶fÎùq–&9—¹-ýJ#¤Š¸ª3^4m/Ì™¯\0\0006À¦n8£·>äˆ´.Ó—é’cph±ËÙù•››º_A@[‰•7«|9\$pMh >‰ŒÁ5°K¥úÃE=hþšAÒtŠ^âV×	©\"	c£B;¤öÞi…ÕQÒ t¬›òé@,\nØ)­óˆsÓ`Ÿ™°°;Ñ4´—‚„Ií£©‘íùèy€ -¤0yeÊ¨—U‚”Bî©v³¥3H™PÇGË5êï’s|·º\rðžÐ\$0ãèò•ò1½©l3€é(*oF~PK´ª.ý,'·J/Ó²tð‹d:š—n§\n©ðj†Y«zê(Æó’ü“w°Ý Zì#ZÊ	Io•@1ÆÎ»\$ïò±¦=VWz•	nŽBøaú›A»µqª@™´I€p	@Ñ5Ó–lH{UºÜoXõ¿fðŽÓ¿\\zµ×.§š²,-\\Ú—^y n^Å×ÊBq·þ…¤zXã‰¡ƒ\$¨*J72ÕD4.†Õ…!¤M0¶óDëìFŠàóã G¡ÏLˆmØc*mïcI£å5ÉŒ»^—t¿ª’jlŒ7æ›¿S¶Q ¢.i’éÖÔh¨õLÐÚ±B6Ô„h˜&ïJ …l\\‰ðWeªcÎf%kj™Á ¦pÃR=Œäi’@.õ¥(ä2klHUW\"™o¥j½§’p!S5Æè­pL'`\0¤O *¦Q3XÂ“‰ÞlJ\08\n…\r·²¸*€añüë–ž¼ûr™`<¤&ÚXBhÖ8!xš®&äBht¥\$ÿ‡þ]Énß†éóÉcL€€[Æµ©d¸á<`œ®\0œ€¢Ï‚ÞawæO%;‘õBC»…Q’\rÌ­ÓìŒì€pŠ¤«ØPQ¶Z’¸úZÁAu=N&Ðia\nÑmK6I}Ñ×n	šÅt\nd)í®ÐÈ÷bpÎ€\"žðg'¦0œ7ÃuÈ&@â7å8X NÀxÄáö­ú\$BùßZB/¶M¯gB»i¦ÖÑ§¶\\âmƒmIÌÄ€Êç;5=#&4˜ÌçþPÕ‰½éðqí’A™ä›\\…,q¤cÞŸ\ncâB–‚¾×úw\0BgjD‹@;=0m“k®Ä\rÄ²‹`À¤'5¤•¶k-Œ{¢‰\0¯_›Muîøƒ2“Ò×†§»£Àqø‰¬ð>)9ÈW\näd+…ÔÔ§ÀG\rýÃn4„‹äOØ:5ö†Þ8»1µ:Îš?¥‡(yGgWK\rÝ7­²“—m5.œ‚eŒHÙhJ«Ak#»ÓL¶..›\\Î=ÕñUÙÐ„˜ƒÓ:Ð>7ºW+^yD‚“œb­üG¡‘OZÍ4ïŠr(|xµÆýPr¸£,yŽ©Ð8qaÜ©O2µkªn˜Š#p2¾ûÇˆºØ”.¼£c’–U—c”öäëÅ‚jó\$ôí8Ä¬~š7ZR:ð×†8­9Î¨w(a”L¤%­-,ÔÈì¿Œ#ôfƒ%8þÉ|Þc‡‘¬œÚ×%X‘WÂ\n}6’‘HìÿñæËž¤¡#¹&J,'z“MüM…¢‰Œààº‘Ü†² ‘˜®/y6YQ¯‘ì¶ÚºdÓ™dÁÞóÏ:õãô£EƒŒp2gŸgÁ/î,ÒËäÚÕˆ'8ì^;´UWN…ÑÅÞÕ{ÉOCò…Ñ¤ô¢zÉiKX¢’Ú”NŒdG£RCJYõ’‘i²’×y#>zS²MUc£õƒ¨ûÿêRORÔ¾¡0)Ø0Êú]:=Ïž™tƒ‘Áëé'\$™sÒrFŽöÙ67	=\$BÄÓ!qs	1\"ü¬vÆ÷%‘ŒI•l<Êb!Û®6(Cd-Ê^<H`~2¹KìÍzKÝÙœ€Ô±­ÙÕy,qAá*º\0}‚ÝC¨pb€\\ÓSå5ÝßùÚ'(›áÓí|»Mëð„ÀWÚÀ5;\$5µT|ºò;kõñÈtîñ@ò‘â;9³)½ò;i.Û;›·í_¥ê×ÌF¶=ñœDä¥M`HÞ“ƒ\0ˆ	 N @°%w‡ªdèPbð\$H|kÆ[¾ÜdCI!:lÅü,§¨ý<÷”uòt”ô¼NeÏW^¡wè'6•ŒD¿áfýu ¬ihI÷Z:ŸÑ~ý÷Ï£r¾…ÈzÄ3õ+¯uoC·s2ÕbÆua”XðwWK£	HÔ¶27>âWÏÍÝyÃ£¬ÝMëJ£rpT¼”Lð‰|`f™…:ÊõšA²täŠd|i½³[wüèj„ŠW˜ 7‘¤£au‹© úëe ò•šA5­Q' Ê\0È 3‹Ò¾\$ÂçýŒ\rk)a; óæH=ù™Ö~óIGŠIæ°<ù´•\"ù¬ÉI1'è ™¢Gcm\0P\nïwèü#Í>Œ½ÛxB\"ñÒEm|…ù2Š\$}<3PYXgo£dß¶€<Ôþ£¿qE\"`×úÈ4ág«8r£]\nˆ¡—õ:ø›qVbTì£Òm°•…9K&Ò“Ä¤ÃmÔ7)@¨ÀQz›ÃÓ=¢½ßµÅ±íŸH\nÔëö}Oçi}»\rÙ£.¢¹v‹®p¾JW&ßu×550	Ô5ÀîPËIŒÁ\n½Ûí¸³Ææ­l\0O5*=Þú	…P-¢éÊH\0óf×%Ìtãº*¥S:±tÏ› €€?øÈ‚Hâñ÷ºq4ˆÐKÍ”§@€Ô¬»Ü‚.O(±ëü Z¡\$ÏÊÓ]¼‚Åo¿€n‹z«A±!€t85<WñR2[„8ò‚¶ùn5\$IÝµæµ•Z¤Àéó]'}ET\nŸú†Šä.˜í¤&ä7¦ÏVË@¤_ÀD”oÈý&J6°ß4iÃj\$ÈÒEL¢äþu“Üt¢‰Ëä+I¡Ð¢¢šûØ£~üS±SZTXÒ ¾PYz½Å\"\$VÇ_]ÿM(§ã7òƒºü·ÚÌáÃÀ‡t_´S‰óˆÃê/­ßt…½“Ä‚ü¿âmHä:\0»5à- _Z'#ö¥Á1‡P¿é´,}(Ÿ°~¸\0ì‹þ!Ò–`-þP\neùy (¿Êˆ `9OËú!Á;5‰\n½\$ê{úŸ¯þðìUAü¨7ùá!¿çò€[ý ¸Yý¿ÅFæ¿´ÿƒý¯ð>è8&€›Þÿ!CLà¦ÿH€¯õ(”\0'Ç2ûìd\r%‚;àkæŠ4ûÀ_OÏ>þ5³öà@DýÒ¼ÏÞ\0VÃA€6' AY¬¢¶ýS°¿‚££rÔ¾´4š+h@bÿãõ­¾´þ‚Oá”M\0Àå˜ÀrÌ›ú@ÿ\rJùÓm0\08ùOò€ìÿ;kÓ ÊëþA(6£|	`8 ß\0ˆ°&¿²EÐVÏå\0VþãñÏï€wk…NÀ°KùÁ—¡xdpÀÒÿsìAL§â«A¾Xëkÿ‘u\0Œïþ„Ít ÀÔ¢ò.‰>(N’ÅK'flï¢ªdúAŠ‚â?++ðN“Œ~‚ ÿ²˜úkæ€¾²€ªPR\0èúx¡ØãûèÊ‘ô”‹BK]¦bUÃÑ\\Ì›¸€„d\0S@¿ä«QÀïÍ‰šb™\0\0b„„Ö\0_\\¡@\nN—î äOÎA„PfÁ„€ Œ¶ôÔAj ¨ÂM4<¤9“°Ú+çÀ¿¨Ÿ`S‰‹ ìü”Èw3Tð¬„7âX»Â†T!\0eïPAIÈb 1!\0€ž4³åà'¹ @ ! 8\0’Ë/ïˆ º!:K•,ØCASðX‘f®e©ÎMùý.:˜¼:òÆtŸ»¡àÃÌ._ºd„ÿ‹°81v`B\"ä‚Å!.^Ú*åáN.^‡š\n„&\r(Ÿš.Á©§îO0Š«@÷ÙPŠ¹njÒàŽÚ—#¡¼îäÓå&¹‚rHØ<¨†  ¢!à’3¶Ü(i @ÜAaÁÅ{õ Â¬#ÉS©½†6ð¨˜¶F@©Ô¦ãY[Oœƒ( .‡¬/„BüËñÇó)L02BØˆÌ-ÁÆ€Øùqp¹‹J<¤.Ð‘\0\nçï\0ÐÔ/@8C¤4PÀÇ\r	PÂ•°)üðFâå\$q.]¬\"B#‹Å	œ#\\£Â84\$Ãs:.(*Oi>™|#T'`—Bu«a/ˆ€ãCÀÂTØKaêX8Î`p ¸ÚÕÁ\0`Ê\0");
    } elseif ($_GET["file"] == "jush.js") {
        header("Content-Type: text/javascript; charset=utf-8");echo
            lzw_decompress("v0œF£©ÌÐ==˜ÎFS	ÐÊ_6MÆ³˜èèr:™E‡CI´Êo:C„”Xc‚\ræØ„J(:=ŸE†¦a28¡xð¸?Ä'ƒi°SANN‘ùðxs…NBáÌVl0›ŒçS	œËUl(D|Ò„çÊP¦À>šE†ã©¶yHchäÂ-3Eb“å ¸b½ßpEÁpÿ9.Š˜Ì~\nŽ?Kb±iw|È`Ç÷d.¼x8EN¦ã!”Í2™‡3©ˆá\r‡ÑYŽÌèy6GFmYŽ8o7\n\r³0¤÷\0DbcÓ!¾Q7Ð¨d8‹Áì~‘¬N)ùEÐ³`ôNsßð`ÆS)ÐOé—·ç/º<xÆ9Žo»ÔåµÁì3n«®2»!r¼:;ã+Â9ˆCÈ¨®‰Ã\n<ñ`Èó¯bè\\š?`†4\r#`È<¯BeãB#¤N Üã\r.D`¬«jê4ÿŽŽpéar°øã¢º÷>ò8Ó\$Éc ¾1Écœ ¡c êÝê{n7ÀÃ¡ƒAðNÊRLi\r1À¾ø!£(æjÂ´®+Âê62ÀXÊ8+Êâàä.\rÍÎôƒÎ!x¼åƒhù'ãâˆ6Sð\0RïÔôñOÒ\n¼…1(W0…ãœÇ7qœë:NÃE:68n+ŽäÕ´5_(®s \rã”ê‰/m6PÔ@ÃEQàÄ9\n¨V-‹Áó\"¦.:åJÏ8weÎq½|Ø‡³XÐ]µÝY XÁeåzWâü Ž7âûZ1íhQfÙãu£jÑ4Z{p\\AUËJ<õ†káÁ@¼ÉÃà@„}&„ˆL7U°wuYhÔ2¸È@ûu  Pà7ËA†hèÌò°Þ3Ã›êçXEÍ…Zˆ]­lá@MplvÂ)æ ÁÁHW‘‘Ôy>Y-øYŸè/«›ªÁî hC [*‹ûFã­#~†!Ð`ô\r#0PïCË—f ·¶¡îÃ\\î›¶‡É^Ã%B<\\½fˆÞ±ÅáÐÝã&/¦O‚ðL\\jF¨jZ£1«\\:Æ´>N¹¯XaFÃAÀ³²ðÃØÍf…h{\"s\n×64‡ÜøÒ…¼?Ä8Ü^p\"ë°ñÈ¸\\Úe(¸PƒNµìq[g¸Árÿ&Â}PhÊà¡ÀWÙí*Þír_sËP‡hà¼àÐ\nÛËÃomõ¿¥Ãê—Ó#§¡.Á\0@épdW ²\$Òº°QÛ½Tl0† ¾ÃHdHë)š‡ÛÙÀ)PÓÜØHgàýUþ„ªBèe\r†t:‡Õ\0)\"Åtô,´œ’ÛÇ[(DøO\nR8!†Æ¬ÖšðÜlAüV…¨4 hà£Sq<žà@}ÃëÊgK±]®àè]â=90°'€åâøwA<‚ƒÐÑaÁ~€òWšæƒD|A´††2ÓXÙU2àéyÅŠŠ=¡p)«\0P	˜s€µn…3îr„f\0¢F…·ºvÒÌG®ÁI@é%¤”Ÿ+Àö_I`¶ÌôÅ\r.ƒ N²ºËKI…[”Ê–SJò©¾aUf›Szûƒ«M§ô„%¬·\"Q|9€¨Bc§aÁq\0©8Ÿ#Ò<a„³:z1Ufª·>îZ¹l‰‰¹ÓÀe5#U@iUGÂ‚™©n¨%Ò°s¦„Ë;gxL´pPš?BçŒÊQ\\—b„ÿé¾’Q„=7:¸¯Ý¡Qº\r:ƒtì¥:y(Å ×\nÛd)¹ÐÒ\nÁX; ‹ìŽêCaA¬\ráÝñŸP¨GHù!¡ ¢@È9\n\nAl~H úªV\nsªÉÕ«Æ¯ÕbBr£ªö„’­²ßû3ƒ\ržP¿%¢Ñ„\r}b/‰Î‘\$“5§PëCä\"wÌB_çŽÉUÕgAtë¤ô…å¤…é^QÄåUÉÄÖj™Áí Bvhì¡„4‡)¹ã+ª)<–j^<Lóà4U* õBg ëÐæè*nÊ–è-ÿÜõÓ	9O\$´‰Ø·zyM™3„\\9Üè˜.oŠ¶šÌë¸E(iåàžœÄÓ7	tßšé-&¢\nj!\rÀyœyàD1gðÒö]«ÜyRÔ7\"ðæ§·ƒˆ~ÀíàÜ)TZ0E9MåYZtXe!Ýf†@ç{È¬yl	8‡;¦ƒR{„ë8‡Ä®ÁeØ+ULñ'‚F²1ýøæ8PE5-	Ð_!Ô7…ó [2‰JËÁ;‡HR²éÇ¹€8pç—²Ý‡@™£0,Õ®psK0\r¿4”¢\$sJ¾Ã4ÉDZ©ÕI¢™'\$cL”R–MpY&ü½Íiçz3GÍzÒšJ%ÁÌPÜ-„[É/xç³T¾{p¶§z‹CÖvµ¥Ó:ƒV'\\–’KJa¨ÃMƒ&º°£Ó¾\"à²eo^Q+h^âÐiTð1ªORäl«,5[Ý˜\$¹·)¬ôjLÆU`£SË`Z^ð|€‡r½=Ð÷nç™»–˜TU	1Hyk›Çt+\0váD¿\r	<œàÆ™ìñjG”ž­tÆ*3%k›YÜ²T*Ý|\"CŠülhE§(È\rÃ8r‡×{Üñ0å²×þÙDÜ_Œ‡.6Ð¸è;ãü‡„rBjƒO'Ûœ¥¥Ï>\$¤Ô`^6™Ì9‘#¸¨§æ4Xþ¥mh8:êûc‹þ0ø×;Ø/Ô‰·¿¹Ø;ä\\'( î„tú'+™òý¯Ì·°^]­±NÑv¹ç#Ç,ëvð×ÃOÏiÏ–©>·Þ<SïA\\€\\îµü!Ø3*tl`÷u\0p'è7…Pà9·bsœ{Àv®{·ü7ˆ\"{ÛÆrîaÖ(¿^æ¼ÝE÷úÿë¹gÒÜ/¡øžUÄ9g¶î÷/ÈÔ`Ä\nL\n)À†‚(Aúað\" žçØ	Á&„PøÂ@O\nå¸«0†(M&©FJ'Ú! …0Š<ïHëîÂçÆù¥*Ì|ìÆ*çOZím*n/bî/ö®Ôˆ¹.ìâ©o\0ÎÊdnÎ)ùŽi:RŽÎëP2êmµ\0/vìOX÷ðøFÊ³ÏˆîŒè®\"ñ®êöî¸÷0õ0ö‚¬©í0bËÐgjðð\$ñné0}°	î@ø=MÆ‚0nîPŸ/pæotì€÷°¨ð.ÌÌ½g\0Ð)o—\n0È÷‰\rF¶é€ b¾i¶Ão}\n°Ì¯…	NQ°'ðxòFaÐJîÎôLõéðÐàÆ\rÀÍ\r€Öö‘0Åñ'ð¬Éd	oepÝ°4DÐÜÊ¦q(~ÀÌ ê\r‚E°ÛprùQVFHœl£‚Kj¦¿äN&­j!ÍH`‚_bh\r1Ž ºn!ÍÉŽ­z™°¡ð¥Í\\«¬\rŠíŠÃ`V_kÚÃ\"\\×‚'Vˆ«\0Ê¾`ACúÀ±Ï…¦VÆ`\r%¢’ÂÅì¦\rñâƒ‚k@NÀ°üBñíš™¯ ·!È\n’\0Z™6°\$d Œ,%à%laíH×\n‹#¢S\$!\$@¶Ý2±„I\$r€{!±°J‡2HàZM\\ÉÇhb,‡'||cj~gÐr…`¼Ä¼º\$ºÄÂ+êA1ðœE€ÇÀÙ <ÊL¨Ñ\$âY%-FDªŠd€Lç„³ ª\n@’bVfè¾;2_(ëôLÄÐ¿Â²<%@Úœ,\"êdÄÀN‚erô\0æƒ`Ä¤Z€¾4Å'ld9-ò#`äóÅ–…à¶Öãj6ëÆ£ãv ¶àNÕÍf Ö@Ü†“&’B\$å¶(ðZ&„ßó278I à¿àP\rk\\§—2`¶\rdLb@Eöƒ2`P( B'ã€¶€º0²& ô{Â•“§:®ªdBå1ò^Ø‰*\r\0c<K|Ý5sZ¾`ºÀÀO3ê5=@å5ÀC>@ÂW*	=\0N<g¿6s67Sm7u?	{<&LÂ.3~DÄê\rÅš¯x¹í),rîinÅ/ åO\0o{0kÎ]3>m‹”1\0”I@Ô9T34+Ô™@e”GFMCÉ\rE3ËEtm!Û#1ÁD @‚H(‘Ón ÃÆ<g,V`R]@úÂÇÉ3Cr7s~ÅGIói@\0vÂÓ5\rVß'¬ ¤ Î£PÀÔ\râ\$<bÐ%(‡Ddƒ‹PWÄîÐÌbØfO æx\0è} Üâ”lb &‰vj4µLS¼¨Ö´Ô¶5&dsF Mó4ÌÓ\".HËM0ó1uL³\"ÂÂ/J`ò{Çþ§€ÊxÇYu*\"U.I53Q­3Qô»J„”g ’5…sàúŽ&jÑŒ’Õu‚Ù­ÐªGQMTmGBƒtl-cù*±þ\rŠ«Z7Ôõó*hs/RUV·ðôªBŸNËˆ¸ÃóãêÔŠài¨Lk÷.©´Ätì é¾©…rYi”Õé-Sµƒ3Í\\šTëOM^­G>‘ZQjÔ‡™\"¤Ž¬i”ÖMsSãS\$Ib	f²âÑuæ¦´™å:êSB|i¢ YÂ¦ƒà8	vÊ#é”Dª4`‡†.€Ë^óHÅM‰_Õ¼ŠuÀ™UÊz`ZJ	eçºÝ@Ceíëa‰\"mób„6Ô¯JRÂÖ‘T?Ô£XMZÜÍÐ†ÍòpèÒ¶ªQv¯jÿjV¶{¶¼ÅCœ\rµÕ7‰TÊžª úí5{Pö¿]’\rÓ?QàAAÀèŽ‹’Í2ñ¾ “V)Ji£Ü-N99f–l JmÍò;u¨@‚<FþÑ ¾e†j€ÒÄ¦I‰<+CW@ðçÀ¿Z‘lÑ1É<2ÅiFý7`KG˜~L&+NàYtWHé£‘w	Ö•ƒòl€Òs'gÉãq+Lézbiz«ÆÊÅ¢Ð.ÐŠÇzW²Ç ùzd•W¦Û÷¹(y)vÝE4,\0Ô\"d¢¤\$Bã{²Ž!)1U†5bp#Å}m=×È@ˆwÄ	P\0ä\rì¢·‘€`O|ëÆö	œÉüÅõûYôæJÕ‚öE×ÙOuž_§\n`F`È}MÂ.#1á‚¬fì*´Õ¡µ§  ¿zàucû€—³ xfÓ8kZR¯s2Ê‚-†’§Z2­+ŽÊ·¯(åsUõcDòÑ·Êì˜ÝX!àÍuø&-vPÐØ±\0'LïŒX øLÃ¹Œˆo	Ýô>¸ÕŽÓ\r@ÙPõ\rxF×üE€ÌÈ­ï%Àãì®ü=5NÖœƒ¸?„7ùNËÃ…©wŠ`ØhX«98 Ìø¯q¬£zãÏd%6Ì‚tÍ/…•˜ä¬ëLúÍl¾Ê,ÜKa•N~ÏÀÛìú,ÿ'íÇ€M\rf9£w˜!x÷x[ˆÏ‘ØG’8;„xA˜ù-IÌ&5\$–D\$ö¼³%…ØxÑ¬Á”ÈÂ´ÀÂŒ]›¤õ‡&o‰-39ÖLù½zü§y6¹;u¹zZ èÑ8ÿ_•Éx\0D?šX7†™«’y±OY.#3Ÿ8 ™Ç€˜e”Q¨=Ø€*˜™GŒwm ³Ú„Y‘ù ÀÚ]YOY¨F¨íšÙ)„z#\$eŠš)†/Œz?£z;™—Ù¬^ÛúFÒZg¤ù• Ì÷¥™§ƒš`^Úe¡­¦º#§“Øñ”©Žú?œ¸e£€M£Ú3uÌåƒ0¹>Ê\"?Ÿö@×—Xv•\"ç”Œ¹¬¦*Ô¢\r6v~‡ÃOV~&×¨^gü šÄ‘Ùž‡'Î€f6:-Z~¹šO6;zx²;&!Û+{9M³Ù³d¬ \r,9Öí°ä·WÂÆÝ­:ê\rúÙœùã@ç‚+¢·]œÌ-ž[gž™Û‡[s¶[ižÙiÈq››y›éxé+“|7Í{7Ë|w³}„¢›£E–ûW°€Wk¸|JØ¶å‰xmˆ¸q xwyjŸ»˜#³˜e¼ø(²©‰¸ÀßžÃ¾™†ò³ {èßÚ y“ »M»¸´@«æÉ‚“°Y(gÍš-ÿ©º©äí¡š¡ØJ(¥ü@ó…;…yÂ#S¼‡µY„Èp@Ï%èsžúoŸ9;°ê¿ôõ¤¹+¯Ú	¥;«ÁúˆZNÙ¯Âº§„š k¼V§·u‰[ñ¼x…|q’¤ON?€ÉÕ	…`uœ¡6|­|X¹¤­—Ø³|Oìx!ë:¨œÏ—Y]–¬¹Ž™c•¬À\r¹hÍ9nÎÁ¬¬ë€Ï8'—ù‚êà Æ\rS.1¿¢USÈ¸…¼X‰É+ËÉz]ÉµÊ¤?œ©ÊÀCË\r×Ë\\º­¹ø\$Ï`ùÌ)UÌ|Ë¤|Ñ¨x'ÕœØÌäÊ<àÌ™eÎ|êÍ³ç—â’Ìé—LïÏÝMÎy€(Û§ÐlÐº¤O]{Ñ¾×FD®ÕÙ}¡yu‹ÑÄ’ß,XL\\ÆxÆÈ;U×ÉWt€vŸÄ\\OxWJ9È’×R5·WiMi[‡Kˆ€f(\0æ¾dÄšÒè¿©´\rìMÄáÈÙ7¿;ÈÃÆóÒñçÓ6‰KÊ¦Iª\rÄÜÃxv\r²V3ÕÛßÉ±.ÌàRùÂþÉá|Ÿá¾^2‰^0ß¾\$ QÍä[ã¿D÷áÜ£å>1'^X~t1\"6Lþ›+þ¾Aàžeá“æÞåI‘ç~Ÿåâ³â³@ßÕ­õpM>Óm<´ÒSKÊç-HÉÀ¼T76ÙSMfg¨=»ÅGPÊ°›PÖ\r¸é>Íö¾¡¥2Sb\$•C[Ø×ï(Ä)žÞ%Q#G`uð°ÇGwp\rkÞKe—zhjÓ“zi(ôèrO«óÄÞÓþØT=·7³òî~ÿ4\"ef›~íd™ôíVÿZ‰š÷U•-ëb'VµJ¹Z7ÛöÂ)T‘£8.<¿RMÿ\$‰žôÛØ'ßbyï\n5øƒÝõ_ŽàwñÎ°íUð’`eiÞ¿J”b©gðuSÍë?Íå`öážì+¾Ïï Mïgè7`ùïí\0¢_Ô-ûŸõ_÷–?õF°\0“õ¸X‚å´’[²¯Jœ8&~D#Áö{P•Øô4Ü—½ù\"›\0ÌÀ€‹ý§ý@Ò“–¥\0F ?* ^ñï¹å¯wëÐž:ð¾uàÏ3xKÍ^ów“¼¨ß¯‰y[Ôž(žæ–µ#¦/zr_”g·æ?¾\0?€1wMR&M¿†ù?¬St€T]Ý´Gõ:I·à¢÷ˆ)‡©Bïˆ‹ vô§’½1ç<ôtÈâ6½:W{ÀŠôx:=Èî‘ƒŒÞšóø:Â!!\0x›Õ˜£÷q&áè0}z\"]ÄÞo•z¥™ÒjÃw×ßÊÚÁ6¸ÒJ¢PÛž[\\ }ûª`S™\0à¤qHMë/7B’€P°ÂÄ]FTã•8S5±/IÑ\rŒ\n îO¯0aQ\n >Ã2­j…;=Ú¬ÛdA=­p£VL)Xõ\nÂ¦`e\$˜TÆ¦QJÎk´7ª*Oë .‰ˆ…òÄ¡\röµš\$#pÝWT>!ªªv|¿¢}ë× .%˜Á,;¨ê›å…­Úf*?«ç„˜ïô„\0¸ÄpD›¸! ¶õ#:MRcúèB/06©­®	7@\0V¹vg€ ØÄhZ\nR\"@®ÈF	‘Êä¼+Êš°EŸIÞ\n8&2ÒbXþPÄ¬€Í¤=h[§¥æ+ÕÊ‰\r:ÄÍFû\0:*åÞ\r}#úˆ!\"¤c;hÅ¦/0ƒ·Þ’òEj®íÁ‚Î]ñZ’Žˆ‘—\0Ú@iW_–”®h›;ŒVRb°ÚP%!­ìb]SBšƒ’õUl	åâ³érˆÜ\rÀ-\0 À\"Q=ÀIhÒÍ€´	 F‘ùþLèÎFxR‚Ñ@œ\0*Æj5Œük\0Ï0'	@El€O˜ÚÆH CxÜ@\"G41Ä`Ï¼P(G91«Ž\0„ð\"f:QÊ¸@¨`'>7ÑÈŽädÀ¨ˆíÇR41ç>ÌrIHõGt\n€RH	ÀÄbÒ€¶71»ìfãh)Dª„8 B`À†°(V<Q§8c? 2€´€EŽ4j\0œ9¼\r‚Íÿ@‹\0'FúDš¢,Å!ÓÿH=Ò* ˆEí(×ÆÆ?Ñª&xd_H÷Ç¢E²6Ä~£uÈßG\0RXýÀZ~P'U=Çß @žèÏÈl+A­\n„h£IiÆ”ü±ŸPG€Z`\$ÈP‡þ‘À¤Ù.Þ;ÀEÀ\0‚}€ §¸Q±¤“äÓ%èÑÉjA’W’Ø¥\$»!ýÉ3r1‘ {Ó‰%i=IfK”!Œe\$àžé8Ê0!üh#\\¹HF|Œi8tl\$ƒðÊlÀìläi*(ïG¸ñçL	 ß\$€—xØ.èq\"Wzs{8d`&ðWô©\0&E´¯Íì15jWäb¬öÄ‡ÊÞV©R„³™¿-#{\0ŠXi¤²Äg*÷š7ÒVF3‹`å¦©p@õÅ#7°	å†0€æ[Ò®–¬¸[øÃ©hË–\\áo{ÈáÞT­ÊÒ]²ï—Œ¼Å¦á‘€8l`f@—reh·¥\nÊÞW2Å*@\0€`K(©L•Ì·\0vTƒË\0åc'L¯ŠÀ:„” 0˜¼@L1×T0b¢àhþWÌ|\\É-èïÏDN‡óž€\ns3ÀÚ\"°€¥°`Ç¢ùè‚’2ªå€&¾ˆ\rœU+™^ÌèR‰eS‹n›i0ÙuËšb	J˜’€¹2s¹Ípƒs^n<¸¥òâ™±Fl°aØ\0¸š´\0’mA2›`|ØŸ6	‡¦nrÁ›¨\0DÙ¼Íì7Ë&mÜß§-)¸ÊÚ\\©ÆäÝŒ\n=â¤–à;* ‚Þb„è“ˆÄT“‚y7cú|o /–Ôßß:‹ît¡P<ÙÀY: žK¸&C´ì'G/Å@ÎàQ *›8çv’/‡À&¼üòWí6p.\0ªu3«žŒñBq:(eOPáp	”é§²üÙã\rœ‹á0ž(ac>ºNö|£º	“t¹Ó\n6vÀ_„îeÝ;yÕÎè6fügQ;yúÎ²[Sø	äëgöÇ°èO’ud¡dH€Hð= Z\ræ'ÚÊùqC*€) žœîgÂÇEêO’€ \" ð¨!kÐ('€`Ÿ\nkhTùÄ*ösˆÄ5R¤Eöa\n#Ö!1¡œ¿‰×\0¡;ÆÇSÂiÈ¼@(àl¦Á¸I× Ìv\rœnj~ØçŠ63¿ÎˆôI:h°ÔÂƒ\n.‰«2plÄ9Btâ0\$bº†p+”Ç€*‹tJ¢ðÌ¾s†JQ8;4P(ý†Ò§Ñ¶!’€.Ppk@©)6¶5ý”!µ(ø“\n+¦Ø{`=£¸H,É\\Ñ´€4ƒ\"[²Cø»º1“´Œ-èÌluoµä¸4•[™±â…EÊ%‡\"‹ôw] Ù(ã ÊTe¢)êK´A“E={ \n·`;?Ýôœ-ÀGŠ5I¡í­Ò.%Á¥²þéq%EŸ—ýs¢é©gFˆ¹s	‰¦¸žŠKºGÑøn4i/,­i0·uèx)73ŒSzgŒâÁV[¢¯hãDp'ÑL<TM¤äjP*oœâ‰´‘\nHÎÚÅ\n 4¨M-W÷NÊA/î†@¤8mH¢‚Rp€tžp„V”=h*0ºÁ	¥1;\0uG‘ÊT6’@s™\0)ô6À–Æ£T\\…(\"ŽèÅU,ò•C:‹¥5iÉKšl«ì‚Û§¡E*Œ\"êrà¦ÔÎ.@jRâJ–QîŒÕ/¨½L@ÓSZ”‘¥Põ)(jjžJ¨««ŽªÝL*ª¯Ä\0§ªÛ\r¢-ˆñQ*„QÚœgª9é~P@…ÕÔH³‘¬\n-e»\0êQw%^ ETø< 2Hþ@Þ´îe¥\0ð e#;öÖI‚T’l“¤Ý+A+C*’YŒ¢ªh/øD\\ð£!é¬š8“Â»3AÐ™ÄÐEðÍE¦/}0tµJ|™ÀÝ1Qm«Øn%(¬p´ë!\nÈÑÂ±UË)\rsEXú‚’5u%B- ´Àw]¡*•»E¢)<+¾¦qyV¸@°mFH òÔšBN#ý]ÃYQ1¸Ö:¯ìV#ù\$“æ þô<&ˆX„€¡úÿ…x« tš@]GðíÔ¶¥j)-@—qÐˆL\nc÷I°Y?qC´\ràv(@ØËX\0Ov£<¬Rå3X©µ¬Q¾Jä–Éü9Ö9ÈlxCuÄ«d±± vT²Zkl\rÓJíÀ\\o›&?”o6EÐq °³ªÉÐ\r–÷«'3úËÉª˜J´6ë'Y@È6ÉFZ50‡VÍT²yŠ¬˜C`\0äÝVS!ýš‹&Û6”6ÉÑ³rD§f`ê›¨Jvqz„¬àF¿ ÂÂò´@è¸Ýµ…šÒ…Z.\$kXkJÚ\\ª\"Ë\"àÖi°ê«:ÓEÿµÎ\roXÁ\0>P–¥Pðmi]\0ªöö“µaV¨¸=¿ªÈI6¨´°ÎÓjK3ÚòÔZµQ¦m‰EÄèðbÓ0:Ÿ32ºV4N6³´à‘!÷lë^Ú¦Ù@hµhUÐ>:ú	˜ÐE›>jäèÐú0g´\\|¡Shâ7yÂÞ„\$•†,5aÄ—7&¡ë°:[WX4ÊØqÖ ‹ìJ¹Æä×‚Þc8!°H¸àØVD§ÄŽ­+íDŠ:‘¡¥°9,DUa!±X\$‘ÕÐ¯ÀÚ‹GÁÜŒŠBŠt9-+oÛt”L÷£}Ä­õqK‹‘x6&¯¯%x”ÏtR¿–éð\"ÕÏ€èR‚IWA`c÷°È}l6€Â~Ä*¸0vkýp«Ü6Àë›8z+¡qúXöäw*·EƒªIN›¶ªå¶ê*qPKFO\0Ý,ž(Ð€|œ•‘”°k *YF5”åå;“<6´@ØQU—\"×ð\rbØOAXÃŽvè÷v¯)H®ôo`STÈpbj1+Å‹¢e²Á™ Ê€Qx8@¡‡ÐÈç5\\Q¦,Œ‡¸Ä‰NëÝÞ˜b#Y½H¥¯p1›ÖÊøkB¨8NüoûX3,#UÚ©å'Ä\"†é”€ÂeeH#z›­q^rG[¸—:¿\r¸m‹ngòÜÌ·5½¥V]«ñ-(ÝWð¿0âëÑ~kh\\˜„ZŠå`ïél°êÄÜk ‚oÊjõWÐ!€.¯hFŠÔå[tÖA‡wê¿e¥Mà««¡3!¬µÍæ°nK_SF˜j©¿þ-S‚[rœÌ€wä´ø0^Áh„fü-´­ý°?‚›ýXø5—/±©Š€ëëIY ÅV7²a€d ‡8°bq·µbƒn\n1YRÇvT±õ•,ƒ+!Øýü¶NÀT£î2IÃß·ÄÄ÷„ÇòØ‡õ©K`K\"ð½ô£÷O)\nY­Ú4!}K¢^²êÂàD@á…÷naˆ\$@¦ ƒÆ\$AŠ”jÉËÇø\\‹D[=Ë	bHpùSOAG—ho!F@l„UËÝ`Xn\$\\˜Íˆ_†¢Ë˜`¶âHBÅÕ]ª2ü«¢\"z0i1‹\\”ÞÇÂÔwù.…fyÞ»K)£îíÂ‡¸ pÀ0ä¸XÂS>1	*,]’à\r\"ÿ¹<cQ±ñ\$t‹„qœ.‹ü	<ð¬ñ™Ž+t,©]Lò!È{€gŽüãX¤¶\$¤6v…˜ùÇ ¡Žš£%GÜHõ–ÄØœÈEŽ ÒXÃÈ*Á‚0ÛŠ)q¡nCØ)I›ûà\"µåÚÅÞíˆ³¬`„KFçÁ’@ïd»5Œê»AÈÉp€{“\\äÓÀpÉ¾Nòrì'£S(+5®ÐŠ+ \"´Ä€£U0ÆiËÜ›úæ!nMˆùbrKÀðä6Ãº¡r–ì¥â¬|aüÊÀˆ@Æx|®²kaÍ9WR4\"?5Ê¬pýÛ“•ñk„rÄ˜«¸¨ýß’ðæ¼7Â—Hp†‹5YpW®¼ØG#ÏrÊ¶AWD+`¬ä=Ê\"ø}Ï@HÑ\\Žp°“Ð€©ß‹Ì)C3Í!ŽsO:)Ùè_F/\r4éÀç<A¦…\nn /Tæ3f7P1«6ÓÄÙýOYÐ»Ï²‡¢óqì×;ìØÀæaýXtS<ã¼9Ânws²x@1ÎžxsÑ?¬ï3Åž@¹…×54„®oÜÈƒ0»ÞÐïpR\0Øà¦„†Îù·óâyqßÕL&S^:ÙÒQð>\\4OInƒZ“nçòvà3¸3ô+P¨…L(÷Ä”ð…Àà.x \$àÂ«Cå‡éCnªAžkçc:LÙ6¨ÍÂr³w›ÓÌh°½ÙÈnr³Zêã=è»=jÑ’˜³‡6}MŸGýu~3ùšÄbg4Åùôs6sóQé±#:¡3g~v3¼ó€¿<¡+Ï<ô³Òa}Ï§=Îe8£'n)ÓžcCÇzÑ‰4L=hýŒ{i´±Jç^~çƒÓwg‹Dà»jLÓéÏ^šœÒÁ=6Î§NÓ”êÅÁ¢\\éÛDóÆÑN”†êEý?hÃ:SÂ*>„ô+¡uúhhÒ…´W›E1j†x²Ÿôí´ŠtÖ'Îtà[ îwS²¸ê·9š¯Tö®[«,ÕjÒv“òÕîžt£¬A#T™¸Ôæž‚9ìèj‹K-õÒÞ ³¿¨Yèi‹Qe?®£4ÓžÓÁë_WzßÎéó‹@JkWYêhÎÖpu®­çj|z4×˜õ	èi˜ðm¢	àO5à\0>ç|ß9É×–«µè½ öëgVyÒÔu´»¨=}gs_ºãÔV¹sÕ®{çk¤@r×^—õÚ(ÝwÏ…øH'°Ýaì=i»ÖNÅ4µ¨‹ë_{Ï6ÇtÏ¨ÜöÏ—e [Ðh-¢“Ul?Jîƒ0O\0^ÛHlõ\0.±„Z‚’œ¼âÚxu€æð\"<	 /7ÁŠ¨Ú û‹ïi:Ò\nÇ ¡´à;íÇ!À3ÚÈÀ_0`ž\0H`ž€Â2\0€ŒHò#h€[¶P<í¦†‘×¢g¶Ü§m@~ï(þÕ\0ßµkâY»vÚæâ#>¥ù„\nz\n˜@ÌQñ\n(àGÝ\nöüàŽ'kóš¦èº5“n”5Û¨Ø@_`Ð‡_l€1Üþèwp¿Pî›w›ªÞ\0…ŽcµÐoEl{ÅÝ¾é7“»¼¶o0ÐÛÂôIbÏên‹zÛÊÞÎï·›¼ ‹ç{Ç8øwŽ=ëîŸ| /yê3aíß¼#xqŸÛØò¿»@ï÷kaà!ÿ\08dîmˆäR[wvÇ‹RGp8øŸ vñ\$Zü½¸mÈûtÜÞÝÀ¥·½íôºÜû·Ç½Ôîûu€oÝp÷`2ðãm|;#x»mñnç~;ËáVëE£ÂíØðÄü3OŸ\r¸,~o¿w[òáNêø}ºþ ›clyá¾ñ¸OÄÍÞñ;…œ?á~ì€^j\"ñWz¼:ß'xWÂÞ.ñ	Áu’(¸ÅÃäq—‹<gâçv¿hWq¿‰\\;ßŸ8¡Ã)M\\³š5vÚ·x=h¦iºb-ÀÞ|bÎðàpyŽDÐ•Hh\rceà˜y7·p®îxþÜG€@D=ð Öù§1Œÿ!4Ra\r¥9”!\0'ÊYŒŸ¥@>iS>æ€Ö¦Ÿo°óoòÎfsO 9 .íþéâ\"ÐF‚…ló20åðE!Qšá¦çËD9dÑBW4ƒ›\0û‚y`RoF>FÄa„‰0‘ùÊƒó0	À2ç<‚IÏP'\\ñçÈIÌ\0\$Ÿœ\n R aUÐ.‚sÐ„«æ\"ùŽš1Ð†…eºYç ¢„Zêqœñ1 |Ç÷#¯G!±P’P\0|‰HÇFnp>Wü:¢ž`YP%”ÄâŸ\nÈa8‰ÃP>‘ÁÁè–™`]‘‹4œ`<Ðr\0ùÃŽ›ç¨û¡–z–4Ù‡¥Ë8€ùÎÐ4ó`mãh:¢Îª¬HDªãÀjÏ+p>*ä‹ÃÄê8äŸÕ 08—A¸È:€À»Ñ´]wêÃºùz>9\n+¯ççÍÀñØ:Ž—°ii“PoG0°Öö1þ¬)ìŠZ°Ú–èn¤È’ì×eRÖ–Üí‡g£M¢à”ÀŒgs‰LC½rç8Ð€!°†À‚Œ3R)Îú0³0Œôs¨IéJˆVPpK\n|9e[á•ÖÇË‘²’D0¡Õ àz4Ï‘ªo¥Ôéáèà´,N8nåØsµ#{è“·z3ð>¸BSý\";Àe5VD0±¬š[\$7z0¬ºøÃËã=8þ	T 3÷»¨Q÷'R’±—’ØnÈ¼LÐyÅ‹ìö'£\0oäÛ,»‰\0:[}(’¢ƒ|×ú‡X†>xvqWá“?tBÒE1wG;ó!®Ý‹5Î€|Ç0¯»JI@¯¨#¢ˆÞuÅ†Iážø\\p8Û!'‚]ß®šl-€låSßBØð,Ó—·»ò]èñ¬1‡Ô•HöÿNÂ8%%¤	Å/;FGSôòôhé\\Ù„ÓcÔt²¡á2|ùWÚ\$tøÎ<ËhÝOŠ¬+#¦BêaN1ùç{ØÐyÊwòš°2\\Z&)½d°b'ž,XxmÃ~‚Hƒç@:d	>=-Ÿ¦lK¯ŒÜþJí€\0ŸÌÌó@€rÏ¥²@\"Œ(AÁñïªýZ¼7Åh>¥÷­½\\Íæú¨#>¬õø\0­ƒXrã—YøïYxÅæq=:žšÔ¹ó\rlŠoæm‡gbööÀ¿À˜ï„D_àTx·C³ß0.Šôy€†R]Ú_ÝëÇZñÇ»WöIàëGÔï	MÉª(®É|@\0SO¬ÈsÞ {î£”ˆø@k}äFXSÛb8àå=¾È_ŠÔ”¹l²\0å=ÈgÁÊ{ HÿÉyGüÕáÛ sœ_þJ\$hkúF¼q„àŸ÷¢Éd4Ï‰ø»æÖ'ø½>vÏ¬ !_7ùVq­Ó@1zë¤uSe…õjKdyuëÛÂS©.‚2Œ\"¯{úÌKþØË?˜s·ä¬Ë¦h’ßRíd‚é`:y—ÙåûGÚ¾\nQéý·Ùßow’„'öïhS—î>ñ©¶‰LÖX}ðˆe·§¸G¾â­@9ýãíŸˆüWÝ|íøÏ¹û@•_ˆ÷uZ=©‡,¸åÌ!}¥ÞÂ\0äI@ˆä#·¶\"±'ãY`¿Ò\\?Ìßpó·ê,Gú¯µý×œ_®±'åGúÿ²Ð	ŸT†‚#ûoŸÍH\rþ‡\"Êëúoã}§ò?¬þOé¼”7ç|'ÎÁ´=8³M±ñQ”yôaÈH€?±…ß®‡ ž³ÿ\0ÿ±öbUdè67þÁ¾I Oöäïû\"-¤2_ÿ0\rõ?øÿ«–ÿ hO×¿¶t\0\0002°~þÂ° 4²¢ÌK,“Öoh¼Î	Pc£ƒ·z`@ÚÀ\"îœâŒàÇH; ,=Ì 'S‚.bËÇS„¾øàCc—ƒêìšŒ¡R,~ƒñXŠ@ '…œ8Z0„&í(np<pÈ£ð32(ü«.@R3ºÐ@^\r¸+Ð@ , öò\$	ÏŸ¸„E’ƒèt«B,²¯¤âª€Ê°h\r£><6]#ø¥ƒ;‚íC÷.ÒŽ€¢ËÐ8»Pð3þ°;@æªL,+>½‰p(#Ð-†f1Äz°Áª,8»ß ÆÆPà:9ÀŒï·RðÛ³¯ƒ¹†)e\0Ú¢R²°!µ\nr{Æîe™ÒøÎGA@*ÛÊnDöŠ6ÁŽ»ðòóíN¸\rŽR™Ôø8QK²0»àé¢½®À>PN°Ü©IQ=r<á;&À°fÁNGJ;ðUAžõÜ¦×A–P€&žþõØã`©ÁüÀ€);‰ø!Ðs\0î£Áp†p\r‹¶à‹¾n(ø•@…%&	S²dY«ÞìïuCÚ,¥º8O˜#ÏÁ„óòoªšêRè¬v,€¯#è¯|7Ù\"Cp‰ƒ¡Bô`ìj¦X3«~ïŠ„RÐ@¤ÂvÂø¨£À9B#˜¹ @\nð0—>Tíõá‘À-€5„ˆ/¡=è€ ¾‚ÝE¯ž—Ç\nç“Âˆd\"!‚;ÞÄp*n¬¼Z²\08/ŒjX°\r¨>F	PÏe>À•OŸ¢LÄ¯¡¬O0³\0Ù)kÀÂºã¦ƒ[	ÀÈÏ³Âêœ'L€Ù	Ãåñƒ‚é›1 1\0ø¡Cë 1Tº`©„¾ìRÊz¼Äš£îÒp®¢°ÁÜ¶ìÀ< .£>î¨5ŽÝ\0ä»¹>Ÿ BnËŠ<\"he•>ÐººÃ®£çsõ!ºHý{Ü‘!\rÐ\rÀ\"¬ä| ‰>Rš1dàö÷\"U@ÈD6ÐåÁ¢3£çðŸ>o\r³çá¿vžL:K„2å+Æ0ì¾€>°È\0äí ®‚·Bé{!r*Hî¹§’y;®`8\0ÈËØ¯ô½dþ³ûé\rÃ0ÿÍÀ2AþÀ£î¼?°õ+û\0ÛÃ…\0AŽ¯ŽƒwSû‡lÁ²¿°\r[Ô¡ª6ôcoƒ=¶ü¼ˆ0§z/J+ê†ŒøW[·¬~C0‹ùeü30HQP÷DPY“}‡4#YDö…ºp)	º|û@Ž¥&ã-À†/F˜	á‰T˜	­«„¦aH5‘#ƒëH.ƒA>Ðð0;.¬­þY“Ä¡	Ã*ûD2 =3·	pBnuDw\n€!ÄzûCQ \0ØÌHQ4DË*Žñ7\0‡JÄñ%Ä±pŽuD (ôO=!°>®u,7»ù1†ãTMŽ+—3ù1:\"P¸Ä÷”RQ?¿“üP°Š¼+ù11= ŒM\$ZÄ×lT7Å,Nq%E!ÌS±2Å&öŒU*>GDS&¼ªéó›ozh8881\\:ÑØZ0hŠÁÈT •C+#Ê±A%¤¤D!\0ØïòñÁXDAÀ3\0•!\\í#h¼ªí9bÏ‚T€!dª—ˆÏÄY‘j2ôSëÈÅÊ\nA+Í½¤šHÈwD`íŠ(AB*÷ª+%ÕEï¬X.Ë Bé#ºƒÈ¿Œ¸&ÙÄXe„EoŸ\"×è|©r¼ª8ÄW€2‘@8Daï|ƒ‚ø÷‘Š”Núhô¥ÊJ8[¬Û³öÂö®WzØ{Z\"L\0¶\0ž€È†8ØxŒÛ¶X@”À E£Íïë‘h;¿af˜¼1Âþ;nÃÎhZ3¨E™Â«†0|¼ ì˜‘­öAà’£tB,~ôŠW£8^»Ç ×ƒ‚õ<2/	º8¢+´¨Û”‚O+ %P#Î®\n?»ß‰?½þeË”ÁO\\]Ò7(#û©DÛ¾(!c) NöˆºÑMF”E£#DXîgï)¾0Aª\0€:ÜrBÆ×``  ÚèQ’³H>!\rB‡¨\0€‰V%ce¡HFH×ñ¤m2€B¨2IêµÄÙë`#ú˜ØD>¬ø³n\n:LŒýÉ9CñÊ˜0ãë\0“x(Þ©(\nþ€¦ºLÀ\"GŠ\n@éø`[Ãó€Š˜\ni'\0œð)ˆù€‚¼y)&¤Ÿ(p\0€Nˆ	À\"€®N:8±é.\r!'4|×œ~¬ç§ÜÙÊ€ê´·\"…cúÇDlt‘Ó¨Ÿ0c«Å5kQQ×¨+‹ZŽGkê!F€„cÍ4ˆÓRx@ƒ&>z=Ž¹\$(?óŸïÂ(\nì€¨>à	ëÒµ‚ÔéCqÛŒ¼Œt-}ÇG,tòGW ’xqÛHf«b\0ž\0zÕìƒÁT9zwÐ…¢Dmn'îccb H\0z…‰ñ3¹!¼€ÑÔÅ HóÚHz×€Iy\",ƒ- \0Û\"<†2ˆî Ð'’#H`†d-µ#clŽjÄž`³­i(º_¤ÈdgÈŽíÇ‚*Ój\rª\0ò>Â 6¶ºà6É2ókjã·<ÚCq‘Ð9àÄ†ÉI\r\$C’AI\$x\r’H¶È7Ê8 Ü€Z²pZrR£òà‚_²U\0äl\r‚®IRXi\0<²äÄÌr…~xÃS¬é%™Ò^“%j@^ÆôT3…3É€GH±z€ñ&\$˜(…Éq\0Œšf&8+Å\rÉ—%ì–2hCüx™¥ÕI½šlbÉ€’(hòSƒY&àBªÀŒ•’`”f•òxÉv n.L+þ›/\"=I 0«d¼\$4¨7rŒæ¼A£„õ(4 2gJ(D˜á=F„¡â´Èå(«‚û-'Ä òXGô29Z=˜’Ê,ÊÀr`);x\"Éä8;²–>û&…¡„ó',—@¢¤2Ãpl²—ä:0ÃlI¡¨\rrœJDˆÀúÊ»°±’hAÈz22pÎ`O2hˆ±8H‚´Ä„wt˜BF²Œg`7ÉÂä¥2{‘,Kl£ð›Œß°%C%úomû€¾àÀ’´ƒ‘+X£íûÊ41ò¹¸Ž\nÈ2pŠÒ	ZB!ò=VÆÜ¨èÈ€Ø+H6²ÃÊ*èª\0ækÕà—%<² øK',3ØrÄI ;¥ 8\0Z°+EÜ­Ò`Ðˆ²½Êã+l¯ÈÏËW+¨YÒµ-t­fËb¡Qò·Ë_-Ó€Þ…§+„· 95ŠLjJ.GÊ©,\\·òÔ….\$¯2ØJè\\„- À1ÿ-c¨²‚Ë‡.l·fŒxBqK°,d·èË€â8äA¹Ko-ô¸²îÃæ²°3KÆ¯r¾¸/|¬ÊËå/\\¸r¾Ëñ,¡HÏ¤¸!ðYÀ1¹0¤@­.Â„&|˜ÿËâ+ÀéJ\0ç0P3JÍ-ZQ³	»\r&„‘Ãá\nÒLÑ*ÀËÞj‘Ä‰|—ÒåËæ#Ô¾ª\"Ëº“AÊï/ä¹òû8)1#ï7\$\"È6\n>\nô¢Ã7L1à‹òh9Î\0B€Z»d˜#©b:\0+A¹¾©22ÁÓ'Ì•\nt ’ÄÌœÉOÄç2lÊ³.L¢”HC\0™é2 ó+L¢\\¼™r´Kk+¼¹³Ë³.êŒ’êº;(DÆ€¢Êù1s€ÕÌòdÏs9Ìú•¼ P4ÊìŒœÏó@‹.ìÄáAäÅnhJß1²3óKõ0„Ñ3J\$\0ìÒ2íLk3ãˆáQÍ;3”Ñn\0\0Ä,ÔsIÍ@Œûu/VAÅ1œµ³UMâ<ÆLe4DÖ2þÍV¢% ¨Ap\nÈ¬2ÉÍ35ØòÐA-´“TÍu5š3òÛ¹1+fL~ä\nô°ƒ	„õ->£° ÖÒ¡M—4XLóS†õdÙ²ÖÍŸ*\\Ú@Í¨€˜YÓk¤Š¤ÛSDM»5 Xf° ¬ªD³s¤äÀUs%	«Ì±p+Ké6ÄÞ/ÍÔüÝ’ñ8XäÞ‚=K»6pHà†’ñ%è3ƒÍ«7lØI£K0ú¤ÉLíÎD»³uƒêõ`±½P\rüÙSOÍ™&(;³L@Œ£ÏˆN>Sü¸2€Ë8(ü³Ò`J®E°€r­F	2üåSE‰”M’†MÈá\$qÎE¶Ÿ\$ÔÃ£/I\$\\“ãáIDå\" †\nä±º½w.tÏS	€æ„Ñ’Pðò#\nWÆõ-\0CÒµÎ:jœRíÍ^Süí„Å8;dì`”£ò5ÔªaÊ–ÇôE¹+(XröMë;Œì3±;´•ó¼B,Œ˜*1&î“ÃÎË2XåS¼ˆõ)<Í ­L9;òRSN¼Þ£ÁgIs+ÜëÓ°Kƒ<¬ñsµLY-Z’:A<áÓÂOO*œõ2vÏW7¹¹+|ô €Ë»<TÖóÕ9 h’“²Ïy\$<ôÎ#Ï;ÔöÓá›v±\$öOé\0­ ¬,Hkòü-äõàÏš\rÜú²ŸÏ£;„”¹O•>ìù“·Ë7>´§3@O{.4öpO½?TübÃÏË.ë.~O…4ôÏSïÏì>1SS€Ï*4¶PÈ£ó>ü·ÁÏï3í\0ÒWÏ>´ô2å><ëóßP?4€Û@Œôt\nNÀÇùAŒxpÜû%=P@ÅÒCÏ@…RÇËŸ?x°ó\n˜´Œ0NòwÐO?ÕTJC@õÎ#„	.dþ“·MêÌt¯&=¹\\ä4èÄAÈå:L“¥€í\$ÜéÒNƒ­:Œ’\rÎÉI'Å²–AÕráŒ;\r /€ñCôÈåBåÓ®Œi>LèŠ7:9¡¡€ö|©C\$ÊË)Ñù¡­¹z@´tlÇ:>€úCê\n²Bi0GÚ,\0±FD%p)o\0Š°©ƒ\n>ˆú`)QZIéKGÚ%M\0#\0DÐ ¦Q.Hà'\$ÍE\n «\$Ü%4IÑD°3o¢:LÀ\$£Îm ±ƒ0¨	ÔB£\\(Ž«¨8üÃé€š…hÌ«D½ÔCÑsDX4TK€¦Œ{ö£xì`\n€,…¼\nE£ê:Òp\nÀ'€–> ê¡o\0¬“ýtIÆ` -\0‹D½À/€®KPú`/¤êøH×\$\n=‰€†>´U÷FP0£ëÈUG}4B\$?EýÛÑž%”T€WD} *©H0ûT„\0tõ´†‚ÂØ\"!o\0Eâ7±ïR.“€útfRFu!ÔDð\nï\0‡F-4V€QHÅ%4„Ñ0uN\0ŸDõQRuEà	)ÍI\n &Q“m€)Çš’m ‰#\\˜“ÒD½À(\$Ì“x4€€WFM&ÔœR5Hå%qåÒ[F…+ÈùÑIF \nT«R3DºLÁo°Œ¼y4TQ/E´[Ñž<­t^ÒËFü )Qˆå+4°Q—IÕ#´½‰IF'TiÑªXÿÀ!Ñ±FÐ*ÔnRÊ>ª5ÔpÑÇKm+ÔsÇÜ û£ïÒáIåôŸREý+Ô©¤ÙM\0ûÀ(R°?+HÒ€¥Jí\"TÃDˆª\$˜Œà	4wQà}Tz\0‹Gµ8|ÒxçÍ©R¢õ6ÀRæ	4XR6\nµ4yÑmNôãQ÷NMà&RÓH&É2Q/ª7#èÒ›Ü{©'ÒÒ,|”’ÇÎ\n°	.·\0˜>Ô{Áo#1D…;ÀÂÐ?Uô‘Ò•Jò9€*€š¸j”ý€¯F’N¨ÒÑ‰Jõ #Ñ~%-?CôÇßL¨3Õ@EP´{`>QÆÈ”µÔ%Oí)4ïR%IŠ@Ôô%,\"ÕÓùIÕ<‘ëÓÏå\$Ô‰TP>Ð\nµ\0QP5DÿÓkOFÕTYµ<ÁoýQ…=T‰\0¬“x	5©D¥,Â0?ÍiÎ?xþ  ºmE}>Î|¤ÀŒÀ[Èç\0žŽ€•&RL€ú”H«S9•G›I›§1ä€–Ž…M4V­HþoT-S)QãGÇF [ÃùTQRjN±ã#x]N(ÌU8\nuU\n?5,TmÔž?Ðÿ’Ü?€þ@ÂU\nµu-€‹Rê9ãðU/S \nU3­IEStQYJu.µQÒõF´o\$&ŒÀûi	ÜKPCó6Â>å5µG\0uR€ÿu)U'R¨0”Ð€¡DuIU…J@	Ô÷:åV8*ÕRf%&µ\\¿RÈõMU9RøüfUAU[T°UQSe[¤µ\0KeZUa‚­UhúµmS<»®À,Rès¨`&Tj@ˆçGÇ!\\xô^£0>¨þ\0&ÀpÿÎ‚Q¿Q)T˜UåPs®@%\0ŸW€	`\$Ôò(1éQ?Õ\$CïQp\nµOÔJ¹ñX#ƒýV7Xu;Ö!YBî°ÓSåcþÑ+V£ÎÃñ#MUÕW•HÍUýR²Ç…U-+ôðVmY}\\õ€ÈOK¥Mƒì\$ÉSíeToV„ŒÍHTùÑ!!<{´RÓÍZA5œRÁ!=3U™¤(’{@*Ratz\0)QƒP5HØÒ“ÎÕ°­N5+•–ÏP[Ôí9óV%\"µ²ÖØ\n°ýñäG•SL•µÔò9”ùÇÌë•lÀ£ˆ‘\rVˆØ¤Í[•ouºUIY…R_T©Y­p5OÖ§\\q`«U×[ÕBu'Uw\\mRUÇÔ­\\Es5ÓK\\úƒïVÉ\\ÅS•{×AZ%Oõ¼\$Ü¥FµÔ¬>ý5E×WVm`õ€Wd]& \$ÑÎŒÅ•ÛÓ!R¥Z}Ô…]}v5À€§ZUgôÔQ^y` Ñ!^=F•áRÁ^¥vëUÅKex@+¤Þr5À#×@?=”uÎ“s •¤×¥YšNµsS!^c5ð\$.“u`µÜ\0«XE~1ï9Ò…JóUZ¢@²#1_[­4JÒ2à\nà\$VI²4n»\0˜?ò4aªRç!U~)&ÓòB>t’RßIÕ0ÀÔ_EkTUSØœ|µýUk_Â8€&€›E°ü(â€˜?â@õ××JÒ5Ò½JU†BQT}HVÖ‘j€¤Qx\neÖVsU=ƒÔýV‘N¢4Õ²Ø—\\xèÒÖïR34ÝG¿D\":	KQþ>˜[Õ\rÕY_å#!ª#][j<6Ø®X	¨ìÍc‰•Ø#KL}>`'\0Ž¨5”XÑcU[\0õ(ÔÙÑWt|tô€R]pÀ/£]H2I€QO‹­1âS©Qj•Z€¨¸´Hº´m¨ÌÙ)dµ^SXCY\rtu@Jëpüµ%ÓÿM¸ø€¨óµ“Ö?ÙUQ°\nö=Råar:Ô¿Eí‘À¥-G€\0\$ÑÇd½“ö]Òmeh*ÃìQ‰Wt„öc€¡`•˜AªY=S\r®¯«	m-´‚¤=MwÖH£]Jå\"ä´Ä õþ­fõ\"´{#9Teœ‰ÙÍMÔc¹ñNêI£òÙßD¥œõÙÜçUœ6ÙñgÑ2Ù×Ý¶eƒa­L´€Q&&uTåX51Y >£óûSýÖŠQ#êIµ¥Õj\0ûœ£ÅW PÑþ?ub5FUóLn¶)V5R¢@ãë\$!%o¶ÔPúÉ'€‰EµUÁÔP-†¶š¤Bp\nµF\$ŸS4…t±UF|{–qÖÈ“0û•ÎUmjsÎÃü€²øý\$´Ú›j…cëÚå¦Ö«€¿aZI5X€ƒj26®¤&>vŽÑ\n\r)2Õ_kîG¶®TJÚÁeQ-cîZñVM­Ö½£z>õ]•a¹c£Ëcìß`t„”HÚÑjÝ6¹£+kŠM–\0Œ>Œ„€##3l=à'´¥^6Í\0¨Ã¨v¦Z9Se£€\"×ÊêbÎ¡ÔB>)•/TÁ=ö9\0ù`Pà\$\0¿]í/0Úª•«äµ½k-š6ÝÛ{küÖá[F\r|´SÑ¿J¥õMQ¿D=õ/ÈWX¢öœV—a¬'¶¹éa¨to€©lå†¶ÐXj}C@\"ÀKPÛÎÖÚom’3\0#HV”µ…v÷Ñ~“{žµÖ?gx	n|[Ø?U¶äµ[rê½h¶ÞG¸`õ3#Gk%L£ê\0¿I`CùDÞê¸	 \"\0ˆŒÅ§¶°#cN«6ßÚ¹fÂÔzÛŽêº;Ñ¤ÃeeF–7Ù/N\r:ôâQñGÕ9	\$ÔóIøÕ¼ºß]£®TÝØWGs«ÔdWõMÚIãèÑÙf’BcêÛ¤êõÂ÷!#cnu&(ÞSã_Õw£ùSfë&TšZ:…0CóSÙLN`Ü³Yj=·¶>Å²ÃñZ!=€rV]gû	Ó£rµ ËXlŒÉ-.¹UÄ'uJuJ\0ƒs­J¶'W%·¶­\\>?òBöëV­j4µÏJ}I/-ÒrRLºSè3\0,RgqÓ­ôÇTf>Ý1Õï\0¥_•”Ç\\V8õ¡ZÛt…Ácè€†ú<^\\ùll´j\0¾˜þT¥]CÝÔw×Î“zI¶ÙZwN…¶¶pVW…jv»Y¶>2Ó	o\$|U‡WÃL%{toX3_õ¶òR‰J5~6\"×ãZl}´`Ôkc­ÑîÛeR=^UÔŽ•¥1òÑ½w7eØdµÝvŽÙb=á\0ùf €,³må)ÕéGpûÕ-Ó¼½)9Lý“š>|Ôë \"Ì@èû¤5§`†:›ô\0é,€ñt@ºÄxº“òlÃJÈŽ»b¨6 à…½‰ÝaŽÞA\0Ø»ARì[A»Ã0\$qo—AàÊSÒü@Ìø¬<@ÓyÄÐ\"as.âÎä÷V^„•è®¥^õ›…—œ\0ÜÈHÁ·[H@’bK—©Þ)zÀ\r·¨¤¤=éÁ^¿zˆB\0º¿’¤äNéo<Ì‡t<xî£\0Ú¬0*R ºI{¥í®´^æEµî·¸:{KÕ§1Eˆ0²ÓYº•›à/ÕÑcêÀ\"\0„ê¸4øÉF7'€†˜\nÕ0ÝÉ`U£Tù¤?MPÔÀÓlµÈ4ŒÓr(	´ÁZ¿|„€&†©t\"Iµ¿ÖÛL w+Òm}…§÷€Wi\r>ÖU__uÅ÷63ßy[¢8µT-÷ÙVÏ}¤xãô_~è%ø7Ùß{jMáo_šEù÷ØÓë~]ôP\$ßJõCaXGŠ9„\0007Åƒ5óA#á\0.‹Àä\rË´Žž_Ö¢áÀßÚ%þáÀÀ\n€\r#<MÅxØJËù±|¸Ø2ð\0¨–;oŒ^a+F€í¸Îç¬€LkúÁ;À_ÛÝê#€¾M\\“¬€¤pr@ä“ÃµÆÔøÂþOR€¿ñ–~zÇûAÁNE°YÁO	(1N×‰ˆRø¨8Ø€C¼Ž¦ë¨Én?O)ƒ¶1AçDo\0ä\r»Ç¢?àkJâî‘“„\"â,ŽOFÈÌa…›ùª-bà6]PSø)Æ™ 5xCâ=@j°€ÇL”ÁèÈLî˜:\"èƒ»ÎŠ¤l#¢ÀéBèk£“ˆ›ž€ÖË@ •Nº:ê>ï|BéžŽ9î	«Èî”:Nýñ\$èéS¥ CB:j6î—Þé•àÎ‰Jk”†uKð_W›Í¢Ã˜I =@TvãÒ\n0^o…\\¿Ó ?/Á‡&uê.ÞØ_˜æ\r®î¥Cæì+Úøc†~±J¸b†6ÓüØe\0ÍyóÑ¡\0wxêhÁ8j%S›À–VH@N'\\Û¯‡ÆN¥`n\r‹ÒuÞn‰KèqUÃBé+í˜f>G‡°\r¸»ˆ=@G¤Åädç‚†\nã)¬ÐFOÅ hÊ·›†ÃˆfC‡É…X|˜‡I…]æð3auyàUi^â9yÖ\no^rt\r8ÀÍ‡#óîØâN	VÈâY†;Êc*â%Và<›‰#Øh9r \rxcâv(\raŸá¨æ(xja¡`g¸0çVÌ¼°Œ¿Q†©x(ÇëƒÀglÕ°{—Ægh`sW<Kj°'¿;)°Gnq\$¨pæ+ÎÉŒ_ŠÉdø¶^& ¯Š˜DÂxà!bèvÞ!EjPV¤' ââÁ(”=ÏbÂ\rˆ\"–b¦ÝL¼\0€¿Ìbtá‚\n>J¬Ôã1;üù¼ÖîÛˆ¿4^s¨QÁp`Öfr`7‚ˆ«xª»E<lÑÏã	8sþ¯'PT°øÖºæËƒ¸°z_ÊT[>Ð€:Ïó`³1.î¾°;7ó@[ÑÞ>ºž6!¡*\$`²•\0À„æ`,€“øÇàÝÁ@°àáå?Ìm˜>ƒ>\0êLCÇ¸ñˆR¸În™°/+½`;CŠ£Õø\0ê½*€<F“„ö+ëƒâ„q MŒÁþ;1ºK\nÀ:b3j1™Ôl–:c>áYøhôìžÞŽ¾#Ô;ã´Ü3Öº”8à5Ç:ï\\Þï¨\0XH·Â…¶«aþŽ®¸™M1ä\\æL[YC…£vN’·\0+\0Ôät#ø\$¬ÆØØà!@*©l¦„	F»dhdÝýùF›‘à&˜˜Æ˜fó¹)=˜¦0¡ 4…x\0004ED6KÍòä¢£±…”\0ònN¨];qº4sj-Ê=-8½ê†\0æsÇ¨ûˆ¹D§f5p4Œàé©Jè^Öí’'Ó”[úùH^·NR F˜Kw¼z¢Ò ÜÐE”º“ágF|!Èc©ôäo•dbÁêùxß\0ì-åà6ß,Eí„_†íê3uåp ÇÂ/åwz¨( ØexžRaºH¼YùceŠš5ê9d\0ó–0@2@ÒÖYùfey–ŽYÙcM×•ºhÙÃ•Ö[¹ez\rv\\0Áeƒ•ö\\¹cÊƒ†î[Ùue“—NY`•åÛ–Î]9hå§—~^Yqe±–¦]™qe_|6!ŽÞóuï`ŽfÕî™Jæ{è7¸ºM{¶YÙ‡©øj‚eÆÌC»¢S6\0DuasFL}º\$È‡à(å”Mb…ÈàÆ¤,0BuÎ¯…ì¥Ñ‚2ögxFÑ™{a¸n:i\rPjýeÏñ˜rÈrØÏGýBY ˆM+qïçiY”dË™é`0ŽÀ,>6®foš0ù©†o™ó æXf¢äù\0ÀVÝL!“«f…†láœ6 Å/ëæ£1eƒ•\0‰>kbfé\r˜!ïufò<%ä(rË›ùa&	ý™¨àY€Þ!¡Òñ–mBg=@ƒÐ\rç; \rÞ5phI 9bm›\$BYË‹ÿšÄgxç#‰@QEOÇæm9–®Ë0\"€ºç!t¨˜ê†Ë‰¸®Ð‡çO* Ååÿ\0ÂÝ>%Ö\$éoîrN&s9¿f£ž4çù™gŠä~jMùf›wyèg›yí\\`X1y5xÿŒùž^zï_,& kÑæ¢é|¡€À¦1xçÏA‘6ð \nîoè”»Œ&xÙïgg™{r…?ç·›ü-°½…®|tä3±šˆÈÍ}gHgK¢9¿¿¨õJÀ<C C° 1„î9þ7‡g÷š‚ïh6!0Hâí›cdy´fÿ¡DA;ƒ‚9…Tæ¢ÿ®0¬Ä\0ÆpØàù†!‡ 6^ã.øSÂ²?ÆØ¦E(P­Îˆ .æÂ 5€ÄhŠéˆEPJv‰ .‹•¢+—\$ç5Œ>P+µ?~‰¡gŒ6\r³öh¢¼p«z(è†WÙÄ`Â•¨±\"y¯ñÏ:ÐFadÅ¬6:ù¡f˜Þi\0ì˜ÝØàA;áe¢°àì¬ç^ÊÖwf„ >yÍŽŠËõ`-\rŠÚ…á\0­hr\rÎr£8i\"_Ú	££¼9¡CI¹fXËˆ2¦‰š\"ÍÅ¢‰… øh¢L~Š\"ö…š%V•:!%Šžxyèizyg„vxÚ]‚žÆ}qgžÄÃZiŒä|Œ`Ç+ _úgèòú†™Ù£¾úªÂÀÂè­ž6PA€Ê€\$¶=9¢ŒùàÍh‹¢|p’ ÿ¢ˆé˜íè!¢Ž.ø!”þ¶žüiç§^œøÚiË¢Ž8zVCÌùöŒZ\"€æäØ(Ä¥›¹°9èU)û¥!DgU\0Ãjÿã¿?`Çð4ãLTo@•B¤§úN†aš{Ãrç:\nÌŸ“E„»8Ã¦&=êE¨*Z:\n?˜¨g¢èÌŠ£‹h¢õ.•˜’ Nþ5(ˆSƒhÑôi2Ö*c„fý@•“ÑÞ7¦œz\"áƒ|ÖúrP†.Ç€ÊL8T'¿¸k¢ˆß:(¹q2&œÆED±2~žÿ¿Ø±þœŒ¬Ã9ûÒÂv£©¼8ÿƒ©– @úé^X=X`ªqZºÐQ«Ö®`9jø5^ˆ¹å@ç«¸În¼qvž±á¨3±ÚÇèŠ(I6ðªjšdT±ÚÂ\\Š ‚Ÿ3¢,™Ïhék¢3ú(ë3¬‘‘PÒu•VÏ|\0ï§†Uâk;¢ÌJQ¶ã é. Ú	:J\rŽŠ1ŸênìBI\r\0É¬h@˜¼?ÒN±\nsh—®å\"ë’ò;¦r~7O§\$ ú(ã5¤RÅèÆ	èÊ½jÂîšØFYF šÜ”£«~‰xÞ¾©f º\"ã†vÛ“ošëË¨ººÂº#ŒÜaÒèŠõ¶®P“„Ë<ãáh£-3éº/Gx®õ²nÇi@\"’G…?ó¤,ïZpÖxX`v¦4XÆõóàû„[ƒI¶œ7žÃ¥Xc	îÅ!¡bç¢}ÚjŒ_¾¥9á5qti¦6f»ž’°¸ÝÙž5ÿûç FÆ¹ãiÑ±©pX'ø2¡Žrƒ„®0ÆÆºé§D,#GëU2€ÌØâIè\rl(£— €ì±£¦¨=ÐA¸a€ì©³-8›dbSþˆûõ4~‚ô—H;°Â­0à6Çbé{ª„ÞºRæèÃs3zë¯ÃÀüNðÞ„Ž`ÆË†+ò¦­ 4<ø^aƒy°¬”	}r°Âây´õãáû¸kŒ&4@ˆÁ?~ÔäÅcE´ÂÈ­@ˆLS@€Œéz^qqN¦°</H‚j^sCâ`èæsbgGy¹¤Ö^\nÈNó\n:G¶N}¼c\nîÚÕí¤ +£†ï=†pÙ1º’NµTB[dÀÿ¶–š¶Ð‹¢¾Ü¹ñ`³nÚoj;žjÄ›whØõž€c9ƒ‚pÌ¡[y4«¨¶05œÍ‹NßÁ+Î¿·Ð`Xdaáæ/zn*öPÀ‡êÁ¸#tíèµ¸~à9Wî	šVâò~=¸#Ùùn)¨î´î	2ÜÉ;…j:õ°Ják„C¸!>xîù5š£==¦2»—‚. ã|¿'¨îä[€Ì'—;üÚv½ù«–“¸„®÷ÎëÎ;:SA	º&Ð[£me†êãn±ëúûªî™«Ëµ¦Ä•<Ÿº6ma‘=Y.ç¥žÀÅ:g¶ÔþÉè…€ù°žÐ;«Iß»xÅ[”éI¡J\0÷~ÂzaY®íºîüwT\\`–íV\nÆ~P)ézJ¾©æ½üñðQ@Ýà[¶{rÊ‰µDîB„v—ï|i-¹EæøKŒ;^n»{êó½å:Nh;–—Ú2Á¨Æ€pçÑ´6“úƒ»ç½˜9§9¡¥öÖXÂhQœ~—ÛÛiAŸ@D šj‡¥î}ÑozLV÷ïçÑ³~ù•ž	8B?â#F}F¾Td­ë»áÐe±ÃzcîçŸFÅÀŠg‚7Î—Ûêà€ 6ý#.EÂ£¼áÀÖÂ£¥ðS£.J3¥ö5»¯KÉ¥óJ™§¸;¤—„n5¾¾:ySï‘ÀCÛvoÕ½.˜{ñð	d\\0ë?W\0!)ð'šû¼èEgá;à+»\0üY NtŽbp+À†cŒø“þ£\0©B=\"ùc†Tñ:Bœ±Áž¤úcðïˆþîÆï¸P‘IÜÈD¸ÂV0ÊÇ!ROl‰O˜N~aFþ|%Éßº³¸¬…ò)Où¿	Wìo´û‡Qðw¨È:ÙŸlé0h@:ƒ«ÀÖ…8îQ£&™[Ànç¹FïÛp,Ã¦å@‡ºJTöw°9½„(þ†œ<é{ÃÆO\rñ	¥àùÚ‚\$m…/HnP\$o^®U¡Ì\"»¿ã{Ä–…<.îç¡‹n¥q8\rÕ\0;³n£ÄÞÔÛðç¡Ÿˆ+ÎÞ³3¢¼n{ÃD\$7¬,Ez7\0…“l!{˜é8÷á¶xÒ‚°.s8‡PA¹FxÛrðÄÓôQÛ®€¹†1Ì…¸p+@ØdÔÞ9OP5¼lKÂ/¾‘·¾˜\\mæú¸Äs‡q» îvºQí/§ÿÜ	„!»¶åz¼7¾oœ¿EÇ†Ò:qàV 5˜?G¡HO®âO†\$ül¾š+â,òœ\r;ãç°¾¤’~ÎAÄéŒ³é{È`7|‡ÿÄ‚Äàër'‰°Ji\rc+¢|—#+<&Ò›¹<W,Ã>¢»^òPð&nÂJhÐe‡%d¶æìèÏÜCƒi¶zXÃAÿ'DÍ>ÉÎˆ¡Ek£Ê¬@©Bòw(€.–¾\n99Aê¯hNæcîkN¾d`£ÐÂp`Âò°%2ö¦½\0");
    } else {
        header("Content-Type: image/gif");
        switch ($_GET["file"]) {
            case "plus.gif":
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0!„©ËíMñÌ*)¾oú¯) q•¡eˆµî#ÄòLË\0;";
                break;
            case "cross.gif":
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0#„©Ëí#\naÖFo~yÃ._wa”á1ç±JîGÂL×6]\0\0;";
                break;
            case "up.gif":
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMQN\nï}ôža8ŠyšaÅ¶®\0Çò\0;";
                break;
            case "down.gif":
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMñÌ*)¾[Wþ\\¢ÇL&ÙœÆ¶•\0Çò\0;";
                break;
            case "arrow.gif":
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo"GIF89a\0\n\0€\0\0€€€ÿÿÿ!ù\0\0\0,\0\0\0\0\0\n\0\0‚i–±‹ž”ªÓ²Þ»\0\0;";
                break;
        }
    }exit;
}if ($_GET["script"] == "version") {
    $q = file_open_lock(get_temp_dir() . "/adminer.version");
    if ($q) {
        file_write_unlock($q, serialize(array("signature" => $_POST["signature"],"version" => $_POST["version"])));
    }exit;
}global$c,$g,$l,$Kb,$Rb,$bc,$m,$Gc,$Lc,$ba,$dd,$y,$a,$vd,$re,$We,$mg,$Qc,$T,$Ug,$ah,$hh,$fa;
if (!$_SERVER["REQUEST_URI"]) {
    $_SERVER["REQUEST_URI"] = $_SERVER["ORIG_PATH_INFO"];
}if (!strpos($_SERVER["REQUEST_URI"], '?') && $_SERVER["QUERY_STRING"] != "") {
    $_SERVER["REQUEST_URI"] .= "?$_SERVER[QUERY_STRING]";
}if ($_SERVER["HTTP_X_FORWARDED_PREFIX"]) {
    $_SERVER["REQUEST_URI"] = $_SERVER["HTTP_X_FORWARDED_PREFIX"] . $_SERVER["REQUEST_URI"];
}$ba = ($_SERVER["HTTPS"] && strcasecmp($_SERVER["HTTPS"], "off")) || ini_bool("session.cookie_secure");
@ini_set("session.use_trans_sid", false);
if (!defined("SID")) {
    session_cache_limiter("");
    session_name("adminer_sid");
    $Me = array(0,preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]),"",$ba);
    if (version_compare(PHP_VERSION, '5.2.0') >= 0) {
        $Me[] = true;
    }call_user_func_array('session_set_cookie_params', $Me);
    session_start();
}remove_slashes(array(&$_GET,&$_POST,&$_COOKIE), $wc);
if (function_exists("get_magic_quotes_runtime") && get_magic_quotes_runtime()) {
    set_magic_quotes_runtime(false);
}@set_time_limit(0);
@ini_set("zend.ze1_compatibility_mode", false);
@ini_set("precision", 15);
$vd = array('en' => 'English','ar' => 'Ø§Ù„Ø¹Ø±Ø¨ÙŠØ©','bg' => 'Ð‘ÑŠÐ»Ð³Ð°Ñ€ÑÐºÐ¸','bn' => 'à¦¬à¦¾à¦‚à¦²à¦¾','bs' => 'Bosanski','ca' => 'CatalÃ ','cs' => 'ÄŒeÅ¡tina','da' => 'Dansk','de' => 'Deutsch','el' => 'Î•Î»Î»Î·Î½Î¹ÎºÎ¬','es' => 'EspaÃ±ol','et' => 'Eesti','fa' => 'ÙØ§Ø±Ø³ÛŒ','fi' => 'Suomi','fr' => 'FranÃ§ais','gl' => 'Galego','he' => '×¢×‘×¨×™×ª','hu' => 'Magyar','id' => 'Bahasa Indonesia','it' => 'Italiano','ja' => 'æ—¥æœ¬èªž','ka' => 'áƒ¥áƒáƒ áƒ—áƒ£áƒšáƒ˜','ko' => 'í•œêµ­ì–´','lt' => 'LietuviÅ³','ms' => 'Bahasa Melayu','nl' => 'Nederlands','no' => 'Norsk','pl' => 'Polski','pt' => 'PortuguÃªs','pt-br' => 'PortuguÃªs (Brazil)','ro' => 'Limba RomÃ¢nÄƒ','ru' => 'Ð ÑƒÑÑÐºÐ¸Ð¹','sk' => 'SlovenÄina','sl' => 'Slovenski','sr' => 'Ð¡Ñ€Ð¿ÑÐºÐ¸','sv' => 'Svenska','ta' => 'à®¤â€Œà®®à®¿à®´à¯','th' => 'à¸ à¸²à¸©à¸²à¹„à¸—à¸¢','tr' => 'TÃ¼rkÃ§e','uk' => 'Ð£ÐºÑ€Ð°Ñ—Ð½ÑÑŒÐºÐ°','vi' => 'Tiáº¿ng Viá»‡t','zh' => 'ç®€ä½“ä¸­æ–‡','zh-tw' => 'ç¹é«”ä¸­æ–‡',);
function get_lang()
{
    global$a;
    return$a;
}function lang($v, $ie = null)
{
    if (is_string($v)) {
        $Ze = array_search($v, get_translations("en"));
        if ($Ze !== false) {
            $v = $Ze;
        }
    }global$a,$Ug;
    $Tg = ($Ug[$v] ? $Ug[$v] : $v);
    if (is_array($Tg)) {
        $Ze = ($ie == 1 ? 0 : ($a == 'cs' || $a == 'sk' ? ($ie && $ie < 5 ? 1 : 2) : ($a == 'fr' ? (!$ie ? 0 : 1) : ($a == 'pl' ? ($ie % 10 > 1 && $ie % 10 < 5 && $ie / 10 % 10 != 1 ? 1 : 2) : ($a == 'sl' ? ($ie % 100 == 1 ? 0 : ($ie % 100 == 2 ? 1 : ($ie % 100 == 3 || $ie % 100 == 4 ? 2 : 3))) : ($a == 'lt' ? ($ie % 10 == 1 && $ie % 100 != 11 ? 0 : ($ie % 10 > 1 && $ie / 10 % 10 != 1 ? 1 : 2)) : ($a == 'bs' || $a == 'ru' || $a == 'sr' || $a == 'uk' ? ($ie % 10 == 1 && $ie % 100 != 11 ? 0 : ($ie % 10 > 1 && $ie % 10 < 5 && $ie / 10 % 10 != 1 ? 1 : 2)) : 1)))))));
        $Tg = $Tg[$Ze];
    }$ta = func_get_args();
    array_shift($ta);
    $Cc = str_replace("%d", "%s", $Tg);
    if ($Cc != $Tg) {
        $ta[0] = format_number($ie);
    }return
            vsprintf($Cc, $ta);
}function switch_lang()
{
    global$a,$vd;
    echo"<form action='' method='post'>\n<div id='lang'>",lang(19) . ": " . html_select("lang", $vd, $a, "this.form.submit();")," <input type='submit' value='" . lang(20) . "' class='hidden'>\n","<input type='hidden' name='token' value='" . get_token() . "'>\n";
    echo"</div>\n</form>\n";
}if (isset($_POST["lang"]) && verify_token()) {
    cookie("adminer_lang", $_POST["lang"]);
    $_SESSION["lang"] = $_POST["lang"];
    $_SESSION["translations"] = array();
    redirect(remove_from_uri());
}$a = "en";
if (isset($vd[$_COOKIE["adminer_lang"]])) {
    cookie("adminer_lang", $_COOKIE["adminer_lang"]);
    $a = $_COOKIE["adminer_lang"];
} elseif (isset($vd[$_SESSION["lang"]])) {
    $a = $_SESSION["lang"];
} else {
    $ka = array();
    preg_match_all('~([-a-z]+)(;q=([0-9.]+))?~', str_replace("_", "-", strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"])), $Jd, PREG_SET_ORDER);foreach (
        $Jd as $C
    ) {
        $ka[$C[1]] = (isset($C[3]) ? $C[3] : 1);
    }
    arsort($ka);foreach (
        $ka as $z => $H
    ) {
        if (isset($vd[$z])) {
            $a = $z;
            break;
        }$z = preg_replace('~-.*~', '', $z);
        if (!isset($ka[$z]) && isset($vd[$z])) {
            $a = $z;
            break;
        }
    }
}$Ug = $_SESSION["translations"];
if ($_SESSION["translations_version"] != 1579331192) {
    $Ug = array();
    $_SESSION["translations_version"] = 1579331192;
}function get_translations($ud)
{
    switch ($ud) {
        case "en":
                              $f = "A9D“yÔ@s:ÀGà¡(¸ffƒ‚Š¦ã	ˆÙ:ÄS°Þa2\"1¦..L'ƒI´êm‘#Çs,†KƒšOP#IÌ@%9¥i4Èo2ÏÆó €Ë,9%ÀPÀb2£a¸àr\n2›NCÈ(Þr4™Í1C`(:Ebç9AÈi:‰&ã™”åy·ˆFó½ÐY‚ˆ\r´\n– 8ZÔS=\$Aœ†¤`Ñ=ËÜŒ²‚ž0Ê\nÒãdFé	ŒÞn:ZÎ°)­ãQ¦ÕÈmwÛø€ÝO¼êmfpQËÎ‚‰†qœêaÊÄ¯±#q®–w7SŽX3–óQ°ê/ØÓ—Jý6éÊ™Ìïg2qs‘_fœ˜oµEñ·˜2¶<üBÈ6­kð@£²ÊZš„‚Î¦Œ#Æ¤ŽnE¾cêëÀÐ‚ÂŒƒØ÷>`@\$cB3¡Ð:ƒ€æáxï…Éß»«8ÎÀxá½ãÈ„J\0|6¬éàÜ3,ïób×‡xÂ4Ž8Ê1©¬ÚâÔDcº:C¬À„´âØÎŽA&2Žð,ß.(³N'NððŠãä78cšŒCË:„´E¤BÞ6%ïÐ¨<Ž\r=\$6½-„\n:³ØÆ€Ó«ËŒ3#¬ß94£N)ËÓ\0#£tÀ4µô0‚3ŒèÎÎWÕaAc@æ#¸Ð¿Uð˜2)0»Xá¹Ikl*8\0003Ž–0ƒ[µõT643Ò1¹@¢&\ru8æ>#}2ým4í8C“Ëë{ÁCŠ°Œ4ŠÎ Wõ–ÿ>WÒûsàø É2”€’±YÂ(ñ	/øË‚\\¨½Ÿßb „/¨½d\"'­~Ÿ,êr)s([˜¸3\\´“E\n·%ãýC˜åàË¥¯²z:PÂ×A,¢8Ê7½3BË7¼¬B\rA CxÌ3\rJPûŒñ *\rèÓü7(Úù5BïhÍU@OÃwjI~µÏÎÍGõFì›5‘µ!´1·ÜæËŽ[K 0ïÆ÷¾³¬6Á ûgU%£ê§Ò¤â:Ã.hAGëôT×/ƒM¡8ÅŒT_Æq¬oÇc¼{Á2å!Èª:)+Ò`}áXl³-Ë¯m‚§bãJ2EHî7…ñNÏµ¥	SÁ8Èïl’©ã‡¤š…Ñ\\[ÙÆQ¤mGQä}Þ…Ò‰âæ½k_&IØŸ¬©^X>emð2­ÐÞHLÁþ\rdð¦©äÙÐR<O8×¹”\"„Ûã¤)¬ù— ÈçVY\"\\e“ A s¢=\$„0†eðá[hsq\rÄü¢Deá\nõ=+µéÁÒ«L1,Üýó~Ìˆ‚Ý`¤qŒÒB@PzuýÀ@\n\n\0)\$D‘g \r(RA¸ß«wLfˆi2d\\Ê’šO&\$Íô Ýšé­‡¦Â†Ãç–b~'ÄŒ9¤t.ÞaÂR\n>#àˆúÅo…¥Âs<@—C¤4qÚ<:à@Â˜RÆ\\7À°ÜúU¬‘\$‘*·g!)ÉI+%¤¼ß3ÔÖ£™„&¤4œpÈOŠz&¯ .‡ËZ£zä €’D!.ä†9ÙT·M&Ì¨’CLC½‘'d1‘æ6	òG2®u²ÂrÓ1BxS\n‹ä0¾¤MST—žŒÉ8Ì–9á1u„”ç%K¹Væ4”5eÚsÉ\$l1Nð¦ºåá82dŒ#H¤ÐÉlMOÅ43MòxËñCJ%¤ìÀ³¾q2 çè'„à@B€D!P\"€ªj E	ž)&¥Mða='íAT¨\n‚Aö[kvŸ5‚®ƒ\$Ô8¤7š¢9W\rQG;\0*{¥'lžLGÐ¾’†‚ÂŒ±‹5Lù\0 ³„cª°dÉ…0†ÀÌìôCÇM‡†øb€š8\n\nÊ\n§¥Ëˆtt„0ŸHˆ Ý0aÔ3†‰‹b›6yå\0åˆÚH‘»+¬–’”•Œ¤©“ÄlfŠÇ“¥4Ô\$YÉ¯I~'Zï,S„}¶Ä…9§P­/S¨T4QÙh… ›—Ák¹ª@)Pä…í›¿€«ðò bmJÃ=-¥”*…xÏÐ-Yq…¤ÊžSùÏúk§VŸ*r¬Ò©œ¬ˆ‘¨`ŠcMƒ@>liŽI«º Aa M²ý/d\\š±1	ÇPŠvÙkxÁÎ5C‚\0^0éƒê0â%M›z	}¿žÑS{ÄD‰­ÛÇÐqA~m%?DàA‹ñŽ%0’¦ê`Wsg—ò“†6üJÞÇw;'cì^±&\rÅ8C&âÜ~Ë®ToËUÜL¬Ê-#çÄ¢‚9D²[XAl¥=AõgIáäA\\2†,ò‚‰¼ÌPÁIZÑ•^FCƒ2;%øî&C	¢ƒf;ÃÉC†ŽYË(C˜ç”»ˆæ^Œé01dúº• r#¨IÔ&(öIjêG©Ô,ÇQêã²nËôNs¬«ZêZì¼”Îv¹K›^†Zê«S„uØdãb×Y”Á6*ª%€æ “‹kJ«rß/&VBÏY/=DÔÍÄñ6á6/¤Ô»«”1{ºdú¹-}²fvÞE<)u3Q” m;  ‹œÕº\nKuNa5°lÝM]ö\rn¯¼7VëâTsµoáš³RliÉ`#¯°|SŽìtîôã­-¡JþD~CÉ‘5È&GÂÐÍ ø	åŠñÍmÌ»Ô'ùÂãNo‘³°F¼‰´òðÉÄ#¯J 4°Rî}½ù?Qé}Vñõ~=Þº5ZC´2ãvŠm1R¤ø—MÝë*áÑF>f]LVè²âçmƒd\nˆ]-ùbQ¡í¶£ð)*‘zÌVÒîµÁ™ºSÚ=*êw‡®^EeJjycÁM°€†çÎÞðœý\\tûË÷Ç(±W#¯W^Ÿ°#¯¦LÜ¿gö*ÿØHÅWþúÞì3·¼@>£¬ü\0S}§ Î×A_,Î‚&£³—Šk=Ùä,¡>r[ƒóÌ‰I¥ïžrî+×ý}xÎÜìØþnJö¾)(ýœ÷äû—ÉÉ\"µ„wpÈ4.„Øúmål¶Oncƒ\"°Éð +V²Eîþ¼«ØANœê\r„¼ËÚ÷ÂbÙ0/dâþ­ %˜N&t¼ãË\0ë«ÚlfŠû/¦\n£yOÒâ#ÍïÎäÐ8%anãïì%\0=…–>/æ7àêSÉîÉJ4æ÷+åàÖ\$Î‚ËžÿÄ0®#p×Ð¦æ,ìÓC_	Ãt;\"2.\"Ú	p¨Ã¤þÔPzèÎq\nÃtÔ-én¾æÐÞR\$Ð\r€Vœ Ò`ÖÑD6Ûb0lÈ\r Ìm\"ð(lÒïI,‘\0ª\n€Œ peÃ\\.ãšÊ‰JBÂ®rÆL†ÕŠæëñ6/èê\"fT3J·‰VóCN	±ëVŒ\rÐ,î/0v)Ñj±ªÉ„ .ñ‡AF¾ÍføJ)è´¢@ZƒÖ:(À*,öDbp \"Mëf±Ñ@ÞÎ¾Mõ1ª.q®çêÌÙKií|5ÇÍQ¬íí}qÑÑÔëåä6\$'m£Æ†¸«ck®³ÏoX¿Í«Î4\0˜ªeŒß`ñ ’á`@Â4îX0«B ê%ê«Kl@¢Ø\"vR%—ËVHç¤ldÒVÆ¬fH”N*ÖärP¨Àà,ªº/Àî-t_ð\0cÀ‚)¢ÔÀˆ©fö Z?ÂMI¬*L³(RˆÑÈëòŽÀ";
            break;
        case "ar":
                              $f = "ÙC¶P‚Â²†l*„\r”,&\nÙA¶í„ø(J.™„0Se\\¶\r…ŒbÙ@¶0´,\nQ,l)ÅÀ¦Âµ°¬†Aòéj_1CÐM…«e€¢S™\ng@ŸOgë¨ô’XÙDMë)˜°0Œ†cA¨Øn8Çe*y#au4¡ ´Ir*;rSÁUµdJ	}‰ÎÑ*zªU@¦ŠX;ai1l(nóÕòýÃ[Óy™dÞu'c(€ÜoF“±¤Øe3™Nb¦ êp2NšS¡ Ó³:LZúz¶PØ\\bæ¼uÄ.•[¶Q`u	!Š­Jyµˆ&2¶(gTÍÔSÑšMÆxì5g5¸K®K¦Â¦àØ÷á—0Ê€(ª7\rm8î7(ä9\rã’ž¸±¥Â€B¾+‘\\ÈècîY§*ƒøü›œ+\"	ãêñª)\"¶X£ªØ¢eJT*©Ú¶I£÷§»¦¸¢Pê°ìFêÔt‚\"et~é°&ÁM# Úõ@Á\0È7¶M0Þ:#m¸áËÆ1¶C›Ô3„¤Ý8CæÒŽãKzÏË­LÔ9ŽðHÈäÌ4C(Ì„C@è:˜t…ã½2t¡A#8^2Áxá9Î£È„J`|6Á-+Ô3A#kt4ãpxŒ!òž–&Ám‚?2«XÖn£“j©PúÆÌ<+!×u•‹11Ú‚ÀHé£ö„ª²në\"@P®0ŽCtÆŽ£\$^ #õÓö–«%|\"ƒ«eÍ–º›\$ŠY\\‹ò—ERR<“ðÂ:’Àì0ƒ¨ÊûÂkÝn’B,B²¸Ø©ÂZÝÕªjlkR<ñ‘Jº#XµŽZÆÌjØY<Ø½Ôlò<HÆ–¸iKkÖ/#`chá5èØÆ0Ðº@ §d(@)Š\"bÔ‡©£ŒíYn²…ß1dFêVÊf„ê6>§\r!°™o–1lkÀÈ¦ÈþmEºµØÚ¼y¬×¦dþdy=s¡dy­²‡Z¶>l;Ìs ñZð«BE,†­V±ŽM®‚Š›pWPˆßç*˜A0(ÝÎ©mŸCÏŒ£Ãv7LUHæ§ÃÃðì{ŠÙ•ÇŒÌL•Îv^Á¨q­âè_P†1ÉÉhûì€1¨›ÞûC Ø3Í¸Òã0Ì6J+ñ!kñä&“«%`*\ríEL7!\0ëÖ²üÂ3`\0Ø7ŒïPç<ƒ—ÚC8a=@‚®@“Ãpu7` 9‚“\n†R\n9|%ñ—Ä^cKél¤Ì*\$\0lÕ r}Éˆõ‚›2xn¸4†D¢ž\n}OêA¨U¢TZ…\n@9)%(Ò›£Š¡J‚ }U9ëUj´§¸Rö!ÈJ´'ÉçUÄ3oVD¸AGj‹Óß‚K8¹\$TŽLÂjj7p‰K‡4è(x¥>†@\\žSÜ2P\n	B(e¢ƒºŒQÁ¹å\"¤Ô«©un¶\"©à’C¯\rªP:D°|é`8eMëˆÚÀpÂÕXõÉE^¼\"ê÷%'í! ÔŠ	ïFp4T½ÕH M¡±#K(Ã”!’kˆ0†hÖ–_”n~Œéû¿”›Mé´–¤l0É0@ã¬”\r,×Ÿa’H¯ …P’R_\nÛ+1“}»urjC@peä4‰Ÿ³C\\„ä*ÓòÎ“êLÂ©Ž!ÂY:ja®6•q%·¢lÍúVK²ð7‡zSÛ£“!GR38¹ÆUI)D:„ØTËD¨šfj]0@DoUn)9Få2¸ƒ¹¾a¢†Î ¾šF•Ÿ‡TÖSÉ9\r@€!…0¤¨üå ‹UA¹æ[IÁJp…¶YA7d~OálV(¸þV8¼‡Q0‰&ká{h2V×¥GZqBPÊ)G>G,AFr9JÑG:„žUÅ‡JLÂI&})BÚ\$FÔ¤œ7ÆÍ>‡ÒÀfA¶H4£L c~é®iQ.lkY\r?dú{Îð Â˜T!dE¬ÖgLc»ÃhÌX½×Ò|GÅ©&ÌJ«Ú´~CQ¤^;–éq²†‹Z¡‰Ÿ`”1´|ÂÛõrja@\$;cú6ïÝF¦ZƒOš;Iš…Z™‚0T\n	”7. Ó\$ä³6nÈ#H‚iÇF…TVÖrpBÉöWÅµ‘Š€Âp \n¡@\"¨p~&\\.…ÐÍsŸü¶!‹vƒ'dúEQ–¸²h‘®Ã{«bØ — îPÑv]–ø…“âåÉp‰#¢á:öíPÀ1Hlø/q¹A£-nâª§Hçû%·dØX÷†ÃÖ2´ÊjåÖ…~Õ2}ÐkK*6S¾áóB+Ê][Ñ§fæQ.LÌ¾·áBÞÛÁn¤È›#ÌƒAïBh¹Ïƒ©0Jˆ9ldœëˆ#» g\n\$rù”ÌµQÂÍV”u¯¬<JNtóL[d‡2%„M@ÅÁL4‡¦@d„\n`áL2šú	Cq\"%\0*4Æ¹¶÷5²â5¡”;­\"Ú-µƒ; l\nG\rvZî¢lWkã-¨à\\ŠT@í”tr±¡;ÆÅ\\”»¬\n\\ð;‘.ÇQ”5´’®™žé8îCz¡Bhß–n¯å>3 ùŽ¡E#çÓC”È½Î¾m®Ì¨È1“ùq­kvp›8dÃ‡’`T\n!„€Ae0iJ¯^Ç‡4´—(¹ (ÌˆFÔ(Û}ÖG˜•¡—„-x \"Ëˆ¹žý'§×¾D%'¼X+Nx~š!O¸×Ty’bÖÚ‹0¹RS&^W»å^Ä‡Ö\\zyfJ#âÂÛ²÷ÒŠ¯M:?HsæÕƒ\$Ô\0•ïÛ»OqéÏ¨wißÞ Áƒl—¸v°/ºn ;‘ÄMag9>Ü¾\\•O2\\Ü2­ &<ªKS¤N¢vè[Ì’÷?9âÍhõxœ—2?ƒ»I\"óÞhšvG† yËbúá0æ1ÍºÈ£9Bà€\nCÕëCc<<ä¡‹u‹XŠ¨®=¯}¦V½Œïÿ.ü¨´é±í±…f,ŒDµ	'ë«dM¿\nÅiú¯êépŸ£Å qoä?F¤Œ‡Œîp¦ÎqüÚOLÄh.OþÚdD&Å€]jú:ðÆ­Z2l*£ì„žB˜ì(lL‚ìÀèÅˆWÌœC0ÛÇg+zvp1Ë¤éûê®ÚÃÿEØ+\"VÛpxÜ\"‚\\éÒ\0PÅ„Ž&ÔçŒ/l¶ØO€ÉÌäÍFæÍŒÈËH¢«bBÇ FéÎyHµ\n¦äÊP°–pã§\n†âÏMäkP²üo¼ÔPØqìÅâÌ¤8ž§éé¦°b¶aBOªVŽ°ÒkŠ1º)hìÓì˜ÝìP8íÝ´Á=\0%ŒÛQ&Ý¯ÍâVÏåàl)î'12÷­ žÊD­ÀœÊ´ÜC\nb>/¡P¹Ob/e‚0obï#Žf^È€O«t¯äCÂdÎj?†œÎÔ¬åÎÎd4Ül½pÌÎ¬¨ªåb/©XDqŽV£Çq–Ò,F«, ôñ<ƒL1¥la°\"üÜ^ñ°óm¨m­Ì;\róG!ÅÒ&0qoÝ­žýq\"þò\r,ß*ç!n7!¦ÐY- ürË&q4ýª¼â’5!‡\r!Â‚s0{Ò8:rHÕ‘I2R9E†\"o•\"/šfÏÂiÃ˜ ÐêÂ‚‰Òf2/÷\nEháñÒ7\0rƒc(’A2Ž+2‡\$ÒŒ£ƒ¨ÁPs’vfû\"2C\"c(,%r&Ï‚Û&‘ˆó¯ÎŸÒ¨C/øüÄxß§o(°tÞ‡&ñG\rR'-²ç*ã-Æÿ,/‡pö¬œWJªG­Y\nÈÿ¤DCŽ@²á*ÄK1ƒ1Ò—­©2D>âäk&W(R’À.ÊÉEäãcç+*èV’ÄÏÉß…16Ò¬k&q­mC®†ø*®bEÚl³`ÝMœ\"rt.OÐ:.´DN¹B“6`gú\r€V´@Ò`ÖtLÆ`£x}@Þ€ÒÇÚMÂfËÚ\rªŒK\n„€`ª\n€Œ ptHW;ƒÖþNžÐgoÂ	Fj#¥Ê0âFùìÌF3‹Ø“·; òZN¢_%u*­Î29ÐàX\0EdtL{BÆ¦ù¬ºæ_ìò&`˜\rëÊTúLã‚ñôI>Ø.‚R¤†v¬`-§–!F/ªÈcï3sÉÆÇ0+°ˆÇƒ¨Ö#0”ˆ{ç{HéÛ\0Ðå-h¥Iô†\n‡:6cD4Š‚¥(t\0àˆdžÙ\$Yô©Cqµ8DL+2*XblsqIÔ…DK‚ &ŒZ«Î.e”\0BŸNñèÛ{Ls\"ñQ^bêÇF'¾èà¬KÀê Úrðh ç.^8âlf*¶:Oq´~ÈlŠÒâ|¯F«ÌÆ¹\"æ‚¬„Çl—6¯´\rëþãV7s@qÂª]Kªc¤~x\"a\$…Ô	\0@š	 t\n`¦";
            break;
        case "bg":
                              $f = "ÐP´\r›EÑ@4°!Awh Z(&‚Ô~\n‹†faÌÐNÅ`Ñ‚þDˆ…4ÐÕü\"Ð]4\r;Ae2”­a°µ€¢„œ.aÂèúrpº’@×“ˆ|.W.X4òå«FPµ”Ìâ“Ø\$ªhRàsÉÜÊ}@¨Ð—pÙÐ”æB¢4”sE²Î¢7fŠ&EŠ, Ói•X\nFC1 Ôl7còØMEo)_G×ÒèÎ_<‡GÓ­}†Íœ,kë†ŠqPX”}F³+9¤¬7i†£Zè´šiíQ¡³_a·–—ZŠË*¨n^¹ÉÕS¦Ü9¾ÿ£YŸVÚ¨~³]ÐX\\Ró‰6±õÔ}±jâ}	¬lê4v±ø=ˆè†3	´\0ù@D|ÜÂ¤‰³[€’ª’^]#ðs.Õ3d\0*ÃXÜ7Žãp@2ŽCÞ9.(ÜÔ+z>P¯ˆK»ÃÆ>•BÃÇ\"ŠÁvÇišä¡å‚>H§²ý%(YpÜš\$*¼Z@é*p¥ª¤¸œBbÈ6#tPƒxÊ9„èŽŽ£€áÍãÆ1ÍcœÊ3„Ð0ŽƒÄ0Žc(@;# Ð7Ž³¨@8Pƒ˜ïŒ`@OÃ@ä2ŒÁèD4ƒ à9‡Ax^;ÕpÃ1Ì±@]ŒáxÊ7ô€çIRxD·ÃlWCL£4V6ÐHÞ7xÂ.1Û’˜²Ð“¾²8óS) ë¤KÈ;+\"%ÎIxáÚ–¢Ë³È{ópHíÛKr´ïÉ<í¼Y-Šüb°¨˜+Œ#Ý=£Á(È†µKJ&àØB‚ÔIF4¯!îJxÜ¥òÆ\$¯KˆV „#äƒ¶Š\\I“jš3	ñå5yB¢îÁ‘¦Hh(JröA%‰Vrä–Žœ76ðœt¯Z¶a¡Œþ%öÄhE0ŠFV“fÌ>QF©\"±¡4\$Ò©ƒfà á“è(ª?)Aò¶xÒ/©R>Ø¿7¾ÔhK‘«¢À\\æì\"²íâ›\$š,¤é¸+‹ye¯> \nbˆ˜†¦9+¼ý2z\$›ilŽ´´÷]˜åÈ³<ý¢®J\\¥ÒÜ]:¸²/rµöôFmã/(hö›N‰vÎ'sà¹üvÕâ}­×ÇN›»´É4;®÷-zds¨wiÇz<„~òµ©’?„ÂÝg–B …ÎÙüÿ¿ö#6PËpAÄãwîþScüA”<Efž–8s9„¼Ëœ’nÙ:	+ìE¿ƒêO‰©3=í”ù‘\"îHû~&ç\$ÖW˜\$Ë%K¦pÒ\0 Ø“pdøÀó6PK4!EÅ\r%T®éJÃE]L¤Ó£<JÉÉ#AD˜ª’„¤CNIó\"‡ÙôÓÛŽ:–+ÑI‡¤r~á¢ú8à†šbÆHÊØ./5D%øÎ¢)^ˆåæ%%¨šµâƒ£6§UÔEt¯¢Š@‹§|“FIÅ¤d`ñ™x§±å}1%’ÆTI\"aV3*€ÂˆSbÂ@€:§ ÜŸdLÁÉK8C\"gS\0M)Å<¨¤TÊ ;ª¥Y*ÕxrV*Ì¦—ü2´@úc,YN²VZ-/èG¼“¾¹Ñ½I ì†”´i\"Ñ7ˆeN/#Â(v¡q…ä›“É­!WŠÄˆš¾Àp\\’6dð)u2¦ÔêŸT*RªuRªåR®V\nÉZ@H DÊWˆ5¢ª~„ÐÑ‘6d»ããê8¢=ÇW ŸÒp&mw••š•Î97‚ØÞÁgÂ‚Šª\n gÙmSTw^Q\\/FÜ©Ñ‚¯K€TPÉÚd,uC`l‰CQ(ƒhe`á„3@iFÃªwO!˜:Õ ØÃ:e©ê((¥ýªÈ jnX†éCd\n8G8ÓÔI4m£{ƒ^Ä\rÌÃbðö«=GBšãY‚€H\nÝ&×óŒâé (-À¤¼Éb²Ëa1*(\rc¦`Ç2%=m\rê<9íT(g«J=:&Çê›Czuª(’­@²°Ì'Ôx{ô°«XÛ‰@ŽµkÉÀÐŠlOÁÍH'€AZ«u×\rÁÁF¨õ\"¤Ã“á 4†0Ð gTMC]Æe(e·ÓåŒ¯Â|J\r`„ž't¾¹‚ê#‰¤ýhqEÃII®}P±”dÉvÌnÙ]Éš¦V(‰ÑhŠ)´§G¯Ù†<EË;_SZ”œbnk*8½ÀEoˆõ,`à} \$Qx·Dælë|ž“SjjÏŸŠ‡Y/­¤…¸ •*¶VRQÊ¦\r|F^ž½+Ð2ø(è5² ‚Šæ\nˆ%27Ä‚—£…ÌJX•Ÿˆç)Ø,ÔæªQ‚+*e’zà×ô`òá„ÂFù¸Ócg`\"?;¥ÇXÌfwÏÖGBì˜šÜwÁË©ÎUË“òèZÉ¡ÆÉ!*Y;–ê#™/)t©³Å2¡ƒg44F§nÅž˜pY½[Cßºjéb¦\nv4µˆ¸R&Â^Øîè%ÇŒoRA^Åof»ìÂÉº\\BÔÂ¢¾Ëæz“×ØßJóè0T¶{»øÄlïà‰Öûj½úKÊ¦ó/ù=knÒ¢r¨ƒßDÍ+?2@X.õZ¡'-S½šÒ^BÖÚ*à•³	ÆÛI[išü´ÐîÏáŽ£Š=´,ï7ï\"sô‰(îrMàº†šHÍšês¹ö3òK½ºVéìú9TÊ@uG4‘XÉ6FÉ³ë,›am#Íá½1Îî!X¸Ód]ôrÜG÷!Ù^é|ï6F&ÏvZ\r\\Ô¹Ï·£b+9i”í3³(¢qœpcâ–³vkx!tnþ>ºM—l*+Ìón\$BÛ0).Áw:•ÌJ|‹×[õ’2†Ø†€¦¹QqìHCº^ó§ßÝ'\\ÖÞ‰ž¢û¿g&_êž5Ä3¤‰¬îKV¦bõ¦£×·D„XûÚ.X<ç½NsÍM‘#Øü›­êãÿº8.w\\9ÐlúU²®-(4!*@‚Â@ !Õ”ÖŸTÝ¸Mõ9'K{·r‰(ÈÄÛ'RnZ&a ^0`ãŒ†\0Ä|s >,Š×*„ðŠLjËÁ`RÆ\0ë<ÈŠp+­¦PdÏü¦¬IB[‚r+01CdnÂôÌ£<ã¡p9ƒ†Î‹\nÍï @ŽÇNÃ«\"¢ˆŒ¬‰oöÇlÀ©ðŸÿ¦¢ËçQÐ”°) Ëp¦ËË6ÕD€÷0Ä`ØH&­ì|\"Ð‡D†&&pÈß£P‰iâÕÐ65,®ËÁ|.!</ö±dnd³Ífðm<-\"£Ž?ð*Zí¬ÁÑ\r\r.^í.ÊÒH¨ ªŒ×ì¦¦Œå\"Hð0àÕò×PÂJž#´b¢º?ÎèÒ§àÏŒJ¹BrÙæ¼@Bj&%°B¨†c¥ú+fŽðœˆXBãLæ_‰¬¢É4|äÂæ·®ã¦èN,š®0žeÆjc‚âo/íÊmB®õšã!®Ú|‡%Äh£ÐRŸ|l±\"N:0úäâpò1ä¢œ|'!GÌ),txE²ffjGˆjØ(àzJb¨„~°Ê}¤T\n8\"á 6%¢ò-q®ç#'?#ÎAÑþv’!\$F\"fB½!#7!g¡mè©Ë¨|ã%Û¨†HÆu-Âó1:#îÎ+æ,,ÀP¦0P¦Â\0RÚ¦ÈI‡‘Ž)ñ—†MÃÐ.2œ})­*1Û*mp+•Vw­l²È’ }n+ð^ûd¡Œ³,ÎW+rÕ*QÆ×U2âç\"‡#=\"råÍq/¢¼¦,æ‡Ê?/¤&PV²ƒó¨4,fÁp@I“ÁS93u-…1*b[Ó‘SZ¨a+Pd+#jY£ŒË‰ìŽ5*³T-o5Â)\0ÙSe&èßÓXGÓq“w-d{¹.Ë(1PqiÊÙ\$x´+‚ó<Ô\r”8j~äÜ:ën£@l/øpH²<*d§Ã|¨,Î’zê¡Ùë9¬ï0qŽóè.áÓÒ£xÆ2àŠŽ)8\"Á8o_Ñèñ²l%åöóç‡íŠž/K#ïjuC¶Ý“Üb¤ñÄ,ñê+“xÄ³|ËÑžðíÞu7*Ž	6°ª+©DS'ºßåøE²Ü{ÎS'”.ðÑ\",~£è‘Dr¾8ˆ|ã°òú‰ppß648çT<“t„¸ôˆ’²»tY9,Ë?Í†òÇ~7«@ÎME¯º¦ô±HfîÍ¦](R€:arJ;²±7i6JBÖŠd%ùó<g³AÓ/6tJã²ËNÎm3í_8´÷C²õOåÃNóOR§J2Þõ&çd÷+ôef–|±U\rTª^\núO4¶ûË&”òCú…´oK•Fu;P4ð*æ,¦ù¶z†°Ùod*D”2†®ö/yEUIãµ€öt5Eh=T]Cõ4òµ9<•p÷•Bå' %6fÈiôpŠfî÷ÏÀëOÄÂUwG±ËDÄˆœÃK\$„4•ÎØQá	j^3uÇ[ë‘^Ÿ4ÔcY¨v#áKò\$!GaQU@Üb’ ¤ì„iÏACpŒµZ/õâ8ÆÂ\$?	²ñ11:Ãñ­U–,/„’(E¯ð\nŠÒ	æå\rM.ä~hÊHQŽkkG92TMcVh_vm7n.ur+&:j@††\0Øbú:bc¥ð¥htj¤ +h´á­#_Uå'\r,.\"çåã<¤~¨í4À@\n ¨ÀZüí4¥¡pY1õ÷	\rVlÆÐLÕ0¿CV‚+’ÂÕ–ò±Ë|Ž©2‰ÒsÅ£Ug1êruŸA¦/&^‚RÃ%£jP6•Núä4±2æ`p¼W6?u04€D¤1ßrGPZŽ(FÔÛÀ¦‹˜õkæP|KrƒvÍúw/À±ÇÊb*TATRkeÁÉ¹5jùTñ—S&vþð–ÄtN ê‘¿ M-cÒk*Šr›7·znÝ{ãÇzí FÓh÷¹@wª;òiõÑ6–I}÷©T÷­cã®¤ÕÀîL¨Ê÷Ý|×½>¬yCª[°Gµlë.¯ø|Wò¥fA)²FA îv3÷_;O²ÒÍ»BÁJ×\0óØÜB„n@Z¢œ›¦à†£3\$ë4®ÌÚBHÚ\"×¦ÒlÈ%·þ‘dhFD4	%€8vò—t!/^YÏ[	æ\"‡¦Î4·Ex6\\£Ñ[Feñ!ã/çŽŠ¯¸uÎq[˜¯0‚>xŽ\ràìE\0îµ¨^È5Q0Û0%N5TGÄ¸ô•&u,N8à";
            break;
        case "bn":
                              $f = "àS)\nt]\0_ˆ 	XD)L¨„@Ð4l5€ÁBQpÌÌ 9‚ \n¸ú\0‡€,¡ÈhªSEÀ0èb™a%‡. ÑH¶\0¬‡.bÓÅ2n‡‡DÒe*’D¦M¨ŠÉ,OJÃ°„v§˜©”Ñ…\$:IK“Êg5U4¡Lœ	Nd!u>Ï&¶ËÔöå„Òa\\­@'Jx¬ÉS¤Ñí4ÐP²D§±©êêzê¦.SÉõE<ùOS«éékbÊOÌafêhb\0§Bïðør¦ª)—öªå²QŒÁWð²ëE‹{K§ÔPP~Í9\\§ël*‹_W	ãÞ7ôâÉ¼ê 4NÆQ¸Þ 8'cI°Êg2œÄO9Ôàd0<‡CA§ä:#Üº¸%3–©5Š!n€nJµmk”Åü©,qŸÁî«@á­‹œ(n+LÝ9ˆx£¡ÎkŠIÁÐ2ÁL\0I¡Î#VÜ¦ì#`¬æ¬ž‡B›Ä4Ã:žÐ ª,X‘¶í2À§§Î,(_)ìã7*¬\n£pÖóãp@2ŽCÞ9@Š‚0Á°­²öƒF+ÄzÂË3Òž·22Ù¯ŒKŠW5b¢I m³¬¢*yB¶QËÃ8·Š|NK­2CƒÅ*ªSÎÒ\n^SS‹Ì Œƒl™6 Þø¼£xè>Ã„ß[Œ#ÆøŽr`Î5‹ó\0Œ#›È;/ã½^=Hæ;Íã X–(Ð9£0z\r è8aÐ^Ž÷H\\0Õµ|á7ŒáxÊ7ã…¥jC ^.AðÛ7¼’`Í7¯ÈÒ7Áà^0‡ÓŠP¨…}ÝÃ+r¼\"í£ej}RPFÎ4îS4‘|°Œ0òˆâ/”_Bñî:€NËssŠ%P,>–Ä.Êž¥ Jö4Ü#]INU‚@B¸Â9\rÖBŒˆv/N“àN©«7Ù¦tÀåË£S¯F¼â­ÅTžÞéPå@ÑSø´RSEq”P:û™y®5È\"ÂªíÐ\"[£ê6Vã°Â6£.~ŒOzF0èJŽ,‰èj‹A°íyðOÇ1š0ƒ¸°j\0ÒH¥4£LÅ+ÚýÔº›ŠQ8ªé<Ð]ªa±ï	ÙL¡w®)qä}.kÙ%ôòDtU1ˆ÷R1n²àÃœ÷\$Â7I\"ˆ˜¶R.·ÐrFÙÄþDå»F•)ÓÔ›‹JíÔÆT¨cÎDg!Ù ”P)#0gˆ!Š#ÂˆÃÝŒfOÂ“V)HsAzaSA'vL”¡lRéµª,ñÔKÁb‰eœsžÈÞt†`°¹L'Êznæ¨ÃG¢J{5iâ¼÷£I¬„îBçœ|†Í\\S1‘PàÏóß<…È&ôÖ¢Ñq>Qz.Pð~ƒrÁaÍ8§G’õ 8‚F(Ô%òJSØzz#Y\r4Ê…3Ø”¬Gw\$§Y{¢pJ	ö(sàœ@rGtï´óÈÃ0f\rŠ½8©²\0K2†à(*óÎÁCpyÖ4‡U|°3‡°7†t˜Ö¸tR¨0†pÂ“Àkj¸7Sô\n˜)“¤TÊ	Dó_›;Ç®˜X\"ð\"RNæ0*Ì|˜r•k&‚Y1b×q¬4†E`¶OÜ[Ëq.EÌºRì¼9/æÕ”`Œz }@X2MaL26›w0^²3!Æ€·=„BCˆ›#å½rŒ^Ö¼ŸäØ‡IåUbIJ\$@ÆÕ’~§ökMj¦°ðJÜ€¹l-©ä·×\nã\\«t‡uÖ»CrlËÁy/HÍ#U_¡\$6‡ÜW˜t¡`ú1\n°³š©ô«Á„5°nd¨«45‘¹ˆ\"æ¡û³d%EåÀÆôÌQ ¦”æŒÇd7AäW´\r„˜èb<• 9N°ÕCf¦\nâWÓ9b÷e¤¶MK0þ;H\rXŽUÒâãc¼:qö¼ÃnR¨{!‘%¶Õ\0 „€†ÎÑŠR«©Q›6ÀÀ‚ä\n]\n/QµåeH¡ŽÐà1\r„TÇ@ç-b='¬öžðÊÕUÐr‡Èÿ+Uybxw»éÄÏ%s4ÔR7¹j=P);\0›	òX¡Í{+ù‚šã\rÁÂc-f¾¨w?¡Œ4UàÒ× ±Vxò> ê²“‰[h‚ž\rŠp@Â˜RÆÔÙšÒÝK-ð¦,ðØWºF_`Yxd(à\nl4WR‰ ,(ŠÞ–b0•Œ)3·ôIÅ2ØàX¡Y@±Ñˆ×œ4ÃòID5xµ¨B§;f´,±˜BL…ÕÖÜkÙ€!¹V•ÓHøy;ÊÆvÞb@¼ë	ý>Kp8¸Ðæ­Ã2n\r³š¤+šƒ´YVzò¯càœ]BQ(\r!ý7° Â˜T!ÏéÏ•R›¦á	KHO¥	‘ƒRl+Â iÚ1|ÍŠQgbŠ¦=VÛdä\n!‘-ÂÙ¾f†þU³\\JòRÑ¾9WUƒzìX˜K‚\0¦ù\0f» €ö,PŒ-Ëãj¡¦ª«¹ƒ 4wG8g£‰Ýx€lb™+LDœ¦6d2€â)6G5[!P¶ïˆüJú…;)ážHØõ#·ëídxÂ¶Ržd`Ü6zm¼§á£‰[£›­,)+	DŽ’›I0®ÒˆÉªÉ³x¥\r×@^IÀòé…aâÃŠÀ²£ÁßÅí7çP©h]t<‰‡–ö¾)Û\rÍ³h¤%FFühäETxÅc]8Ùùó#.Šdc‹µK3èZw¢Bè‹‡\"<)Ž·ˆŠ‰¤,Šªœš×@NÕû²ˆb)“íq~gP¹¨Äµâå··9Ö¿;‡¼2ï·ìyrËÙ>]á9ÄÞ[»&a2)íçe*º÷ké×{Æl³uOÝœàS\r!éÇ]J«1œpS§ºëÝ÷:”rÖ>éîî—SO&ý£U=”;²x\"b	·õÛ±â r/Êæ‹`ïW–<o³ÝÝûÿD—HiB@Äq‚SZ€4d¾Œf”8Ü7s!Ðú`éÊãNæ”=ÄïiÖeú(Tô#¬Ôn¤u.8ì((®CŠ¢ÇŠ¤¢0@á*)éœlã0J-üúnNêG„ôn–QÆ()O`ûe:3ÌN(…§~RNzOî<w\$ôìî\"H ¨\n€‚`úM€ÒV‰,ÎÀæW%v½kj}nøˆä~óîtÝŒ\\éŽ€#fªàA\nƒªàá~kFª@°´ç8}\"c	FæÖ¯ò8Lb€I®óÜËO§çî\nŽhˆÅ)°ê‰¶€O1	h8üPÒþpÖ}pÚ(ðß0t'ƒ¯§Ø µ\nnŽüfZd*S\0ç|Å#¤Öè¤×*º)Íž|ðý=Ãª,äOÎBîÏÇ±\n›,µœ|ÇÐnðÇ\0S	¾é\$‚zóÎšûñb(‘gGo±eÐ	¸Y @MÀî\$'*º0 ¤KàôRR1®S«ÞÞ‚ô,,„€f(ýÏØ®Ð<olØÔQµljæï®TG”(âžQ‘iäb±‡OJmÔ.OëÞc\"ðàLFšzÆ…Q-Ä­±ì-Ê(E¢Ù!L£\$¢2lr-†‚5NÏ!Ð4Ø-ttò3€äÄïÇpÅP@¢j½ña£³&0íëæ7(Ü0ÂéF„ø.\"Jó,²ê®‚úfŒQÒxêU\n-ê6é¡(wñ#\nLk)Rv€¦–èñ€~d†9Ñ0‘R«(ÑpfÌ(€ä#5(‘Ý*Ñ÷+‚õ²×‘·î¯ã,Ñ%)ÒˆnvƒH/’Ë*ñá.¯¤Çãná‹flÊN(„p\\€ñ„T	 # „ÜÄ#Q†ÐDò\"¹¬ˆòcŠ2jü¢…¾„ê#140U6ØòSmguðLi/¬H¼ï/0Ô¯2¨£’ç1/¸îg‹'5gñ&bØÅ PyÎÑÁLâd¾(¢áÈ–ï§ú„‚¿-¯?-æÉ8Ñi0ºë¾èÎPÒºhs¤-³8óÐìsÔÃgý	°k3é<Ñ•“ð†ñ‰<&Ò÷?ï9>ÒÐcae#û(=/³ã!Ñ:stwë‘iÐï@púCJ€ô&½ó‹AsÎ¤2ÄƒuH=sD+á¨›D´a@,jÅk^Ý2Ù/óÆJ²‹Bô %	,sý@ó…“‰,”M,ã¶þ´žhcZƒ³	4.TcK%>†¢ˆíÏ7(ÿ?(lËÝ*fÈà+X&±Šêô	.'øUAT!Î^€Æƒ¤ÄRêCNíj0´Üf„/!GIGNB¸Î;xû«YMBKbîÜæØ‡‚dÔ\rîPbãî\\‘õ!O¢k*ªöÞ	!”‡S¹Ï£5ÏBÞìHdo§Aè\n„óP~N@€èm¥<ßó£ˆãmâ…Ž=8/äü²ãEôÅHNƒXÉCHî˜øRá>´Ç@U e3ù0´Ã/ÒèùÆ)[R}?¨ÿÒU3QÃI‹<ABÔL…U]c]T¥Y2o[´™^BÝ^:š¾GµÊA­YÕÎµðUY{A-„ìUûa1•¹a¢Ÿ#‡¢i†¾8­O%a~íI\$'Z-Ð+c\"ñcq!!j; uêÔµZc”!EpGZR„ô¯‡^®Æ¤{fJç\r§YR«Y•½9/QæC`0m_Uã@U.nÊÝaOÉ_6)DD*&(ßkä¤’ñ_¥\$¯öhèL§G®Ö#±eµ\\v'kÎÄô”ò†È#O&Ó\0ˆá\0R\0JÙZ“ËH4O^Qxôi4òkgö¥hU÷@W#mv‘J7ilkqhq®p¶¸eòqr–ñu·l–Üþ`æG_òT”DsÏ'(2ÝIVq`Å;u=kvsV•g.‚Pe4÷`cW`¶ÿ@G£ÔUhÕ~Ëï4Õê”pgS¦·QñlèaGD¹EÛa7oYÑmz–¨5nØ0W±Côw{pG{¶#{÷‚Æªêõ5~*.¼ÇFÎtgQä»BWØN°ztïR´hðí'¦—z´GGì{oÔ°@†—@Øm\r Æ\rhºMEŠqG?iN\ràÈ\r Ì•Eš. ŒÚ`ÚÂånÂi€\n ¨ÀZ¾x>I¢ë€74;{7Ò†NL×ÛB·K|8FÃ¯|ôuG’-‡¯N	JõÙqS€ëÞ)NºÌŽ¿,dOì¸®¤(Q\0›ƒØ@7D€duïv¯Ì‡Q‹3F‡WhðH!1¢ã†#jõvÕÞb2(Œ”ÃjüL7ga°¦	’j¥þ[…Œ@\0ÅØXHRÍÐÌf~Wé‹\n2-ÁoŒ¤@üm>r!QY02rçbŒ8´V;S\rŠ™”•j„®FäÙeWÎq×v	V’î€Ã‰Rm…rx¦ß”uf—[føƒŠ)¸‹Cä<#ÆÂ@Ê^hº\nUÏ’N2íŠ•&C±ÿ\\0Á7y²…¯>uÂurp-Á=2T%2³½mn ðS°9’T)MídTÎµŽó­ž)f òµÖñ®ƒ£®@¬W ê Úæ±·4urS§Y”²6(’'{¤+5¶\$¶s¢ù:#`)ùN/R\$ú¦%=5	=h_²{O«g®g'[–Gu–’p&¹z@ÞÜ€î=CõtYoR.æ‘vÌ‘DEd€@	\0t	 š@¦\n`";
            break;
        case "bs":
                              $f = "D0ˆ\r†‘Ìèe‚šLçS‘¸Ò?	EÃ34S6MÆ¨AÂt7ÁÍpˆtp@u9œ¦Ãx¸N0šŽÆV\"d7žŽÆódpÝ™ÀØˆÓLüAH¡a)Ì….€RL¦¸	ºp7Áæ£L¸X\nFC1 Ôl7AG‘„ôn7‚ç(UÂlŒ§¡ÐÂb•˜eÄ“Ñ´Ó>4‚Š¦Ó)Òy½ˆFYÁÛ\n,›Î¢A†f ¸-†“±¤Øe3™NwÓ|œáH„\r]øÅ§—Ì43®XÕÝ£w³ÏA!“D‰–6eào7ÜY>9Ž‚àqÃ\$ÑÐÝiMÆpVÅtb¨q\$«Ù¤Ö\n%Üö‡LITÜk¸ÍÂ)Èä¹·/˜Ê6¢ïêf9>æ‡(c[Z4±€P˜œ¨ª¢ò· *Â0ÂÂ‚è53Ã*-£RŒÑÄ° ŒŒ2¬9(ã{TÐ\$((ê8+è#ÆÕj(Ï(èúþ0Žh@î4¶LÔwÉ˜î¹Œ`@ #C&3¡Ð:ƒ€æáxï3…ÃZ¢¿¡ræ3…îp^8J2˜ä2áš\r«š¢ŒË˜Ú#xÜã|ÁKûú‚CHúFCÏpÂb—ÎÈè9£Xè†±]0†\r1+D7Œí8ÉQÕ%LÛ%uœ7²È*ü;BÂ¸Â†ÈCš\"2b:!-a\rKõ‹cØu¤E\rƒ¨ÚŸÄcHá±ƒrý#ª@´kkÒ¿7â Ê3#¨Ù²Ö‹ ÂQË #¯¸ÆÃ¼änž£Hå(ÉÓcÏM3Z3Œ—ð¡?„Šb¹NˆðÔ:¦®€Ž¶¡ÃD\"´Âì¾ªnDV5Þñ.5²hv0“AÃhàÓ±ÍÓ¢âˆ˜e¨Ò<¹‰Ýä”ÉHƒQ®•5„=3tŠýhunŠâ=0B#PU. Pê@QŠP@hŽ«ðÜ,\"')Þh*§cÓÊ')xÂ¶9+îgPèðÎÃ#lb4Ñ¬ä\"6‹ûN)¡æþ'íºÂðü(Ê< ãtƒCip©Ž‹Ëÿr£ö“¨;Cð &@KÊì†®\"8Ê7±”Û]pC2Í×h@Þ3È¬—	øLCím7)?\$:ÇÒ\0Íu UBŠ9ÊÔß‹*+ŠýØÁ]o¡@æ¥ÂªR2½*6Ã²â£:ûµt`”HAY?²°ÇÊ\r.ìa,3’Üº—Ó\ncL©œ;¦”Ö‹ÓprN	Èœóè¡“È>ªñ¨…K‚²—\$\$¤@	2\rde+\"ƒ’AÈ+`.ì—ÔAÑ‚tiI*Àð)”É],¿ä¼˜dLÉ¡5?@å`XnN.@ç98”žƒ˜>	,¸Ó­éó„5n´46XöâGd¨9<3œ!is#îÙ>²j“ƒaG¤5™µ\n`ðerÁ „#Ø~ÒXl\r‹«Ÿ×Üc\0aÐÁ<˜fòä,ïY%›\"û(a1€€1™3º¶ƒIwr¦@¾†Äˆ‚rø#Çî/!¨æ/ˆÐi\r\0€(€ Œe9 _Äƒ#r4K‚†*ÁŒú8¾hÍ)§5+‡CVm¢OA¼;Ã¢^L²˜;Äu²“Èôˆãá“8¦®'D~õäº\rÁÁo\$ë\rC¹³rÌÃt¿!'Lœ])\$—é°¥ÅñÞ )… ŒÎ;CÅdí™D™\n•¡­áÔ—!æºÔOÙ&Pa­ ¨0ØC–›F-°žœéd©×ä;	¤ñrfMV‹”a\$Š‡“4QßÌÑ…!¹`) dÃˆu5Hì3ðÚü 9ý'ì1’Ä“%æ‚t54TÉ”ÜA€O\naQS¶*U¡A ¯®B†”‡)Tô¼›,’è%Qp Ô 7bCê…*ÔàÉ©ãIL‰s³ŸGí}†ôÔ‘*C\nlØWgiHF\n’ÝV\\\\ÑÚL±µ‡\$nX\r „lL¡ÍƒËhv#f‘~\0ž\0U\n …@ŠA£ lµÃ2f¦	 ¤Zð@(L¶ÚÜ[£Üë)¸W˜£IBŠÓ:Vë§BÚëKh\ncŒyjðàÉNƒdbD†ØÞ¥bø.†€€†tý|²¾ˆÅ³Â5bgñ´n©¯!ŠºÞ¸B-Í‚\\‡36ß=Ò›ëÁ¿Põ‚[š›UhØc´´DáÀs­°7£üD¿ï‰>'µü‹—å>¯œ*ºÈ€E¥NŸI©›–²ÞS)\"Sò•E'd„@ßJmÅ·Ï‘L‘{SjÌ±ÏDlÌð7Ã¡0YsÜmeýŒÌzP\n…ÐÂP0ôe¥¡Þø*“)”Ì<´ñ´&ˆÕƒS×;´qw¶ÄÍ1¿iª¹‡Þ£ˆA˜Á´lPFÜPÖþN	‰ÐÙä7èò<PÑ%(ÄÍFžRRmš‚#à()-äÙx•A»aÅrøåîKÕ¦ŠAD8÷ÛP¨BHG£7kN°r8³Y‹¾ABU	9®IŠ…ì‚ð@¯Ì‘”Y{Dm9<³ŒT8Gd˜”C‚8ùPy:Žm`7%g³'¡}Îì`\0«¶·I'Óû|Pšøè(ÆæXz;MÖFŒîÞsyìmí¸·Ë„ßfQgo¡./EñœÓÂ	÷¾ã¸\$p—=”of¸&ÞàÛ‡|nMÛÇ¶ÖýÞ\\‹p^¹8(I˜ü„mÕñËxÍ%­¯’˜—Ha‘ÙÿêøŒZÔŠT°O*ÑµŠóBIŽ×F)„©™sugP;#ýSd8\\EšC(bëõ0¶QIº?\\T!j}«u ]-ÝÐæN:*UFyÄIôw=Œ¤ÂAó>HÌ„ò†|ÌI„¿4ƒ%âÓ=²!zÂ8ˆŸÚÍ9w‹'ÝY[õÓWÔ¥},ÏÌaéå=qô¦|ÿ+œñhŠ~–ë®¬¦ˆ+z´¶´‹ó”k{¡•Èú^#þ\"Ñaa‘|V¢±«~jï“hkè€ ­ð¾'‰Î”pìàÿXOŒC–ZÙé¬òx´Š0(ŒuL“û‰Î†\nŽõŸÈ'ÿ%éøÀßÓÌÀÊBœYÏ^þFì—/@ƒCœÁ/önì<Þ&øóP¢¢rÖ+à'N\0Þ%8˜ ÂßM¨áÍþ\rÍÚap,(ÂM\"íøFÄyâº0DÊ/1ÂV¢Láæžâ,ZÑ&p'­ÏîºKA(pAic«H¯dô.Lç‚æ¯b^âz¯e ýO¤J3f\n>‰Æ\$†>„è~Í(Ð²Zb†¼ŽÈû†0 \"Þð¦ /q\rhÔ“ È•åÃ¢FåÉ9é¾\nkBÑP|Ó\r\nðìô†´k…oo¾¤ÍP½pÒ\rÅBalÜX#	%0€òi~Í¥U	ð	\"`Àhã-P`f8#’l‘XÕpŽõ¢|*\rS¬ó\0ê0%Íiìò'fañNµ\"	MTaæ´¦–>J\"ã,ÑàíöcÅNä£Ž­HÔÐHþÑ`2íKQjü#±ÉŽaÍþÏ'–^ÃT1~ÏD?ä~ýe8Ô(Ë‘Þd‘ãCTÌIå@¾@#êAÒïñ	 žÒÃƒ£òÒðC†+!j‘öTÒ?#¬t\$#Q’7ãâôíiò%ÒZ6’_qm#`AÒ\\=ÑI 	\rŒjÂáìÕ\nH1+ÍcJÚFm¸Ññ,\r§)®¾ÁÂO*¼æ)™ÃTó:(¥¼çf8eìðE:FãBXÃ`£~{#W1…+Elñâ*ÒäcôÚrÞÑð=#¬º˜6\r€V„rxÓo°+\$vã#Â\\ÃMbPGc\0\0ª\n€Œ pqîùƒÆã®Nj·ê\r¬2ŽT7¬™3N2²½4Ÿ°¶U6¬Fø^\$nLâT/'Ë\\øb²10õ£&b 8ŽÐå1£6V‚®3+£ðån“H@\rãÒÃ¤8D@«:„B@‘	\"Ö¡ŠâdÀ†um¢iÖÔ`¨ÊTÀEÄÏ\\›óÚÎ2îi#&\r­èb§vö*ÏÑ;K>“Ý*ÏLÂG-@³šè0Àõ\0T	>Ã¨+21*,`1¬iPþ3pïóÂ÷kÆý°\nÁÄý†>(¬öÄâ0\ràÄl#BÿI¤Dƒ Æ¥¤¸´Bø­'ìÍ,ªÂ8^F\r<nßBÓò_ŽÙ0ö¢Âæ‘;D;Ib98ãZt13œ@î.‚Ô„G,Þ\n±°MN¶Í2P:æUå¬";
            break;
        case "ca":
                              $f = "E9j˜€æe3NCðP”\\33AD“iÀÞs9šLFÃ(€Âd5MÇC	È@e6Æ“¡àÊr‰†´Òdš`gƒI¶hp—›L§9¡’Q*–K¤Ì5LŒ œÈS,¦W-—ˆ\rÆù<òe4ž&\"ÀPÀb2£a¸àr\n1e€£yÈÒg4›Œ&ÀQ:¸h4ˆ\rC„à ’M†¡’Xa‰› ç+âûÀàÄ\\>RñÊLK&ó®ÂvŽÖÄ±ØÓ3ÐñÃ©ÂptŽ0Y\$lË1\"Pò ƒ„ådøé\$ŒÄš`o9>UÃ^yÅ==äÎ\n)ínÔ+OoŸŠ§M|°õ*›u³¹ºNr9]f%3MÒ)¥ípÈº²ãh@2ã¨æ:¤£H!éä0 ãpòÈP¢:§§\n0æÈ#Òš1h2†Œ˜e›Á1KV Œ#s´:BÈ›FI4Ù+c¢Ú¢Ã”|0ŒcX7èô0·°Ð@;¥ƒCI!µp æ;®£ X‰ ÐÊÁèD4ƒ à9‡Ax^;Ír?%árê3…îÐ^8JÒÀä2á¢\r«ª:¼ŒËª|öB!à^0‡ÏÚP2È£L\"¢£ê&¢ã¤&\r:‡M£è…2Ã•°´âh× 5(ßSÄ1\"hÄ±l»KG¨Np®’Îô>Œ\0Ä<·\0MaX”´ 6£jô\nƒHáAïDg²#)\\Èc¨èô o`ÆçŒ£0ÂÅGÃ²ö:Œ±Z9HÒ`PŒ‘DPŒ> Œìô‰ÅB^ÂI ã\rˆ8ì7¥#`Ø7Üb|öí2ôŒ7(Îp˜a•©´h&B+ÅG`¨ÉKp<F‚\r#ÞLVD0·È3\n7XpÈÊ˜¢&.ƒ(CÕuaTÄ£R°ýL4Õ%<9àc+Ò!²‰¢D“é—cÒ€i©ôŽè:7¢BƒZ×¡ê&Š®© \"Õ¨º’ôÄ\\õ®„ƒër\\<çˆ@S<þÓT°ˆþåˆâ ‚®©:õ–ª!ÆŒ¹#´ŒÞÉˆ‡JÆPúü6ç\\˜è°K« &\rœ,!/6ÀŽ2ÚÔÔF\r”ÐÑ´©*:7ŒÃ7K8\nÇÆU *\rêâ}	\"Äã3N\rëÃ%-ÓCÊ<3Œ+ËŒûXñÅ¼2…˜SÞŽ}øÝ'‘w~üR	\"b*0o’B¤ÐS¼FÓ€å-üÈÊŒI’é‚L	‰2&dÐš“`wMÈÜ¼§æCp/@eéDAD šL;Ê)Ff‰ˆÂü4Åt8”&¡ungE^¢\"JQ“É/DÄ&¡CpI“ÁOKÈÂS(r\\KÐ\r1¦TÎšSZmMð4˜@ôìäMÁ’RPY?‘@àGäÎš†St«Í™5!­A£â€ž:3rÅì4Ö¨{IŒäèTU:‚›É„.Uh‚:‘ ªO5ä¤1ØÎý\nÁ!š£÷˜Fs	z/i(£ˆ0a(Fn£4FÁcY‡ŠM~sfL!†o\$p‚Ê8¤½\0P	A¶æŠAQ(þ‘ezoœ³À}¯Ýoš¶Æl*ÁmÄþ• ÞØPoó%ËIÐÝ˜+ÛÄ\rÒ¡çß™¤Í&Í<\$g·%ÔnZq™<¥”ž`h&¥Ý2,#s&*\n7ë@7ÆCìÂ˜RÓjnx‚ñ”+qF¸’’r¬¡ŒR\r?`œÍ%fK(tÎsŒÐ\nxŠy…\"¡Î „™®¶Ö»‡&!\$ˆ‡“I/\n=DÌRKÌÓ(ÓH	*?(üÄÉÐ}ƒoêf§ƒc’6A@'…0¨A‘Iö'Ä`š/”cI\0R™+°°©Ê“-Êáy[M:”¢Sei]Måó²„Ñ.*&Š—²÷“ÃyIAˆ»³VnR5*KDb°Iën8Èø3S´LA0Aæ.<?Db¥ù/I}²€ž\0U\n …@ŠÌm\0D¡0\"Úd*Ì#Y«=Íµ²Rž‘(N™°äö	Ã1ÔÉ#PÌB©):çdç)‡j’ÝŠ—¥äÑ¡SÂk	é•He¼4D=AÝ1‡‚Š#jxèÄ¬XHh§5ù¼»”…Äºy½,¦£¯Ý½ÊYÒ8‹!ÊF#\\dáT±\0\$ˆÐ+ôP,Ü8:‹’h1)Å<ä¢’.)òÊZªùßjL3g a,=V¬k¾2BÍYÊâŠ‚£uRÇð=.ÜY:×j\0]æà2ÅvO,5†ò|4ãU‚kƒ(wÀ·ùh7S 0Äkr-W´…cCˆ+ÊFX#!hq­ºLüÈŽljé\"0–P•:%žÉbê@aÉ{æs”Ôäj#è\"†æF§Eñ¢Ë¶ÒMÌ†]ÐˆÐ)-è‡Â)¨\$h|\"6àÜžJ[”*†#jì.ÆÉÛLä|‚Ãƒnš¬ü8“´ª±’]Ac‚ð@CV4•ck–Ë®ÐúÖNÄš9 ·ˆý±}	n%µ®œ	5Ê­\$:à°^Ä+»’ŒG²É&Í*øÏ¸\n s t¤ˆ>UY›OÊÎÆ{\"É,wû¬öÞóÛ»*´nÕ¯uŽÙ7´—o©nú÷ìšM¯‚ì‚dOhÁùëÜ\"IŠAXDÈŸ‡PÕ²[ÉW)R´€6¶Q+Nr¼yöŒ™41I+.5Øþ^I¦˜bá›sb•neÆÂ\n£Sz½Mö„ýO±/?<mLhVÉÑMËß¥¡ðà².ÆBëž;´N`a©HÙ£@§yo?GÊu\\p¾ÏEU=Ø‹¶EŽÝÚ™/Áx[¶’:çyÖ¨½­Yäê&f·FV0¾ºQaŒV—ŽÚ”ôKäÀR[üo0¼é ÚÝÇTK´\"“TH`F6VáqE2\nr³a\$¾·ØùV¸Oýš!”¾tº¡þßy¼NÔêyh£% ´£ÂøŽEj¬ÅœMCI°:†@R|ãÇìkX7t7~÷_¿3hÆ†#âÔ-…ë¿W×ðöŠÇÝ/Ïßýž?inŸ»}*Vëj#ìÉÍñ€äÑÂôÙÍÈp\n8ÚebÚ üE´ÿía\0#Ù\0mÆ\r 2Ïý¯ûkÒÍeÎÍ¤&†oúø0Ö\nƒë-Pò0LÍR¼`˜6G~ùÇ2@àN.¢îÕãC…>u,^4Ãì)ã&¶ÈÄ7\nº=…¦d¶D°f¶kþäð\"³¬ 3DSê//Šä½Oó…Ê%ã´…Ë¾~0lr'\0„Ç-ÌÜxlœo\$=\n,^mfªiÌVü„ÌËÍ&ç	¯Ÿp0þ\0@U‡Üÿ¯íMaKÇfâñ‘š¦â¿ÉÅ¯¸í\$Ú°üþÑ,îã4ýîÖSÑ.†þï‘.Aëîj`Ë¬X;MÌ£\nhMØ¸-°@*Õë2Šè¼\$±	\0QíHñpÏéÑ‡\n1DÌ`yÉ®”¦Ži*25†™+²9Í/™1®jq¤HÃ[	0¼óh)k± NÏ,ä?Q2ñNé.RÏk%QßQå1ÜÂÑìÎqMìñ1ø\n†œLæ×±'Œ,AD.Ïé1ß!J\$ÿ±ŒŽí5!€	(ÌzÑ°¢@-)úÇ.ÐI…HGÅ¢˜¤¼£í\$ÈOqºDâ/\r%âXîˆ™âöF®„ë‘òP‡Žì\$m¬÷ê¥(&ï­Ô&/T ¦¦e4\r€V¨\$BIF¦]O<ô@Zar˜l‚jAD|©Î\n ¨ÀZwãIè±&ÒÄMž×ç(²\\8ÆÐHRå\0­€¥fÐ„&Z åÞ¾BLòìœÌf «C¸„?†Ô=cÚƒÞïŒü1m£èÎþ±Ü\$ÀÂ§Ò/qØcŠôP&h6çF¯2Ú;à 1ež'ØBiøÝN§ÍfÝO²é'Ê0ÑZícdV‚†ñð‚(h®ÐNî“‚ÆP4¼Ç~„³”7“™8ŽÓ³–1S†É£| £5	ìÕàÞØ&ÌŒ}ó˜8Ñ\"+í‚_å(»í^½S„Ê6&F:ú†@kŠ¾of8úf>•`Nùc, ñgJ!EÚæ)XÀ¤ˆ¥š¸SÆîdj/GK2ƒ Á¢ìi3«p2\0003‘Z\\‰É3“*ÈVv%6ûÐÜl‰8ô>n³:è² î.Ãq\"çD.Äjã[„Rdh	\0@š	 t\n`¦";
            break;
        case "cs":
                              $f = "O8Œ'c!Ô~\n‹†faÌN2œ\ræC2i6á¦Q¸Âh90Ô'Hi¼êb7œ…À¢i„ði6È†æ´A;Í†Y¢„@v2›\r&³yÎHs“JGQª8%9¥e:L¦:e2ËèÇZt¬@\nFC1 Ôl7APèÉ4TÚØªùÍ¾j\nb¯dWeH€èa1M†³Ì¬«šN€¢´eŠ¾Å^/Jà‚-{ÂJâpßlPÌDÜÒle2bçcèu:F¯ø×\rŽÈbÊ»ŒP€Ã77šàLDn¯[?j1F¤»7ã÷»ó¶òI61T7r©¬Ù{‘FÁE3i„õ­¼Ç“^0òbbâ©îp@c4{Ì53Í†T¯Ê9(“žé5ƒ¢‚	(æŒB#ZÀ-£((\"ÃHÐï”#›z9ÂÂ¤0»ëèáÃi´ž.âÈ6#t«¢C\"\$¥©É».V«c€@5„£f¶!\0Ä2A\0Ñ\rƒXú@2ŒÁèD4ƒ à9‡Ax^;ÌpÃÆ0\\”ŒáxÆ9…ã€Â9ŽcºR2á É¨ÆŽF#2RòŒi¨xŒ!òV+2Û! P´7¾4>:)c[^¥Âãxô6´ƒsz‰CmE3MÓ­ëfÁ\rcªÕ¼(“p5Ñ¢°Â9U…L„’0Â5€HK\\ŒUØè<×Ö„¹¼hÈê8£*Q P–7©àé P‚Ø#BHÜ1ŽC-ª71b±†^¿Òk%\"cpÞ¿½ÔS#£p×=ÛC=Â3¹µPÈ@PÖ2ª\"„;@H´ÆÈÄëFMBb`ÈˆûßÁCÀéd7¼,(KÓ\\Ïq*üÀUËÆ(‰‘Ñ2šÖÐwŒ£´vÅ°N‹sQÓ+{FR&yR¨ïÃþò½Ã¢sè£FFŠz4\0ßè¨€\$-[‰#lnÅˆ£Æ¿¤éh»]”6 VªPP°ˆ!Cµ9½ÐÃX1ðP@¨*éC€œ›Ò³\rÛnö9ï¨Ò •˜¤ÀÊ:4ƒÕðb‰¬FÂMxÚß\$ß>ƒÛ•QŠD9Vâ8ËjqãÓp00”£3Ã0Ì¡FIXž2E0ë#eåj„ímÜ4#H•R9®a“C‘[M'^^ôØ„£V¦<ûÝs\rÍƒlø	¯†ŸxÃày~ož‹÷¾’kêzÈç±íÞã_ø±‹`a_\";|ïã¼“‚^`¯yÌ¹\r=B‹kô\\?‡ô÷ŸëáŽéÞ@è MÕ b4ˆlc€eÌ¢©%lTV˜G²oÈu:K\\›\"çÀ€ÃªOJ))p¥T®–RÚ]Ké…1ÃrTšRl¼@Ó¨>Dä\\9‡H¯*ƒP¤tê.rrŠšCÑ0Ÿ¨–CÒjOŠp4Š™Ò7\n)5spX•…šqFII4ÑWÖ’Ü¼e (­&‚ä ”¡êVK	i.%äÀÓdFQ9&”ÖÜ<Œa¹:§vº	Úã5ñb-çŠãÈ™L*	<À’oÈÁ?Â„ÆáÃtpg¡¸¸<XºÚ½\$„à\"ÁRJØê{HÁÕ‚G€ÁñÀ]ESHv‹ƒ›oÆšhÞíQ4¨Â!¸Úq”­œ“PŠ Òã™•VèíR-|‰l8ÿ™a|^åêIF¨ÜãN#ð€H\n\0‚yÏQ[=æð(*\0¦:¡’\$•¬ÞH4‡b0C=\\óh”±±^æÑ”Þ˜„íw¢#åìÛI§jt.¹Ø®Ã,u„(•Í†ÒæcÈäÁ‰> Ò9	9›))&ÅªÛH.”¶qã‚O\0C\naH#HgvNÑ;oIø9Ó¶Êî\$¬!ØË˜*´8•`ò’ó8L×]+E‚ôàW9†N‰¬†MÈí7¢gS‡Ž°\\†§h_–´1éŒ°ThQRiB{ ‚&R“Ëú@5ï`£5•ìþ™°™qôåÀ Òñ\nƒ<!@'…0¨P‚\\h­½(Çöl\$ny½w”Âˆƒ0iáÔáˆÙ¼jW\n–£²¹Å˜Â‚×8 \nl°’’r­O…}@oDx*þC|é*P³~LùÆ\$­Ã\"		XC\r!éuâk\\ËY)5dõ<«bîð*¤4¦’Ö‘ryoæ¤=\nÂdIƒ‚ø	ØT›«7DëUS,\\Æ ÄÊ°BB·díá7€ƒ—©&\$—”ª¬^ñ‰°H\$édUõ\"|q ¤ùµ¶ØV„Úl¨5ºW;JZÙ…=ØþÜ\$6Øs”CJ:-›*¡L®èôÚV‰î¡ui.Ëã/ì + 7TÓ‡®\"„Ðº‹h‚ë*6¢©ºS[¸oÎ9ì'†*ÔïðCÀªÜ*6ƒ	uŠD(ÇŒ‰Bj_ÌXOt5Ï4»¼ž§ŒY-AN¹_ºE_;Še€,ý£Vó¡MK³zŒu“*A‘Z ß2ŽÖÆ/œs›	µþ§gºàÎÐ(C8©J\\­ ‘¬;õð‰³¹Ñè\nÉþófkÒj.d®7á™z±ãž	‘E‰ÈE	¶L¶oa‘A%·.ó×g T!\${IŽ6Ñ9@ÿß“ò°NDK/áéU?À^Wßä(`­b™f_\nV'ãá5¬‡ËO4p„Bm\rœ‚%Æ•JOÄõ¿5¸1„]mÐà³Uë|&åü˜¤l˜öeÚºŠçœfÉùõ‡å|·¡e³1z1é\nuN¸®˜[s	sž~Å6a¿Òr¸äˆÓ·ùÙ¹E„=—uhRøûz;f2»©t	]Õy‡xW=Á˜¼ÞûË:×€è†Ûs'‘S¤Ø’0\$œi‚ò?i—YH»Ê`'yrE¢üÉUd0*”×“W1ijŽ#—Ùª¢©æó”Ñá””xç7ë!Æ”‚hÑ(äßšÔú>ü?(õ\"”ù&pÇà÷² J1)uç¸â}œnŒE\$ŒÚ©•^où™¿xC¶¿¼Î•‡Y7íÜ×êPõF0P'_ 0·ÏÂOÍÁ<üÚ4Ú~ŸîÉÅ(Ê:ÿm^ýN¶ÁcK\0úü\nÜ:€òËJ üÌ6ÉHLTãeI¨7‹\nÁ…Ì]ÙØ¸…†jàÈÓãz*\nE4ƒH(Jþ‚wàxFUfÚ„Â'`ØU@]¥ÞeMb+)\\æi\\æ®”%e GÍp+/\\YE˜`@\ràÄe`,)èÊÇÿðK\0&¶üÇ2ËÐ·ªà\rEÆþL–I¨ËT#ÐÓPÖ7ð\"VnÇ\0=@Üâ\n P<ç\0ü®d­ÐæÇøé§DçpöOpûÙ\0VÄœë0Šé#Jég²ìDéìÆÝüþñ C‚=nµ¥Üæñ4¼ò¿kú;í–®²yÐº F·p@ÙC‰1MÑZ¿ñ`æpÚl¢yíx\rê0ñÇ8\"3.Yi”¬Àæ]bb¢ŽAIÂ»\$„UŠøX`àIâ<d‡ÍIÉ¬2H± ˜Î:ä¨F*2–8Û£Ì¤LˆBi}#N+CbA1xÙ1\\Ù€xEjdð<f¤i\0´ØløÅQÈY­XÕQuÀÜ±f0…;\"’!å\rÑ†ÞÆ˜8\rZ\n­à–å\0Ò/\0PìÝíâQA\"OÍ\$’Z\$ï#±…†gÂH™’g\$¹'’LÒfìÒÃ:=¥¦FEœ	b*ÍáÅ2ÇkŽÓ…Ö<åÒA-Í‹™Ã%0¾§Pù+0ÿ&½+?’lËoõí†\rØ^ÃšØFˆŽÈUL²l£{-¥îË.É‡°úUP&ÃãBüZ\$DÚÄg¹#-›1\0å\".¸4°ÙÍ¯2Î¢Õ.-ªÙä'ÅM2“:r‡?&R‚7D5¢ƒ\"Ñg%R&@íõ5\nßw5Ê;6-/rÑ5¦ì\r	Î5ŒÓq<Q¯äp\"nË°mƒÐ­ªÞ²¢ª°íñ:nw9I]9ˆ˜Ó‘0°ìÈ€”#S¬4só Üè%`–#*Ô=ød Ö\\CŸ9£#9Gœ:ª;Î¾mŒÃ:nŽ5fÊ1Q?7?Nµ?“êë³þç.Ä×å(\r€V;Â†aëÆ†âˆIå,@iú?öoNj1B¦ôQï	„9°h–ôl\n ¨ÀZ\nÙ‹à¤±ÛñS@I]F ånÙtt#TqGElëÑ3@TŸ\$j\"¢.ëD@FèlïúURhƒBþ? YbûE¤#ê/Ãþ{†]Å†8\rò\r(±N}KCƒo,¼¢FÅjË´Þk,\n<@¦RŽØVAãPVà†(+²O!{OÎ6ÕÏûnŽnC@-Ì£	\rQ@Øï‰îÇ4ÊOøe1({\"ˆjVS#Ssõ!Q5Hœ<¢„ýõCTõ5BF\0eEþÕEÐ*ÑÂD?\0a5BG‚‚(rN`,ÚÒ2Oå\nÂt—±¦ú\"ð1Y`òú¢Œ2\"UoÜ¾E´#Õ'UÆê¸å(þr¬kÚ^&³QÇR¬r:â4ÉzÈ¦?]…Ü6Sµ?[ˆ¦\"4žBñD1‹pª§<!ÏåC£\\Q ";
            break;
        case "da":
                              $f = "E9‡QÌÒk5™NCðP”\\33AAD³©¸ÜeAá\"©ÀØo0™#cI°\\\n&˜MpciÔÚ :IM’¤ŽJs:0×#‘”ØsŒB„S™\nNF’™MÂ,¬Ó8…P£FY8€0Œ†cA¨Øn8‚Ž†óh(Þr4™Í&ã	°I7éS	Š|l…IÊFS%¦o7l51Ór¥œ°‹È(‰6˜n7ˆôé13š/”)‰°@a:0˜ì\n•º]—ƒtœŽe²ëåæó8€Íg:`ð¢	íöåh¸‚¶B\r¤gºÐ›°•ÀÛ)Þ0Å3Ëh\n!Ž¦pQTÜk7Îô¸WXå')žjRœ(íìöáVÃ±º&o‘YÌ˜íÔÂ BcŠµ¿b‚È¢ãsB­O°‚2\r«Z„2\rã(æ<-æŽŽ\rÃ>1Œp²¸³èú1?èÀî4Žƒ@Þ:´#@8?ã˜îý\0y\r	èÌ„CC.8aÐ^ŽòH\\Â(»Î³Œáz”Æƒœlýáˆ\r«:0µ¶ã“\"˜ãpxŒ!òN+0ƒcj2? P¬§ ££´5Žƒ¨äd3HŒÃHÊ;Ï“ðÈÒŽ‹ª|	ÃËBØ\"àP®0ŽCrÖ3ŽhhÈTpÊ„´Ý:šÓ\"XÞ¢Ã(*#…US\r®|J/â`7„€ÆžÖL0ˆ2ŒÃê64#²Ú:ÕSaM7B2+<\r3+ 0Ö*U‚:RÎ¦;ƒ@ì³Žk#4ŸºmÂÿ`‰U	ƒL\"Ã\nŠjp64c:D	È6Röm‡MÑ-PZ9Œl)Š\"`Z5¬D)>«³ìÙP³üM€Å8­ŒhK\"	î¨Ë\rcÃùŒ(ëa“\nE¼-Kø’6Ã£’k=ˆ©^jÃd,³SEÎET\"S’žÇ)ëªð¡Âë:˜¶ZZˆâ :˜Ê<&£r\r2ŽoDì¥.Tb\\çÏb#A\\8©‹÷vªØ„µ°“Û^²dk@bObÌ^Ï´£xÌ3_ˆºO6£«ö*\rõÄ<£šÐëDC5†A‹XçÎÜ`Â3Œ+[Œ¡Órl`2…˜SÁ¸£\n\"÷µcË:\$â ÐÉ%m¶œ:Äm¬&¡QÈÇ®\r)„í HC¤‰#IT™	Iã”£)Â‹dÈ7K!÷ªÐRó<ÒôDVŒ¦ <5è\\.ÍZpÞ7_”ÃC#,BN”í¸[ð2¿YÈGÙ:} ¹#Ä|òEHé\$;¤´ ôrPJOa«µ–¶öÐsÌÌ”ÍÞð>ià€ç–2DíšªL&|Ð†rtiI¡UÉˆÉA÷À•ŸCˆyŽ–×ÜÜXâô¯øÎ»4‡Þ¸ Ef­Nˆf˜Nz›uLÞ9¬äŒó•)h­“ŽÖ¡Wfm’Ú×L9spÊ‘õT\\AŸ\"0œŠ¼\"pNŒ¹›@\$\0[Þ	>(@RÿÌì.ÅÄŸâNÓ)dÅ4fËŠIrSlí§D2gÍYâ/„œ*†pòºKó”@fâãÔ¶MüF*\$e£ æŸE©|7`ŒÑª7Jl;†€ÒÃD\$-)\n&ÅèÄ°Š¤”Ò 3š†ÂF¥Œ„”·ÖkÖÉ‚)Jn(§îJ‰a.3êÌÏb|¶	õ#¼÷‡&:o_óë[¸¥?pÓ	8I\"!å½—Õ7'Ê¬E©Ðž‡‘?Ã1Ö%îíèLâ–Èù@‹ÉÑ)ÎíB€O\naQ‹£\"…=T÷3nÀ²ˆHm^«ª9RR˜jÊûŽäìžÆâ–Zcú\rÄ3§§¸´iŽ ¬ÉÂ<H!9s'\r9„0¢Hg”\n2ÁP(Cj»™Ü³¦”F[â£RB2¼Š'(\\s(—6!Kô'„à@B€D!P\"²\nì(Lµðûª„<O°PR‘…›ŸCì)šÉ-§rÈ\ncjgPÁË&«46(é[g,ñ?a53»4Íõ%EE“ŸêPHQ§½\r\"jì’mMèŒ³×üÐmrªe¡½‡5øs²”ŒÖÉ=…5žTËSž°\\4ÇÝ£Ü}á’6H\"0Q	´.OÎV.Ûuoà@‹ÐS)•âJÍÊæ8p*(ªqsCHzURAš:4ådÕñÖ ÐW2Û~Kå×PmßST`	+/éõ‹ Eä_ÂY%^á4aŠRÝ…Ú«\$¡˜£mZ‹ål­Ê¨*€Îoñf#Ä¤Ãð¡¢	Ae¬5€¢ö†Ö! Y¥1ãä`ôÁ£²Ö²DhCÚÆÕì*†®hY¾Šëd(á”5ê€˜P°p…åÊ7) @Ê²¡7†,„ª6b…1ŒOa,¶©·\r‰	Ù¡	á-ç,ðcžP!È„»\0ŸL\0ÐØh=ó¡BÍB—EèÚ#\n[V+é\nA¤¡yTÍÕ3Hçø_ ‚X.ÎÀƒVgàÉ¤õ'	p½\0®äXo™)xŽ‘òB³I-NØÊl¡\\l:ÿ«!GU”9OU\$Cƒž ¶«´Â'Í±%`åŒ8OÉÉ™rsBá¬Š›mÐ¾\nyc-ô*¢ËK‹ö¦§\0(\"†Ò.£È\rÆdvÜ“ïÝþÿÃxph%FÜp`ÊÕ¸§@ŽÆûÇÿÀ£Í¸ÁÅÜ¹Ó™Æø×ã¤„™nªïµŽIwyn5ô¥.ãq/¥ü\"`&˜C,S6Eä÷ U(L^¹ç=ñ>T²¦‚OeÃÈ3QÇ“ý¸é‹È:*Õ^©ä‰°¸’ R£,E­µ|N‹hAm³#\$í™¡·f@q\$C96†Äv»yBxFOäý²àžB’Œ¶ºÏ¹JvM] t¾sÏ\$oMéÞÔB–G|eÃ³o¡ÈIñ¡§Fv¥›Š&*âÛ7´ÛŠÒs±JÜô}ÿø?ê=ªìœ—ùì2ºC+ë8´Ë0Ë\r³ucÅž,qjúKÕUr9xDà‡hð³µÓp“†ÇõïÃr98·\0‚–Cx°\n‰=Böb™åå¼JŽÒö‰UaÌ<ÀTXSd¬hžâ Ù 17¾ë80;¿î äÖPOúàÐö«pNeÿÎHïO<Q¥‹\0L’ãë¼ïÐ\nã\"N	•gþð=\$§ÎòäÏ<ÄJ\r2Í«|40Mä\0¹Î~`àØFðÚÀ¬Á(°ÖíRÈšXÄöò/Ž0äð|BP)‹qo'pD·H\$ežzïè‰Ã¬D\"þ°R6Ðž|LœgÃª¸‚øOET/dòfÎ¬Ulj¬î.ô§câ{¯ZóÌZ-,aiÐ¢Æä/ð®NÐòO`¨x0\"]lÚ>0ç®OÑÂOÚ•°—ãþ3C\r	TàÒÉ/é2éPÌ1b`\$¤Pl,å«ŠŽKŒFÖqHDB„uQOÀ–UÜ,e-À‚Ñ^ÍÅ ‰Íó<ÖqvóQzó«pdì\r€V\reø\rm¨FùÁLé(P…ƒE\rãL­’)oÊ‡ñ¢Kêî\n€Œ	¶ Î;ãðRâNÐÍ2êÀ¾OO(B¤f‘Ü·ø§íÜ#à§í	¬|'ÊŽIÀ7­ò;¤ûã|!@Zp1˜…mO‘®U1¸é->€+Ú„ŠÄN.˜½Œ˜\ni®‚9€'Â0üE†¹æFåT2Žž¶.ÌÇTaŠää2Z>k`ì«fÚ;Î6¾ò_'NÎa€àéRlã…+'0ƒE)'þ¶NÎá\"b2+ŽáŽ)&îH6¥Pe2[jÚ¦ÊªÞ	 Þå®øë…ìåÖ%rÐ^êÒ¨€ÇÂB:r\0ìCc¸d2¦Àì˜\"Ø³¬˜\n‹JÇ¢öF‚zOqo&ƒÒ{ã<_Bæ¸Æ´TÒŠ/êP@î-7ã#Æ\n:ÔžQ>?pš&¬";
            break;
        case "de":
                              $f = "S4›Œ‚”@s4˜ÍSü%ÌÐpQ ß\n6L†Sp€ìoŽ‘'C)¤@f2š\r†s)Î0a–…À¢i„ði6˜M‚ddêb’\$RCIœäÃ[0ÓðcIÌè œÈS:–y7§a”ót\$Ðt™ˆCˆÈf4†ãÈ(Øe†‰ç*,t\n%ÉMÐb¡„Äe6[æ@¢”Âr¿šd†àQfa¯&7‹Ôªn9°Ô‡CÑ–g/ÑÁ¯* )aRA`€êm+G;æ=DYÐë:¦ÖŽQÌùÂK\n†c\n|j÷']ä²C‚ÿ‡ÄâÁ\\¾<,å:ô\rÙ¨U;IzÈd£¾g#‡7%ÿ_,äaäa#‡\\ç„Î\n£pÖ7\rãº:†Cxäª\$hàÄ0ÀH òó\r®Ú;.,(Üþ3£(#˜æ;ÁC ËÁð&\rã:Ä1Jƒ½®ó Œƒj†6#zZ@Šxæ:Ž„füij7íÛb‘¯Ñ\n;±C@ÞþIÃ„cC#Z-†3¡¾:˜t…ã¼Ü#QÒ÷ÁC8^ŽòÔE.xD¨‡Ãl¦\rÃ4œŽƒJ@ã}1mØë³ISê:C«z:º°ƒ:¢½b²´;„ÒäKêþÛÔ¥%NïBpÊ:ÇŒ¸æ‘@P®Ã«²`æ‡ bò’!-ƒa¥¯bt’U#Èà¼\rãhÚŽŒ8 ¿ƒxZ\$ÀN¦øB´êÑºC’ž”)Ë{&Ë„úb\$\0PŒð·´R÷Œê0Ê3¤w³ê:¹eV­J*å.ÞàRüóTõ}\rÍÌ™TŒ£Àè6TÉe¯zÞ7›Z£ÞƒŒpƒ¶(‰h—h§(ß…b)-×1<7E#][W¹NBs£u€§ŸL(cÌÛ±‘D 5¥ÈZr5-XÊ	#ls8OXŠ<jôJõÕLG£\$šFlÅç18„]ÏXˆ¦¯Ù¢AIàÝ¸ Ûžë¹â¬Zi˜´î£0èíC\r-¤¤m{žðlTV¦»BÍCÂ8ËhŒ´Â´·SÚ´ƒ (Þ3Ãdv™ˆ#¦6#l`´ÝÊÖÆ9PÉXØ7¶Y\rÁh­£`X\\rÜ:8A8.¾Ž´ú¨ bjþ Ð\"ž )ÈØ=š=Û Ègr3÷}ï~€ø^#‘ãù*˜7ùÎ¡ÑúHíŒzÐÝ\"öƒCÜ\rÏyÖ:ã\0ñ<w¼•œ2¼ƒe5¡‘GFŽ’<&(p§š\"þL`LA•2&gšSZmMéÅ§@äˆØ/„~’üŽâ§#©PÀ†¶XG\nŒQÎˆþ«è(­èb%„ø”ãZÁ^T\n/ia:÷bƒ›üD'P¢öŒÜ¡»‰F\0000‡XšñáhLi•3Â„Ø›ƒºpG0´'XdS»#ü7'å\0ÕCo[íyûD }ˆ1²o1d&¹Ô¬FÍkŽGç92Õ¨»MÑ9`\$Í\0BœdX’M='T(€ BšJ^Ñd6©8²oKµ+d½0¨BÍØcQ\$€è†–>_Á”PÒT20ÂŽ¡`	%`êNÝÛÀ—¡Ò\0ÍB­Ö˜ g\rØ¨’tàL¢;9#Cñ¤ %8:¢·8KÙ±G‡†OC\"gŒ¥”ó’sIÒGAAQ ‚0‘ðäh¡Ñ3d€½Ë¢“C o˜%ÑÚ®©‹0Q,Y)©\0007”ùÚf,œI†D6(’X€á•m¨U\rW¼¶;Å2W£Cð¡¸ !Á,'¤d—Nˆh+Àr¾uˆ4Ö›Q”ÚP ¦‚0 \n¼Ó\nF/))E~( È @”<Ï0ðQHœ•gGƒM!5Tª:2rMÞô\n'Å\0ƒRôâ‰ÛA«ô¬êÆ\"_Ã“M.*?ƒAH!f+‘Çï\"MuP§Þ“•ÓV¼ì… €–EOMNd„¨­£Hh\$S½•3œ™…\0žÂ -]‰,››8‚JSÇ50 =5›l]G(å\$¥·Jô†!}Ã´Ç~DO\";cW1P£Dv½2µ\nQTå03îŒ5”€Ü½à(Á¾ÓFQl™¤ÁG*BEÉQ4‡„ÁK¾¼\r„©W\"‚5dKo‰˜F[Á‘¦±xˆŒÐ04À¹à@B€D!P\"àÒ„B`EÂ‹*’ØàÂ´ÕŽ‘(ýu§'‘[ja<8K¶	¹=&L'ˆý^5{sÑ­æÂZR?Ô’“)ÒÍ wSŽÅ»#’X>GB50;©S”YÃKM+…gQª<Ë„Ã†–ðr–©¾WïÀ¯k¤®•D1@‚}ÙøtçBLºK]&X¬çMØlMYì ©³€B~\n#8¹T›l¯pŠE¦A¬¹Ÿo–º“%™TR¥˜qõf1„ÔêfgTgH²ë…QèÕV[Ú¡\r9ƒX›,ÀÐ@U°/0ÿ\0 ´í€PÃŒñy`<\ndpA;¨LF3&¢ù.;@¢’Ã«²ñ–ÎmÑ”†)a\rf6†PÄWUý`’¤¨%uÂg#2ÝÓ,§ü‡rÛeÊøL*†\0q‰ÌÝœ:8’#]¤+È”–úûuàS¼î´3YF¦þÁybjÙ\\,R­ŒÑœj|S‹) æKLj†·³ung*B˜tñœòB`Aªg(2<«–qþ]ÈLï1A. âO\0@ÊÖ’†kÂƒô®‹Ä™O6¤ïš/ª‡Îa';\\Ïýõ\0[Ô<§w“s¡yÊb“å/Û,“7ÐKû3®0¢_Ö»¦\$ÿyö`¡3CH_¬é\nYnt™®+ò…Ë­> ê•RLTr‰&©¬õ˜RL¸j<B‹˜Àœ§+Ú–S¬Å†‘W(‚ƒÎ)Í4õ„XuÌFxî‘í\\—xŒHi¹CŽs”—}Â¦h>ó—+†çïÈÜìÁŸ(6Yò.¡;ÿ7G%?og/Â+rÛêûo¾[PÆ³f½|í`whrÎÉ1®Æ_×)A]]}¶ä.‘Äª'[ã\\B¯ö1EüóÌDžIH0ïø^Åt+f¦[lGâXûN¶Ö¦* ¨YÌ8( P	ŒT,BÄ‚gO É¬~ø†ÐËPF5è>BâÈÌ²B0FlÃÆrûÏ“%\\ønÒâ¨Ì=`¤ÝÉÅn°ínVzŽúoÏj/îdè‚d0~?‚úð†ëPŠå¦üè\r	N†ŒíŠÏÌ#\r6‚w/¥°º\r°¾%PÂ0lø0rûpÏ\r,Ù0ÚüÊ\0¢Vƒ§\r~0\0æKO:¨Ö#¢>6Ðp‚BfàèYÉh #ZGéZDCž™,™íJÊzpb¢®rü¾‹€ ÄÆyë{‘R Û±>+'žÀ-M|vÆBlF¦hfœ-‚Øf‚9Q4 Í°Ù£Ô1…D¥IppUì¡ñ’úå©¯\nTpëPïq‘Ì®Þ\"ŠÝ«¬¡€ÏÑ”û0ßqÅ‘ °-õ(j7C*7Ì®\neª\\Ãà#`	IŠjlt€*ô[\0æíhÛ¯1žÝï¬ûñ¢Éâg!p¢ûñ—MÛ\n	ã1Ùeä^Œ\\×`ËÀÞÕAR:@R?Ã×\$RH:²T1.ÿ6‹ ¤2 Æ\reøþWí¨ÚC«ŒœúilÚ-­²+{(²4Ë›(„y\$Ò’G’^×Ã¦§’PÜä)­ìC„y(¥+nE'ï¯(ð&CR¹,R#q®\"¤B!`É\"òÜŠæ=`®\r&‚S(šXèËä”ûœ\räŠ,=/rFIOq/ó&`–wfiÖ³¬>DÊRóƒ´`‚kL'p´ænŠe0\r€W1jÖ“`0£°öIä‹+ \$‰Àmã,½1&‹ ª\n€Œ p4 Þ‘K¢6‚&p¬ö|úâpîï·0n@íòÉ“†ïP' €î¯ªOº%Tð+â2m„ØƒRÑpO`;/*?nD·ì˜Ü\$\"73J0Ïbœë¨²3U'bf‘¨ÕãH#'bEkäBÉÎ-Ç:E˜sI°:‚XÜò´üÌ’öâ:‰bàº PSÂd¢H/¸ÕãH¹šÇ@ÈwAp„ú”)Co€@ñÀ\0PïBM]DÉ“\0Q\$u)ªªÂÅ~\ngŠ§4=‡ýM@x¦2âŒÒ\"—€ñHkˆjl\$¤x0¨!NÛÈ`ê5âäÅ¢pÓ\nR'D&Ó¼22ò5\$´.	”4”S ÝB\0ËÅ¸7e_5ðNB4,!FT&NÍÌ=fWCÍ\rëëjg\"M2vO@BY@b84•\nBö  ";
            break;
        case "el":
                              $f = "ÎJ³•ìô=ÎZˆ &rÍœ¿g¡Yè{=;	EÃ30€æ\ng\$YËH‹9zÎX³—Åˆ‚UƒJèfz2'g¢akx´¹c7CÂ!‘(º@¤‡Ë¥jØk9s˜¯åËVz8ŠUYzÖMI—Ó!ÕåÄU> P•ñT-N'”®DS™\nŒÎ¤T¦H}½k½-(KØTJ¬¬´×—4j0Àb2£a¸às ]`æ ª¬Þt„šÎ0ÐùžsOj¶ùC;3TA]Òººòúa‡OÐrÉŸ»”¬ç4Õv—OÙáx­B¶-wJ`åÜëôÆ#§kµ°4L¾[_–Ö\"µh‡“²®åõ­-2_É¡Uk]Ã´±»¤u*»´ª\"MÙn?O3úÿ¢)Ú\\Ì®(R\nB«î¢„\\¥\n›hg6Ê£p™7kZ~A@ÙµðLµ«”&…¸.WBÊÙ®«ê\"@IµŠ¢¤1H˜@&tg:0¤ZŠ'ä1œâ™ÑÁvg‘Êƒ€ÎíCÑB¨Ü5Ãxî7(ä9\rã’îQ™äj ƒ–îòA\"µ¬Ëâ•·é‹ÑÑšO9Â¦sLŠJéŒ†M8l(]43Á\$%ÎŠ¼ÁOŠazá—©ÐF«ì©,Äâ¸“Â‰Yn—RôÊa,# Ú4Ó@2\rã(æK£¢<:Ž„Ë[#ÇYu`Î5xÂ:#Â9Œ¡\0î4Žƒ@Þ:×\0áeŽc¼Ê2\0ybÊ3¡Ð:ƒ€æáxïw…Ã\rUVLAtÊ3…ã(ÜÚã³m…áè\r³-›VÓ(Ûc#xÜã|Ù5p¡vg)…óÔìQèzÂð\$Pø–Xö/;äî£äoÜDµ§‘;:Šd™4–‹e™¦\\ófSVúÎ)B@Nãê¼‡8RBg%B¸Â9\rÖ>Œ\0Ä<Žƒ(ªjÚÅeKNÆv/!”“N]<M¬g‹Â…üBö+‰Z6-DF—æ2C‘¦\n¶,¡!ÊZ¿Q¦5˜€b»=¤ÜVøA0ÚÖØ\$Qq¾7órBðÅ¶o6'lâ¬”Ò|£µ­´)IÆuBgÛ¾€¢E‰lŠm©9%»H‚Îÿ»<öˆ·°‹P±»%ŽCÅ=¢xå7lBøf[ò¾V5Ô§‹ÒæÑ€¦(‰‰±=»<„™@ÝäK ì™kÉ—ÈPQEÈ‹¾Ë}ùçã™ ªüÜŠ‹8H‰—¶×\"SPò/®ò\09Ñßú}~‚Pè”UÄqÞ&/(€s€CQs‡ &Ù×\0Ójt-–3XJPa J1Ž2–>¤Îê•£²ÅÏ‹Œ¤9¬Ø³K  L©„7Dh¬â\\I¡á¬†å‚Ãƒ™wE©'´Bî¹+>\"¼	rºß_'Ü§¤¢’i© ¤Ê\$BJJT3ÙˆÜ˜ÒVŽBA°:\"@\$¤	D±Ì„å{MQSM³žˆ_|’TÊm½8‡FWÌSŠ…0Ü˜;÷HßJ¹ \"EøÔœ¢¶Îˆ)‡nò„Ø@©&Ç\$°‚[°ØÌ¸c#¼\$zè:FÄ—V‰ÀŒÀ&OÒO([/xR”ŸJ*h Y5R¼ŠËœö,´’)¦MË™v¤Ô¾Mr5Lé¿1LÆbó ƒŠÃòË|›nçù1¸þŒeJ	((x£@ÐRÚ³a!ÈU‚–©Uj´9-ÐÇHdUË|.Æ¹W:é]kµw‡uâ¼è¢öKá}õaC£\r_`ˆRöDƒ.â^!	žHä\n})“E­ÓVOÒDlIâ:žÏ©Âjc¡.˜Dž{(§i×/J5F|K”!Ý* ›¼¸ä\\Ë¡u.ÅÜ¼•^«Ý|¯¸§b½3`pvgÂÃÊÇ¢Ž”äô„Rš)e>*@¹«2š‘‰qp°ÇÄÂ§ÆL*‰*Sï‡—vDEqV1VE£BøÚ`Í¹M¯çÅ\nJ5%aì:	“)ØÔ!Clá'Í?\$Žá(j\nj½¦,9gØ²Í	Š…†ÐÊÕCfk409‡U|°0u¹°7†uYqVˆ Z+6\"Üà@×\rÔÄ0†È²H\"Ù)%q¬Ù•b™#Ðä¾\$¾5“ôeaŠyÊ4dBFÈÀ-›¨–² ¯_‰~ŠË8P	@‚è\nIrš>Qpû\"¨òJK)Î7n[”`†Ã•hc¦4Bñõ¬ƒHv¸Á”3Üõ¬®ÕœDV½^\\t½sØ¡ID¥‹Í3¾œ/ô:È\$ƒ¼×“oÓVk9­u~.ýãË¸8-E¬¶Ðrj¡Ü4Æ«ëžäÞ+yÃ\r¥Ý%(‚\$ÍC´FE|¹0¦‚44MÐ†\$ú¢ ˆQ4vçz©Nêª3…)«9ÄQ’›«`àˆrur¶Tó@VLë­µº’Ë“L.c§rßá@^ÚDJ®vØ)‹{ÜÝ•SP+B¶.Üça?n¸¨ÍR›4cè&¶LQ%éEOy¡³&fyÇ&7°“µ†·	‹–³~Yñbì\\Va’…:20 \n<)…HhîæÓÔ=PoU[R`Ú¢ê}eZÎ² ‘P:¤C¤²_Æ§ƒÖºu<ûÊÍP–J3£¶–Dá J&íNË^wãùM{ºÍ’†øL±ˆœ‚\0Œ0¤lEVKb¢·¢Sxé×¿Û/šá÷{gX®6S¶¤p\rÒv¶ª\"°Q{ŽÃuðse H’â‘„é.\$N9Ç\$p%ú‘\"êXgSÈ&\\Ú8.mØöòtgA”P	=1æåªA­)g‰)×ÔYë‰ˆ4ç'‹?7gÙÚTm÷•ç†!]Õ˜h-¼¸I¹W÷¤¨|dçÈñØ`k<©óe§)¢ƒhJ!Èf§P)Ç)Ë.–š~.	—q?iý®æHÐ€Š„”›`¸½bY‹±–7íS|…NÑÉA \\ýc‰‘‡~<¡¢›¥Š|R½ûÏæJØÉ…ê[_Á·C1¯»)'`êÆò² \"h÷üÈžá,(]>†¨ÿ`oòt,ïð×)Ü9Ç¨oLNéë†\rÇ–h>Ž§v,B„±HÒ#Ìðm2!axQ/ø‡\0”ˆ8Éx&D”IJqKV;+\\poDf¼{¦÷†JÜGÕð>èQÂ¿ê~ãÇ¨Æk`ÃE'´ydÚ„í4\"‚wÆsÇàò°^ñ~ñcj/nŒh¯E’;têø&DÔ7h|ïÀ30¨<ÍBdÇt³g«áœT©(Tâ_	„z}â¨pìnO\"ã–IŽÖv‚hêGŽcÇYíÎîÐ°|ã¢”hÎèO¤þfì\n@‚\n€¨ †	\0@ êL@ÒVEˆ\\LvVËªW%vÈÀINFî)/D4J®yF¸à@#&ª9b®÷¦·®9æ0€BòBÂøJ-îâ…Gå5â\\öá4—h|ÀÂ„ü±¢˜±„Eoz™bð,kO”´±œø©Öø	Ù‘¬5q°+Ñ´€‚.qº9‹@’èñÃ\n5g¤bˆÃo*1ž'£À‘Ã¬˜éÖ\"	&~ÑÄ&ñÈ”bZk‘› ñÐÀ£ÿaœQÀ)¿qnÞ’\$Á²)²-aŽ†¿ø“„†Õï¬€ËyEž~·¯¶ÞÌÑBnõäè©X0ˆÁäÄTÉ/µ\"ëZ–b%Ïòr4.24äO\nÒ~R‰î¿ð¸h\$øÓG?Bù'â’˜Îv=Ò¶óòºè%œ Äx²U!«'È¸ï°@NCVF\r¤™Ñö0ã¢¡Áœh’:³OV\$âÖsË(ƒkO.ê*Mé/é¿00Ú|á3!-ì¬Ænîòs3€Kê(D2…,\"¸IèrŒ¢ÜiPI.\r,ðB÷Ñä!\nw5pC5ÆQ(éGfïAk6°:i0DIiŒ9ƒv=‚,¬J\$>…ÐjŸ§~çÓ…6S|öÓœs“ Ú'ñÃÏ7£ÿ:Æ;e:1ËhX?Ó•;çlîï<#ì†&ðiNIÊÓ©Ž)©¦–§\n,&p„ÈçP0Çæ{.'¯@h2¨91í’)V‚-pÏÅ\$ëNÃB×CTÓðœ<Ë;Ï‚~ÆÌ}óÈ/ç²M†ÀÉ©DÂ¢^Ÿ‚Ì3Ö|“ìÏs6¦isªŒ¨iFò >Ø›ñÓ=NÊ%Ôn0Q\$…d7=g7óT~ož‚“µCë\0w“Ò5òRü2à“ªxe£Ø…òÐ’*à_¢­ô…\$±¹&‚Ÿé™K¦uKðL-¹\$”È!Ì~.#1Ôt‘éMƒ›4P­q/M¨Bc°ït5´r÷ô‰Ppªèµµõ>î•)®øgt«I”w1hè’wµ-U0U;’ùƒ‰DSi9’ü‘ƒüžiÆÙ	ÃˆEØ¤×	B’fqŠ´KNâ„%õoH*ÛÃ³2@MCÈ¨É¸´\$&´ƒÂ4qú•Œ<‹‹ðyíx¶5eEµz&Ð—WU†B«eHRÂ-’TN3T’\n†­ÑíÀƒ¨ITpROuL”5QsÄCåH™1ü€FÓAh8\$MÇQÐfe£w\nu»VgâOºòð[RñCËVDTCJõ_Hµ€f¶)Q¤HU!KUc¶&yÍUhEõ]IÈP€´•£ÃbPby‘Œ,‘)\"M&tp5©R6q³¬´§bôAJÔ›!‚õg1g”‘fYe–5eÐyhÆ=@ëai–†€\$ñ6¡ehZçUgbm\rÒ…\rB(¶èâ?ÖÕ#3&œ/Æ&-Êà+CãQ'›*‚y+hyÃ—d´â&4çg¯{GT‰NW²SgóS¶[6´½pUßiï—l=R'Ý;–°ñn’€1(!Ä=×3@Ð€ñn|¬kót6»<¶ctúMõ§@þ—WeW?l7N‚×S<p6ÉT<*ß/1Y¦ÎuôãäLÙ3¥g×\rd•@:pÔH3ÛbÕ8µ–‘Sõy¤O·)Yw-qð›jÐ~ô+P'ðÂƒVÍk×+vè×(÷Í+5¨ù6¶OšOÄ­2	ywdv71.ÖÕ¹q“¹c6“9‚]€wù<—m<÷Á#%wR•zãþ\$Éˆ^ynò'äª÷J@‡®éC/­o¥Néâj²¶úÃr!j™‚‘„ó+…1·OÒ\$ú³I†	J‹FÄR—5„&¸*õN\né˜L5Ç3Ð4™´ÑO’/\$\"›8SqC‰ô‡x¥5†”IO\n³Ã³	i\n\r€V`ØÌÀÖž²÷B\"\\Ó\$úæ•mh·ª<ãÒŽ–”ä²Å2¢Bîf¨RˆAx&à·Hô ª\n€Œ p(ÀI±ˆÜ®lfó’HI—ˆq‡M±Šwó’“zE‹|ù1ôÃ„RÃ\"J.\r²¶|oè‚àÓÜÖ7ÃŽ÷6ÿ.òD®ÂzBóFCsJ|ñ.o0ãc0Þcà–ÉË\r‘i—R‘wc¿ŽC¿Ž—G˜Ynç-´à.	EâîÒ¤'\nñiz%Ñc56ÃUâRG´v+*o´Be-Nµ”yRF@NÞäŽjÉ\"!t·0On.Y_©¶µ0†&ÔÎ…Vü>“ÄÁt8m'UÇHöÒý¡SÞš‰?u6z#¡¯¢¬ÖE£YCC´ÄJwæJ+Í\rwØ‚ÔG_š= ˆ.ESëf±ÐOD>Ç<=gof:R6v‡5ºv‰]¤ÉJò\"x(3æò4aPqœº‚\$Ú˜w²	6PYD†ÎŽ 5há+RƒGÙ73ob¶°1‰¡\$Û‡3õ\näw’Hj®Ú£…	s@q%\r*DGoR[ Z¨*Ä™',IN0ã—œltJ.òS]°¸‘§:15±@ÞÄÄì`k0¢ˆ3ZšS+‰ŠË­ÿbH/Rb”“ J¢ù1ùcq·Æg×ˆ}á\n";
            break;
        case "es":
                              $f = "Â_‘NgF„@s2™Î§#xü%ÌÐpQ8Þ 2œÄyÌÒb6D“lpät0œ£Á¤Æh4âàQY(6˜Xk¹¶\nx’EÌ’)tÂe	Nd)¤\nˆr—Ìbæè¹–2Í\0¡€Äd3\rFÃqÀän4›¡U@Q¼äi3ÚL&È­V®t2›„‰„ç4&›Ì†“1¤Ç)Lç(N\"-»ÞDËŒMçQ Âv‘U#vó±¦BgŒÞâçSÃx½Ì#WÉÐŽu”ëŽ@­¾æR <ˆfóqÒÓ¸•prƒqß¼än£3t\"O¿B7›À(§Ÿ´™æ¦É%ËvIÁ›ç ¢©ÏU7ê‡{Ñ”å9`\rçKp‚†KòDÿµÏàæï>Í+œÝ½®@Òçˆn è9@IØÂPýµèè&\rëˆÜè7ÉS†âÂˆD,ÄŒƒjÒû?Ã{Rªˆ;X“F£Æ1£(òÔ–¿ÍxÃ\0¡\0î4ŽƒC7£kðæ;­Ã Xƒ:ÆÁèD4ƒ à9‡Ax^;ÌpÃÅïÊÜ3…ëÈ^8IÒ€ä2á”\r«rD´ŒËrrã8à^0‡É ¬4ŽmÃÈ=7ñ:ð´9ÀSË7èÌ&:Œc¢°,\nÃ¥M*N0L#ß¶¸œ:Œª8¤„Ñ›ž+¥+BÕ„£\$\0<¯\0Ms]¯<\"6£hÝŠƒJ8B#k¸”ÁàP’7leœâ¢ãêþ'ÅŒáB Ê3[Cdj;.ue\$ŽÂl@Œ:ÚxÜŒ±,[çXN#1&g¹ÎjD„Bâ|æ¼±\nç9®ÛŠ2Ãï+»-R@ë]?ëÀðþ11ÝûWxØ›Èi\nÃÄvhÂæ¢â˜¢&SÍ(Ý¨ª•×OTéT3\"ÀìNÔÕ8ÕX†ÆR£žˆ2½h–œÃp5žÀÀP Ò4Õ„<\$¤«rPÝˆ£ÄpÄhã-Q’Âò\$j¢ „2•‹/pÑ*D¥înèÓû¼*Ôz<â3Ï„\"¦ugnb0Ê—ÊÎ•\nb5!<ÖˆŽ2½C,&a•°½ÌÝ³LâR‘\rã0Ìò^i †ûB‰R_Ñ¨7§¹[ƒxQ1Üz3©`Ù­#œ§	¸#Î0­. A_ÅÃu¶2…˜Rš\nhÎ>½0¶=3ÊÑ8@a•*øš\nŒóâO©Pëá\0ƒ4^c”§£ÊU*Ê÷´—ò`LI;¦gè}rkM¡¸°^¼“¨>Çµ(%öÓµ8IL>¦Iä&G%…–ôŽl3í¬=%ZLÔ‘~/©84ž”L€p\r&02ä¨•ƒBXéu/¦Æ™S;Ñ)78òààbv`ù®BµÃ¤Ï<,ä’`P '!­=£Pà}‰Êó8¤Ñq#\$¥ùžF™\$>5\nˆÓ³^Deô‚ˆ¦W’F4Ä²7³ìûVrº!š£g}\ržÂx…é#¤“bÀÃ\nÎ8Pðî’æfyž818ê½²*xW‚V?ñàÈ8(öF‚€H\n7¶3\\FAJ% ‚cÈáhoŽ¸â/9\0Ïá£&-dÔ+¤pF”D-?dµ‘†ðîr‰¢\rZ\\<‚ò.áQ j(é2.ZN÷qä¢>ŸdöF’´ÀGIì½\$™èÚM†ÉÉ]r`KãpKˆ\0‘Oh6ûÊÈ\nvñ½0¦‚1ÔÄòè|•`l]	\0¼šS~ðÈÒ#¨l–H‡ƒ6ÊhxG†×UÎ(i5Êén” Ì;]#Qœ9\"ãŒ¾!ðP?°ˆþ­¨°ßI I\"aäÍŸêe4‘©9¦Æh˜Æ–@á	\r¯Ê’©ì^§ ¦É&š‚hxS\n‰”!²rG“91l¬¡Ãå^¨z0ä¬½É’tOÉ-X§p‘Róc\$§Â¤(¿ ÑJ&Ž–˜XðÓ:@ŽoÅ—ÈBÖA*K:èHÚé'\$hÔ3U¢‚`BÌœ&¦'%ŽÎ*²€ Ùà‚Â U·¡\$-¤blðB	áH)\\bêCŒj6åb¬{Ÿta`P%\$/Ä>qŠš€('‡øq¡Š2† ÀšTJa2¤½Äµ\0†£žM*Ç7lîR) µuˆˆaRÙHÃ)äz1Ú<q\rýüj7ùf4†tÔð:	ŠÆU àC'*\nËA» rJˆV>ÎÑÅÀuí¢b§Rä­)1az?òÆY”«¾B›1Î8G¨7âü|«íiT07Û©LB\na¤=1›>ëÙÁÅâñßŒnÂi¯>ÒyEœ«BvÃ¸\nPêŽ…6€0Äk\rœ¬Ý ›÷Aœ—£.åp©bÒsÚŸ1¨Æ¢kg+OµÖŠ!8!DzW³Ë%RÿF×À­Ö®ÂâçL¸FOÈu«b”yNâ¦l pˆÏ°«f%Sh·œð‚¥¿	\0¥–óRéê‚6âlSïQI`e\rN=m¨×ðIAW@¼­«öâeƒz¾W[]Y/“«´1¾Ë{4×%=¬¬6Á-Ó®¸‚à„vúæÜ;3Í¶÷FÝÝ[² RFÈédÛ+zõlÜU`=UÒ+ú¤£×âV³¤cqnGÃ€weGÝÜ:Â/ü8ŸÜ{ÔNœ&l!Mâ­}ˆÓã'5<UkÆýš“%¥jIE»ÇE<¨“,ã‘ä<›Ö6“þuQn1%@£&‚i‘ýšáŠ.^VoÂLf×iØ‘ŠÀ_ºqØùvuÙÍ\nª?b?Ð\$+ü[×#â-€åªƒ‡•y•VD®üîÐÞ[‘=Tº\n‹wýòCÃÅ>Ø¢eûß0Y®}\r¢1x5Oä³oZ¹0“B-t.”«JÊ¥˜Ÿ¾•ˆÞŒ§rrù<`p‹„;®-õäoÉ3V%>Úô ?vŽöÎ×54ôó†xž\neEeJâfIj9Ý}ål›uR°(xlVñ›®c0#<Ã>@¹yŒ\$Õ)Œ*žðOÏøüßíü7õŸyVpaüÀLí\r“gï.(à­ÊyíðïBße2Ý­ÞÿªÚäN,Þã&ðêF‘mø#§\\ÐëjXïÈXï0p,cmJÄòþïåˆVÑl|&ÿ.>º…Œããþ-Ìö/C‚aH(éÈÜ/C¬¤Šdò/e”\rä¦(i\n*Åb‡k,/O¨0ÂD;‹¤•X¶ðuŒþ8\nøÛ\nK	ÜãÌ…P–.ðŒ'æ|€Ý°Kåò„ÏÂØiÆŠTD7mÒL†XZÍL8þÌêó×lü¯;ÅF“o8uÌ,ÌìØÕmS.ý±†™/âð­g A\$!±0ZBÐ¼æB-%˜|%ƒ†\$¢BkèÄee>ÍJ\rêVÕÁ.úð¦¯ÍNEÑ0ò†kñq±&†*hG€^/‰opÔÃæ8l£®tÖ1“Ñ–aÆ8ú.Â]Rj ì£-¢ÑiäÑÆõ°4†ÀÒ¤Ï/Í%--NýUñÜAeê½qç±Ä7e’i…—mhAñð²ðPE …›qàð /ÀÐïå¶.L˜Zƒ•ˆªÔãvWì?ÉÌCeê.6™ÍLœÌ\r#íûŒ!#%t2Cø%è\\QW%BVi‘P¢Íµ&h±-×&ð(Y„&\r€Vœ–€Á+BøÈiÂ0î äxbhË@\r§ÞF©\ny ª\n€Œ pëÃ†0bÔ&Ï\0‰Îç,ošÌß£5\"8#Æøµì¼ëôÆÊú/¬èÀòðÌœ÷¯K\rãØ8ÃÈGŠø/-2j-NçDšBÓåDÉ2Žr~D2O/BHK¾LãÂjÂ\nDD.qEÌ(/Q-äÈQJŠÇ<9à˜ãåR#GÔ î£).\"–è0ò£J>ÃˆÆÃfÊ/&/®J–©=62•‘dò\"ý7¢C5ÐJÃ\$–£ŒEÌª‡³†ãã‚TBPrçÞhKüëÒîÖ?ƒvb‹Âbì&ÖÄbÆ0\$P’G‚jžKÎ¥Â>ü\0Ûî@êX«ÈžùÐà{ÓøÉ‚J!„7e^Ò£vîI<ì‹æJÃ÷1†Õ<¦ª½±XB(t1\0Þ½Àî-ãº1Bò5Âj>¢XO2v:…ö® 	\0@š	 t\n`¦";
            break;
        case "et":
                              $f = "K0œÄóa”È 5šMÆC)°~\n‹†faÌF0šM†‘\ry9›&!¤Û\n2ˆIIÙ†µ“cf±p(ša5œæ3#t¤ÍœÎ§S‘Ö%9¦±ˆÔpË‚šN‡S\$ÔX\nFC1 Ôl7AGHñ Ò\n7œ&xTŒØ\n*LPÚ|ž ¨Ôê³jÂ\n)šNfS™Òÿ9àÍf\\U}:¤“RÉ¼ê 4NÒ“q¾Uj;FŒ¦| €éž:œ/ÇIIÒÍÃ ³RœË7…Ãí°˜a¨Ã½a©˜±¶†t“áp­Æ÷Aßš¸'#<ž{ËÐ›Œà¢]§†îa½È	×ÀU7ó§sp€Êr9Zf¤Y´Êb‘Î¦ó~œäÀ=ìÛþ€(L3|7\$Ë8 0¾( ú³ð€B`Þ¶\"¬	Nxë ï²†AðŠP9 ÞÒ³£¢*Ô¥c”\\0Œc;A~Õ®H\nR;ªCC-¥Hæ;­# XøÐ9£0z\r è8aÐ^Žòè\\’:Ïx\\´ŒáxÊ7ã„\$C ^)ó÷(PÌ´£è4ãpxŒ!òj+\$mã® PœàªMû\n¢jšˆ³‰«ë~É\$ƒ,\\\nÂHŠ+…+â¨ß¶(j9GŽ´Š†µB¬~„ŽCPÊ\nðdí\"Á*ü*@MtW“Ø+<N¢à#Ãƒ¸7¯°ÜÃA{ÍfP¬Ù(J\$Î2ŽÀP‰(Œ#­®2C`ëY»¬’.:½#¢tþA%Z©L PŸw,ìÑM%Ic\0´µzÎÅ³)íÊ:B€Ò4ŽKø¨2§3ÚT4cZŒ¸4væ.#\\CcL¹ ¨¨ÆÆ0ˆ˜ŠšíÔcx1aª6‹ncxŸ©£rÿJÔqÓêû¿4¥,ŠŽ”…%VBÌõQU(~	§H¨Öñ\r Q†J­y•ä\$±ŠJ©Î¼³é!†Ø.O	?6ð„b×P‰W6IJÅ>A» KHA»Œ£ÃX7]ü\"k‡â#Mä'£n`¦°w“ºÔ¸6ãœ„!©ÂÑÕ¬/Km¢#Œ¶cÅ¢+ý®ÿ²¬¼”ã0Ì§©¬-%Å Øß.ãŠÆ;7:Æ±¸Íq/º9Éz/‚0ŒèËÚ…oñ\nó¡@æÐnv™yS\n:ZÉë\n£pø*rNñB•„LžŽRXÇ>§HdQ&³„¤•²XKIq/&N˜Î¢fM©'´ú›ÁôOL­?¨hÓâ} gµÍ†uØUZj\\Ç´6<£HÙ—;žC&\$2“RnaOzE1)°»€àÃ0.I‰9ÿ%4ª•ÒÊ[K¡Ý/¿4Ä™ RfpIÂ¦ôâ×YÁÒ\nƒæþ@±®\räÓ»ö¦Qpp=éäž¬ø.b`Êñ%A”ÍBŽxu?éô’”ij@\rŒx¹Æ°äûO±!˜Ö\"‚„ñLKÇcÐ”¶G”‚i—Ù'Ø4 C{©\rÌš„R SËÑx#)œ2ä\0‚_¬„²šÄ0iÔÒz*€€(€¡(ƒL¤;Æì‚÷\0PCO¤ô1§´sC 4Fƒ£ÜH-GQì7‡xrØÀk-)AH¹|¢ØT_iÒU(äÔ“©í5Ä¤…Í’:IÜ³0ÐqKZUX¶H²6dmxb&%L0¦‚4!&K±~¹ã\r	Ã²x…ì4Ââp~‹q=\\xßÄu*é–1ÒZP³Ú¶Rz\rðš„’(L²)q@‚i2\$%RP0¥câ_ŒFE¬ö†8J`éÁMFš…\0žÂ -mjh”§™õˆÜš[\n® ¸GFÅ\"û¥Pž©Ó2\\LzÚ¬mð•€àL™†R˜²3Úja,n7ô3‚\0¦ÉŸa¢\\Ž¤`©-Ô:uk¬0>Ê~EP\nbXd¼—Ê‚^rp(}¥<3žÖ¦U	d¬2Ä¹–ðž\0U\n …@Š½­@D¡0\"Úå†±Lº\$ì%I7NZ©¢	a,Q‹eLÊ£:'Lê’…çá\$­Æt\rù2\$WP‚¶\0ÊžCa~.±Ë)¾Û	óiíƒÁ¢ªI’.¸§~Y»ŽG*›PB®ù³Þv€…ñ]Ðb[¦ Ãæ´tÀ-¦®H]éôEt–bÐ-õ–’ØâŸÉJ0©H0h”ÈÂ¤U1	\n«ž•,{F©Kyq´®|À‡¥g0šëØ@bc¸w3;OL™œlAÍeë\rB°æÒ[ÂI'.}žéÒC	Ê‰1íŠ!C•fÒUTWŠë3Z6-l­gXL¤R<Åˆ8(uœÒ%C™Møp89¹=†¹zIá\"…%BÊEá:v®É» ÕyºxP¬'9WñõkRô\"…`Š‚ ST(B@ß³PQˆAå@ÅþÖ…@‚Â@ §lÒºúhQxp™Ó_6£µª!(Â%¬¿«ð^-W‹^¿^ùMÙFIa´—èó\rµåžË¸„½„¼ÝŸ§qTŽDÕ_ç¡I¯«íï1kŒ5¨ÃC¶\nª¾™¬«_¢íÕ|HFîQ±Ðîo£Áu‰:.>!Ü‹Â7HIš\$«×ƒ8¢StŒ'\nA4j\r52}`¼¨fl#ƒY4Z’ÌWß¢4îó~ÎxP…éKÆÃÜŽ.ù‚<k¥K‘œ‘ÊùÃŸ&ùsAæLÉ¸Ìj¼—±BÎw_9†|[=ó`òkŠå\$“%h>y8wb²n÷ºRî´\\t7æ2!°l÷uÝñ|òaÉ÷áŸÞÓÛ½×Æ*Šhª8|ŸÙ;‡_ÃÝÔ¸v»ƒnïËA?gô´äÎŒrHã¹:x?Câ\"¹AhÈ©a4o<¢ø^É§¿4ŸHåº,á[=îÖò‘:5—û·v[à¸ÊQß™G,5È/M·=õôCv*Q•N¸Z’ÿ·ÞßÙ·f@Þ©D5ñòqqÐÇ|¶óOÏÏõýê-÷ÏˆÔ;EU-Ž{UÒß'M}’¨Ý(t±D4Ê0†1.ó´ö¯iÛ.+m½WºÍj²ÁjbN¸ûbùN0²p\0K0õ´ëÃŠ/®è¾Ë)\0*Î¸Jû¢ö	ƒ‚J Ê§.'Dª3cÞ–hÄ¢ìÊh``Dòrå©ækê¦öå’\r\$—€éÃ¨îf= Äë¾7í¨Í­ÎÃBö«‚G#BqL4ªišƒ%bu¢ÔO/þÍ+.,ì¾€ZÆhÅVèk”\\…Š;eS)zS¥>0ßäþ®ù\r*<S…<TÞù.“0è%0í\r°òû‰K«øÕ1°ØT\0Ó\$\"Õ2ìðß€§ƒŒ©¡*&¥Q%‘øð\rq…Æ†q9Æ~sæÊ¿±H4 @PÓ­>\nF\\Î…ÁjŒCÀ	'¢B¢_¤ZÃ€8E©¦\$ÞÀiJþQKèßŒþÞRpd]0&©­+\$Q‡“‘Dg§Ž]¯,Á,¬™1¡&‘¢)º-L…\n•1Ðï§¢êÐl…”ÍŒøb‘0í­AHÍç\\í±0üÃVïŒV©OJÍñ1øÊ¬ó!lû eÔ%R%€PÐ\rÐAç9qY¢,@Œ‚7Ñû.ù\$ÍWq=¬ß’X2QŽÀï€ÍÂÌ” P	_`ÈÐñåcègK¼¼\r™#RÞ	zWG¸+î”1ÌÀhÐÎ2¡)ŽW —`ÜYo~Û†+blÿ2œVdqM¸{°ŒFFe#Ì9&  @†h Ø`Ö&eNs\")k¤\\§¨\n ¨ÀZÜ\rÇî\$£´¥«M¢¤#…~Ù`ÂîÌf\\ŒŠ|F€é¢\"Àš‹`ÒÀò@\0Þr \"þô’Úñ’à9d}l0È3Z9-¢«öÄæ%\$y6ó;`˜¥öÝ¢>;pšŒ…f\n…TÌà4ÅÄ»æ´É‚7f>ÆoZï/æ€ÐVQ5lŠ”,`¦rlºïôœ.×:¯ !\0ÞŒFß’¦–s¿<Ð\rÐÆB@34%\"æLâö\$ì2ÅL òPSX^Eîj)´ƒËüü”Š¤Lí®òÏ®‹\"R÷ËŠOi.b9BÆ.PƒðŠq¢Î\nOøÉ€Æ(fª	óø\$ÅŠ,ãè&EÑ.ŽO¦Š ‚6óaÂË;LÉ<Cx5ŽeAf‚¹ì‚YsÔU€Þ@@î-CXAã|1eÔ>‰C&€Â_c†<`	\0t	 š@¦\n`";
            break;
        case "fa":
                              $f = "ÙB¶ðÂ™²†6Pí…›aTÛF6í„ø(J.™„0SeØSÄ›aQ\n’ª\$6ÔMa+XÄ!(A²„„¡¢Ètí^.§2•[\"S¶•-…\\ŽJ§ƒÒ)Cfh§›!(iª2o	D6›\n¾sRXÄ¨\0Sm`Û˜¬›k6ÚÑ¶µm­›kvÚá¶¹6Ò	¼C!ZáQ˜dJÉŠ°X¬‘+<NCiWÇQ»Mb\"´ÀÄí*Ì5o#™dìv\\¬Â%ZAôüö#—°g+­…¥>m±c‘ùƒ[—ŸPõvræsö\r¦ZUÍÄs³½/ÒêH´r–Âæ%†)˜NÆ“qŸGXU°+)6\r‡ž*«’<ª7\rcpÞ;Á\0Ê9Cxäå.ˆŠý­*FÉ–(éÂ¡”×%I‹¥&î»¦ò¤Ð¢:_+©k	²ÌqÍBk,`X²k2¤ƒB\"È6½8@2\rã(æ@C¢6:Ž„##Ç!o`Î1øÂ:#Â9Œ¡\0î4Žƒ@Þ:É\0á-Žc¼2\0y*Ê3¡Ð:ƒ€æáxï?…ÃwÁpPÎŒ£p_3ŽsLÖ„J|6ÁRëØ3ACl®4ãpxŒ!ó”¨BåSj•	,ZþÅè;dî\$¨jBÁÔÌ»ÞåªÉÍ^Ï³MÓ<Þ\$¬kúáŒ	DÂÎˆ³\"¸Â9\rÒ’8Œ%~U6¥­dBOÓ†ûÕË\0‡2kÒ\"V°êãé_·¬k\rÖÎº?¤†É}X+‹ImtÔµ:LÀÛÉZUqÔËq±°{\$D#¨Yc\r±¥::€­55S\r³<,©±ä#‚(ö–‡0(ˆ„ /Óîòºøóo’%eœ@„^m•a¦íó\n˜¢&0)RBYcvVè»NzÉ__C=*bWVW®ÓwvÖM­j‘°éÞ\"Ê'•š˜B[·zéÈ† ”*Z¤0Û%w^HÉ²ì¦ŠþåiÁ³«ºˆëñµ…ŽÄñK­©?Žxˆ!_›TB Ò9Ë#dº¡„T7r¼¼‡Ís(ð:Q2:9¹KIir:hR@ü<Õ^\0˜'esÂª 5\";—gh^\$á8H†>Cª(™fçŽC ØØ6I)D«&êê”&OªB»YŽVøÕFq¯\\Ï,ê\nÇ(òSXn*2DF(V«A&ÄØWíMJý‰[{Ww>²P£ÞwÆ¥¾'Èù‰3èho¨‰¾Å´ûß‹ó~¥9r?—®®ŸèŒ9-ãs†ù_D•ÇœQXI][ô{ (*€Â€˜@€:¥ÚÒ<\rÈ6†7NC\">Mà8§4êÓÊ{O©ü;¨Ô(rPê\$¤8âŠ@ú+)³Ú§Õ	[Bî­–ÒmÞ™;*Ðý·ØôHWUFM¡!7ZX[ª66'dµh@E‘´1,¹k#‰\n[cz!À¸’£BÂo\\ÁÅ6q\"§DìžÒ|OÊAC¤”2ˆQN‰ÒçM”’öH¹X·!ò)le«Wœôä’ª%háêµ’å\n×±¼n\rƒ½XTc![h8Û4HT	Â*3ö¥Ô›ê^\r!°6\0Ä—C‚†A´2­PÂ\$3aÕ'%\0Ìfèl\ráœöM¤Â\n]r“4åCtX!±Ô8WŽ·Ì¡Q|H‘‹5ÂÚ™¡K:Èeô˜BhUùU€o°(€¡¦\"3>É„«\0((`¥”¤k¬u6(\\Ÿ€ †§aØc‹Ü:ôÌƒIërÁžr¦d–ÜšD\ré2n 9Ê¨ècÖ‚ŠÈÛÏ5\r%j§ ARR¨sLé>¯ YóYC‚dLÉ¡5%ªÃ@ia #ÀÎæò]¬áŒ0ÃPÊPS\nA|ðÖ¢_	«'Ô’3ËuFˆŒ†‹’dÌàØØd\$\r”Û©‹S&eeÖPp`[úªBæ¢þc‰Æ’&t§®¦¯Ä<	\$h<¦4*RFK¹j¦’œƒˆuHI3 Û\"z>Ÿ(1Ï\$¹>+ŠCLõåv\r.œJ#nªÈÈXÂ¦KM¢‘–hÉQEVJ©]ª°ŸHÕKW™0(I\\ž(ÌÚ¥š%¦“Û.ËqfM‹¹z”™€ªKê~ÊË=gïª«ê)m(©§CÏ˜#J?T˜ynHxðÚ™/Q‰Nn‡³?Â»Ñ¼U–™3ØÍ8¨~ ('„à@B€D!P\"ãÌ|(L¹¾)Z·˜Õ\n ºÐµL…d2Ä?\nÒU·ÑTºI¤ŽhÇ‘ØãuH¹üÐ%-²bAg~³IÄ\$î¶3›õn|D…iîðJÌ¤ÁÛ+qµºÚ7ŸiEìÏµ¼GÓìã˜T‚mGDóvàtŒÐºUV»ÈÊ¾FÂÇ+ÔÑ‰¶1ttzå<«p¨Ñ\\JÀ:¿oÜÉÙRª½é1I!ªÈk*#+„ûk\"‡«ÇF/@’¼ ŒaÂD.ù[°mJQäVsÍëùTÒ},|–.3ÅUÜ¬´,®ÍæÑgéSD6ñö£KjØv‘-Þ÷Ø™Q`l4Çgå\$Žæ`c…•éãëK7ÊðNÉºú-ÀócCÓHü1Z¤-óê80/l°á\\î|±LÐßÄŸ5>G{Ñ~—´KÀâ¡ÐÂ Aa \\”RT«É#¤”—SøÙ8×ùLjZÚå²šbF¶_wNB½‚ôƒhcpÄ)‘7¡Yñ±©ÎÔ²Å‡)ã.BÃ‰/3à%}bñÚ^ñMu5[]S£ö‚CÛ\r'ªãk¼U2‰æävIó‘Ê¹YÙ°—;JMØ1Q4<ÙªÇ\nª¡ IæbB®câq%oš?àÔøŸ<À{ò'’ÆâzL`Í;zŒn'Ñì_lî×=®ÄÆW|;f|„¼GÇÊuä¢›ƒÕ÷¥Œ²2Œ2~`´ÞJK£\n‘ù+\$ñ/±º˜ëêÑ8àî³s¼ßGZüŸ•Ï¿ŸÙ»„ƒÝš‡><ÒÈÛBøÌ#a}„Döè80gV\$ìÁj P˜PYmðþë\0òþîþË\rÆÝÂ–ÞÚiˆÛÊhŒC&µêíÞ[£!\0PË\"n,š ôÒgæäÄFùÞ€¬¦˜,öEm8~î¾3~°q•ÚlÕ-4Ï†Ú;8XÈ¢\$£èoün‚¾Ôg\nÏ®¤çÚ•¬4´æ¶³Ï°.C\nï÷(ð˜ªL…0ºð,Te\"WOœàÅ˜„ƒ\\Â¯ÄW0æ#lJÆÈÞøKopúFÐþá-rkËDüŽP´âT2Ã¨^A±\nlAðN{é–?'«\0¢lÐÏ¢¦GŠ(éÐîÆçdç\\?¬òl&´lLÆ¸áê0â1,[íÎƒ%€ßï‡	ÐŽÍÐ]°hùÏm¥~ÓÉ«EmÒä…™q‚ýQ˜m¯Îà;]PŠPMéçe)ßñ¾N¾n0^ÀøÍ,D@¬\"³Cöp™B¸òcˆ‘L¿¢pÑPõÐ¬óñ¸ý-ÌO)ÝR¦¶ßqui~å¤'ÏŽoëPl<²)Ò-\$:Ïí,C©¤)Šzmˆ`ŽšPòù± áp’ÅR%’Q	¥Û&CE#1'bwí\n¨øvNY#ˆ)èû(kqv7²Bïêk):7Çq ÎoŠú\$<kM,ÌJDcBV<Ïbwn¾,\n…´Ô\rDx°Àõ1û&+:3‚‚Ø\"JdÂœÆ0ºãïW-~5èûpoCN´êœú2 Â‚’«’•r£‹ð-	ú€ä\r€Vºªä\rie\rP€Ì3™ÍÇf„¾ ª\n€Œ p§°®¹ìV3Ç5²\\î/ßˆ)*ÍTÈJÛ±O\nêKE˜j±©fú%BÐÍS%ãº˜æ\\ ï}!­èC«M:7ó\"^‹Ò\\‚®•‹0…l@ELF˜É‚Éžð\r–¤1b~ËØòÄO0#&ZÒÑÈo‡†DBÎV¦¼ým¦èd:'ÆØ‘??	r#Ã	qÍ7´\nwÓ6×\r4	@ÒŒÑªjü¦;@Ìæ7ôhÔÚTí¨0zSwælcVz´=Tß\"Â`,°dÃˆåJü0G°–¼F´Ë¬nêPiÏ}‰~h*ÔfØ—ÎšÝ“¤ú´–ØqÜ;@ê…j¾\n”Î3D%\0Ó-7GeTáŒßA	¡J°ùBFîc@ÞÄê€tƒæ6Môx¬o'ÅH´ë,Ôs…)et\\@";
            break;
        case "fi":
                              $f = "O6N†³x€ìa9L#ðP”\\33`¢¡¤Êd7œÎ†ó€ÊiƒÍ&Hé°Ã\$:GNaØÊl4›eðp(¦u:œ&è”²`t:DH´b4o‚Aùà”æBšÅbñ˜Üv?Kš…€¡€Äd3\rFÃqÀät<š\rL5 *Xk:œ§+dìÊnd“©°êj0ÍI§ZA¬Âa\r';e²ó K­jI©Nw}“G¤ø\r,Òk2h«©ØÓ@Æ©(vÃ¥²†a¾p1IõÜÝˆ*mMÛqzaÇM¸C^ÂmÅÊv†Èî;¾˜cšãž„å‡ƒòù¦èðP‘F±¸´ÀK¶u¶Ò¡ÔÜt2Â£sÍ1ÈÐeš’­‡#Q–4—¬p –%É‚ðôSÖÉÉˆÒ›%ƒæ0¶è¢,°Ï{Æ4¿€È:BBXÙ'ƒ€ò9-p×0\rÜ2®ì@‚29àäÍ(c¨Ê\rLP×(ˆ‘\n%0 @4ˆRy	¤Ð›n0…:h*R94ljˆèÐ9£0z\r\n\0à9‡Ax^;ÍrO®apÞ9ázî¥c˜æ;Îc ^)ÁóÖ¶\rXxŒ!òj+%;ª%@œô½a®Ð7c(Á´HèÜ¶\rcÌé­´âR×¶,@ª:ŽkÜ/T`ä‘(#[ª:!£#^; HK]%5ã)¡@Š#Èà8AâXß-.ê%p ´V{ .Éã¢ô¢hV!°ßXÑ²¥4#=ÃZˆ7Úc8Ï0ö¸ÓvD#\r4Ã3ñZXå	ƒÔÓ¾\nÜæŒ¨:5ŠWóp2ÖÊ\$JÓ§˜¨‘&Cu˜2SVr”¾/ÖÒÙf\roKßŠbˆ˜ ˜ª6· ìBRæ6ÌELŽÈ0ÄˆÃÓiÅNãe¬K	);\rÄ/!ÃYã'³í1\\=ªb‰X¢Ù}+6òÏ¡Ã.P¨%H:~êO’Žä0KZ[#Mrœ×³yÝ)³˜eµ´Ã¿­ÝXmiJ@§0K›Š4Jeè'©•g\\\n\r-¸ß„>Ä	‘Ò€—Þ‚vÔ§Nâð#Œ¶z1(ä[Ã¢–3Ð0Ê¨’l&š¼èë„ê2Ä#LŒ6éÊ´zR)j4÷4U=Zé-ƒtWÙ(.DP-II(©(û:œc_„®tÊMŠ€ÙÀKÝ'ä4wþ“â4h“ÔùQcaæ±cÏ¡½~¢õ‘ÛØ?É¦«§¼hŸp/ÏŒÙ…PØF^Z-h¥›·Þ]ƒ¹#aÍêä¤¥\r` FiÀÄ¢¸:\\KÉ1&DÌšRlé¹`äœ“¢v\rÀ¼Œu×Á‚¡ 2âLZ• uVÅÜÕŠG¤¡ÔI5	/÷R¹ï~Qû;2…\0™w0HHø Z“’*ÆlÎ—sRHIŠuð¨%ôÂ˜Ó(tLé¥5¦Ôß\r¡ÂuNá”<\0Ü«JbP,Lø)Ø ›Às¤È†B@uIáðK&-†*Ôx‰ÃÈvT\n¶)EB6­LÙ<3‹Ò*C˜[\n‹'dl‰G wR4˜7ªÐx;*¦Â(/)E×šw‰ë¼Ie² ¢ØdÊvVÓ,ŽÀ'´‰©z™eXr‚i§~ˆåo¶0@@P³qº†è”ñÕ8()À¥Äw3O¨†™=K\0S(e-,Dh\r(!¤4>\0àœÜ|~Q\nGM=‰éÌ`üÙ…d8}ÉœœtÐEû¸S’QWa•Y*|ÕB‚°fQø¶Ÿ(œéQ˜ÒmÓÑžÄƒ(DŠ[‘DQt}Q¨(Â˜RÀµƒ—ßÁp 	…°û©XBµvdÍMƒÎ´R\nK'Ôl Ô´]Cš£?f¸<“újˆKBDS®9\$OÉœ .˜6UJòOTMTr|<žöã¡ª6liD9—Óû`Ž iW„ÕóË’pN§8O\naP©Ô)¡”œíDÛå\"Ís@uÐŽ×b:ÚÈ nÁ¤3“’DÈÒ	Fƒn½X«I¶IÎ±¤æ&2VOnJ¡L*\0tO3Å9ìÐÂB%k“D¨—“^JjsZî4ƒÝåpAbò\\a<'\0ª A\nÒ^ÐˆB`E¾hAKËÒyYz:òQÌ‚\0ØX‚¬A[ÎòîAª:¤å “gr­ ­­Ä‰™d9†P‰lG‰\$&³Ò‘/%fÌ©3cEÑ)áŸ%E®UÍZ\"ügøã¶fuSÒHllåâÑÆ˜’Ck%ÁÊD©#9çLën“z%Þ™\"é+ÜÅyÂ¶dòKfN)ÍA,“³¯IÀ^fÑñr¸×èsXê0Ÿš&ÃŒ™‘À.nèèÄ™Üé©b¡T`)IŠMcÉ±A\$71‰¦®šGÑ²t2™3UÆnˆŠi™áÞi¯s¼Ž8¼>rVbï6žT“mÜêuZwåÕ)‘GlDÌì\\aJ³Nm	Zep§\0K‚ÔòìÎšZù@‚ÂC(sÆî½3H†ZšRDä¼<í’®PNíC>Óßm†Êhcžà/\nåKY Ò¯•Ñ‘\r9Ÿr‡˜+0ƒ¨iÑ·ã»‰Ûå	{×{Á}÷%ž{ßæ›€˜ô¥´ÈÙ¾±©ÌÓÐ ÃÍ›ÜT'Wsp^ùxÖõ5Ï»“iliÌC	p<£všk?htE((íÌ¾j\"VKné2f–ÝöëoÒ*p»|à˜s£;r oQmø‚stw²´#†Ì¡\nHŠrV+4æL¬+tÀßÓ®ë#*e+“~(©Ï^ƒ\nŸLocëH©wÐ‚–êB\rQ0xH9<PÜ™ÚcµÉÅ0í|»¬K¸æ2¡Næ¯bÔt\r/[7ÇVÖ¶è±DòT¡\\ªrhPu*>r>–uè}±‚³lÂcLØÇp2Nñv²u–úK‰Äx¨RŠq	ò WkÒé\$B¸økÎÿû ƒî×¦ŒÑÇWlÜ£‡B_RÒz=d¬¶H±jÈ(Y…V	ì±n9ô¾'Ð}Ÿú½]f­õiŒFÖ¿«/Ë³Ñ~üNýo®Æoú	cD±®R×¤|\$¨È®ß§¸ÞN-xóP.|pá-üå¯¼#®ÔN.îÏ<÷Ï\\£ÍB®«Ê}o¬ôïÝÐ>ÔgÀ¹OöõÊ¦6§ 6÷EŒ4F‰‚‚ \$vÚ©’ðlp-”YˆLáðvü|U§Á\$`¥â:'o¦\$|´ä¢p Ð¹N%(J#Ö=E“\n<BP`@àÞÓf8D\nå,ˆ_‡æÕpxXí\nÐíWo°õÐîTNFÆ/Û…AÃUOZÿ§\" ­€-„!OVóãþýÃrØ)\0XõÑ+ÉŽÿQ0Ftµ,Øg Ç`ÃbÁhb&	Ž¾÷ 	D†&ÂêÜÇú|#è%‡œP&ñ‰Rý‘&õÑz×Ñ1oûpÏù:\0Ì]%ÖœBGŒ~\"ë.ðÑÑ Íq²ªCârÀ\$\"EÂ4û¥˜w\0ÒÕÐcƒ\rZqÍ^Tðõ\0K)íP˜Ypâ\$±í1J ¢a1à'lqñãÆméž5Ñ\$Æp:<òÙhß\0/á¤ÙM³rD@æ>àÉAàš¨vÌãÊ¯¢Ú{‘¼##ü“È.QèÞ©%Œ‚\$±_‡`â˜g4qÆþ;Ã&ãÇ\rn¡p6f¤t?ÊºàR‰Å€Uä`î*¼`è@ØcnLçîµ¯ 8FtH¨–”Žx¹)2RË€ª\nŠ–	&º¢2·ÝÄr];&MäH[!í/ÌP…‚ ÅÊfQBäÊÁã†0¦q\"å+0ï)Ö'fþ5Ð,€/cX5Ë\\²‹ƒŒ\"R61+€€Œ,W†ºw\"d[,Ücmnõâþ»æP«¹BÐ-CléSXÆäÃóm/cDõnš^f õ\"ü7ÐG/û7“pëâˆ™Q4ó‡L7ÑTepDDv´åP/Ì†	 Þö®(Ø«‚aïÈ\"o¤“ªÁ\"&QŒV(l‘Ü1Ì<\\FŽ–\$L6íÌJ¤7,ÊÄ…œC®û6’J-¬<Ã€<*»=LLfä(ÂÌ>Ìî¿8\0‚%h%(˜wå`@‚qðÚðâÐ¥‡qä*ý,NGœ0à\\";
            break;
        case "fr":
                              $f = "ÃE§1iØÞu9ˆfS‘ÐÂi7\n¢‘\0ü%ÌÂ˜(’m8Îg3IˆØeæ™¾IÄcIŒÐi†DÃ‚i6L¦Ä°Ã22@æsY¼2:JeS™\ntL”M&Óƒ‚  ˆPs±†LeCˆÈf4†ãÈ(ìi¤‚¥Æ“<BŽ\n LgSt¢gMæCLÒ7Øj“–?ƒ7Y3™ÔÙ:NŠÐxI¸Na;OB†'„™,f“¤&Bu®›L§K¡†  õØ^ó\rf“Îˆ¦ì­ôç½9¹g!uz¢c7›Ž‘¬Ã'Œíöz\\Î®îÁ‘Éåk§ÚnñóM<ü®ëµÒ3Œ0¾ŒðÜ3» Pªí›*ÃXÜ7ŽìÊ±º€P¦<¹æPÝBHcRÜ@P#æ0 Pã¨©-c\\9Œ P„×%(ÈìÌšÀ£ Ð2»Ljk\r/GÚµ;-b¡°®ÔR Œƒj ˜EêT¨³£‚B†„Ú‘¢<²”Ä4Xí Ðƒª)ëZ‘ŽépÈâz42£0z\r\ràà9‡Ax^;ÐpÃ&Éî¢\\3…ñÀ_5Žshä2á¨\r©rPˆÉr†ðÁà^0‡ÉÐ‚ü©‰ƒ`”Æ’;Q«Qºº6'¯£:7KÆ1Êë”Ð\roTÉë“BrÈ2&62o°è\nãä7K¨èJ2xÆ€M¯lÛmÚ:!ãdaŠƒÈáÜƒmœ‡²¬€ÆÍ•6t³ôØÒ8À\"²Ž2·2º22oÔk	Yc-·Ì+¢#;8[³UŒ÷ Ï\">–W&Ì{L–Jè²a— P¨9+€VTÞc{æ9Œ/¸˜–6‘H˜ìÀ:§Ã(ð0“à)ŒyŠ¤ŸM	E`Ÿ9N5~eVD)Š\"bô:ŽÙC£>O£_×)Šz1LquRTÆ{¸˜¥šmfŒ P‡z&\"9·Þ»Žˆ4n>—²E<_†Õ@P¡”.öaP3ÆhþBÇˆ£Çèîq•tÂé‹8ÀE±nÏˆ‚\$öØ\"Cë8@ª[*ìq¦õhJ]Ø«Ùüp’biÐ†4&\\Â£¶0Ú12¨è‰%4oZ§ošŽˆKðÓâB;'|²kp3î‹F„YZ’•3ŽMzøÂ§B#&ìa¹ö“,c†ö0ª.'ee“8ëUN`MRÊ8-¬PÂÏ#1!+}'äjZ\0K'\rïÉ¿GÜýß[ú…x‘†\0jÍø €†¦¦\"êÖÄ\ráÍQ3Ã*Až˜ ,™Þ ’¦UÑ\$?à&@Òœa\$)%u9èS²xOIñ?(\0î ”#ÊD†à^àØÂ‘Ñ`íŸõ<¨	ÐSÌ1Ú‡¦Œ“‚(œÕgÁÒ9l0†À`êUÉB•D„¡F‚zÏ£2ô:±#Ä”òÚ}OêAÃå”BŠgÄÈ°Å\"¤ÜrÌ^©ÕEð|Ø\0m{)ºÀÂMÊ%&FT7(ø‘ÙŠA4L5ÀövÍJ¯)H¡.;˜išd`€1Jðå\rÒØ”ä®™ÐÆ–Ã˜f3ÄÄ7—Ó2™Q±>Fäp0›¢eJJ9(ð°é;i*‘K	ck\r5‡:Sç3¸„á@\$8R±.Š¨‚¨E\r1_1Ì­CÜ—;‡aÐ7šÇP+Œ[„„Ÿ8DÓIAA”2BØâ‘ÚœØƒ£\"tr—!*ÄÖ³Ï6”¸nÕ&ÄÜ™	¹6”%ñ<ÌC\r6Ú)-˜7†´pS\nAó–T\nRN¨V–…\0ÊÂ\r\0%Ñ3SFyxT2±EÞ•”%–PÚüÝá )ç<”™5dêS‹Ü3¬â`U#i¸ÒšsRjÓY^\rÕ\\É£vÈŒ«P|EJ™Ñhz¡SG%ÐÝ#ÀŠÈkŒ}.|„…\0žÂ¡>~ Š³“\0R;áÕ¶–Oê¡R66ql³È]då®'µ94wYa;K}„Ñ\0&0Ñç P4FÖ,sW>2ƒn¦eŠ’\"–VÉƒT	Œ`©=3·µŒˆ6²ZKØe±¦½¶¡¦tî¤Ñ	{7ÿ¡g¨XH`cVŒ2¬àÂp \n¡@\"¨oþ&\\±WË~'§as>Ü!YÃ#<5·Q\nƒzNÙÁÝC<8)ÅVp }Y=‹iÞO[•ü¯e9¶Dhá‹ÅHpÆ\$Â\\ÞÉˆkÁú?ˆ©²¹çÚ(­ƒ(åâ¯§8lr21Édí?‰ö*gºVe‹\$FÐ˜t sŽ\nÎ7&èåÉFclÙ³3Ÿ;èrÚÄ /æPÓHèS4©>XÉ)HH:v…ÜžÞY&íã%Év(Ò£«QÈvU_„£A@¥=ÆwÅlè„””¯Ò'¿©“gK-[‘G0a±„\n—J§2eÌ¡)ð{	a\nÇv±å|îL“hÎ¨*NÍ<RCÀ\nmJ˜¥\r„ŽnD•bl³¢qDÌ\nì…I¬­}=öE/©–pÜÇMÆ'i.^¶îTqºé83+¬9\$HçÓÛbÕitÐ“ÈèÃ!ÙUœñ³+•m±”>ˆv¸T\n!„€A¤ÙAJZD¡)å—GNr2¬àò{b_Ûâ\"ë`‚VL_8e[Ëa†w¥Ã-ŠdLùõ£Td–MHcžó=4à·ù«˜Rªà4Ò`ÓùO;÷+ÇîƒÐÃEèüÓ˜ž—£²ìíÛ‡awZc|p9ã,Å\$éoò†£Ôº§?5+¬tP]ÌÌ×9ê%+´˜>«Jú¼Îë\"¢r9¨cÙšNÛJŸ¤¸ÛÏ¶›²­e!2ó2Ž‰|‘0 Fr[†žÚMêµ˜ù\$6ÃÊck·ìóÒúp@Ã(bœ¾¬ù¯È»š3-Ø‚tÎ¶QÙ:q€uì©ýþéA!ç½'OÙ\n‰¢P˜µ€A:ËY©/½›\n•uÆ\\*ÿgW}¼ªO~öXëäÒ¸¿É&–t¦ÊÖˆlNÖ°ý§+•ãò?jLÿ2&Oöÿ¯Öé¯A\0E†ÏæËæ2pxL%\0dRO€_ÂNÝ+¸efYàˆ´b¨\"À ZC¶Ö`Ãg\rƒha‡‚Â)TMPTSŒê_ï”Øæ|ú®˜3ŠN]DZ%iZgÊÂ§0*g#pÖ§…\0LÔÊ)ù\0¯¾Öì·\0\"xÇçÍmb¥pï\$]Ð¤llŠUÙÒ›ð!0§	pÁ\nïºÿ‹\0ð\$¬YäíþsœËúçÆÐën`æÈòúÏØô\0\niÔ‹°pòê°øñ®½ b®Âm¼¾fbÜ!P¬PîÿÌ…­º°±(¾±/ðØýQ‹õÏøÜ\rÅ\roûáS\nB”Â…ÎÊ8Ú'’kd‹¯.eÃRÊ®Þ¬L2”&¢›Àé„à(P6€@.€eÍØÙÐn3©t!1d}±h´ñt¤CÌTç\rEèÃÒÝéøEï<û‡ÜÍä\"q'1*ÜMJuBîØ\$Rofàø.˜2Í²ºbQ£\0E{P\r°Ì·my(‘r¯r1]\0.RfÏÈàPàÏ¹/Á\n!Rüc'\"’,üð³\rÒ6ýÒ:à­G\$Ç!²FÚÍ¶32K\"²NYòÝ’_#ð<nDúDŽP¦äwž\\ƒ\"½Âº_‹L!EòÇOÓ\0Q\nIñY	ì´%‘9)pí\$2«Ðèá²§%%é\0002Xie2Üðe+¤Ô=«V^2g%¢²b0e,í¸Ån²,2^%Ò]fŽ2ªCŠ¾ekôÝç–+²1\n¡\$rò}mÌÞ›s0D[0’ø·±3%CË¦Ý²öÜòú0òÝ’õ0³.\n‹úO`àR=&/Üá­€y Ïÿ-ïÇ4Î1Ò©13ZCÆ`â‘_\$`?fø-ý+RëèYæ4 ÊŒåòÜÎpÅd²÷¤®ñ9\"F|…%¤3sž)ÉC²1å¾„ª!ÍX3œ™Ž^ûI7%™\$Nî[óÐàì¨*0Ç\$S¶,@Økô_cº5q¥-\n÷ƒÖ8iA\0âr'b”öËg±|jJÄÝã3‹À@¨ÀZØëý6æ@ŸNœé»>0³CbUBtqÂD\$‡TD­‚ÕæÌ+^†Ôh°dcE`ÄÀ@ƒ¢@nE\\iMä\0EG\0D¹¦G8Óÿ1Òw‰!àØ|¬p§vZG¿ÐFq†T!…©ËU;C<4;o)PvQ}9‚Ä;& ì\"°!4ËDÆelu\0ÙLŒñN˜;ÍD”\rMÔï:±5tùM°)LÂ¢Th&;dIÈØ¢Î)â£â:cF:Ô\\„ËÙOÕ\"ø. ÄþÄKÒ¶pÃTŒ½\"cÍžªú#Ï5Í‚y°ü# ¬É‹þÄ¦hô£\0\rÂŽBt=/®ÒêÜãc¢‚@ÜãqNldÇ³üŽ\nÅ\rºp­ÉYC\\ˆÌ1àÞ— îe€	\\«³BZú¥ì=‡Ö>`A`Ü";
            break;
        case "gl":
                              $f = "E9jÌÊg:œãðP”\\33AADãy¸@ÃTˆó™¤Äl2ˆ\r&ØÙÈèa9\râ1¤Æh2šaBàQ<A'6˜XkY¶x‘ÊÌ’l¾c\nNFÓIÐÒd•Æ1\0”æBšM¨³	”¬Ýh,Ð@\nFC1 Ôl7AF#‚º\n7œ4uÖ&e7B\rÆƒÞb7˜f„S%6P\n\$› ×£•ÿÃ]EŽFS™ÔÙ'¨M\"‘c¦r5z;däjQ…0˜Î‡[©¤õ(°Àp°% Â\n#Ê˜þ	Ë‡)ƒA`çY•‡'7T8N6âBiÉR¹°hGcKÀáz&ðQ\nòrÇ“;ùTç*›uó¼Z•\n9M\nf›\$ä)©MJ Ê½Î Òòh¨èô#«èØòŒ.J¨áŽˆàÃ+dÇŠ\nRsŒjP@1¢°Ó@ò#\"™¥*ƒL¯Žˆ(ê8\$±‹cŽphÎ0° Âº9#ºš4\rã¬l×G#ºò2\0xÂØÌ„C@è:˜t…ã¼¼1S°¥ËÈÎ°xáŽrSŒ„J°|6¯.¸Ü3/)ÊœŠ‡xÂ?C*@1Œp:ûŒ0¨æ3£Þ”³XêÙ!-øš7±ª+pÔ·@U/L¥ÍÃxß\"cxì•ÐC(ÚÀB P®”\rÏ]Œ\0Ä<´ Mi[Wä.7ƒ¨Ú¾B Ò×õXÜ“¯O#\"1³vT+HÃz|P©Ñ +.«Ê5o(c4Lò@\nŠ±â0ê7P¦fÉQƒ;63Ì0°„:ŽcŠªˆ0ðß‰î3\0Ç¨wË\0¡Ùc(&ej˜ï‰ˆª€ÙÖª‚n±U¢\r4ÝÃp€_PÊW\$‰¦á°Íëd¼X°¦(‰€T~ÊW£ªÊÓãM4”ˆPŠC	Ñ0¶s·#ˆëU7â6ëz6‘éº:r©¤2Ÿè4X Ô5KE‰)\"ófcãÄjÇéC-DÃåz¶¨©ë Pˆ!H5ÍC7â#ù¤\n¨æ•Rê>ªÜü°\r+%Ci ‡0íH›1U¡TX‰D°©ˆôaoâOEˆNÂQBÀËk°^ß³ì«G‹ïñ\$2 c T:—·2;ÚˆšB;zïîõXÖª–½ŽÉ¾–0¨I\n¿S¬(µwÚ Ozœ÷ê‡ƒ„Ù~\"Cãv—“î\$þhAçÕ•kêQ]´5\"_	Ýc—|F°#˜Þš\nŒ#äßÓÁ)_¬\"”VR’k²#¥”¤ð@”C*SJ©],¥´º—Ó?)™4à^Tê{ƒÀˆBzÓêqÉ…I¤TxrÛâ[ä¤3NJQ¸eeQô—î²Ðc¢\r†œì(T××Ðd…¡Ô\$ä ”’¢VK	i.%àî˜,L¡É3¦–0`éN	É°‡@´ƒ)Ä¨áR…X³…Mg –JÃ‚<J°²¨Æþýë(aˆÀ•™Ñùª1Ç\rÆ¬R`\r’†	6D9RC”UjÔ0†cJrš8a˜Ï\0ØÃ9Ø’i›ÈóÞªÑ›a8ºÈ×^âœCŠ†,x'µÖaƒ‹î.@‚\0 \rížF\0PUL† eLþ²vG‰Ž\"¨€§oá ðê‡G‚ßÑ‚<’¡¼;Ã§,Œ…'òg/„ª|.vH-Ä)¢v±\r…<Ž?Â`fÉ~i­’#I#ÎÀpHÉ!6¤¹&	ph¡¤3¥elHC¤_OÅþð×!BS\nA‡PC@Í ¡º€ŠÖ®ùÕ1+xd©’¹4gûl¨„Æ²‚¼äÊQ='å·¯¦ÄßãÉK)´ÆÌe½\raºÔZNF \np}© i6\$Âa¢’¶_©aP•ÀdÆàHö.âCPáRÖ#—QS'…0¨ÕÅbbËÉ–™Èš¡Ðu6äªASÈ\\V|…æ4ÍÉì^ù%¤ ô.×ìU‰ PS˜Î†#šºÉe(ä­—„Æßa\r a'\$ì•ÓS\n‚¤É:íˆ“-Ö¨tI	+2h¼¡s4_EõE‡‰Pù—Õ“æ˜\"I+	È¨)Q„Ø „0¨BL	!h …)œÂp \n¡@\"¨nÐA&Á'… ¥yo=é&[ßvˆ¤°eYa,LMÂ( j­žF\"˜˜u(dÔ8YåáL×¥”9Gu„©åLˆ‰Az.˜zäC‚è^Ï E h¬Ç³Ô\$Ö+ÜE<è˜Å1üVv\n;(ñ¿µiŒ()ÿU,mt3Æ|ÛÐ¢m&ãS|’¢ÏUf*À…#„,·Ó|WÄ­²•.Ûð:pæìôPSceÌ`­-¾cÌ’¬¯æâõ~éÓ1fûŒÚù1ábçÔÓ^lŠUÔºÁ²ìë´bX¶ÈÄ.]C@2«•\rallHÝ•\nÎxÂ§£´mM¹Ã[zqbè0ÄiÑ%Êù¡ªRÃuR8&¥è<0§z@NÁäÕ·E˜Âs]ÅÈÍ7-¼ÍS^€òÞ¾ÃF49Ç5êeORôLvL!øøÍ®¢Éå € ¤‘‹·!î¹fã’ÉJ¨*0*KºN/F˜”<àÞŒLê4ls¹‡\"_aù3æý]‚ð@®•¯!ªÔ–èNjt\"‹C“¸„4‘“aIªï†›Ä†Î.<LÏqRÅÅÍ*¼0Õ!yÇùL¶,4ç6ZkvwÒ+0š+¸É\\Îµç|eûïìiVù>\"¼S—r~‡3Q'FC}!²òƒÓ¦\$?ló¬Ú¢ï[±ÍeP­Ú¼~Ì!‘\\¤škzØrƒ•Ä2¡¯…ú€h!)¡‰¿u^‡\r;©äÁ'¡À¢4\"ùº(QÎåwü…‚Cž]Åém3ÒíáùÏTJcãr¾ücb©ZU]¤S’ª#;Ã&†DÉ°ßAêSÃ´]úgäÊMñ4ô¾€Ýè™Þéýç¸1&‰Ô7„oÓ¢ÓKw<šxtêPó¢{MÈ…üC<hÈ°ÍÛŠÑ U.0¿d—V•·óðA3å+ô»‚ßõGñc¾oãªÕúÁXfJ| )¬\$¬\0uh×/‚mÆ€QBh±¾Uol…ðÈ	m00°\"nÃÅ@DÈðÈ †0‚r2°B¶Pš`äÜúãnXÐŽ^ÆŽBäpEâ	)ºåN8åªæ2‘¬TÓ>9#\nØ\"B¹Bú÷E0gB]¤F¸ðŠq\"•ä.3p™‡\n@‚v%€À®\\­i¦¨×¾j‰\"Ã&§¨Ú3„è&ïêI©	ç<´â,þê¹‡îÿPìBe\"×\"Â±05¤¤Ð%Ø°G½§#ò¸Èm	é>X…F1,‘b¾jœ?Ç\r«L1ì0×âRÀ÷P•„8\$ãóÐ™¬kƒO~SmIïjõâÂÜ„+	7åQÊ…O¯UˆÜg‡\nfÔ%1ˆ{£ V%ÎNècÇÔ@‚de¬ŒÇR7>“ð+‚4àÞ¨b{¢hýI?Q½F÷ñÌÊ‘¾ùñÓM\\Õgj×cq‘Ñ­Ð%…ÖÒÑ÷Ý¥Œ#fÞ²éNE ÊTã>ó°Í˜ÙÄC!ÍŒ=#Ò(Ù­Ž/2\$h†õ#R,¸±÷#ò ¸ ¨UE‘%[P\réì¨2;	qi%å›Rf3²`@B\"`½F’\"±À2«TíxWr\0j|\rîj(bœ4.)#Z€\"Á)Ê¨qÏü1åv¤*\$äw±µ+oR{°^äöáïDxpw@A`Ø`Æ `Æ™@Ä¡jùƒ\\Žˆt1ÉN‡ÎÊ+¦.\"Æœ®±;	%4bÇd½@¨ÀZâ\n\$i˜1NëBDëzø‚.#\"6#§9FîûozeE-0Í\\ÛÅìEá/fÈ=Ïn m¤Ú‚©/l-/-;4Ë¢ÂC Ò8Ñè¹žŒŸ7Åè<gl¯~3>(3Pé“¦L<,(ïÚÇn]ä#	ÌÇP„oó±i–cC;‡å;ÍÏ=:³ºøé	àà)Â˜ÚsÆýÌy=€;ðûG@_rÉç£>Å.ùFbPPþÊbŠo† ÖB„š ÞšçÐtB.1óÝ>l1à‚AÔ;‘ª!Bé(€ÊÙÃ+:bd1å.Ä¨^H©øVÐ=LH)E~\nÄ2¬>@î/C¾-j:#~\"†.lJþEêB¾\rÀ";
            break;
        case "he":
                              $f = "×J5Ò\rtè‚×U@ Éºa®•k¥Çà¡(¸ffÁPº‰®œƒª Ð<=¯RÁ”\rtÛ]S€FÒRdœ~žkÉT-tË^q ¦`Òz\0§2nI&”A¨-yZV\r%žÏS ¡`(`1ÆƒQ°Üp9ª'“˜ÜâKµ&cu4ü£ÄQ¸õª š§K*u\rÎ×u—I¯ÐŒ4÷ MHã–©|õ’œBjsŒ¼Â=5–â.ó¤-ËóuF¦}ŠƒD 3‰~G=¬“`1:µFÆ9´kí¨˜)\\÷‰ˆN5ºô½³¤˜Ç%ð (ªn5›çsp€Êr9ÎBëlwq-½âm^™|_Ó÷Æç|mzSË;IÊ¡n,„¹¨cô 0NÖ(f¹L×§¨Jô# Ú4Îø@2\rã(æ;C¢2:ŽƒÅ#Ç\rp Î0¸Â:#Â9Œ¡\0î4Žƒ@Þ:Ä\0áŽc»Ä2\0yÊ3¡Ð:ƒ€æáxï+…Ã%\n;ásÄ3…ã(ÜÇãœƒ!…á–\r¯k\nÏÛ#xÜã|ò@îkzÁÁÌ´À­HJ×¡‰[ìÄÑH2¢	—Ñ¨l¢#n‚â† ÎjjTB¸Â9\rÑR4Œˆ[÷A¼ÍZkE§t‹¾º(\nfš¨Š’L‡94´¾7\r´µ½iº\"k×Ú?S/âs-p} †'«Uæº–“–2ÞÿAŒ;ådAã ¿°)šðÃ.\$‡'Hmš\"	¤Ói-Ñ×-zI éê@„¤B˜¢&Y°\\Þ5Ôªpü?Tú­ÑˆSÁ']!r§in3qãÈEˆPuYMZ)6k¦ií¤ž¡„‚6žÁy• ¸.Ô»£‡ÙŽLÿŠlúÖB Ò9Æ#dj¥„¼7i:\\7§iƒ(ð:LQLì9Ï‰Äü“4ö–y”UŒÓpž¶È‚^Ql¢ÖÕ½6£®)’ÖË5èu6ûC ØÀ§©[„[É2 O¿ù)O™¤ÈLþœ'©ª„Á¾vs:–¿©Ý•¥©}í\" éY ýsH5éžÕ2koÀˆä\ra³¨'®m@Õè2^€¾\r¢ËPœ*9W]ugÞ²4‘%I’t¡)J’´±àË¿0ÌpÆ :N³D&rLNÏÔø„½Í:pÄ ( £ ãuÖ<ã¢Æú3,ÂNÛÑ:\nIå’’ÒjOJ)M*¥pî–RÛÃKÁÉ0&\$ÂÕÚËÝM)­ú’S IØ£| ùÓc^JÉ¤ëwLÅ˜árDlæ¿˜`¹3QË„–¨rNÉ{ˆ\n¡¢W¸‘°i\r°\$júqA´2ªÂšÃÄaÕ\"€Ìb`l\rá\nD”rÊ5iP4”Ü!±®Ñ¯É4!5Ä@÷B®(Á\0P	@‚–\na{Žà(!§d*ÞànEaÐ7£àäC´J¡ž*£äF†Ú:\rè’%¸ªŸArhûƒ:KÉ™+'ú!ôÞ†ÑhsGèœFXÓ/CppGˆù \$ äªC¸h\r!Œ4&Ò|MF²ü1†êã„ÌÅã›\naC?®ÏrD€¡tžhRHåw‹‘ØšòÔµrª!„•Ý™%o	ˆ\")f÷tBT<å›êª~C\0Z„^#Ž“ÒZòI;–+”æ¯hïÔ\\Š&¢ˆƒOú1H‰áú¡Nü(ð¦'É\$¤8ÄPÿœ‰2DAÑ‘ÉþÀé½>\\ˆ‘‚Ú Ù<Ôz’R‚ÊÓ¿ÁRBb%IÀ/êè½E<ÏYå:Îšu6Åù \$µ@èÂ=\nHõ9¢ò-ÖõŒsIêú5Ç¸*ã¢{L“('\rév,¶es)u¤B™&b`M=X&áø(²djÊ–²Ì\\å³ÃòÉHƒxôl¹öH@g\r¡-g¸€¶¢`n–Zå³ÌúÕ*Æ6ãØ½Ÿµ5!Š6âzÿOÙv†	VÄ×W†Š!¶XnÑIi•Çé ¤%GkÅAr‰»¤FÁ%n!ä\nÖZÔZü ëJ¬•ŽOI{ù#d®ØÖs9MÒ\$ÄÎÈ£V*AAbHÞ¥TÉ[«bê±J1l¹Å¼§,ž™ö­cÌXÕŽs\rzÍX¡É0U–µ‹È,¦É™Ë+!Žc¡iN 5vØ2Ò®ËYU1ŒÄ×ÁnîC7¶F\$êã\\Tá‰\"!P*†Õsgìœƒ\\ËH<>19\"à‘ERð©ÅˆûãÈc–ˆ‚m„“z‘sñ±0§÷Þj	…=%dášøyI©8e©Ÿlã™Ù!™¤ódì‰ƒ¶Pƒ\\RÎÒñ:ó!²¥^îi]5žYÏ©ö­chµ,ÀÏ)/¬7”¨#q@¯-D§ViEmÕUv19aCi5\rhÛ»UD€†	7\0Åî[{¾k=E«J¶GálŠpÁÝ·Ø˜„¤@ÐWGÜÙÔåÓÄ†œÄÍ H4‘ÀÔìÄ’z`w^,œ6oxã¤µ«ÚïgT„Á‘D°Q-rk\rjê¶²B!á(9‘3˜ZØÝpDðò×Œ„{*÷f‡EZp%À@p~\nr§»9UÆ¤r‰ƒäK¿PQzÖ)¯gÝž‘Ì©å®2æÓs[Q¢mäëQ\\ÒÏóö%Î7³Dç½ÐtätI*…ÒdBU<§ÔrÎpU9as“Ÿ£L	8Ã‚\\ÉVmÙ~;+?}ŽvnŸfûkì«—¤œ²	kôõ-ÆÀ“+ÍN.àÜÁ3’{'WMbn‚è÷ŽO{öÇ8@Âk“_·5‘3æùÝÃ*toÏÙS=ÞBôiÉfÅ;Š\0…ç.õBžÿ±˜»!`¯XÕZM0ÅúR,[’å×êÆà'^œ»¿ßß¶-ÝNŽ¸?3I>¯0?8“}{fþ¦þ?Z0åàÕöHéù_ƒ¿Z:t\\¬|#{FºêÓÆMQŠêjû«v|Ý†_UR¾ö„?ôøâLÞêþþ®ÔµKÎò.PæPÑ74ïˆX%pù0 ±\$­ðbîP<ÂÔ6ÃV9¬>ÝMÀÅ/ìçpDÅÊúíáné\0.”ûÆs–ùFô-lR#gÔ®Èí'z%ÐJ80xÊ|íð‚È¬\0ß¥ 9m :hÿ/&³kÄ9ÉÊ^¬¼‡k„-n<=Ï'eì5ÂZÆ0ª@âv6Âýƒ›ÂÚnªµ‚LÎÎÀÒ-( èH˜dâÄ®~ãn1clVƒl4íš„Âž†Íhð.ºŸb×£òG€Ì q,ä¨†R›*YKÞÕíô/\0›E1ƒr0*¾Ñ@]\r]Ê-q&2Eh¢Æ,!‚^nEº&3ªlÓð:À£Ì1nª0'l^\\–#ËÈ¯¢h0Æ¾pï×Ž€Ï¥¤ -â[ðÞöÝ‚<Xq©…ÄŠÞÙWP~ø‘ gFñG`«ŽÔê©4êØ½1Èëªºù…¤[†¥ !‹Õ£ÊÇOÊo:¶‹x°±þÇŒYã®2«EŽ-QIg#b §‹ÊbŽþ–aD­®!(<#kÏ	CÍ‰à·2\0´BY>@Ef?g\ràì;àî’æ°#b+È\$^‘*>é²n @";
            break;
        case "hu":
                              $f = "B4žŽ†ó˜€Äe7Œ£ðP”\\33\r¬5	ÌÞd8NF0Q8Êm¦C|€Ìe6kiL Ò 0ˆÑCT¤\\\n ÄŒ'ƒLMBl4Áfj¬MRr2X)\no9¡ÍD©±†©:OF“\\Ü@\nFC1 Ôl7AL5å æ\nL”“LtÒn1ÁeJ°Ã7)ž£F³)Î\n!aOL5ÑÊíx‚›L¦sT¢ÃV\r–*DAq2QÇ™¹dÞu'c-LÞ 8'cI³'…ëÎ§!†³!4Pd&é–nM„J•6þA»•«ÁpØ<W>do6N›è¡ÌÂ\næõº\"a«}Åc1Å=]ÜÎ\n*JÎUn\\tó(;‰1º(6B¨Ü5Ãxî73ãä7ŽJ{z:H¢¶·°(ÓXÇÉCTþ¿æf	IC\r'|\"PÂlBP«Žˆ\"¯£=A\0äŠ\r±(Ú»£AHÜ@ªPæÝŽb”0Œc\n9½É„|ß8ãZ;,ÓO#¶àæ;Áƒ X‰ˆÐ¤ÁèD4ƒ à9‡Ax^;ÎpÂÐÇl3…è@^8KRàä2á˜\r°cZ»ŒÐ`Úß\r#xÜã|›Šƒäí‰()Žƒê5¥Lk¾'*ì”‰–i æÌ/nóàŠ/©QUUŽë¾a“CRB««0\0¯K\rÏrÞŒˆ2h:6%Œ¢YTN5€PžÃS#…^VŽ«˜É²£8òÅ¾¢êÑc¢¹m*i[Xú-â Ê3#ªRÃØ:Œ P–Ù¿ïâîB0ëŒcL<5§8Î¤ðê+}.5[ëŽCC±MÁƒb¤\rËÀ·¯)XÖÂ\rÌè5ÁŠ±Ch°7S&Ô Œ3Àb–7Z“€ÞCc†â„˜Æ0ÔØ¢&K#–€¼LÎÑÊºK“·Ñ<&‰CÕ£3[Sj½ªU(%jŠ»âž´˜¾”èË‹1{¡BN%EBƒdÚ>ƒ8Ò:Ð¸@’6È´¾·ˆ£Æûh¾+âülªFÑ¬NzŽÛvˆY=øŸßÕh\"(.#l¥ °c>7sMj˜sÝÊ<+#t™Gl[5~ZPÇ\"\"(‘\$Ò2dÂb‚í±º(Ù-â8Ê’©-“¾”±Í3QK5£xÌ3(Ro}¾‘kê*\rí}Ñ„‡\$Éc5åÄ\rû·U/Ó£Ê`3Œ+¸AùYQØÝqŒ¡@æ°\næ\"YµE‡EJ¤PœòÚI¡: ä—Ã¬whõ0š”È™“BjM‰¹8tåHÐ.Néä7òHè2ŽP ú¨ÀÜÔ‚’8ì5†\$BŠQ¶\rO:%ó*mŽr3F¤ò ÔÑŽ9ü+!É,‡4¶—Lû‚\r% 2äÀ˜ ºgM)­6¦ôâœß´!„iéÓº—W	TsÍì8hn!ˆ>s„H¤±eŠ@ÉÑ„~e(Œ‡'¾rJy†Ø„Ê\$8 I-F†àRçÃ9r*çd­È\0JÔ@X'ø²`áJJ±DHú¢cñr&š%³Ðêù\"sæ“/¥ù%C4p\riÞ2@€1ÅC’W³­1åæ\0%R4eL1Ï˜dÉ¾äVQÌØt3ªíÚ>“|ÓH \n (LX—2ùË‘E2G‡2>MÂŽ!R&ÇƒblÍ©·X®‚œ\$‚L%\".DÜaˆäŠ¹£W¤ ˜ ðÞWdéq~d˜‡4ø’Ÿš3J7-˜øŸb€w8!Œ4 ÒÓAè—ñxÎiù?¨\0© FY0¦‚10J9¯5qg‚Yl\r‘bžVL4>a…\"‡I¢Éá>(D­ÔG5JTÏRóì*G`J+J3æÂ@tç	¸I\"!äÓ£çvk’Žç‚”€â¾™JÈ,@ÈÃ(šjfs„Ÿ\$Š”1Œè‹´œxS\n”ß@ÕX¶dg\$9¬PÂ\\j§*å åCÕèVòéªôí':2Ê³W\"µ<êH‚\rÚ™Ni81Qð@Ú2ž+Ò`\0Œ&ë@X¤õÁÇ²e]ê„ (\$—9\"‚Zòi4ƒšÉ•\\Ê\n«jç-”âT-™Ñ»«IjðàTÃ)¬n*Z+ÄzB¯PHf!éi\nÁ×Ó.ˆÎi¶†ÒœÚÂ\r„œú\0 ˜»æz/%\$P;†¾[çìÿ 'j–XÆØŠ\n\nqØbfS°Þ—®ÂíN\0Ð)2ZÄÃmMÄ¶pÞÚUpF;æMvù1bÍ„1)*\$Ø!¤•´=WÊb_›aC\$óöMfM`/íL Š·®©IEÎ¾‘FÈ\nù-ñü)³-(–\n\$ˆðâ50\n‚X¦Ð2‡r:©Y¾\\/×1ŽºyŸ˜xkYVüd‚˜\0C’gªÓW-sM½ÐºDÿ`Ô\r“\n#GÃLÉ™ˆ¦–UÁ Ù›æQŒÑ=«GC“çp‚’ã.ôÎcD[[CKøÿô<Ì¦¡˜¤*@‚Â@ ­ù¼Ü=\nÑ+ƒƒƒŸgè4±¤œmƒ]›cÇDƒ´”ÊúÊ\"ÁÉd¬]Ç¹YêÀÒm£Æ“!n ”¥…¶pÂ´ª_ÜNzÍ—r²šAp	Àûd£í¹Å¼Žó*ûÔÕo€Ã¾·6ü(ûø¤Ôn»8.îàïûy èâ·¸tß%/ˆÄÍús¸©7	ÅÞbqýì´\rQ*m£Ì-ÅÇ\rÆØÝ¬|›ãSÃ9'©U bÞ‰£:À—œµòT:I2%0ë9µëD¯\"/êlÁOò4Œê¾¡ˆéõè˜TYÑL`=Eó&“¸Úµ&Ö0¹j•GFOÐ61m\\½ ŽÞ…U÷€åCxO¨ÃÑ8Á.ºa1GN'\nì¬…wx	Xl5’Îùk±•g›È~Q^ž„Fcq“/jÄÏáìAÖÉÏ«pêÌ‚/+YìUƒ‡Å°ì[p^á‰‰þ'åB3KóÚªa°É*b•fÎQ„aÞr˜C‚–\\ÌG7ú¶`ÙRá¦ûãË×øÿ-è½XGèçð‚K¾‘-+œ^vè@IÏº•-…´;å¦¦kÎŒ³€RÎï†'0DÇõ¬Öõ/Þ±€ÈÄc„vëà’©9+2jC„÷bV÷Ð5Œ8Ðoj&ÃÀ2`Ð3òÖ%ÌA•!ZÎFßnLânPà\0‡åðUnJ<lßî-P]záîHÝ0j6Pnµ ¹è\0ÒpÃïS	êº Ø˜hHpM\nÍ%\"Ïzöã®Ñ+\ni&t‹ÊH¤ïjd¦‚ô3²Uaul[É\n\rd¾&0Ô&t €ôZª¢/ä%«\r#î!Pù\rœ8%ê¿l^›ŽAçA+ÜI6’éH¬+\ní&M	¨V&²&àÇ~ÇO¼‘¼Í€¿í†mBrøEM¹‘l)0¦õéhrW‚÷|TSìZqqhF®æÖñ{˜ÖÌ'l)ñ¢#ñ§O|±¤¥GÝl;ñ¹¼q„ÅÌ`;à–+@ÈN|’#Àþ\"EBN2¦>»®ì3 ä+o&SÐ[ï`FÍeÍ)ÇåKX`F`ÎgTUÀŠ\rˆv\$oò ðR\roÓ,^k'\"²/1ÏE\\\nË²C¸(ã¢%ï *æö-:Gª±\n’Sª>ÓÑ©Òe'\${!E)&h™#&°Ó|‰’=+˜w\"Ö±È4o&À„7D:ærkÒ¢×d8×Ò ±«+ Ù*mz*Îg(ô?ƒ7°ˆEè^’Q\0>æ?ÒR5oºaå”Q#²Æ¨r«Pô\"þÝðÆ…Êqøïüà2îÆrõ0’ú3/R	rÈ@«è%oîdX×1¥¢YO:gNOSŽëÝ3Ð‚å-Ñ3°	“AE:\r€V¯oÈ°ÅIÅê^ãZ\n€ÒÇÜJ¢nËv\r¥´)Hˆ~@ª\n€Œ psè#7H^&ðh~føHÃþÄ-ÐÜs¤ps«/ó¢¸“¨'ïR#Â@\$BH\$J_©’h^&/dvãÀ\"óv×\0¤EaBü ì¯ 0ã÷+kH¡¯:£Ç\rM#ëV«j	%áR°Òˆ\"¢(mn	€Þ¶e\n)žx NcÜC°7¤\0\\c°Ud>ñS*™ˆ¨ÖåN\\nÞUÏpø¤\rƒJ-‡1Î¶ÏNþvã6’€ôôTh+vâ|\"Ï5Forïò®õ%*8­(5cZ ê¼ÅÌGlä°G\rF©ÅÿbÜ<sÙHtxcF‚	©°Ý@š³fnÿMfmf{%F5 ¦Ah\nÄ¦ð¾´ž^Â?ì#òã\"hRâ	CVUuEÔØÀ2-a¢tp<t~+Œ-€æcUQ’àÑ‚*ÁÆ\rä.ãd+\"Ö‚²\r²â9à\$‰²wc:Û¢ÖlŽÚ t\r Ú";
            break;
        case "id":
                              $f = "A7\"É„Öi7ÁBQpÌÌ 9‚Š†˜¬A8N‚i”Üg:ÇÌæ@€Äe9Ì'1p(„e9˜NRiD¨ç0Çâæ“Iê*70#d@%9¥²ùL¬@tŠA¨P)l´`1ÆƒQ°Üp9Íç3||+6bUµt0ÉÍ’Òœ†¡f)šNf“…×©ÀÌS+Ô´²o:ˆ\r±”@n7ˆ#IØÒl2™æü‰Ôá:cŽ†‹Õ>ã˜ºM±“p*ó«œÅö4Sq¨ëŽ›7hAŸ]ªÖl¨7»Ý÷c'Êöû£»½'¬D…\$•óHò4äU7òz äo9jNznºQ9Šã<€ÝÍ)ÎL–®¿d¸BjV:p‹	@Úœ£ÀP‚2\r¨BP‹ìÛ Žlðàô#cÆ1¦Út´ŠVÇãKFÄC¬’V9Žï@Èâ4C(Ì„C@è:˜t…ã¼Œ(pˆÜ”Ï@Î£Áz29Æ^)ðÚô1È@ÌôAj‚Êã|–Š¸Ò’Ä P™5£H€è9@ƒ êøŠ¬J¸5l»½<¨Ë‚ä£tæ4¤Éê\néÜÞ¢!(È“ENh–7ƒ{Ú%#ËÐK·+ƒâ\$¼1ÍB•ÑxéM#Tð‰#¨ØŽÃØ:Œ¯”Ô4B2B3¯ppÏ¤v†ÂOÚ8œ n£Z*Îƒ¢üÜÎé\n\\%o’r5'#:ž2hŠ&€»­lÓrQÊ6Â>•’P„.	(¦(‰€PÅ9«ÛagÏTKý6Ð	(æ5Œ°Z\\:Î8>üa^ÒÍ¢ƒ(Ë3r\$µoE	pÃoˆ…†#wPÙ}U	¼Ú\"@Pá]B\"ôÓ±Ê@@ôöh£¦ùÆl2\rÜ½¬©c]C¬È\0Î•\"VêGv JîƒNÙˆÂ3TIrdã-42ÐàUfø°ìJdÇ\rã0Ì´Éih—uáˆ¨7²0[t\$0Ì?ŒÕ•Ú7Œè@çNcÊ„‘¡I#ˆCn2…˜R¥¥Z÷vaºd–ŠŒ[Â›Ëé›ªÞ„|””FƒŠŠBq³Çqì Èr,\$ÂOL(\rÁxÈ²Õ«,®wïºî3Ì“2è˜QXÄ½Fœ½ËeÃ(²‹À¥°×	Êr¨åIè|r2Ñ¬oØG‘ô!H’0ï\$BÌš9IòŽ¡hì°9‡ØààfÉÌðŽ6\0ÐÔš«Yl!Å´›±„´\" E~lXÑ{1J(›µ@Òœàh1Èy15#.»	9’%„Ž©6®hI›zD	Q¾®Å2àa1£)ðˆˆ:ã‚A¥[4`Š¸_Âé-†½¶†¢€H\nà°É‰Ð()\0¤§Ä²ÜKBeIaã™Ã\$ÅÌ¹™ªM‡BniP¹B\rŠd;Æ²ZW	›*\0˜†ˆBJì\"e8¢‚hÒèn:9£¾¹¤d•†t|M!ÙŽjÅ9ÀÞÂ\nC\naH#EØøI(K\r&P6·ƒh·¡b²•eÐ:\"Jfzl¡´¢’TèSZá5Rî*-ãöOIù9|§H93CHk(ð–„’LA;RqÅviQÈqW¬cÏ+]3¹“%1©–57É¹3PQl\0 Â˜T[áÈ¢«rhLOH 	iÝn¨„JP‹‰äž€´rÊ,A¸3’A3`ÑH0ÓfM”<¦JBR‹y{„ÉËA– a*E3ôâ˜èr#hªrÎr {ÒbŸ\$!D*‚ÌXŠ*Á	á8P T *¡‚\0ˆB`E©@('CâPÕTªÈºf‘Ø`¶ªÝ©‰µH|ÀXÑ¡—§2­M\$µMiÒ:‡Y”ŸòßãéK®´ä9c.NÌ]sM\ní‰²¥°ÂÓ‰ƒ`v\"BòeË0AXÂÖÑÈÑÕ²d¢Œ¤(¡±\\:\rE¦R3Õ¦æ\rÄ¦x{‰M5ª^ Ö[,ÉËÈzW1„Õ¸óÜf#\$k:'NÍ (aMºRfX2‡všŸM£MPj’Ð.¾ÀHEÕ\"%Ô6œƒ@úz¹ìåêxP‘¾>hD1¨ºÍwJ2	½Š-‹,Â‹\n ‚®*¡“„dÀF€PR6ä!BÓ[cP#N(\$‘Ä Aa N%æfÛ9\rèa\r!Èì‚:¶N%”¼ÈZ“àƒ¨“(Dhó&Ê¿Ähã/Ÿx2Ø‡Xü_Ê‘n¿Ð£dNÖá´(µÆbs)Œñ®HÄG†e\0 •”ËòoB\$ló‡r\"x©F9Ùyõ~HÜö3&Äí0Í«cr{GÀ—Rœ„¡Š×å|”qó±	i†¬Ü~\0:G0Ó]	§¢C¦\r-L‚é˜^ÃA~.ªÒ1 ÚÃ\"†ÉõöþX‰µˆÔŽ\\ÐµIj…PìÛU×óöqæKºK¯(jS÷`N«œ¶ú÷V°êž¶rØšØ4¯²4Kj«dÀ(Ž¢*¨ŸµPajgx\"pàÏPP&EB\r-E¢¶©‘z-[Efî=ÕµÊ)jº–eµ\0Ó±åFVS¤ßyÝkh¦\0(5‹p‚š´Âëžº×{lÂl1pÞ¤ì‘éÉžÝˆ-z±|K†½Ö¿0NW_o}‘Xª~5¸»­ù{«Zq—ÆêOšXaV? wšžÞž'¯õ;n§|õÒqÝÉùÝç§Ë{£lÖHÛ”Ç\0C7u	µ{x\n	‹N„ÜŽ¡ÒAÁ\0jßuÚbÃÔ*zŒ­&=b\rõ¸×¦Šˆ»;Ó«Ptèm¦ŸZ:¦¡sËÐt+6ÊídÈï6\"sX-ã(Õ`öÞö^m9ÿ&ß>;•y°®†€Æœ—”¶I£|yÞ¸Ët\nG¼ŽøÇþÔtß;uÊ0eÀÖ û\$U”Ð·äÃÝ6Á‰ó¦Gc*0ÂÃW_¼-\\±Äôß/€pAé¾¨–üÏ¥É6/NÙþÀ’·Ò>°X-cQ]‘yÿ¼°çŸ2vGòo¥<O£	0e¤ï^°Ó{}-‚^WÏÔòìÿ\\éï¸…KæöþåQª QoX\\Ãè>ÎFóo²ùãæÁ£îÿ­ó£ê;\"õã¤hD€TúîÎ£(i£’Å¯Öƒ/,ÐŒªÄ%È/ÇUbàdíÓd|\rRÇkBNŒ~dæ\r€V¯î\"ÂÊ¤EjVãDn¨ƒçEBZÊPÓéÈ…'\n ¨ÀZr¼Ðš#ì˜æƒ&îš8Ð%¬BiîÞ°¦	°šÀòÀ%ÖU\0C-8,Ã¶>é¦2kì pìxãbÈÂ,7\"@`%Þ)ÖÜ\rêBKdr®Ñ(c :BŠnÀ†4ƒâ÷ÅoÈ6rív…°Ù‚Ä,…ÞÊ¯×ŽšeåÈÓ1PØnš&&ØÙ1UnôÑSP\$Ù€Þ A`Ø×Qr8O@å@Xìž ìH•°Úy…Ì[eº©ËÜJÂ'Mú\", b^±E®Åë&CÀê—jÇål/Â\0VÍÔ\"/„š\"b^@ä0nâSâÆ,¦–þ«²\$‰¦‹áN\$Þ%Íñ\\5£òm€\rãàã(4,¬(f¦díÄ I jƒ†„j¯ÂìOÞ";
            break;
        case "it":
                              $f = "S4˜Î§#xü%ÌÂ˜(†a9@L&Ó)¸èo¦Á˜Òl2ˆ\rÆóp‚\"u9˜Í1qp(˜aŒšb†ã™¦I!6˜NsYÌf7ÈXj\0”æB–’c‘éŠH 2ÍNgC,¶Z0Œ†cA¨Øn8‚ŽÇS|\\oˆ™Í&ã€NŒ&(Ü‚ZM7™\r1ã„Išb2“M¾¢s:Û\$Æ“9†ZY7Dƒ	ÚC#\"'j	ž¢ ‹ˆ§!†© 4NzØS¶¯ÛfÊ  1É–³®Ïc0ÚÎx-T«E%¶ šü­¬Î\n\"›&V»ñ3½Nwâ©¸×#;ÉpPC”¶S2Îuø,±Ë³T‹AE	ÑÌïh2ˆškœëä Ž¯ƒv¾I°Üù	ƒzÔ’Žs¾ P‚2\r«[ŒìúF:!à´CƒÆ1°îp@˜4«ÄÿºV4212ú¾ãÈâ`4C(Ì„C@è:˜t…ã¼”0¤,ò­8^Š…ã„hüáŒ\r«C‚7ËBrÝ¤à^0‡Éh¬Õ7®ô=E\r35±hÓ7¦\n˜å\0Žˆü¼/Kâ`Î*súò½¢Mbè6\r‹ðœ²ÈÂ6ô¢«0®ˆ\rÎrŒ\0Ä<ª€M9OT\nŠ7‰\"Ø\nƒL?S©šÍ\0004+XÇÖC{õ#¨Ù6C`êù\ntœ\n’/Â3cÓ0Î3Ç¬m˜ùlú³¬cpãaB|lêKÒRŠ£P‹­\nª‰s3,ðÐ*5¦YTe¦¥#ÝX_C\"0)Š\"`0³L+¶ÚÐÔ\r¿®@Qê1Ý¯P‡Ï8£ÒÙãIîáÂƒ6Î°¢HÛŽK“ 9åV.2¦Rê¿cïóô!NAf/Â#TÖ¤*0@´*`Ä¦èZ&„2‚j’o3”ç]«xêŠ\"/ÓøÛ­«UtˆN¦²#Œ£z)©¯ÕûÜÈ2H‚B7ŒÃ3¥¥¢+	V\rèÄ<¸ìDFÃŒÕðATÁcœpåoƒµ„eG\nÐÊaJZí%K’¡¸Œ²{Í7).ý'czZ*2ŽóW0ŽMj7á'È0QÇBš£]ltÉÇ±üƒ!È²<“%É½¤ 9JR¥ü¶Lƒt²ys—a3M4J›ârl0Çì‰Iªb‘R6*l¬Æ´î˜8\r1èÈG1ß{ HR\$\$IC¼˜“;Çy/9¦4ä–RÛ&Y=@|QM[gF\ntÐ“ÖpPâ\rH=J’Ð˜HN;@Á¤Ÿ)0aÌ!.d|•šbª«j'o5‘ò8]É‚u„QN†ÌúPë'nŽ8G‹ƒ h5€‰’nW)»-­E•ÀbI		G§‹PœaÌJ(.¤…x‘Vž¦A\0P	A‡[\0((À¤˜²È®Š	-j¨2Ã4LhX)œ\$yN²ÓVjŠr!Q¼;ÅôüˆªNÅ8’¬ÒF:íG®4Õ§”¬‰i%‰)|8 fûÂ-5,P!UØ‡!Ä£7\nôáºpßÉ(C\naH#I@A%—óô\nA”µ™Â`£L[\r+ÄÇ*Â	¡!}dá¥ú.Œª^Dí]J¶è RHXy2\$ÅN¡²¹\rDˆG«mx‘Ò]”\0BòŒ’†5RpçI«JÆyÓÌ÷àFS”¿\r\$À(ð¦&— rn\"˜HFê²›Ó ½#Ô†M±z7tü´æø\nm’Ì’š5R“Q:ž1€€Â€Sf0 ÁR6/×ÉÑCšwÎpä{cÑ©9¥@ô\$ÊŒ+Ì'„à@B€D!P\"­Úœ(LµP·¶hœªRŽ«ÈÌ9DÓ”®‚bë]©án‡˜aB\nÏ\r+®“–Ðú…C¦¾¼¹¢Ô@PR&J@ÂŸ´T‹\"Ì¿NÓ­XyðFÎ›Ìš‡­ dãc–£ `è\0ÜnLÉt„Ôb!@ãÁÒ5åÈ³cÚ\nF‚à‚h‰j…	9(º_M	¹\"€ê,âÔZ\\{©KÌ*8ÆkÓºÔlÒ•t¬RAâ…²)þì¢…¡ÞÒÅsTZ/á¸½¦¡Ô¡½¦)¥*|‚|xs¦íHÞöµëv‘ÖL@ÎI`¸y™Æ0Ïì\\ð -84—°×`Úú¾ö6+óL®‚2bÃö¡c e¢í0¬¼˜[åÓTÂ Aa NÂ\"gæôæ1¹Hã !—fxÕa‡,¨Áx  êt´†E“cUnÑô:Ò5R²!‚o<%£…G“eé0çð\0œ¦@²¶CÆÙo.”\\ »þb'p¸–ÅòvbhÚ±_¤`ÒÔ@ËGŸŒ/Ty¯?h@SÝ‡tÙ?,äm\nI]_tAÖ!7Í”ô]šFÒDf’•#1jZ}BEµAŽ°¬éZÇÌ~ÈáÃ§æpÊµ‘í¥öÅ•çý!®íXot¨d½{ÓÒy¬\0€3-Šy/¡Ô\nè(+ãŠaX…ñO©\r])ª\nÒr}ºÀÍD‰ë•ÈÜ–wo‘v„pŽ!,U—;,Y\rÆ\\>ô™	vÿæMçzI„OßÅÀŠ(¦f’îÒ>V™T‘Cñk%vgÁ}Jw²Ø`ù‘w[êïJÜeyðÂÐÉoa„›ñˆ§'N«ˆÁk½·IT†ã\n°­iÀòåa˜ldÜGSyt@HH‰#Þú¼þtspÆ:/MEœ±Ao ‡PPRÄ¨Üuƒù—³y0-yÈíï€Ö\në´\r1½ÌÜbó†a…9ÌªÜBLf­ó{tI›Ýð7zoP‰o…è—»È Á==˜xh?Fù¯\\ÒÏ\"û›r4TÎ¦i„ÊHÂ’}\"ÈaTt¦ƒ˜sŒFŒµDÖD‡<s\"ôÈ©5…ñùsv[)°¡´ÞÂÝ\$ßvñÅw½ÿÃ}ú¢÷ô)±ÒüCÃlx/Ø>ºy\nÃiZù0ð—f§G5ß^gÝû>3bÊ¡q>çü¬\"âˆ+|<.—ýÄco-²¢C/ó!Öküê+ÖãL@ÄÀžÀêà#‡ÒvŽ×&ÜÄŽÒëÖðÎÐöâpþ¸%°\"íOê™¯îbG÷ëp¿ÎZ´ ÞD€ÈOÏöf:Yp>üÃ5h¡É†OªŒ4\0òA¬Yä/çÌ\nŒ&Bï¶ÝpxÁ„.þ§Ífc£ÜüÆ§Ü[ËNÛ¯ô\n¤èK¶ÞP¤ò°\nÐ¦üä	t]£óêŽšÈ6¿c\n˜e\"ZåG«Fæ#âØÍ¸Ì°Ö´DJîPàø\"æ¢üTg\"âä-Ã\0})Þ~þ#ƒWÍ\\£kn=	Bíå&W,Ê)C1<¸& kä¿ÍÌ‹®ì(Hc”\r€VžÂÂã8ëá¢BƒI[‚ U.ìÕ@Ú%	a ª\n€Œ ph£r/G`%¬¾1ŽÄ§RÌ-(b&HÞî«(]ËpóéfL°±\"N0†TÛ,˜eä~;#¶q¨ŠÂÑZß¬1nZ“iØ*b0X\$¼ƒÀÞ¥º“f%ÑßÃž>„/Ñ&Bý##ªÐ\$1¤_H#\n4àæ,bÊÎ‚] ô„ô(àŽÒ…ï ²\$3.£gá!Ò3\"\"\"r;è^½@5c(õ\"è\"¦†vB«À~oŽQˆÈüåÒZ äbD&Î\r&ËÞáEÔçEÜN6­\nÕ(®Äå\$HÅG\r\"èk+ÎJD@êjåº¢òdN\$-„Ý+ˆö\"Â©L8äcg!†T¯\0Þ¯G®ÌøêF-OÐr>[â\"]   e2PD\$^\nq\$T…‚Ì	\0@š	 t\n`¦";
            break;
        case "ja":
                              $f = "åW'Ý\nc—ƒ/ É˜2-Þ¼O‚„¢á™˜@çS¤N4UÆ‚PÇÔ‘Å\\}%QGqÈB\r[^G0e<	ƒ&ãé0S™8€r©&±Øü…#AÉPKY}t œÈQº\$‚›Iƒ+ÜªÔÃ•8¨ƒB0¤é<†Ìh5\rÇSRº9P¨:¢aKI ÐT\n\n>ŠœYgn4\nê·T:Shiê1zR‚ xL&ˆ±Îg`¢É¼ê 4NÆQ¸Þ 8'cI°Êg2œÄMyÔàd05‡CA§tt0˜¶ÂàS‘~­¦9¼þ†¦s­“=”×O¡\\‡£Ýõë• ït\\‹…måŠt¦T™¥BÐªOsW«÷:QP\n£pÖ×ãp@2ŽCÞ99ˆá¿Eú8†i‰\\œåA\\t”/Ê>¦B¨á ªÐlr’j¨H£åÊ8W¯äªAñ#	ÂÊ¨—E‚®Y§¥pîäÑƒ\$©r?(èä€ ŒƒhÒ7A\0È7·-hÞ:›|8AràÂ1ŒmÈç)Œá\0Ã+8.HÂ9µƒ¸Òâ4Óa7Žc¼2\0y5Ê3¡Ð:ƒ€æáxïG…Ã£)Át3…ã(ÜŽÄô9xD¨‡ÃlÖJc46¸#HÞ7xÂA¤kééNE\$ÐŽháKJ	se¢û°*ÁWXÖE”t”)ÎM•È1\\r¤áÌDDb¸Â9\rÓ@æ‰D«‘ÉK¯\$ñEš8w±v×¥ÎJ•Ié.Q ÑÊ@>gI\\ÄSòt’ÅÌJ–\0S\$CEiÌR‡9hQ9¥Ùvs„}è^Æ7á2FÚŒ¡ÊDØñž’Ä:¶Kåë6J–è1*¼‘d­¸NB0ê6\rÛ’ÛK£Â7B˜¢&#÷Ñ='&X±,E Ù3œïºPt!	p¤-V)IcÙ7¦Ð—Ä\$=hí±j?¸&;“Æò¼õÕy_'¥ARøÄqú8Nå7¢ÀAF¿Ä£‹öãf©D–‡oðµ¶ÇFÑÐˆ©áXfŽ6–Ö*!Ý: Ýu}HÊ<8CtÏWŽnaÍšæùÊ{ŠføJs,r8Un×Ú¨H*ìA€£åÂ?äwÁãœ·6ƒ“HÓMTT3Ãe)ZÇ’bRAD¾P¨7µõ`Ü<„¯l:Ì“0Í£„`ÞÒ˜sO¯uúÎR˜  •t¥ ÜN(`¥ô\$²PGßjí\n†¥¥TŸªg\rÉ¥(@äŸC¸\r!‘*§óP ”\"†Q\n)F(å ¤¡2RêeM¥wZr›@ú*ØF¬Uš\rBì•öz ÊöYäøO¸F^ƒÄ1¤qô¸bµÅ¡Ö(”@ˆò(ñfa57œ(@§CšyOh<\0Ò ƒ .OÊ(U¢TZQáÝH©4©ƒ’˜SJeÚ)§o• I\r¡ÀÛÕ4\"@>uà‚K'EÒo\$àa\rj¡.ü¤¼J‰‚•ˆ(ŸI1>'™JAÎ»]Œñ¤@³86k@Uà94€@d¦P~K.Â£r]	–8¿¶’ÿ NGÝ†ƒXÃ–Ž<IpÒCc¹'¢,PŽQx-G0© B\r”:aÌIf'@\$´9§dîžÈtOB\"\n‰&sØÊ²V¾à¼¬%‘¦,Ë™{>MCUéP1ÄFnÍy±6fÔÛ†UÒ˜t7G-&&Ã½&9‡¬FŽaZ(È3Ô‹©5|€©~ø©bkju2À¤q@nA;Ç>ºC¹Åa¢NÎ¡æ9Ã›ÓŒ0‡TáLÅÅ5¦ôä!…0¤ˆã×FÈÁ|˜Á9D3,çqåÐKÒò+„ÐçÂ¤rˆñ_Ag¨ª'Å\0¡Â< ©ÃqI+ŠaÐ-×45ÜOÖçRI‡(¢!	#×xÉ«Ô¼Hæ4’,_\0d…tµ.©©>qMÒ‚!ÔÜ¥ÀÌ‚ƒh „ªRT„ßòp›´±N›ƒ˜xS\n‰!)ìPI¨&â†bHd[sWU”Ñ.­\0°µöÔÁ×‹“c T\nÖh,mÚ¯%ŠÓËºùžù§iÈß?å\$š¦=V\rH&\0ÍI´Ma*Ô—Hi’i†[ëmC‘«A…äR	aÒ Ü[x.¢S±–Z9EÓ&	á8P T +‚\0ˆB`EÇK¹œ\"’ò#Ä¡–xÏ¥ö°hòcÐzÄQÍÌøŠB‚%²Õb§ê+r>Ù2-FŽm²£›@{òìb,…ˆˆÝEpç9&t,5«Újó^ëë3ÎÙŸ<7fÒå×T%¨ò&!sÖ}…0§Ä–QŠŽq-‡0…^eEu£g¥qZr¹‚	ø(íóÆy‹×^ŽÒ^¢*%Qêá+\"l®XX¯‰‹ñŠËrd‘zÄ›yË¨®g¼g¶9…Âí¹Àù\0¨Ù§;æT›†ÊÊ¢Ák\r\nì&òå«Ìý0Ay_VƒkZL¯FÈ……”MyMÑeeüOŠV#{ÊÅRµ<®7-ixä„ŸÀ›éEÅ«ˆ2o[hƒÏk0¼ìÃÌ&ËÈ½ÝÌ˜Á7“—¡HB‹évè4\"‰1&Ñ…@‚Â@ ·h#o¥Æk\rr\\KÁÂ”(ò½i`ãH…g‘þ”*I‚è\0¼u#7Ò:wFË€™¼å¬é€ƒ¯6ù×ìå D…‘ö¸½Hç_T.{™ú0Yú‘é=iuÎÖas ÄD€wð0Òs(;®{QJ»•¢4?E£gãÊµ<–ëdAš\$ ü«qîƒœBNÑ-nÈ™Ø¨ÅætÎß,úéA\\2†+ÊÜ}m(Å Uêÿ1îÌfö\"1ÅÎ¡Ó€ Œd¬ŽQ·…k ë\"ãðå² EùœRÊ,^­YC˜[Ê#…Ù»„Zƒ ÅØ²ÕZþqbíBG]ü\"+Qk-‰bY'vGÏðì\$oøþib2Ã0íèÜÃ\0ø/ê>åÁr‹ðmˆÃ\0nÒr%™gõÇ(ÉŠ­¡Óä€Læ\n`ãæ„^äVF\"ü²œ#ˆ£æã*p×M@§®%?)^IÐM\rÒÝËmP5B\"Ý­Ö[G²^fr ìœgªø¡BòE\"0b®\\ÍÜìÏí\nLÖ¼ŒÚs°¬E-¦&îÌmb³OòÎ«ÆÎðÖÏ-[§1\rÆÐ§0£¡\"ÊÙ‚Â*„’o.O‹âŠPê³ÅÒì° ZPÐßÌPnåˆÚp\$þï\0‘8à¶ìñ	±KÎ·1Sb>eØ'Þâ>ß/>³E ]ïšÇ\nâh§\"EŠ*0àÃ@,‰ô­ÍFÑp¡ïÍ‰m\nÞ0b3Ã®pþºâ¸+ÂÀ®ç1Œ0‘’Ÿ7«XËñXHØoâÒmæg+,Ê®\"mÄÜŽûG±ôXQ?ñ_ÑöX‘]ðX°øÑ1@Î2…“\r11\nÞFÚæf´aÊWbê¡t2Ìá¡6?\"\0‡0¡|0Vkã£„cåíe¼Ñ.KÎ7&ê+M'ò8b\$²¥žß‹vÓÂ8ÌmãFµ(ð[rs/+D,Óò¡#…¾Ñ¡¬{NãN qCÎ2àÎ15\"rË-Ž\n÷!P+../ò“#E•/Îù¼x¦ '‚®åjÒælÌß3BÓMæ#‡Û1Îe*à	Þ›ÀÉ&Ò†§¡ÌpG[AÈa0=ap''™)!ÏÈ³Eàìj&IH–ÐÅŠneæc\$RH/Òàq’˜n\$€c+è¡3iÝ7&`óy\$®òm%¥\0000Ðgº\r€V¹\0Ò`ÖuDM`ìx¤	8\rëdÇèNc˜Ì \rª¼K‰¨Ìj\n€Œ puˆR¶HF9ŽÇgn3a#îg\$Üð ÙÌú»+·ƒF9Á\\¦ÁG*cœ1ÁÎýã&ÖŽ6q¡%B£\"2nÚ½âêÁ4&Ë,B^ûÐÎW#ïDï³EBãÖ=¢9Dm<'¢9ƒ/O¶¡ Á<h<Øb°m'º~Æœ8RÕ@°H´6áv¦ƒIp?IÆª#)/Rí	J§+\"0'\"`¨tãt5#V«%4u@àˆ¤ÛnHtYÎ• îí	:8Ý´>^o§'0U\r%qpšÝu.ËÐ»C4 Œ”@¬L`ê ÛG\0aKŒÀeá\rH2äá(iZã¦Z.¢îIö]Å†é´ìFðònÆ#¢h\"ëJ¤gô®t²Ü ÞÄ@î6C„mÂ>'£!¦òc*fË\0xŠÞÒUœ!";
            break;
        case "ka":
                              $f = "áA§ 	n\0“€%`	ˆj‚„¢á™˜@s@ô1Žˆ#Š		€(¡0¸‚\0—ÉT0¤¶Vƒš åÈ4´Ð]AÆäÒÈýC%ƒPÐjXÎPƒ¤Éä\n9´†=A§`³h€Js!Oã”éÌÂ­AŽG¤	‰,žI#¦Í 	itA¨gâ\0PÀb2£a¸às@U\\)ó›]'V@ôh]ñ'¬IÕ¹.%®ªÚ³˜©:BÄƒÍÎ èUM@TØëzøÆ•¥duS­*w¥ÓÉÓyØƒyOµÓd©(æâOÆNoê<©h×t¦2>\\r˜ƒÖ¥ôú™Ï;‹7HP<6Ñ%„I¸žm£s£wi\\Î:®äì¿\r£Pÿ½®3ZH>Úòó¾Š{ªA¶É:œ¨½P\"9 jtÍ>°Ë±M²s¨»<Ü.ÎšJõlóâ»*-:œê%/ü(¸·iÛZœ§dÂ€¤Æb¢ª»MÛ€ÌRí#®èã3\n·jsZ=1ÄhA¥MÜ‡¬ïŠÜÚÂÐ¯\$·Ë¬:N¤­Ó[¶pDÌ6DÌ““‹jªÒÁ*SSÀ.ºÖ# Ú4Ã(ä \rI0)ü²¶(Â„»'rÛ<Jë3Zê\$©ÌÔ¢,¡\0x0„@ä2ŒÁèD4ƒ à9‡Ax^;ÖpÃAP”0\\7ŽC8^2Áxà0Žc˜ï^xD¯‡Ð\n“?)¡à^0‡Î\n«=tjãºîü²ëÇ®TÁÃíÛ/\r1R€?—-9D¿íd;*Å°eÂ×]òâsy5×£žŽO÷èŽ7Qã+v#Šv³8ÍÍ„£\"JË¨”z>_Ò”ã'1L@A“32¡0Ë2þŽ¨	;[,È*U¿; ïÔàãËØÖJö]s,°ëC´†F€¨“Þq#dW<BÿÄˆÖy )m]A\0ÇÈãø§/âOKãïöNç(\rÄ‹+©(ôy;o‹ù‡BJ½yá=éÀj•6nHñ. +3ÐÐ¨Êrï©Ô}Å©úš­‘þDï©)Ëã\"ÞŠrwh,ìó{¹+ÎÈöó*Ä|)Š\"e¹'zÖ·(´§k—ƒwÛ3z®üõ×Úo*cNús°ðqeùÜBøz§wSk-'vœ'‹ŸÞŽº„ûîNEÃ¼‚€)3%)mê-ß\$dIÞ-§=Î>|Åœf‡zb‰æ?öÉú;w¤}Tå ¿äº¼9ói,\"UK2¡+ïö¶ÒNP™1f.Î@Ó±‡ tÌADaGþ3’všÊn~ìè7¦P•˜ûÛ+-@—°wêÙi9K+Üô†Àè™I-fM´%2ˆIßÑeo„¢—ÈG3©N0Ù:fzsX›H*¢¼ÿ–õôÛIÉ©*Dr³öZq’ÛT@&0Þ¥âJ™2K!`¸™>BNãÉy^bD\0ÝrÌ¢;ö]O•ŒíPrÛweµN–Ï‰ cÅ)¶t£JPjC”HªcÊªí@2\n8E4Q”dƒ(1Ç?˜’ÏÜ¡GTj•Sª•V«Uz±VjÕ[Èµt¯òÀá7†àÂLµYK6'ÅhØQšgMëIj##þõr„m5ŸÉÖN¾OŒl‘ÌFÔï&a9Jˆ	4ÉÆØùb™geKnè|½J|ApóGÁ'ÒRAèÃ1uÔÜŒ’S*…T«r°VJÐ;«eq#Ú½Wë2‡€è°œ¹X+,9ËÈäÈˆñ“uïæbé”YYvs`ßÂSäòV{9wˆ5Ÿ?cÙâ6(³9F|uÍÄ^(”h» òÉ	4qfÎg9W1Ê«”D’‘é¹&TWM³q¹9˜ª†Êª[oÉõž¶Hw2×¼çk%Ú›:–\$£‹	¦ŒŠ£F>É…R€ô¤Òò«ElM>Æõû@Šç2ëi¾ª%Ä œA_&2/yòÜj|ZnIúxV¶œÏbi&íÐ¨§’NuÚ'‹“¥kt%/ì±gŽuÖ©œt‹hÙòt²±…žØÉâk”Sd^òŽG6XMÜ„ØE„y­@ôNP{êi‹æÆ´W«kKÒ%6eÚåLäÐÂ˜RÎŽß²Â&##Jµ4­·=RÄ­r8ì0ÿ‰©ì'9­9Õ§Áæ\nÒÜÌ¶…\"ÓbK ¥(;Õ-•3BIi,Ë©h¡7Í‡í9ÉÝKE|ÓÜ‹Î1v¾H(³ö0i0£·W¼¢_túär€ êÑÞs›6#éÆ\\zc’ZüÓ\"c:4Äü(ð¦*kCRudŽV85—ÄHg8ºÒTsvô§A²QT¬2Ø5l¤ÓîgU,£ãÜZfC8êX¢/œª›m›0™«nÉ96@_Ù§‘\r”ÞãwÎIiÄõ#‰fÇ¾*b0T\nŒ³3êu/JMgžÇ]¸R	—^Ãàµ*><0eÈhsxœ­,èJOi  àó_(\rÀ»g<ÚÇß³°n9¹Â6›P‡2N­)¬^öÂhÁšœnl„Ó!Ã7â¦]Õg/X€^m†Blõ­«oE¼#lÿžÎkÃÛ;G¿í mØýXK#ƒu9dû3OEÙÒq¶ˆôR^fø>÷‘Y%íÊu¢æÌ³=r0ð™ÑßÎíò÷tKmÊÕRA¯F0N÷ÛûOì\0‘ òÎ7au±7¿´¡¾'½]A'2#ù…W+ñl1»Ÿ³6-!Ž¡ò9z÷3ölËFóg(i.¿a‰Ç[eŒê÷]·*Õz(w–v9’ÚëÁA»ñ{r÷ºG©Éÿ{üÁHìy™2{¾vûdÉ\$¦5”'3Cq5–tDEèýš¦ž#š…¨l—™“{}ÓgKj-tázÐ·»_bJ\nTQÜŸ¥<÷š];[=Æ`RPó·å?˜”®×{³”ö¼Ô\n.Æá+µ¦ÅÜz©Ø„Y’tì\n¥ãu>±ë=JÖ‰ÀB T!\$:8ç{&^™öèŽA«Y–ÈåyG=8ñ¯s•°¿¸ÃX¡.#æ\"y|ùýÍ³újM†lÚ\nEŽJüA›„Èòüœ(#é¡\r¢n{ÏÅJ)ÇÊ\\fˆYËÃ¥üö“%åöd^ê\r}º’C¤¼ýN0ý­ò^…î’Fêw£þo&–>'èÎÈŽsM®ÏªL@í**®Ü®Æ;N|ç§ã,´Ó°&ånnƒGìÐ§\\¦Â˜Ï†ÒçÌÓ\"€°`/@GN„+7‡2·„ô¸@ð¯ÍëëLèæC(€û\\Ô¬œvÐ’…/1	kº…ŽH´îx(K1æ>£L\0¢|ŽÌ¦nJ2ò³I´uÏÆ4çþiÑêZüåþ5ÐÇO-,m\rìsîZîfÜâÓ\rÖ‚'Êsz¸pÈxJƒ\\9ü\0ÞPZëé¼ð>èé–hÇfæ˜¬üç‘)/8uÏt´n\n]ÖK‰Â§§ö\",Þ§‹Ä^ˆú=±h;í	0òë©–(Eómjƒíè­ÌÖò¯R{±ì±ƒN êÎ¦kãOð’oê€§Î”c°‡\"Ø\n€×§10|«`xâ”30Õ±_­ØÝä\$žÈúÒÍ§çdËOû‰™Ñ/±ÐìÂoqÙ/×Ñ³\0²ÿ,‘‚ñÌÞ¢ìÞærè¡ ûãwî–^hÔÚÐÎµöÓfMˆÓîØn±Ò”J’<HŽÔ)RFEQý²Opˆí,³\$MÿbŸÑèÖQj4JíAJV+t\0007°Âkìðhm£'¦½N&)èú©ÒŽ'ñ±µ\"ò›†hi±Ëÿpy)qBARœ™dŠ–êr‚ÜÌóxp„Šl¹'\r>}«È7±¨òZÈÒRµÒV\$òZ„Òºi’¿*¦|rÑ×q*Ú…é	ËOTíÎ‚å’zdÈælÄÃò+&Û“0åNè}rJ)íÕ .|ÌsE%ñò}cNÛO\"ÁH hgÐõ†~Þo56ÄpóÐ4­Ó£O7k—7¦ž©“\\üQ ‰ç	7ÆÝ'='MÇ9°—:¿Cvß¤:Èó ƒ’¯V{ÃfÞhúÓãu'ä¬mDãP	‘rÎ.ù„0ÜÓÎÿíW	m]£!ãþ>2%8×%!ÇÈ™Ô92@\$‚ô\"\$ï:S72d(RÞ;êÇ6ó¶ëd@ÉÑAç<p¥2#±Bè~y'Ó<¦?CÒ!	.‹CQ­B„¯âio/+Q°äÃwnï*å@Q]9qÄ°ÓAR/5†ï5Ó¨4èWHå;TF^nå3GJÔEBqõFbª¯2dSœ)Ó±kVHCµî52òM3ò÷è²ß+aBQ™&2wL§ËMëEM1—I¢€þQJ©!f{@´»Aô\\NóÙ0¼@DYŽyÍQ¨78#äü´X©:4æà’“ŠµÐ†)Ë(b5=Ï»2Ñ—9Eû#&ù‹î|ÐG¯C‹FŒéìš‘|\\¥Bh^\r€V¤ÂN?‹Aè<mSS0gRQ-ò›ÑaX­Jåg uÂØ\n ¨»`pÎU\${/K(¼ü°Œq!1r¤ÉO,¼OFÈ¨o,\$rÂë{K>tæÛŽ‹P^P†²Hú[Õ¡c„™Sœ´4oSYK2y;•ff,³VÒ|L%BYÕJ-„kS ^a„kè…RôÈOô…0ppÞÏLv0Š\$ö@)ò¢~•€èHíÈÄ+&5=æ|EŠÎ„ÓJÑ~Õ@¼PºMref±,çìª`›&	Ñ,îÍíHÒL¤ŸUÃfÒo55)M–\\D‹?X­ÐâìL‡gîÂ)Rýiö)LõMSU6”¯Fè+j¶ dërf¶k,ÔSg¯cKÇ]ž_(æ3Ç)G•Ë´'Âöü˜NPƒiÇ;çÆ|™Z'mî(¿n®:æÂ(º{ƒgl5bô°é'=^æ7Msq6pµDï·Wu}2Q=h-¯(ñ>¨4Ýµ{·heÐèÔfDL–šu\0ÞÅàä\r* ãqr®\0dTZðkÜ‚ÆDQQÌÜU¥.\$ð6jìf‚ï4ÒÖóú¶ ";
            break;
        case "ko":
                              $f = "ìE©©dHÚ•L@Ž¥’ØŠZºÑh‡Rå?	EÃ30Ø´D¨Äc±:¼“!#Ét+­Bœu¤Ódª‚<ˆLJÐÐøŒN\$¤H¤’iBvrìZÌˆ2Xê\\,S™\n…%“É–‘å\nÑØžVAá*zc±*ŠžD‘ú°0Œ†cA¨Øn8‚k”#±-^O\"\$ÈÀS±6u¬×\$-ahë\\%+S«LúAv£—Å:G\n‚^×Ð²(&MØ—Ä-VÌ*v¶íÆÖ²\$ì«O-F¬+NÔRâ6u-‘tæ›Q•µåðª}KËæ§”¶'RÏ€³¾¡‘°lÖq#Ô¨ô9ÝN°‚ƒÓ¤#Ëd£©`€Ì'cI¸ÏŸV»	Ì*[6¿³åaØM Pª7\rcpÞ;Á\0Ê9Cxä mËvBZ­!å\"L¨:Â‰dB@0R¯’\r‘M/d!Ö÷ÃDAÚL1p«t×°Ä4‡5Ðêô—E»6N±ga0@E¬P'a8^%Éœ«\"ÈìX‚2\r¯¬ƒxÊ9„Pèc¨à8BS8Â1ŒsæúŒá\0Ã0# Â1#˜ÊãHè4\rã¬Üèæ;ÂC X“¸Ð9£0z\r è8aÐ^Žõ\\0Ë’ô'	áxÊ7ôHçEÑ¡xDªÃl%?¾£4\$6Ï#HÞ7xÂB´y¥â<BiN¬HòE¸¤Â€I°B©¤‹‹j/E™h¨*LI\0†¬cÙ¼ÅÎY](9Zu•EKÌS‘‰‰Ir[ƒªP###ÌX6…£y\$’å¢E0¥PBDqaÖG“(ñLN½Ï€‰JŒ#¨Ù3ŽÃØ:Œ±%›g¤D©Pv'+:ƒÀ¨cšA‘+ÑTT&8ôJeXÂ’ïÉþ?N)+tec6OE¸JLœª>€ H #cÃ`A=Cdþ9ŒcÜøŠ\"cÌU%¥s jncœ½XØ4}\rÈ\$T=s].ìvE!ÖS‘mßtÃ»æýÀ=okß¸G{”3º+Û°Al–Ý°á8–ÃÞýõ­~dqt7ÂØ]lï|’wÛÃBü|È”€Pˆ«–eˆƒHç=ëÊœÉ	AÃw?ª‰äŒ£ÀéUÎuøç\niQcO©‘\\XÂÚtaz¥ØŒ‚SÅ\"Å’ V>90¶±ÚJFJÌÑ5nT¯#,Ëé6AB ÞÁ¼\rÁäPÜšS‚rÌxÀÞÏ¨sQáÐ9@@ÂÃ	õh°\$º”0eÌ¡Dˆþ«úd¥e‹ª-H‚5FYk…@ÐØƒZdWAÊ§3ìÜAê<1½ Òú‘\nMJ©u2¦ÔêŸT!ÝQªPÜƒÁr¨UJ±0¼`è¯•`\"Ñu^Ÿe‚°Ê¹3b„šçV:Åù\$KÃ\"zrJæ \$(óBt²´DZÓZ«\\&§×Ÿr°L	æ‡\0Ò¥ .R\nIJ)e0¦”âžT\n‰RD%N•J«UO9èFd­Hm\rx6ª°éÁóÂ€!•A†ö ¼\rjá3‡\0¥ti‘¬£–C‹M©H	r¼%R¢ø&‚¥úÃPÐŸÓ|_Wê\0004†Æ´“ü¾PîV° Â¤:h°%WÀ¶µ ‚\rP*\r­ÍtÐeh rBW–DôÉ™D'Hã˜îk€H\nàPUI¦‚v‘0:ã™~+e|ÁB<YÎA¬jþ+†8¿åÂˆA¤ú5àÎXlAÑ2;äÊÓtÞAtÂ4‰ê.*…ÝJÑø“¸lƒÕÂdNáÍD§6ƒT¸\rÁÁC(…£\$Z€\r¤1†ˆC:™‚z§öÂSõ=§õH0†ÂF Âfˆt'‰l4’Gj.Óè‡cZD)%-vvÓÜš4GLJ“2RŠaFDÈ›Ñu’G‰ÕÆ™w„\n	H)v\\uˆª.)°‹X „’:T*`ˆôÝ3§àÝ-êÚdRÅ’4ÎˆmˆY/Õàr~ž´ÙDÒò‚xS\n‡™¸£Ñ`ÆO0„-b°×ˆ{5kÝÕC4§•F²‡`¤/¦¸u2 ‰ËÉw4PP\"“im=©VÌW`@Û)(oÈ¦`¨/=s† ÓŠÂVKIy1‹DKàçr‰‹è—E¨–ÄœÑ@fÄÆ'xÀÙÛ&EÀëÖE¾œ¶xÏš¸q¬ßža*aáÍNtuãvØGpëEåèS¯±`Ls,(ù!µ´‰/£é<âtF8–2aDâ2%æŽº|•NY½Æ/Ô\n…u1›svhuúW§ìQúnØ\$v#ò~ìä34»,äß¬»¹dëCZ¥©3zÇÏÍÕ»¯…ô¿~Z8³\r¶y¨(QæÉFAˆœJ/¢€•EBhXí¡§Iá¨÷•’T%ñô…¿„‘žh9Z´v2×¬×ý¹ž³÷PlŒ‰\")Ëðê—Ñ,\0°dÎîŒl<ëÏä…óø6õLô¡Ýpºm¥±òÉ×¢&¢éÍØ’y‚’·bD ×xŸ\\.ÂâŒU‹4è=™]ƒä\"Ÿ˜ø-¨½¥Hvp7’’bN?IE)¥Uï§Šq…ÄÀPônˆD^™b vˆ¶§E‘7º%Ç\"”‹#{­_*@‚Â@ ·ˆ<4¦4ì¥-¤êMi¶žQ~•-Eˆ°¶ŒL0@Á=ÄÌ³QÙÑø6t§Äx€õ]qx\n˜dê°±¼/¿›š§^&¶W±%;i4;ÔÈ÷Xµh£õÒ	ÙóÛÜj¬×ª‘ãöY—Ž½‡ƒiƒÒ®»~µÑˆé¯\$Ã§õÏaDßsDº‹…”U\n¹D…¥«t±KZ‚ð@|0R	rût9oùUn­ö‰xéøh¬Ùœ	ÔfLÙe+Ízú¼ìÑ|¬^KÑÌ“Ü,HÍÞc7<Ÿ§ófNu45ãèœ­ÐcÌÎÛ•kþsgÙrèý†`Øî“hJ½Úú4ÿsÀþçTEÄP4ã\$|…°¼Ã=Á\$vÄ\"„#F8a7HØ*îKN›ð*ˆØÈÉ¡a-Ö¨¯àpoæÝÊŠ}~œ5ÀR5°:FÄÑghÎžÏ¶î®XºÌâÑŽ”É‹ÖÿA|3hë`ÑPwkHÑÇZÿp0’C¬ì¡{¤n3n6/NFä¢¼™0®á¬'ìô-ŽÂ ÃJ¾ïâìÐÄ×,NÅ,V ÆúÎƒöápJý\rç\r\npÓ\n°Öó0í\rÎ\np˜¢‹c”˜ã4<Â–×¡%pº)†&\"ˆ8ŒÐv'ÐDD8/âÌš/x©¨¯M,÷± =\"<fŠ‹pŽqÏ&+¢¾,!*™ñ<špýî\0]M†ô Pâp\röÞFÊÇ1-ÍPI¬Ý…É×KÍ	gYø5ÖåËeøÚï¡Ñ­pJÿ0›°Ø.PåLyl‰q¶Ðá<3ÁØBZŽ,ˆnád\$0ì/¡\"clmÃ¥NHäÏWkÝ0· Ññª~Ò£láÁ\nÆTÉMâ^¸8£™\"åã\"¬GG\\ÚK	#r@t`\rT'.>DBD7¯½ÐäÌM¡ÏÍ%Î&Ihý²làä2Ð2%\nÒzár9%¬S&ñ³ƒÂ!G½Ä5\\Ef™&0é'hÒ™dTbRs!pÎ©™*COõ2	úšàÉ P¸rã†±£ÌÅl-‘,nemèêLŽ ÇàJ¨Õ\nK.=ÄB?b=Há-¢›Å®1!jøb>®Âêg50+0‘èîòòûïª%O®û0Jh(\r€V¹\n¸\rg”A¤îd&FOêRVÀÈ\r Ì€…( Œ›¤þ\rªÐLêÈƒ@ª\n€Œ px¨‹5ãìîÀÈïÆúÇ6Ãâ<#%1Oèu/îYmÆ²,4ê\rÂpge°…Î;D;¯”2põs¶¾¢Äg¦ü#_<A\"âáÚ)Ði+é\0¿kXnàoá\$Ñ%2ÞFÜÂôÅt´®à½#<3(Ú+ÂÈÈŠ;@Nf¥èg&8dºáf‘pþËk¬<Ë\0@v#ÉŒb:6ý¦IA\\!‚QEý:s+ÏÙE/Þü0k2†§ŽLˆnÄþœVy@à‹äºÛé#FÃ#Q±ISòtQ.ÑG&FfêÁ/\0p`Ï§&¥ÍáfCËÆÁ¤¤`ª0¡d?2î±î&ÕQtÅQôDmT¾Äraj[0r¼gJETFÇ/ft´ly\n!\nMf6F))ÕFi–n\\£AØk¯)a00FŽeÌ<®¸!a`F\n&";
            break;
        case "lt":
                              $f = "T4šÎFHü%ÌÂ˜(œe8NÇ“Y¼@ÄWšÌ¦Ã¡¤@f‚\râàQ4Âk9šM¦aÔçÅŒ‡“!¦^-	Nd)!Ba—›Œ¦S9êlt:›ÍF €0Œ†cA¨Øn8‚©Ui0‚ç#IœÒn–P!ÌD¼@l2›Ž‘³Kg\$)L†=&:\nb+ uÃÍül·F0j´²o:ˆ\r#(€Ý8YÆ›œË/:EŽ§ÝÌ@t4M´æÂHI®Ì'S9¾ÿ°Pì¶›hñ¤å§b&NqÑÊõ|‰J˜ˆPVãuµâo¢êü^<k49`¢Ÿ\$Üg,—#H(—,1XIÛ3&ðU7òçsp€Êr9Xä…:9–Vî>ã³î›B°Â94-\n–†Šc`Â8ƒ	Š_\réª\")#jâ»Hô¶B‚È”C«¾¿Š\nB;%Á2›\r1+¾•-BÈ6¬ï¸@ö³ì³l†4c‚Æ:Æ1³éK¿\"Çc\"ôŽl¨îì„ˆ0ÅÊ\0æ;¬c X’ÀÐãÁèD4ƒ à9‡Ax^;ÎpÃÇ#\\±Œázâ¢#œ·.…át\r«*³ŒËVŽãpxŒ!òH ŽÖâÊã\nP«¬†R£­.b•c“¶¼¯këxÈ ô2Tî=Tâ.’6à¡Íœé±kP¯Ë8Î†„£\$:‚B#˜bØë*	eØÏK²»;Š@Ø8.ˆj>¼Ã|4¹@ñ¨êÐ„HÜ1¸Öøèƒ*@:£•bX:Œ U)K/â4L5ŒqˆÞ†ˆ#;Œ3ÈÑŠÂ\$Œªâ*¿³c˜ê9B’4¯Ï*W	­ƒRT‹•hä5¬\"bTì­B Ê”\\ŒâÌ†ŠÃ*9¥hmô6\r[ZÊŽcÂ7;‚ˆ˜°˜×%Ëœ4¯c“¬.­Ëfè<µBùŠÇtÐÝCÕÀ——8hör4?ÎØ§Qaî&¿°¹Å½\r–v<>K¥û;ÿ\r,Û;!¢HÛ!APŠ”o–K¹²Aõj¹•Å3µêûn²KÝ‚'_(ˆ›5‹‚r—¬o²Ñ›óa:>ÃÂæ7%4hæ’dÙBÔ)äJ¼°rÒt°éAÈ^å×¼´5°ŠÏã.×JàÀR9ˆ1ìŒÊã0Ì6G4˜éDÃ:þ*\rè²V7:P:ÈòHÍx-ãzÍÔKô¯Âä,áãfGuÆ2…˜R’	U\"^“žÁß-†™ûbRpÏòÿu†Lø’õoÉrÂÙúŸt¾ÝSHGI„É&DÌšRlMÉÀ;§\$èP“²xOA¸žÒÐ£!`\"Ð¹£õ¤OÙŸo\0‚=B”	zÒå°”‚à@Ý 	Ø4Í4Ë+¢FIQR:O©ü9,`Ê¾/Q&5ÝÓJkM©½8§8+\nC’yOq]Óº˜b ÛÐp.ªƒçB†B4ïx“¨tˆ¶“ß.!Ò¢D8D]Èk,ÄÓ°ò<•!Ä#ÉíeR40	Mš!Ó+  zXÁ„33~ÃŸ*~|ìÔ‘>¹6•\r;`!…\rÐ^¤`\rŽ¬µ–Ô± i\r!¾^–â„GŒÙq\"Ñ2DB*PàP	A8‘.GV\néý€ †£Jc›ž=¢ã4g\n!zEÉ—š£.•Ù oñl‡<¸°ˆò/€%™BµWeàTlù?òDRCò>¦¡C†àà¸ÒÊ~K‘VMšÆ8é¢OK*Î‰pe\$„<¹£¾P\0C\naH#G²4ZX Lì™Ä¦p]E›]#ê)Ïå¾jšH d å’@¬oŒ\"É£\$œ”’²ZKËƒHBe‚h6Ó†¼ÃÔC‡a““hŒŠI©5>'dÊ“£^BÃÉGm!\$D¢–1¨5G8¯C†GÏÈm‚pPÃêÉQ–&¨ˆ™âHÑ{6‘'…0©O›dFll\\_zmdmB\r,œŒ\$PäzRÍa²Õ’¡(ÐÌYU!_¡ªž¿c†“¤YËsf:µ3£êhÉsIˆ²‚\0¦ÏˆüèU…€`©5)£òoi\rù\$@Í^Hb>æ¼®7†A)'x@*D—×°t-Õ‚äsJãÈ¼Ë¬)­j³0ÒÊ­¬W8ð~oŠsxlÄæ†ÆVC‰r’,‚\"È¬&¹×;'nÄ1ò7\$…}ÃEqj`Ò4Gò?Áåž\"’¸K9†žÔ™‚Y†°[y\$mK¶ò^DKC.P)”}e”ÃVÅªá±†¶ÊGœ^,qØ¡\\\" Þ’šnñ	\nÔñ´³lh'ü\\K¤@AÉtèdGšsV`†ë:N°20’‡—»á—óB”¼w”¿„Ë½~ËPLjÝ¸ÀÒ—¬ßooÝ\0	Ä^±®z‡’(JiuŸçTÉèW²ž•´Ö9µÁ“›&¢¬š¡gšt—\0¡Š(	dØ@„\0” âÔ•™ån˜ èÝSÇgH—;gˆ² <¬æ	§,†yS\nüjpÃy›2Å\$ü—»Ð(P]fJ)ÛÜŒ’%©_æ\0W3±qYq 8Uä‚\r±J;a*@‚Â@ ®¨\r¼úÚƒž-Ü—¶€Ðš s)KÕfòœ³VM(A^p ÓÃ8Ng¿€3dtöñ3B5~>”zQÂ§\nu`\$*ñV‹Æ§)‘ŽÓ®@ïAw\$äÜ\\Œq“ÊÑIãÄåcq]æ*Xã+y4|Ðø± ë£tŽOÍyO7æ+3¦ð{Ô_\\3ªô–ÛÖ9UFê9Õ‘¤CòÙ‘1:a¬¶=KøOŒâ#°KöêPÓd¢Éº‚†è‡,·0ÀWpÕÎ†&%ü€æ VìdxÆÅ€Mg#Æ}¤NÒ0*òFœ€Ô-úZ‚NÈ,…/gªÐØÒõƒTaº”À«ÙÛzOzÛž¹,ó«_/=o\"tŒ;rû-0âbYÑYD’{üùíZç_k\$zS>^{šØ¼‰_¥ƒñzš½—²¸b\"Y‡»/Íf5øIùlƒ;|pÔý…%‡pìeÅƒwö¾Fùg¸ /¾ˆ6ÔbP»\"öÂ:5í8%8\r%¸½ª°[ @T&ÀRÆ¯úúâÔÜ+2qä²Æ#°\\TÇL†mä\\@/¬ùP8Ça.ùÆÊúW¯ƒ\0ï’úë&–Úâôµ\$°ì¤çŽÃï©	,0tÛ%K¡^æÎ7}\0Î[0Œ?-±ŽQšåìšð¢úpºÅ‚%ír©B\"øeÀ—¾<jæ»JQŽ=\r\rlxpÅ\r†âpdÔíRxi–7â:Õ°äT\"ûi,„:’\"<\\‚\"#¤z#¤„}¦^Ñj¨gÜ#`òx‘ñ‰ ê=¢–‘DÓ®î7ì‚ÜC@‘Ãì(¢Žb®÷ÖRæKâÎø'Ïƒ¸¢ãü,.rù-dÀí‚ªå®VíŒ@ÌþÒÏ‘\rêŒÒ°ÚáMöQ„UêP÷^—ŒzÇååc¶0-¼°‘”Ê/pÛ¢)P‰±³¯ž—RUn°#\rÉ‘ÒØÄDNj§X †<ÂÕRªdZi£ž=Ð\nÐÊÉÑ–úÿ	1Šµë\nw Ñ o¢HkbŽñ…öµc·\"\0æRéó!PTÃ™mÌ|ãã\"’;Ò2Èò#€ò8ªo¯¥¸×‰PÌöR`@p‡ªØrmÆú—’,8‡Ø‘Õ#Ò'MŠùiñ¼;X@ä)Nîö¹íÐABdjÊ ðÒ’«*É\"HÔàÒ¹âü-R\n g¤²0¼,>TBþYƒ3\$Ãd(%Æ rÝ²á!M<ü’í#¦XÒâÉ8~Å*6q]!âD€²ÞXÈ˜a©ˆ	Òë0ÄQ¢_P„æ1s\"0œä,>\r312“61n”e*\r€V°\0Ò`ÖtCêèEæ2¥ÈP¢jÇÂ;\"z¸@ÚÀ*:~ ª\n€Œ psÈ0¬@Î\$“,ÉÂ^îl)Ž!3Œœ#Ó”Ãÿ.~ís–¤`Ê#¾[Ä°rŒppÏ¥\0@šB²Æ&\"\"¸v€8ÅRb¢,bØ/dp8­@Uc\0Bü3CÚ²óØ96Ÿ¨\nÙªŠù`Þ·E\n ƒJd48„B%Ä‹\"O¬|ÕFXsÄ ô^Ï3Ân: ì™kÒh!B›B—˜ü)\0ÂôRø´?.‚*‹\$JÝ4UF/… LBÆ€¨s\$z2d“ÂâtD dm\0”`Ó/Â:E[l\naUqF³1fúeê@ÂÈhd	'ä¿Ä\\ÐàTº¿à˜ €çDb^™4RönÒ€Æ ê\r 	ôŠG6=À‚-©Nó'¯bÖGl&Æ–\n”ME\rd>ô]:\"‰KeJlv\$CQ< –\rôi=Í’>àî,‚ç%\"´æ@!³ Ù£\n2)£ÍO8–";
            break;
        case "ms":
                              $f = "A7\"„æt4ÁBQpÌÌ 9‚‰§S	Ð@n0šMb4dØ 3˜d&Áp(§=G#Âi„Ös4›N¦ÑäÂn3ˆ†“–0r5ÍÄ°Âh	Nd))WFÎçSQÔÉ%†Ìh5\rÇQ¬Þs7ÎPca¤T4Ñ fª\$RH\n*˜¨ñ(1Ô×A7[î0!èäi9É`J„ºXe6œ¦é±¤@k2â!Ó)ÜÃBÉ/ØùÆBk4›²×C%ØA©4ÉJs.g‘¡@Ñ	´Å“œoF‰6ÓsB–œïØ”èe9NyCJ|yã`J#h(…GƒuHù>©TÜk7Îû¾ÈÞrÙf²\0¢–6À“·°3„øÎ3¼€P–Š j0ØŠ;I¸Î ¨ÍÚ::¢`Þœ¹+ð	B‹ê6ÌA€P‚2\r­K \rã(æ‹è³”8z,0ŒcL˜'\nu/C˜ÊãHè4\rã¬^‚ Ã˜î÷Œ`@ c@ä2ŒÁèD4ƒ à9‡Ax^;Ër‰Î€\\÷Œáz| £œ\$á”\r¯|vÔŒÏzZ„-!à^0‡É( 4­ªDê»h*€¡ îˆÖÑKÃ‡\"PÉ½£„\rbì	.zhÃ P®0ŽMRpˆ„£#\n<¹àMKS¹èˆ–7Àîè”Ÿ1ÞÎ0\"Z|Œ¹‚„7Bu\0Œ„22úPKˆ#8	ƒèÿ\$RzC0\"@·'ibn0…©j0“:L˜\\®‹\$(ÊÚ®‰Â„ç¥ðò^·	-óÂÝ¿£pê¤RÃÙOv)Š\"`ß¨ R`Ü0+Í(ÚÁwóRj@æÌ%®ò)c¨§ŽÈ‰Ä‰ºµÓ4˜³¬ûzÅ£è©~[—ˆMJæºßÀV!‘ÁÐ \"YÕ’âŒ@Â1\r‘Ú”=áw¤iQ>›¥Œ£Ãž7&K“Œ:Ô'VãÞ·Úã]ä<)5w€­Ùª~·ã-nç0àPÙ®ÃÈ\n7IÈÞ3ËlÂ’Ã»ìŠQ¢£¡¬*n›#oèä1¸YU‹	ÛNR6ü')\nG%&\n0AÊ/V*DË(­ï2Õs}ÂsÄP0®‚è›\$¼S–²è5•Ã`(ÃHÿ¼•ìARW\$Í¯Y@74HÜ˜IÒ„¥*JÒÄµ.ò÷0¾\$Ì7ã\"ÒŠ+LÛ8'Ã# –ÏSãe2ÎzŒ¤@ìéÐX|¼2æœ2ö-¤•¡LìÍÚB?`û)GòrKI©=(¥4ª•ÒÊ[K©}ä&0ä™S;Ujíeò&àæ0Ä:5@ë9¡4jà3†T`¡²\rå™w´tL#‹q¤ì—€Ì`ÈhGhÁ<´zù=ˆ!É:‡#8©ƒf9áÈˆTbŒÃ0u#á±	š”xŠB?GaÌÞ£°Æ“ßsÐ.!±­—äo\rñÀRDž<ÃÐ@@P&¨(‚”\nIÑˆ‡e¤œ˜Ò¤U\n²~:æôßÇã0AtƒF¬œÎèJŒ‰'¤þ\$/('ål\r\$è'4NÞÈ*25æî5K7ô‘RGJ˜;†€ÒÊB!éQÚÀÈ•Žew0ìŸ\0†ÂF•:UAfèƒA7Bq±<rŽa–(ÁœØå‡¢ºï>ÊPÎ4Ä²Œ´ÙTÎrQ6¸&¹!8:Â”IBQ dÜÆJ\r&ËÐvŽI0!„l¹‡}0\"7C>’uQ‰-ég9B\"á<)…Hâ×ó'±°øtÔÌPe\r8ÙöÄgìêBÔ¤µ³@ÛI˜,l‹«ÂT 'Ã“Dæ•»IÛJL°F\n’Ýó#&jz2Çôû“xdéCFœ5`Q¢h\n	á8P Tµª¶@Š-rX0,³+öïé¾V”49Sˆ®—b\nRIý@© ©%¤ôGQlé@ÜX\n‰h@ˆÙƒ%ËÑž8	VC¶ój7€Ò8ÞJ³è‚™åªŸS­A’èhƒD¥±Žý±&zÅqü¶úÙ6¢~±î‡ë>ÁT+×©ÒAXèD”©éq†Z6GÒBnä‚)H]Ì!R6Ž‹Ñ!\r7bñ…0ÊHbã/E´:ÎúH\n	Lá’pÒi`%¼è‡~®‰ÄP°¼ÝÏEpk±˜:”9¨lkYÈI 0Øˆ°âj_rñ\ndÌž¨ÒOK–l‹Ø¤ºÀeñjäù\"#cñdA\rØÖé¸nÐã9>¦•Ù¼“±AI!•žaÈ8i3ÌýŸ\\tñøQ§@<»S‹ˆµ¬'e¢rJ˜‘ ¦8å°äHZ¦àƒ8¸ì ²Ö\\ËÎÜ“²ŒKÖÙ€IJ¬ÃŠNƒPe.‘ÔÁÐ6BA2#yø—FÈUW³®mÏX—>Hœÿ¥‰v˜	šUm€¥Ð©´)\"dV¢‘ªŽ¿õY#¸ŽÔ‚w6PnfÊ”J®ñ‘É^½?66äkxïÚ\r9šÕ„#¡£’• @€Ö‹^¡Ž`jÚ{W%^âé£ÎõÕYLTæ“#ª¦L…'~ò'5›ÙKº	¤\r¶¬u‹›K¼^ò‘7šRß¼0G÷Ñ;¶ëï~ßÍÔ¥	Ý† €“Æ6IOÓ¼_«üŸm£ò°ç-×îÜOàæBŽÛ.GÏ¤ÝÃB4­\"­<Fár®H°xÂ˜Ãd¿ƒÛ^~•¢'ÃX…W+g!LÅ‰‡ ¦¿¨K‡jiŸ\ràvçLZv#Ò)\rz.ÐŒÔýÑÙ'5”\\>×ÚŽ³Ãy¿Nœ‹ÿ&O¾´NØ‡cÐz¡k¢x·¢t]_ÇxÂ±ö{m‚e(KÅõˆÔÈÛi\"y¿zî}ñðÓ~E`'>&‡(ß\":«1BøˆF<È™3*¥yÍ²©qà0¤¬A‡7dB9›´Ëø£yäQ½¿ sÐ«#Ê©W@]ïÖMük¼†\$Ìt·—åAŠÔ}}&{_wnÂTŒ´ïü¼tß‘ñ|7\\ÊÄääöO'ºWÍ\rÒK(±òÃOa:^Ùî²wáÃ¡%ÃÑOòNg„ä¿i(Ú™£«[ÜB>FT(ÄÒv¢i¶ O\$2ƒìDÂ2RNÊŒÏ²ã­1\0ï”üÏÂ8lÎÉ°áñ\rÈŒ%F-ÏÖ¹\"Î£ZQ¬­\0ÎYÏ¦¹P<\\®p5DN\nCœ\\£´ÆZíÏÀékuløÐ Yìw.ìýÔQåòÇ‚\"´Y0b/ˆØúÌ¢Êl†ËËhé£ü@„ìs	°©	ëkÏèh”Œ—MÂn£¾BþUp8”îÚï(È0%VG@Æ…çGD:*ÔÂ|!êGÍÒßNÞÑB\$ †k Ø`Æ- Ær(î5BŒ2Í\$òŒ@\"š%c8Ê\$nÿl®†ÀÞª ª\n€Œ p\$­í®ì6„\\’DB±£vâi¦#m8×Å	mL8Hô0+ž…+„Çí\"Qñ\"3„À0‘Xì¼‚ˆX ÊæÎb„\$(ŽúþöRB\\—Å±\n2ÒÐêpððROn_Îì[Æ\"bí1®\0üoN˜ûl.5Î‡ámþîÐ£QÈîÀÞ6&n*ª6¦úRE¬¢Jfu\"hâf`\rÎ,ë¥Ú'*Bb‹O!`@çl8ÊˆÄž£¼í«¦F\0êø`š?Ñï#»#èz_ÃV£êËð’;â4-Ò?‚\"\$ÿ˜’ëzêž‘;Q&8‚Np@\ràì:\0î0ãŸl„Žã’¶`ä½Pým@";
            break;
        case "nl":
                              $f = "W2™N‚¨€ÑŒ¦³)È~\n‹†faÌO7Mæs)°Òj5ˆFS™ÐÂn2†X!ÀØo0™¦áp(ša<M§Sl¨ÞeŽ2³tŠI&”Ìç#y¼é+Nb)Ì…5!Qäò“q¦;å9¬Ô`1ÆƒQ°Üp9 &pQ¼äi3šMÐ`(¢É¤fË”ÐY;ÃM`¢¤þÃ@™ß°¹ªÈ\n,›à¦ƒ	ÚXn7ˆs±¦å©4'S’‡,:*R£	Šå5'œt)<_u¼¢ÌÄã”ÈåFÄœ¡†íöìÃ'5Æ‘¸Ã>2ããœÂžvõt+CNñþ6D©Ï¾ßÌG#©§U7ô~	Ê˜rš‘({S	ÎH<¤¨Ú\nhkˆÉ=oj9n°ÃŠãÆ4ƒºšâOÓþŒ P’7%ã;¶Ã£ÃR(çÈàÚŽŒ€P‚2\r«Òé'ê›@Žm`à» pÆ’nø@ëµÐÛü<m‹5´Oèç8®ˆxëÊ3¡(:7AÐ^Žó\\˜Æ+Ûð»ázfŽt 2áª#R²¢7Ë°Ú¡+xŒ!òj¿¬	š¦ÿ.CW+9ŒjÄŠŽe:Ž£++Ã¼†“Í£›ýF¶¨í67S´ø'+Ã­44¥pƒ¨®Å(°J”ŒCÊVÖil’BXÞ—Àb ò8C¢Þ6ÅcrLêEÃ«T\rÉäV»Å0Ì®0Ž£b;#`ë‰jò,#£uq1ŠuºÈ‹Iû–º¸–ì	!¬ˆ‚3%ö\"PÃŒ¶#”Æ!i(@ÂŒé\\]s×—#Ú6É`æ1·¢˜¢&{Z9BP¢ë}28³œÞÃOäT¬ˆ§	Œ³ÜKÆM”eSÝßŒPâ+˜ P¤2Âj\$<6Çc•Èˆ£Æƒ¡ÔG™22.Eˆ‚5Ý\"¤Ú®J¢¦»	ž°–*¸«°Œ£Â‰ ¬Cšj*`#£\$“0ŒŒ4žk¬È	ˆüæKÐÂ4ÎÈå\n7\"ËýŽ.ðíµK3(+¨–\rã5ñ&¢­YÄtpA=ÃÊ	Â£OÖÎ¯C›£HóÃÏ¿¨«Ò¨”Ì¶pÊaO+Ë£nØ@Ô7ƒ8Éµ³Š§<¸ã¬ƒ„|Ê†º#Ò4¸Á¦ƒJÒÄ´§Ë²üÂ;Ìq„e3ŽSLÖ2,SâÅ8‡ßC¬:;óýÊÓOõ<¯**›‰|¬þGŽËt2ª¤îJ‰c˜2äÝ\0œuJ›ÚëFp•á½d¨öRÊ[{©1&GÆ“Bj\rÉ©³(dûÓsÁ% %’>kNl€ÞJV{L*\$\r9Âf	ª~ä‘Í“òˆïÃ*~x†’–ZŒ0T é\rs¨óÆÂÉ¢!¯!’Â”Yt.Œ9ºPØéËÉEI! •E0æƒÉ`cJÄÉe•ºÚŒ‘Âl­œ¯G’ŠPC#.@\$#\"!#aæÈ5³S¨AUw@)câö¹ÞbÏ4a¤Òšx(h‘áS6hÝ!˜@Þb^E(²A\"¾dó„x‹Õü¤2*›Qü6\$°½œ“TôæÉ	¹²ð…\n4mŽ+`ÿ‰V\$g)… ŒOŽX.…E(qÈ9‹‹d¯v-Q5&ää“ÔPÜ,8D+è6Èl6#mhš„’(LÑÒz‹@§Rg\r‘SJÁÅo° ÌS	ëÎ|s(¢†2^‘Í‰³M¤pš…\0žÂ -iÒÔ¨²›=æàk.NÈ™c_=¤nFx‡)õ4©kazIà¼)TøI«@¢šÂ^Le°b/\0‰1@Ìi‰a¥:á*Hb¶TZ<‡`‚‡¬zŽ!5ÅØ2—‚ŠC\0\nzFõÀž\0U\n …@ŠEë€D¡0\"×ez¯Ö:@a@êG`›Á3`¨tÜ¿x•ùÛ¥¦¨ì“ôFÃm7\"áµà©sÄy­n™óD–4æk3PÉû´ñâ0Ôq¥K4fÊ!ž4‹R‘‰b(i‡0(ÇF‰I*—:‘ØÁ²bM7•“ú!©2ƒ¨fŠÈ„Ñî6,I:*E’”9Üâ«gŽª©1'1cVËcq;¤…IE/˜2Q\$­ÍË\\yNa7QqØ¢RiC(wRêfô4<XÃÁ‘CäË”VH“ŒˆB)‡0\"òûv&9•Žz†zÎ]i'·f0»¢+—‰Á8öè0®ð CaòÊ%è÷ªÃ¥°â{(`*Þ†ô~ª¼²Ä:fB‚aîFx±w×P¨BH0†®\$†¥\"9\r\nV\$—ò r\$@”‚ðA™¡W¤Ê™¢·óU…€Ÿ¥gšCTHc¶ \0œÞC\\ñí™Ò&s›J)#b¼7b_—cóbìf#è(pó©—W9…Ï#—DIgÐZâ‚ì×”ó‚\0ŒZ|9êå ì¬MNX:cs\"ÞQ‰)Ü‹’KUê10Ž‹ó_–:ŠK¶Â6zŒ’!<Z‹	¨V\$õ}\0Ä«3‘E ”Ýý}·5~¶;†«-Ï2?WX\n§ÅQ'—l`K‘/ò,¯GB¤‚¹RTÁ¸•2FrWxIU´ÖûÄÙûÀÑAS±*ÖÃe4#Âmw§‚Z\rKU	_§÷†v•Æ±Ðkã·¦ÄX¤d6áÏ8©#•l0ˆSƒZ!ö¡*ÈOht–<:ÂÇniÏÅˆB'Saà¶Ê¨øWŸ¸ •,5Á`	è(`„¬ªsž€í’Gµ¼ZØÚ¦lAÎ©?\r½vÜt†RsùùëÌŽìñ²Jîõ®™·–ú\nd_©&†Í›ŸvŒûqÿvÙ˜ß¼ç}ž»ö^Ã¸}Ïu»_Á€V¬¸xVŽÍÂüW“ñ›ðÌ\$XkuF„t5õ“HÂ[…p Ø©m#8„‘ðÜtQ™!L½`Â¯ö›:D°ŽzRYý4z>¾ â¢:kâm¥?~ýe˜o%Y¼® C8XÁÔÎ/[´5ý`ƒ´dTÆòý+þ¯l6Š™óž'ö©¬˜Ñ2\"H‰¼WÇñ|†‡ïôån4ó\rÔÿ#’‹ÎÚó¢jÿå”TfJ9G¬DÙíÆçnPbÄ<‚…ê_€îqâŠ:Í0[Bš\r#¾ÇŽèÈìýï ðêNÐýYs/è\\…Ì±ÐÃPLÇÐ[l2SÃ#Æip)oÐ&]æv›Ãªé¥ˆÅL8ðTâà¨Ä¬Týnß\n®äé\n¬RÉe9P½\n0ˆ]à¨'D;,ADg\niR=L’Ap°áá\rŒWŒøP`Ê3€æ äZ\nD–äã!bf/c˜Cå\"!eÞW#G‚¦5\rÈÏ±î€âŽbÎŠŒ\r\$~!¬ÐvCTYbú\nmÈ_Q>áÚó\rNU†R*p_ †R ØjT=Í\$k£…®ˆrz&BÒíþ1C.Ê sg” h²v@ª\n€Œ pn§¤\$R&­Üð‰\r«&„ -JÔï\0ã„#‘²Ë #4(\">\$/ºŒâ ¶…ü`š†àÒÌÆgb„ç %ÿ±l¥¢<> @Qô\r`Db±z±CŠ6XµÆZ;bj	„ˆ¤ìiÆðØPJ°ˆÒg#xÈ¦²âš#(\$…²YfÜãÂ:0°Žˆ.B€•2P½RVõB%ÃŸ#Ãò6Ó%HŸÏJ¼òc%QÀ(°Üâf*c83ÂŒ8Q0'KØÒ†ùC†S\",]±v\"Š´Ä8ÝDRäæB`k`ÎŒÄE&\r, ¬2¦t#ïÐBE(@k'Eº*Q¸EÃ¬\r„.é*R%.à¹bV/ ˜2˜›’l(dlåD†,r*íd;1:\"Å}(Æ\rëZ.ëâe€.C|ìÇ%Fî	\0@š	 t\n`¦";
            break;
        case "no":
                              $f = "E9‡QÌÒk5™NCðP”\\33AAD³©¸ÜeAá\"a„ætŒÎ˜Òl‰¦\\Úu6ˆ’xéÒA%“ÇØkƒ‘ÈÊl9Æ!B)Ì…)#IÌ¦á–ZiÂ¨q£,¤@\nFC1 Ôl7AGCy´o9Læ“q„Ø\n\$›Œô¹‘„Å?6B¥%#)’Õ\nÌ³hÌZárºŒ&KÐ(‰6˜nW˜úmj4`éqƒ–e>¹ä¶\rKM7'Ð*\\^ëw6^MÒ’a„Ï>mvò>Œät á4Â	õúç¸ÝjÍûÞ	ÓL‹Ôw;iñËy›`N-1¬B9{ÅSq¬Üo;Ó!G+D¤¦y¨Ù°G#¶Áâ…[NÆàQB<ÎŽC#0Ž‹²<2·.[z¶?‚‚È¢ãsœ69k` ŒƒjØ¡ŒƒxÊÑ<îpæ:¤kCœ0Œc>ƒ.A\0Â@2‚ãHè4\rã¬Nøî´`@EãB|3¡Ð›˜t…ã¼¤1pÒ.9Ë@Î©a|z9Žqü„J(|6­ÂØ3-Šf7Áà^0‡ÉH¬Ÿ·£\$b\nÊ‚\n:<#Xè:ºÂ+RÕŽÃHÊ;T3TŒ@­‚Þ'.#\nãä7-ƒ8æ†Œ\0Ä<¤\0HKPÔi>%ð¢-\nƒÈáUƒhÚ¥À®¬/\rë`ÖŸVð“2ŒÃê69Ã²Ü:Á¸Ø3B2*–Sƒ\0)Œ5²—bŽ”âäÀ§nðÐ;-èÚÌ¨£0²ÔÁ~É! P¨§#íÎÆBC\$2\r”í£czðŽc\$ÀŠ\"`Z5¬°„:4Ã‚.#­ÝC£Õ#ãtz\n5C+\"	é-d™0Ããêç–äâ‚ÓD¯+[\0\$£…ÙB¥¹ó”eLH¯\0V=A …>*r »/*#DÒ)z¢0¢„\r&¸2	\0ÜƒN›Ý@)n8'&»¬\"@ƒ~ºÞ¦p˜¨\$°„¶e3p#Œ«+´O®Ç´©˜Ø	ØòÜ1Ì\\åÃ6‹¶PA^Ã~åR¨¬GÅc5ŽŽB»…@R­°Â¶0ª%C+GC(P9…)Hª:Bƒ:×¾­ˆò„0iH¨4^Ø€Ž±c{JÈT„1ì£K€ÈbI2Xé&ÉòŒ§*ÃrÄµ.\rÁ|:¶ÍÿHD}p%;9N‰I†LP\\ßxŽpZ0n`*y	¹¤nTÐ”’²¢j_@\n„¡£ Øÿ bCH©î¤Äœ”wJˆeò¥ä–Òë`lM‘÷&fxÊÁo/Ð€@­Ë!Œ7ÍZœ0Î‰Ù«1‡9Y‡\$ ®³øŒ :²lFiÃÍôÕ³3Âp4ÏÌ¢àÆûQ¡4TDb\"¼µn¨Cfo\$:ºDÀé˜+½vÕ“(ºÖÉg\\’ÜÙŒ9s)ˆéD˜Â€‚Œ‚EÁØÖ'øœH!ÐP	@ÈG¬OÊ	®”Òâ¡ûi'åü”„4àEâú&MÈí†–pKœYDÆ‰?\"\\lOA}wAœ<†Âü‹Pc½wêy5¦Ò<µMšö3&­?\"ðæQS±Fé¨7tò@F 4†0Ñ\rÌÁÎ.ñÚ=,bƒ.åì¿7¡)… ŒâCzïüÁ“žÈÙ)‘0dfPÌ’VSÉy12HØ’R~·C	ûk§Ô9Ebû>ßû†€d|Ò‹€ÖÕ‰HI\"!åÉåC-¤Ê¡FéøŸ™E1ì&/AòÎB˜Ð¢3¤f‰—2iù¤ik}¦©ðËž( /„ vÚL`nHEà¡®O	ô‡)‘hÓ”Vœ	0gP“²—â| ¥sÅ1Ä5™\"8G‰¹\"\$…Òœ¦ÃAi&`ª%„`¨™g¬ýŽ—JS3ˆU)e!`FpÜ¸L \n@\råðœ¨P*VQcÂ E	Ê‘5[)ÚÉû?ªj<·“ôeHY¥¹hZ—|L‰8 :\$h†È×Iµ¶ä]fJ¦ÀPU—’øµ#bUYƒL5Ï €†&a™Ø\$1>'‹ŒÓ!Ûh×\\12lÙ•Ño¬´µ£¬Ð*ƒSír†9¡åtJJIiŒÊ*	wÓî®ká~B;%<äŽ”•¼½ÉiÀgì*j™yÃHzA™ž»TùkPD=–ä•ØÂÝ„Kì\0QJ1>¨µíƒ‰‡1„´À(é˜¼1aÖ	d~ÓL[ñrµÍÒØÒ–Ma—		-áP´ß³‘,1ãP©µ èŒd•Á)kÔ¾\"5ŒÆ]AI>Uá›ÍÉ:fô1(e Aa Rb¢š#4) R-±\r&ùÅ¢xPKz§\0¼«è#2¡Ðæ\0%–æ\nŽƒ4A9Á<%¤-bà@¥Q!È„ÀÀ£h.Ò@ƒJimbÊTÓzvŒ˜‚˜Ä²ÿCÄáê\"yr4eÔ!ÓH“Í&Áv‰ëGëÍG¥	HKˆðÜ†”4s`wSå%\n2:GØÔ­[\\™˜‚U-±@—P#¢`L\0W¡Š¢ÐÊãloÎÊˆ\$à·ÞŠÕ\0001fÏ%½>š+ºj÷Ñ'_­à´(¥ìNÉ‹3Ÿ,¾¡—ò£@RÕ¨€ÝX¸•I“Öà81âu8Ë_â»Œç¼lPl¸ß‰÷S©\"èPÊZåœŸ—ÔÊë-/œ&‚lZ\n5*h2PÂü`0Ñ\"jÄ0ÿò¡2\nõ@]4™Þå¬uº§Ol¼ñ; u‹Ž+“%€ó-«{tVJÒÏªð@\nÑŒ-®„ŸÆáqÊeÌTW=]*ÅÝîSÚSD”ÓHá»©)ðvLñ¾oÅî§‹@üPÔs-“£€V\\Û¼ÕýkÓ©”´Y4Ú­â€Ÿ4†ü¦¶óîËÐêŸFtåbÜ¸ü¾Øz-¼ç*ºvÚOlñ9G0c›’Âû\\‚Oüçå{'Wþrá¾7ªê¹+ýNò*ÙV÷_µ+4…þ´\0Š…¦ÎÅ¦~³‹bP¥¤/ ÒÌÙ3É©ãDâ¿\nø¼dûÞ-¯|øâÞÆÁJÊå\$0&heìr7,Ü-†í¦.Ä îŸo„òÆ Qp\$â®üº!î8ç¨7Kd¶åÄÀŠÌs\"S¥póŽÌ¬PTBO’h¯–d#V¬À»&V)°n½4]@¦\r„t]@¡‹ªT(à\r<“0.å”:ÏNB.S2Ë°¡nÏ\no6ò”÷ph#L<®¬?ŒrGƒØ( Èqäe+´0¾Z„á¶;kÀ/°Ðó#PºVŠ8ðNòb¤òZå‘\0004P¹l–ÈÐà0‘m@¨zÅúæ0”;ìÍýÃðì¯†%#î!.m\nÄ_Àæ3,·\n„ìö•©^gC¬È‚œ¢ç»¥êÐPä¼)º0‚ô±m¤V(jPf	e\\T	V …Ô íEÔÒïDÓO`Õ„ÑbÕQ¢¬@†P\0Ø`Ö`\"ýèèÌöycJ4ðZ5‰’Ú‚èŠ#NŠfü§Àª\n€Œ–Ê\réÔ%1œãmœÎÎ>Ø1œæ\r¾¯câ&¬ÍÀx\"æ`Ãb)p»Í®ê¬8®J/\"ƒŽ®ãÃH8qÎ©.ÝK:j(mË¯\$ŒÂ\ni.±KÇfªþÅŽ½#Äî\\¹o¹ÄlDàìb\nærj#õ'Ø¶ÐfçR&Ëšï¿'Ê˜5Â†÷Nræ’¡)2r·f2&¨²!®l7°FÚEÀ¢Ë®#2± š\râÈmäc#lT_ÜÜ¥\$î2Zèš–¥ e2²ÃêŠBâÚ¶Òþ\nfJ!ìG¥uRx]@(†Ž¶#%\n–ñ„1¨³Ò˜0\0Þ¡€î-+i È™â:A¨}'%!Qí`";
            break;
        case "pl":
                              $f = "C=D£)Ìèeb¦Ä)ÜÒe7ÁBQpÌÌ 9‚Šæs‘„Ý…›\r&³¨€Äyb âù”Úob¯\$Gs(¸M0šÎg“i„Øn0ˆ!ÆSa®`›b!ä29)ÒV%9¦Å	®Y 4Á¥°I°€0Œ†cA¨Øn8‚ŽX1”b2ž„£i¦<\n!GjÇC\rÀÙ6\"™'C©¨D7™8kÌä@r2ÑŽFFÌï6ÆÕŽ§éÞZÅB’³.Æj4ˆ æ­UöˆiŒ'\nÍÊév7v;=¨ƒSF7&ã®A¥<éØ‰ÞÐçrÔèñZÊ–pÜók'“¼z\n*œÎº\0Q+—5Æ&(yÈõà7ÍÆü÷är7œ¦Å,Ië“()Œ£’h9<	‹£3É\$#šR7¯\n‚Å7#ÐÝƒxÎãcK–æŒ+«–¾5ƒš\n5DbÈºÐ+D7 ©`Þ:#ØàüÇÆ1 ±Ü3„¸Â¾PˆÊ¡\r# Ð7Ž±êŽc»ò2\0x €Ì„C@è:˜t…ã¼Ô1xÓ¿OÈÎ¢xá*JÌ˜^*ò^È7ÃpÌü§£ Ò7Áà^0‡Ê˜Þ5Œ)‹D-Â˜è9£[Žµ«ó`-.¨CB†CšM;‘@‡´ê‰‰Ï¢È2C\"40ŽHü†Œ„£\$\0005€M{_¸V}\$Ø¨î	cxØ:ª\0*#…˜7¨‚ø÷B¢•‰#pÆÈ[.\rn9)ÈJ“©A6ŸŒ+UH—€PŒ:¾-:Ü £ƒ(Ï õL±`PÎ2HzŒ6(oH§0 Rz6±a\n1Â‚`ÒºŽŒ:R:Œê=Öƒ§L €8oÔC½Iíþ…¡c¡orH>nê> É\r{šÁ»ÒX¦(‰€Tn;²¶ãüç=õ]E\0N]'ÃzuZ9ÃItŽðšAf÷#ÍìR> CL6*³ƒˆ.ÁÆ^Ao¢>5Ù@P’6Çw@\"§[î:*ëºJåž‘’ÿj{S!-Y°ÏÄ®›¬¯¸ @¨ËŽ \\×9Ïsƒ(ðƒÑ\r9¦Â£\"ƒ>‹ph@®Hõ°ò:‚ÔŒoò3 ÍÐ…7×ÀŽ2Û-.»Ce.ò ¨:ÎŒÃ2E¦Â¸óÃì3dÑniZZ:í0ÖjÊŒA¸ú;Ã³S_Cç)jæ Øq„¢å…ÀO¾	W¯6§Î,ßKëgEÙ÷™Çäk£v\$1ü¦ô¢_ëÿ€/ò†ˆPóìgp5øÀ‡æ¢ ’K‚ŠùýG²öá:%hív’~CÉ°Da',’EÚýÛ’\ni-#\nûŒxoGuIÀÞsÚ’[	t2¥ôÂ˜Ó*gM)­6Ädâ“˜p\r€¼Ñ”¢Ø>4eðå	•£	²a¨ ‡pò¿Ð‚‰ùî\"D&H\\(mïez2¢RƒB%%3’•”ÌÉ\\v,%¤¸—“bL‰™4&£/SzÉÉ;F7LêPnOiôÙ1¸ÄK–Ñ…àø¡H°æ† …d§F¤TÉ} E°¾åÖA	aA ÊDAVZWù@ oEÎ†(òÈ&R+5!Ü\0hhIhú3†ä˜a&Ij‘A‡%²¯ƒf áÉ£ô‚ƒ¬é{‰½&\$ãU8ˆÂ%IkŒÒ­¢ìax/Q\$=ô\n›‚ñ¢í6£çC(s6U³x(7\"^LI™vbÁŽ#²S.]ëpIh…©'.\\kæ@À)¦A‘™Ö'bgQJ(ƒö4rt,¦äg	bª@b	N	i£‰k9DLàœCÛiˆLš54—Ÿlá@©,¬¤R0ÒŸõ7´pÃšUJå4—Ì]C:bU¬0Â[*µX3¡¦­’¨ìj”y)… %Bœ„Æ²;GÂºçhmŸ*à¹A‚ƒ6\rgáÞÂ‰vNIÛ—è‘;ÐÄÔƒ•/à€-La2N‹‘P&Á(„Ã_M£²V‘d¤„£VFºˆ EÊ\"Ê:–Oðm>A¤Öç:|ƒySfÖXù—2NŽ 1%pvJª¶sæª,+¦CÓ<³ßLKöà¹ªÝjÁÀÁ¥‘ÚH¯Åº#WÎ‡°ÖjZL—dÂß^€îG,¹JšH©#\$wRˆ ÁRŽá…|¥r<„D<6“`–³éLÕHÊ™ã¸ÐK™@oX3RÃ!\$¾¦àÝ|lµSn:-‹â?†7˜	Ý¿+9hœ‘Ê\nw#²ñL1áÈ,	áÁ}sÎ¨t:çfÐÑÄ«fàgi(2SÆhfá”d¤ðfqª¼*(Q„ÚgÚ *3@5BçËá)˜gˆ¢yœöej\rJµÆ¼Ø)|€Ò¯\0¾3PÞ›yi×ÝJ—ÃFBºŽoá39°ç!¦Ÿ¦AC\n@ÉÈoZ¸ú¶&Ê1´æGâ÷ìíÉËy\n†¹Š`2ˆQ™^½t5Ù¦ i]ÁáÍæÅB ZCÔ\"Ê:©Sœ#»h7!‘ÜËÇe—åâ¸C#¯7MXÐ¦ýâNÐÅ0–Â¡@†Q6â¬Îæ éßœP\\ƒxb¤‡«(Ä}D2÷ŽÜ7‡­4\r3×=!H¸ÏL½”#[´:|Ò‡Pä@Lø_,í¦lÎÝË¸à‡ý¹·T¤ù|g`€ …@¨BH#À–‡uL{T¡˜¤îT¡?pàÐøu\"jø•å†­ºÆ1æE+‡žµÖž¢6}@Gc€¥\$5]ä¶è_ewz¿\\2pg±ó®Ê{=†‹º†^ÚCÈý¦î*Ö?îëŒ;2ˆíîvÌvÜ<¾ìÈËçŠìŒÊxñLíGv®ûæ{ÉOÃþ–¿Ð ¶;ãöñ%¸z>ŸÝƒ¦õ7»ú7ëš …ýœÃ1¦9ÖÕ«y#duûF\"˜FˆæÆ\$ÍÊžŽ#·KÛ8-„\n×‰T\$zºdýl*Í˜CKb‹üÎ¤l”¹'¶SãŒt©8™€\rH)#„QI_ðG,Á ò²)Àäy‡´w¥Ü)&þ0C²ƒž\"ÀâÜã…jÐé–%&äÑˆþ8CöîL>Ñ	˜~å4¢|Ü\n›%jsÃaFfÒu­˜(0NÑ(õ¬ˆDïbZp[PaÎÜñPXÝÐp™‚‚J\$òÜ\"€&ÌžÉG6\0æ\ri4h†\\ëØÈÅØõ\"ÜÛKV]b \"@ W„4éh+Aƒ’`0ŽÊ0Ä4ã`\nð¸(ìŒo@ÜÞâwíñï{¦Z¥¤Y¥žZ\"‚\nËV,ðÉ%âD,½Ðå,†Ñ«×°ÊlñðŽß±qˆ;p‚k£ó‘117‰Ðxü êü`Ú´Hä¥9‘üDž.¯ïï õ¯€JïM¨ð9®M1gñm¯E#&ð®FH{Ñ1„[‰Ñpòe”ÄÎÅK—ðeÐ0Y‘²á*Iq¨ƒÁ.áQ·åÃÜ¹BlßMø«‡vFd€C¬”alš(+4Š	t\$æF_ÂVjfƒ„-d²Gb%©ÌÿâZ]mìuïº4qîv#YE¢\$ò@)v-†¢—R!åÖC–KÊÆ\\@òÀ	œÄñÑPmÒ((‡Øl‰Älmèâ#ÿ#	p9€ Ý%PÉQaOâ§'Í×‘»ðk'¥JÜ¬_)…ñNp.³²ŒU#˜å«8¥Q%qí.\\¨('âV6ño,2Ç+‘a+ÑÝ¨T,Ñ,R¶%­,pÏ3-rìôçz—&HZâZcÔ8Œc,Ie <K).Ž^n\$vÆÇ”@¤`Än¥q]ÐQ0-‹´ä‘›)Ñ²—ŽM3s°‡íèT\rhÚà&ž‰Ñ˜äÄG*’ñ5³_6Æ¾³³HETëüÖòáƒºáÇ{’¾DñÌ{N)8ña¨_9£m’£ãr&ÓVâsŠâ³tl´'Î* \"=Rô;àªA@èA†ï96½qÍ<æé=(\$*ÓŸ4.ß=óÑ=O·9ã¤€³°)džgBÝ2Ñš<\n³!‡˜ÛEZ3c;AO²fÎ/\0ï/Ã#j!BqB¡= ÓC®#Ô7/Ïš‡#6*¦\"Xi¸<EC”2!Ó8”-ÍFíñŽòh3q«OF¯#(&À†RàØ`Ö*¢>²Öei‚\$â¦)Ãº),L1,FtQ#¤B\$Àò]iˆmÎÞIi¤\n ¨ÀZlðjç> ÂÄ%Ñn¿G‘¹tÚoŒE@‡ûMNÂ2Òº~ôÝJM\rŒ\$Bb0éB;\$u¢ð“6Èã“Œ`4¢b3á%'ÔMìt9ÐH´>ÆFjC»MæV{0E˜9d€5*\nõOFd¹%¥€è#ãÔÒ3½p;íÚ(ˆUâ\rë\$&0ê™ÕzsQ` L0%©SXÍ™WðP P—XEO_WÔç)-µ±Y-„bpEZÕŽ¬†a)­Ô;Œ{†R(InŒ 5v|ÇGÄ6\np˜Pø6åp½À_¢ë_ò\"'O„YÊ,T ÔkÜcK\\(1¬Æ -¢ËuÃ&0À‚ÏmÀb+\"3ª¶Q\n«-{XayI4\\¥G¦¨dÞF#XÏö\0Í£>e®6†\"\ràìúð äW^>l!`žq Ú¯§|;óW à";
            break;
        case "pt":
                              $f = "T2›DŒÊr:OFø(J.™„0Q9†£7ˆj‘ÀÞs9°Õ§c)°@e7&‚2f4˜ÍSIÈÞ.&Ó	¸Ñ6°Ô'ƒI¶2d—ÌfsXÌl@%9§jTÒl 7Eã&Z!Î8†Ìh5\rÇQØÂz4›ÁFó‘¤Îi7M‘ZÔž»	&))„ç8&›Ì†™ŽX\n\$›Žpy­ò1~4× \"‘–ï^Î&ó¨€Ða’V#'¬¨Ùž2œÄHÉÔàd0ÂvfŒÎÏ¯œÎ²ÍÁÈÂâK\$ðSy¸éxáË`†\\[\rOZãôx¼»ÆNë-Ò&À¢ž¢ðgM”[Æ<“‹7ÏESž<ªn5›çstœä›L@ÞÚ%£ ÊL4\rÂŠ\nh:T¤8ÂsãÀã«žõ¡p£È”4àTÉÁ°XÃ½.päÇ‰¨\nè4¡n’' P‚2\r«Âí‹T:\"m²<„ c<èÜ°pP@;#¢\rICƒ9Žë Èâ43£0z\r è8aÐ^Žóh]Ç#r.ƒ8^”ò²A,ŽC ^*òŒÎ„ÀÌº'Ž{šã|œB-xÆ¸¯0,NLJ½¥­‹Å\r±]2Å1‰‹”•+Ñ«Å±®U<9T,;#\"“<Ì¶€P®–\rÏ:(Œ\0Ä<¡ MaXˆ!ã`ê¼§#J=eÂîr„º®LˆÆÎ©Ch0Óâ¡9ãä\"£0Â:’Ýg°ý%J1â5žëe­•7ÅôŠ\n	°ÇP±ã‹†6`ÑØØ7±ËØŸ>¥|\rm¶(3x‰bœ§iê6jår ßÀ{\r‰315è›7Z‰àÜ¤˜¢&L¾îÔYRU©lGIqEWR±Ôèç„¾BëWicªˆºŽ§ÁtSÒ×#k½0\$²ã£ÆÌÇéÉZ[•° PÅ­DÑ@ˆ!Lë>Ú\"‚#2ßÀê‚]N¯9gÙ.Š{e‘%(ÃÙq:i¢ÅÕº›o²c–ŸÔXÍRŠKÅ®¸¸ã,.ñ%`UÚã4m*Yã0ÌõÎIÂ\09N.S&; Þ '£ÈAgŽc¬ŒØŽc5Øak»%.<^Â3Œ+Å\nþØóŒ42…˜SHyêÜ=­Ã˜x²8æ›§-;ðÙPéhëÇ\rÃ=ÁGC”¹s2CLKRñ¦L)2¦tÒšÓhwMïá9 êÃp/)åEAD ™¹<ê1G>xeÊàp&¨œ0¥Ä†R´p‡‰¢¥hb3ã#©]>,BMN .K©~¦DÌšRlMÉÁü§@ä“ÃŒ§5?¨È\rzÝ9Ðp8 @·R‘Š6o\0005 t¢GH;2[Äà ›'vHWú%\$„	O¨4[œ€T&i\n¤ðÒÊVø­Õ‚C42}/©ågšõ’‚R7hú­Ò\ngP1Î%a±Èc.\n~!&Hìä@IâKqaâMÆ„|@PH-¬Ü PTI'+ÒdÅ‡2<¯I l'07' Æsß¬[#¦¶;›‚Ù‘½?I\0½0°ïL„‘9êµ’‘’ðŠë7Ø™¨CzA%°a Ï^E½pà•ÒXKI<Þ(®]“,yœ¦9ù†WlâéýaL)g¯6Ú&à€\"’–ÜK¡Bˆ]„°¸š¢ÝŠø\n\n'I äPJE ˆ0Ç6R?!ÏAåøƒ´‚ƒ‰….%uÑNI&‘¿ä~ŒÙ™»7¦u„•èPMˆ7N(í)‚\nÂÑ\"R7©X3Ï`xS\n‰,Á\"Rxã”¸ è­™Ï`@­ƒ u!t Á3&?M)jÞ@ônòÜÖá0g¨®j¸£EM{ÃŠ½¤ Ä]™«7…¢‚¤ª'«¢¶e\n5@FaÈ’ –iÉ#‹Sdö¦Â2(¹™L9 ('„à@B€D!P\"ÚKL(L¶°Š¡t–srÐBÒ9X0ÅX<dê³ žòû1jLæœ£X0Å™D(ÊŽÊÃ4VAhÕÔGiZë·0Ò’¶(ÖU7F‹Gæ¼ÙÁ„œ43dÖÔ»‹=næV¾çsZæk„Q¶œ¦†Ö/Ø\nsÕUÆòÀV¡…’“ÒªJ@\n\nÄ™r ¢±¹Es`TÞó§)i}•¨¨`\"íVW1FÃ” ‡FŒbÍ3UŽ@Øa\"0^+1²½µäeùÔWˆ7Þ@šnL¡zÇK•Pï„ŒÎ/F8Õ¸Œ1ÌÉŠÊhí\nÜ°‘í!u©¡´.‚¼^–[TÇ~\\Å*˜@ê¾Îdj3MDS6¯FßžH=OŒ\$õo<ÂðÏ&3¦á“¨ƒr\\˜1tALRHs”ÀD¾+-§¿\$7Œõ«\n!„€@ÂKª>uôÝâ‡Í4)ÿ#%äæ%Ø`ˆrÁå…c·¥pÖ2Á×Æ‚þ×Š»pþ@CP‘.kÕnhf¦¤à/6=U+›+jBRŸ°¶{|Ú;Nø“‰<O¥ç±f¬–l–ÙÉÂÇ›fpM¶÷|\$9‡ÿrRí­¼¶6·0ÄO{í¹	\r’æß•–µ†ÓÁÎ3G)\0›r)Ë£g°dÈ«-š<B1™×2è0Æ”·0‰O­n„„à\"“¼„Ë£'*¥1r÷üâfxbqG¤<q7É´†íS¤Ç>¶°AÏš<Néj›®¦B¸ºÕsbfÊcÂ)‹™Œ§!î·|ß+ìVÍì 4MµzïdpGtÊv‚uŽŸ`/3o*cx¯ÙŒwtíæG’¾énÑ1¾î\0(£ L\$^‹¢>5‡SiÆÂßI°pqD6ß‚cŸˆï1ò§>ä‘OmüÚýäEË0³:E2¶_GÅVvsB´HóX\$^¨ZžAEecÁ¼ÛU»yQ%ð¤d”öw;Ùð%û3„¡ò¿‘€/}ù×ÿáQÿXÒ>vqc§lp.\r¾MÆÍÜ“qíBoµøÈûû/ðíÿ—Ù\r”€Ü”žËšŒçfß®v\$ýËìç)déoò„nîõ®òøï´5,é\0+®[nüøèÊ·n½ç`ÌJŒCÎ?HÔ3c¼dºbŒ6e¤\rä¸@Ð/âjxbök–ÎdT­nY°\"À<Í–#-†[äÂ âPRj³ŒçË-\0ïï\0:TNöîÆ·côÁæ˜UNð1ìú¿ Z\0¬WúåZîªU/öø¯j«²Ó«\nÃÒÒå¾ø‹è},[ÎË\0….áÐÐ#0ÄíÔi*	m8 ðÚÓ +!Z¹ŽdÌ€†„Šžôä\$Ðè>( ÜƒŒÒ*J(°Ý°Ö' :‘\$ÓûÑí'pê}î9Eì+/FTpà%¬\r-)c”yQL;ûFZ\nBkÞq\$oON}brÐ:ÿŽÝQ7'ØÏìÏO¥Ðž%±”ìôFË–ó£b\0£ÐÏ\rÃæÓä:q0Ôì\"p\n±¼Râ[]qÊB‘š}€0ÀÐÈd=¥¨\rÊJÐ(ŸŒXñVÁB|Žæüñù¢@£çÇ\rg fR­r5H¶0Böò£Xä¢3oäüÍþ±‰Jü­ÊYcÄ\r€VcÖa+\n!D|}`ÄP‚3qTÝ¢Në@Â¦*k\r§æHœ€ª\n€Œ p\$ñìT‡êÞ/Æ×å\nãò0Ø/Þ×é“):’Âš#‚<I	rFkîÍâ	ðœU€òë¬nó¯	ñºŽìt¡h\rqŽÍk¬ ‚ô|bX'\0˜¯…‚PdL×âDãÎ©â„yÄjat]¢Š¼#bàFhÅ1W2´6E?ÎrV!'¾FÃe1*Eb¼kÖŽ'\0006Oü0ŠŒ\\ÈDšnn~è'q(|£vÓ:4Ïì*Œ\ràà9ärI¡2ÄU`b`ÆþRÊF/3*0c\n\"ƒðËˆ÷o E–'ÂŽ@ðTË,JÃ¬#&2Ã:í2˜ðæ”I6Ì`Í‚òCƒÂbêh.º»ƒÏži+´<4ºï¨n¥01+ÈY€á+¬Š àî.¦6*šfrúM5\$K óXg Ï5 ";
            break;
        case "pt-br":
                              $f = "V7˜Øj¡ÐÊmÌ§(1èÂ?	EÃ30€æ\n'0Ôfñ\rR 8Îg6´ìe6¦ã±¤ÂrG%ç©¤ìoŠ†i„ÜhŽXjÁ¤Û2LŽSI´pá6šN†šLv>%9§\$\\Ön 7F£†Z)Î\r9†Ìh5\rÇQØÂz4›ÁFó‘¤Îi7M‘‹ªË„&)A„ç9\"™*RðQ\$Üs…šNXHÞÓfƒˆF[ý˜å\"œ–MçQ Ã'°S¯²ÓfÊs‚Ç§!†\r4gà¸½¬ä§‚»føæÎLªo7TÍÇY|«%Š7RA\\¾i”A€Ì_f³¦Ÿ·¯ÀÁDIA—›\$äóÐQTç”*›fãyÜÜ•M8äã3ì@Âí¡ij’Í¾Ãª†¾¯BšV×BïÀÂ¤¢â+¢92‚`Þ¿¿êxäžÉZ#\"£¦\nKnØŽˆ³v¡\0Â1¡IÓ\rë1Bá\0î©(¬j0¤pæ;¯ƒ X’`ÐÑŒÁèD4ƒ à9‡Ax^;Ìt7¡arø3…éX^8IÒ€ä2á°(í¾7Ëâz©ºà^0‡Î3Ú1¯,c\r¤@Pš‘<®«nòÉC¬A\rˆ4@˜%©\"7LST“MJÒâpÞ¯ŠM\$\nó\néxÜô¢á(ÈCÊÖU¥lÛBÞ6¬\nt4¤5ëçAëË*7mÛ#‚”ù¨j˜Æ½=ƒ0Â:Ó!í`°CkD: `˜e9†Z×‘hÓtÝuà ÓŒt³(š0I¢\rˆ	óšVÊC6kn…:7˜£*W\nw(¼ƒ¢ô ÞýÎ6%2j‹iõ*¢˜¢&L[Ä>îc( Ó([«3”ƒF\"ù…B˜6÷Óè!¯µ}ˆ£ž‡›fÄ5Wšl4ˆòÿF‰#lp÷B(ñ«²š\\˜Hlh\"f°Îo¦‚YCÑ, ˆÏ¸Žò°˜çŒÅîkàA¹¬ˆ3/D±îÛËX0…ÕžÓ¢â#}&;Ê/…¬Ìt*ÀY+ÐŽ2ØüL³mSX—»ÃxÌ3\rŒ\0Êã,Òt7¨)ðòX#˜ë6ã˜Ín_‘Á)¼½xÂ3õ/û½Öq|”2…˜SÔ\$­íhÐöHS\$Þ§\"£\\ý7ê`:Žqü[4R¯¿Ã)„ªÖËÔ¹/LÈ;ÌÑwMÍshÜ©,\rû„A÷òoJ‚PŠ‘˜RÈÒ)M´MÉ‚ýáÔ2‚Öj²Ïa\$ä&˜å4“IrVpÍPÈ’¢V})m.¥ôÂ˜Ó*g~i¨9&ÄÜßI[Ý:	Õ;µPàm`Ðt€@ù½›…ž\n³bÀ€ž†³¼T‰P'È¨ã²øoÒa˜€«°Ü!“`¤Î©®M@É”—ªò;i¨“C“ÚYêÌ0†h>ôQë¶wIá¤xpñ÷Yä\$Ñ¡“¢Kƒc#&t43ß¡Ðn#L:“Önn!Á—^&à(€ šá½7\0 ¬’TY¤q’d„°’bPNUðnE!ŒésrH\r›P6ÊÍ«›ƒ„[?°˜œŸTC0id,dŽ\0ìPÝ+Ô'Q¡=(²œR{	ì8\$¨@“ÒŠF8!Œ4DÂü—|Ûd/qÓº¸œÂS\nA=ÌñC4IÀ CÄ´ê‘Èä·©±ƒ(ªv…©!Íëf(E£\$ÆÌÈZ±\"ŽD©¡ÃôŠ¡¨A½@öô¶ârp!\$Š‡“VJ¢4\"Ä®%ph×ÑfÆœ„=÷ç øc_¬Ö\$\$àçhP	áL*3sÄ‰ëÝQ€€3¢²éÁ©Ô‡†Äå'¤ #FTË³6|s&	¢	™MM'd'üÝ¯Ô6#¶dÁ2K¥¼K\0F\n’|Ÿ+2ŒÕÎú5ÔÒ•‡\"N€Õé®\$ò`ÓêHº×c\0è0\0œ¨P*[, E	Î‘…ŽÍÎzÀXJšA¶` KÆ¢ˆç™‡“â€À‚ð‹ˆ°É.E.³(¥G*uöŽèmÅ°èé\"ð^•IG°èU\"¶jD¦tÐ*„­‚’Í®»Ù\rá¥Sø¡—m&~ë3…zÐo]Õij5ÈTvÌ£µQ¡X—®ñBIÌûYr'h+µ<G\nÀ:ˆ¨éHÌñS\\c‡&NÉò°‘À*«\\£à¬.C¡Ôt¤8Í«àØfa:1f4‹…0Ò—\n¾jÏqYi	‘eæ3puMHŒ_	«¸eà(+òÅŠŒf'CF™”»YŠ›#¢·'#Ö\0_j\0m=jLÀ1|¢ËííêÅæŠ¤CuRáS,T\0äÎs\nål´…´Ø¤ŠNŠü0¬ó¼Ô“ñ¾º¼é9 ŠIÎŠqM1¯TåQ`T\n!„€@¾‹ê3t©Ù¯1Ê#†ç™u¸bˆŠ³å¥\\š3JyCz¸Vz¹U¨Ùbì”ÎÆÉ*%=Zª12Ç¹Fà­õ>º^¦(Þëíg°5¸Ž»%F¯¥8—ì­ybËã×£’É®öbLZèbR¸N†ã1ÄX8î`ñº Q¸Ýu|žPC!½öZ!aˆÔÓ‡r/¢¹Õ&ex½p‚ŠQlÜ,¦ÅÓnbã&é»©À†¤‚G\n\n/ˆ°®”Þ?ay0á”1DV³À6ø +…0›´ÝºÏ6ÉŽ)x…žecI€sXì%\08€-Á/«_Wó(db‚0a>¨íO¯6»0œ0««úº}¼†ûbý‹×•O`\ríÏ±'³ÃFné;É)3¶’†`fAÈÆõŽÇ—ûÏ{ÅxŸ¿HB]4­b8}Ìv,fïâý4fá8@å&ÏY§ˆZþ;oŽª8æÜvÝ+Ïj<ñSÅ>D¾+Àžn2fUFohž#¯\0j!fÄ—Ù,kT“AŠ«\0¦Ó,ôYw¯“g¢]´0Þo{/â¼†Œþ,ûÏñþ‡Êú^ë÷¯³x|)‚T3K2Ã(´!€ÛÛ§g.­°¶¡8?£B˜mñ³^'îí[KaõÇïOÊ6Î©ÌÔîŽ²ù§~û¬ÆÌ©ô±¬Ò¨ü/\0»\0,ÍÐ\nð¥šðð(-ôWå‚ÞfÌ/‚ü%cœC\"ÌË¦\$\$â<.NYàæ(â\nX€ÞJh¼çƒãÉ*Êod%D>0>÷î,bPR?ƒœ#hØ/ÜØo¨Q\n—ã=+ÐÍ\nÉúºÌ¸?ŒhkŠ2I’d#6]Ï@&%/ŽÈ¬OÇ A\rC\nù\rÐà3®Ûo®Ñ¥8ÈÅ>êZÂùÎ»Í‰o˜öâs‘æ‚ŒÐ¾™	”:°þÑ+Þkéõ®•¥È@Œ(ÅzDX#Œ8‡íˆ&ð6äeê¢ý-IPð/èýPØfQa¼ðï,¾&n,.\"ËÆv—„ÂŒZ*:±zÅ0õJ0ˆ\"ô\nhfÅ¾oFÌ«âùŽ¨Í‚üÍÑñïlé½@Ï‘ðîºgFd&ÌÍËx™LÅìê\n‚X±&bÎ¼ÑáBBºÃQ¿‘ýïÇ 'd 1Òìà1ÀÐQbXIbzLê‡Ñˆ3er¿†\$iüë%4EíŠÖQ˜¿KÄD*ÔÚ¥z_¥Õ#b7#0o<2…ra¢ùû#òf’±\$„u&òPcÊ\r€V§@Ò_B,\ràÄOB9qLÛ£¬2`Z_¢s¦>\r§¸F¨Þx`ª\n€Œ qÅ®2LÒ'-~íO\n¯îŒÒA	-£'ok-%	#‚<\$D\$‰\\%#0½,äHøÉE\0ó!Ãô¢/†°\n¢¦ÄgBÏCõ)ãÞI¤@‰€ß\"gƒ@[Ã/‚rDJÞO\$4Õ=,CÔ\n†D„atS\"ŒºnÙ,6>qIP<ðNç\$ojR…˜ß\"¶7þÞoh!¤»gîCj71LZèÔk7óp!í#ÉDz¦ã9^;Ó”?àÞ¦*,`„ð°Äé1\rìŒ·`„{ÄûBÀÞs ¸¯ÅJ°¼Ü¶¢~çpx·¥Âh¤à]\"8a`ì4sÿlˆG`ê’¦;îÍct£îò3/Î®82ŒØX0Ä¹E÷B¢bIS&ûëÜQë¦WÀá0kŒ@î/¤V*€;\$ïG¡ÃÝ\$Îð@ç~/€Â";
            break;
        case "ro":
                              $f = "S:›Ž†VBlÒ 9šLçS¡ˆƒÁBQpÌÍŽ¢	´@p:\$\"¸Üc‡œŒf˜ÒÈLšL§#©²>e„LÎÓ1p(/˜Ìæ¢i„ðiL†ÓIÌ@-	NdùéÆe9%´	‘È@n™hõ˜|ôX\nFC1 Ôl7AFsy°o9B&ã\rÙ†Ž7FÔ°É82`uøÙÎZ:LFSa–zE2`xHx(’n9ÌÌ¹Äg’IŽf;ÌÌÓ=,›ãfƒî¾oÞNÆœ©ž° :n§N,èh¦ð2YYéNû;Ò¹ÆÎê ˜AÌføìë×2ær'-KŸ£ë û!†{Ðù:<íÙ¸Î\nd& g-ð(˜¤0`P‚ÞŒ Pª7\rcpÞ;°)˜ä¼9ªj6ºIÒfÓ\r¬Bp·ƒK\nàŽ@P 0Áã`ÂL#Ä1P+>:Lè˜7Œñ\"p8&j(Ü2 Lè‚¥¯i˜@2\ríü­1Ã€à¼+CÆ«ŽhKìŽHlS\$0´!\0îÍ\r\r”šË˜î¼`@%ƒCÈ3¡Ð:ƒ€æáxï;…ÊR™ŽArð3…ñà^8L3ä2á¤\r«Âp½ŒËÂŠ:\r.àxŒ!óšÊ£6ôÀC“ë«)¥<†DâhÞÌ¥ÉCÔò õ<o-UV\r5s”É‰¨¿´\rbºœANûJ+Äƒrö3Žh˜È\rôðÊ:!-Ÿh h(Òk¨Þ0Ìè¨4Žàß Q Ò:Û\"`ý´hâCsÔm(ˆ2ŒÃ\nj­ËèëŠtå¤èˆÈÇm[bÎòF¯%¸‡¤1²î¼ ,;¥&bL;Vò5h|@ÿ)Óü€ŒêEâ	{„àè2à£blÈŒLª•Î¢&þ9 V41¹°æóº5¸ÓVºì!Åˆ¥iSV4ª-Úô:íÆ¯¬³¢ž‰¬¥špÊƒ°ò®¤(7MàË’ÛbHÛ%ŽC£:\" é­´•Û(iÑ^Õˆ‚Ð²¸@\")®Zp©Z\nôyÇ**rñÊ„ÐR­zü)¢ó¨	]EiaÈÐÚ”B\$¬õ ô¦ç_?êÌqŽ÷B8ËsÚmh6F\0SbÆÖ€Ì3\r’\nz\$ ‰Ž*\ríÄt<„'«˜Ì¡‘£á3FÀÃ¯aÓk(ŽòaJ«m}^‹5Ò´þàæžŠ¤S”‰^©H3‚~žÉšf;npÃ•äÐRøM©½8§4êÃºyH	ñ?ÅzD/ŠPî(}ŒRËRêeþ‚@M		 !¤ƒ’ÂÄ	ŠLÈ>‡3®Ž¼S¦Eú“±IèMKí0%³á»¡< ¹3¦”×Ó‚rN‰Ù<'¤‚ŸSüP,¥˜J¢ƒ˜>nAÀÊ®€é\nÁó˜C'Uœ¬CZ+Hà9#¥h¦á’ÊfÈÀ2† êLˆA×%ÈÜ¼,¢ÿÁSÎu-ÂldÉ¸r€(eg†ÍÚP{Ïñ¶qÎ‘hèeÒžCwKëû4ÎeÛ9˜Èç)–†,Ú†“\$oºÊdÜ9¨Ë\"KnÇ¨'ä¹ƒr;’iLà›ÒnÐ\"ÏoE8ä¤r8Ì\\SC\nqÒ!Çš‡Ü»G#jÃijÂß´Ë’‰õâXÔ!W}Fã¨ðÜH#Ú…L‰hä4GÚÓy‚'õÒ¯£BOBS\nA;G“ƒy	Fò*'‚ÈL\\›\$õÕ’†QJ9m\$•`š×FfgÁÜ\r4m›Å\"VHâ”sÀ‚%¢ð_¡Ryä\\<›\$†V|Þ4!¹gœs’yñX+A™‘èåJ<t¯…,Ôâœ¡\rôI+„50 Â˜T—hÜùÓÉ¡y)‹dƒÒHÒ;pd!}BRKë¬ì#¯¡À²\\BÕÚlõòI2vAêÆ¨ÌáìÆÅ¿']Ô\nlì­³cvK0T\nr¦>¦æ“USª¤ä9´ú·Á˜ÁÉ€£¶‰–ÑÜFÈœ&Å®2·§¬ý›æ½ËL­¶Ýo£µ¶ê§%‚ŽdÑ•²3ìÉ-]vÕ¯ Îuéb®je]RÂ\0ï0¼¤˜Såš~n*E'¥Òt[>×ëÍ…•IÈÚN)8¯´Ü­.ògCÐ0Hªú¢Öù}\rjNÔÈ›•¢V¡xAYuKó*t•®À÷mx• tæa–ä\$–\0‘hÊ’~…íª‰ñ‰nh>|1æ¸iVí¸ Öéé™%8tò[®Í©0@Ã!ø?DÌþÄ£÷/§9áì2‡pG•ˆeVk§\"«Ã=S[mQ\\röaÃÆj:D2VÄ×.l¼Wt:ÝóÔØäE³\\+ÙN¢`ÜLRßaÙó?òî0 1èmˆJŒpëÇÈüWµ÷m\$Èì°àŒ¤ŒR\"Aå\\2f§`KX3¯‡SRv²£s„ÁÁù_IÌ‡´J!!P*†ë?&SØòtpÛÔâë¸Lš0Ùx/eQh8ðA·)cXkUgî„k€PQgï`±)Ö\"3ìÜÔ¸œ[ö–®W¨.;¨™îÀñ»ŒŽð*;”ÕnwG½•j-¤†œ:W€ƒÓh'·ðzû6Öþà+}qÖuwÝäãÞwôe÷ÿFT€ ðî³V¦WD¸ì”\"ü`q*·eošžGÂä¥®4&|G:“ÕîMíe®'Ås›9„qÒP»xà+¦\"´3˜Oaµ‘ò¢™iEuÝ¨e‰Y/ùnÂA[¹âÇñÙ½¬„•Í¦Ôg‰“6º*¿0ÝR¼ž÷N)b\n3Wó»6þñnÜ‡‡+GÀ™ï22½&ÞJâ`wùæJœáà:yõyèIo|•¦ÒºÔxnS'ôUJ.\\8øyÙ{°`Î„DîJ‘ÇS³&©ÕµýuÉŠSßã2å”¶Ñ¢ºk°ÏçÕMHÞ(Š¯{’¹å×!CÍù¦êäšuÁB½ºèd0é•ÆíýiøûùÌ‰<\rópX*}©\\õêæ¿ôÂLõ*p5Y\0Lþ‰y\0Â´ôo¼¿€‚G*: ƒÉlãnÆV,.Õ¥DÞ.¥¥†ÿ¯U\rò0.ûNDà-:ÕcÂU@50D5ÅåLûà†¶(lŒ‹h:ïìïÃFðù&ÏcöÐpH§opt–ÐÐ1,üÅÀœ„HÑÉ\né=CÜP|*ð*¡>v/Â¥æ¢§È<‰™À,cÿ†ÒMc\\\rÁŠc®;'²¢ìÐ¹ªDÀ[¬i	†ÎâpxÐo.ó)î;eÊlF°kLôGÃÏ¨‚[ÅÀ3¬ÀVEhçoDûŽžL¾¬ÂÌej%~ïï,ÅjÚó¥\rxîeaLÈ@­lG†L OPûLð.ÖñreP“ñ<ô‘ÝoT)F F¯[#Ô±€Æ¶îq¥¦ðBOBB:@ÌaDC²ob~S¦\$:cª:íZ¨YFŽaÆÙ¥Qo:ÿù-Yq:¸-^TQéëù\r`\$å´U1ŠWP9%DÁéÖ\"ÉM{±äF#Jw†<‚E¡/%¶®\"¸Ñ”§z–R@Ò›oºã.ÑòDóp¢>QŸ!#®FBBñbo²m%B\\fæQn×h@Å(œíƒ\$nú?id\n²ŠØA)·[)„:© 2d' K°Ê1ýÃ:\nr3D\\ N†W\$/T?döÆÇÙ!b°ß@‚û2×,hFqéµÌgÂGc¢Xè/®òòìGÐm!%êàpdÜCE.Ré	S1mäàª\\5å¸F\0Øm*W Öép¿-Fåh&„¨zÓ'¢~fÀÚ€b´“Ò\n ¨ÀZ2\$ï¸>Î.Yàä¥…ž£êãÈå³xÕÓ|à#,–b:#âB\$gˆcÔGÒf†þj†‚£Ì„†€<#4bOo4\">[êB ð–Ïç¬²ž’åæ,V„p !á„bzFb”ûmš8«x²å–DGÎw`_bDç¨+Ed_cWÏ0W­1â´Å2, ®4ûläoLS”(ûQ—Æ¥A40ÀTó¯8ô2¢œ6ƒl2j´ÏdÉ ÉBæmgm@/%¸_NÆ¼Ó¤ÃçqFã»8Ïö×eÀR”€tÆ`âb:Eøî¶¦d.XFÌ8Å/`@žZVp,/Œ²:%º DJÇñBƒ:nÜnà4 š\$-°0\"úìfPÎjtØÈð—Å@\rë\\âòmhxúQ´8\\°¢(`	\0t	 š@¦\n`";
            break;
        case "ru":
                              $f = "ÐI4QbŠ\r ²h-Z(KA{‚„¢á™˜@s4°˜\$hÐX4móEÑFyAg‚ÊÚ†Š\nQBKW2)RöA@Âapz\0]NKWRi›Ay-]Ê!Ð&‚æ	­èp¤CE#©¢êµyl²Ÿ\n@N'R)û‰\0”	Nd*;AEJ’K¤–©îF°žÇ\$ÐVŠ&…'AAæ0¤@\nFC1 Ôl7c+ü&\"IšIÐ·˜ü>Ä¹Œ¤¥K,q¡Ï´Í.ÄÈu’9¢ê †ì¼LÒ¾¢,&²NsDšM‘‘˜ÞÞe!_Ìé‹Z­ÕG*„r;i¬«9Xƒàpdû‘‘÷'ËŒ6ky«}÷VÍì\nêP¤¢†Ø»N’3\0\$¤,°:)ºfó(nB>ä\$e´\n›«mz”û¸ËËÃ!0<=›–”ÁìS<¡lP…*ôEÁióä¦–°;î´(P1 W¥j¡tæ¬EŒºˆkè–!S<Ÿ9DzT’‘\nkX]\$©(è³‘!šy&¡hÉ0§2‘ ìÂŠ’X÷¤ÚE4£\$üâãÎn™ ¯«)ü56d+RüCˆÉ<ç%¯NÁÍE’€í3ÎâÎ# Ú4Ã(äÛ<Í\$5BÏ¤>ëBnrb_¥EÓVÖ–©S„Ù M¥Vîôë•<*\$xXƒ@4C(Ì„C@è:˜t…ã½œ4µ1MÃxä3…ã(ÜŽæ9Žö°È„K|h5“ihÊµjš‡§)*§¹D2š\\xÂ.¨‹#ÇÓ´¾Ö¹N’€å	‹ˆÂa\$Ì™,ðdO!ŽáiDE‹dnúG&„Î³!±6ý]á¢C ²Lá(¥Ic±H9†?âè3Î†ÂÈþ7:£%V¾¦ N{Ÿª¯Ö…Ÿdº÷³kËâŒ®ï¡~Œ“KÊŸˆ¡íÊ†ú5 Åijtââš\$;á¯7vo¹L67šºÀålÛ~Ô½¦*|Û³@‰¡\"]bR&)ò—{>…Â3¯¥øªõz»D|ê¼´.3GNdvJä‰RÏDc°Ba²OT}6#¼\nÅÄÛù M©ª{¢ŒËmææÜ!ª\\WÚ!¥Íîü þ%tì(°9ËžÝ»YA\nbˆ˜ºó\\\"“#)+¥á\$\\¦F‘,/=cûwƒi2	W%µ‡½AcØ†Cñàí%”£Pôã)0¶Ä,Óþ^­4þX“xç¹±VÌM“ñ)é±Ñ‘‘ZpÊda\"	“#`ÄÙ#Ì?¬9ô²çØ Š‚	Ë•DŒV@D\r!Ì0† ØKˆsX-¨k\ráÌ;SeÊ‡€è¶ƒ˜i\rá¸9Ÿö^RÃŠHÈ\0004ÛOÂàð!‘x\nkŠ±EÞƒM1¦,hq5‘‘&C\\â=kiÐ6@ä‘áŠ,I°¶3ùM_¥QßTDochsŽyä¡|yòq0¥ã=g¼ØUQŠ)ü¦õ“ÂF ÒÁxH#uC*Õ¡¶#èCÄË`¸Æ•RÄ‹lP0Y—²ÀB¤‹t,*Ê1ƒ9%â„€SÂÂN³\"òÍÎD¢h¦%V”ÉNOÛ)E!²±¤;\"§,I°‹–’ØíK†­#%ä¾FÄÆÉ7ß%f9÷Kó)	%™=3Ð‹”híGÍs6Qâ´.3uw˜Cìb+\"JÅ¿Êa¡NQ~Y¢#²x’´¾„ÑV>L™Z UªUK©ä®Ò9'(-ê']Ÿ‘ÈBÇ¹S•z¯Ö\nÃX«d¬µš³Ö%Z‹Yl- ^\"Xa‘)m‚%Ï±h>ôÁÖ9ò¾ârx“,é¢™äZšTzN¢(¦‰b¾.•Ý¦mâS?£×L%\$\\=4EÐ&Š*4\nIâGd-êQyóG‰Ue+ÇNÓu€°–\"ÆY)f,àî´•&Z«]l­°Ë¢EL\\‹˜h¸H]±ZŸsR«ƒéc\r\$9¥y:¥Wû!²öGÌUID|*‚ðÿ˜zÇ\\™l¦dÕ«ÐBÁQÔ\0°¥§zïÑÅÅ’'XYJ;/èe¶('ÄŽÁ’„•gMµº²lØYHm(áI\"š£weQ‰NÊÛ¢Äì‹©Õ<´¦D¡ÖÞ×Nª\$¦!SÝ“æ”ÐÕá,•é*ßæ\$š’\\•#ìè¡ª“zd (.@¤ºÉò?rFËn´‰T±Bšð‰zC´…÷çŒèÉk—ï²cP”°HLbŒ¿\$5›±“éG¤jî>‘}5QÔÝ[“’¹°1þ1+vœJéà(ŒYùËªü®\rub}A’ÁwJ³K‘”ÉÜY.ƒ›\\Ù•èGc¼¨wõ^@¤7 F¢¬Â˜RÀ¶Ö¥ƒå3T9‰Ç§B~\râPïQBF\"G’»€ãd½–ÊFtìJR‹¸–%™—t¹dÒ«9µK´Ã6³ÒT(òž£%ð¹Q*S\rä]€ÈÛ’rÄ_è†a@\"	–’Ù I²Zµ¤‹N“ì]->e\$ÕÌ\$ƒ“gÅíì·‘X¹Í§™òpBFW¤\0žÂ£ÔUúªf°)\"&¥§*k¯–3Ø4DUƒÆ[­@ä½rLRn²]{Ç& ·?µ•Iy^4—Ë`â8T*ÈkLOq5¬x©ušæ\\Ú&AË§o%]Àô^ž†-bíã\0Œ…ÙÔO%Á4ÎÓ¥lh8î[KÖvÊd+ö_ÈAÂnVjHg9×Áv™!ð~pA:µ½Ã#z“oŠLÌ†EÅÛR#iöª±É*®ROd}·G‚žŽ€Ýã¶Jó8]8ï&Š‰~š)Lêùºý²!Ú9>þçÌò.ÊQø[‘`p·ƒ1À=	¹ÖJŸ·ä).©ñ Ào3;çaPd'ùÀBþvŠ\raYÚ÷xXÂr	d}¥õ__ZüÙr³ÎP íXŠLïÑyùÆ§B€Lõ¸¤J©!AÔAÙ@\$ù	>\rC:ƒ.5·z)Æçèýá '™,×EÄfÏqÌ†£æ7Èê:µAî~äCÎý†µÏˆˆÍMp|oJF¢ÂnôOÖ¯Æ›Cè´šMì.6FÒÄÆ,cˆÅ-@ê§bäWî¦nîd¯ò\$'Ê¸wBaæ@|äÍpN0gžcËn›(üLLÎ†b|¦±\0H°=ŽôñBˆkÀ)®&ÄDj¶/IzªPbKnòÇÈ@ÚÎ/BÐPf·0\$eƒ×ÂØÆïþ¼\n]Ï>nHæçþ&¢2°Èb¨mG®÷ã^a‹ˆAíp¨0â¤ATCˆÀ‹+ìnôö/NììŽel’N€‚\n€¨ †	¨ãíŽ×ÈòŒ&›L,QK–&ÂNâêPíêJäüs zá¢\$gÀ^1æ†TÊ´\$ŽÚ©òŠ1_ˆ #&ä;HÙÌ¦&º+áz­\$–|Ë°J\nOt0aœqn÷¬O	¢äFãäã‘ª”ØÑrz±ž°q~Ù1„FÊ•±°r¬àÍÃÊÛeè,h}Œ”MX\$qÈþ¢Ñ¸8í‘K¯«º(#²¡cÜ–‘ñô(*ÞºÆfð–2\0»ç‘ ‘¯/CÍur‘ê .Œ\$‰rdFbv†@±`«Ql%§&\"XñNT/¢xvî€!Ž…%\"C%b%Œn/‚ª-ƒÞ=JÂè\"‹Â¶0§æ™„(2h›H¯²`åˆˆvíbHÂ‚Li´c±–3’†F'2žPÐ,ýKdmd¦¿¦JÏÆ Éê>—2ËæÐŠA1nºŒïGÏÚ8N,Åc’ðC2lŒJ\$%/CÄo)âØÆ`Eòšð0K3âN’¢HÍ0,ë&æ.°B„FNOÓ,ŠÇRò3‚[3Åì=sB/ñÅs4Ïðy³@*“Xéñ@“ìbdì£yfLÿBì)¥P„33ÓÌFþ®Zo,žo†\$uÐÏ.B\"³£Z¶öMöO«a8ÓtIŽÖìÄL½‰œÉÂBíç»¥>ƒ%ñÆôiÅ-&¤ÉpLw\"˜Šé>»€PCNä\$\0Rí3w<&àóŠ6óé‰5i°˜/é2ö`lÕLÍ4JC2JFìYAÔóÖß§U4Slõ”5BECÔ=qƒ5Ó6pÀäDô3i3ÅE²¤Øðàf¤Wr0Q‘BsY>TJ	ÇF/!4g\$ýFÃ‚a‚AGR&eç*®T¶´R~t1HtcHÔ7L\$´oIaIÑŒŠ¬áGÉ}J±©\"%DA§2l´}4m3Î‰MˆýMÎ’ôãHGN”×\"îéCN>å”BUì:ÉäÔ¸\$*,.jŽSâ†æÛkª,Iª8©-B%­%•bb£ÐøaµmÍ¸ºðÅ!j¢!ÌÌ¶P]?­0ÇTñã\$¨4?Lh¸U0ibmË¡Ã¥Nµ•ó¬V•>ÖgH0‹–0Ðµ7ÐFŠáB6‹Ó<Ðtêd‘°žÐŒ·!f:ë”—³4èõLñ§#,:f“3A®Í\\r5A“ÕÏuÓ1õ×JoàƒÎ×^;6òÇ]Á]Q\0Þé‘^´c]¨]ëzš+Œí•íO”Ó h;2ÈØ]ÕíPõò.µ«“ø0÷SŽöþ„9bV<í)³Á|jŽ\"!A\reBBg0Û\nË¶ãÎôªEÚÁïà@M¯Zõ½KÔ–áÓgH´å0ÔVfPßgäLÔQ\\±ëAÖ{3ð+hUK5ï6ö‹c&%+°ìpã´uÖ±\$DQIV¢&I6CkBpÓ>oÕ÷lìÑhöÆa¥dª†˜ÃNw¥	»	R‡P¶†Ntü.Ð’—°–!t÷M§paEp°©qbÃcc˜~Š[oÐªõõñEÃqq×ÿÂ\0‹ÈÁVHGO*A/©¨O4ã0·!Õ]WRtÐpõi5´ûvNÈ!vŒ¼äworWtK\"øª¶ShÑõKö¥tóÀxð+2Šl„}H’bãñ¿Ñ‹–¡t±2ëk{Š‘41{vÅd²–·¬\$wÃf±xÊ·ÍnÐ=âêj·ØbNuEÃ›*© sðy}h·r³{qÏ¾É—±­Lt£7Ùw/tw2G{#ò0dB8hì\r€VSÌ÷ˆ¾{Âº]aå¢e9¬ËVµ³,%N{\\Wk, #2'®XÀUp>UV¸îž·ŽmZ\n ¨Ï`qrŽl^UB­Çol	©˜–¤Ï‰laˆd‘ø ‰æX¨lUjt˜œ=Ñ‹„¾Í×}”{c	.ÇÑV-’wb?°ckðxÐ'‘|Œép6CxÅWÐsr²\\ØWÛ…†ìÌn9Œ‘öŠXF8P`ð¸\$h¢„v†ÁAv.±—'e`+Õ5f3&öÈ&P¼L(žo³>Šè)fl¨!áŒ\$·ÓqËDÛÆ´ƒ“ƒŽfOt®H;UH4ÓaG›˜b®R8qÇ?˜¯I—¹‘Ž…ÔQ+›-9|yÔÌëÕÝ>Y5æÆµ0›ÒZŸ'Yš3;8¨\r™•üþuèŒ	>r©3Sµ6C”~¢MxåšfNPÇß\"¾ßt:…:\0ÜMõ>ÓÚÒï„@\n`äƒKo\0ù\$u\nD¾Pmž–\"š\0003™Ë>±Zç…?OGôG.2\0Aj¾GÒêf¨f\$ìðë}¦dPs.a¢]YHõt~jøŒµ†ªþ:Btò®z¸-S¬£šùbSZ%n¬0‚46ÔÚ\nìfÕ‘*TN%£¬ÊòÔÀ";
            break;
        case "sk":
                              $f = "N0›ÏFPü%ÌÂ˜(¦Ã]ç(a„@n2œ\ræC	ÈÒl7ÅÌ&ƒ‘…Š¥‰¦Á¤ÚÃP›\rÑhÑØÞl2›¦±•ˆ¾5›ÎrxdB\$r:ˆ\rFQ\0”æB”Ãâ18¹”Ë-9´¹H€0Œ†cA¨Øn8‚Ž)èÉDÍ&sLêb\nb¯M&}0èa1gæ³Ì¤«k02pQZ@Å_bÔ·‹Õò0 _0’’É¾’hÄÓ\rÒY§83™Nb¤„êpŽ/ÆƒN®þbœa±ùaWw’M\ræ¹+o;I”³ÁCv˜Í\0­ñ¿!À‹·ôF\"<Âlb¨XjØv&êg¦0•ì<šñ§“—zn5èÎæá”ä9\"jˆò¬˜eHÚ‡?Éèä\nó ñ¹-’~	\rR@ƒn¶Œ0b<4\r‰€æàpè¨991	R4±Dœ#( Œƒjêÿ ÞÕ\"ãxè†5èÐåŒ#ÆÕDcpÎàÇ0Ó\0000Žj`î4ŽƒC=\"E’€æ;¢c Xˆ²H2ŒÁèD4ƒ à9‡Ax^;Îrù#\\‰ŒázrŽÔ¸9xD§Ãj&¦.£2&õŽƒHÞ7xÂ%\"°ò8<q*ˆ2&ûÒ7¾¯c€ðŽŠ@Ö:\"\nCÒ6Æ\n\"44'ëåWV¹m»  Pœä'hÓv5Ã¢º:7<èhJ2:6=“e6m‘e\rMhì‡†!t8£*RàP–7ÕƒuPPÁbêÖ„HÜ1ŽC-Ê:C Â:‘üR:ÆTµ0VÓL˜Œ:¿cŒ÷ˆÎè¯o`_/ŽP5Œƒ*‚Ÿ§¯µ#Ã(ÈÉCÒ„­€˜—JÅ´ÈX\rb¯kFc^\ràc`ØÖ0	Â1Œ#r(‰‘bØVØÒâ:&Èó|:Íã&õV’l6PUÌ=\\±#¥µÍ-¤.J ç­ÀÕÈ§²=z“\0¶ Pžµ¦²1bC¢HÛ!^‚(ñ¼>{•Z°¸×\\¶;^©ˆ‚;RôÎ\$\"6¹Ê˜§\n¢sÉ)­Z©ÊeéÌGGŽiH¤2¤ïdŽ„e26qèê6ÉŽ4¡OI˜Û¶ˆKª`9.8Ërµ.|Álê’Ž©ƒxÌ3\r‘ºR'Œ‘qC±‚ Þ½cpò`ƒ˜ë#I5ð\$ Ü9Ëõ/¶0Œã\nê}ötéuŒ¡@æùþŒCéÆ\nbÖCeD„;\"Âäfƒ©)\n†€üµEªIIhÑ:ä¾Ý\0ib¤Q0‚Æ™S:iMiµ7§æÓ²xOA¸£¢f£Tz‚Ð¹\ru\"¤ÊŠHQÇñÆ³ÂwÃ\n_E¯ì¬”ÄJÐŠãvÔäRJâ)O¡Í-¥ÓúÞÃJñ€¹0&%ãBjM‰¹8täaBwIå=¹×ÏÔ„nÁÀœ/8nœÈ U‰TšÇ°CZˆGëp9=’r!ÌT‡m	y’tŠÚê#\"Áˆ<ªãMÉÊA ¦\$X`›6Y/øÿ@õX²f6DQï>¨ø™»å}éM*šÉ8EU` ^zC—°ØèL¡{/¦`Æ¼V\"2	ÈÄ¥ÄtVM|\\ËÀõƒ\"B‰¤è^)ˆ¦0­™Œ‚œþ\0PCQä`1¨Ô•š¦#á”Ô¬†ðjÍª=HŒØ7‡v<JBquÒiD4¡X1L\"p®-ù8¼_«\"ÁÍ>¤wàªˆ\rÁÁu¥˜¨ŸÖ@w6“ytÑ(å±LgD2Ð\n†¦ä~'ð!…0¤¢ãÐ:ÄÅ*ÉL¾Ø ‰‡\$”„\"o# o8Òd^Ç¢XK‰2{dj¥È9.N&äÞWÇŽ.£ /U#þ@Î%9’RHXy3Èæ\rO¢NVBUŸ+Ä8¯Â²2\0vRR“øÉQ–Óå>š’RÍ<\$ðŸ\n€O\naQ©Øœ€n<4öÊŠþpIÁ¨U~°Áâ6hÊÐ (!¸30êqDhe\rU±xªt öÊqœ­lðþò@_`b.`€)´\nñ<Éá{*‚–A.oÁ×•É[ÑAþ%!:†@õ3Y?\",µ3]ŽLÉmÁ8P T·¬@Š-òWE´äÅ²¶Ùåûj—õ>’XöIYPºeˆt+T¡}%ô9@€îùÂ‡S\"+/0÷‰Ö\n9hè6+št¨Le¢…°P·\",áC%(e©‡§¶Džk•…g794|ñF#IØÅª5àòßŽ0-ªå»PÂìXoHáÌäa…Ë#ÖÁ‰1§úï‘bœ£ÊGšá@\$\\ä8â®g½\$£Ld\0oÌ9·#FbŒb\r@\rÉ¸³Ö	ƒm¡L4‡¤e:›»ôAâv±æÝŽÕ)0X†0•Ê¹}¡XõÉ¡Ýö¬´0mÖèvÛfNub¡ãS†D\0§J1Bz£<‘â8QÝS’ð‹ëÆ#Vùæ¤96Û„Š#ÂØgùé¹©‰h¦4a‹Ù \0PFQjue&<ª[hU#–F¡‹,ßZIÀ#AÕŠÔ#cPíñ\n!„€A]Oò1¢TBÔ\$\0àÞ'üé\rÐì£”|{’Îåyg”tÖ‘˜˜Fˆðâ‚µìAãh²2\0¥foR©T%ËS\njÈ×mQÛàÆZ!ìã\n£òÉ&á§“™2ŠÖw+ÉÎß—s6ÿøï5€ÜX¤ã‚BÖ9õY\r¦¡×lr	Iy˜F]¸slH‰áñQùú–€ªÇû3¦+9ðõË»?<q–­žØþÙÁñ·p&ð´÷Y»Ôû¿nëÏºÆN‘ú\0ä4€NÈQJšªñ¸°è\n“ä\n=ýòå.j±ØÝØAM˜£9³VLÁþ\"DÙØ%²Gˆu+(“Ò °´”þx9f–]p8§Õ\rß(¥e{ÓèÛBAµUÌÌŸ3ò™‡\$¾èž‚Ptê¿’dÜì‡“Ö@Ëµ‡ïx/:Ã‚©Ã©ßÐ³l˜~/´å1ÁÙ7rdPÀ­P>ßæ#xóIOìÔOðü¢,ê|þ¥¾þæZþ.ÂoÏüÀFD€¥lÐ@\"~o°\nÍª:B6»â˜JÂÞGÆÚ„\02 À¤ F*±Ov#ebÑæ> Øm œ¿ˆ\n#p^Ä¤(´ð@EÜÕlnçnzÇÁRE.¢íVlËþ[€Æœ Èeoð0Ê¬hpÂ\0Ltÿ-°¦È«Gþ\\¯Ù\0Ð¶C¬qü\$0ÈpÉP	¯nóÆ\$±\r¼St\$°¬ pà.ÎH¨ðÚínTêÌžè¤\0HðéÐØ1/¹OÊçúîÐþåŒž0®_m¿¯ó\0qu‘éÐ‚©‰¼è1\0PÀì»mt×‹ÄCŒü°®Ò0²›‘H»ÑL×ÑP±U¡{ív«UñRä°Ìi*˜% ´ÕÀÞ\rExEb,¡\"ëü[@à¢É\"¹CÖ(Œö&`ÖÚ¦¤WŠš….KâfY”Ñ´FÑšÀžç‰\"œ‰(SdÈ.¯Ø©­T*ä˜ÚCØý„VS‹<\"Ñ¢\"Â®ùHš\$ñq-~Ö+WBg\0Xm:Öƒ&Øín9b³ÅºÓ­>Zpøäñ]\"Åc#nÿqXÇÑo#†!#Ð6kíÒ’Ò.:Æ(B‰R@Ç°ÜC¿&—\r’4ý²]&â‡'/¹\$å\r¤<Âˆ»²|1’Tl#—)1nùä48eÄQäb[À–\$Á|SŽþÓ®µj–'Qt p4B-»…SñW&ÑRÑÐï'p\r-Ñ+Òƒò‡'’¯f@ÒÉ†²UÑ)¬ŒÉˆ|F/íÑ)ˆ‘-ï\$n\"JZÑ±°DâæØ‘U&oû#s,Ùb(ä±lM…3|ÈòPÚ±…0%k4m™)fþ5“XAgRvrm)òAÍ|ÝÄ4±³2ÒÙ5\r:Ý“rÝâ²w\$d8D!7s‹4°Ï8n4ÃÒÏ.¤:A¯<doç1ŽÎ{’À¶0ý1£TïLr³Âçî¨Ê,§NÎ5ÓÒêS×Œ©eÄ\$îbEœHàØ(\$\n³ÂdœWÆšF Öü¢B9è&åÀÐ»eJ\r€V\rgš?+8õ\n¶£Œ(\$¾Tâ&±ã¤Hãe#\$% Œ¹	\"Gè¢ëÚ\n€Œ p?¥Þ#cÎ¨ªŽºB&ZÎüêŽ„å î'ànôsÔy3Üït‚oßñèoÔ')(Ž#4#‚<\$Â_æ%ThÆÚ\nÉÀ¢Fm£^úf@±	¬\\¢’6Eª\$0<µ\n§79‰¯L²Œ%\0	€Þ¸¢O4öcä”[{!B4bp-íª0a\n¿Q=*” ÔpÊRìX-Ð\nÿç-GþÄ×'•&(~Ç0,\råþÏnëp!2Õ3Q[T\$5c@'©F''*FÍ‹uVpGÖ€Ò/Kàó\"ì'?:#¦\\\r°\nË(2~³¥éYÃ'Œ*æ¼ÁÉ¤FÃT5 \nN'KäŠ§^mÕp%ÏÕæ\$\"g5Ô1€¦µeJïc’1†ßLÒ•RÂÚ-ôÎ^,@ÃlF\$\$n¶l”j_Ì4ÄR«Tñþ2c?Àî#ÃdA‡ögÀ¬¿Æ{aêbvB	\0@š	 t\n`¦";
            break;
        case "sl":
                              $f = "S:D‘–ib#L&ãHü%ÌÂ˜(6›à¦Ñ¸Âl7±WÆ“¡¤@d0\rðY”]0šŽÆXI¨Â ™›\r&³yÌé'”ÊÌ²Ñª%9¥äJ²nnÌSé‰†^ #!˜Ðj6Ž ¨!„ôn7‚£F“9¦<l‹IŽ†”Ù/*ÁL†QZ¨v¾¤Çc”øÒc—–MçQ Ã3Ž›àg#N\0Øe3™Nb	P€êp”@s†ƒNnæbËËÊfƒ”.ù«ÖÃèé†Pl5MBÖz67Q ­†»fnœ_îT9÷n3‚‰'£QŠ¡¾Œ§©Ø(ªp]/…Sq®ÐwäNG(Ö«KáÀ ²(a¯½àÖ˜¡yæÌÚ2B;4BÌ0Bƒ(›0¤\0*5£R<É0d ŒƒjÜõ\$ã{4È§ã›>ü'ãÆ1³C› &í\nè0Žhî’\r\\JÆ˜î`@&í`Ê3¡Ð:ƒ€æáxï'…Í´4¨Ar43…ã(ÜŽÌv9xD¤ÈÊ\nãŒÈÐÚ”#xÜã|—ºk«(í\n[ãXÂ‘\$ÃÐÎÖŒƒÒ) ƒ+þÙ<;.28”M¹.‹²Ò'\rã³&2Ã#(è\nãä†\rÃ:*Œ\0Ä˜Ž€MQUUƒ\r]TÕcRKYÖµ2â%C`à2Œ`P¨4Ž\0P–7Ñk˜äç## Ë	2Of„Œ£²£B\$†0Ž£bk\rƒ¬:½KàŒ:¼£+\0C ä:Ðìé:èJø5¨Ã’x8ˆÒK¬²b7Ú€P˜4ÃK²7”&–*–ÍŸkÀ8Ø63‹£.Šh[½?7¢˜¢&-C\"mc]H£rÒMUT=%—\"ƒE´Š©õ­;å9»‰›Mu€õ\0AN|PïÃ{¸éZN—œŽ™Ý(ºÀ™„\"@PÒê\\¶ËK(ìÚ4K[\0@¤Ð2ÝMÃš^Áif)Ay\r#f®”Ž¨ãh„Æ#¶CP*ÝQ!ËdSÃ’ÄÛÖ[ÆTJˆÌ3'J‚^'ŒbMØC{%5ÃË=·Ž±<R3[¡@¶íñðè9tÃÎ0¶¥_)Ž¨P9…)|\n±é¸ê9×îº<—ŠŒsÊÍÍ#“=T¡1)½QðÇ¸6w¥ 1¨,‰#IT™'J”7*ÊòÌ¶2MÓdÝ1ß‚<’Ô³„äÕbj*x	czÀÖÑñà-Ø´ ä(çˆ	/	¨À€½\$ºÑÒ<là8’õ\0ßB|i\$¤´š“ÃºQC/­+\$°–’ËmKMÁ-¦0æ‚Hm]d¿ |ÙÌÙÿˆÕT™ÔÖQ	!=N‘-G„žOÁ7DÝ”`@™‰¸b\$„™dðÎÁkeyŒÙ2J›3bê©ÿž§¢ÕHaÐTŠ:”QcuæÑÄ3F@ƒ˜a?à€1—¨šHûr@¤Þ¿ô®ÔÁu9	å<2`äICB‘êj)À@\0()\0¤Ž’d&ÒMÀo%á\r7ÌŠÌé2ÆaN'‰.fÍ* EŒ\\7‡u8ÜÖ©vA…@É´b\\°™²g—1Q.¢ƒÎ8pw¨â%õRÍ c“(h3¤xÙ4ëÇ˜ä\\œ Ä´gìçaL)h	¡7Fõº¨× Ih5šØœL	‘4±Xë·‚@‡eAF!’dð‚”J1\$IjU@CØŠˆÌ	S4	V6èDÃÉ‹\$ïv]#ÝM!› ¡Åqà@azï®?œ€ÆH‰£—)tÌ¼\"\nNIÚÑO\$¤žIÂnxS\n-:@Ôuèìù4¡I¹vI–•VÄ¥äo	¹H14‰Žœƒ>H\r²,UE°2 ™KÛÉ0Ü#I@BÕKD†ÌŸÓƒƒ‘3J«Ý`ÖnªöGR1BÈÏ\0s¨f à›ËÌ¤8!ÔéH2|Ãƒ³¯ýQH'ÕØcA4‹âÐa˜Y(7uuGœ0‚RŠ'˜“Eõ—nb9²~ÁÎãb`f	¸1èM«ôÐÈ¡’Šf‰¹¦˜™yfgéQ]–bà‹<‚2a¾;«µËCtóÉì€Xà¬zŽá6ˆ\0ê )³û#ª\$R¨ò~  ”cèqÈ'Òú€Ã™3P\0(-E£b¶¢•2ç­ 	Yê\0\neÙ` ŒxripN\nÈ‚tÐÕI€¡Ý>(å8_0‹TA&“œÃ^ÌÍ‘nYÁ­Ð6’²Ây\rL±E2ëbLLáºÜ–Yk[Éõ/¡›·{\0l>¨&%¸šë‹qö:qHÅº\\ØPFMD¥>Yðàòœ^O9Á>'£Çw¹Ÿ<'è¡p¨C	\0‚–.T>åi*#_Òü˜%ÔüNÃ[&j¾*ð^Vy„0Ìu\\i¢Jº´é…Óá—Pé´ù¤”â«ÑYã¼‘Cu@doHû+ä[l„â¶™ÔF«\0™á¬uU9Õ 2¼£%¬u™Ç)Ï—6ÏŠuÚêÚø7ì©CÈ­Øº¿c´Õ9²uª‹¡R\0Ék­6K¶¦ÖÕ{gblcg·µaÖ›-—Is´4Ûs\$ÁÕ)šÁ»ôš†/·nn¼–›œzÙúGx*½¦Îut\r*8žîI•yàØ§‡ðN\$d©Ïá%Tñ®º8†Ûâ[cƒñbAøÎÕá©ÓxÆÂs,½\"¡8å€J‰b—#îÙŠsò„ßói*f/­BÐKÍíÆØ¶»>­’šPÊ|Ì2áÓ¥‘GgÔÏ©ŒÀØ‚ê’cCÑîÙsA¥HÚèâù<ò€\"’Éí»\"ûð0y>/k`KÚ%b÷ùND.’ÖÎ«_\rÔûÂ©î“dSÉRÀ>1N‡FÑƒ±òk	x­tÃ•Õ*ÞstÂ–¨W£Æ%ÛÏnÆ¢¨½JtfŸLä¯ñ•hfˆÂ)Ë^IVÉì\0‡OZ–q:O	óãü’HLí¶,ß9¨ \0¬^½ù|Æ˜í]•z6cÌX‡î ‚h¡¸v¨“¸¼î­¬P_F\$\nüyaQk<¿î“­†õàäö/þþONÖïFît±@–'JÊé(´c\"%E~\rmæüÊé-ÌÓí{­x9­\$ðÍÂ‡ílÙŽ¼¬-ðÓî80=ðBo0GJûðNKMÈám<0íÑâe`ß°LÜMëPV0ç˜ÉL˜±!é/@º°–7pš!/LÞ°¨±­\0&v¡NhÇìr¦Ì„6K>WÏÒ‹üSÂL=ê°¨`è¨£d\$ à€`ž*bæ&ÂJŠãÂüƒ˜6©	 Ò“0Î´1™â¤*ô\$È°\rC\$|CÔKG\rìí\nl—L‚7ó¦~·LˆRlŽÊÅzWå‚ž\\U(­\0ðÀÅ¥\nC\nQ\\–°¼ö´àp\rñRanò(q`þ‘o„óÑW–ÎLvé'\0QZ¼ílìÑ(c¼Ï¡£ìÄ¨%…ŒMÅ€O2·fˆºKw\0Ö1€ÞeGžHé?/ë1Õ‘ØŒÍ±åLñ¬p\$ÇX]\$*fKÑ\rñ×qr¥åÐ\reÕÒjPgq¤úàÂá0æXŒžË#êé\$ò¸Æ)+ÎÊ´'p¯8 ’=\"ñk\0qƒÅ&ûòJ;¦¡!Œ¯%£ìp,©ÃîÏrL* É#Mn/¢Ï‘çÐ#¿'RA\$ñZÄx/cb-1ã!ÃìÊ‰P/‡8Æ†p¥ŽåÐ~ÞëÆŽí§+g\0Bn&ã#ØŽð:áÍÊä²Î3P[,R×ò½\$‹ÊÂ_¤Ü±¬†\nqÊK£vU·+’ûSo*ÚrTõ3,²Üñ¢ç1P°sòÛ1…³Öòèä“,SÅ2•gf\r€V°ò@”ï°'¢~“ ê7æ(%àŒ®(¯i¾6€ª\n€Œ pl€Ü{böT¢ði/E0ðvc®8ÞÙ°T'\r£ «8ÐpûÐ7“Šµ°+Ó†˜ø#mÞ:¤Øc&¨@X/`Ì \nOY! æÎ“VÅòr?)è7Æ&¶Äð&k¦ I:Ü\"Ü²¢÷“N0Â^	€Þ­\$Ì D\\`Ô7£¢>F<Ä\0È8\$bìÌ¢ÌÌìØõf6²B(Ÿ¢bª­BÐrRKvÖéCÏ¼'ˆ:64FÂPs\n1ßE#PCã2êœð†\$¤4Å™EIžQ¥ûEêŒ)*¨‡þ2Oho@ÐÅ¤Ü/¢ì¨*\\<	7IBt'Š\\ÇC˜·à¨«Æ³â°úíL\nÄL¦úÀàáFÆ·/€\"ßL¦\0·+íð†5£\08”4©áB&/¸#\$åÞ‹æ…*7D\"øXôONÊ6@î2‚;ÅF;¥4%ºpE&i€";
            break;
        case "sr":
                              $f = "ÐJ4‚í ¸4P-Ak	@ÁÚ6Š\r¢€h/`ãðP”\\33`¦‚†h¦¡ÐE¤¢¾†Cš©\\fÑLJâ°¦‚þe_¤‰ÙDåeh¦àRÆ‚ù ·hQæ	™”jQŸÍÐñ*µ1a1˜CV³9Ôæ%9¨P	u6ccšUãPùíº/œAèBÀPÀb2£a¸às\$_ÅàTù²úI0Œ.\"uÌZîH‘™-á0ÕƒAcYXZç5åV\$Q´4«YŒiq—ÌÂc9m:¡MçQ Âv2ˆ\rÆñÀäi;M†S9”æ :q§!„éÁ:\r<ó¡„ÅËµÉ«èx­b¾˜’xš>Dšq„M«÷|];Ù´RT‰R×Ò”=q0ø!/kVÖ è‚NÚ)\nSü)·ãHÜ3¤<Å‰ÓšÚÆ¨2EÒH•2	»è×Š£pÖáŽãp@2ŽCÞ9<12ÞÕ?íb0£ÇQÜÈ§sÖ²ÏƒT‡\$ŠR&Ë‹`Îª\nº|§%ªû8²	!?/,ën’LSÎù ŒL€œËÈ Œƒl% Þç8Cxè‘:c„g;Œ#ÆçpÎ3‹¬ï#›‚;.Ëw>8´Hæ;Æc X”(Ð9£0z\r è8aÐ^ŽõH\\0Í³|iŒáxÊ7ã…%JC ^-ðÛ¸0Í®°Ò7Áà^0‡ÍÎ³ñÔºÊ‹jhÿÛ#,´…!ˆ»Ê]\\(±\0ŠµTøÊlšÚ]-™ –¾ò½¢‚Ý‚ˆÛ)w®£ÉÂ¸Â9\rÔFŒˆ#>ó¡€N…(©‰a‡a,ö\"—¼Ñòœ >S\$_ãR:Æ^âHºHH'ixZžËˆÂ¾Dd¯@‰NŒ#¨Ù;ŽÃØ:Œ°­Ÿ‹ZMy R<¨ÕÈC&ë3þÎÜkª+ïìµu\\9s',âÌ’€‚wœ‘lÇêCöó±ë«;*§	Ü’sméÁ(òÛÌ’»Ü¦°H&fŽ‘ÍýÉyHYrRš¦ŠsJŸ]ðB‰hX)Š\"b	ÄÈìê5*±éŠ¥IãÆò¶éÅâ™^˜„ ŠÌªn½+1rq QÝZóï5WÉI°´°Ï\rÃI‘y|•—‹J	­Û´Jý’%«Þ¾ÔªJ~|¨z¥º†ÅÌÏ­¿{'÷Îgõ¶¯a¦MB „’2RŽÐŽÛ¼å„@AÅãwæàþßÇìCÁ×\rÊd2Ö(‰“y!†\\ÅÐ[±åˆ¨»SV’Q±b6\rØ”‚4c†€“&N(¤\$¸àY¸r7&íB)Çîƒ0lMå¬O/4ºÆB o8‹7@`uOÊ\00033`@xgBAÍK‡@åƒg(HEF›ƒpu:à 9‚’Öí‰>5ˆl®ºái\rÍ¹B\n†ùõ†¡úB`6E„`¥Ã\r!‘8)“z§ò TJ‘S*…T«#²¯JÅY‚ôäþƒ¢ÇV€ˆHõŒ„ÖRÌ-mà2xk‹€_¥˜ø/èIÅ‚—e‰ï!’Ä‚‹¢íƒïD¡Õuã‚¶jMJ¢ððJœ€¹L)©\0§Õ\n£TªT‡uV«Cr0ÊÁY+H\0 \$“W¡\$6‡–U˜t“ ùúœùÀ£˜IÑ5¬î„<œ%¬N6`]!!N\"„X¥Jå¦ò×i¤(Ëy(…¬j\r>É`l\r€€1à£|àa!„3K„ñåÜE¢q\"%\"åvN…\$A†p\0Ç0§igPØ!ò˜ùœƒ²(”!×‘’•,6#yÍq\n€H\nÝ×Ó—Ž¥#^&Üò“ç4P‚Èš!ŽHÇ9ÔqŽAÊ9•„§ äyÛN©ò‰ðïYYD,fÝn ÒjmLcÕ]ô),ž¡Cš¶OñU•‚ƒ„ZR2í\\0îvƒha¤3ª(v)Pcfª*¸“*è·dý)… Œåã4Ä[04ž.÷l[ê³*D\$B;Â*ZÖÓÆeåT„ÕJÓ(;™\$æ¹…ZÄT«Én*ŒŽ£>Q¢Ô-TõzFJ	ºJìÃ%yh(A\$‡˜X#Ýk\$JÎt£ž§‹<iÜ3# Û&‚p°È¸1Ä…JkR¶9¶áÚ£ÂNˆPHP	áL*T˜ìnŒö¶½[÷?¥Œf-­1#eØë‘áIbäÔY;R[×õ¨)Ì’Ú™)ö˜›ñÄuÜ›¯%ÈCL’<œ¥ÝË4‹ŽœHUŠŠY@@å°f¬@€ä¨PŒ*Xa\rÌ\$4ÍÔ÷oeî¼aÈà#CÒÕL]Äo¢d•ºæ‡nÃ¤«’†¤Âp \n¡@\"¨A\0(•dK\$CUOÉåþ¨‡¸•\0R³@ &\\ßœs›Z\"Nb	¡t€DZ‰ÏëèÅ¤Áeˆ‰>+[äãZWÚ²„Ì¸’73ÚÝXèÐ†¦%¿—•°óêkÀ\"6¸–Ú8'Ýr2\$2µÔJ¶5Ä\$h:ñã×…Þj#5Ïl±¡˜Ã˜“#È|‹R¦¼ÒZÌÃ«X	¥‚ ë‘P)sHjõÌZÑK’¿iwtï1iEuE?p<½ºì‰1>ÙÎÅ2ÚÆ‘(U«#ŒÜò\$2¹œ\\¤(Žœò°´‘]S– šR`&ÝeI©w#—zJËCS•‰¤û‘è\\Joä:«<“&ë•Ú¶càù™¯À… VPxiLö¬ÍØ´ÏB˜e9ur²nÆÙ¯–Òâ™C.vÂNHeéi×5ÝhÇ¹¹c Í`œ¹¸AÝ:ëHÝx¸IýÐçÄ\$ÄÜLöm©p‘çÛú,­5É—°‡\$Ôš&ÐVÚ°m§wÚ›Þ†‚awûFÿ%*O7×h{Á+A@ÊL¦¯ê¤¢N–…°v®)hZs9òLE¹zXMaP*†éF¥:03‚pÓ¸sO)î¸6Æ©@—èƒ@¥ÖW.†Áa8yŠ'P@¾nÃÔùÇÜyŒ%\"2ÔŒö(	URì?}Šƒ¯ÑUÀ%ÙüBù‰ßÛŒf7ïÁUÎîïãùkÉ*íÿ„ÚÐ?k˜4/Øú¢núí\\@¯ ûèÜ/ìx&FÿOœA…ø“Ê¢]°4Â‚¦¢žÓ~&ÇRÚgÛä6M-\"ÜïÈiÐþ´.¯æƒïêÃ¯îýO£Iü“ÂøOãÇƒP >O×/Ü3Yp^ûÐ~ü+™a BÐ€é 	ŒšQ @F@î\$bJ•.Œ,)Nkj.dŽŸFÕOàÖniÂÛàÚæ– Äv)\rH‚Ào–~ÇD ‹ü0äáäÄê\nv¬µæð_!.%´rìß¥¶Î­k~,€C¸ÝÂ,ÖCâÑ\$?/€[0”ÄJ”O*å\0”Æ„BÃVmäáK½0èäLî£qåÿ*£d?°„á'¼.0ôª*ðÀñnæÇ\"ëoÍoP¨±ŽÝ#Aqx?ƒMî²•–pbdwÑl³­:*#7´kä®ëc:‘¨M*‚K<î¢éOžÄN@ˆF@àœ¢8l«l.„@Ö§%	æDÛ‘Æ[\$úQè&1S¾”/üþ±z4Áp€æ>ìf¼ì­ d-”)läŒíN2ŒügÈ.\r²Úmì|ñt&°G÷Í°Ò§%*Ç”v«©CÍòM&D¤î2k2pmÂ­&'“'êpÚÒl.‘¦5‘}(±Ö*øóç\\{lþÎ\"Ì`>P\$ü±eÝ\0B2ýqø¹1+0ƒ‰R~¯öùðpÞ¯6&Å(¯Øô­,ð\\Rµ\$Rºÿ§)oÏ,04<,°¨£âîì»C%ÇE,n(Žì¹óR›³!0ó\$ï2„^Q¸ªîÎl\"æ@DàÓFÎÒ:.Ž,ÅBÿã>ŸÃâÙÂÀ\"qÂ2J¬RóJ*ˆÊs:*óVeÆ!61 FòÞ2ÎZpFíÈrïPÊLDlã¨’Û‡`Zï¾!-[7B0Žé0Ç/3cÖíNÙ9gÁf°x¢Æ·íÑm–-Šp¸óxuÆHqÖêÇQ1CI†F·6Ö“ôÑÑk4Ë?i3±·(‘¼ô¢±åÜuàŸO8ÞS)1q›2í`k¢¾ó´\"sûB&®ý.åQ´Ù´íÐB¯5DGLÒƒ:{¯L¹Vó±HcXy¤G5ƒþ®Žú\$‘:J†Ÿð”}Ð¢„¦û>Á òò÷-T1Ë*“-3—cCÒyIRJg(f­Ji/Ãî†Šo­[5´PŸíüuðÝäJw³X¶”Æhæ“MƒMÇÂÜßèl\\Åòôäv‰K&@ÕBÈïÄI´.¨iP¯C³ù2îø\"NÿAMK¨¾úCâðµ\$@HwtÛ8ÃÞuÏïâI!%å\$´3BfÈHõ\\&uÑì²-u[VU^U)ÏÔ\$‡UÍR“2áK“>1¯-JB­D¬ºnöÚ’¥A¯•O`ßâ†²ÕÒÆù¬çZbÒ\"<³_[èaõ¶Å.0Ài3Ôªª¿ôt\\uÛÙÂ=ÈoB°ãÒ¿./Ó\0p†ùuð`u3.CL¡/£`5rÁ`Ðš«œ\r€VÙ5~ñ’.ÏßTª*«n@ŒÈ`Ú«Ö²ëÍ@¨ÀZò+ÀBb„üùZÌõ–a-Õ¾=¶g_Ï£/Ð+fN]]m)5NªÜûÎ²‚ÑÃáv]\0š\rëÀÀóY¬>.Ä9)¦ÞcMÉ:®Þþ °=ÍÀ_‘ãbê§!•/ñs.>&:Òj]6Ð{ÑÓ1ôºà\$¦µ´ÔÏ³È,dŠv±0_N±6Ü\r÷F»2Âç\"Ö•p¯þ{³ÖûŒ4¹Îñ1ÄAvnHéf´\rÍq—qö	•d¨·+›qÊ~e’¶w£·;pwO)“Önj“¾®´ã¢uSÎ•2\$‰ê5‘Í0ÆB\0n’EmÒ•]’CIƒ)8‡D?æ83å«Òiyt’ùð*@¬O ê ÛY£umÂ'ho‚¬¿ã3ôZ·6ÄtËqìñížjÂ¡=ësr)A:¶‰/B&ÜÇ”v.&E\r4·64àÞÊ î8ã®òÂPûm~^cP ƒðø‚Ç§Sj' ";
            break;
        case "sv":
                              $f = "ÃB„C¨€æÃRÌ§!ø(J.™ À¢!”è 3°Ô°#I¸èeL†A²Dd0ˆ§€€Ìi6MÂàQ!†¶3œÎ’“¤ÀÙ:¥3£yÊbkB BS™\nhF˜L¥ÑÓqÌAÍ€¡€Äd3\rFÃqÀät7›ATSIž:a6‰&ã<ðÂb2›&')¡HÊd¶ÂÌ7#q˜ßuÂ]D).hD‚š1Ë¤¤àr4ª6è\\ºo0\"ò³„¢?ŒÔ¡îñz™M\ngžgµÌf‰uéRh¤<#•ÿŒmõ­äw\rŠ7B'[m¦0ä\n*JL[îN^4kMÇhA¸È\n'šü±s5çdymE8YÚáñùe*´Ü	‰¸æ™(¯8ˆÐ®ãç\0000ìR:\nXÚ0É’.ŽhÜŽŒïÈ6£¬êz½(ê°4(¼(9ƒªvÖ§Á¤ÓA*´]\n\$°9p@%#CŠ3¡ÐÑ˜t…ã¼œ\$Q*¾(£8^™í æ9Žð(^)ð›0ª,&žãpxŒ!òh+!`ÔÁ\0P¬4Žjè9£Xè:ºèÌÔÃÈAC\\¼®\"pòƒ/\0¬ÉÃl«®¤ƒò4ÀAM#ðX–7Å¯ó°<Ž\0UF6°³&ðÅËKC<)\r ä„\rt¬:)§o3&2<…\$x2ÎÓˆÔÃ¨Ý?\r3Kî Œã;ŠºÍø¦›¼	»ìÆ/C£’ß0VBà“<Ö „2ÚO(ç];(ð:'å\"èó˜d(èŒØO=’½5«½9p¥Ø)Š\"`Z5­0›Ì7Ðä²X¡;­­BPiLh1A@RüÀìÝ¾M¶ÚcãFBŠAÄ·Bpƒ0Í&,ã®\$£…Àä£Æl94ùÃ’QkÐ‹ã\" „X3“’:<£:B;\nddØ N„8#ZŠ­F3º”GxÚ-Ž—[ÞK«®'µcïÏãkrÝÆ8™<-¸„Ž©VðŽ2­(³0\r“Ú(‚µƒxÌ3\r‘\nh&A©L]d3á\0Ú2¼”ñ#2\$Ä52ac<[H9l¤0#ss·SÒ”\\\"7#É”¼¬A-œÏ7ÎÐÍ£]t=Kl*øïT´ê)'\\Ó±ü%„\rÈ,]ß.±ë°0ó^†‹ ‰óysˆƒÄ#—E`÷½J]e|)M´ÎÅ1üƒ!È²8é\$ÉrlŸ(ü¡tª•Ãp/‰¥Y¦”¾ S)­6› Ê–Ökª2DŸ‹`àhß0 }%ãWUÝS©& :‡`ê ª\rÈ‹&Ž`±£ˆù Bçè‘’BJI‰8;¥È”ßðrJÉawò«RúafÀ˜ªÒ<` `>kHÉÕ*ÒÐI3‘~\$eÒ1hZ’BÆÈÒç´€à‚Î NÐøÁ£pÖ)4^«Ü¥9ÇTÂQ 8Hº,ÅÖ¶<T\$®è‘B¨®œ‘R\n°”¹ç~‡™¤-Ò\0Ç˜Z×ÈBÑ1\$¤0µ8€H\n\0¶L\nFÂêƒ›È'DÜ2`PSIIyí}|H8I¡âEˆºD5ð@eÌÉ›\r&\nO³²v@b'FR‘øfzs-²5Þ¹òé\$Id“y„R’ðÜUQ‘ÂU¥é’fœa„*…Ñó“EØªÆá\nÈ®›Oš\$õ§0¦‚4¤\rä(™‚\0¦ÃKš%&9Ðê¼N*xÐŒ›“”^ôcÌË'ó4¡áHàe”ÈËm€‡9Áp^PpÕtæS	 OmÏve0\nîä}A™[ŠRêê©ã”)Ò)Añ dU¶X½`s\r\$ ™¡\0žÂ -FŽ¨ÖS¢ÝQðM#¬/v¸@X¶¥áÎ­“Š³´Ï2%bFã‰d‚(„	‚0b^ Ði%!*ÞsY«7¬¤ºžÊƒêBê¨Fl’1r½tIŽ»œ‹T…¡ÄìB  \n¡@(@‚(R	!8#ÙûB‚xR\nP „pjíj£T³|0ª`o]Tp—æÖ+tÙO9s©¥éà{Ž´hÓÐ:Díd;“E^HFºÔ\\û•>w'Ñ0Ÿ‰Ð× £ÊPUH&M~–ãwÙâoX×‘œ–FÅ¯B\nÈÝ@ôXÝ“3Ü½´³BP[R¤DE7Œò%£”·@¦G©!eHmÁ¸T&rRZUR¤\$ÖpÌG®kð*¼(¥.vÈ®p	p<÷xí³ÀM\r.	âbA¥”1ÙÅÎ†&ÅaEUIÄ“cr4\\TAÈ¹í:_TIe\$ønwEäð‡d÷!*\0“9QÉÜ¿B³\n¡±ˆ#•äx¨tLë°#&cBÆ‘såAûæQu(;?“}_fOmH´ê Óâ‹WåaVDå<¼•w…£iù\$€¼i£H”é\$1…È:M1]d#œn‰Oj9~F–Û»nÁÙjj{Oä\nÕZ³QÒ5‰Örn¤°”)^ÝI3òãOhÍoª5Ôv\n{g Ï£ÝÎÑØa,ÏâÕÐÙ\n©)Ôwªó_ÖA04•Ú{º	óäíM^{2ÉT\$–ÙÉ±ôì˜5¬–é\n™qWŒË5“Ú\\SºySæãƒ“Vè[~Ü,hã1ÓP¸ÌE•\nF^Âw{Š¶5™üiHˆ^~Œa¿6JE©BúÈm9V'QœtqðÓ{ù4È\\Ï“¾S°ùÚüå×ß˜ôØOøm\rí×hUI“×¾\\¦Ð dÉî\$Ãå««³ÎoO¿]ë0Eb¯ž¢\\ò/4–LW˜öˆŠª1\r»\0¡x¯0R­ú¦mˆÔÕqàÃÈ:ç¼°«µE™šEê‘Âé­Dšß •ìåæ‡a÷¶UßwlÛ|c<ß\"@˜\r›Õo'O’M€Bõ“°\nYçÏ×OE¯=)ôáËÔ¬‹&Â²Î[°¿›sƒ|Sý¾Ç\$iÍi^{æ¾ËÝv¯'Ìvå\r€¶Ã¹,Ÿ)ñ°Š¤j6™)„ï tUˆ‹!uÊ5}Hv²Í6”§GNa‹§´âêäiõ…,m›Åaï\\®÷˜ø¢â	¬žh.eƒÊ#Êk¢ý¥LÈÔå(Må÷ŽþæîB÷äí¯\$è†Ð&HP¬öÏ¢/Ï\0ç0FBÐ\"çÐ',Úèmæ0FPH¾Í„,ÀÌl\ndZ[Ì\rEÌ\r\"ð5aJ_ƒ4\$‰v™Ï:#®Ô÷°2¾0–õ°\$æ/VóÏÈäb}e–Z¬c.¿¢:ð@¡e”Y„ÓÆI Æ/å\0Påì>£ôWBtî\0‚ËÀäÌAÐ0ð,ºÌæ8°Vùÿ,Ñp;-‡lÍÑXÊiñ\0002eˆ\nŠ§Å¼<GÐ?q @Äq#4\"îDãæÅCõŽÕé‚\"ð\$zÑL|P…ñU\"¾ç¬	2CÏ\n¤É˜[Àœ¦ÓÐØ¿ÎÔÞ0{mB—ëù\r¤¶3¨_nú2bÐ'j@S»	#SÄòäËÙnnxQZÚpR1¡1Aju Ê&€†O`Ø`Öq*ý)Â\"å‚Xg´~0\$5)ž*öÿÚžcP\0ª\nŠ\rÎÉžÕ©\n…àÒ±&x0NUmÆ­Ù\"i\"Í¶}‡x#è4XÂìÅ£N(ÄnÀ:ãŠc…ÃãÌþR\\Ä¢rîª	£…ñö¤çÜ¥Z Dh@=Š¦0j¤'Bj/-Äê'p”èÑÓÑÖE@ìax1®tû2…çSrœèµ*-Š	†çò³\$Ò4æ°.÷Ð¡*Ò7(/\"r=,êÎú¥\n>å®tëèÒÐ>àšébŠÏâài«’üîêæäâ«ècM|ib%Ñ.2~0cÄ.à\\+tÉ¢ü:²_*£|0kµ+ÂxF\"¤à‡Th„4+®Ä2È\\*eâ’¤rñÀ1î\$‚¤'¥éEU\0";
            break;
        case "ta":
                              $f = "àW* øiÀ¯FÁ\\Hd_†«•Ðô+ÁBQpÌÌ 9‚¢Ðt\\U„«¤êô@‚W¡à(<É\\±”@1	| @(:œ\r†ó	S.WA•èhtå]†R&Êùœñ\\µÌéÓI`ºD®JÉ\$Ôé:º®TÏ X’³`«*ªÉúrj1k€,êÕ…z@%9«Ò5|–Udƒß jä¦¸ˆ¯CˆÈf4†ãÍ~ùL›âg²Éù”Úp:E5ûe&­Ö@.•î¬£ƒËqu­¢»ƒW[•è¬\"¿+@ñm´î\0µ«,-ô­Ò»[Ü×‹&ó¨€Ða;Dãx€àr4&Ã)œÊs<´!„éâ:\r?¡„Äö8\nRl‰¬Êüž¬Î[zR.ì<›ªË\nú¤8N\"ÀÑ0íêä†AN¬*ÚÃ…q`½Ã	&°BÎá%0dB•‘ªBÊ³­(BÖ¶nK‚æ*Îªä9QÜÄB›À4Ã:¾ä”ÂNr\$ƒÂÅ¢¯‘)2¬ª0©\n*Ã[È;Á\0Ê9Cxå\0­åÂœOªÑ2~)#›î6µnz¬Z*ÄÊœ°¬ÓœÎðŽSÊU-ªËI\\Š•ËÔBéFÁ@ª9Ìô2/Î\nù)IJ•6l\"ÛD,mEÑÈŒM%Ã²YVAñC&E®ŒâŠ\"Ðl™UÄB/­N Œƒl‘3„ Þ÷¼cxè(#„ÕgŒ#Æ÷Žr@Î6Kìÿ4 @;/Ë¹j<×æ;ÍC X–èÐ9£0z\r è8aÐ^Žø\\¢ØÃtÎMC8^2Áxáu]ƒÈ„L\0|6ÍO3MCkì4ãpxŒ!ó\"4º\"èT­Ì)ÄJu6¤)M¹×4Äß[¥‹5—KÔcqŸÁð”¡`GU\\Ã'\rêwÅê‘QšjS¦ÊQÆwM6íÊšÒAª¬8ðÂÝªb‘,æ62”ÃhŠéŠãä7[IJ2FZñ\\Ù‘ N÷¾ç»üßeKÊQV)m”1–\".”ê3Ð‹r¯Ê)ÒßgÒ‘ÍmÚ¢\0Tç‘8‰zŒ#¨ÙgŽÃØ:Œªû„›R	Nf‚ ù·#£pÆ:drBåÖ*±g™1)ø‚3Œ÷ Ïä47gÇ/ªù€OÍíF*|k¤ñu?#ÒïµŒ®ÝÂ³(D¼EoEôh‡+Gô¼ì°€R¬™'Q½,PãJy¯wn¨6ü{	\0c!¹\"…˜RK†7ªdˆ¼u^ñ;Oý¾s‚¨Úã-AoœÆ€”ß¡iÉ¼%7\nçËàmÍ5_øNè¡SW…‚¸Ö“k.GPÑ¯VØ¤ÑX…-â»(@Êà#U6·è€òMCoÐF3ƒ]‘Ò†±pŸöh[àÓ>naÉx|Î`«á:ÄéË=¤K	T(	&i¨g?]IüØÁ\"SÒ!hpÕ.DgðãÕÂŽÏUñG	DU4Šh…U„@„ì™ƒµ9ñ`¤»–¾éÜ<F\0&¤Ì¥Q>ºVPð}ÞÁh[IÂ|\n˜t=	%C=q\\ÐÚ:¨ŽOM¨^Uš´XE!&;Gü–™Ô-í¤ÞEâW\r]\"ƒÎAÇ ùÈUæÜQF  #†PÞC,Â5@)Õ‡ vÎëv<A¼3`Ø±ÎŸqM¡˜6@¨Ï+\rÁä;ÐæV²ØÎ¨0Î’šïžKqç¤€AGœ§Ü0S@e4€4-^ª©\"ÍÊEQ³n‚ÓHR÷`Ëc1%x*ôÂ|àr¡«e\$‚ˆÁS:ïl…l†E¼Nòô^Ëá}/ÅüÀXé­„°¶²¥ƒÀd,PV>’Y%M\0[¨’Ô…áI4…3³–wº£\0¿¦%½À\"\"sAsS ïòd=HdŒH» \nõ_©§ÚB\nðM\\'Þ¡0ðæº×jfÀ4¯@É`j‚ó^«Ý|¯µú¿Øw`k­°€äÂ˜c–ì1lÖ6*Áô{(F™†JÒ¥ ž™¾+„C[YáÁ3Ð«{ZÍmD(ÖÄ\nã@ÊÃH*V5”§òâYš\r/„ÚÂÁ+OAâZµ‰2®@ÙCâ¹Ê ÏøC5”ZFËÑ8E¨òä?'Æô’\0Ã<\0c³Öô4ºévg‹|m”hLKipß@’td £¾‰2cÁ\0\n\n (‹¯Kp™Ššs>é”¤LŽføìÐÙwëhøžSÎzOYí­ñi è|ÚÍZ—¼7‡|‡/'…3…µJ4ÜnËê»Ø¾êszoÀU=Lìhø-ÐæÃÖ½L§åàáH×M—b-ð;Ÿ Æ.iëä_x PuR…x!…0¤ŠA³0Ñ0¸]:ÞÍféZ…62ß]!3`…ÖÃºÞk^üj›®ÇˆÓ¨#»P-ú2Ä\r-â¤’Êl©ä„Œ4WmÑ‘ïVùyMÃEOðÞÁÇD_x5­~ABÀÉXc›¸€ßeÜžˆfŒ*°ûZi£[]už’S'Rië ‚I'qd†–øyz”\r×ýè]‚v™4†Úk5BÍ‰”1”5Ä~rK=ÇvTõ–¥ÙLŒ\0žÂ¢‰ò^nìÙ4ÊU\$˜„îfF<·¹vÜ-Ãð•	ÊÎ8á§3<‡æ ÒŠ–ƒ6z¡Éè&PÉgC.;<8Êm˜Ó:76¦žû²&R‚PÊ*ÜÏ¹è8¾ò =Kt#LKÛài™¬ýù;Éƒ`ø@˜ºu´qYg:šÎ.¹„¨o	±vÑÄ ðœ¨P*^ûßÂ E	Â¸Ã@Žy~âîpÛ^£f|ÍŽŒr5ª¥ÎÈü(¶ž*UÂy‰Åß,NÅ¦pº/^2y[vä=¹ÐÙäµÕZi¶×ØöšBÂ+äÃ/y©Æýò\nE°í	?Å]ñ½Oóß-!ÉBêµd;»H«Î­ç=c4ó9IF(¦ÏÊÈc'ùœÆñ©6D__t­ïí'ë=]²y†TýH†þÄxýï”jDv‡î\r Û¨¼ûoúûÎ>/.Xú‰m¨’’/²úÏ\\Æ‡\n×„h­ì°ÉÊ†ÂsD®NxÉ~\nÆìÁ£þ=å JXD%\\%0\\,ì@˜ú5n\\ÖŠþsnh t¸#òM êÏ`@ÄlJÂËhx)d8åÑÈRxï}#\0l¦Ü9­DAÊô\0¤^¥è`ÐRÎïò­ÏP‡‡¨ïf˜ç.\n`ÒGbÇN¤gb\n`Ê=‡~Èg*8Ë\$²ŒŸðàoƒÔ î”º¥Bpõnkh ‘G.…°Ê.ä‹pLR ’Þil(ég\":fü‘¢*œˆ’.Œ‡b`Bª—ÐÎ1ˆê÷ä¤èªuÊj…nà‰Q*÷‰BØo€ÚY\r‰µ\nðŒÎ8Q†ö	IM¤‘ˆN÷§jVÎrEhx`»qˆæfÈ\nJìõDr+á,hR”B\$ÕéÖÆ:>ÅR,¯¨\$‹¨Ä/£°`.±õèã/ÖPœD)¸-	\"üòmo=h—ÃŒð€¨ †	\0@ßÎ\r%˜ŸL”Z\0àÈ£î³ì {Ð×‰ºýÑ\"&°qCzüš#føŒÒX¦/ÇapFøò1A1.õ¢ÞÊŽ^ý­¤ôÎDCM^GF£¦ÞÔpÒÙD„%Þprlrmˆ….Œ»ò„ÿ	)`\\,¬F’BÑêS i3¯q(¯¶þæåÍ—)²jû±)ïäòÈPlHW(ðy)&þQ\" º¹\$r¼Ðãâ˜Ñ¯0\rgR®‚ÈÇîRÆl>;2_+gâ„2‚º°,\r‘,ð®ÿâ#,Òí*ë&Š÷\$\$Ò/¸‹¨ÎÚp,FÍ3P³5M`ºròò4“](28À˜ìEÊÒç†’MræƒªøŽðö´'îž(‚Ó5¬]««8É8ÑNB€(S”(³)MY*†áK\r%Rüõ6O§)ðh­ðmÓ%l&4`üONvÏ3.\rq9Î[7óï.„fÃm4*qbÖe6øQÌ,åz)þÛ3Tò««sŒeFÊAë4¨o<üü&‚õãØQ~å	-‡Æe²¤ûD06bZ\0†=†ìPÍPp²É-Jeã†‰¢\0ˆä0Šî`¯ORI¯êû“9Òî÷m˜~ð%5­,™ÈbÙsCÉHÒ¬å”‡F²IÒÎ ’NìeQ}I³ùBÓ<§q5òKCM4þÆþÓ/3´ ÔôÔ±Ñ¶°TFiÓ½/³\rMtÃ\rSGMô¥H¬V¯OJ”Û¢ûM”*éÎ‘hÔô²ö÷Ç¬ =p7æØ‹ª§!‰¦NÇRunˆsðŒ2rÄ ˆM à–B5@©AòÉJ#RÌZ×rsUõV,ñ ’à%sgQ¯¬¯òÞ‹Ã[Õk-Ô)4YNäjôæAÔëHU	X†c*\r4œèÅu’\0¨+™ªR÷	ÎòF\\vÀDÅ\rWUmZ‰2ûuÒþo±Oô»Iõ¤‰Ïù+¨¤‚§ÈòõÚ­ñiNM*³1OJ2^X±\\º´lmÈ•OÔ;PNÕß_u_ÖY“©Yó]a\r—P…z+ñá3¯Tº•‚â]Bs»`¨×P¤1R–\",©-Ra-©JÓVYÖ:…´MGv7dr´m±âÓ±é^ÓL…¶]^Ô0Öf)ÓÈ\"q=£\nuCÐ‚Hk=¶£%2ðý.Ø&ÑS2nUëbµï`ò”°Ë:‘›m6=VAKÖ0éÍ¬UVã©!ùbtzÕ´ÓbõòÃÔ’LTIqòcXÊq/–»Z•Èæ±If¦šøšdƒni×Z,«adI	× ÌÌg|È`@ðrÆH#•~hŠðA³×6ÕûrP/Ž’ãÑW·Gq“ÃD‹gs‡sQq1c¯L÷š•ÃqÖtòw#W«V5g4«VÇÉSO5¸  ¬dÃW©Wj*'Ð‰¼Faw‹Ïn1nu¬ï)U„ñ`ÿ’¨ß?‹‹H/.6äú×„¼×±x·¥1z’t¹@qivåk–{VŸ-±˜luþúôyy—	`Õdx1cö~Ö#!V)K˜+LXE‚â÷0„Ô§O·‡tûbÚE< b~£Â\rÀèÆTÍeó7t8-nîÖxsgxv8|·±ON(um¸C‚ø“‡ô7¢\r‰Øˆ7}XiƒÂ!nõña#†è#‰e:w\næ¸Ÿˆ£Y©˜•‹8›8Ý‹¬e„ì­…4hHQâO·÷;tr'ìRP×È/‡mhøtJ-óÛT¨|µ\"º¢ÊQ°®üû˜iVe;µÏ}vaN˜L=hñ‹i2á‚gÓˆ¸AfX­“öe”*ß˜Ãˆ–-tXDw‡|½–ëlä¥2°&ykW’Y|ÇfC‹é!!i'˜r¾)ÙŒö¨‹š%™™µ,é';€é%~„m;o¶é”xÅ”²ëpØÍTÈ÷å&YƒƒYÙd6ß•…œÑ‹ç›XQ”™a;øË…¹÷ž+\r42e›0C~/­Z€Ó!xÚ†W›™¦q‰­aøé‹µR\"'ºF§ùj£>´mxUˆÉµâP8;¤qÄpúO>yë.xWžZ\\Üòû zIekòá—z”ØY‚à\\+Ò–Mv¡–ÐÏE©ÕFÑÄ}0IX™'éO1öô7ƒªÿÙ·uèAòO†ŸƒŒÓ@Âl½1,¹œB¹!SÓ.o­5ZEöñ6È±/‘‚E&B¥&-EïÂpgç(:írZó5oª8Ò¢ØÁ‚´‘•ÎŽÍ_kèM+ß²ÔoˆÑù<ZogÅU³¶„ÙÓÊi„\r€Và Ò`Ö•¤Ê[§Zuãð¡ ÞçàÌ¡…Ê+ÀŒë ÚÐEžÏÊ<\n ¨ÀZ	^©n~I\"½²µÇ,fèðûW¨1nÇ‹Ú½§9óP{Cº·çegÑ»1:­kt³NwC{ {Äÿ3ch-~çP<îÅS*)ÆÒ°FÜö5VóUà›· Ó·ôˆèøk ØçªM,J\"¾&Ù#}ÙWÂÏG#8y•µÞA\\3´qºÅKÈŠÔ7Äw¦\"Ä®?m™;¥à	“”¸F2[ÃûÇ3”[ZC T>‚6‚”º²ˆK±ñ âœ=šôrÅ7ë­®^‘h C‰¨Ùw”ì(˜GzR:¤ü§PÆ»L¯‘÷¨ùÛ—™fkZZ‰U®–úêà+—×m†mçË¤Ø‘k¼Ù¿VÕƒ¹uŠ™Ý„@¨•Cà;ãÂÏ Êa‰Z5uu	ÏüË®Qû1y/¿ÂùÒÒQ63O,A¿“Ð›¬Òà™‘Æ 	Qú?A˜zI%ŽzQþ„ZSƒµæï—.ÖÇü…¾\0Œ^‡cjÚ)XäO\0Æ ê\r´‰ƒöc“d¢'àŸÒÀmÆ†Œ8x @rG¸ø8·*0ÊëÈv[²LUÓ5yqOj'à¨\\¾>Ûøw‘µI@IÔeök/íÀ¥Púøõ÷>}ù†ÜÎÓ/¨JP\\P`\råãÐ>îì®-cÐ·‰nì†bßÍ=w£uù}LDà	\0t	 š@¦\n`";
            break;
        case "th":
                              $f = "à\\! ˆMÀ¹@À0tD\0†Â \nX:&\0§€*à\n8Þ\0­	EÃ30‚/\0ZB (^\0µAàK…2\0ª•À&«‰bâ8¸KGàn‚ŒÄà	I”?J\\£)«Šbå.˜®)ˆ\\ò—S§®\"•¼s\0CÙWJ¤¶_6\\+eV¸6r¸JÃ©5kÒá´]ë³8õÄ@%9«9ªæ4·®fv2° #!˜Ðj6Ž5˜Æ:ïi\\ (µzÊ³y¾W eÂj‡\0MLrS«‚{q\0¼×§Ú|\\Iq	¾në[­Rã|¸”é¦›©ž7;ZÁá4	=j„¸´Þ.óùê°Y7Dƒ	ØÊ 7Ä‘¤ìi6LæS˜€èù£€È0Žxè4\r/èè0ŒOËÚ¶í‘p—²\0@«-±p¢BP¤,ã»JQpXD1’™«jCb¹2ÂÎ±;èó¤…—\$3€¸\$\rü6¹ÃÐ¼J±¶+šçº.º6»”Qó„Ÿ¨1ÚÚå`P¦ö#pÎ¬¢ª²P.åJVÝ!ëó\0ð0@Pª7\roˆî7(ä9\rã”ŸÄ„´ƒ¹¤Z„Ô»±b8¨«+ùq1ña8³0ÌÂ¿¶/\nzL«)ú5''ÅéQêÉ Á Si'qyJæS³{J¬î”é7(‚¾\\1åœ”žÏîm<»Õ…W;CN³*©œ¢ Œƒl«7 Þþ>xèpá8ÙãÆ1¿ƒœª3„\r“Aƒæ÷ŽãLôÚ¯Ä9ŽóˆÈå¼4C(Ì„C@è:˜t…ã¾6-9N#8^2ÁxáuÝ£È„L@|6Î/|ª3N#l4ãpxŒ!óŠæË,,XíÖë‹y\"mÓ·J©“!r­¦iûÃJÏí£ËR\n4`\\;.”’Ù8Ú²ð£‚/ iL‹£ÆŽÞ£2<R[OÌe=#\$Vr=¤²p+Œ#ÝmŽiÈ“9PÒ]@ 	œY,Ã‰ÜhFP+šRª+4švžÉ3áqI¸%Æ\".	Ü³Y-²sm›Õú<Y6\nÚºó	@\"^Ãê6Yã°Â6£.”»ðÂ¼.B¥1Gqž¾\\i°Ò¦”*ÊØ«´›\\·.‘3¶:D>€Ÿ»%ÆŽðñõ|9VÅ©ë‘a%QZ\0Q+5Œ•óºž§z:{¦«qcÃËÉRò|¬æµ—®ïêë·ZB7F6?Ðcò´a\rÏˆ\\9*QH \naD&5PRÐÊ+¨ôãÀæ†ÑZ›ÙjÈˆð©³„WYj QŠ%˜0öàÑ«hb\0€ÊÇŠË<TÅ¢ÂðÂ”ƒ.cÄ˜ï2æ±”z¥{HµQC„È\0˜íÑ	?%l©¢3É;ì®#3byQ»Z8F¡0¸\"¦”áÞˆj…˜„@„êÈë­sè%ÿóŠm\rÑ´ÃŸØãÃ(x@¡¹m2æƒÎ\ni¯±‡Ü(ÍzHHˆAH\$×x;©eáœ3„Ñß¹ö 5*úžZ¥8DÌƒ4âð rG õ6“ÞÃ0f\r‹¢ÆV«ŽÛWhhÜ…@Þ|˜ðn €:ÇÀêµÖÈft`€6ðÎ•CšðÊa†ÎR¨ › •·¬`ÜP((`¦ZºÙpõ’<‘W’JK<ÖŽî“,p§m r°bh?¬p9LE´•Ä›É¹x8üC\"È^G­z¯uò¾×êÿ`,\r‚Ð6˜Së*9‡F@ÃA>£Œ}+26JVšÙ£ðò/9Xá\\6\"žKªb.%),pÌµS¨…T@¬¼/±xé\"ÇšvÙÉ·Q¥`&®\$?Xxs]‹¹6‡€àW¨dËÅyÐÕð¾—âþ`;°F“p.a,-†Ç˜÷i	!´8ÚÃ¥&ÑÔWuÎÛÏý}!­,ðà›¦\rxÄÀ¸f„ßÊª‹Lj8…@ªTÈg¼.[¡Ž2@¹CcüG¾Ã‡)ù]ÛxaÕ=hLu±T¦Sü™³=6.T¬Ðs5Ü:³^K§çPÞ#ž†‰ÁÒi¨ÐæÃ)LïLc-ââä˜û—;.s'o¦\0\0(1\0¦!HOu»ƒ%±¦%§QU*à(!²ÑgÙþ>GÐûƒô[zÓAÐþ •šµmoøÂ^¨®‰ÒI¨¼í›>Z,ÊncGõo6¶&Òl@ìh7	Àºª“máÝCšúC:úŽÜøW'n³¥BóÃK\\  aL)fàuK†IX[CËª`cˆ…B.ÜUtêDéÐó=Ò\0ä\ní×½Á¬)RØÍnãX,-ý,•Wf‹\nél.ÇØeS’sNÛõ¦³¤¶S™Øã‘;¨È^:•€’ICÉéY4#­`Aý^¡ÅÔ‡5ž“€m 5db4Øæjã·‡Ÿ¼c2›C¼ÅÃ'³hŸÙ{ÍsEÞÈ¶Bìiœ6y²¸íâÊU*ù\0ÍÁ!Ä³®Qh.dõ`•ócªÌu|×¥÷c°ZÎ[ÊüÖž}\0Sb™¬nã<a ` ×øu¼‚¥à€M¼4×E©6´¾™ÑÁÈ÷'(	;ˆ;³&j¤ˆ²Âàò›–8.î\\!E2Âp \n¡@\"¨@W\"„À‹ÅÛêƒGñ»¡õÀy=‡Ç=Z^˜–sN\n~åñ¦ìœ]ÚôYS±ÖCç\\á´F’ÔÂBòÓ¸“¶kA+.ŸB„¡ºkXCJC§uŽÒÍa§Kâ0Aþ wã\"09G[aB<+ª2é\0“¨Kj”³’¤*YrsÑ®ã¦†Ê’Wk„£°ª2ÔÏZØ¸ï]~w×oÑ\$Ì–Í;^KTºý‰IÆ–\r¾òÔ“b\n#\$'÷>2¶’–.gVæ\"¶ùžØ »×€ÄEVš‡¥Ó&y÷ÐzÒŽÙ3mCÊÅgÄ“þwL!^K£3ð¦CÓª¾µÒp:ªR~læ\0ëij¦Ôûƒ,þKo>á”;ÈéMÎZÏÅ-Á¨\"ºL'cW¼íQµsÂÍPçæ%ìËÜp	³'~±ÐÍÃ²÷„¦¤…ò¦–qmŒeâfàÈ *|à¨„ÚÂ²B‚~oãÏ¾OæøÏð&ƒü> Î?iTDFþ<'~vo0;©þìDM 1íZ}hÔ\$^(ÃŒ—‡nEíV+†€q\nn÷¢\næl¢ìFïÌÆð¶ f’²KÞƒàâÀ¨ †	\0@Ò„Ü\r%˜•ÍZ àÀD\n«HÚ‡jÚÌ\"1îàìè†yI¸\0^3ÖD¤šü„Wbvi¤³	\$²&pÄÈ8Éêwx;mîÊÌƒ¶~)Ø~‚æ÷£ŠÉ\röL¾-PøÊZ—ëj€eðí	&+ßˆOìèì(UèœoÑØ0üî¢³	Õ¤E\0	ê\\À@N\0îm£¾Ch+e&÷#”2È}nÿ¦†é1…pÎ…K á\$ÿ	Œ¸0D5¤|pÄôpÉlFø\nàÊEÆß…ÝgþöÈ‘&°ó1¬DÃ&*3ŽÌñ x‡ ²†9¢våBäpÉl‚~G#Œö-\\6b\0å‘3„ö9±ÿ©ÒN¯^‹!hhf„ÐèDÂ,9B¶B´k\nZ|)Òñ\r±¦†îb H\$Ç¦…B~-ƒÂ<ÑV¦d;ß\$2b<hy®cî’húezÛ±&rQ\"ã‘#\$P‹/ÄfÒ(îþÿƒÂ82š‹†Èì’ŒžÎRäoÃ'Àä1r/íHÂí¯Çe1Ò|Fç€säàêâ³ È¬vd(oåC„h+fj{’Rìˆòòøb\0PQô”GÕ/æµrï0¨\$|E1\0ˆ.Øi(8zSBF‹)òµ32ÂÙH|ýïÊ.oÑJIÎN*+ÂæŽ\\æã„àS+jŠë¯3,Ð‡±K\$ªe*ö‚ó(.s\r+/6ò²w†M`‡òÊï“ŒÊ¦ËÎÅ7ƒšýS\0hTë9¨Ç8Ó99	C2s\\9¤Ê3Gˆy¢»'’ºi0/¥h?\"_fà;pã7•æˆï Id.œàPD¤U‘HINå7s;@•:TÊÙ;05Æ«BÒ\$ô@Non&ÃBf±\$“”ê#Q;áN8§Žë&±§ª’Hÿs–È,sLDG8{'fÉ“BÖ3<ˆí•;¯ò†jàp{íwð<PÓH\"þ3IFPTíÄ÷E¿sÛc¾o^ooÒÿ”lyÔ=Î×Ž	@Î€’«L4jÿÇ¶‡t†äK)\"¦‘°4iÑG&†o4xûÆþi´*h\$DýhSPˆWA“À;µ?Nâ7óEu\0;´LlT±R.ìè14ˆîrpÐxx±ˆ Ñ˜ìÄE\$Ó§3µ<‹\"ÙT4ÏA\$M:µ:ô3Q±SwUQæ§[R¨­RôTîÓ¬hÕýÉÙSõVÛEôNkuRk5Ž‹U“<\$Šeô|êŒÆ:#h+¬Ì‚‰Xäjhòäg\r9CÃÈ—[5rR¦˜ø`¤]'uI7Um]©Á]õ´5PÓ±V‹Wà^Š<­áÒ£9tSC•7²)XUöýÀ@@Ü¿C2UõVv>€Þ[\0È¥êŠ°Œ<¶˜¶\$€vEæN5c‡U%’9¤¹ôpÛ‚ïF	4úë€©ÐA`ssAumg,aguïL3}a–-2ögE‘hp‹*URV‰ah3a¨8äÝcÒ¥jÖ•1´DG‡Y§W5£T±9	R3<±ÓPðÿjBó+\0Œ¡	%Sm3	¨ƒVÖJð6èQ6ÕÕgm¢°	Ä\ro=3è©ÒÎ\nnÎbz®—æPˆç\\E¡k>Ä”—oW2HB‡ ’Ž_Ñè ²6fmÈyG8²r¯[‘Ïsä+1òa<rG^3ø9²Ã?î[oI\nŒ„š`Øm@\r Æ\rm‰1S8Ôí#RÐÛ§òÝ€ÚÇžÆ‰²\n ¨ÀZä ÀÈ[q=ƒ?5\\;b»óˆ§WDìmY5®Œ½—&äN})’¼5f¾@	 ß{àÌ(æ¦^R§ 9òô‰.gy…EÁnãhK4µ“UN¸S·’9ÈÒ¨¶XrV£nçfN½2b¬+\0˜\ríÈcê[äxI{ä¬p'²gÎ·-,ÆÌçnw–ÎÿC›\"tÍ.·èèuûa\nh	§dD©Èø—ëiŽ˜l}s×HLg!*˜“;x?6Ô‹wØ¥‡ÔK^6}_À¨£ú=ƒÜÆ`Êaˆà\n<XÏ²±hµ(®èF›P3!]§DÂ+¸³v®v“?Ks™Š³œÿ7ÿ5¯QI({13ˆÿ‹5ƒ„|®qÓDIÏäh’ç‚øéFKn|fž\nÅ¬ ê\r°\rON…ÄêR¦þBˆ””Ö^'¡=Rg©#„N§‘ïÕÌ‡Ç©,®l£¶OC¦çE_1¥r3–p§±5Ä8ƒ³¸ÊNúF/=˜Î­1\"JËà\ríúãê@¯yš¥&+¦kU†è½«˜’vgBã¶rÂ‚\0	\0t	 š@¦\n`";
            break;
        case "tr":
                              $f = "E6šMÂ	Îi=ÁBQpÌÌ 9‚ˆ†ó™äÂ 3°ÖÆã!”äi6`'“yÈ\\\nb,P!Ú= 2ÀÌ‘H°€Äo<N‡XƒbnŸ§Â)Ì…'‰ÅbæÓ)ØÇ:GX‰ùœ@\nFC1 Ôl7ASv*|%4š F`(¨a1\râ	!®Ã^¦2Q×|%˜O3ã¥Ðßv§‡K…Ês¼ŒfSd†˜kXjyaäÊt5ÁÏXlFó:´Ú‰i–£x½²Æ\\õFša6ˆ3ú¬²]7›ŽF	¸Óº¿™AE=é”É 4É\\¹KªK:åL&àQTÜk7Îð8ñÊK')šNgI,ên:Óõ]“gn|cŸŠ7Ô+%áÞ1>Åˆ#(úÊÄ¦.8Ð0ŽŠü ŒˆÜ*#xÊ9„\n9Ž£€à’°£ÆÉŽh0Ü3„¸É.æ×ãHè4\rê‚.8FC˜î’Œ`@\"ã@ä2ŒÁèD4ƒ à9‡Ax^;ÊpÃ\n Hð\\’ŒázbÇ‘L~9xD¢‡ÃjJ× C2J6ÂK‚ã|“Àú 2³`P²0Ž	óX²³Ö@èÐäÈ¯jðÛ*cJÊ:A+sœ'Š’©IÒ¢Ì\rlî¢Êbúºa(È›0C UUƒËR%ë“¸*/˜²’Ž£h'Žƒ|áJ3å–.˜¬þuNíÒý)Ï…8#8#Z’6OãUF²‰•c PÐÍãº#Èë– ­—(‚=^.à˜4 -HšÏ¥‚0¥‚ÊËRÍË¸®lc‡8oÈ¦(‰•„ PÃ>Ô-;w<¸ø<\n P”Õ\$OÒŽ™ŠO\$Vu£‘ä VO”„¨ëIŽ¶TdË”á°2R•¶TBRÍÀ\"×…\"IòÊþ(z6‘®YˆÙ™ä™¨—OYÃò\"@Tg>ˆS×(¹ˆäÝ\rÛ‰\$»[t<=ƒràŽjB3¹NeTRÈøÐÖ„¤á{=ObBé¥-Ø4Àã-„Ï£àPØ::f¦£ãhÉ¥éö{I?,Ÿ\r|àË0á\0Ì0O®bŽUìZÍÎ\r´.¦ Ë¥\0Ÿ\rœÙbUõXˆâ\r5€á\"ï`Öáìèì.<´I=šöP&—S=pæà¾¨â|“Â´05¾Žß|©§Ý2Í¥fv5uËtŽ£íˆHÒD•&IÒ„¤•ºVK\\“%Ä¼y3m*Pà¦`|@±,®è8'kÅáeQ‚ð7'Dìôƒ²jå\rœrfïCªB\r…à:bbSÌ#%‘ÁGÒøK:*™#œbÅâGw0œ2P\\l>å\rZ°Â†º	c÷)%%¤Ôž”RšUJïŠ‡\$º—Ã+p&-Î&pæ›)L&qøAà|¨+ \rÐê’:¡Ô‰º4²&–Â|ï‰3`d‰!&rhCk‹3¨6r`GÞÉ®zÂ}¦²EÃ|!7,\\S»Ç|ÑÖƒÛy`4C’§ù!2m’pª½rÈ4„I\r¼¢B…ÈP	@äKu(áÈÎ\0 ¢‚—ðºRz)…8¨2 ØøÊ¦qøX—ò‡ûÝ–G†P*‡ÒEæÃÝ‚Ä\\„Æ°H	çq­9cG\"\$Q6\$:`p¨òlC„\\9£Ã&fH7M¸8Â’\0 ëœ1·òÒa65ÔM0êŒÉ8GZ¤zwL0†ÂF˜Á¨ÏœŒÀr\r¦,2¼³øaŽÑ'gó˜—ËvÐêc®^¤Ag3ÔZYdóß2BâÙTÑ˜¬rƒ\rÌI<p¡–<¾²<Â#\$múF£¢ŒÎ1£Dñf‡—WÕ\n<YÍÓˆwR‹Ày/`(ð¦\ri É\ns½Z½›éwED‹¶SKë‘#ÍápêC9ïjGðâCež÷–MPÁR^F§%Éµq®sÉ³°ö\"LÊU>®Bðä™éºÍú >=5ÐkŽ#\n.Bv½“„ú-m)0þ7ÅBªÏRe8+ðœ¨P*Y†rHyGÓ@@*¢›dÑÅÎÐÊ\nnuß¡0\"Ý[¯vC5Û‰8Âž—q¯5èVŠÙ»ãõe\nc”·úWžö¦Î]Bç\$é˜¢9(N	Ã—§(,‡[ŽPÌeÉA¥Á`pÕöbžŽŠòÇQ‹ O½œMåA¯¹ÏÅmg”6¾µ˜æ@Œå™3GÀ¦É\"-Cih¤K(k/j \"GR‡\"‹´6´„ÙeÔ¼¥²øõra“ì™Ã39\\, U;¾žÎ±p›ËçnS\$¹‹•¨+U¼¿‰É©»48å¨ûëŒÄA5òØBp ê*\r«í-²nQªY„09KC›‡ÒÄumLW*\ràym8\"ìÐÍ‘ï-ŽráˆÙòÙÊ\n‹óíi„ÍäJ'áBN¶²+k¤Ø\n(+åv™\rÃ|	çÖK³g\"vÓ ×Iª;6 Aa àEã³%M²‡9!ºtÈ¦—ª/À…ª°^UÕƒ0þ™õA}^èU]A:ã75.]™Í\$û+ª´¯½·±0¦}Ådw>ÞßrQìoáOÀ3—w¼¢pcYÂx\\{–øÊ¶ñ…©¬Ó3­‰˜RêIÕƒÛâRNJÚ\rÿ®¸(Í[Óƒ¡ýõÍ8©æîs“ÔÉyÇ:g3“Ô5ðœaI&µoK>¤Eú£ôéñèâ²¹ž{­žé;y€;†PÄDyñ¢êdš#&·Û`¿C¸œ„aµ+5Y¥E«Â;?ÐyŒÅÊCÈ4í¶ .·Y(Ø7\r‰€¾„@èÀÒIîï\n2pÉ™^åõ	„lºÇËf¶å1 Îº~ñÊžIêñëUv0£Ó5®~SRÁYK1g=Õ£R–™ md+`iÀF¡^S/ä(Ý5ó·É“wúð?ô¾CŠTHJt¸x@Jä¼¥jpfuX:•0ëz¡ÿfø×ù^IŽZÑ?°G¨€úÆJûÏ@ÿèïd;(ŠÆlPÇb†û[\0DàÂ‚%tHp\rþ*ntã…`ç­îPnBá¯J-ŽEãsá?!bà°:»Î&J·è&;m\\aOP˜/@Õk€Õ­^ÿËÈäq+‡b„/hÔ-Fp	ðÔÆ\$VÅPE­D(iÎ†Èƒ‚:jDà×D…	\$‘	g¸?Ô9æ€&Ã²=ð¯\n	\$Ä>Ç¨÷Ð¢™bž0¨ú×BÕdÕîê¾t.F\\ešú­RR«öý\rbQ- Ñ°xõÏ@Ñí\"Q°kñÐ‡\rp‘ÊpÚÍ–0Qä‘21Å~Ù‘/H&U†[±FÁ°ÐÏÃƒæÎpNÆ-äà‘#p\"îXv(œ@ÐG¬aÂO¨ì¼&Y¯AQW\0ÑJ[¾\"¤ä>OÂ4–\"D„ÑˆÔ˜[C¢ý\"WQ¦=ƒs§O@Ébð‚`é\nmlX‘6õMoŒžÍo±•E(1à-g‘ÄQn;‘:>m¢‰oêõ/0Ž2	í ò×h˜jl}®ê?‡{«ýDý @O22kæãe’Ý£2cr”R,©îwîx5†F2Ç\$î4ÍOÌ,?Å‚Ï°*UMò[«0U%Vä¹În>òpZäo@Ø‡š¼\$#.}c8 c`%ä.\0†r€Øe/åœ­Ž®º\0¨ÀZ\$ƒël\nÉ¨a'ï&¶äô·)+\$(Ž-éØ8òåj.ln&\n¼\"R¦h&ql’‘à¢òÉmQ)±®õ²žŠe0cfU‚¦›G<}\"†|’+Í\\\"çVu¢/\n+V91¤µ‰on–0GVkÑ^W,”@êO¬ë	¢È’‹%2û	¬2Î17j^å’h^²e6ª_ð_8Í` k²\"AâB”ÿ!m(.Pš7ê·©Q”ÝP¢²€	©2\$¯äOL\n6OÚæ*ü:üSÎjoÜ1 Þ‚f8ô.o…–|‘lWààR5ÀŠ5',#@ôùÃ”¼.‚ù…×@3äig&10ÐxÐ¢ÿ(s7£ò-ì4V“†?ÀÞk\0î#ãØRÀÖÅðqsËÇä^-Ð§à";
            break;
        case "uk":
                              $f = "ÐI4‚É ¿h-`­ì&ÑKÁBQpÌÌ 9‚š	Ørñ ¾h-š¸-}[´¹Zõ¢‚•H`Rø¢„˜®dbèÒrbºh d±éZí¢Œ†Gà‹Hü¢ƒ Í\rõMs6@Se+ÈƒE6œJçTd€Jsh\$g\$æG†­fÉj> ”žCˆÈf4†ãÌj¾¯SdRêBû\rh¡åSEÕ6\rVG!TI´ÂV±‘ÌÐÔ{Z‚L•¬éòÊ”i%QÏB×ØÜvUXh£ÚÊZk€Àé7*¦M)4â/ñ55”CBµh¥à´¹æ	 †È ÒHT6\\›hîœt¾vc ’lüV¾–ƒ¡Y…j¦ˆ×¶‰øÔ®pNUf@¦;I“fù«\r:bÕib’ï¾¦ƒÜü’jˆ Žiš%l»ôh%.Ê\n§Á°{à™;¨y×\$­CC Ië,•#DôÄ–\r£5·ÐŠX?ŠjªÐ²¥‚ÖP¦pº`Í¶ëJb”¸D¢b†¶d*5\"=è[ÞL‚²ÙÈÍZ\rèÑ>É¿Î©2\\“JŒ¤hqÁ \\¶“V^íÌ0ý.®„.ºÀP‚2\r£HÜ2ŽK‚þ9Å¢^åªŠy¢J:ŒD»—ôªÐ%rc¨–¦d-6‡ñìk2¨ÄxXƒ@4C(Ì„C@è:˜t…ã½|4%\rDÃxä3…ã(ÜŽæ9Žö0È„K8}·Ê1h‘[œ—'B²¢/¢ã|à\$¥Œi\rÍˆ„Ä¦È0ã'6\nóV T‘’¸ßM°#eº­ÑiàjLXÃtWrš4k\0ªÉBb„K—š@„J¨R˜‘D°`J2Tk^äùLçe™F%•_­ñe,)©#°hH(ÑD’—ùÂ@;³ÝþK#D„>˜hwºfÉ.8ÕÝl¨öâï70j0jñ65^Ó»,ÈËÒ|LªE\nÜ¬Æ¯š4R5hjsúL#lÍšD_hÕÝÑÄ`ZÝ¡2œµGÁ2ûhÃ¦Ê•Íˆ~-4\$Ië&„\0¤Jž¶ó!J.8ë¦ù¿!zŠëz¥ÜnÌï¼Ìþ&ñB˜¢&kè:fA#Nlsž9m¢S!Ð“é€Ò8'~šæpâŸOáÓvoùø„.B£¸Bš ×³ÈÍÞé)ü²FÁN^Î+(ÌT‡„çº(Ñâ°÷ÕûÙm±i %^#’qo\0h=ò`ø^*ø6' Ñ1Wš›ïzÁ!<Ú»ÛpD\r!Ì0† ØK0s,¨;á#Q%ž‡€è²ƒ˜i\rá¸9šSrâ«ËéÐ‹PÓ‘â2&L@¸¦8ëßòN~dèÊ¥ä4™i§A~´v² rm'\\›ÃÔæCaV6‡IP9BhIÞ‹y± ¸´TzSs‘)É”X¡WÊÊx. ‰þ”×ËÒ;CÇ4²Ä6B‡3(|¦]—`\\^de7q—F©(pãq1Ž\nˆºÇÒAPûÜ=@XçZt+ÚA½9„+-‘d”ô°é\$JLfi’U§FÂA£z¡ŽRyGiE\$å\${”ò~Tœ‰Øä)’òÆE=É-EìaB® ¢”¦éé%É.ƒŠ.YÇ7E\0»œQ|ªÆˆ‰›Ñ5â©u&r\nˆŒ\n\rB¨päªÝô£GrEÌµX«•‚²VŠÙ\\+¥x¯ƒºÀXSùb¬u’²Ã\$3!Ò,°DµÈ1q.¤€].…ÔÏº:Í…â0H†TÉ\"5Bâ2€G÷\nA)ŒHÁÆœât£‹¢ýŸGLºÎTŽ¤K,¬š­Ÿ¥V/JY]<´\r:\$cîWÝò§g4­»AÕz±VjÕ[«•v¯UúÁŸ«c,…”²at0£«Qk\rLBŠ)Îó5#Ò`|A\$g7p†xO)>JLŸ|q|7˜ÐþRé¾'I@ªR„ýT‘ës‚YM©&Ž‰Ká9ä<KN’ºx›„ ²2&—cX|Ê¨9EÐ¡*’lT‘][¨zÇLbš£ªH²œ†ÁóN2¥9È ¶:ìH£ë[#\n«Ô²…Tµ£s9b^’Ý6hŒÆ£|Îã\n (Û±^îÒ1€€pSafõ³’qT¡©!£ÖÚUJ(â ò¦kê5ž[ï4œå¨@\n1-§#¹cRmTTýë…K\râgh”_]RPÌ´(ö’é!ICoãÉs!â¹R\\Ø¹¤ÙJLµ°Hç„ë\$¥^w\"K:T4}6fIÑ‡™>.¶P«„0¦‚1æ¤^R‘ÈÌ]'	]¨E-T‚m<‹’4C“¤È_¦ìPÅ€'õ­©rA\rêf¥«æ¡ßå.ï°•™:¬ÚR‰WMáí: ç-¥¹–Š<!-b½âXi¶pšŽ(TÂM!7îB±á)%qAN9ø°çû½(6U-ãF#Ÿ#L_O:vÆÍ.¦ñ!RÖ§;–,SÊN€€(ð¦<²•5}PtL~×%P‚;hÑ¡¢Ûp\"¡ãØqb¡^:—l‡/ÂJeáN;t© …ÞÝ&Ö=d“:–%òl]\nÖR7Z•xºX‹{ºw’½ªPŒƒµ.oâ¶Wúp‰Õ›Ê•>˜d5r%Ùc`R×”Â×àö°êë°ÐéçîG2ó4ÜŒ€r'<4P›æ×””Ô—õJ/9F¾eeíÎ*Îb°7Òr÷@IZÚ1)ÍÒÞ—ÜK}ªô¥¸Ùç A¬rú|ýI•š5!\$¢Ý´ÍÆ&Ûº—\nŒ¬»M]%BZÓJz¢½Ù¸ñ-nb=Ù^êNÂ}.°þØôû6^ræ³Ìd4¹QfÏ]çq?½Ô”Eå§¿ÉbÎ·\n¥¼w–óµm¸Éa¾»,ñm/d©Â„ç_ õcAH7³¸ÝVã­u\r~í£ƒ¸ä\$€­•ÑÒ—vD.±Ã´gµü·-*s‡¢çûç\rõy7Ä¥\0ª2ÁÛÊ©7}—ðÃvï;·s¯Ü†”ÇKQ|£Õ_;÷@\r‚aþëDlè\nm\n(ïâ`¨’·æœ8O¸u«t´lâÆ*2&|RòJ§–sé¸O‹èÜª®cÅò²KÂÒIhvg:8\$ÜÅ¬L^&-Œº\\ˆ>ÉdŽ*“ÅÊ4åüÇX¨êåâZ‰è\$Èz	èKkþ5ƒ\$‡À‚\n€¨ †	ÓG|ðÐ:¾Eê‘ª„¶,GÐ>H\$*w­8^FZâô–EþaEèf#qˆsÅõ\r,A­6wîîµ¦¶)\"Nó\"œâƒ²Ðgš“²‘0Îq\nH–èÉ	¢_\"›pûËfjÐòcJžk¢OOÌÀ©Ð’Ó‘geA«qñ#ðõì9ÐÖ‡,Éw‡~ÂÅ4`ðå'†Z¥‘1ÑlÑ8ãPð#ép˜ÓŽ®\$±_koQ>Ã°Í‘VfÑ2—0é«sl:ì±†6‡0Û6ãðþ7Ú—\rÜ%Íà|mî‹áw\rÌ\"b0]QÆ,qXÃºÃl>¨äJ®m†Þ-ÁvÜ'FJÄf(QèªèŸï2*Dø,1È>£VcäH­’ÈLôGâŒøGX^¯\0µä&f¬ä‡2'ü4j¬\\KNF*^¸ªä&D@îÞDûÈŽ.êgNî˜,8ÕÐÞK’^ápö£³&‘(Xµ#B,b#·\n˜ý/‚b²o(DRÒ²fgÒ4D’êcÇ°D¤…*€«Q*ƒn¸ˆ»‚TÃÎäç\"ƒÔã%þ*\r¦Nf´2lFÂw¢<‰Áþî>m¤:¢ ùD,â\$øeì¨Îz#CLø‰&['üçËC+äÊ%3,’ÞkPoØqÞBçøÁ2—*Ç)ïÐ*e2{êtÇ¼°Bd(Ÿ@Qt)r.m,¤`IE:ñé(``òeŽàIstlÄ£3ç|ë£|sOmsƒ7/8ˆã7‚•,»4NâzSžûÓ£+ÍŸ'2é\0¤Ð5r«ÍhÕï1\r.™hUq|cd‹8Ï‹43€’üA3Êµ“Âíi—,’*Ù=Æeèx8S¹4ù“í<„“?SÏ?a=k=°ýIË“¥;±E8âPâp2®.23Œ‘“'t;ð§ÌàÀÔIC4'QyE*CCôYŒ3ó¨|SEdçlL0æk8Gp,)­ì(FÄc+ŽS/T)à<Lä‰Ë8¸”~b”‹HIHŒ~Cp`þº¤qÏJ´‹Ê\0thn7«2ÍŠr¾ðª¿LõKlH+¢„«Ç>n#EQFôE¤ÂüÚ\$^ˆ(ýFø{ç¸}Pöî¥ñ#â5ƒFLòöü¦>S½4ORËF})Ô9R¦S´GkÕFh\n|\nÞBKSÏ¢ºÕ=DÕAEÓ1r•SÓçA1§VðmVUJªÒÃ;ç™ðHU~òõ‡XìPP5kD±*óZhBd·‚>~+ha'{¦­2æ¤êcòí?Óý=’×D²š›³E\\¯!T\0ñ^Ô7VÕÝ=UàëTuXS«T&{&æâx…ÌbÕþyÕŽ±5ÏBr×YUV_	`fçV6|V\\Ô\$_Æ\0góH¾Eäª¤TÞs¡E\n¯]O§VµQd¬-µWU3T6YU¶OFM,U{`òb¥eÏU/	bÐ-dÄ®v¦F=WøK6„ÎçvPï‰i‰êq…*tCR¯T6©.±?§_”yT!J>åºû°è~61_1íQ³\$˜ÑÃ+±\0G—>òƒ[²\0[±Gt\"¥)ooS{	•½oÑŸpò-'pv³o8pÓ·m«.Ï†pgK]Nä[r†1¦1Ñ½o«p\$ý<vÅkSér”>¹q×SF1!B´K‚v÷^–·u‘UBã~@†‹ Øp¹ËH¿l;lQJ«˜·ua6á7B-bÚßò 4†jôºì4Z Q¾Ä€ª\n€Œ qIs`Tu9,(_æ˜Â4PÐï×9Â<7áPsë~‘MCK}×õ5Qqê&Ij|.împ\nv«˜¶\r;ÒJ:AdO#t%(rD ED\"Ç–ùÐ!—âŠ9,Ëå@v‰â×e`-.™ó,Á2yñÑLÀÄ°Oxi3.òò@Õ“nRÆ\"ãäP²éô–Èj£<%òµòÓHµæ1”Ìe*8Ÿ8ÓY,DýX‰Ô±SZ¾W©|5{‹²Ñ‹ó¤8Ui]‹I(ò·ŠøÒ¹c”>p÷\0øh´¸›ŒãÄ?oÁTb˜yaP_xñ,L¸RÏPÇ¬®Å%-¡rù\r–×tž~hAÙàoÛL\$þ £\\ÿâÒ&*-/1&Î&n\nÀÂ`ê ÚéXæ¾¯·%.ÐiPæñ²+s‡–LixP{ƒæ€ÌD4í=\$j­\$¹qTë.³ó¦¥ÖÒ:.Øîs Mù‹‹RH#XÃV8<1é§uÂêàó+N,&/ÎNÝI• óS®í¹#:-#\nÁ¬^ReLÆCH";
            break;
        case "vi":
                              $f = "Bp®”&á†³‚š *ó(J.™„0Q,ÐÃZŒâ¤)vƒŽ@Tf™\nípj£pº*ÃV˜ÍÃC`á]¦ÌrY<•#\$b\$L2–€@%9¥ÅIÄô×ŒÆÎ“„œ§4Ë…€¡€Äd3\rFÃqÀät9N1 QŠE3Ú¡±hÄj[—J;±ºŠo—ç\nÓ(©Ubµ´da¬®ÆIÂ¾Ri¦Då\0\0A)÷XÞ8@q:žg!ÏC½_#yÃÌ¸™6:‚¶ëÑÚ‹Ì.—òŠšíK;×.ð›­Àƒ}FŽÊÍ¼S06ÂÁ½†¡Œ÷\\ÝÅv¯ëàÄN5°ªn5›çx!”är7œ¥ÄŠlÒÔ¶	®øò„§;• ˆÒlœ©# \\À	Z:\nzT·\"ŒP¢iÁ>õ²¬»2„ˆA¯¨QtVŽ\0PŽÌ<áƒÅ0’P6§Ì(ŽÁ‰ Î4Œ#p Œƒk¶û=cxÊ9³c|(9Ž£€àüÂƒÆ1Éc›¶¨c Â:#Â9Œ¡\0î4££xë*„„Æ9ŽïÈÈâ†4C(Ì„C@è:˜t…ã½2,Žý?#8^2Á|Ü9Î^)ðÚüÌ®ØÌü²øÒ7Áà^0‡Ép°2ºoc,6F;r\$V( Æ€”¬ÒÐa—Hkå(jxë˜ed…_°‹ÊÞ3°ÌC+Œ#Ý-¢(È¼# ÊaH!Ç#£t7 %Óo¢åÒh˜&L4h©'ŒdHÇ+`‰=#¨Ù\nÃØ:Œ UVÅnúv™'Jv7]ì2pJ®ÈñGŠ–+¦5¸%û½°¥n]•7™†Q7,tW¥Ã«ÇéZ€”ò^œi\$TÝÍ2H;F–R÷!	\n(Ü™¨7­˜(Ž¦S»Å·dÎ„Ù[ù46)º8@)Š\"`<U€PØÜY£¤—dªH!Šb&ÄÃíWž’i•XÂ©ˆÞ‰ïU\r¿\\WC•xî¦5EÛXŽMJ<1TY\nÅPÆ:×úPïíŠØ1ÃpéwÕÑLÜˆ‚Ç²ˆƒHç0“*?!!ÚvÒgsÛŒ£Å´7KU æ—cG8]’÷=~H¼/Aå¥Ù:’\nf9àÃ@\0”a\0Û0×\"»j»2Ð3PAhÌ£xÌ3VpÊ¥ñCq4@xÅ©\$:RHSß1|4í54vtÖÙ€nN„\\Q 4xr‰Jåoä£­pàºP n2¡„—\"Q†øSIßBáRwðCZLSáÈT´]’\"F~ÁÉ:7ŒC\"HNÀ<'¤øŸ”‚PŠ;¨…ÁrQêD2*ED©¸>Š¡¹Q¥Lª	pP\r¥A@tÎÑM'eÄCª œ'mbEw™·,JáX%Á5	!D,.Ã\"|(¨_¡FnKSªwO)í>§õ Ô*‡Q0èûEä£”‚xJAâ©0Áñ‡=DP“(Ìbø>}ê™f>\$_@‹hï\"¦ÔTHÚ\"ieQ’Õš™R°t—©˜4†ÀØ^S(p>ÐÌ6†U®C2Ú†‰A+¥Ì¾‰HoGä3‘Òh™]œÍ ©æ †é„¿ž9‹4…Ü„AùjŽ8 --T¶A™óvBÝ\n\0	£3DxK¹pøI“)!R?`Ç0‹°toáÀ9“´íC<ÎM©Q&;\$š•f1ó™Å.9ˆk`ø>Êu&0æ›’À ;s~™ààšÓjoN!Ék‡xÇ)’0gOÓ\"š5ò™#ÜmcàA2ÐPÛ€RÐ4Ç+‘´+å34ŽÐ«¯áŒ¡HòåÝº·LÄŽGS¢bAp ™ð‡d.Åz¬Ö7Ôä+¸¢%¨ \"DÈ¸©8‡à»OuW*e_ 5ˆ’à’DƒËî‘Ë°ÜµÈíO&¡%¡@Ì~œ9Qs}[ÀÞ™(\nLMÔd—DB¬É!/d•À^xS\n,ïÁ’s\"-We¥í‹®ÂfGk¹:'„¡ünNÃ¤u­Jæ\",V¼\n#]·K˜£­Ò\\ÿU±x‚ä€«ËƒŠOméAåØ#J\0sêÂ+%=¿ºD8r]E·V5¬ÊZMqHÓæ\\Åµe¾(NbÉ%jrí>á\0Aú%ŽMª¹àÐN™Éz•ž¸ažYaìF¤#tŽ¡ÂE¯\$ÔÔÂ	|\\‚]Ô@ðòËY—EsÜ2âBeTyd‰²…Ø‹Âïéäì[“[‹s\\­ÿ\$=‡´DÞî1åYÃ,g¼˜Î.-&„©|£&tW”^Zå?¨Áxrw:”…¼‹ùëÈ„qgÒ(\n)ÓžÔÏâWÆ(ð);tK0%ÜâitHk­tŒZÀŸÓßKçÙ +\0õFŽÐeæ-a›2.±´kCY\$œ—ÄN9éX]ëiá®OË*¨H\\ítrñy‰Àð43à¥Ï‹~\\«7Næ‡´ˆºÎ&Š7áÉ`Û%“Þ	{tÔ-ˆN7\n Í€()&ª ’õÒò©d™![dcn[oÇ–À á†„`A\nP „0‘õ\"K}éæÎ¥¤•)Y!\rqæ@KiZÕÆúqk\0^rL2IfWCü.Å‰;¼;Ó)‘¤è[É™5&îœ»4“„A8ï##YT€‹3^¬•|Ÿ”ÄEjIw Ì“5èÙB¼\"íH™b¢þ*V»i#!CðÈ£}½Å6<c­hÈ]n\$P²L7Óò†R»a¶ÚïûI¬\\e|b…â´S;Æ9Ã}ï¾‘ä\r­ì`œ\n²ìSð‰xâ7NëÞx¼šç	›¢S‘[¨0ÊÈ(e]Ž¹2÷±#n0—bÐŠ³…Xtõ‘¶·†Ú¬M–Oj™KÕ^|Üëum»ßk,žPk¸£»n’g%–¯ò8D¤æ–ƒ*‹£\"úÙG[Ï¸Ö½2Žœ‡à”€~£#VÑŒØb[?H¢ —T.Ö+†àÿêˆ˜)v¢ûŠûaò­|×¾¯æo”tÃ6Íœ×8Â\\:®FØjÆz\r%¼þä„ÉÎà÷l¦;ïf|/†€ˆÊÉB¼l¸Ë0Nø(ænì°nB\\í<\\îLažMÜHäé‡ÐmÈ:ÄÎH%Â,CË°:Ý>õcŒƒOŽ/’9_GòÁ\r›	Îá\0êùfü–&<Á\"'kðcë‚b&m¬—à*« êNÒ°«¬cÂ=ãŽrZÃÊ-,¿Rßd&Œ@!*–ÎÖ\$¢ª¼b³	p¬ÙÏpæ°ùã®p&øÃðZm¥ÎÙ#§…Ä\"ÍZŽË½	ð£HHÕ…ˆXÏu	{Í]0³\n‡@)l¶s>hë¼õÂõGLÞEkq-¦ð^0Úk°W£“ÑŒØê]æãmôt{­èÖ!^BŽlãrÜc„GeÒ!¨øâ¬,\rmº:%zN€ÈrEv‘u	0pMd„ü|?à~ÑŽßqìÝè_ð|êcn‘ü€\$­rsæÿ ¢oî(ãg¼ÿÏ´žl¤úÂö9ÃW±y\r,|\\°NóÂ‡#M±	NL*ñ¥\$T C5ñÚòN<%h%¥šG§þHÎ¶äÑxANfA¬Là;%Ry&‹æ…ÑÛ\$†ÿ(g¬ßÒ€{èÛ\n£Àh¨ÎÐÎÊðÆep%Pq£X0Í0r¸HN:˜CªÌ‹¼iø|#ØñÒŒ;ú±\$Z)rØ!È<EJØøƒb\\	ÄT¢bÐ˜ëðcˆÐÐ\$~ÿò\$èr=,pˆ/OÞ4§”Bâ\n ¨ÀZNö\nÑ&ÀC3\n‰Ö½l.U„@Þì‡¤ƒ*ÁR<{ì6exIòTm‹Ù/qèGÏ² Ï¸6…U5Ok5e_5¤JH#f\\¤Z©çFÈ2j&¦Ä±É¨ÜÉíÛÂU*iæîwò;b7ñFvrÞiÀàÉlÒqRû‘W<ÑE\"|\$ƒpø¯r¿…ì\\bÑŠ8F_5‹r-ò”\$ùä4Clï¨7“„=\r+*« æk¥ó[BiMB¦h`ðêÖð!.s“@©æÈ-t–tYìÊã(Arb‹Ðþ\"¬ØÀ–«ªœC\nôMxã\nÑÀ'ÄÖg”q¤P\$ªøú,9U#F”¬wHÂ('œ3Ö±@\ràì>Àî¢¥´Üéö¬Ï8{Í\0003®O'Ä6 ðÉÀÓ”xÞj½I‘\0 ";
            break;
        case "zh":
                              $f = "æA*ês•\\šr¤îõâ|%ÌÂ:\$\nr.®„ö2Šr/d²È»[8Ð S™8€r©!T¡\\¸s¦’I4¢b§r¬ñ•Ð€Js!J¥“É:Ú2r«STâ¢”\n†Ìh5\rÇSRº9QÉ÷*-Y(eÈ—B†­+²¯Î…òFZI9PªYj^F•X9‘ªê¼Pæ¸ÜÜÉÔ¥2s&Ö’Eƒ¡~™Œª®·yc‘~¨¦#}K•r¶s®Ôûkžõ|¿iµ-rÙÍ€Á)c(¸ÊC«Ý¦#*ÛJ!A–R\nõk¡P€Œ/Wît¢¢ZœU9ÓêWJQ3ÓWÕÜë5ÞÆ.¨\"”.TÏ{¹D-á(ÛJ½s”\nZÄ1H)tI¬¤Évr—¤«s„	ÏAp‚2\r£HÜ2ŽGIvL&Å\"žs…| š•ÅùÒK•Ì‚äN'+ý\0BIÑÍ1g,†àÂ\rÊ3¡Ð:ƒ€æáxï'…Ã1\rCpÞ9áxÊ7ã€Â9Žc¼®2áŽ:e1ÌA§ANš³çI…ã|GI\0DœÄYS±,ZZLÇ9H]6\$™ÌO\\ZJ3qr“eõR+²ZK)v]P+¤V”Ç)\"E!ã @¨’çA–¤A.²–0Y<·œÅ™Q9UAU¤QPr”DôäGÏ0üBräó=Ï¥JÒC—´òMÒd–’áÎZHÁv]œÄ\"†^‘§9zW%¤s]Y²¡x:DaJ”Ù—‡5	CL±!X–ËM„r¤âÒB•\rÌD•mý)Š\"eLnŽIœ¥ã°Ý54½!PÇ0>D\\œÅCæ^Y‰7OTV;dd5SGAM2l«.þ—Ž€rëF]˜4p›iP,uOSäü²çoºŒ9„1K!%~¬£ë:Þ¯¬‘%IÊX’ª½Xs•…22YiUc\nR¥ÄùÌK–Ñ]óXÕ´ÑÈ]Œö^D`º!A„´¡}\\#`è9%¨	ÎS=¥Ñ¿ÏT)¢Á0\\˜–'Aiº‹“Ïé‰5:eºUV\$1ÒI-„9#e~Ò¼kXOÂp^ŠÆ„ùÐXXC¶îÂðÌ69u…yntÐL’*&µì—ed} HR\$\$IRd(J^t«+Ë2Ø^2\rãpÂ:\r?ŒÊ1LÁX_!„AÐ\"Å‰<\"„ZŽ‘:(ˆ`‰‰Õ;‘x&Ž™¨âÉÔ7W¢-ÝÁœx(T«‘”ŒÐå‚pTN	ò”÷Ò\nCH©\$¤´š“ÃºQJo=+%„´—(x‰l9¿T¸™ƒšhzL=³6ˆ›\$eÌJ“fÌ+„æàr‘\n9D`–mBüBÀ4\$ñÝ\$0@W‰ÔH‰‰¢s	1ÂáAReUÞ¬>ò¸çbà„ˆÂr! ­@°mÏ»f)Ë¨Œ1¦EDFÎƒ‘q’D¨ž?‚\0 ƒdˆ®\$GÆPÿJ<	ƒ¤hÁ\"pg„ðæÂ•X‹Î\"YA”â¬WŽQ(Ìi†Fâ\"@ S@Kã0qýôrË™Å4%™P\nxëü¶äqj‰‰j+Åâ¾ˆ¬W‘D&&!kR‚‚\\˜qS\nAqI+äQ+u°eNKa\"ž‰©v¢5Ý’ÁÐ-“h¿_d½ÕJRlN	Ò¬Â¸Z¨ŽRjÄËP5vÔÎXœ1ÆöH£N#žjTSÚ|:ÑÌ,D0BÍÈ(×\0à,*á@'…0¨ÖQÁ‹\0R\nz ôš (\"Ešµ¢ö \"ºÅ¢ŒtˆUÒºØ¼î—ëN’sÈ  …ÁP(òB(	øåVìP&Â|kèùðX'Ìú£&‚`ÛP¤Ç•va@|Åx¹A<'\0ª A\n½×ÐˆB`E°e¤V‰z-OÙiâ	@YÒ%Eú:Ë<DÀ:ôpÎ,‰7æÁ‘p\"ˆ¨»´Â.Ô–QN.Î…œÌÕ§¶¨&¬Nx™”æÚ—†¢´m£&hê~à ‡9Å@‹o&[	…ŽYDQ¾	°Jñ¿`š”\"ðFNÓ´}ä¸P‘Í¡«¹Ô*}ÚÐ·»%æ‹s8Kkº2¯W2ž”M…çÊÎ&¢rÎm¹:2½³E•\$âŽ§RjTé)¥¾(˜ê4Ê<\\àü\"KEÐ,¢mŠÉÉh·Ab*°W*é‚U('Ðï\\1t›±N+>¥¤M‹¢&‡H“Ò¨ÂLˆZ+³Ae–0H\\‹”½ùÄ%\r5AbëÐ~m0ŒèžÁ@‚Â@æ<gLQÜ¶+ðƒE<¢eT‚\0^3,‰%¹|QHyA„`æwHðª¬Þ#Äº#–7H´^ŒD‹ƒ Q1\"ñ%™Õ¬‰Òå›/ìuwù»D˜Ýš˜´F!}Ú¼H´é(ÓâƒB\n·&„Žé¢•_\nªÔ|±`\n\ná”1júØcÉ)M¼¦xHZ-s’ñþcnâØrˆ4+W	'«ùB¨|ÆzHŽRb=¸aqmÑy/eôÁ+±‹m¹Î:z=Âñ¤LÑœÜ˜rÛ+FpwX®(û¶ÜG»pš˜ÞûŸp²õ?¾çôúóÆÑ²Q\0®‹1go[tÕÁùÍRb1D+ZÄ[ÝŒXhÂ#‰ãnZVii‚{åHaay?K*àÂ#Ÿ‹+sšBÅàˆ²öd]\nhZxˆYpëvÒíê°‚ná‹Ÿ»‹½FþTñï…:9xxâûäLŒŽ„~¥êgß:gm©sÖ|½#æ%77B\\\\öjéÒ:Wní7·ÁÊ\$£ö®Î¥YX¹ŒîFê>	ü©Ï,VÂ-BÞ°ó|#ýú.ŠÉG…ÁÆ‡•rszFD§+;±þÚwÿ,kJ­qìë³r÷¶’ÊYZÈí…¦¥bFùÏ;fR½“{`§ÜG¾÷{Ÿ¤ü¥¯ï>É%7§aO–J>Ÿùä¤¼vÏ¦szW×c¤À·Qv¢„éïì´WgÀÝ±'æœs‰\\Éòwº*9äõš¦?ŸW^G\nßèÈáƒ®žÿ¨ZÏr LŒû`h…ªÓŒ\\u3ÏBa<ñN.çŽ|Æ	ìÅîR4ÅP8ßŽzø­þìc#K\0p=Ð6Æp@Æm†oB0L”p­ÂÀLžð:Â£º½/ùb®	¾\r\0ÊŽ¬þ¥è•K®2‚ÒA>¶-4+Ž¹-J6+®ÙÒ‚ p†t!\\'^ûÐ²\\0¦ómâ–Ìò:¬öÏ§xag\rƒzŸgåÈá 4.pIíƒ×íˆôÁvº\n ¨ÀZlÄh*íÍën›‚”b6#«~OÃ¦Õ†ýJô¥aÐ!(4Âä!^ÛCp;'– Cn/¬rÇiV÷!^•…šmLHzZ£4uFj`ÍI¬\0¦\\\"\\&l%¡æQ*2ç¬©˜àyXµ1¬ù0¸ÓBì÷‹unF‚¦ÀÑ¾êIôïtùª4i[¬.\nnf®f³NRÂOîjÉ\\™„Vn\r6çdnÎ ¬ Æ ê\r®n\$1ÊÎ\$Ql4ÁGÃÆQÂb?‘¦™ƒ¤±²µéZ0MˆŠ‹\$2FµR:`ƒ¤Ãþr(êqðñÄ u\"a._.ÙÅn";
            break;
        case "zh-tw":
                              $f = "ä^¨ê%Ó•\\šr¥ÑÎõâ|%ÌÂ:\$\ns¡.ešUÈ¸E9PK72©(æP¢h)Ê…@º:i	%“Êcè§Je åR)Ü«{º	Nd TâPˆ£\\ªÔÃ•8¨CˆÈf4†ãÌaS@/%Èäû•N‹¦¬’Ndâ%Ð³C¹’É—B…Q+–¹Öê‡Bñ_MK,ª\$õÆçu»ÞowÔfš‚T9®WK´ÍÊW¹•ˆ§2mizX:P	—*‘½_/Ùg*eSLK¶Ûˆú™Î¹^9×HÌ\rºÛÕ7ºŒZz>‹ êÔ0)È¿Nï\nÙr!U=R\n¤ôÉÖ^¯ÜéJÅÑTçO©](ÅI–Ø^Ü«¥[f]œå©bë…Òè©*ÁÊ\\gA2‡¥y­OËXþ#Év—”ªi`\\…É\nsÃPà ŒƒhÒ7£‘ÒP	‘Z¨œÄ£BG–‰‘Tr’¤{4Ç‘0Œ&Q8)´,ý•ha!\0Ð9£0z\r è8aÐ^Žòè\\0Å1\\Z\rãÎŒ£p^8#˜æ;Ì£ ^)AñÐT¤„\ntÄ[T¾exŒ!ð\\\$	psd<-D%yÎRP	 s-î±~WF¥ÊJQO„²ú¬:ôá(\\ÂÕÅ1‘|FM•ÏZS¤‰‡Œ\0Ä<Žƒ(P9…*iXB m O¤òà™gANQ¼D<vE’´MÆQ„dÖ­TMF¥Ä9zr—„}MÇ) D)¤8¡®!v]œÄ!bœåíbsÄ“÷s'ª‘UE¬sÝ‚ž§è8*£Àè\$©ný”Éu¨€‰q\nÂ/\rG~g1s\nbˆ˜V¥íäðœÄI&t’Ëƒjä·5-;#ÃÕOT¯Ôµ1›t©V×ä,ž‚ZÒôÎxþéš„ž'Éséº¹]%Ú)Ï£è\nÆžñi0¹WDQTaŒÄÖT)#˜@s´xOíûŽçºïTah—§1PPÀ\$#hV’èùd¦’¥Â¦K©¤¹Jºç12Af„›ºKÕG#†ÕV*\\\\—È*\rƒ äË•I6Q0D×<C2Ñ\$7­Ã%ÛæB(‰ÌJ’í7ÆÑ\$r€MIGFŽ¤×')C\$‚ª_‡IFÎå3-º'äVñë~ÙOa:€=OdQEƒ—“°)\nW(Ð1Hµ¤Œ™'J”¨•’ÂZK‰y0>ÄÆ™S:iá7†àÂL\rN`øsÕ.+ñ E»á,!Ç8¶H¼@Á Ô*‡\na•7AÜË¼#\"9Ê>ôüõÍC¶C†X¡´\$…,1x®PÀ?´ž”RšUJée-¥Ðî—ÓíL‰™4&¦\"¯Cps…ÉÍ:¼¡ß‡(±° 7Ñ,§ˆèèÂLƒ2T>ˆD+YÆZÂØËø…EðlQ\n¶îÛÞØ­Š0F±Â†!Ê±™tO¾†Þ9ÄÛŽ›a\$T`švÎìr½AÊ'Å¹”v¤j0WàÜ)Ž3‹È]ºdjÅ¡5€€(€ ÜÄ›”Î	ÂQ	ŠT&‡‚à©d,MP£_‚•çÎ\"Tñ£“â‚Q¼1,¤°‘´D½³0a\\p…²É!!B>+eX¸´EŽrÎ9…\0¼IIüÏŸQ/G0˜åGßÑèé2QÞÁÊ&æ¡,#JÍrlS\nA@ÞÓI€‹ÏXFÃ‘2/\rQ1/Ã”K\nãð-£Ô3%äÄ™ÎG9…pµwâáëY*''YA[”i£œÑÊ\"…q6‚˜Aa<'1˜9flºÉÑ<úÓrD”€@Ž9…ˆ‚†Ã¤K‰Æh\"G4‚„ƒ¤NŠ#,xS\n€#ŠDvPLem6Vè¨„q1”þ ”¢(‘…@­ Ä ´ÍáQ=W‘òiâ„`¨	Ù\"e\0¡,¦R	Á½©Ã‘ qÊ‚gä;¡E\0KA|ôhµ)¢€P”5ŒÂp \n¡@\"¨@U°\"„À‹mÖÄ¥HHÑÎLÉpd®5u\\kÅX¸ºc+yW*³šsÎ‰Ó:¤ìŠ‹³¬.'h§»×tðP¹­,šyøl©\" ›s¼x²ÞmMŒrµæÁzÐÂ£œH!1P\"×ûÎs…øñ\nãHãHÀ‹˜B—\ný3ÄAt„0MWãT#Þ,´–Òâ]Jy{,ÊS¹wo×\n7I…H3ŠÕÚÑ`±›	.§Eñ\n‰®+œ…í[Óœîñ2xfx©ŽJ„«	bš*•\0¦TXŽqh(—#§gÂç'ey”­8æB@Œ+&TÒ¦7Z½ŠKKiÇM©<Bœ\\U;>‚¯±¯Í™¹¡ä@ˆ¦J–<BñÇ;‰à/\"æ¸ø\0].g<tØ¶l†K0_VŒtKoæïÑÔlÉ…¥¶\n!„Ì|S½f¡Z|Rê¦zÄùó>¢¨ð‚UrÁ¸­”—J)©5 	á-%jíf#ø—¢öd	ñ~öêbA,¸]ŠIë'å\r6‘P.‘µµyŒ°×kS¨‰nÐ2Š Ÿ<ám­ðAN'D‚ÉdrrT7a#½°„IŽˆú9DœŒ_ë:'AX„0ŒP8¸oÝB#n*Â×ºÕNXAoŠ+E.OT	I)MT}‰‘¤&'vSEÄzÇä`Á˜YöÇÇHƒlB§‚*ñ]{w´~½ü®öšSNbUt¤ÖŽœÅZ(9µBè‚Ëz<ì|)\rêÑŠŽöå>¤È©1ÑÍ|Eõv•aî-Ç@yEFå²Œl\nÜÇ§¸ƒóººDo&+!evñËÜ{·q¹½ˆ—’]ržUÊ.×'åÝ¢¸B6\r]1	‰wa¹\r>öôëáÒèáÌÙw6ôô¾·}ôbHÚn…M³»ð*Í ‘Ð=³è<yÏšõ\\™Oc±NÆï÷»§ÚKMj¯£Ê~û4ZŸGçðf÷ù§àÐ¯–‰øˆØBHâeáPk>å1ì—‹s9\$\$•BÞdˆ´•\"z_ÀVGíŠ\"]NŒìðY\\Þ‘ñ)”dzF½´D‰6”ø«Tý/®Æ&ÂhFœÀÎ|Ì<ñGDê¯JTå>T%Føîvl‘ƒfóÌãl•«G°3ìò°.ÐåäÏ…!s\røìãÐTùÐYFºÑðlfŒ\0S&„¢Á^\\É Á{‰:Øv*vòÌ~õÍlÄ*a!	Á\r\nP¨‡X¥ÄÐ,ÂS¤^'â©\nnë¸\\eË¦#qŠYFüŽëÎžYÌÚ£ìß\nvÎpðA0¬ëìÎ‚ÿŒÅ0úÎ\rÍ\0Î®(s#¬MÑPè<	=&°ôTñ*0Šóæq.2ÀM Ð È#þ_âšÌ\"4fºKÊ×ÉØ–€ä\ràÆ…€æX*Ø¤¨®0<AHQÁF¢0Æ¡bÛiØ#k3C\\è%`Ø)šØmŠØíF gT\rƒ—ƒ¢9í>'ã\\[‡@2Ž¬ÔbLûHôýÑ6\n ¨ÀZŠBŽjéÄÛiD¡B2#b:¾ENádÆ,¦Q\nºFåƒŒ0ñ68®\\Ï&˜÷ñÚ%¬TCŽ|xå#)ÄÇˆH)ªqã£\$&bÁbêhJŽ÷fDbÎê.–z+»&0l®¨†-è†Š÷nš'\nGïŽ„v…E(‘&î¦¤o©Ì–AB®iáÌ]Åà%Ì®ì­6/ºB0ð¬¯+æ2BÉÜâA,\"íÐ–+úƒ@¬ Æ ê\r¯ .\0 ')NÞ¨Ì¸SíHÌ):.Q%Æ¹&Rh¼Q®¡l¦Ç1»Q‰ÄøÁÐo_­%Â®Á‘¡,sL§A";
            break;
    }$Ug = array();
    foreach (explode("\n", lzw_decompress($f)) as $X) {
        $Ug[] = (strpos($X, "\t") ? explode("\t", $X) : $X);
    }return$Ug;
}if (!$Ug) {
    $Ug = get_translations($a);
    $_SESSION["translations"] = $Ug;
}if (extension_loaded('pdo')) {
    class Min_PDO
    {
        var$_result,$server_info,$affected_rows,$errno,$error,$pdo;
        function __construct()
        {
            global$c;
            $Ze = array_search("SQL", $c->operators);
            if ($Ze !== false) {
                unset($c->operators[$Ze]);
            }
        }function dsn($Ob, $V, $G, $xe = array())
        {
            $xe[PDO::ATTR_ERRMODE] = PDO::ERRMODE_SILENT;
            $xe[PDO::ATTR_STATEMENT_CLASS] = array('Min_PDOStatement');try {
                $this->pdo = new
                PDO($Ob, $V, $G, $xe);
            } catch (Exception$hc) {
                auth_error(h($hc->getMessage()));
            }$this->server_info = @$this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
        }function quote($lg)
        {
            return$this->pdo->quote($lg);
        }function query($I, $bh = false)
        {
            $J = $this->pdo->query($I);
            $this->error = "";
            if (!$J) {
                list(,$this->errno,$this->error) = $this->pdo->errorInfo();
                if (!$this->error) {
                    $this->error = lang(21);
                }return
                false;
            }$this->store_result($J);
            return$J;
        }function multi_query($I)
        {
            return$this->_result = $this->query($I);
        }function store_result($J = null)
        {
            if (!$J) {
                $J = $this->_result;if (!$J) {
                    return
                    false;
                }
            }if ($J->columnCount()) {
                $J->num_rows = $J->rowCount();
                return$J;
            }$this->affected_rows = $J->rowCount();return
            true;
        }function next_result()
        {
            if (!$this->_result) {
                return
                    false;
            }$this->_result->_offset = 0;
            return@$this->_result->nextRowset();
        }function result($I, $n = 0)
        {
            $J = $this->query($I);if (!$J) {
                return
                false;
            }$L = $J->fetch();
            return$L[$n];
        }
    }class Min_PDOStatement extends PDOStatement
    {
        var$_offset = 0,$num_rows;
        function fetch_assoc()
        {
            return$this->fetch(PDO::FETCH_ASSOC);
        }function fetch_row()
        {
            return$this->fetch(PDO::FETCH_NUM);
        }function fetch_field()
        {
            $L = (object)$this->getColumnMeta($this->_offset++);
            $L->orgtable = $L->table;
            $L->orgname = $L->name;
            $L->charsetnr = (in_array("blob", (array)$L->flags) ? 63 : 0);
            return$L;
        }
    }
}$Kb = array();
function add_driver($u, $E)
{
    global$Kb;
    $Kb[$u] = $E;
}class Min_SQL
{
    var$_conn;
    function __construct($g)
    {
        $this->_conn = $g;
    }function select($Q, $N, $Z, $s, $ze = array(), $_ = 1, $F = 0, $gf = false)
    {
        global$c,$y;
        $kd = (count($s) < count($N));
        $I = $c->selectQueryBuild($N, $Z, $s, $ze, $_, $F);
        if (!$I) {
            $I = "SELECT" . limit(($_GET["page"] != "last" && $_ != "" && $s && $kd && $y == "sql" ? "SQL_CALC_FOUND_ROWS " : "") . implode(", ", $N) . "\nFROM " . table($Q), ($Z ? "\nWHERE " . implode(" AND ", $Z) : "") . ($s && $kd ? "\nGROUP BY " . implode(", ", $s) : "") . ($ze ? "\nORDER BY " . implode(", ", $ze) : ""), ($_ != "" ? +$_ : null), ($F ? $_ * $F : 0), "\n");
        }$hg = microtime(true);
        $K = $this->_conn->query($I);
        if ($gf) {
            echo$c->selectQuery($I, $hg, !$K);
        }return$K;
    }function delete($Q, $of, $_ = 0)
    {
        $I = "FROM " . table($Q);return
        queries("DELETE" . ($_ ? limit1($Q, $I, $of) : " $I$of"));
    }function update($Q, $P, $of, $_ = 0, $Rf = "\n")
    {
        $rh = array();foreach (
            $P as $z => $X
        ) {
                $rh[] = "$z = $X";
        }
        $I = table($Q) . " SET$Rf" . implode(",$Rf", $rh);return
                queries("UPDATE" . ($_ ? limit1($Q, $I, $of, $Rf) : " $I$of"));
    }function insert($Q, $P)
    {
        return
                queries("INSERT INTO " . table($Q) . ($P ? " (" . implode(", ", array_keys($P)) . ")\nVALUES (" . implode(", ", $P) . ")" : " DEFAULT VALUES"));
    }function insertUpdate($Q, $M, $ff)
    {
        return
        false;
    }function begin()
    {
        return
                queries("BEGIN");
    }function commit()
    {
        return
                queries("COMMIT");
    }function rollback()
    {
        return
        queries("ROLLBACK");
    }function slowQuery($I, $Hg)
    {
    }function convertSearch($v, $X, $n)
    {
        return$v;
    }function value($X, $n)
    {
        return(method_exists($this->_conn, 'value') ? $this->_conn->value($X, $n) : (is_resource($X) ? stream_get_contents($X) : $X));
    }function quoteBinary($If)
    {
        return
            q($If);
    }function warnings()
    {
        return'';
    }function tableHelp($E)
    {
    }
}class Adminer
{
    var$operators;
    function name()
    {
        return"<a href='https://www.adminer.org/'" . target_blank() . " id='h1'>Adminer</a>";
    }function credentials()
    {
        return
        array(SERVER,$_GET["username"],get_password());
    }function connectSsl()
    {
    }function permanentLogin($i = false)
    {
        return
            password_file($i);
    }function bruteForceKey()
    {
        return$_SERVER["REMOTE_ADDR"];
    }function serverName($O)
    {
        return
            h($O);
    }function database()
    {
        return
        DB;
    }function databases($yc = true)
    {
        return
            get_databases($yc);
    }function schemas()
    {
        return
            schemas();
    }function queryTimeout()
    {
        return
        2;
    }function headers()
    {
    }function csp()
    {
        return
            csp();
    }function head()
    {
        return
            true;
    }function css()
    {
        $K = array();
        $vc = "adminer.css";
        if (file_exists($vc)) {
            $K[] = "$vc?v=" . crc32(file_get_contents($vc));
        }return$K;
    }function loginForm()
    {
        global$Kb;
        echo"<table cellspacing='0' class='layout'>\n",$this->loginFormField('driver', '<tr><th>' . lang(22) . '<td>', html_select("auth[driver]", $Kb, DRIVER, "loginDriver(this);") . "\n"),$this->loginFormField('server', '<tr><th>' . lang(23) . '<td>', '<input name="auth[server]" value="' . h(SERVER) . '" title="hostname[:port]" placeholder="localhost" autocapitalize="off">' . "\n"),$this->loginFormField('username', '<tr><th>' . lang(24) . '<td>', '<input name="auth[username]" id="username" value="' . h($_GET["username"]) . '" autocomplete="username" autocapitalize="off">' . script("focus(qs('#username')); qs('#username').form['auth[driver]'].onchange();")),$this->loginFormField('password', '<tr><th>' . lang(25) . '<td>', '<input type="password" name="auth[password]" autocomplete="current-password">' . "\n"),$this->loginFormField('db', '<tr><th>' . lang(26) . '<td>', '<input name="auth[db]" value="' . h($_GET["db"]) . '" autocapitalize="off">' . "\n"),"</table>\n","<p><input type='submit' value='" . lang(27) . "'>\n",checkbox("auth[permanent]", 1, $_COOKIE["adminer_permanent"], lang(28)) . "\n";
    }function loginFormField($E, $Sc, $Y)
    {
        return$Sc . $Y;
    }function login($Fd, $G)
    {
        if ($G == "") {
            return
            lang(29, target_blank());
        }return
            true;
    }function tableName($tg)
    {
        return
        h($tg["Name"]);
    }function fieldName($n, $ze = 0)
    {
        return'<span title="' . h($n["full_type"]) . '">' . h($n["field"]) . '</span>';
    }function selectLinks($tg, $P = "")
    {
        global$y,$l;
        echo'<p class="links">';
        $Ed = array("select" => lang(30));
        if (support("table") || support("indexes")) {
            $Ed["table"] = lang(31);
        }if (support("table")) {
            if (is_view($tg)) {
                $Ed["view"] = lang(32);
            } else {
                $Ed["create"] = lang(33);
            }
        }if ($P !== null) {
            $Ed["edit"] = lang(34);
        }$E = $tg["Name"];foreach (
            $Ed as $z => $X
        ) {
            echo" <a href='" . h(ME) . "$z=" . urlencode($E) . ($z == "edit" ? $P : "") . "'" . bold(isset($_GET[$z])) . ">$X</a>";
        }echo
            doc_link(array($y => $l->tableHelp($E)), "?"),"\n";
    }function foreignKeys($Q)
    {
        return
            foreign_keys($Q);
    }function backwardKeys($Q, $sg)
    {
        return
        array();
    }function backwardKeysPrint($Aa, $L)
    {
    }function selectQuery($I, $hg, $qc = false)
    {
        global$y,$l;
        $K = "</p>\n";
        if (!$qc && ($zh = $l->warnings())) {
            $u = "warnings";
            $K = ", <a href='#$u'>" . lang(35) . "</a>" . script("qsl('a').onclick = partial(toggle, '$u');", "") . "$K<div id='$u' class='hidden'>\n$zh</div>\n";
        }return"<p><code class='jush-$y'>" . h(str_replace("\n", " ", $I)) . "</code> <span class='time'>(" . format_time($hg) . ")</span>" . (support("sql") ? " <a href='" . h(ME) . "sql=" . urlencode($I) . "'>" . lang(10) . "</a>" : "") . $K;
    }function sqlCommandQuery($I)
    {
        return
            shorten_utf8(trim($I), 1000);
    }function rowDescription($Q)
    {
        return"";
    }function rowDescriptions($M, $Ac)
    {
        return$M;
    }function selectLink($X, $n)
    {
    }function selectVal($X, $A, $n, $Ge)
    {
        $K = ($X === null ? "<i>NULL</i>" : (preg_match("~char|binary|boolean~", $n["type"]) && !preg_match("~var~", $n["type"]) ? "<code>$X</code>" : $X));
        if (preg_match('~blob|bytea|raw|file~', $n["type"]) && !is_utf8($X)) {
            $K = "<i>" . lang(36, strlen($Ge)) . "</i>";
        }if (preg_match('~json~', $n["type"])) {
            $K = "<code class='jush-js'>$K</code>";
        }return($A ? "<a href='" . h($A) . "'" . (is_url($A) ? target_blank() : "") . ">$K</a>" : $K);
    }function editVal($X, $n)
    {
        return$X;
    }function tableStructurePrint($o)
    {
        echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap'>\n","<thead><tr><th>" . lang(37) . "<td>" . lang(38) . (support("comment") ? "<td>" . lang(39) : "") . "</thead>\n";foreach (
            $o as $n
        ) {
                echo"<tr" . odd() . "><th>" . h($n["field"]),"<td><span title='" . h($n["collation"]) . "'>" . h($n["full_type"]) . "</span>",($n["null"] ? " <i>NULL</i>" : ""),($n["auto_increment"] ? " <i>" . lang(40) . "</i>" : ""),(isset($n["default"]) ? " <span title='" . lang(41) . "'>[<b>" . h($n["default"]) . "</b>]</span>" : ""),(support("comment") ? "<td>" . h($n["comment"]) : ""),"\n";
        }echo"</table>\n","</div>\n";
    }function tableIndexesPrint($x)
    {
        echo"<table cellspacing='0'>\n";foreach (
            $x as $E => $w
        ) {
                ksort($w["columns"]);
                $gf = array();
            foreach ($w["columns"] as $z => $X) {
                $gf[] = "<i>" . h($X) . "</i>" . ($w["lengths"][$z] ? "(" . $w["lengths"][$z] . ")" : "") . ($w["descs"][$z] ? " DESC" : "");
            }echo"<tr title='" . h($E) . "'><th>$w[type]<td>" . implode(", ", $gf) . "\n";
        }echo"</table>\n";
    }function selectColumnsPrint($N, $e)
    {
        global$Gc,$Lc;
        print_fieldset("select", lang(42), $N);
        $t = 0;
        $N[""] = array();foreach (
            $N as $z => $X
        ) {
            $X = $_GET["columns"][$z];
            $d = select_input(" name='columns[$t][col]'", $e, $X["col"], ($z !== "" ? "selectFieldChange" : "selectAddRow"));
            echo"<div>" . ($Gc || $Lc ? "<select name='columns[$t][fun]'>" . optionlist(array(-1 => "") + array_filter(array(lang(43) => $Gc,lang(44) => $Lc)), $X["fun"]) . "</select>" . on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'", 1) . script("qsl('select').onchange = function () { helpClose();" . ($z !== "" ? "" : " qsl('select, input', this.parentNode).onchange();") . " };", "") . "($d)" : $d) . "</div>\n";
            $t++;
        }echo"</div></fieldset>\n";
    }function selectSearchPrint($Z, $e, $x)
    {
        print_fieldset("search", lang(45), $Z);foreach (
            $x as $t => $w
        ) {
            if ($w["type"] == "FULLTEXT") {
                echo"<div>(<i>" . implode("</i>, <i>", array_map('h', $w["columns"])) . "</i>) AGAINST"," <input type='search' name='fulltext[$t]' value='" . h($_GET["fulltext"][$t]) . "'>",script("qsl('input').oninput = selectFieldChange;", ""),checkbox("boolean[$t]", 1, isset($_GET["boolean"][$t]), "BOOL"),"</div>\n";
            }
        }$Ka = "this.parentNode.firstChild.onchange();";
        foreach (array_merge((array)$_GET["where"], array(array())) as $t => $X) {
            if (!$X || ("$X[col]$X[val]" != "" && in_array($X["op"], $this->operators))) {
                echo"<div>" . select_input(" name='where[$t][col]'", $e, $X["col"], ($X ? "selectFieldChange" : "selectAddRow"), "(" . lang(46) . ")"),html_select("where[$t][op]", $this->operators, $X["op"], $Ka),"<input type='search' name='where[$t][val]' value='" . h($X["val"]) . "'>",script("mixin(qsl('input'), {oninput: function () { $Ka }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});", ""),"</div>\n";
            }
        }echo"</div></fieldset>\n";
    }function selectOrderPrint($ze, $e, $x)
    {
        print_fieldset("sort", lang(47), $ze);
        $t = 0;
        foreach ((array)$_GET["order"] as $z => $X) {
            if ($X != "") {
                echo"<div>" . select_input(" name='order[$t]'", $e, $X, "selectFieldChange"),checkbox("desc[$t]", 1, isset($_GET["desc"][$z]), lang(48)) . "</div>\n";
                $t++;
            }
        }echo"<div>" . select_input(" name='order[$t]'", $e, "", "selectAddRow"),checkbox("desc[$t]", 1, false, lang(48)) . "</div>\n","</div></fieldset>\n";
    }function selectLimitPrint($_)
    {
        echo"<fieldset><legend>" . lang(49) . "</legend><div>";
        echo"<input type='number' name='limit' class='size' value='" . h($_) . "'>",script("qsl('input').oninput = selectFieldChange;", ""),"</div></fieldset>\n";
    }function selectLengthPrint($Fg)
    {
        if ($Fg !== null) {
            echo"<fieldset><legend>" . lang(50) . "</legend><div>","<input type='number' name='text_length' class='size' value='" . h($Fg) . "'>","</div></fieldset>\n";
        }
    }function selectActionPrint($x)
    {
        echo"<fieldset><legend>" . lang(51) . "</legend><div>","<input type='submit' value='" . lang(42) . "'>"," <span id='noindex' title='" . lang(52) . "'></span>","<script" . nonce() . ">\n","var indexColumns = ";
        $e = array();foreach (
            $x as $w
        ) {
            $rb = reset($w["columns"]);
            if ($w["type"] != "FULLTEXT" && $rb) {
                $e[$rb] = 1;
            }
        }$e[""] = 1;foreach (
            $e as $z => $X
        ) {
            json_row($z);
        }
        echo";\n","selectFieldChange.call(qs('#form')['select']);\n","</script>\n","</div></fieldset>\n";
    }function selectCommandPrint()
    {
        return!information_schema(DB);
    }function selectImportPrint()
    {
        return!information_schema(DB);
    }function selectEmailPrint($Wb, $e)
    {
    }function selectColumnsProcess($e, $x)
    {
        global$Gc,$Lc;
        $N = array();
        $s = array();
        foreach ((array)$_GET["columns"] as $z => $X) {
            if ($X["fun"] == "count" || ($X["col"] != "" && (!$X["fun"] || in_array($X["fun"], $Gc) || in_array($X["fun"], $Lc)))) {
                $N[$z] = apply_sql_function($X["fun"], ($X["col"] != "" ? idf_escape($X["col"]) : "*"));
                if (!in_array($X["fun"], $Lc)) {
                    $s[] = $N[$z];
                }
            }
        }return
            array($N,$s);
    }function selectSearchProcess($o, $x)
    {
        global$g,$l;
        $K = array();foreach (
            $x as $t => $w
        ) {
            if ($w["type"] == "FULLTEXT" && $_GET["fulltext"][$t] != "") {
                $K[] = "MATCH (" . implode(", ", array_map('idf_escape', $w["columns"])) . ") AGAINST (" . q($_GET["fulltext"][$t]) . (isset($_GET["boolean"][$t]) ? " IN BOOLEAN MODE" : "") . ")";
            }
        }foreach ((array)$_GET["where"] as $z => $X) {
            if ("$X[col]$X[val]" != "" && in_array($X["op"], $this->operators)) {
                $df = "";
                $db = " $X[op]";
                if (preg_match('~IN$~', $X["op"])) {
                    $ad = process_length($X["val"]);
                    $db .= " " . ($ad != "" ? $ad : "(NULL)");
                } elseif ($X["op"] == "SQL") {
                    $db = " $X[val]";
                } elseif ($X["op"] == "LIKE %%") {
                    $db = " LIKE " . $this->processInput($o[$X["col"]], "%$X[val]%");
                } elseif ($X["op"] == "ILIKE %%") {
                    $db = " ILIKE " . $this->processInput($o[$X["col"]], "%$X[val]%");
                } elseif ($X["op"] == "FIND_IN_SET") {
                    $df = "$X[op](" . q($X["val"]) . ", ";
                    $db = ")";
                } elseif (!preg_match('~NULL$~', $X["op"])) {
                    $db .= " " . $this->processInput($o[$X["col"]], $X["val"]);
                }if ($X["col"] != "") {
                    $K[] = $df . $l->convertSearch(idf_escape($X["col"]), $X, $o[$X["col"]]) . $db;
                } else {
                    $Ya = array();foreach (
                        $o as $E => $n
                    ) {
                        if ((preg_match('~^[-\d.' . (preg_match('~IN$~', $X["op"]) ? ',' : '') . ']+$~', $X["val"]) || !preg_match('~' . number_type() . '|bit~', $n["type"])) && (!preg_match("~[\x80-\xFF]~", $X["val"]) || preg_match('~char|text|enum|set~', $n["type"])) && (!preg_match('~date|timestamp~', $n["type"]) || preg_match('~^\d+-\d+-\d+~', $X["val"]))) {
                            $Ya[] = $df . $l->convertSearch(idf_escape($E), $X, $n) . $db;
                        }
                    }$K[] = ($Ya ? "(" . implode(" OR ", $Ya) . ")" : "1 = 0");
                }
            }
        }return$K;
    }function selectOrderProcess($o, $x)
    {
        $K = array();
        foreach ((array)$_GET["order"] as $z => $X) {
            if ($X != "") {
                $K[] = (preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~', $X) ? $X : idf_escape($X)) . (isset($_GET["desc"][$z]) ? " DESC" : "");
            }
        }return$K;
    }function selectLimitProcess()
    {
        return(isset($_GET["limit"]) ? $_GET["limit"] : "50");
    }function selectLengthProcess()
    {
        return(isset($_GET["text_length"]) ? $_GET["text_length"] : "100");
    }function selectEmailProcess($Z, $Ac)
    {
        return
            false;
    }function selectQueryBuild($N, $Z, $s, $ze, $_, $F)
    {
        return"";
    }function messageQuery($I, $Gg, $qc = false)
    {
        global$y,$l;
        restart_session();
        $Tc=&get_session("queries");
        if (!$Tc[$_GET["db"]]) {
            $Tc[$_GET["db"]] = array();
        }if (strlen($I) > 1e6) {
            $I = preg_replace('~[\x80-\xFF]+$~', '', substr($I, 0, 1e6)) . "\nâ€¦";
        }$Tc[$_GET["db"]][] = array($I,time(),$Gg);
        $fg = "sql-" . count($Tc[$_GET["db"]]);
        $K = "<a href='#$fg' class='toggle'>" . lang(53) . "</a>\n";
        if (!$qc && ($zh = $l->warnings())) {
            $u = "warnings-" . count($Tc[$_GET["db"]]);
            $K = "<a href='#$u' class='toggle'>" . lang(35) . "</a>, $K<div id='$u' class='hidden'>\n$zh</div>\n";
        }return" <span class='time'>" . @date("H:i:s") . "</span>" . " $K<div id='$fg' class='hidden'><pre><code class='jush-$y'>" . shorten_utf8($I, 1000) . "</code></pre>" . ($Gg ? " <span class='time'>($Gg)</span>" : '') . (support("sql") ? '<p><a href="' . h(str_replace("db=" . urlencode(DB), "db=" . urlencode($_GET["db"]), ME) . 'sql=&history=' . (count($Tc[$_GET["db"]]) - 1)) . '">' . lang(10) . '</a>' : '') . '</div>';
    }function editRowPrint($Q, $o, $L, $ih)
    {
    }function editFunctions($n)
    {
        global$Rb;
        $K = ($n["null"] ? "NULL/" : "");
        $ih = isset($_GET["select"]) || where($_GET);foreach (
            $Rb as $z => $Gc
        ) {
            if (!$z || (!isset($_GET["call"]) && $ih)) {
                foreach (
                    $Gc as $Ue => $X
                ) {
                    if (!$Ue || preg_match("~$Ue~", $n["type"])) {
                        $K .= "/$X";
                    }
                }
            }if ($z && !preg_match('~set|blob|bytea|raw|file|bool~', $n["type"])) {
                $K .= "/SQL";
            }
        }if ($n["auto_increment"] && !$ih) {
            $K = lang(40);
        }return
            explode("/", $K);
    }function editInput($Q, $n, $wa, $Y)
    {
        if ($n["type"] == "enum") {
            return(isset($_GET["select"]) ? "<label><input type='radio'$wa value='-1' checked><i>" . lang(8) . "</i></label> " : "") . ($n["null"] ? "<label><input type='radio'$wa value=''" . ($Y !== null || isset($_GET["select"]) ? "" : " checked") . "><i>NULL</i></label> " : "") . enum_input("radio", $wa, $n, $Y, 0);
        }return"";
    }function editHint($Q, $n, $Y)
    {
        return"";
    }function processInput($n, $Y, $r = "")
    {
        if ($r == "SQL") {
            return$Y;
        }$E = $n["field"];
        $K = q($Y);
        if (preg_match('~^(now|getdate|uuid)$~', $r)) {
            $K = "$r()";
        } elseif (preg_match('~^current_(date|timestamp)$~', $r)) {
            $K = $r;
        } elseif (preg_match('~^([+-]|\|\|)$~', $r)) {
            $K = idf_escape($E) . " $r $K";
        } elseif (preg_match('~^[+-] interval$~', $r)) {
            $K = idf_escape($E) . " $r " . (preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i", $Y) ? $Y : $K);
        } elseif (preg_match('~^(addtime|subtime|concat)$~', $r)) {
            $K = "$r(" . idf_escape($E) . ", $K)";
        } elseif (preg_match('~^(md5|sha1|password|encrypt)$~', $r)) {
            $K = "$r($K)";
        }return
            unconvert_field($n, $K);
    }function dumpOutput()
    {
        $K = array('text' => lang(54),'file' => lang(55));
        if (function_exists('gzencode')) {
            $K['gz'] = 'gzip';
        }return$K;
    }function dumpFormat()
    {
        return
            array('sql' => 'SQL','csv' => 'CSV,','csv;' => 'CSV;','tsv' => 'TSV');
    }function dumpDatabase($k)
    {
    }function dumpTable($Q, $ng, $md = 0)
    {
        if ($_POST["format"] != "sql") {
            echo"\xef\xbb\xbf";
            if ($ng) {
                dump_csv(array_keys(fields($Q)));
            }
        } else {
            if ($md == 2) {
                $o = array();
                foreach (fields($Q) as $E => $n) {
                    $o[] = idf_escape($E) . " $n[full_type]";
                }$i = "CREATE TABLE " . table($Q) . " (" . implode(", ", $o) . ")";
            } else {
                $i = create_sql($Q, $_POST["auto_increment"], $ng);
            }
            set_utf8mb4($i);
            if ($ng && $i) {
                if ($ng == "DROP+CREATE" || $md == 1) {
                    echo"DROP " . ($md == 2 ? "VIEW" : "TABLE") . " IF EXISTS " . table($Q) . ";\n";
                }if ($md == 1) {
                    $i = remove_definer($i);
                }echo"$i;\n\n";
            }
        }
    }function dumpData($Q, $ng, $I)
    {
        global$g,$y;
        $Ld = ($y == "sqlite" ? 0 : 1048576);if ($ng) {
            if ($_POST["format"] == "sql") {
                if ($ng == "TRUNCATE+INSERT") {
                    echo
                    truncate_sql($Q) . ";\n";
                }$o = fields($Q);
            }$J = $g->query($I, 1);
            if ($J) {
                $fd = "";
                $Ia = "";
                $pd = array();
                $pg = "";
                $tc = ($Q != '' ? 'fetch_assoc' : 'fetch_row');
                while ($L = $J->$tc()) {
                    if (!$pd) {
                        $rh = array();foreach (
                            $L as $X
                        ) {
                            $n = $J->fetch_field();
                            $pd[] = $n->name;
                            $z = idf_escape($n->name);
                            $rh[] = "$z = VALUES($z)";
                        }$pg = ($ng == "INSERT+UPDATE" ? "\nON DUPLICATE KEY UPDATE " . implode(", ", $rh) : "") . ";\n";
                    }if ($_POST["format"] != "sql") {
                        if ($ng == "table") {
                            dump_csv($pd);
                            $ng = "INSERT";
                        }dump_csv($L);
                    } else {
                        if (!$fd) {
                            $fd = "INSERT INTO " . table($Q) . " (" . implode(", ", array_map('idf_escape', $pd)) . ") VALUES";
                        }foreach (
                            $L as $z => $X
                        ) {
                            $n = $o[$z];
                            $L[$z] = ($X !== null ? unconvert_field($n, preg_match(number_type(), $n["type"]) && !preg_match('~\[~', $n["full_type"]) && is_numeric($X) ? $X : q(($X === false ? 0 : $X))) : "NULL");
                        }$If = ($Ld ? "\n" : " ") . "(" . implode(",\t", $L) . ")";
                        if (!$Ia) {
                            $Ia = $fd . $If;
                        } elseif (strlen($Ia) + 4 + strlen($If) + strlen($pg) < $Ld) {
                            $Ia .= ",$If";
                        } else {
                            echo$Ia . $pg;
                            $Ia = $fd . $If;
                        }
                    }
                }if ($Ia) {
                    echo$Ia . $pg;
                }
            } elseif ($_POST["format"] == "sql") {
                echo"-- " . str_replace("\n", " ", $g->error) . "\n";
            }
        }
    }function dumpFilename($Xc)
    {
        return
        friendly_url($Xc != "" ? $Xc : (SERVER != "" ? SERVER : "localhost"));
    }function dumpHeaders($Xc, $Xd = false)
    {
        $Ie = $_POST["output"];
        $nc = (preg_match('~sql~', $_POST["format"]) ? "sql" : ($Xd ? "tar" : "csv"));
        header("Content-Type: " . ($Ie == "gz" ? "application/x-gzip" : ($nc == "tar" ? "application/x-tar" : ($nc == "sql" || $Ie != "file" ? "text/plain" : "text/csv") . "; charset=utf-8")));
        if ($Ie == "gz") {
            ob_start('ob_gzencode', 1e6);
        }return$nc;
    }function importServerPath()
    {
        return"adminer.sql";
    }function homepage()
    {
        echo'<p class="links">' . ($_GET["ns"] == "" && support("database") ? '<a href="' . h(ME) . 'database=">' . lang(56) . "</a>\n" : ""),(support("scheme") ? "<a href='" . h(ME) . "scheme='>" . ($_GET["ns"] != "" ? lang(57) : lang(58)) . "</a>\n" : ""),($_GET["ns"] !== "" ? '<a href="' . h(ME) . 'schema=">' . lang(59) . "</a>\n" : ""),(support("privileges") ? "<a href='" . h(ME) . "privileges='>" . lang(60) . "</a>\n" : "");return
            true;
    }function navigation($Wd)
    {
        global$fa,$y,$Kb,$g;echo'<h1>
',$this->name(),' <span class="version">',$fa,'</span>
<a href="https://www.adminer.org/#download"',target_blank(),' id="version">',(version_compare($fa, $_COOKIE["adminer_version"]) < 0 ? h($_COOKIE["adminer_version"]) : ""),'</a>
</h1>
';
        if ($Wd == "auth") {
            $Ie = "";foreach ((array)$_SESSION["pwds"] as $th => $Tf) {
                foreach (
                    $Tf as $O => $ph
                ) {
                    foreach (
                        $ph as $V => $G
                    ) {
                        if ($G !== null) {
                            $xb = $_SESSION["db"][$th][$O][$V];
                            foreach (($xb ? array_keys($xb) : array("")) as $k) {
                                $Ie .= "<li><a href='" . h(auth_url($th, $O, $V, $k)) . "'>($Kb[$th]) " . h($V . ($O != "" ? "@" . $this->serverName($O) : "") . ($k != "" ? " - $k" : "")) . "</a>\n";
                            }
                        }
                    }
                }
            }if ($Ie) {
                echo"<ul id='logins'>\n$Ie</ul>\n" . script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");
            }
        } else {
            $S = array();
            if ($_GET["ns"] !== "" && !$Wd && DB != "") {
                $g->select_db(DB);
                $S = table_status('', true);
            }echo
                script_src(preg_replace("~\\?.*~", "", ME) . "?file=jush.js&version=4.8.1");if (support("sql")) {
                echo'<script',nonce(),'>
';
                if ($S) {
                    $Ed = array();foreach (
                        $S as $Q => $U
                    ) {
                        $Ed[] = preg_quote($Q, '/');
                    }
                    echo"var jushLinks = { $y: [ '" . js_escape(ME) . (support("table") ? "table=" : "select=") . "\$&', /\\b(" . implode("|", $Ed) . ")\\b/g ] };\n";
                    foreach (array("bac","bra","sqlite_quo","mssql_bra") as $X) {
                        echo"jushLinks.$X = jushLinks.$y;\n";
                    }
                }$Sf = $g->server_info;echo'bodyLoad(\'',(is_object($g) ? preg_replace('~^(\d\.?\d).*~s', '\1', $Sf) : ""),'\'',(preg_match('~MariaDB~', $Sf) ? ", true" : ""),');
</script>
';
                }$this->databasesPrint($Wd);
                if (DB == "" || !$Wd) {
                    echo"<p class='links'>" . (support("sql") ? "<a href='" . h(ME) . "sql='" . bold(isset($_GET["sql"]) && !isset($_GET["import"])) . ">" . lang(53) . "</a>\n<a href='" . h(ME) . "import='" . bold(isset($_GET["import"])) . ">" . lang(61) . "</a>\n" : "") . "";
                    if (support("dump")) {
                        echo"<a href='" . h(ME) . "dump=" . urlencode(isset($_GET["table"]) ? $_GET["table"] : $_GET["select"]) . "' id='dump'" . bold(isset($_GET["dump"])) . ">" . lang(62) . "</a>\n";
                    }
                }if ($_GET["ns"] !== "" && !$Wd && DB != "") {
                    echo'<a href="' . h(ME) . 'create="' . bold($_GET["create"] === "") . ">" . lang(63) . "</a>\n";
                    if (!$S) {
                        echo"<p class='message'>" . lang(9) . "\n";
                    } else {
                        $this->tablesPrint($S);
                    }
                }
        }
    }function databasesPrint($Wd)
    {
        global$c,$g;
        $j = $this->databases();
        if (DB && $j && !in_array(DB, $j)) {
            array_unshift($j, DB);
        }echo'<form action="">
<p id="dbs">
';
        hidden_fields_get();
        $vb = script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");
        echo"<span title='" . lang(64) . "'>" . lang(65) . "</span>: " . ($j ? "<select name='db'>" . optionlist(array("" => "") + $j, DB) . "</select>$vb" : "<input name='db' value='" . h(DB) . "' autocapitalize='off'>\n"),"<input type='submit' value='" . lang(20) . "'" . ($j ? " class='hidden'" : "") . ">\n";
        foreach (array("import","sql","schema","dump","privileges") as $X) {
            if (isset($_GET[$X])) {
                echo"<input type='hidden' name='$X' value=''>";
                break;
            }
        }echo"</p></form>\n";
    }function tablesPrint($S)
    {
        echo"<ul id='tables'>" . script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");foreach (
            $S as $Q => $ig
        ) {
                $E = $this->tableName($ig);
            if ($E != "") {
                echo'<li><a href="' . h(ME) . 'select=' . urlencode($Q) . '"' . bold($_GET["select"] == $Q || $_GET["edit"] == $Q, "select") . " title='" . lang(30) . "'>" . lang(66) . "</a> ",(support("table") || support("indexes") ? '<a href="' . h(ME) . 'table=' . urlencode($Q) . '"' . bold(in_array($Q, array($_GET["table"],$_GET["create"],$_GET["indexes"],$_GET["foreign"],$_GET["trigger"])), (is_view($ig) ? "view" : "structure")) . " title='" . lang(31) . "'>$E</a>" : "<span>$E</span>") . "\n";
            }
        }echo"</ul>\n";
    }
}$c = (function_exists('adminer_object') ? adminer_object() : new
            Adminer());
$Kb = array("server" => "MySQL") + $Kb;
if (!defined("DRIVER")) {
    define("DRIVER", "server");if (extension_loaded("mysqli")) {
        class Min_DB extends MySQLi
        {
            var$extension = "MySQLi";
            function __construct()
            {
                parent::init();
            }function connect($O = "", $V = "", $G = "", $ub = null, $Ye = null, $ag = null)
            {
                global$c;
                mysqli_report(MYSQLI_REPORT_OFF);
                list($Vc,$Ye) = explode(":", $O, 2);
                $gg = $c->connectSsl();
                if ($gg) {
                    $this->ssl_set($gg['key'], $gg['cert'], $gg['ca'], '', '');
                }$K = @$this->real_connect(($O != "" ? $Vc : ini_get("mysqli.default_host")), ($O . $V != "" ? $V : ini_get("mysqli.default_user")), ($O . $V . $G != "" ? $G : ini_get("mysqli.default_pw")), $ub, (is_numeric($Ye) ? $Ye : ini_get("mysqli.default_port")), (!is_numeric($Ye) ? $Ye : $ag), ($gg ? 64 : 0));
                $this->options(MYSQLI_OPT_LOCAL_INFILE, false);
                return$K;
            }function set_charset($La)
            {
                if (parent::set_charset($La)) {
                            return
                        true;
                }parent::set_charset('utf8');
                return$this->query("SET NAMES $La");
            }function result($I, $n = 0)
            {
                $J = $this->query($I);if (!$J) {
                            return
                    false;
                }$L = $J->fetch_array();
                return$L[$n];
            }function quote($lg)
            {
                return"'" . $this->escape_string($lg) . "'";
            }
        }
    } elseif (extension_loaded("mysql") && !((ini_bool("sql.safe_mode") || ini_bool("mysql.allow_local_infile")) && extension_loaded("pdo_mysql"))) {
        class Min_DB
        {
            var$extension = "MySQL",$server_info,$affected_rows,$errno,$error,$_link,$_result;function connect($O, $V, $G)
            {
                if (ini_bool("mysql.allow_local_infile")) {
                    $this->error = lang(67, "'mysql.allow_local_infile'", "MySQLi", "PDO_MySQL");return
                    false;
                }$this->_link = @mysql_connect(($O != "" ? $O : ini_get("mysql.default_host")), ("$O$V" != "" ? $V : ini_get("mysql.default_user")), ("$O$V$G" != "" ? $G : ini_get("mysql.default_password")), true, 131072);
                if ($this->_link) {
                    $this->server_info = mysql_get_server_info($this->_link);
                } else {
                    $this->error = mysql_error();
                }
                return(bool)$this->_link;
            }function set_charset($La)
            {
                if (function_exists('mysql_set_charset')) {
                    if (mysql_set_charset($La, $this->_link)) {
                        return
                        true;
                    }mysql_set_charset('utf8', $this->_link);
                }return$this->query("SET NAMES $La");
            }function quote($lg)
            {
                return"'" . mysql_real_escape_string($lg, $this->_link) . "'";
            }function select_db($ub)
            {
                return
                mysql_select_db($ub, $this->_link);
            }function query($I, $bh = false)
            {
                $J = @($bh ? mysql_unbuffered_query($I, $this->_link) : mysql_query($I, $this->_link));
                $this->error = "";
                if (!$J) {
                    $this->errno = mysql_errno($this->_link);
                    $this->error = mysql_error($this->_link);return
                    false;
                }if ($J === true) {
                    $this->affected_rows = mysql_affected_rows($this->_link);
                    $this->info = mysql_info($this->_link);return
                    true;
                }return
                new
                Min_Result($J);
            }function multi_query($I)
            {
                return$this->_result = $this->query($I);
            }function store_result()
            {
                return$this->_result;
            }function next_result()
            {
                return
                false;
            }function result($I, $n = 0)
            {
                $J = $this->query($I);if (!$J || !$J->num_rows) {
                            return
                        false;
                }return
                mysql_result($J->_result, 0, $n);
            }
        }class Min_Result
        {
            var$num_rows,$_result,$_offset = 0;
            function __construct($J)
            {
                $this->_result = $J;
                    $this->num_rows = mysql_num_rows($J);
            }function fetch_assoc()
            {
                return
                mysql_fetch_assoc($this->_result);
            }function fetch_row()
            {
                return
                mysql_fetch_row($this->_result);
            }function fetch_field()
            {
                $K = mysql_fetch_field($this->_result, $this->_offset++);
                $K->orgtable = $K->table;
                $K->orgname = $K->name;
                $K->charsetnr = ($K->blob ? 63 : 0);
                return$K;
            }function __destruct()
            {
                mysql_free_result($this->_result);
            }
        }
    } elseif (extension_loaded("pdo_mysql")) {
        class Min_DB extends Min_PDO
        {
            var$extension = "PDO_MySQL";
            function connect($O, $V, $G)
            {
                global$c;
                    $xe = array(PDO::MYSQL_ATTR_LOCAL_INFILE => false);
                    $gg = $c->connectSsl();
                if ($gg) {
                    if (!empty($gg['key'])) {
                        $xe[PDO::MYSQL_ATTR_SSL_KEY] = $gg['key'];
                    }if (!empty($gg['cert'])) {
                        $xe[PDO::MYSQL_ATTR_SSL_CERT] = $gg['cert'];
                    }if (!empty($gg['ca'])) {
                        $xe[PDO::MYSQL_ATTR_SSL_CA] = $gg['ca'];
                    }
                }$this->dsn("mysql:charset=utf8;host=" . str_replace(":", ";unix_socket=", preg_replace('~:(\d)~', ';port=\1', $O)), $V, $G, $xe);return
                true;
            }function set_charset($La)
            {
                $this->query("SET NAMES $La");
            }function select_db($ub)
            {
                return$this->query("USE " . idf_escape($ub));
            }function query($I, $bh = false)
            {
                $this->pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, !$bh);return
                parent::query($I, $bh);
            }
        }
    }class Min_Driver extends Min_SQL
    {
        function insert($Q, $P)
        {
            return($P ? parent::insert($Q, $P) : queries("INSERT INTO " . table($Q) . " ()\nVALUES ()"));
        }function insertUpdate($Q, $M, $ff)
        {
            $e = array_keys(reset($M));
            $df = "INSERT INTO " . table($Q) . " (" . implode(", ", $e) . ") VALUES\n";
            $rh = array();foreach (
                $e as $z
            ) {
                $rh[$z] = "$z = VALUES($z)";
            }
            $pg = "\nON DUPLICATE KEY UPDATE " . implode(", ", $rh);
            $rh = array();
            $Bd = 0;foreach (
                $M as $P
            ) {
                $Y = "(" . implode(", ", $P) . ")";if ($rh && (strlen($df) + $Bd + strlen($Y) + strlen($pg) > 1e6)) {
                    if (!queries($df . implode(",\n", $rh) . $pg)) {
                        return
                        false;
                    }$rh = array();
                    $Bd = 0;
                }$rh[] = $Y;
                $Bd += strlen($Y) + 2;
            }return
                queries($df . implode(",\n", $rh) . $pg);
        }function slowQuery($I, $Hg)
        {
            if (min_version('5.7.8', '10.1.2')) {
                if (preg_match('~MariaDB~', $this->_conn->server_info)) {
                    return"SET STATEMENT max_statement_time=$Hg FOR $I";
                } elseif (preg_match('~^(SELECT\b)(.+)~is', $I, $C)) {
                    return"$C[1] /*+ MAX_EXECUTION_TIME(" . ($Hg * 1000) . ") */ $C[2]";
                }
            }
        }function convertSearch($v, $X, $n)
        {
            return(preg_match('~char|text|enum|set~', $n["type"]) && !preg_match("~^utf8~", $n["collation"]) && preg_match('~[\x80-\xFF]~', $X['val']) ? "CONVERT($v USING " . charset($this->_conn) . ")" : $v);
        }function warnings()
        {
            $J = $this->_conn->query("SHOW WARNINGS");
            if ($J && $J->num_rows) {
                ob_start();
                select($J);return
                ob_get_clean();
            }
        }function tableHelp($E)
        {
            $Hd = preg_match('~MariaDB~', $this->_conn->server_info);if (information_schema(DB)) {
                    return
                strtolower(($Hd ? "information-schema-$E-table/" : str_replace("_", "-", $E) . "-table.html"));
            }if (DB == "mysql") {
                    return($Hd ? "mysql$E-table/" : "system-database.html");
            }
        }
    }function idf_escape($v)
    {
        return"`" . str_replace("`", "``", $v) . "`";
    }function table($v)
    {
        return
            idf_escape($v);
    }function connect()
    {
        global$c,$ah,$mg;$g = new
            Min_DB();
        $nb = $c->credentials();
        if ($g->connect($nb[0], $nb[1], $nb[2])) {
            $g->set_charset(charset($g));
            $g->query("SET sql_quote_show_create = 1, autocommit = 1");
            if (min_version('5.7.8', 10.2, $g)) {
                $mg[lang(68)][] = "json";
                $ah["json"] = 4294967295;
            }return$g;
        }$K = $g->error;
        if (function_exists('iconv') && !is_utf8($K) && strlen($If = iconv("windows-1250", "utf-8", $K)) > strlen($K)) {
            $K = $If;
        }return$K;
    }function get_databases($yc)
    {
        $K = get_session("dbs");
        if ($K === null) {
            $I = (min_version(5) ? "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME" : "SHOW DATABASES");
            $K = ($yc ? slow_query($I) : get_vals($I));
            restart_session();
            set_session("dbs", $K);
            stop_session();
        }return$K;
    }function limit($I, $Z, $_, $ke = 0, $Rf = " ")
    {
        return" $I$Z" . ($_ !== null ? $Rf . "LIMIT $_" . ($ke ? " OFFSET $ke" : "") : "");
    }function limit1($Q, $I, $Z, $Rf = "\n")
    {
        return
            limit($I, $Z, 1, 0, $Rf);
    }function db_collation($k, $Xa)
    {
        global$g;
        $K = null;
        $i = $g->result("SHOW CREATE DATABASE " . idf_escape($k), 1);
        if (preg_match('~ COLLATE ([^ ]+)~', $i, $C)) {
            $K = $C[1];
        } elseif (preg_match('~ CHARACTER SET ([^ ]+)~', $i, $C)) {
            $K = $Xa[$C[1]][-1];
        }return$K;
    }function engines()
    {
        $K = array();
        foreach (get_rows("SHOW ENGINES") as $L) {
            if (preg_match("~YES|DEFAULT~", $L["Support"])) {
                $K[] = $L["Engine"];
            }
        }return$K;
    }function logged_user()
    {
        global$g;
        return$g->result("SELECT USER()");
    }function tables_list()
    {
        return
            get_key_vals(min_version(5) ? "SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME" : "SHOW TABLES");
    }function count_tables($j)
    {
        $K = array();foreach (
            $j as $k
        ) {
            $K[$k] = count(get_vals("SHOW TABLES IN " . idf_escape($k)));
        }
        return$K;
    }function table_status($E = "", $rc = false)
    {
        $K = array();
        foreach (get_rows($rc && min_version(5) ? "SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() " . ($E != "" ? "AND TABLE_NAME = " . q($E) : "ORDER BY Name") : "SHOW TABLE STATUS" . ($E != "" ? " LIKE " . q(addcslashes($E, "%_\\")) : "")) as $L) {
            if ($L["Engine"] == "InnoDB") {
                $L["Comment"] = preg_replace('~(?:(.+); )?InnoDB free: .*~', '\1', $L["Comment"]);
            }if (!isset($L["Engine"])) {
                $L["Comment"] = "";
            }if ($E != "") {
                return$L;
            }$K[$L["Name"]] = $L;
        }return$K;
    }function is_view($R)
    {
        return$R["Engine"] === null;
    }function fk_support($R)
    {
        return
            preg_match('~InnoDB|IBMDB2I~i', $R["Engine"]) || (preg_match('~NDB~i', $R["Engine"]) && min_version(5.6));
    }function fields($Q)
    {
        $K = array();
        foreach (get_rows("SHOW FULL COLUMNS FROM " . table($Q)) as $L) {
            preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~', $L["Type"], $C);
            $K[$L["Field"]] = array("field" => $L["Field"],"full_type" => $L["Type"],"type" => $C[1],"length" => $C[2],"unsigned" => ltrim($C[3] . $C[4]),"default" => ($L["Default"] != "" || preg_match("~char|set~", $C[1]) ? (preg_match('~text~', $C[1]) ? stripslashes(preg_replace("~^'(.*)'\$~", '\1', $L["Default"])) : $L["Default"]) : null),"null" => ($L["Null"] == "YES"),"auto_increment" => ($L["Extra"] == "auto_increment"),"on_update" => (preg_match('~^on update (.+)~i', $L["Extra"], $C) ? $C[1] : ""),"collation" => $L["Collation"],"privileges" => array_flip(preg_split('~, *~', $L["Privileges"])),"comment" => $L["Comment"],"primary" => ($L["Key"] == "PRI"),"generated" => preg_match('~^(VIRTUAL|PERSISTENT|STORED)~', $L["Extra"]),);
        }return$K;
    }function indexes($Q, $h = null)
    {
        $K = array();
        foreach (get_rows("SHOW INDEX FROM " . table($Q), $h) as $L) {
            $E = $L["Key_name"];
            $K[$E]["type"] = ($E == "PRIMARY" ? "PRIMARY" : ($L["Index_type"] == "FULLTEXT" ? "FULLTEXT" : ($L["Non_unique"] ? ($L["Index_type"] == "SPATIAL" ? "SPATIAL" : "INDEX") : "UNIQUE")));
            $K[$E]["columns"][] = $L["Column_name"];
            $K[$E]["lengths"][] = ($L["Index_type"] == "SPATIAL" ? null : $L["Sub_part"]);
            $K[$E]["descs"][] = null;
        }return$K;
    }function foreign_keys($Q)
    {
        global$g,$re;
        static $Ue = '(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';
        $K = array();
        $lb = $g->result("SHOW CREATE TABLE " . table($Q), 1);
        if ($lb) {
            preg_match_all("~CONSTRAINT ($Ue) FOREIGN KEY ?\\(((?:$Ue,? ?)+)\\) REFERENCES ($Ue)(?:\\.($Ue))? \\(((?:$Ue,? ?)+)\\)(?: ON DELETE ($re))?(?: ON UPDATE ($re))?~", $lb, $Jd, PREG_SET_ORDER);foreach (
                $Jd as $C
            ) {
                preg_match_all("~$Ue~", $C[2], $bg);
                preg_match_all("~$Ue~", $C[5], $Ag);
                $K[idf_unescape($C[1])] = array("db" => idf_unescape($C[4] != "" ? $C[3] : $C[4]),"table" => idf_unescape($C[4] != "" ? $C[4] : $C[3]),"source" => array_map('idf_unescape', $bg[0]),"target" => array_map('idf_unescape', $Ag[0]),"on_delete" => ($C[6] ? $C[6] : "RESTRICT"),"on_update" => ($C[7] ? $C[7] : "RESTRICT"),);
            }
        }return$K;
    }function view($E)
    {
        global$g;return
        array("select" => preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU', '', $g->result("SHOW CREATE VIEW " . table($E), 1)));
    }function collations()
    {
        $K = array();
        foreach (get_rows("SHOW COLLATION") as $L) {
            if ($L["Default"]) {
                $K[$L["Charset"]][-1] = $L["Collation"];
            } else {
                $K[$L["Charset"]][] = $L["Collation"];
            }
        }ksort($K);foreach (
            $K as $z => $X
        ) {
            asort($K[$z]);
        }
        return$K;
    }function information_schema($k)
    {
        return(min_version(5) && $k == "information_schema") || (min_version(5.5) && $k == "performance_schema");
    }function error()
    {
        global$g;return
            h(preg_replace('~^You have an error.*syntax to use~U', "Syntax error", $g->error));
    }function create_database($k, $Wa)
    {
        return
            queries("CREATE DATABASE " . idf_escape($k) . ($Wa ? " COLLATE " . q($Wa) : ""));
    }function drop_databases($j)
    {
        $K = apply_queries("DROP DATABASE", $j, 'idf_escape');
        restart_session();
        set_session("dbs", null);
        return$K;
    }function rename_database($E, $Wa)
    {
        $K = false;
        if (create_database($E, $Wa)) {
            $S = array();
            $wh = array();
            foreach (tables_list() as $Q => $U) {
                if ($U == 'VIEW') {
                    $wh[] = $Q;
                } else {
                    $S[] = $Q;
                }
            }$K = (!$S && !$wh) || move_tables($S, $wh, $E);
            drop_databases($K ? array(DB) : array());
        }return$K;
    }function auto_increment()
    {
        $za = " PRIMARY KEY";
        if ($_GET["create"] != "" && $_POST["auto_increment_col"]) {
            foreach (indexes($_GET["create"]) as $w) {
                if (in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"], $w["columns"], true)) {
                    $za = "";
                    break;
                }if ($w["type"] == "PRIMARY") {
                    $za = " UNIQUE";
                }
            }
        }return" AUTO_INCREMENT$za";
    }function alter_table($Q, $E, $o, $_c, $bb, $Zb, $Wa, $ya, $Qe)
    {
        $sa = array();foreach (
            $o as $n
        ) {
            $sa[] = ($n[1] ? ($Q != "" ? ($n[0] != "" ? "CHANGE " . idf_escape($n[0]) : "ADD") : " ") . " " . implode($n[1]) . ($Q != "" ? $n[2] : "") : "DROP " . idf_escape($n[0]));
        }
        $sa = array_merge($sa, $_c);
        $ig = ($bb !== null ? " COMMENT=" . q($bb) : "") . ($Zb ? " ENGINE=" . q($Zb) : "") . ($Wa ? " COLLATE " . q($Wa) : "") . ($ya != "" ? " AUTO_INCREMENT=$ya" : "");if ($Q == "") {
            return
            queries("CREATE TABLE " . table($E) . " (\n" . implode(",\n", $sa) . "\n)$ig$Qe");
        }if ($Q != $E) {
            $sa[] = "RENAME TO " . table($E);
        }if ($ig) {
            $sa[] = ltrim($ig);
        }return($sa || $Qe ? queries("ALTER TABLE " . table($Q) . "\n" . implode(",\n", $sa) . $Qe) : true);
    }function alter_indexes($Q, $sa)
    {
        foreach (
            $sa as $z => $X
        ) {
            $sa[$z] = ($X[2] == "DROP" ? "\nDROP INDEX " . idf_escape($X[1]) : "\nADD $X[0] " . ($X[0] == "PRIMARY" ? "KEY " : "") . ($X[1] != "" ? idf_escape($X[1]) . " " : "") . "(" . implode(", ", $X[2]) . ")");
        }return
            queries("ALTER TABLE " . table($Q) . implode(",", $sa));
    }function truncate_tables($S)
    {
        return
            apply_queries("TRUNCATE TABLE", $S);
    }function drop_views($wh)
    {
        return
        queries("DROP VIEW " . implode(", ", array_map('table', $wh)));
    }function drop_tables($S)
    {
        return
            queries("DROP TABLE " . implode(", ", array_map('table', $S)));
    }function move_tables($S, $wh, $Ag)
    {
        global$g;
        $zf = array();foreach (
            $S as $Q
        ) {
            $zf[] = table($Q) . " TO " . idf_escape($Ag) . "." . table($Q);
        }
        if (!$zf || queries("RENAME TABLE " . implode(", ", $zf))) {
            $Bb = array();foreach (
                $wh as $Q
            ) {
                $Bb[table($Q)] = view($Q);
            }
            $g->select_db($Ag);
            $k = idf_escape(DB);foreach (
                $Bb as $E => $vh
            ) {
                if (!queries("CREATE VIEW $E AS " . str_replace(" $k.", " ", $vh["select"])) || !queries("DROP VIEW $k.$E")) {
                    return
                    false;
                }
            }return
            true;
        }return
            false;
    }function copy_tables($S, $wh, $Ag)
    {
        queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");foreach (
            $S as $Q
        ) {
                $E = ($Ag == DB ? table("copy_$Q") : idf_escape($Ag) . "." . table($Q));if (($_POST["overwrite"] && !queries("\nDROP TABLE IF EXISTS $E")) || !queries("CREATE TABLE $E LIKE " . table($Q)) || !queries("INSERT INTO $E SELECT * FROM " . table($Q))) {
                    return
                    false;
                }foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\"))) as $L) {
                    $Vg = $L["Trigger"];if (!queries("CREATE TRIGGER " . ($Ag == DB ? idf_escape("copy_$Vg") : idf_escape($Ag) . "." . idf_escape($Vg)) . " $L[Timing] $L[Event] ON $E FOR EACH ROW\n$L[Statement];")) {
                        return
                        false;
                    }
                }
        }foreach (
            $wh as $Q
        ) {
            $E = ($Ag == DB ? table("copy_$Q") : idf_escape($Ag) . "." . table($Q));
            $vh = view($Q);if (($_POST["overwrite"] && !queries("DROP VIEW IF EXISTS $E")) || !queries("CREATE VIEW $E AS $vh[select]")) {
                return
                false;
            }
        }return
            true;
    }function trigger($E)
    {
        if ($E == "") {
            return
            array();
        }$M = get_rows("SHOW TRIGGERS WHERE `Trigger` = " . q($E));return
            reset($M);
    }function triggers($Q)
    {
        $K = array();
        foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\"))) as $L) {
            $K[$L["Trigger"]] = array($L["Timing"],$L["Event"]);
        }return$K;
    }function trigger_options()
    {
        return
            array("Timing" => array("BEFORE","AFTER"),"Event" => array("INSERT","UPDATE","DELETE"),"Type" => array("FOR EACH ROW"),);
    }function routine($E, $U)
    {
        global$g,$bc,$dd,$ah;
        $qa = array("bool","boolean","integer","double precision","real","dec","numeric","fixed","national char","national varchar");
        $cg = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
        $Zg = "((" . implode("|", array_merge(array_keys($ah), $qa)) . ")\\b(?:\\s*\\(((?:[^'\")]|$bc)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";
        $Ue = "$cg*(" . ($U == "FUNCTION" ? "" : $dd) . ")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Zg";
        $i = $g->result("SHOW CREATE $U " . idf_escape($E), 2);
        preg_match("~\\(((?:$Ue\\s*,?)*)\\)\\s*" . ($U == "FUNCTION" ? "RETURNS\\s+$Zg\\s+" : "") . "(.*)~is", $i, $C);
        $o = array();
        preg_match_all("~$Ue\\s*,?~is", $C[1], $Jd, PREG_SET_ORDER);foreach (
            $Jd as $Le
        ) {
            $o[] = array("field" => str_replace("``", "`", $Le[2]) . $Le[3],"type" => strtolower($Le[5]),"length" => preg_replace_callback("~$bc~s", 'normalize_enum', $Le[6]),"unsigned" => strtolower(preg_replace('~\s+~', ' ', trim("$Le[8] $Le[7]"))),"null" => 1,"full_type" => $Le[4],"inout" => strtoupper($Le[1]),"collation" => strtolower($Le[9]),);
        }if ($U != "FUNCTION") {
            return
            array("fields" => $o,"definition" => $C[11]);
        }return
        array("fields" => $o,"returns" => array("type" => $C[12],"length" => $C[13],"unsigned" => $C[15],"collation" => $C[16]),"definition" => $C[17],"language" => "SQL",);
    }function routines()
    {
        return
        get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = " . q(DB));
    }function routine_languages()
    {
        return
        array();
    }function routine_id($E, $L)
    {
        return
        idf_escape($E);
    }function last_id()
    {
        global$g;
        return$g->result("SELECT LAST_INSERT_ID()");
    }function explain($g, $I)
    {
        return$g->query("EXPLAIN " . (min_version(5.1) && !min_version(5.7) ? "PARTITIONS " : "") . $I);
    }function found_rows($R, $Z)
    {
        return($Z || $R["Engine"] != "InnoDB" ? null : $R["Rows"]);
    }function types()
    {
        return
            array();
    }function schemas()
    {
        return
            array();
    }function get_schema()
    {
        return"";
    }function set_schema($Kf, $h = null)
    {
        return
            true;
    }function create_sql($Q, $ya, $ng)
    {
        global$g;
        $K = $g->result("SHOW CREATE TABLE " . table($Q), 1);
        if (!$ya) {
            $K = preg_replace('~ AUTO_INCREMENT=\d+~', '', $K);
        }return$K;
    }function truncate_sql($Q)
    {
        return"TRUNCATE " . table($Q);
    }function use_sql($ub)
    {
        return"USE " . idf_escape($ub);
    }function trigger_sql($Q)
    {
        $K = "";
        foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\")), null, "-- ") as $L) {
            $K .= "\nCREATE TRIGGER " . idf_escape($L["Trigger"]) . " $L[Timing] $L[Event] ON " . table($L["Table"]) . " FOR EACH ROW\n$L[Statement];;\n";
        }return$K;
    }function show_variables()
    {
        return
            get_key_vals("SHOW VARIABLES");
    }function process_list()
    {
        return
        get_rows("SHOW FULL PROCESSLIST");
    }function show_status()
    {
        return
            get_key_vals("SHOW STATUS");
    }function convert_field($n)
    {
        if (preg_match("~binary~", $n["type"])) {
            return"HEX(" . idf_escape($n["field"]) . ")";
        }if ($n["type"] == "bit") {
            return"BIN(" . idf_escape($n["field"]) . " + 0)";
        }if (preg_match("~geometry|point|linestring|polygon~", $n["type"])) {
                return(min_version(8) ? "ST_" : "") . "AsWKT(" . idf_escape($n["field"]) . ")";
        }
    }function unconvert_field($n, $K)
    {
        if (preg_match("~binary~", $n["type"])) {
            $K = "UNHEX($K)";
        }if ($n["type"] == "bit") {
            $K = "CONV($K, 2, 10) + 0";
        }if (preg_match("~geometry|point|linestring|polygon~", $n["type"])) {
                $K = (min_version(8) ? "ST_" : "") . "GeomFromText($K, SRID($n[field]))";
        }return$K;
    }function support($sc)
    {
        return!preg_match("~scheme|sequence|type|view_trigger|materializedview" . (min_version(8) ? "" : "|descidx" . (min_version(5.1) ? "" : "|event|partitioning" . (min_version(5) ? "" : "|routine|trigger|view"))) . "~", $sc);
    }function kill_process($X)
    {
        return
            queries("KILL " . number($X));
    }function connection_id()
    {
        return"SELECT CONNECTION_ID()";
    }function max_connections()
    {
        global$g;
        return$g->result("SELECT @@max_connections");
    }function driver_config()
    {
        $ah = array();
        $mg = array();
        foreach (array(lang(69) => array("tinyint" => 3,"smallint" => 5,"mediumint" => 8,"int" => 10,"bigint" => 20,"decimal" => 66,"float" => 12,"double" => 21),lang(70) => array("date" => 10,"datetime" => 19,"timestamp" => 19,"time" => 10,"year" => 4),lang(68) => array("char" => 255,"varchar" => 65535,"tinytext" => 255,"text" => 65535,"mediumtext" => 16777215,"longtext" => 4294967295),lang(71) => array("enum" => 65535,"set" => 64),lang(72) => array("bit" => 20,"binary" => 255,"varbinary" => 65535,"tinyblob" => 255,"blob" => 65535,"mediumblob" => 16777215,"longblob" => 4294967295),lang(73) => array("geometry" => 0,"point" => 0,"linestring" => 0,"polygon" => 0,"multipoint" => 0,"multilinestring" => 0,"multipolygon" => 0,"geometrycollection" => 0),) as $z => $X) {
            $ah += $X;
            $mg[$z] = array_keys($X);
        }return
            array('possible_drivers' => array("MySQLi","MySQL","PDO_MySQL"),'jush' => "sql",'types' => $ah,'structured_types' => $mg,'unsigned' => array("unsigned","zerofill","unsigned zerofill"),'operators' => array("=","<",">","<=",">=","!=","LIKE","LIKE %%","REGEXP","IN","FIND_IN_SET","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL"),'functions' => array("char_length","date","from_unixtime","lower","round","floor","ceil","sec_to_time","time_to_sec","upper"),'grouping' => array("avg","count","count distinct","group_concat","max","min","sum"),'edit_functions' => array(array("char" => "md5/sha1/password/encrypt/uuid","binary" => "md5/sha1","date|time" => "now",),array(number_type() => "+/-","date" => "+ interval/- interval","time" => "addtime/subtime","char|text" => "concat",)),);
    }
}$eb = driver_config();
$cf = $eb['possible_drivers'];
$y = $eb['jush'];
$ah = $eb['types'];
$mg = $eb['structured_types'];
$hh = $eb['unsigned'];
$ve = $eb['operators'];
$Gc = $eb['functions'];
$Lc = $eb['grouping'];
$Rb = $eb['edit_functions'];
if ($c->operators === null) {
    $c->operators = $ve;
}define("SERVER", $_GET[DRIVER]);
define("DB", $_GET["db"]);
define("ME", preg_replace('~\?.*~', '', relative_uri()) . '?' . (sid() ? SID . '&' : '') . (SERVER !== null ? DRIVER . "=" . urlencode(SERVER) . '&' : '') . (isset($_GET["username"]) ? "username=" . urlencode($_GET["username"]) . '&' : '') . (DB != "" ? 'db=' . urlencode(DB) . '&' . (isset($_GET["ns"]) ? "ns=" . urlencode($_GET["ns"]) . "&" : "") : ''));
$fa = "4.8.1";
function page_header($Jg, $m = "", $Ha = array(), $Kg = "")
{
    global$a,$fa,$c,$Kb,$y;
    page_headers();
    if (is_ajax() && $m) {
        page_messages($m);
        exit;
    }$Lg = $Jg . ($Kg != "" ? ": $Kg" : "");
    $Mg = strip_tags($Lg . (SERVER != "" && SERVER != "localhost" ? h(" - " . SERVER) : "") . " - " . $c->name());echo'<!DOCTYPE html>
<html lang="',$a,'" dir="',lang(74),'">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>',$Mg,'</title>
<link rel="stylesheet" type="text/css" href="',h(preg_replace("~\\?.*~", "", ME) . "?file=default.css&version=4.8.1"),'">
',script_src(preg_replace("~\\?.*~", "", ME) . "?file=functions.js&version=4.8.1");if ($c->head()) {
        echo'<link rel="shortcut icon" type="image/x-icon" href="',h(preg_replace("~\\?.*~", "", ME) . "?file=favicon.ico&version=4.8.1"),'">
<link rel="apple-touch-icon" href="',h(preg_replace("~\\?.*~", "", ME) . "?file=favicon.ico&version=4.8.1"),'">
';foreach ($c->css() as $pb) {
            echo'<link rel="stylesheet" type="text/css" href="',h($pb),'">
';
        }
    }echo'
<body class="',lang(74),' nojs">
';
    $vc = get_temp_dir() . "/adminer.version";
    if (!$_COOKIE["adminer_version"] && function_exists('openssl_verify') && file_exists($vc) && filemtime($vc) + 86400 > time()) {
        $uh = unserialize(file_get_contents($vc));$mf = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";
        if (openssl_verify($uh["version"], base64_decode($uh["signature"]), $mf) == 1) {
            $_COOKIE["adminer_version"] = $uh["version"];
        }
    }echo'<script',nonce(),'>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick',(isset($_COOKIE["adminer_version"]) ? "" : ", onload: partial(verifyVersion, '$fa', '" . js_escape(ME) . "', '" . get_token() . "')");?>});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '<?php echo
js_escape(lang(75)),'\';
var thousandsSeparator = \'',js_escape(lang(5)),'\';
</script>

<div id="help" class="jush-',$y,' jsonly hidden"></div>
',script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"),'
<div id="content">
';
if ($Ha !== null) {
    $A = substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1);
    echo'<p id="breadcrumb"><a href="' . h($A ? $A : ".") . '">' . $Kb[DRIVER] . '</a> &raquo; ';
    $A = substr(preg_replace('~\b(db|ns)=[^&]*&~', '', ME), 0, -1);
    $O = $c->serverName(SERVER);
    $O = ($O != "" ? $O : lang(23));
    if ($Ha === false) {
        echo"$O\n";
    } else {
        echo"<a href='" . h($A) . "' accesskey='1' title='Alt+Shift+1'>$O</a> &raquo; ";
        if ($_GET["ns"] != "" || (DB != "" && is_array($Ha))) {
            echo'<a href="' . h($A . "&db=" . urlencode(DB) . (support("scheme") ? "&ns=" : "")) . '">' . h(DB) . '</a> &raquo; ';
        }if (is_array($Ha)) {
            if ($_GET["ns"] != "") {
                echo'<a href="' . h(substr(ME, 0, -1)) . '">' . h($_GET["ns"]) . '</a> &raquo; ';
            }foreach (
                $Ha as $z => $X
            ) {
                $Db = (is_array($X) ? $X[1] : h($X));
                if ($Db != "") {
                    echo"<a href='" . h(ME . "$z=") . urlencode(is_array($X) ? $X[0] : $X) . "'>$Db</a> &raquo; ";
                }
            }
        }echo"$Jg\n";
    }
}echo"<h2>$Lg</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";
restart_session();
page_messages($m);
$j=&get_session("dbs");
if (DB != "" && $j && !in_array(DB, $j, true)) {
    $j = null;
}stop_session();
define("PAGE_HEADER", 1);
}function page_headers()
{
    global$c;
    header("Content-Type: text/html; charset=utf-8");
    header("Cache-Control: no-cache");
    header("X-Frame-Options: deny");
    header("X-XSS-Protection: 0");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: origin-when-cross-origin");
    foreach ($c->csp() as $ob) {
        $Rc = array();foreach (
            $ob as $z => $X
        ) {
            $Rc[] = "$z $X";
        }
        header("Content-Security-Policy: " . implode("; ", $Rc));
    }$c->headers();
}function csp()
{
    return
        array(array("script-src" => "'self' 'unsafe-inline' 'nonce-" . get_nonce() . "' 'strict-dynamic'","connect-src" => "'self'","frame-src" => "https://www.adminer.org","object-src" => "'none'","base-uri" => "'none'","form-action" => "'self'",),);
}function get_nonce()
{
    static $fe;
    if (!$fe) {
        $fe = base64_encode(rand_string());
    }return$fe;
}function page_messages($m)
{
    $jh = preg_replace('~^[^?]*~', '', $_SERVER["REQUEST_URI"]);
    $Ud = $_SESSION["messages"][$jh];
    if ($Ud) {
        echo"<div class='message'>" . implode("</div>\n<div class='message'>", $Ud) . "</div>" . script("messagesPrint();");
        unset($_SESSION["messages"][$jh]);
    }if ($m) {
        echo"<div class='error'>$m</div>\n";
    }
}function page_footer($Wd = "")
{
    global$c,$T;echo'</div>

';
    switch_lang();if ($Wd != "auth") {
        echo'<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="',lang(76),'" id="logout">
<input type="hidden" name="token" value="',$T,'">
</p>
</form>
';
    }echo'<div id="menu">
';
    $c->navigation($Wd);echo'</div>
',script("setupSubmitHighlight(document);");
}function int32($Zd)
{
    while ($Zd >= 2147483648) {
        $Zd -= 4294967296;
    }while ($Zd <= -2147483649) {
        $Zd += 4294967296;
    }return(int)$Zd;
}function long2str($W, $yh)
{
    $If = '';foreach (
        $W as $X
    ) {
        $If .= pack('V', $X);
    }if ($yh) {
        return
        substr($If, 0, end($W));
    }return$If;
}function str2long($If, $yh)
{
    $W = array_values(unpack('V*', str_pad($If, 4 * ceil(strlen($If) / 4), "\0")));
    if ($yh) {
        $W[] = strlen($If);
    }return$W;
}function xxtea_mx($Eh, $Dh, $qg, $od)
{
    return
        int32((($Eh >> 5 & 0x7FFFFFF) ^ $Dh << 2) + (($Dh >> 3 & 0x1FFFFFFF) ^ $Eh << 4)) ^ int32(($qg ^ $Dh) + ($od ^ $Eh));
}function encrypt_string($kg, $z)
{
    if ($kg == "") {
        return"";
    }$z = array_values(unpack("V*", pack("H*", md5($z))));
    $W = str2long($kg, true);
    $Zd = count($W) - 1;
    $Eh = $W[$Zd];
    $Dh = $W[0];
    $H = floor(6 + 52 / ($Zd + 1));
    $qg = 0;
    while ($H-- > 0) {
        $qg = int32($qg + 0x9E3779B9);
        $Qb = $qg >> 2 & 3;for ($Je = 0; $Je < $Zd; $Je++) {
            $Dh = $W[$Je + 1];
            $Yd = xxtea_mx($Eh, $Dh, $qg, $z[$Je & 3 ^ $Qb]);
            $Eh = int32($W[$Je] + $Yd);
            $W[$Je] = $Eh;
        }$Dh = $W[0];
        $Yd = xxtea_mx($Eh, $Dh, $qg, $z[$Je & 3 ^ $Qb]);
        $Eh = int32($W[$Zd] + $Yd);
        $W[$Zd] = $Eh;
    }return
    long2str($W, false);
}function decrypt_string($kg, $z)
{
    if ($kg == "") {
        return"";
    }if (!$z) {
        return
        false;
    }$z = array_values(unpack("V*", pack("H*", md5($z))));
    $W = str2long($kg, false);
    $Zd = count($W) - 1;
    $Eh = $W[$Zd];
    $Dh = $W[0];
    $H = floor(6 + 52 / ($Zd + 1));
    $qg = int32($H * 0x9E3779B9);
    while ($qg) {
        $Qb = $qg >> 2 & 3;for ($Je = $Zd; $Je > 0; $Je--) {
            $Eh = $W[$Je - 1];
            $Yd = xxtea_mx($Eh, $Dh, $qg, $z[$Je & 3 ^ $Qb]);
            $Dh = int32($W[$Je] - $Yd);
            $W[$Je] = $Dh;
        }$Eh = $W[$Zd];
        $Yd = xxtea_mx($Eh, $Dh, $qg, $z[$Je & 3 ^ $Qb]);
        $Dh = int32($W[0] - $Yd);
        $W[0] = $Dh;
        $qg = int32($qg - 0x9E3779B9);
    }return
        long2str($W, true);
}$g = '';
$Qc = $_SESSION["token"];
if (!$Qc) {
    $_SESSION["token"] = rand(1, 1e6);
}$T = get_token();
$We = array();
if ($_COOKIE["adminer_permanent"]) {
    foreach (explode(" ", $_COOKIE["adminer_permanent"]) as $X) {
        list($z) = explode(":", $X);
        $We[$z] = $X;
    }
}function add_invalid_login()
{
    global$c;
    $q = file_open_lock(get_temp_dir() . "/adminer.invalid");
    if (!$q) {
        return;
    }$id = unserialize(stream_get_contents($q));
    $Gg = time();if ($id) {
        foreach (
            $id as $jd => $X
        ) {
            if ($X[0] < $Gg) {
                unset($id[$jd]);
            }
        }
    }$hd=&$id[$c->bruteForceKey()];
    if (!$hd) {
        $hd = array($Gg + 30 * 60,0);
    }$hd[1]++;
    file_write_unlock($q, serialize($id));
}function check_invalid_login()
{
    global$c;
    $id = unserialize(@file_get_contents(get_temp_dir() . "/adminer.invalid"));
    $hd = ($id ? $id[$c->bruteForceKey()] : array());
    $ee = ($hd[1] > 29 ? $hd[0] - time() : 0);
    if ($ee > 0) {
        auth_error(lang(77, ceil($ee / 60)));
    }
}$xa = $_POST["auth"];
if ($xa) {
    session_regenerate_id();
    $th = $xa["driver"];
    $O = $xa["server"];
    $V = $xa["username"];
    $G = (string)$xa["password"];
    $k = $xa["db"];
    set_password($th, $O, $V, $G);
    $_SESSION["db"][$th][$O][$V][$k] = true;
    if ($xa["permanent"]) {
        $z = base64_encode($th) . "-" . base64_encode($O) . "-" . base64_encode($V) . "-" . base64_encode($k);
        $hf = $c->permanentLogin(true);
        $We[$z] = "$z:" . base64_encode($hf ? encrypt_string($G, $hf) : "");
        cookie("adminer_permanent", implode(" ", $We));
    }if (count($_POST) == 1 || DRIVER != $th || SERVER != $O || $_GET["username"] !== $V || DB != $k) {
        redirect(auth_url($th, $O, $V, $k));
    }
} elseif ($_POST["logout"] && (!$Qc || verify_token())) {
    foreach (array("pwds","db","dbs","queries") as $z) {
        set_session($z, null);
    }unset_permanent();
    redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1), lang(78) . ' ' . lang(79));
} elseif ($We && !$_SESSION["pwds"]) {
    session_regenerate_id();
    $hf = $c->permanentLogin();foreach (
        $We as $z => $X
    ) {
        list(,$Qa) = explode(":", $X);
        list($th,$O,$V,$k) = array_map('base64_decode', explode("-", $z));
        set_password($th, $O, $V, decrypt_string(base64_decode($Qa), $hf));
        $_SESSION["db"][$th][$O][$V][$k] = true;
    }
}function unset_permanent()
{
    global$We;foreach (
        $We as $z => $X
    ) {
        list($th,$O,$V,$k) = array_map('base64_decode', explode("-", $z));
        if ($th == DRIVER && $O == SERVER && $V == $_GET["username"] && $k == DB) {
            unset($We[$z]);
        }
    }cookie("adminer_permanent", implode(" ", $We));
}function auth_error($m)
{
    global$c,$Qc;
    $Uf = session_name();
    if (isset($_GET["username"])) {
        header("HTTP/1.1 403 Forbidden");
        if (($_COOKIE[$Uf] || $_GET[$Uf]) && !$Qc) {
            $m = lang(80);
        } else {
            restart_session();
            add_invalid_login();
            $G = get_password();
            if ($G !== null) {
                if ($G === false) {
                    $m .= ($m ? '<br>' : '') . lang(81, target_blank(), '<code>permanentLogin()</code>');
                }set_password(DRIVER, SERVER, $_GET["username"], null);
            }unset_permanent();
        }
    }if (!$_COOKIE[$Uf] && $_GET[$Uf] && ini_bool("session.use_only_cookies")) {
        $m = lang(82);
    }$Me = session_get_cookie_params();
    cookie("adminer_key", ($_COOKIE["adminer_key"] ? $_COOKIE["adminer_key"] : rand_string()), $Me["lifetime"]);
    page_header(lang(27), $m, null);
    echo"<form action='' method='post'>\n","<div>";
    if (hidden_fields($_POST, array("auth"))) {
        echo"<p class='message'>" . lang(83) . "\n";
    }echo"</div>\n";
    $c->loginForm();
    echo"</form>\n";
    page_footer("auth");
    exit;
}if (isset($_GET["username"]) && !class_exists("Min_DB")) {
    unset($_SESSION["pwds"][DRIVER]);
    unset_permanent();
    page_header(lang(84), lang(85, implode(", ", $cf)), false);
    page_footer("auth");
    exit;
}stop_session(true);
if (isset($_GET["username"]) && is_string(get_password())) {
    list($Vc,$Ye) = explode(":", SERVER, 2);
    if (preg_match('~^\s*([-+]?\d+)~', $Ye, $C) && ($C[1] < 1024 || $C[1] > 65535)) {
        auth_error(lang(86));
    }check_invalid_login();
    $g = connect();$l = new
    Min_Driver($g);
}$Fd = null;
if (!is_object($g) || ($Fd = $c->login($_GET["username"], get_password())) !== true) {
    $m = (is_string($g) ? h($g) : (is_string($Fd) ? $Fd : lang(87)));
    auth_error($m . (preg_match('~^ | $~', get_password()) ? '<br>' . lang(88) : ''));
}if ($_POST["logout"] && $Qc && !verify_token()) {
    page_header(lang(76), lang(89));
    page_footer("db");
    exit;
}if ($xa && $_POST["token"]) {
    $_POST["token"] = $T;
}$m = '';
if ($_POST) {
    if (!verify_token()) {
        $cd = "max_input_vars";
        $Pd = ini_get($cd);
        if (extension_loaded("suhosin")) {
            foreach (array("suhosin.request.max_vars","suhosin.post.max_vars") as $z) {
                $X = ini_get($z);
                if ($X && (!$Pd || $X < $Pd)) {
                    $cd = $z;
                    $Pd = $X;
                }
            }
        }$m = (!$_POST["token"] && $Pd ? lang(90, "'$cd'") : lang(89) . ' ' . lang(91));
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $m = lang(92, "'post_max_size'");
    if (isset($_GET["sql"])) {
        $m .= ' ' . lang(93);
    }
}function select($J, $h = null, $Be = array(), $_ = 0)
{
    global$y;
    $Ed = array();
    $x = array();
    $e = array();
    $Fa = array();
    $ah = array();
    $K = array();
    odd('');for ($t = 0; (!$_ || $t < $_) && ($L = $J->fetch_row()); $t++) {
        if (!$t) {
            echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap'>\n","<thead><tr>";for ($nd = 0; $nd < count($L); $nd++) {
                $n = $J->fetch_field();
                $E = $n->name;
                $Ae = $n->orgtable;
                $_e = $n->orgname;
                $K[$n->table] = $Ae;
                if ($Be && $y == "sql") {
                    $Ed[$nd] = ($E == "table" ? "table=" : ($E == "possible_keys" ? "indexes=" : null));
                } elseif ($Ae != "") {
                    if (!isset($x[$Ae])) {
                        $x[$Ae] = array();
                        foreach (indexes($Ae, $h) as $w) {
                            if ($w["type"] == "PRIMARY") {
                                $x[$Ae] = array_flip($w["columns"]);
                                break;
                            }
                        }$e[$Ae] = $x[$Ae];
                    }if (isset($e[$Ae][$_e])) {
                        unset($e[$Ae][$_e]);
                        $x[$Ae][$_e] = $nd;
                        $Ed[$nd] = $Ae;
                    }
                }if ($n->charsetnr == 63) {
                    $Fa[$nd] = true;
                }$ah[$nd] = $n->type;
                echo"<th" . ($Ae != "" || $n->name != $_e ? " title='" . h(($Ae != "" ? "$Ae." : "") . $_e) . "'" : "") . ">" . h($E) . ($Be ? doc_link(array('sql' => "explain-output.html#explain_" . strtolower($E),'mariadb' => "explain/#the-columns-in-explain-select",)) : "");
            }echo"</thead>\n";
        }echo"<tr" . odd() . ">";foreach (
            $L as $z => $X
        ) {
            $A = "";
            if (isset($Ed[$z]) && !$e[$Ed[$z]]) {
                if ($Be && $y == "sql") {
                    $Q = $L[array_search("table=", $Ed)];
                    $A = ME . $Ed[$z] . urlencode($Be[$Q] != "" ? $Be[$Q] : $Q);
                } else {
                    $A = ME . "edit=" . urlencode($Ed[$z]);
                    foreach ($x[$Ed[$z]] as $Ua => $nd) {
                        $A .= "&where" . urlencode("[" . bracket_escape($Ua) . "]") . "=" . urlencode($L[$nd]);
                    }
                }
            } elseif (is_url($X)) {
                $A = $X;
            }if ($X === null) {
                $X = "<i>NULL</i>";
            } elseif ($Fa[$z] && !is_utf8($X)) {
                $X = "<i>" . lang(36, strlen($X)) . "</i>";
            } else {
                $X = h($X);
                if ($ah[$z] == 254) {
                    $X = "<code>$X</code>";
                }
            }if ($A) {
                $X = "<a href='" . h($A) . "'" . (is_url($A) ? target_blank() : '') . ">$X</a>";
            }echo"<td>$X";
        }
    }echo($t ? "</table>\n</div>" : "<p class='message'>" . lang(12)) . "\n";
    return$K;
}function referencable_primary($Pf)
{
    $K = array();
    foreach (table_status('', true) as $ug => $Q) {
        if ($ug != $Pf && fk_support($Q)) {
            foreach (fields($ug) as $n) {
                if ($n["primary"]) {
                    if ($K[$ug]) {
                        unset($K[$ug]);
                        break;
                    }$K[$ug] = $n;
                }
            }
        }
    }return$K;
}function adminer_settings()
{
    parse_str($_COOKIE["adminer_settings"], $Wf);
    return$Wf;
}function adminer_setting($z)
{
    $Wf = adminer_settings();
    return$Wf[$z];
}function set_adminer_settings($Wf)
{
    return
    cookie("adminer_settings", http_build_query($Wf + adminer_settings()));
}function textarea($E, $Y, $M = 10, $Ya = 80)
{
    global$y;
    echo"<textarea name='$E' rows='$M' cols='$Ya' class='sqlarea jush-$y' spellcheck='false' wrap='off'>";if (is_array($Y)) {
        foreach (
            $Y as $X
        ) {
            echo
            h($X[0]) . "\n\n\n";
        }
    } else {
        echo
        h($Y);
    }echo"</textarea>";
}function edit_type($z, $n, $Xa, $Bc = array(), $pc = array())
{
    global$mg,$ah,$hh,$re;
    $U = $n["type"];
    echo'<td><select name="',h($z),'[type]" class="type" aria-labelledby="label-type">';
    if ($U && !isset($ah[$U]) && !isset($Bc[$U]) && !in_array($U, $pc)) {
        $pc[] = $U;
    }if ($Bc) {
        $mg[lang(94)] = $Bc;
    }echo
    optionlist(array_merge($pc, $mg), $U),'</select><td><input name="',h($z),'[length]" value="',h($n["length"]),'" size="3"',(!$n["length"] && preg_match('~var(char|binary)$~', $U) ? " class='required'" : "");
    echo' aria-labelledby="label-length"><td class="options">',"<select name='" . h($z) . "[collation]'" . (preg_match('~(char|text|enum|set)$~', $U) ? "" : " class='hidden'") . '><option value="">(' . lang(95) . ')' . optionlist($Xa, $n["collation"]) . '</select>',($hh ? "<select name='" . h($z) . "[unsigned]'" . (!$U || preg_match(number_type(), $U) ? "" : " class='hidden'") . '><option>' . optionlist($hh, $n["unsigned"]) . '</select>' : ''),(isset($n['on_update']) ? "<select name='" . h($z) . "[on_update]'" . (preg_match('~timestamp|datetime~', $U) ? "" : " class='hidden'") . '>' . optionlist(array("" => "(" . lang(96) . ")","CURRENT_TIMESTAMP"), (preg_match('~^CURRENT_TIMESTAMP~i', $n["on_update"]) ? "CURRENT_TIMESTAMP" : $n["on_update"])) . '</select>' : ''),($Bc ? "<select name='" . h($z) . "[on_delete]'" . (preg_match("~`~", $U) ? "" : " class='hidden'") . "><option value=''>(" . lang(97) . ")" . optionlist(explode("|", $re), $n["on_delete"]) . "</select> " : " ");
}function process_length($Bd)
{
    global$bc;
    return(preg_match("~^\\s*\\(?\\s*$bc(?:\\s*,\\s*$bc)*+\\s*\\)?\\s*\$~", $Bd) && preg_match_all("~$bc~", $Bd, $Jd) ? "(" . implode(",", $Jd[0]) . ")" : preg_replace('~^[0-9].*~', '(\0)', preg_replace('~[^-0-9,+()[\]]~', '', $Bd)));
}function process_type($n, $Va = "COLLATE")
{
    global$hh;
    return" $n[type]" . process_length($n["length"]) . (preg_match(number_type(), $n["type"]) && in_array($n["unsigned"], $hh) ? " $n[unsigned]" : "") . (preg_match('~char|text|enum|set~', $n["type"]) && $n["collation"] ? " $Va " . q($n["collation"]) : "");
}function process_field($n, $Yg)
{
    return
    array(idf_escape(trim($n["field"])),process_type($Yg),($n["null"] ? " NULL" : " NOT NULL"),default_value($n),(preg_match('~timestamp|datetime~', $n["type"]) && $n["on_update"] ? " ON UPDATE $n[on_update]" : ""),(support("comment") && $n["comment"] != "" ? " COMMENT " . q($n["comment"]) : ""),($n["auto_increment"] ? auto_increment() : null),);
}function default_value($n)
{
    $zb = $n["default"];
    return($zb === null ? "" : " DEFAULT " . (preg_match('~char|binary|text|enum|set~', $n["type"]) || preg_match('~^(?![a-z])~i', $zb) ? q($zb) : $zb));
}function type_class($U)
{
    foreach (array('char' => 'text','date' => 'time|year','binary' => 'blob','enum' => 'set',) as $z => $X) {
        if (preg_match("~$z|$X~", $U)) {
            return" class='$z'";
        }
    }
}function edit_fields($o, $Xa, $U = "TABLE", $Bc = array())
{
    global$dd;
    $o = array_values($o);
    $_b = (($_POST ? $_POST["defaults"] : adminer_setting("defaults")) ? "" : " class='hidden'");
    $cb = (($_POST ? $_POST["comments"] : adminer_setting("comments")) ? "" : " class='hidden'");echo'<thead><tr>
';
    if ($U == "PROCEDURE") {
        echo'<td>';
    }echo'<th id="label-name">',($U == "TABLE" ? lang(98) : lang(99)),'<td id="label-type">',lang(38),'<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>',script("qs('#enum-edit').onblur = editingLengthBlur;"),'<td id="label-length">',lang(100),'<td>',lang(101);if ($U == "TABLE") {
        echo'<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym id="label-ai" title="',lang(40),'">AI</acronym>',doc_link(array('sql' => "example-auto-increment.html",'mariadb' => "auto_increment/",)),'<td id="label-default"',$_b,'>',lang(41),(support("comment") ? "<td id='label-comment'$cb>" . lang(39) : "");
    }echo'<td>',"<input type='image' class='icon' name='add[" . (support("move_col") ? 0 : count($o)) . "]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.8.1") . "' alt='+' title='" . lang(102) . "'>" . script("row_count = " . count($o) . ";"),'</thead>
<tbody>
',script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");foreach (
    $o as $t => $n
) {
        $t++;
        $Ce = $n[($_POST ? "orig" : "field")];
        $Hb = (isset($_POST["add"][$t - 1]) || (isset($n["field"]) && !$_POST["drop_col"][$t])) && (support("drop_col") || $Ce == "");echo'<tr',($Hb ? "" : " style='display: none;'"),'>
',($U == "PROCEDURE" ? "<td>" . html_select("fields[$t][inout]", explode("|", $dd), $n["inout"]) : ""),'<th>';
        if ($Hb) {
            echo'<input name="fields[',$t,'][field]" value="',h($n["field"]),'" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">';
        }echo'<input type="hidden" name="fields[',$t,'][orig]" value="',h($Ce),'">';
        edit_type("fields[$t]", $n, $Xa, $Bc);
        if ($U == "TABLE") {
            echo'<td>',checkbox("fields[$t][null]", 1, $n["null"], "", "", "block", "label-null"),'<td><label class="block"><input type="radio" name="auto_increment_col" value="',$t,'"';
            if ($n["auto_increment"]) {
                echo' checked';
            }echo' aria-labelledby="label-ai"></label><td',$_b,'>',checkbox("fields[$t][has_default]", 1, $n["has_default"], "", "", "", "label-default"),'<input name="fields[',$t,'][default]" value="',h($n["default"]),'" aria-labelledby="label-default">',(support("comment") ? "<td$cb><input name='fields[$t][comment]' value='" . h($n["comment"]) . "' data-maxlength='" . (min_version(5.5) ? 1024 : 255) . "' aria-labelledby='label-comment'>" : "");
        }echo"<td>",(support("move_col") ? "<input type='image' class='icon' name='add[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.8.1") . "' alt='+' title='" . lang(102) . "'> " . "<input type='image' class='icon' name='up[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=up.gif&version=4.8.1") . "' alt='â†‘' title='" . lang(103) . "'> " . "<input type='image' class='icon' name='down[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=down.gif&version=4.8.1") . "' alt='â†“' title='" . lang(104) . "'> " : ""),($Ce == "" || support("drop_col") ? "<input type='image' class='icon' name='drop_col[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=cross.gif&version=4.8.1") . "' alt='x' title='" . lang(105) . "'>" : "");
    }
}function process_fields(&$o)
{
    $ke = 0;
    if ($_POST["up"]) {
        $wd = 0;foreach (
            $o as $z => $n
        ) {
            if (key($_POST["up"]) == $z) {
                unset($o[$z]);
                array_splice($o, $wd, 0, array($n));
                break;
            }if (isset($n["field"])) {
                $wd = $ke;
            }$ke++;
        }
    } elseif ($_POST["down"]) {
        $Dc = false;foreach (
            $o as $z => $n
        ) {
            if (isset($n["field"]) && $Dc) {
                unset($o[key($_POST["down"])]);
                array_splice($o, $ke, 0, array($Dc));
                break;
            }if (key($_POST["down"]) == $z) {
                $Dc = $n;
            }$ke++;
        }
    } elseif ($_POST["add"]) {
        $o = array_values($o);
        array_splice($o, key($_POST["add"]), 0, array(array()));
    } elseif (!$_POST["drop_col"]) {
        return
        false;
    }return
        true;
}function normalize_enum($C)
{
    return"'" . str_replace("'", "''", addcslashes(stripcslashes(str_replace($C[0][0] . $C[0][0], $C[0][0], substr($C[0], 1, -1))), '\\')) . "'";
}function grant($Hc, $jf, $e, $qe)
{
    if (!$jf) {
        return
        true;
    }if ($jf == array("ALL PRIVILEGES","GRANT OPTION")) {
        return($Hc == "GRANT" ? queries("$Hc ALL PRIVILEGES$qe WITH GRANT OPTION") : queries("$Hc ALL PRIVILEGES$qe") && queries("$Hc GRANT OPTION$qe"));
    }return
    queries("$Hc " . preg_replace('~(GRANT OPTION)\([^)]*\)~', '\1', implode("$e, ", $jf) . $e) . $qe);
}function drop_create($Lb, $i, $Mb, $Dg, $Nb, $B, $Td, $Rd, $Sd, $ne, $ce)
{
    if ($_POST["drop"]) {
        query_redirect($Lb, $B, $Td);
    } elseif ($ne == "") {
        query_redirect($i, $B, $Sd);
    } elseif ($ne != $ce) {
        $mb = queries($i);
        queries_redirect($B, $Rd, $mb && queries($Lb));
        if ($mb) {
            queries($Mb);
        }
    } else {
        queries_redirect($B, $Rd, queries($Dg) && queries($Nb) && queries($Lb) && queries($i));
    }
}function create_trigger($qe, $L)
{
    global$y;
    $Ig = " $L[Timing] $L[Event]" . (preg_match('~ OF~', $L["Event"]) ? " $L[Of]" : "");
    return"CREATE TRIGGER " . idf_escape($L["Trigger"]) . ($y == "mssql" ? $qe . $Ig : $Ig . $qe) . rtrim(" $L[Type]\n$L[Statement]", ";") . ";";
}function create_routine($Ff, $L)
{
    global$dd,$y;
    $P = array();
    $o = (array)$L["fields"];
    ksort($o);foreach (
        $o as $n
    ) {
        if ($n["field"] != "") {
            $P[] = (preg_match("~^($dd)\$~", $n["inout"]) ? "$n[inout] " : "") . idf_escape($n["field"]) . process_type($n, "CHARACTER SET");
        }
    }$Ab = rtrim("\n$L[definition]", ";");
    return"CREATE $Ff " . idf_escape(trim($L["name"])) . " (" . implode(", ", $P) . ")" . (isset($_GET["function"]) ? " RETURNS" . process_type($L["returns"], "CHARACTER SET") : "") . ($L["language"] ? " LANGUAGE $L[language]" : "") . ($y == "pgsql" ? " AS " . q($Ab) : "$Ab;");
}function remove_definer($I)
{
    return
    preg_replace('~^([A-Z =]+) DEFINER=`' . preg_replace('~@(.*)~', '`@`(%|\1)', logged_user()) . '`~', '\1', $I);
}function format_foreign_key($p)
{
    global$re;
    $k = $p["db"];
    $ge = $p["ns"];
    return" FOREIGN KEY (" . implode(", ", array_map('idf_escape', $p["source"])) . ") REFERENCES " . ($k != "" && $k != $_GET["db"] ? idf_escape($k) . "." : "") . ($ge != "" && $ge != $_GET["ns"] ? idf_escape($ge) . "." : "") . table($p["table"]) . " (" . implode(", ", array_map('idf_escape', $p["target"])) . ")" . (preg_match("~^($re)\$~", $p["on_delete"]) ? " ON DELETE $p[on_delete]" : "") . (preg_match("~^($re)\$~", $p["on_update"]) ? " ON UPDATE $p[on_update]" : "");
}function tar_file($vc, $Ng)
{
    $K = pack("a100a8a8a8a12a12", $vc, 644, 0, 0, decoct($Ng->size), decoct(time()));
    $Pa = 8 * 32;for ($t = 0; $t < strlen($K); $t++) {
        $Pa += ord($K[$t]);
    }$K .= sprintf("%06o", $Pa) . "\0 ";
    echo$K,str_repeat("\0", 512 - strlen($K));
    $Ng->send();echo
    str_repeat("\0", 511 - ($Ng->size + 511) % 512);
}function ini_bytes($cd)
{
    $X = ini_get($cd);
    switch (strtolower(substr($X, -1))) {
        case 'g':
                                       $X *= 1024;
        case 'm':
                                       $X *= 1024;
        case 'k':
                                       $X *= 1024;
    }return$X;
}function doc_link($Te, $Eg = "<sup>?</sup>")
{
    global$y,$g;
    $Sf = $g->server_info;
    $uh = preg_replace('~^(\d\.?\d).*~s', '\1', $Sf);
    $lh = array('sql' => "https://dev.mysql.com/doc/refman/$uh/en/",'sqlite' => "https://www.sqlite.org/",'pgsql' => "https://www.postgresql.org/docs/$uh/",'mssql' => "https://msdn.microsoft.com/library/",'oracle' => "https://www.oracle.com/pls/topic/lookup?ctx=db" . preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s', '\1\2', $Sf) . "&id=",);
    if (preg_match('~MariaDB~', $Sf)) {
        $lh['sql'] = "https://mariadb.com/kb/en/library/";
        $Te['sql'] = (isset($Te['mariadb']) ? $Te['mariadb'] : str_replace(".html", "/", $Te['sql']));
    }return($Te[$y] ? "<a href='" . h($lh[$y] . $Te[$y]) . "'" . target_blank() . ">$Eg</a>" : "");
}function ob_gzencode($lg)
{
    return
    gzencode($lg);
}function db_size($k)
{
    global$g;
    if (!$g->select_db($k)) {
        return"?";
    }$K = 0;
    foreach (table_status() as $R) {
        $K += $R["Data_length"] + $R["Index_length"];
    }return
    format_number($K);
}function set_utf8mb4($i)
{
    global$g;
    static $P = false;
    if (!$P && preg_match('~\butf8mb4~i', $i)) {
        $P = true;
        echo"SET NAMES " . charset($g) . ";\n\n";
    }
}function connect_error()
{
    global$c,$g,$T,$m,$Kb;
    if (DB != "") {
        header("HTTP/1.1 404 Not Found");
        page_header(lang(26) . ": " . h(DB), lang(106), true);
    } else {
        if ($_POST["db"] && !$m) {
            queries_redirect(substr(ME, 0, -1), lang(107), drop_databases($_POST["db"]));
        }page_header(lang(108), $m, false);
        echo"<p class='links'>\n";
        foreach (array('database' => lang(109),'privileges' => lang(60),'processlist' => lang(110),'variables' => lang(111),'status' => lang(112),) as $z => $X) {
            if (support($z)) {
                echo"<a href='" . h(ME) . "$z='>$X</a>\n";
            }
        }echo"<p>" . lang(113, $Kb[DRIVER], "<b>" . h($g->server_info) . "</b>", "<b>$g->extension</b>") . "\n","<p>" . lang(114, "<b>" . h(logged_user()) . "</b>") . "\n";
        $j = $c->databases();
        if ($j) {
            $Lf = support("scheme");
            $Xa = collations();
            echo"<form action='' method='post'>\n","<table cellspacing='0' class='checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),"<thead><tr>" . (support("database") ? "<td>" : "") . "<th>" . lang(26) . " - <a href='" . h(ME) . "refresh=1'>" . lang(115) . "</a>" . "<td>" . lang(116) . "<td>" . lang(117) . "<td>" . lang(118) . " - <a href='" . h(ME) . "dbsize=1'>" . lang(119) . "</a>" . script("qsl('a').onclick = partial(ajaxSetHtml, '" . js_escape(ME) . "script=connect');", "") . "</thead>\n";
            $j = ($_GET["dbsize"] ? count_tables($j) : array_flip($j));foreach (
                $j as $k => $S
            ) {
                $Ef = h(ME) . "db=" . urlencode($k);
                $u = h("Db-" . $k);
                echo"<tr" . odd() . ">" . (support("database") ? "<td>" . checkbox("db[]", $k, in_array($k, (array)$_POST["db"]), "", "", "", $u) : ""),"<th><a href='$Ef' id='$u'>" . h($k) . "</a>";
                $Wa = h(db_collation($k, $Xa));
                echo"<td>" . (support("database") ? "<a href='$Ef" . ($Lf ? "&amp;ns=" : "") . "&amp;database=' title='" . lang(56) . "'>$Wa</a>" : $Wa),"<td align='right'><a href='$Ef&amp;schema=' id='tables-" . h($k) . "' title='" . lang(59) . "'>" . ($_GET["dbsize"] ? $S : "?") . "</a>","<td align='right' id='size-" . h($k) . "'>" . ($_GET["dbsize"] ? db_size($k) : "?"),"\n";
            }echo"</table>\n",(support("database") ? "<div class='footer'><div>\n" . "<fieldset><legend>" . lang(120) . " <span id='selected'></span></legend><div>\n" . "<input type='hidden' name='all' value=''>" . script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };") . "<input type='submit' name='drop' value='" . lang(121) . "'>" . confirm() . "\n" . "</div></fieldset>\n" . "</div></div>\n" : ""),"<input type='hidden' name='token' value='$T'>\n","</form>\n",script("tableCheck();");
        }
    }page_footer("db");
}if (isset($_GET["status"])) {
    $_GET["variables"] = $_GET["status"];
}if (isset($_GET["import"])) {
    $_GET["sql"] = $_GET["import"];
}if (!(DB != "" ? $g->select_db(DB) : isset($_GET["sql"]) || isset($_GET["dump"]) || isset($_GET["database"]) || isset($_GET["processlist"]) || isset($_GET["privileges"]) || isset($_GET["user"]) || isset($_GET["variables"]) || $_GET["script"] == "connect" || $_GET["script"] == "kill")) {
    if (DB != "" || $_GET["refresh"]) {
        restart_session();
        set_session("dbs", null);
    }connect_error();
    exit;
}$re = "RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";class TmpFile
{
    var$handler;
    var$size;
    function __construct()
    {
        $this->handler = tmpfile();
    }function write($hb)
    {
        $this->size += strlen($hb);
        fwrite($this->handler, $hb);
    }function send()
    {
        fseek($this->handler, 0);
        fpassthru($this->handler);
        fclose($this->handler);
    }
}$bc = "'(?:''|[^'\\\\]|\\\\.)*'";
$dd = "IN|OUT|INOUT";
if (isset($_GET["select"]) && ($_POST["edit"] || $_POST["clone"]) && !$_POST["save"]) {
    $_GET["edit"] = $_GET["select"];
}if (isset($_GET["callf"])) {
    $_GET["call"] = $_GET["callf"];
}if (isset($_GET["function"])) {
    $_GET["procedure"] = $_GET["function"];
}if (isset($_GET["download"])) {
    $b = $_GET["download"];
    $o = fields($b);
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . friendly_url("$b-" . implode("_", $_GET["where"])) . "." . friendly_url($_GET["field"]));
    $N = array(idf_escape($_GET["field"]));
    $J = $l->select($b, $N, array(where($_GET, $o)), $N);
    $L = ($J ? $J->fetch_row() : array());
    echo$l->value($L[0], $o[$_GET["field"]]);
    exit;
} elseif (isset($_GET["table"])) {
    $b = $_GET["table"];
    $o = fields($b);
    if (!$o) {
        $m = error();
    }$R = table_status1($b, true);
    $E = $c->tableName($R);
    page_header(($o && is_view($R) ? $R['Engine'] == 'materialized view' ? lang(122) : lang(123) : lang(124)) . ": " . ($E != "" ? $E : h($b)), $m);
    $c->selectLinks($R);
    $bb = $R["Comment"];
    if ($bb != "") {
        echo"<p class='nowrap'>" . lang(39) . ": " . h($bb) . "\n";
    }if ($o) {
        $c->tableStructurePrint($o);
    }if (!is_view($R)) {
        if (support("indexes")) {
            echo"<h3 id='indexes'>" . lang(125) . "</h3>\n";
            $x = indexes($b);
            if ($x) {
                $c->tableIndexesPrint($x);
            }echo'<p class="links"><a href="' . h(ME) . 'indexes=' . urlencode($b) . '">' . lang(126) . "</a>\n";
        }if (fk_support($R)) {
            echo"<h3 id='foreign-keys'>" . lang(94) . "</h3>\n";
            $Bc = foreign_keys($b);
            if ($Bc) {
                echo"<table cellspacing='0'>\n","<thead><tr><th>" . lang(127) . "<td>" . lang(128) . "<td>" . lang(97) . "<td>" . lang(96) . "<td></thead>\n";foreach (
                    $Bc as $E => $p
                ) {
                    echo"<tr title='" . h($E) . "'>","<th><i>" . implode("</i>, <i>", array_map('h', $p["source"])) . "</i>","<td><a href='" . h($p["db"] != "" ? preg_replace('~db=[^&]*~', "db=" . urlencode($p["db"]), ME) : ($p["ns"] != "" ? preg_replace('~ns=[^&]*~', "ns=" . urlencode($p["ns"]), ME) : ME)) . "table=" . urlencode($p["table"]) . "'>" . ($p["db"] != "" ? "<b>" . h($p["db"]) . "</b>." : "") . ($p["ns"] != "" ? "<b>" . h($p["ns"]) . "</b>." : "") . h($p["table"]) . "</a>","(<i>" . implode("</i>, <i>", array_map('h', $p["target"])) . "</i>)","<td>" . h($p["on_delete"]) . "\n","<td>" . h($p["on_update"]) . "\n",'<td><a href="' . h(ME . 'foreign=' . urlencode($b) . '&name=' . urlencode($E)) . '">' . lang(129) . '</a>';
                }echo"</table>\n";
            }echo'<p class="links"><a href="' . h(ME) . 'foreign=' . urlencode($b) . '">' . lang(130) . "</a>\n";
        }
    }if (support(is_view($R) ? "view_trigger" : "trigger")) {
        echo"<h3 id='triggers'>" . lang(131) . "</h3>\n";
        $Xg = triggers($b);
        if ($Xg) {
            echo"<table cellspacing='0'>\n";foreach (
                $Xg as $z => $X
            ) {
                echo"<tr valign='top'><td>" . h($X[0]) . "<td>" . h($X[1]) . "<th>" . h($z) . "<td><a href='" . h(ME . 'trigger=' . urlencode($b) . '&name=' . urlencode($z)) . "'>" . lang(129) . "</a>\n";
            }
            echo"</table>\n";
        }echo'<p class="links"><a href="' . h(ME) . 'trigger=' . urlencode($b) . '">' . lang(132) . "</a>\n";
    }
} elseif (isset($_GET["schema"])) {
    page_header(lang(59), "", array(), h(DB . ($_GET["ns"] ? ".$_GET[ns]" : "")));
    $vg = array();
    $wg = array();
    $da = ($_GET["schema"] ? $_GET["schema"] : $_COOKIE["adminer_schema-" . str_replace(".", "_", DB)]);
    preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~', $da, $Jd, PREG_SET_ORDER);foreach (
        $Jd as $t => $C
    ) {
        $vg[$C[1]] = array($C[2],$C[3]);
        $wg[] = "\n\t'" . js_escape($C[1]) . "': [ $C[2], $C[3] ]";
    }$Pg = 0;
    $Ca = -1;
    $Kf = array();
    $wf = array();
    $_d = array();
    foreach (table_status('', true) as $Q => $R) {
        if (is_view($R)) {
            continue;
        }$Ze = 0;
        $Kf[$Q]["fields"] = array();
        foreach (fields($Q) as $E => $n) {
            $Ze += 1.25;
            $n["pos"] = $Ze;
            $Kf[$Q]["fields"][$E] = $n;
        }$Kf[$Q]["pos"] = ($vg[$Q] ? $vg[$Q] : array($Pg,0));
        foreach ($c->foreignKeys($Q) as $X) {
            if (!$X["db"]) {
                $yd = $Ca;
                if ($vg[$Q][1] || $vg[$X["table"]][1]) {
                    $yd = min(floatval($vg[$Q][1]), floatval($vg[$X["table"]][1])) - 1;
                } else {
                    $Ca -= .1;
                }
                while ($_d[(string)$yd]) {
                    $yd -= .0001;
                }$Kf[$Q]["references"][$X["table"]][(string)$yd] = array($X["source"],$X["target"]);
                $wf[$X["table"]][$Q][(string)$yd] = $X["target"];
                $_d[(string)$yd] = true;
            }
        }$Pg = max($Pg, $Kf[$Q]["pos"][0] + 2.5 + $Ze);
    }echo'<div id="schema" style="height: ',$Pg,'em;">
<script',nonce(),'>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {',implode(",", $wg) . "\n",'};
var em = qs(\'#schema\').offsetHeight / ',$Pg,';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'',js_escape(DB),'\');
</script>
';foreach (
    $Kf as $E => $Q
) {
        echo"<div class='table' style='top: " . $Q["pos"][0] . "em; left: " . $Q["pos"][1] . "em;'>",'<a href="' . h(ME) . 'table=' . urlencode($E) . '"><b>' . h($E) . "</b></a>",script("qsl('div').onmousedown = schemaMousedown;");
        foreach ($Q["fields"] as $n) {
            $X = '<span' . type_class($n["type"]) . ' title="' . h($n["full_type"] . ($n["null"] ? " NULL" : '')) . '">' . h($n["field"]) . '</span>';
            echo"<br>" . ($n["primary"] ? "<i>$X</i>" : $X);
        }foreach ((array)$Q["references"] as $Bg => $xf) {
            foreach (
                $xf as $yd => $tf
            ) {
                $zd = $yd - $vg[$E][1];
                $t = 0;
                foreach ($tf[0] as $bg) {
                    echo"\n<div class='references' title='" . h($Bg) . "' id='refs$yd-" . ($t++) . "' style='left: $zd" . "em; top: " . $Q["fields"][$bg]["pos"] . "em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: " . (-$zd) . "em;'></div></div>";
                }
            }
        }foreach ((array)$wf[$E] as $Bg => $xf) {
            foreach (
                $xf as $yd => $e
            ) {
                $zd = $yd - $vg[$E][1];
                $t = 0;foreach (
                    $e as $Ag
                ) {
                    echo"\n<div class='references' title='" . h($Bg) . "' id='refd$yd-" . ($t++) . "' style='left: $zd" . "em; top: " . $Q["fields"][$Ag]["pos"] . "em; height: 1.25em; background: url(" . h(preg_replace("~\\?.*~", "", ME) . "?file=arrow.gif) no-repeat right center;&version=4.8.1") . "'><div style='height: .5em; border-bottom: 1px solid Gray; width: " . (-$zd) . "em;'></div></div>";
                }
            }
        }echo"\n</div>\n";
    }foreach (
        $Kf as $E => $Q
    ) {
        foreach ((array)$Q["references"] as $Bg => $xf) {
            foreach (
                $xf as $yd => $tf
            ) {
                $Vd = $Pg;
                $Nd = -10;
                foreach ($tf[0] as $z => $bg) {
                    $af = $Q["pos"][0] + $Q["fields"][$bg]["pos"];
                    $bf = $Kf[$Bg]["pos"][0] + $Kf[$Bg]["fields"][$tf[1][$z]]["pos"];
                    $Vd = min($Vd, $af, $bf);
                    $Nd = max($Nd, $af, $bf);
                }echo"<div class='references' id='refl$yd' style='left: $yd" . "em; top: $Vd" . "em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: " . ($Nd - $Vd) . "em;'></div></div>\n";
            }
        }
    }echo'</div>
<p class="links"><a href="',h(ME . "schema=" . urlencode($da)),'" id="schema-link">',lang(133),'</a>
';
} elseif (isset($_GET["dump"])) {
    $b = $_GET["dump"];
    if ($_POST && !$m) {
        $kb = "";
        foreach (array("output","format","db_style","routines","events","table_style","auto_increment","triggers","data_style") as $z) {
            $kb .= "&$z=" . urlencode($_POST[$z]);
        }cookie("adminer_export", substr($kb, 1));
        $S = array_flip((array)$_POST["tables"]) + array_flip((array)$_POST["data"]);
        $nc = dump_headers((count($S) == 1 ? key($S) : DB), (DB == "" || count($S) > 1));
        $ld = preg_match('~sql~', $_POST["format"]);
        if ($ld) {
            echo"-- Adminer $fa " . $Kb[DRIVER] . " " . str_replace("\n", " ", $g->server_info) . " dump\n\n";if ($y == "sql") {
                echo"SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
" . ($_POST["data_style"] ? "SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
" : "") . "
";
                $g->query("SET time_zone = '+00:00'");
                $g->query("SET sql_mode = ''");
            }
        }$ng = $_POST["db_style"];
        $j = array(DB);
        if (DB == "") {
            $j = $_POST["databases"];
            if (is_string($j)) {
                $j = explode("\n", rtrim(str_replace("\r", "", $j), "\n"));
            }
        }foreach (
            (array)$j as $k
        ) {
            $c->dumpDatabase($k);
            if ($g->select_db($k)) {
                if ($ld && preg_match('~CREATE~', $ng) && ($i = $g->result("SHOW CREATE DATABASE " . idf_escape($k), 1))) {
                    set_utf8mb4($i);
                    if ($ng == "DROP+CREATE") {
                        echo"DROP DATABASE IF EXISTS " . idf_escape($k) . ";\n";
                    }echo"$i;\n";
                }if ($ld) {
                    if ($ng) {
                        echo
                        use_sql($k) . ";\n\n";
                    }$He = "";
                    if ($_POST["routines"]) {
                        foreach (array("FUNCTION","PROCEDURE") as $Ff) {
                            foreach (get_rows("SHOW $Ff STATUS WHERE Db = " . q($k), null, "-- ") as $L) {
                                $i = remove_definer($g->result("SHOW CREATE $Ff " . idf_escape($L["Name"]), 2));
                                set_utf8mb4($i);
                                $He .= ($ng != 'DROP+CREATE' ? "DROP $Ff IF EXISTS " . idf_escape($L["Name"]) . ";;\n" : "") . "$i;;\n\n";
                            }
                        }
                    }if ($_POST["events"]) {
                        foreach (get_rows("SHOW EVENTS", null, "-- ") as $L) {
                            $i = remove_definer($g->result("SHOW CREATE EVENT " . idf_escape($L["Name"]), 3));
                            set_utf8mb4($i);
                            $He .= ($ng != 'DROP+CREATE' ? "DROP EVENT IF EXISTS " . idf_escape($L["Name"]) . ";;\n" : "") . "$i;;\n\n";
                        }
                    }if ($He) {
                        echo"DELIMITER ;;\n\n$He" . "DELIMITER ;\n\n";
                    }
                }if ($_POST["table_style"] || $_POST["data_style"]) {
                    $wh = array();
                    foreach (table_status('', true) as $E => $R) {
                        $Q = (DB == "" || in_array($E, (array)$_POST["tables"]));
                        $sb = (DB == "" || in_array($E, (array)$_POST["data"]));if ($Q || $sb) {
                            if ($nc == "tar") {
                                $Ng = new
                                TmpFile();
                                ob_start(array($Ng,'write'), 1e5);
                            }$c->dumpTable($E, ($Q ? $_POST["table_style"] : ""), (is_view($R) ? 2 : 0));
                            if (is_view($R)) {
                                $wh[] = $E;
                            } elseif ($sb) {
                                $o = fields($E);
                                $c->dumpData($E, $_POST["data_style"], "SELECT *" . convert_fields($o, $o) . " FROM " . table($E));
                            }if ($ld && $_POST["triggers"] && $Q && ($Xg = trigger_sql($E))) {
                                echo"\nDELIMITER ;;\n$Xg\nDELIMITER ;\n";
                            }if ($nc == "tar") {
                                ob_end_flush();
                                tar_file((DB != "" ? "" : "$k/") . "$E.csv", $Ng);
                            } elseif ($ld) {
                                echo"\n";
                            }
                        }
                    }if (function_exists('foreign_keys_sql')) {
                        foreach (table_status('', true) as $E => $R) {
                            $Q = (DB == "" || in_array($E, (array)$_POST["tables"]));if ($Q && !is_view($R)) {
                                echo
                                foreign_keys_sql($E);
                            }
                        }
                    }foreach (
                        $wh as $vh
                    ) {
                        $c->dumpTable($vh, $_POST["table_style"], 1);
                    }if ($nc == "tar") {
                        echo
                        pack("x512");
                    }
                }
            }
        }if ($ld) {
            echo"-- " . $g->result("SELECT NOW()") . "\n";
        }exit;
    }page_header(lang(62), $m, ($_GET["export"] != "" ? array("table" => $_GET["export"]) : array()), h(DB));echo'
<form action="" method="post">
<table cellspacing="0" class="layout">
';
    $wb = array('','USE','DROP+CREATE','CREATE');
    $xg = array('','DROP+CREATE','CREATE');
    $tb = array('','TRUNCATE+INSERT','INSERT');
    if ($y == "sql") {
        $tb[] = 'INSERT+UPDATE';
    }parse_str($_COOKIE["adminer_export"], $L);
    if (!$L) {
        $L = array("output" => "text","format" => "sql","db_style" => (DB != "" ? "" : "CREATE"),"table_style" => "DROP+CREATE","data_style" => "INSERT");
    }if (!isset($L["events"])) {
        $L["routines"] = $L["events"] = ($_GET["dump"] == "");
        $L["triggers"] = $L["table_style"];
    }echo"<tr><th>" . lang(134) . "<td>" . html_select("output", $c->dumpOutput(), $L["output"], 0) . "\n";
    echo"<tr><th>" . lang(135) . "<td>" . html_select("format", $c->dumpFormat(), $L["format"], 0) . "\n";echo($y == "sqlite" ? "" : "<tr><th>" . lang(26) . "<td>" . html_select('db_style', $wb, $L["db_style"]) . (support("routine") ? checkbox("routines", 1, $L["routines"], lang(136)) : "") . (support("event") ? checkbox("events", 1, $L["events"], lang(137)) : "")),"<tr><th>" . lang(117) . "<td>" . html_select('table_style', $xg, $L["table_style"]) . checkbox("auto_increment", 1, $L["auto_increment"], lang(40)) . (support("trigger") ? checkbox("triggers", 1, $L["triggers"], lang(131)) : ""),"<tr><th>" . lang(138) . "<td>" . html_select('data_style', $tb, $L["data_style"]),'</table>
<p><input type="submit" value="',lang(62),'">
<input type="hidden" name="token" value="',$T,'">

<table cellspacing="0">
',script("qsl('table').onclick = dumpClick;");
    $ef = array();
    if (DB != "") {
        $Na = ($b != "" ? "" : " checked");
        echo"<thead><tr>","<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$Na>" . lang(117) . "</label>" . script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);", ""),"<th style='text-align: right;'><label class='block'>" . lang(138) . "<input type='checkbox' id='check-data'$Na></label>" . script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);", ""),"</thead>\n";
        $wh = "";
        $yg = tables_list();foreach (
            $yg as $E => $U
        ) {
            $df = preg_replace('~_.*~', '', $E);
            $Na = ($b == "" || $b == (substr($b, -1) == "%" ? "$df%" : $E));
            $gf = "<tr><td>" . checkbox("tables[]", $E, $Na, $E, "", "block");
            if ($U !== null && !preg_match('~table~i', $U)) {
                $wh .= "$gf\n";
            } else {
                echo"$gf<td align='right'><label class='block'><span id='Rows-" . h($E) . "'></span>" . checkbox("data[]", $E, $Na) . "</label>\n";
            }
            $ef[$df]++;
        }echo$wh;if ($yg) {
            echo
            script("ajaxSetHtml('" . js_escape(ME) . "script=db');");
        }
    } else {
        echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'" . ($b == "" ? " checked" : "") . ">" . lang(26) . "</label>",script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);", ""),"</thead>\n";
        $j = $c->databases();if ($j) {
            foreach (
                $j as $k
            ) {
                if (!information_schema($k)) {
                    $df = preg_replace('~_.*~', '', $k);
                    echo"<tr><td>" . checkbox("databases[]", $k, $b == "" || $b == "$df%", $k, "", "block") . "\n";
                    $ef[$df]++;
                }
            }
        } else {
            echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";
        }
    }echo'</table>
</form>
';
    $xc = true;foreach (
        $ef as $z => $X
    ) {
        if ($z != "" && $X > 1) {
            echo($xc ? "<p>" : " ") . "<a href='" . h(ME) . "dump=" . urlencode("$z%") . "'>" . h($z) . "</a>";
            $xc = false;
        }
    }
} elseif (isset($_GET["privileges"])) {
    page_header(lang(60));
    echo'<p class="links"><a href="' . h(ME) . 'user=">' . lang(139) . "</a>";
    $J = $g->query("SELECT User, Host FROM mysql." . (DB == "" ? "user" : "db WHERE " . q(DB) . " LIKE Db") . " ORDER BY Host, User");
    $Hc = $J;
    if (!$J) {
        $J = $g->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");
    }echo"<form action=''><p>\n";
    hidden_fields_get();
    echo"<input type='hidden' name='db' value='" . h(DB) . "'>\n",($Hc ? "" : "<input type='hidden' name='grant' value=''>\n"),"<table cellspacing='0'>\n","<thead><tr><th>" . lang(24) . "<th>" . lang(23) . "<th></thead>\n";
    while ($L = $J->fetch_assoc()) {
        echo'<tr' . odd() . '><td>' . h($L["User"]) . "<td>" . h($L["Host"]) . '<td><a href="' . h(ME . 'user=' . urlencode($L["User"]) . '&host=' . urlencode($L["Host"])) . '">' . lang(10) . "</a>\n";
    }if (!$Hc || DB != "") {
        echo"<tr" . odd() . "><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='" . lang(10) . "'>\n";
    }echo"</table>\n","</form>\n";
} elseif (isset($_GET["sql"])) {
    if (!$m && $_POST["export"]) {
        dump_headers("sql");
        $c->dumpTable("", "");
        $c->dumpData("", "table", $_POST["query"]);
        exit;
    }restart_session();
    $Uc=&get_session("queries");
    $Tc=&$Uc[DB];
    if (!$m && $_POST["clear"]) {
        $Tc = array();
        redirect(remove_from_uri("history"));
    }page_header((isset($_GET["import"]) ? lang(61) : lang(53)), $m);
    if (!$m && $_POST) {
        $q = false;
        if (!isset($_GET["import"])) {
            $I = $_POST["query"];
        } elseif ($_POST["webfile"]) {
            $eg = $c->importServerPath();
            $q = @fopen((file_exists($eg) ? $eg : "compress.zlib://$eg.gz"), "rb");
            $I = ($q ? fread($q, 1e6) : false);
        } else {
            $I = get_file("sql_file", true);
        }
        if (is_string($I)) {
            if (function_exists('memory_get_usage')) {
                @ini_set("memory_limit", max(ini_bytes("memory_limit"), 2 * strlen($I) + memory_get_usage() + 8e6));
            }if ($I != "" && strlen($I) < 1e6) {
                $H = $I . (preg_match("~;[ \t\r\n]*\$~", $I) ? "" : ";");
                if (!$Tc || reset(end($Tc)) != $H) {
                    restart_session();
                    $Tc[] = array($H,time());
                    set_session("queries", $Uc);
                    stop_session();
                }
            }$cg = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
            $Cb = ";";
            $ke = 0;
            $Yb = true;
            $h = connect();
            if (is_object($h) && DB != "") {
                $h->select_db(DB);
                if ($_GET["ns"] != "") {
                    set_schema($_GET["ns"], $h);
                }
            }$ab = 0;
            $dc = array();
            $Ne = '[\'"' . ($y == "sql" ? '`#' : ($y == "sqlite" ? '`[' : ($y == "mssql" ? '[' : ''))) . ']|/\*|-- |$' . ($y == "pgsql" ? '|\$[^$]*\$' : '');
            $Qg = microtime(true);
            parse_str($_COOKIE["adminer_export"], $la);
            $Pb = $c->dumpFormat();
            unset($Pb["sql"]);
            while ($I != "") {
                if (!$ke && preg_match("~^$cg*+DELIMITER\\s+(\\S+)~i", $I, $C)) {
                    $Cb = $C[1];
                    $I = substr($I, strlen($C[0]));
                } else {
                    preg_match('(' . preg_quote($Cb) . "\\s*|$Ne)", $I, $C, PREG_OFFSET_CAPTURE, $ke);
                    list($Dc,$Ze) = $C[0];
                    if (!$Dc && $q && !feof($q)) {
                        $I .= fread($q, 1e5);
                    } else {
                        if (!$Dc && rtrim($I) == "") {
                            break;
                        }$ke = $Ze + strlen($Dc);
                        if ($Dc && rtrim($Dc) != $Cb) {
                            while (preg_match('(' . ($Dc == '/*' ? '\*/' : ($Dc == '[' ? ']' : (preg_match('~^-- |^#~', $Dc) ? "\n" : preg_quote($Dc) . "|\\\\."))) . '|$)s', $I, $C, PREG_OFFSET_CAPTURE, $ke)) {
                                $If = $C[0][0];
                                if (!$If && $q && !feof($q)) {
                                        $I .= fread($q, 1e5);
                                } else {
                                    $ke = $C[0][1] + strlen($If);
                                    if ($If[0] != "\\") {
                                        break;
                                    }
                                }
                            }
                        } else {
                            $Yb = false;
                            $H = substr($I, 0, $Ze);
                            $ab++;
                            $gf = "<pre id='sql-$ab'><code class='jush-$y'>" . $c->sqlCommandQuery($H) . "</code></pre>\n";
                            if ($y == "sqlite" && preg_match("~^$cg*+ATTACH\\b~i", $H, $C)) {
                                echo$gf,"<p class='error'>" . lang(140) . "\n";
                                $dc[] = " <a href='#sql-$ab'>$ab</a>";
                                if ($_POST["error_stops"]) {
                                        break;
                                }
                            } else {
                                if (!$_POST["only_errors"]) {
                                    echo$gf;
                                    ob_flush();
                                    flush();
                                }$hg = microtime(true);
                                if ($g->multi_query($H) && is_object($h) && preg_match("~^$cg*+USE\\b~i", $H)) {
                                    $h->query($H);
                                }do {
                                    $J = $g->store_result();
                                    if ($g->error) {
                                        echo($_POST["only_errors"] ? $gf : ""),"<p class='error'>" . lang(141) . ($g->errno ? " ($g->errno)" : "") . ": " . error() . "\n";
                                        $dc[] = " <a href='#sql-$ab'>$ab</a>";if ($_POST["error_stops"]) {
                                                break
                                            2;
                                        }
                                    } else {
                                        $Gg = " <span class='time'>(" . format_time($hg) . ")</span>" . (strlen($H) < 1000 ? " <a href='" . h(ME) . "sql=" . urlencode(trim($H)) . "'>" . lang(10) . "</a>" : "");
                                        $na = $g->affected_rows;
                                        $zh = ($_POST["only_errors"] ? "" : $l->warnings());
                                        $_h = "warnings-$ab";
                                        if ($zh) {
                                            $Gg .= ", <a href='#$_h'>" . lang(35) . "</a>" . script("qsl('a').onclick = partial(toggle, '$_h');", "");
                                        }$lc = null;
                                        $mc = "explain-$ab";
                                        if (is_object($J)) {
                                            $_ = $_POST["limit"];
                                            $Be = select($J, $h, array(), $_);
                                            if (!$_POST["only_errors"]) {
                                                echo"<form action='' method='post'>\n";
                                                $he = $J->num_rows;
                                                echo"<p>" . ($he ? ($_ && $he > $_ ? lang(142, $_) : "") . lang(143, $he) : ""),$Gg;
                                                if ($h && preg_match("~^($cg|\\()*+SELECT\\b~i", $H) && ($lc = explain($h, $H))) {
                                                        echo", <a href='#$mc'>Explain</a>" . script("qsl('a').onclick = partial(toggle, '$mc');", "");
                                                }$u = "export-$ab";
                                                echo", <a href='#$u'>" . lang(62) . "</a>" . script("qsl('a').onclick = partial(toggle, '$u');", "") . "<span id='$u' class='hidden'>: " . html_select("output", $c->dumpOutput(), $la["output"]) . " " . html_select("format", $Pb, $la["format"]) . "<input type='hidden' name='query' value='" . h($H) . "'>" . " <input type='submit' name='export' value='" . lang(62) . "'><input type='hidden' name='token' value='$T'></span>\n" . "</form>\n";
                                            }
                                        } else {
                                            if (preg_match("~^$cg*+(CREATE|DROP|ALTER)$cg++(DATABASE|SCHEMA)\\b~i", $H)) {
                                                restart_session();
                                                set_session("dbs", null);
                                                stop_session();
                                            }if (!$_POST["only_errors"]) {
                                                echo"<p class='message' title='" . h($g->info) . "'>" . lang(144, $na) . "$Gg\n";
                                            }
                                        }echo($zh ? "<div id='$_h' class='hidden'>\n$zh</div>\n" : "");
                                        if ($lc) {
                                            echo"<div id='$mc' class='hidden'>\n";
                                            select($lc, $h, $Be);
                                            echo"</div>\n";
                                        }
                                    }$hg = microtime(true);
                                } while ($g->next_result());
                            }$I = substr($I, $ke);
                            $ke = 0;
                        }
                    }
                }
            }if ($Yb) {
                echo"<p class='message'>" . lang(145) . "\n";
            } elseif ($_POST["only_errors"]) {
                echo"<p class='message'>" . lang(146, $ab - count($dc))," <span class='time'>(" . format_time($Qg) . ")</span>\n";
            } elseif ($dc && $ab > 1) {
                echo"<p class='error'>" . lang(141) . ": " . implode("", $dc) . "\n";
            }
        } else {
            echo"<p class='error'>" . upload_error($I) . "\n";
        }
    }echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';
    $jc = "<input type='submit' value='" . lang(147) . "' title='Ctrl+Enter'>";
    if (!isset($_GET["import"])) {
        $H = $_GET["sql"];
        if ($_POST) {
            $H = $_POST["query"];
        } elseif ($_GET["history"] == "all") {
            $H = $Tc;
        } elseif ($_GET["history"] != "") {
            $H = $Tc[$_GET["history"]][0];
        }echo"<p>";
        textarea("query", $H, 20);echo
                script(($_POST ? "" : "qs('textarea').focus();\n") . "qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '" . js_escape(remove_from_uri("sql|limit|error_stops|only_errors|history")) . "');"),"<p>$jc\n",lang(148) . ": <input type='number' name='limit' class='size' value='" . h($_POST ? $_POST["limit"] : $_GET["limit"]) . "'>\n";
    } else {
        echo"<fieldset><legend>" . lang(149) . "</legend><div>";
        $Mc = (extension_loaded("zlib") ? "[.gz]" : "");
        echo(ini_bool("file_uploads") ? "SQL$Mc (&lt; " . ini_get("upload_max_filesize") . "B): <input type='file' name='sql_file[]' multiple>\n$jc" : lang(150)),"</div></fieldset>\n";
        $Zc = $c->importServerPath();
        if ($Zc) {
            echo"<fieldset><legend>" . lang(151) . "</legend><div>",lang(152, "<code>" . h($Zc) . "$Mc</code>"),' <input type="submit" name="webfile" value="' . lang(153) . '">',"</div></fieldset>\n";
        }echo"<p>";
    }echo
            checkbox("error_stops", 1, ($_POST ? $_POST["error_stops"] : isset($_GET["import"]) || $_GET["error_stops"]), lang(154)) . "\n",checkbox("only_errors", 1, ($_POST ? $_POST["only_errors"] : isset($_GET["import"]) || $_GET["only_errors"]), lang(155)) . "\n","<input type='hidden' name='token' value='$T'>\n";
    if (!isset($_GET["import"]) && $Tc) {
        print_fieldset("history", lang(156), $_GET["history"] != "");for ($X = end($Tc); $X; $X = prev($Tc)) {
            $z = key($Tc);
            list($H,$Gg,$Tb) = $X;
            echo'<a href="' . h(ME . "sql=&history=$z") . '">' . lang(10) . "</a>" . " <span class='time' title='" . @date('Y-m-d', $Gg) . "'>" . @date("H:i:s", $Gg) . "</span>" . " <code class='jush-$y'>" . shorten_utf8(ltrim(str_replace("\n", " ", str_replace("\r", "", preg_replace('~^(#|-- ).*~m', '', $H)))), 80, "</code>") . ($Tb ? " <span class='time'>($Tb)</span>" : "") . "<br>\n";
        }echo"<input type='submit' name='clear' value='" . lang(157) . "'>\n","<a href='" . h(ME . "sql=&history=all") . "'>" . lang(158) . "</a>\n","</div></fieldset>\n";
    }echo'</form>
';
} elseif (isset($_GET["edit"])) {
    $b = $_GET["edit"];
    $o = fields($b);
    $Z = (isset($_GET["select"]) ? ($_POST["check"] && count($_POST["check"]) == 1 ? where_check($_POST["check"][0], $o) : "") : where($_GET, $o));
    $ih = (isset($_GET["select"]) ? $_POST["edit"] : $Z);foreach (
        $o as $E => $n
    ) {
        if (!isset($n["privileges"][$ih ? "update" : "insert"]) || $c->fieldName($n) == "" || $n["generated"]) {
            unset($o[$E]);
        }
    }if ($_POST && !$m && !isset($_GET["select"])) {
        $B = $_POST["referer"];
        if ($_POST["insert"]) {
            $B = ($ih ? null : $_SERVER["REQUEST_URI"]);
        } elseif (!preg_match('~^.+&select=.+$~', $B)) {
            $B = ME . "select=" . urlencode($b);
        }$x = indexes($b);
        $dh = unique_array($_GET["where"], $x);
        $pf = "\nWHERE $Z";
        if (isset($_POST["delete"])) {
            queries_redirect($B, lang(159), $l->delete($b, $pf, !$dh));
        } else {
            $P = array();foreach (
                $o as $E => $n
            ) {
                $X = process_input($n);
                if ($X !== false && $X !== null) {
                    $P[idf_escape($E)] = $X;
                }
            }if ($ih) {
                if (!$P) {
                    redirect($B);
                }queries_redirect($B, lang(160), $l->update($b, $P, $pf, !$dh));
                if (is_ajax()) {
                    page_headers();
                    page_messages($m);
                    exit;
                }
            } else {
                $J = $l->insert($b, $P);
                $xd = ($J ? last_id() : 0);
                queries_redirect($B, lang(161, ($xd ? " $xd" : "")), $J);
            }
        }
    }$L = null;
    if ($_POST["save"]) {
        $L = (array)$_POST["fields"];
    } elseif ($Z) {
        $N = array();foreach (
            $o as $E => $n
        ) {
            if (isset($n["privileges"]["select"])) {
                $ua = convert_field($n);
                if ($_POST["clone"] && $n["auto_increment"]) {
                    $ua = "''";
                }if ($y == "sql" && preg_match("~enum|set~", $n["type"])) {
                    $ua = "1*" . idf_escape($E);
                }$N[] = ($ua ? "$ua AS " : "") . idf_escape($E);
            }
        }$L = array();
        if (!support("table")) {
            $N = array("*");
        }if ($N) {
            $J = $l->select($b, $N, array($Z), $N, array(), (isset($_GET["select"]) ? 2 : 1));
            if (!$J) {
                $m = error();
            } else {
                $L = $J->fetch_assoc();
                if (!$L) {
                    $L = false;
                }
            }if (isset($_GET["select"]) && (!$L || $J->fetch_assoc())) {
                $L = null;
            }
        }
    }if (!support("table") && !$o) {
        if (!$Z) {
            $J = $l->select($b, array("*"), $Z, array("*"));
            $L = ($J ? $J->fetch_assoc() : false);
            if (!$L) {
                $L = array($l->primary => "");
            }
        }if ($L) {
            foreach (
                $L as $z => $X
            ) {
                if (!$Z) {
                    $L[$z] = null;
                }$o[$z] = array("field" => $z,"null" => ($z != $l->primary),"auto_increment" => ($z == $l->primary));
            }
        }
    }edit_form($b, $o, $L, $ih);
} elseif (isset($_GET["create"])) {
    $b = $_GET["create"];
    $Oe = array();
    foreach (array('HASH','LINEAR HASH','KEY','LINEAR KEY','RANGE','LIST') as $z) {
        $Oe[$z] = $z;
    }$vf = referencable_primary($b);
    $Bc = array();foreach (
        $vf as $ug => $n
    ) {
        $Bc[str_replace("`", "``", $ug) . "`" . str_replace("`", "``", $n["field"])] = $ug;
    }
    $Ee = array();
    $R = array();
    if ($b != "") {
        $Ee = fields($b);
        $R = table_status($b);
        if (!$R) {
            $m = lang(9);
        }
    }$L = $_POST;
    $L["fields"] = (array)$L["fields"];
    if ($L["auto_increment_col"]) {
        $L["fields"][$L["auto_increment_col"]]["auto_increment"] = true;
    }if ($_POST) {
        set_adminer_settings(array("comments" => $_POST["comments"],"defaults" => $_POST["defaults"]));
    }if ($_POST && !process_fields($L["fields"]) && !$m) {
        if ($_POST["drop"]) {
            queries_redirect(substr(ME, 0, -1), lang(162), drop_tables(array($b)));
        } else {
            $o = array();
            $ra = array();
            $mh = false;
            $_c = array();
            $De = reset($Ee);
            $pa = " FIRST";
            foreach ($L["fields"] as $z => $n) {
                $p = $Bc[$n["type"]];
                $Yg = ($p !== null ? $vf[$p] : $n);
                if ($n["field"] != "") {
                    if (!$n["has_default"]) {
                        $n["default"] = null;
                    }if ($z == $L["auto_increment_col"]) {
                        $n["auto_increment"] = true;
                    }$lf = process_field($n, $Yg);
                    $ra[] = array($n["orig"],$lf,$pa);
                    if (!$De || $lf != process_field($De, $De)) {
                            $o[] = array($n["orig"],$lf,$pa);
                        if ($n["orig"] != "" || $pa) {
                            $mh = true;
                        }
                    }if ($p !== null) {
                        $_c[idf_escape($n["field"])] = ($b != "" && $y != "sqlite" ? "ADD" : " ") . format_foreign_key(array('table' => $Bc[$n["type"]],'source' => array($n["field"]),'target' => array($Yg["field"]),'on_delete' => $n["on_delete"],));
                    }$pa = " AFTER " . idf_escape($n["field"]);
                } elseif ($n["orig"] != "") {
                        $mh = true;
                        $o[] = array($n["orig"]);
                }if ($n["orig"] != "") {
                    $De = next($Ee);
                    if (!$De) {
                        $pa = "";
                    }
                }
            }$Qe = "";
            if ($Oe[$L["partition_by"]]) {
                $Re = array();
                if ($L["partition_by"] == 'RANGE' || $L["partition_by"] == 'LIST') {
                    foreach (array_filter($L["partition_names"]) as $z => $X) {
                        $Y = $L["partition_values"][$z];
                        $Re[] = "\n  PARTITION " . idf_escape($X) . " VALUES " . ($L["partition_by"] == 'RANGE' ? "LESS THAN" : "IN") . ($Y != "" ? " ($Y)" : " MAXVALUE");
                    }
                }$Qe .= "\nPARTITION BY $L[partition_by]($L[partition])" . ($Re ? " (" . implode(",", $Re) . "\n)" : ($L["partitions"] ? " PARTITIONS " . (+$L["partitions"]) : ""));
            } elseif (support("partitioning") && preg_match("~partitioned~", $R["Create_options"])) {
                $Qe .= "\nREMOVE PARTITIONING";
            }$D = lang(163);
            if ($b == "") {
                cookie("adminer_engine", $L["Engine"]);
                $D = lang(164);
            }$E = trim($L["name"]);
            queries_redirect(ME . (support("table") ? "table=" : "select=") . urlencode($E), $D, alter_table($b, $E, ($y == "sqlite" && ($mh || $_c) ? $ra : $o), $_c, ($L["Comment"] != $R["Comment"] ? $L["Comment"] : null), ($L["Engine"] && $L["Engine"] != $R["Engine"] ? $L["Engine"] : ""), ($L["Collation"] && $L["Collation"] != $R["Collation"] ? $L["Collation"] : ""), ($L["Auto_increment"] != "" ? number($L["Auto_increment"]) : ""), $Qe));
        }
    }page_header(($b != "" ? lang(33) : lang(63)), $m, array("table" => $b), h($b));
    if (!$_POST) {
        $L = array("Engine" => $_COOKIE["adminer_engine"],"fields" => array(array("field" => "","type" => (isset($ah["int"]) ? "int" : (isset($ah["integer"]) ? "integer" : "")),"on_update" => "")),"partition_names" => array(""),);
        if ($b != "") {
            $L = $R;
            $L["name"] = $b;
            $L["fields"] = array();
            if (!$_GET["auto_increment"]) {
                $L["Auto_increment"] = "";
            }foreach (
                $Ee as $n
            ) {
                $n["has_default"] = isset($n["default"]);
                $L["fields"][] = $n;
            }if (support("partitioning")) {
                $Fc = "FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = " . q(DB) . " AND TABLE_NAME = " . q($b);
                $J = $g->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $Fc ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");
                list($L["partition_by"],$L["partitions"],$L["partition"]) = $J->fetch_row();
                $Re = get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $Fc AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");
                $Re[""] = "";
                $L["partition_names"] = array_keys($Re);
                $L["partition_values"] = array_values($Re);
            }
        }
    }$Xa = collations();
    $ac = engines();foreach (
        $ac as $Zb
    ) {
        if (!strcasecmp($Zb, $L["Engine"])) {
            $L["Engine"] = $Zb;
            break;
        }
    }echo'
<form action="" method="post" id="form">
<p>
';if (support("columns") || $b == "") {
        echo
        lang(165),': <input name="name" data-maxlength="64" value="',h($L["name"]),'" autocapitalize="off">
';if ($b == "" && !$_POST) {
            echo
            script("focus(qs('#form')['name']);");
        }echo($ac ? "<select name='Engine'>" . optionlist(array("" => "(" . lang(166) . ")") + $ac, $L["Engine"]) . "</select>" . on_help("getTarget(event).value", 1) . script("qsl('select').onchange = helpClose;") : ""),' ',($Xa && !preg_match("~sqlite|mssql~", $y) ? html_select("Collation", array("" => "(" . lang(95) . ")") + $Xa, $L["Collation"]) : ""),' <input type="submit" value="',lang(14),'">
';
    }echo'
';if (support("columns")) {
        echo'<div class="scrollable">
<table cellspacing="0" id="edit-fields" class="nowrap">
';
        edit_fields($L["fields"], $Xa, "TABLE", $Bc);echo'</table>
',script("editFields();"),'</div>
<p>
',lang(40),': <input type="number" name="Auto_increment" size="6" value="',h($L["Auto_increment"]),'">
',checkbox("defaults", 1, ($_POST ? $_POST["defaults"] : adminer_setting("defaults")), lang(167), "columnShow(this.checked, 5)", "jsonly"),(support("comment") ? checkbox("comments", 1, ($_POST ? $_POST["comments"] : adminer_setting("comments")), lang(39), "editingCommentsClick(this, true);", "jsonly") . ' <input name="Comment" value="' . h($L["Comment"]) . '" data-maxlength="' . (min_version(5.5) ? 2048 : 60) . '">' : ''),'<p>
<input type="submit" value="',lang(14),'">
';
    }echo'
';
    if ($b != "") {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $b));
    }if (support("partitioning")) {
        $Pe = preg_match('~RANGE|LIST~', $L["partition_by"]);
        print_fieldset("partition", lang(169), $L["partition_by"]);echo'<p>
',"<select name='partition_by'>" . optionlist(array("" => "") + $Oe, $L["partition_by"]) . "</select>" . on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')", 1) . script("qsl('select').onchange = partitionByChange;"),'(<input name="partition" value="',h($L["partition"]),'">)
',lang(170),': <input type="number" name="partitions" class="size',($Pe || !$L["partition_by"] ? " hidden" : ""),'" value="',h($L["partitions"]),'">
<table cellspacing="0" id="partition-table"',($Pe ? "" : " class='hidden'"),'>
<thead><tr><th>',lang(171),'<th>',lang(172),'</thead>
';
        foreach ($L["partition_names"] as $z => $X) {
            echo'<tr>','<td><input name="partition_names[]" value="' . h($X) . '" autocapitalize="off">',($z == count($L["partition_names"]) - 1 ? script("qsl('input').oninput = partitionNameChange;") : ''),'<td><input name="partition_values[]" value="' . h($L["partition_values"][$z]) . '">';
        }echo'</table>
</div></fieldset>
';
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["indexes"])) {
    $b = $_GET["indexes"];
    $bd = array("PRIMARY","UNIQUE","INDEX");
    $R = table_status($b, true);
    if (preg_match('~MyISAM|M?aria' . (min_version(5.6, '10.0.5') ? '|InnoDB' : '') . '~i', $R["Engine"])) {
        $bd[] = "FULLTEXT";
    }if (preg_match('~MyISAM|M?aria' . (min_version(5.7, '10.2.2') ? '|InnoDB' : '') . '~i', $R["Engine"])) {
        $bd[] = "SPATIAL";
    }$x = indexes($b);
    $ff = array();
    if ($y == "mongo") {
        $ff = $x["_id_"];
        unset($bd[0]);
        unset($x["_id_"]);
    }$L = $_POST;
    if ($_POST && !$m && !$_POST["add"] && !$_POST["drop_col"]) {
        $sa = array();
        foreach ($L["indexes"] as $w) {
            $E = $w["name"];
            if (in_array($w["type"], $bd)) {
                $e = array();
                $Cd = array();
                $Eb = array();
                $P = array();
                ksort($w["columns"]);
                foreach ($w["columns"] as $z => $d) {
                    if ($d != "") {
                        $Bd = $w["lengths"][$z];
                        $Db = $w["descs"][$z];
                        $P[] = idf_escape($d) . ($Bd ? "(" . (+$Bd) . ")" : "") . ($Db ? " DESC" : "");
                        $e[] = $d;
                        $Cd[] = ($Bd ? $Bd : null);
                        $Eb[] = $Db;
                    }
                }if ($e) {
                    $kc = $x[$E];
                    if ($kc) {
                        ksort($kc["columns"]);
                        ksort($kc["lengths"]);
                        ksort($kc["descs"]);
                        if ($w["type"] == $kc["type"] && array_values($kc["columns"]) === $e && (!$kc["lengths"] || array_values($kc["lengths"]) === $Cd) && array_values($kc["descs"]) === $Eb) {
                                    unset($x[$E]);
                                    continue;
                        }
                    }$sa[] = array($w["type"],$E,$P);
                }
            }
        }foreach (
            $x as $E => $kc
        ) {
            $sa[] = array($kc["type"],$E,"DROP");
        }
        if (!$sa) {
            redirect(ME . "table=" . urlencode($b));
        }queries_redirect(ME . "table=" . urlencode($b), lang(173), alter_indexes($b, $sa));
    }page_header(lang(125), $m, array("table" => $b), h($b));
    $o = array_keys(fields($b));
    if ($_POST["add"]) {
        foreach ($L["indexes"] as $z => $w) {
            if ($w["columns"][count($w["columns"])] != "") {
                $L["indexes"][$z]["columns"][] = "";
            }
        }$w = end($L["indexes"]);
        if ($w["type"] || array_filter($w["columns"], 'strlen')) {
            $L["indexes"][] = array("columns" => array(1 => ""));
        }
    }if (!$L) {
        foreach (
            $x as $z => $w
        ) {
            $x[$z]["name"] = $z;
            $x[$z]["columns"][] = "";
        }$x[] = array("columns" => array(1 => ""));
        $L["indexes"] = $x;
    }echo'
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
<thead><tr>
<th id="label-type">',lang(174),'<th><input type="submit" class="wayoff">',lang(175),'<th id="label-name">',lang(176),'<th><noscript>',"<input type='image' class='icon' name='add[0]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.8.1") . "' alt='+' title='" . lang(102) . "'>",'</noscript>
</thead>
';
    if ($ff) {
        echo"<tr><td>PRIMARY<td>";foreach ($ff["columns"] as $z => $d) {
            echo
                    select_input(" disabled", $o, $d),"<label><input disabled type='checkbox'>" . lang(48) . "</label> ";
        }echo"<td><td>\n";
    }$nd = 1;
    foreach ($L["indexes"] as $w) {
        if (!$_POST["drop_col"] || $nd != key($_POST["drop_col"])) {
            echo"<tr><td>" . html_select("indexes[$nd][type]", array(-1 => "") + $bd, $w["type"], ($nd == count($L["indexes"]) ? "indexesAddRow.call(this);" : 1), "label-type"),"<td>";
            ksort($w["columns"]);
            $t = 1;
            foreach ($w["columns"] as $z => $d) {
                echo"<span>" . select_input(" name='indexes[$nd][columns][$t]' title='" . lang(37) . "'", ($o ? array_combine($o, $o) : $o), $d, "partial(" . ($t == count($w["columns"]) ? "indexesAddColumn" : "indexesChangeColumn") . ", '" . js_escape($y == "sql" ? "" : $_GET["indexes"] . "_") . "')"),($y == "sql" || $y == "mssql" ? "<input type='number' name='indexes[$nd][lengths][$t]' class='size' value='" . h($w["lengths"][$z]) . "' title='" . lang(100) . "'>" : ""),(support("descidx") ? checkbox("indexes[$nd][descs][$t]", 1, $w["descs"][$z], lang(48)) : "")," </span>";
                $t++;
            }echo"<td><input name='indexes[$nd][name]' value='" . h($w["name"]) . "' autocapitalize='off' aria-labelledby='label-name'>\n","<td><input type='image' class='icon' name='drop_col[$nd]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=cross.gif&version=4.8.1") . "' alt='x' title='" . lang(105) . "'>" . script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");
        }$nd++;
    }echo'</table>
</div>
<p>
<input type="submit" value="',lang(14),'">
<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["database"])) {
    $L = $_POST;
    if ($_POST && !$m && !isset($_POST["add_x"])) {
        $E = trim($L["name"]);
        if ($_POST["drop"]) {
            $_GET["db"] = "";
            queries_redirect(remove_from_uri("db|database"), lang(177), drop_databases(array(DB)));
        } elseif (DB !== $E) {
            if (DB != "") {
                $_GET["db"] = $E;
                queries_redirect(preg_replace('~\bdb=[^&]*&~', '', ME) . "db=" . urlencode($E), lang(178), rename_database($E, $L["collation"]));
            } else {
                $j = explode("\n", str_replace("\r", "", $E));
                $og = true;
                $wd = "";foreach (
                    $j as $k
                ) {
                    if (count($j) == 1 || $k != "") {
                        if (!create_database($k, $L["collation"])) {
                            $og = false;
                        }$wd = $k;
                    }
                }restart_session();
                set_session("dbs", null);
                queries_redirect(ME . "db=" . urlencode($wd), lang(179), $og);
            }
        } else {
            if (!$L["collation"]) {
                redirect(substr(ME, 0, -1));
            }query_redirect("ALTER DATABASE " . idf_escape($E) . (preg_match('~^[a-z0-9_]+$~i', $L["collation"]) ? " COLLATE $L[collation]" : ""), substr(ME, 0, -1), lang(180));
        }
    }page_header(DB != "" ? lang(56) : lang(109), $m, array(), h(DB));
    $Xa = collations();
    $E = DB;
    if ($_POST) {
        $E = $L["name"];
    } elseif (DB != "") {
        $L["collation"] = db_collation(DB, $Xa);
    } elseif ($y == "sql") {
        foreach (get_vals("SHOW GRANTS") as $Hc) {
            if (preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~', $Hc, $C) && $C[1]) {
                $E = stripcslashes(idf_unescape("`$C[2]`"));
                break;
            }
        }
    }echo'
<form action="" method="post">
<p>
',($_POST["add_x"] || strpos($E, "\n") ? '<textarea id="name" name="name" rows="10" cols="40">' . h($E) . '</textarea><br>' : '<input name="name" id="name" value="' . h($E) . '" data-maxlength="64" autocapitalize="off">') . "\n" . ($Xa ? html_select("collation", array("" => "(" . lang(95) . ")") + $Xa, $L["collation"]) . doc_link(array('sql' => "charset-charsets.html",'mariadb' => "supported-character-sets-and-collations/",)) : ""),script("focus(qs('#name'));"),'<input type="submit" value="',lang(14),'">
';
    if (DB != "") {
        echo"<input type='submit' name='drop' value='" . lang(121) . "'>" . confirm(lang(168, DB)) . "\n";
    } elseif (!$_POST["add_x"] && $_GET["db"] == "") {
        echo"<input type='image' class='icon' name='add' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.8.1") . "' alt='+' title='" . lang(102) . "'>\n";
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["call"])) {
    $ca = ($_GET["name"] ? $_GET["name"] : $_GET["call"]);
    page_header(lang(181) . ": " . h($ca), $m);
    $Ff = routine($_GET["call"], (isset($_GET["callf"]) ? "FUNCTION" : "PROCEDURE"));
    $ad = array();
    $He = array();
    foreach ($Ff["fields"] as $t => $n) {
        if (substr($n["inout"], -3) == "OUT") {
            $He[$t] = "@" . idf_escape($n["field"]) . " AS " . idf_escape($n["field"]);
        }if (!$n["inout"] || substr($n["inout"], 0, 2) == "IN") {
            $ad[] = $t;
        }
    }if (!$m && $_POST) {
        $Ja = array();
        foreach ($Ff["fields"] as $z => $n) {
            if (in_array($z, $ad)) {
                $X = process_input($n);
                if ($X === false) {
                    $X = "''";
                }if (isset($He[$z])) {
                    $g->query("SET @" . idf_escape($n["field"]) . " = $X");
                }
            }$Ja[] = (isset($He[$z]) ? "@" . idf_escape($n["field"]) : $X);
        }$I = (isset($_GET["callf"]) ? "SELECT" : "CALL") . " " . table($ca) . "(" . implode(", ", $Ja) . ")";
        $hg = microtime(true);
        $J = $g->multi_query($I);
        $na = $g->affected_rows;
        echo$c->selectQuery($I, $hg, !$J);
        if (!$J) {
            echo"<p class='error'>" . error() . "\n";
        } else {
            $h = connect();
            if (is_object($h)) {
                $h->select_db(DB);
            }do {
                $J = $g->store_result();
                if (is_object($J)) {
                    select($J, $h);
                } else {
                    echo"<p class='message'>" . lang(182, $na) . " <span class='time'>" . @date("H:i:s") . "</span>\n";
                }
            } while ($g->next_result());
            if ($He) {
                select($g->query("SELECT " . implode(", ", $He)));
            }
        }
    }echo'
<form action="" method="post">
';
    if ($ad) {
        echo"<table cellspacing='0' class='layout'>\n";foreach (
            $ad as $z
        ) {
            $n = $Ff["fields"][$z];
            $E = $n["field"];
            echo"<tr><th>" . $c->fieldName($n);
            $Y = $_POST["fields"][$E];
            if ($Y != "") {
                if ($n["type"] == "enum") {
                    $Y = +$Y;
                }if ($n["type"] == "set") {
                    $Y = array_sum($Y);
                }
            }input($n, $Y, (string)$_POST["function"][$E]);
            echo"\n";
        }echo"</table>\n";
    }echo'<p>
<input type="submit" value="',lang(181),'">
<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["foreign"])) {
    $b = $_GET["foreign"];
    $E = $_GET["name"];
    $L = $_POST;
    if ($_POST && !$m && !$_POST["add"] && !$_POST["change"] && !$_POST["change-js"]) {
        $D = ($_POST["drop"] ? lang(183) : ($E != "" ? lang(184) : lang(185)));
        $B = ME . "table=" . urlencode($b);
        if (!$_POST["drop"]) {
            $L["source"] = array_filter($L["source"], 'strlen');
            ksort($L["source"]);
            $Ag = array();
            foreach ($L["source"] as $z => $X) {
                $Ag[$z] = $L["target"][$z];
            }$L["target"] = $Ag;
        }if ($y == "sqlite") {
            queries_redirect($B, $D, recreate_table($b, $b, array(), array(), array(" $E" => ($_POST["drop"] ? "" : " " . format_foreign_key($L)))));
        } else {
            $sa = "ALTER TABLE " . table($b);
            $Lb = "\nDROP " . ($y == "sql" ? "FOREIGN KEY " : "CONSTRAINT ") . idf_escape($E);
            if ($_POST["drop"]) {
                query_redirect($sa . $Lb, $B, $D);
            } else {
                query_redirect($sa . ($E != "" ? "$Lb," : "") . "\nADD" . format_foreign_key($L), $B, $D);
                $m = lang(186) . "<br>$m";
            }
        }
    }page_header(lang(187), $m, array("table" => $b), h($b));
    if ($_POST) {
        ksort($L["source"]);
        if ($_POST["add"]) {
            $L["source"][] = "";
        } elseif ($_POST["change"] || $_POST["change-js"]) {
            $L["target"] = array();
        }
    } elseif ($E != "") {
        $Bc = foreign_keys($b);
        $L = $Bc[$E];
        $L["source"][] = "";
    } else {
        $L["table"] = $b;
        $L["source"] = array("");
    }echo'
<form action="" method="post">
';
    $bg = array_keys(fields($b));
    if ($L["db"] != "") {
        $g->select_db($L["db"]);
    }if ($L["ns"] != "") {
        set_schema($L["ns"]);
    }$uf = array_keys(array_filter(table_status('', true), 'fk_support'));
    $Ag = array_keys(fields(in_array($L["table"], $uf) ? $L["table"] : reset($uf)));
    $se = "this.form['change-js'].value = '1'; this.form.submit();";
    echo"<p>" . lang(188) . ": " . html_select("table", $uf, $L["table"], $se) . "\n";if ($y == "pgsql") {
        echo
                            lang(189) . ": " . html_select("ns", $c->schemas(), $L["ns"] != "" ? $L["ns"] : $_GET["ns"], $se);
    } elseif ($y != "sqlite") {
        $xb = array();
        foreach ($c->databases() as $k) {
            if (!information_schema($k)) {
                $xb[] = $k;
            }
        }echo
                            lang(65) . ": " . html_select("db", $xb, $L["db"] != "" ? $L["db"] : $_GET["db"], $se);
    }echo'<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="',lang(190),'"></noscript>
<table cellspacing="0">
<thead><tr><th id="label-source">',lang(127),'<th id="label-target">',lang(128),'</thead>
';
    $nd = 0;
    foreach ($L["source"] as $z => $X) {
        echo"<tr>","<td>" . html_select("source[" . (+$z) . "]", array(-1 => "") + $bg, $X, ($nd == count($L["source"]) - 1 ? "foreignAddRow.call(this);" : 1), "label-source"),"<td>" . html_select("target[" . (+$z) . "]", $Ag, $L["target"][$z], 1, "label-target");
        $nd++;
    }echo'</table>
<p>
',lang(97),': ',html_select("on_delete", array(-1 => "") + explode("|", $re), $L["on_delete"]),' ',lang(96),': ',html_select("on_update", array(-1 => "") + explode("|", $re), $L["on_update"]),doc_link(array('sql' => "innodb-foreign-key-constraints.html",'mariadb' => "foreign-keys/",)),'<p>
<input type="submit" value="',lang(14),'">
<noscript><p><input type="submit" name="add" value="',lang(191),'"></noscript>
';
    if ($E != "") {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $E));
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["view"])) {
    $b = $_GET["view"];
    $L = $_POST;
    $Fe = "VIEW";
    if ($y == "pgsql" && $b != "") {
        $ig = table_status($b);
        $Fe = strtoupper($ig["Engine"]);
    }if ($_POST && !$m) {
        $E = trim($L["name"]);
        $ua = " AS\n$L[select]";
        $B = ME . "table=" . urlencode($E);
        $D = lang(192);
        $U = ($_POST["materialized"] ? "MATERIALIZED VIEW" : "VIEW");
        if (!$_POST["drop"] && $b == $E && $y != "sqlite" && $U == "VIEW" && $Fe == "VIEW") {
            query_redirect(($y == "mssql" ? "ALTER" : "CREATE OR REPLACE") . " VIEW " . table($E) . $ua, $B, $D);
        } else {
            $Cg = $E . "_adminer_" . uniqid();
            drop_create("DROP $Fe " . table($b), "CREATE $U " . table($E) . $ua, "DROP $U " . table($E), "CREATE $U " . table($Cg) . $ua, "DROP $U " . table($Cg), ($_POST["drop"] ? substr(ME, 0, -1) : $B), lang(193), $D, lang(194), $b, $E);
        }
    }if (!$_POST && $b != "") {
        $L = view($b);
        $L["name"] = $b;
        $L["materialized"] = ($Fe != "VIEW");
        if (!$m) {
            $m = error();
        }
    }page_header(($b != "" ? lang(32) : lang(195)), $m, array("table" => $b), h($b));echo'
<form action="" method="post">
<p>',lang(176),': <input name="name" value="',h($L["name"]),'" data-maxlength="64" autocapitalize="off">
',(support("materializedview") ? " " . checkbox("materialized", 1, $L["materialized"], lang(122)) : ""),'<p>';
    textarea("select", $L["select"]);echo'<p>
<input type="submit" value="',lang(14),'">
';
    if ($b != "") {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $b));
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["event"])) {
    $aa = $_GET["event"];
    $gd = array("YEAR","QUARTER","MONTH","DAY","HOUR","MINUTE","WEEK","SECOND","YEAR_MONTH","DAY_HOUR","DAY_MINUTE","DAY_SECOND","HOUR_MINUTE","HOUR_SECOND","MINUTE_SECOND");
    $jg = array("ENABLED" => "ENABLE","DISABLED" => "DISABLE","SLAVESIDE_DISABLED" => "DISABLE ON SLAVE");
    $L = $_POST;
    if ($_POST && !$m) {
        if ($_POST["drop"]) {
            query_redirect("DROP EVENT " . idf_escape($aa), substr(ME, 0, -1), lang(196));
        } elseif (in_array($L["INTERVAL_FIELD"], $gd) && isset($jg[$L["STATUS"]])) {
            $Jf = "\nON SCHEDULE " . ($L["INTERVAL_VALUE"] ? "EVERY " . q($L["INTERVAL_VALUE"]) . " $L[INTERVAL_FIELD]" . ($L["STARTS"] ? " STARTS " . q($L["STARTS"]) : "") . ($L["ENDS"] ? " ENDS " . q($L["ENDS"]) : "") : "AT " . q($L["STARTS"])) . " ON COMPLETION" . ($L["ON_COMPLETION"] ? "" : " NOT") . " PRESERVE";
            queries_redirect(substr(ME, 0, -1), ($aa != "" ? lang(197) : lang(198)), queries(($aa != "" ? "ALTER EVENT " . idf_escape($aa) . $Jf . ($aa != $L["EVENT_NAME"] ? "\nRENAME TO " . idf_escape($L["EVENT_NAME"]) : "") : "CREATE EVENT " . idf_escape($L["EVENT_NAME"]) . $Jf) . "\n" . $jg[$L["STATUS"]] . " COMMENT " . q($L["EVENT_COMMENT"]) . rtrim(" DO\n$L[EVENT_DEFINITION]", ";") . ";"));
        }
    }page_header(($aa != "" ? lang(199) . ": " . h($aa) : lang(200)), $m);
    if (!$L && $aa != "") {
        $M = get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = " . q(DB) . " AND EVENT_NAME = " . q($aa));
        $L = reset($M);
    }echo'
<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>',lang(176),'<td><input name="EVENT_NAME" value="',h($L["EVENT_NAME"]),'" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">',lang(201),'<td><input name="STARTS" value="',h("$L[EXECUTE_AT]$L[STARTS]"),'">
<tr><th title="datetime">',lang(202),'<td><input name="ENDS" value="',h($L["ENDS"]),'">
<tr><th>',lang(203),'<td><input type="number" name="INTERVAL_VALUE" value="',h($L["INTERVAL_VALUE"]),'" class="size"> ',html_select("INTERVAL_FIELD", $gd, $L["INTERVAL_FIELD"]),'<tr><th>',lang(112),'<td>',html_select("STATUS", $jg, $L["STATUS"]),'<tr><th>',lang(39),'<td><input name="EVENT_COMMENT" value="',h($L["EVENT_COMMENT"]),'" data-maxlength="64">
<tr><th><td>',checkbox("ON_COMPLETION", "PRESERVE", $L["ON_COMPLETION"] == "PRESERVE", lang(204)),'</table>
<p>';
    textarea("EVENT_DEFINITION", $L["EVENT_DEFINITION"]);echo'<p>
<input type="submit" value="',lang(14),'">
';
    if ($aa != "") {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $aa));
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["procedure"])) {
    $ca = ($_GET["name"] ? $_GET["name"] : $_GET["procedure"]);
    $Ff = (isset($_GET["function"]) ? "FUNCTION" : "PROCEDURE");
    $L = $_POST;
    $L["fields"] = (array)$L["fields"];
    if ($_POST && !process_fields($L["fields"]) && !$m) {
        $Ce = routine($_GET["procedure"], $Ff);
        $Cg = "$L[name]_adminer_" . uniqid();
        drop_create("DROP $Ff " . routine_id($ca, $Ce), create_routine($Ff, $L), "DROP $Ff " . routine_id($L["name"], $L), create_routine($Ff, array("name" => $Cg) + $L), "DROP $Ff " . routine_id($Cg, $L), substr(ME, 0, -1), lang(205), lang(206), lang(207), $ca, $L["name"]);
    }page_header(($ca != "" ? (isset($_GET["function"]) ? lang(208) : lang(209)) . ": " . h($ca) : (isset($_GET["function"]) ? lang(210) : lang(211))), $m);
    if (!$_POST && $ca != "") {
        $L = routine($_GET["procedure"], $Ff);
        $L["name"] = $ca;
    }$Xa = get_vals("SHOW CHARACTER SET");
    sort($Xa);
    $Gf = routine_languages();echo'
<form action="" method="post" id="form">
<p>',lang(176),': <input name="name" value="',h($L["name"]),'" data-maxlength="64" autocapitalize="off">
',($Gf ? lang(19) . ": " . html_select("language", $Gf, $L["language"]) . "\n" : ""),'<input type="submit" value="',lang(14),'">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
';
    edit_fields($L["fields"], $Xa, $Ff);
    if (isset($_GET["function"])) {
        echo"<tr><td>" . lang(212);
        edit_type("returns", $L["returns"], $Xa, array(), ($y == "pgsql" ? array("void","trigger") : array()));
    }echo'</table>
',script("editFields();"),'</div>
<p>';
    textarea("definition", $L["definition"]);echo'<p>
<input type="submit" value="',lang(14),'">
';
    if ($ca != "") {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $ca));
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["trigger"])) {
    $b = $_GET["trigger"];
    $E = $_GET["name"];
    $Wg = trigger_options();
    $L = (array)trigger($E, $b) + array("Trigger" => $b . "_bi");
    if ($_POST) {
        if (!$m && in_array($_POST["Timing"], $Wg["Timing"]) && in_array($_POST["Event"], $Wg["Event"]) && in_array($_POST["Type"], $Wg["Type"])) {
            $qe = " ON " . table($b);
            $Lb = "DROP TRIGGER " . idf_escape($E) . ($y == "pgsql" ? $qe : "");
            $B = ME . "table=" . urlencode($b);
            if ($_POST["drop"]) {
                query_redirect($Lb, $B, lang(213));
            } else {
                if ($E != "") {
                    queries($Lb);
                }queries_redirect($B, ($E != "" ? lang(214) : lang(215)), queries(create_trigger($qe, $_POST)));
                if ($E != "") {
                    queries(create_trigger($qe, $L + array("Type" => reset($Wg["Type"]))));
                }
            }
        }$L = $_POST;
    }page_header(($E != "" ? lang(216) . ": " . h($E) : lang(217)), $m, array("table" => $b));echo'
<form action="" method="post" id="form">
<table cellspacing="0" class="layout">
<tr><th>',lang(218),'<td>',html_select("Timing", $Wg["Timing"], $L["Timing"], "triggerChange(/^" . preg_quote($b, "/") . "_[ba][iud]$/, '" . js_escape($b) . "', this.form);"),'<tr><th>',lang(219),'<td>',html_select("Event", $Wg["Event"], $L["Event"], "this.form['Timing'].onchange();"),(in_array("UPDATE OF", $Wg["Event"]) ? " <input name='Of' value='" . h($L["Of"]) . "' class='hidden'>" : ""),'<tr><th>',lang(38),'<td>',html_select("Type", $Wg["Type"], $L["Type"]),'</table>
<p>',lang(176),': <input name="Trigger" value="',h($L["Trigger"]),'" data-maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';
    textarea("Statement", $L["Statement"]);echo'<p>
<input type="submit" value="',lang(14),'">
';
    if ($E != "") {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $E));
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["user"])) {
    $ea = $_GET["user"];
    $jf = array("" => array("All privileges" => ""));
    foreach (get_rows("SHOW PRIVILEGES") as $L) {
        foreach (explode(",", ($L["Privilege"] == "Grant option" ? "" : $L["Context"])) as $ib) {
            $jf[$ib][$L["Privilege"]] = $L["Comment"];
        }
    }$jf["Server Admin"] += $jf["File access on server"];
    $jf["Databases"]["Create routine"] = $jf["Procedures"]["Create routine"];
    unset($jf["Procedures"]["Create routine"]);
    $jf["Columns"] = array();
    foreach (array("Select","Insert","Update","References") as $X) {
        $jf["Columns"][$X] = $jf["Tables"][$X];
    }unset($jf["Server Admin"]["Usage"]);
    foreach ($jf["Tables"] as $z => $X) {
        unset($jf["Databases"][$z]);
    }$be = array();
    if ($_POST) {
        foreach ($_POST["objects"] as $z => $X) {
            $be[$X] = (array)$be[$X] + (array)$_POST["grants"][$z];
        }
    }$Ic = array();
    $oe = "";if (isset($_GET["host"]) && ($J = $g->query("SHOW GRANTS FOR " . q($ea) . "@" . q($_GET["host"])))) {
        while ($L = $J->fetch_row()) {
            if (preg_match('~GRANT (.*) ON (.*) TO ~', $L[0], $C) && preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~', $C[1], $Jd, PREG_SET_ORDER)) {
                foreach (
                    $Jd as $X
                ) {
                    if ($X[1] != "USAGE") {
                        $Ic["$C[2]$X[2]"][$X[1]] = true;
                    }if (preg_match('~ WITH GRANT OPTION~', $L[0])) {
                        $Ic["$C[2]$X[2]"]["GRANT OPTION"] = true;
                    }
                }
            }if (preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~", $L[0], $C)) {
                $oe = $C[1];
            }
        }
    }if ($_POST && !$m) {
        $pe = (isset($_GET["host"]) ? q($ea) . "@" . q($_GET["host"]) : "''");
        if ($_POST["drop"]) {
            query_redirect("DROP USER $pe", ME . "privileges=", lang(220));
        } else {
            $de = q($_POST["user"]) . "@" . q($_POST["host"]);
            $Se = $_POST["pass"];
            if ($Se != '' && !$_POST["hashed"] && !min_version(8)) {
                $Se = $g->result("SELECT PASSWORD(" . q($Se) . ")");
                $m = !$Se;
            }$mb = false;
            if (!$m) {
                if ($pe != $de) {
                    $mb = queries((min_version(5) ? "CREATE USER" : "GRANT USAGE ON *.* TO") . " $de IDENTIFIED BY " . (min_version(8) ? "" : "PASSWORD ") . q($Se));
                    $m = !$mb;
                } elseif ($Se != $oe) {
                    queries("SET PASSWORD FOR $de = " . q($Se));
                }
            }if (!$m) {
                $Cf = array();foreach (
                    $be as $je => $Hc
                ) {
                    if (isset($_GET["grant"])) {
                        $Hc = array_filter($Hc);
                    }$Hc = array_keys($Hc);
                    if (isset($_GET["grant"])) {
                        $Cf = array_diff(array_keys(array_filter($be[$je], 'strlen')), $Hc);
                    } elseif ($pe == $de) {
                        $me = array_keys((array)$Ic[$je]);
                        $Cf = array_diff($me, $Hc);
                        $Hc = array_diff($Hc, $me);
                        unset($Ic[$je]);
                    }if (preg_match('~^(.+)\s*(\(.*\))?$~U', $je, $C) && (!grant("REVOKE", $Cf, $C[2], " ON $C[1] FROM $de") || !grant("GRANT", $Hc, $C[2], " ON $C[1] TO $de"))) {
                        $m = true;
                        break;
                    }
                }
            }if (!$m && isset($_GET["host"])) {
                if ($pe != $de) {
                    queries("DROP USER $pe");
                } elseif (!isset($_GET["grant"])) {
                    foreach (
                        $Ic as $je => $Cf
                    ) {
                        if (preg_match('~^(.+)(\(.*\))?$~U', $je, $C)) {
                            grant("REVOKE", array_keys($Cf), $C[2], " ON $C[1] FROM $de");
                        }
                    }
                }
            }queries_redirect(ME . "privileges=", (isset($_GET["host"]) ? lang(221) : lang(222)), !$m);
            if ($mb) {
                $g->query("DROP USER $de");
            }
        }
    }page_header((isset($_GET["host"]) ? lang(24) . ": " . h("$ea@$_GET[host]") : lang(139)), $m, array("privileges" => array('',lang(60))));
    if ($_POST) {
        $L = $_POST;
        $Ic = $be;
    } else {
        $L = $_GET + array("host" => $g->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));
        $L["pass"] = $oe;
        if ($oe != "") {
            $L["hashed"] = true;
        }$Ic[(DB == "" || $Ic ? "" : idf_escape(addcslashes(DB, "%_\\"))) . ".*"] = array();
    }echo'<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>',lang(23),'<td><input name="host" data-maxlength="60" value="',h($L["host"]),'" autocapitalize="off">
<tr><th>',lang(24),'<td><input name="user" data-maxlength="80" value="',h($L["user"]),'" autocapitalize="off">
<tr><th>',lang(25),'<td><input name="pass" id="pass" value="',h($L["pass"]),'" autocomplete="new-password">
';if (!$L["hashed"]) {
        echo
                    script("typePassword(qs('#pass'));");
    }echo(min_version(8) ? "" : checkbox("hashed", 1, $L["hashed"], lang(223), "typePassword(this.form['pass'], this.checked);")),'</table>

';
    echo"<table cellspacing='0'>\n","<thead><tr><th colspan='2'>" . lang(60) . doc_link(array('sql' => "grant.html#priv_level"));
    $t = 0;foreach (
        $Ic as $je => $Hc
    ) {
        echo'<th>' . ($je != "*.*" ? "<input name='objects[$t]' value='" . h($je) . "' size='10' autocapitalize='off'>" : "<input type='hidden' name='objects[$t]' value='*.*' size='10'>*.*");
        $t++;
    }echo"</thead>\n";
    foreach (array("" => "","Server Admin" => lang(23),"Databases" => lang(26),"Tables" => lang(124),"Columns" => lang(37),"Procedures" => lang(224),) as $ib => $Db) {
        foreach ((array)$jf[$ib] as $if => $bb) {
            echo"<tr" . odd() . "><td" . ($Db ? ">$Db<td" : " colspan='2'") . ' lang="en" title="' . h($bb) . '">' . h($if);
            $t = 0;foreach (
                $Ic as $je => $Hc
            ) {
                $E = "'grants[$t][" . h(strtoupper($if)) . "]'";
                $Y = $Hc[strtoupper($if)];
                if ($ib == "Server Admin" && $je != (isset($Ic["*.*"]) ? "*.*" : ".*")) {
                    echo"<td>";
                } elseif (isset($_GET["grant"])) {
                    echo"<td><select name=$E><option><option value='1'" . ($Y ? " selected" : "") . ">" . lang(225) . "<option value='0'" . ($Y == "0" ? " selected" : "") . ">" . lang(226) . "</select>";
                } else {
                    echo"<td align='center'><label class='block'>","<input type='checkbox' name=$E value='1'" . ($Y ? " checked" : "") . ($if == "All privileges" ? " id='grants-$t-all'>" : ">" . ($if == "Grant option" ? "" : script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$t-all'); };"))),"</label>";
                }$t++;
            }
        }
    }echo"</table>\n",'<p>
<input type="submit" value="',lang(14),'">
';
    if (isset($_GET["host"])) {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, "$ea@$_GET[host]"));
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["processlist"])) {
    if (support("kill")) {
        if ($_POST && !$m) {
            $rd = 0;
            foreach ((array)$_POST["kill"] as $X) {
                if (kill_process($X)) {
                    $rd++;
                }
            }queries_redirect(ME . "processlist=", lang(227, $rd), $rd || !$_POST["kill"]);
        }
    }page_header(lang(110), $m);echo'
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap checkable">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");
    $t = -1;
    foreach (process_list() as $t => $L) {
        if (!$t) {
            echo"<thead><tr lang='en'>" . (support("kill") ? "<th>" : "");foreach (
                $L as $z => $X
            ) {
                echo"<th>$z" . doc_link(array('sql' => "show-processlist.html#processlist_" . strtolower($z),));
            }
            echo"</thead>\n";
        }echo"<tr" . odd() . ">" . (support("kill") ? "<td>" . checkbox("kill[]", $L[$y == "sql" ? "Id" : "pid"], 0) : "");foreach (
            $L as $z => $X
        ) {
            echo"<td>" . (($y == "sql" && $z == "Info" && preg_match("~Query|Killed~", $L["Command"]) && $X != "") || ($y == "pgsql" && $z == "current_query" && $X != "<IDLE>") || ($y == "oracle" && $z == "sql_text" && $X != "") ? "<code class='jush-$y'>" . shorten_utf8($X, 100, "</code>") . ' <a href="' . h(ME . ($L["db"] != "" ? "db=" . urlencode($L["db"]) . "&" : "") . "sql=" . urlencode($X)) . '">' . lang(228) . '</a>' : h($X));
        }
        echo"\n";
    }echo'</table>
</div>
<p>
';
    if (support("kill")) {
        echo($t + 1) . "/" . lang(229, max_connections()),"<p><input type='submit' value='" . lang(230) . "'>\n";
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
',script("tableCheck();");
} elseif (isset($_GET["select"])) {
    $b = $_GET["select"];
    $R = table_status1($b);
    $x = indexes($b);
    $o = fields($b);
    $Bc = column_foreign_keys($b);
    $le = $R["Oid"];
    parse_str($_COOKIE["adminer_import"], $ma);
    $Df = array();
    $e = array();
    $Fg = null;foreach (
        $o as $z => $n
    ) {
        $E = $c->fieldName($n);
        if (isset($n["privileges"]["select"]) && $E != "") {
            $e[$z] = html_entity_decode(strip_tags($E), ENT_QUOTES);
            if (is_shortable($n)) {
                $Fg = $c->selectLengthProcess();
            }
        }$Df += $n["privileges"];
    }list($N,$s) = $c->selectColumnsProcess($e, $x);
    $kd = count($s) < count($N);
    $Z = $c->selectSearchProcess($o, $x);
    $ze = $c->selectOrderProcess($o, $x);
    $_ = $c->selectLimitProcess();
    if ($_GET["val"] && is_ajax()) {
        header("Content-Type: text/plain; charset=utf-8");
        foreach ($_GET["val"] as $eh => $L) {
            $ua = convert_field($o[key($L)]);
            $N = array($ua ? $ua : idf_escape(key($L)));
            $Z[] = where_check($eh, $o);
            $K = $l->select($b, $N, $Z, $N);if ($K) {
                echo
                        reset($K->fetch_row());
            }
        }exit;
    }$ff = $gh = null;foreach (
        $x as $w
    ) {
        if ($w["type"] == "PRIMARY") {
            $ff = array_flip($w["columns"]);
            $gh = ($N ? $ff : array());foreach (
                $gh as $z => $X
            ) {
                if (in_array(idf_escape($z), $N)) {
                    unset($gh[$z]);
                }
            }break;
        }
    }if ($le && !$ff) {
        $ff = $gh = array($le => 0);
        $x[] = array("type" => "PRIMARY","columns" => array($le));
    }if ($_POST && !$m) {
        $Bh = $Z;
        if (!$_POST["all"] && is_array($_POST["check"])) {
            $Oa = array();
            foreach ($_POST["check"] as $Ma) {
                $Oa[] = where_check($Ma, $o);
            }$Bh[] = "((" . implode(") OR (", $Oa) . "))";
        }$Bh = ($Bh ? "\nWHERE " . implode(" AND ", $Bh) : "");
        if ($_POST["export"]) {
            cookie("adminer_import", "output=" . urlencode($_POST["output"]) . "&format=" . urlencode($_POST["format"]));
            dump_headers($b);
            $c->dumpTable($b, "");
            $Fc = ($N ? implode(", ", $N) : "*") . convert_fields($e, $o, $N) . "\nFROM " . table($b);
            $Kc = ($s && $kd ? "\nGROUP BY " . implode(", ", $s) : "") . ($ze ? "\nORDER BY " . implode(", ", $ze) : "");
            if (!is_array($_POST["check"]) || $ff) {
                $I = "SELECT $Fc$Bh$Kc";
            } else {
                $ch = array();
                foreach ($_POST["check"] as $X) {
                    $ch[] = "(SELECT" . limit($Fc, "\nWHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($X, $o) . $Kc, 1) . ")";
                }$I = implode(" UNION ALL ", $ch);
            }$c->dumpData($b, "table", $I);
            exit;
        }if (!$c->selectEmailProcess($Z, $Bc)) {
            if ($_POST["save"] || $_POST["delete"]) {
                $J = true;
                $na = 0;
                $P = array();if (!$_POST["delete"]) {
                    foreach (
                        $e as $E => $X
                    ) {
                        $X = process_input($o[$E]);
                        if ($X !== null && ($_POST["clone"] || $X !== false)) {
                            $P[idf_escape($E)] = ($X !== false ? $X : idf_escape($E));
                        }
                    }
                }if ($_POST["delete"] || $P) {
                    if ($_POST["clone"]) {
                        $I = "INTO " . table($b) . " (" . implode(", ", array_keys($P)) . ")\nSELECT " . implode(", ", $P) . "\nFROM " . table($b);
                    }if ($_POST["all"] || ($ff && is_array($_POST["check"])) || $kd) {
                        $J = ($_POST["delete"] ? $l->delete($b, $Bh) : ($_POST["clone"] ? queries("INSERT $I$Bh") : $l->update($b, $P, $Bh)));
                        $na = $g->affected_rows;
                    } else {
                        foreach ((array)$_POST["check"] as $X) {
                            $Ah = "\nWHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($X, $o);
                            $J = ($_POST["delete"] ? $l->delete($b, $Ah, 1) : ($_POST["clone"] ? queries("INSERT" . limit1($b, $I, $Ah)) : $l->update($b, $P, $Ah, 1)));
                            if (!$J) {
                                break;
                            }$na += $g->affected_rows;
                        }
                    }
                }$D = lang(231, $na);
                if ($_POST["clone"] && $J && $na == 1) {
                    $xd = last_id();
                    if ($xd) {
                        $D = lang(161, " $xd");
                    }
                }queries_redirect(remove_from_uri($_POST["all"] && $_POST["delete"] ? "page" : ""), $D, $J);
                if (!$_POST["delete"]) {
                    edit_form($b, $o, (array)$_POST["fields"], !$_POST["clone"]);
                    page_footer();
                    exit;
                }
            } elseif (!$_POST["import"]) {
                if (!$_POST["val"]) {
                    $m = lang(232);
                } else {
                    $J = true;
                    $na = 0;
                    foreach ($_POST["val"] as $eh => $L) {
                        $P = array();foreach (
                            $L as $z => $X
                        ) {
                            $z = bracket_escape($z, 1);
                            $P[idf_escape($z)] = (preg_match('~char|text~', $o[$z]["type"]) || $X != "" ? $c->processInput($o[$z], $X) : "NULL");
                        }$J = $l->update($b, $P, " WHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($eh, $o), !$kd && !$ff, " ");
                        if (!$J) {
                            break;
                        }$na += $g->affected_rows;
                    }queries_redirect(remove_from_uri(), lang(231, $na), $J);
                }
            } elseif (!is_string($uc = get_file("csv_file", true))) {
                $m = upload_error($uc);
            } elseif (!preg_match('~~u', $uc)) {
                $m = lang(233);
            } else {
                cookie("adminer_import", "output=" . urlencode($ma["output"]) . "&format=" . urlencode($_POST["separator"]));
                $J = true;
                $Ya = array_keys($o);
                preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~', $uc, $Jd);
                $na = count($Jd[0]);
                $l->begin();
                $Rf = ($_POST["separator"] == "csv" ? "," : ($_POST["separator"] == "tsv" ? "\t" : ";"));
                $M = array();
                foreach ($Jd[0] as $z => $X) {
                    preg_match_all("~((?>\"[^\"]*\")+|[^$Rf]*)$Rf~", $X . $Rf, $Kd);
                    if (!$z && !array_diff($Kd[1], $Ya)) {
                        $Ya = $Kd[1];
                        $na--;
                    } else {
                        $P = array();
                        foreach ($Kd[1] as $t => $Ua) {
                            $P[idf_escape($Ya[$t])] = ($Ua == "" && $o[$Ya[$t]]["null"] ? "NULL" : q(str_replace('""', '"', preg_replace('~^"|"$~', '', $Ua))));
                        }$M[] = $P;
                    }
                }$J = (!$M || $l->insertUpdate($b, $M, $ff));
                if ($J) {
                    $J = $l->commit();
                }queries_redirect(remove_from_uri("page"), lang(234, $na), $J);
                $l->rollback();
            }
        }
    }$ug = $c->tableName($R);
    if (is_ajax()) {
        page_headers();
        ob_start();
    } else {
        page_header(lang(42) . ": $ug", $m);
    }$P = null;
    if (isset($Df["insert"]) || !support("table")) {
        $P = "";
        foreach ((array)$_GET["where"] as $X) {
            if ($Bc[$X["col"]] && count($Bc[$X["col"]]) == 1 && ($X["op"] == "=" || (!$X["op"] && !preg_match('~[_%]~', $X["val"])))) {
                $P .= "&set" . urlencode("[" . bracket_escape($X["col"]) . "]") . "=" . urlencode($X["val"]);
            }
        }
    }$c->selectLinks($R, $P);
    if (!$e && support("table")) {
        echo"<p class='error'>" . lang(235) . ($o ? "." : ": " . error()) . "\n";
    } else {
        echo"<form action='' id='form'>\n","<div style='display: none;'>";
        hidden_fields_get();
        echo(DB != "" ? '<input type="hidden" name="db" value="' . h(DB) . '">' . (isset($_GET["ns"]) ? '<input type="hidden" name="ns" value="' . h($_GET["ns"]) . '">' : "") : "");
        echo'<input type="hidden" name="select" value="' . h($b) . '">',"</div>\n";
        $c->selectColumnsPrint($N, $e);
        $c->selectSearchPrint($Z, $e, $x);
        $c->selectOrderPrint($ze, $e, $x);
        $c->selectLimitPrint($_);
        $c->selectLengthPrint($Fg);
        $c->selectActionPrint($x);
        echo"</form>\n";
        $F = $_GET["page"];
        if ($F == "last") {
            $Ec = $g->result(count_rows($b, $Z, $kd, $s));
            $F = floor(max(0, $Ec - 1) / $_);
        }$Mf = $N;
        $Jc = $s;
        if (!$Mf) {
            $Mf[] = "*";
            $jb = convert_fields($e, $o, $N);
            if ($jb) {
                $Mf[] = substr($jb, 2);
            }
        }foreach (
            $N as $z => $X
        ) {
            $n = $o[idf_unescape($X)];
            if ($n && ($ua = convert_field($n))) {
                $Mf[$z] = "$ua AS $X";
            }
        }if (!$kd && $gh) {
            foreach (
                $gh as $z => $X
            ) {
                $Mf[] = idf_escape($z);
                if ($Jc) {
                    $Jc[] = idf_escape($z);
                }
            }
        }$J = $l->select($b, $Mf, $Z, $Jc, $ze, $_, $F, true);
        if (!$J) {
            echo"<p class='error'>" . error() . "\n";
        } else {
            if ($y == "mssql" && $F) {
                $J->seek($_ * $F);
            }$Xb = array();
            echo"<form action='' method='post' enctype='multipart/form-data'>\n";
            $M = array();
            while ($L = $J->fetch_assoc()) {
                if ($F && $y == "oracle") {
                    unset($L["RNUM"]);
                }$M[] = $L;
            }if ($_GET["page"] != "last" && $_ != "" && $s && $kd && $y == "sql") {
                $Ec = $g->result(" SELECT FOUND_ROWS()");
            }if (!$M) {
                echo"<p class='message'>" . lang(12) . "\n";
            } else {
                $Ba = $c->backwardKeys($b, $ug);
                echo"<div class='scrollable'>","<table id='table' cellspacing='0' class='nowrap checkable'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>" . (!$s && $N ? "" : "<td><input type='checkbox' id='all-page' class='jsonly'>" . script("qs('#all-page').onclick = partial(formCheck, /check/);", "") . " <a href='" . h($_GET["modify"] ? remove_from_uri("modify") : $_SERVER["REQUEST_URI"] . "&modify=1") . "'>" . lang(236) . "</a>");
                $ae = array();
                $Gc = array();
                reset($N);
                $rf = 1;
                foreach ($M[0] as $z => $X) {
                    if (!isset($gh[$z])) {
                        $X = $_GET["columns"][key($N)];
                        $n = $o[$N ? ($X ? $X["col"] : current($N)) : $z];
                        $E = ($n ? $c->fieldName($n, $rf) : ($X["fun"] ? "*" : $z));
                        if ($E != "") {
                            $rf++;
                            $ae[$z] = $E;
                            $d = idf_escape($z);
                            $Wc = remove_from_uri('(order|desc)[^=]*|page') . '&order%5B0%5D=' . urlencode($z);
                            $Db = "&desc%5B0%5D=1";
                            echo"<th id='th[" . h(bracket_escape($z)) . "]'>" . script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});", ""),'<a href="' . h($Wc . ($ze[0] == $d || $ze[0] == $z || (!$ze && $kd && $s[0] == $d) ? $Db : '')) . '">';echo
                                apply_sql_function($X["fun"], $E) . "</a>";
                            echo"<span class='column hidden'>","<a href='" . h($Wc . $Db) . "' title='" . lang(48) . "' class='text'> â†“</a>";
                            if (!$X["fun"]) {
                                echo'<a href="#fieldset-search" title="' . lang(45) . '" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '" . js_escape($z) . "');");
                            }echo"</span>";
                        }$Gc[$z] = $X["fun"];
                        next($N);
                    }
                }$Cd = array();if ($_GET["modify"]) {
                    foreach (
                        $M as $L
                    ) {
                        foreach (
                            $L as $z => $X
                        ) {
                            $Cd[$z] = max($Cd[$z], min(40, strlen(utf8_decode($X))));
                        }
                    }
                }echo($Ba ? "<th>" . lang(237) : "") . "</thead>\n";
                if (is_ajax()) {
                    if ($_ % 2 == 1 && $F % 2 == 1) {
                        odd();
                    }ob_end_clean();
                }foreach ($c->rowDescriptions($M, $Bc) as $Zd => $L) {
                    $dh = unique_array($M[$Zd], $x);
                    if (!$dh) {
                        $dh = array();
                        foreach ($M[$Zd] as $z => $X) {
                            if (!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~', $z)) {
                                $dh[$z] = $X;
                            }
                        }
                    }$eh = "";foreach (
                        $dh as $z => $X
                    ) {
                        if (($y == "sql" || $y == "pgsql") && preg_match('~char|text|enum|set~', $o[$z]["type"]) && strlen($X) > 64) {
                            $z = (strpos($z, '(') ? $z : idf_escape($z));
                            $z = "MD5(" . ($y != 'sql' || preg_match("~^utf8~", $o[$z]["collation"]) ? $z : "CONVERT($z USING " . charset($g) . ")") . ")";
                            $X = md5($X);
                        }$eh .= "&" . ($X !== null ? urlencode("where[" . bracket_escape($z) . "]") . "=" . urlencode($X) : "null%5B%5D=" . urlencode($z));
                    }echo"<tr" . odd() . ">" . (!$s && $N ? "" : "<td>" . checkbox("check[]", substr($eh, 1), in_array(substr($eh, 1), (array)$_POST["check"])) . ($kd || information_schema(DB) ? "" : " <a href='" . h(ME . "edit=" . urlencode($b) . $eh) . "' class='edit'>" . lang(238) . "</a>"));foreach (
                        $L as $z => $X
                    ) {
                        if (isset($ae[$z])) {
                            $n = $o[$z];
                            $X = $l->value($X, $n);
                            if ($X != "" && (!isset($Xb[$z]) || $Xb[$z] != "")) {
                                $Xb[$z] = (is_mail($X) ? $ae[$z] : "");
                            }$A = "";
                            if (preg_match('~blob|bytea|raw|file~', $n["type"]) && $X != "") {
                                $A = ME . 'download=' . urlencode($b) . '&field=' . urlencode($z) . $eh;
                            }if (!$A && $X !== null) {
                                foreach ((array)$Bc[$z] as $p) {
                                    if (count($Bc[$z]) == 1 || end($p["source"]) == $z) {
                                        $A = "";
                                        foreach ($p["source"] as $t => $bg) {
                                            $A .= where_link($t, $p["target"][$t], $M[$Zd][$bg]);
                                        }$A = ($p["db"] != "" ? preg_replace('~([?&]db=)[^&]+~', '\1' . urlencode($p["db"]), ME) : ME) . 'select=' . urlencode($p["table"]) . $A;
                                        if ($p["ns"]) {
                                            $A = preg_replace('~([?&]ns=)[^&]+~', '\1' . urlencode($p["ns"]), $A);
                                        }if (count($p["source"]) == 1) {
                                            break;
                                        }
                                    }
                                }
                            }if ($z == "COUNT(*)") {
                                $A = ME . "select=" . urlencode($b);
                                $t = 0;
                                foreach ((array)$_GET["where"] as $W) {
                                    if (!array_key_exists($W["col"], $dh)) {
                                        $A .= where_link($t++, $W["col"], $W["val"], $W["op"]);
                                    }
                                }foreach (
                                    $dh as $od => $W
                                ) {
                                    $A .= where_link($t++, $od, $W);
                                }
                            }$X = select_value($X, $A, $n, $Fg);
                            $u = h("val[$eh][" . bracket_escape($z) . "]");
                            $Y = $_POST["val"][$eh][bracket_escape($z)];
                            $Sb = !is_array($L[$z]) && is_utf8($X) && $M[$Zd][$z] == $L[$z] && !$Gc[$z];
                            $Eg = preg_match('~text|lob~', $n["type"]);
                            echo"<td id='$u'";
                            if (($_GET["modify"] && $Sb) || $Y !== null) {
                                $Nc = h($Y !== null ? $Y : $L[$z]);
                                echo">" . ($Eg ? "<textarea name='$u' cols='30' rows='" . (substr_count($L[$z], "\n") + 1) . "'>$Nc</textarea>" : "<input name='$u' value='$Nc' size='$Cd[$z]'>");
                            } else {
                                $Gd = strpos($X, "<i>â€¦</i>");
                                echo" data-text='" . ($Gd ? 2 : ($Eg ? 1 : 0)) . "'" . ($Sb ? "" : " data-warning='" . h(lang(239)) . "'") . ">$X</td>";
                            }
                        }
                    }if ($Ba) {
                        echo"<td>";
                    }$c->backwardKeysPrint($Ba, $M[$Zd]);
                    echo"</tr>\n";
                }if (is_ajax()) {
                    exit;
                }echo"</table>\n","</div>\n";
            }if (!is_ajax()) {
                if ($M || $F) {
                    $ic = true;
                    if ($_GET["page"] != "last") {
                        if ($_ == "" || (count($M) < $_ && ($M || !$F))) {
                            $Ec = ($F ? $F * $_ : 0) + count($M);
                        } elseif ($y != "sql" || !$kd) {
                            $Ec = ($kd ? false : found_rows($R, $Z));
                            if ($Ec < max(1e4, 2 * ($F + 1) * $_)) {
                                $Ec = reset(slow_query(count_rows($b, $Z, $kd, $s)));
                            } else {
                                $ic = false;
                            }
                        }
                    }$Ke = ($_ != "" && ($Ec === false || $Ec > $_ || $F));
                    if ($Ke) {
                        echo(($Ec === false ? count($M) + 1 : $Ec - $F * $_) > $_ ? '<p><a href="' . h(remove_from_uri("page") . "&page=" . ($F + 1)) . '" class="loadmore">' . lang(240) . '</a>' . script("qsl('a').onclick = partial(selectLoadMore, " . (+$_) . ", '" . lang(241) . "â€¦');", "") : ''),"\n";
                    }
                }echo"<div class='footer'><div>\n";
                if ($M || $F) {
                    if ($Ke) {
                        $Md = ($Ec === false ? $F + (count($M) >= $_ ? 2 : 1) : floor(($Ec - 1) / $_));
                        echo"<fieldset>";
                        if ($y != "simpledb") {
                                echo"<legend><a href='" . h(remove_from_uri("page")) . "'>" . lang(242) . "</a></legend>",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('" . lang(242) . "', '" . ($F + 1) . "')); return false; };"),pagination(0, $F) . ($F > 5 ? " â€¦" : "");for ($t = max(1, $F - 4); $t < min($Md, $F + 5); $t++) {
                                echo
                                pagination($t, $F);
                                }if ($Md > 0) {
                                    echo($F + 5 < $Md ? " â€¦" : ""),($ic && $Ec !== false ? pagination($Md, $F) : " <a href='" . h(remove_from_uri("page") . "&page=last") . "' title='~$Md'>" . lang(243) . "</a>");
                                }
                        } else {
                            echo"<legend>" . lang(242) . "</legend>",pagination(0, $F) . ($F > 1 ? " â€¦" : ""),($F ? pagination($F, $F) : ""),($Md > $F ? pagination($F + 1, $F) . ($Md > $F + 1 ? " â€¦" : "") : "");
                        }echo"</fieldset>\n";
                    }echo"<fieldset>","<legend>" . lang(244) . "</legend>";
                    $Ib = ($ic ? "" : "~ ") . $Ec;echo
                        checkbox("all", 1, 0, ($Ec !== false ? ($ic ? "" : "~ ") . lang(143, $Ec) : ""), "var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$Ib' : checked); selectCount('selected2', this.checked || !checked ? '$Ib' : checked);") . "\n","</fieldset>\n";if ($c->selectCommandPrint()) {
                        echo'<fieldset',($_GET["modify"] ? '' : ' class="jsonly"'),'><legend>',lang(236),'</legend><div>
<input type="submit" value="',lang(14),'"',($_GET["modify"] ? '' : ' title="' . lang(232) . '"'),'>
</div></fieldset>
<fieldset><legend>',lang(120),' <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="',lang(10),'">
<input type="submit" name="clone" value="',lang(228),'">
<input type="submit" name="delete" value="',lang(18),'">',confirm(),'</div></fieldset>
';
                        }$Cc = $c->dumpFormat();
                        foreach ((array)$_GET["columns"] as $d) {
                            if ($d["fun"]) {
                                unset($Cc['sql']);
                                break;
                            }
                        }if ($Cc) {
                            print_fieldset("export", lang(62) . " <span id='selected2'></span>");
                            $Ie = $c->dumpOutput();
                            echo($Ie ? html_select("output", $Ie, $ma["output"]) . " " : ""),html_select("format", $Cc, $ma["format"])," <input type='submit' name='export' value='" . lang(62) . "'>\n","</div></fieldset>\n";
                        }$c->selectEmailPrint(array_filter($Xb, 'strlen'), $e);
                }echo"</div></div>\n";
                if ($c->selectImportPrint()) {
                    echo"<div>","<a href='#import'>" . lang(61) . "</a>",script("qsl('a').onclick = partial(toggle, 'import');", ""),"<span id='import' class='hidden'>: ","<input type='file' name='csv_file'> ",html_select("separator", array("csv" => "CSV,","csv;" => "CSV;","tsv" => "TSV"), $ma["format"], 1);
                    echo" <input type='submit' name='import' value='" . lang(61) . "'>","</span>","</div>";
                }echo"<input type='hidden' name='token' value='$T'>\n","</form>\n",(!$s && $N ? "" : script("tableCheck();"));
            }
        }
    }if (is_ajax()) {
        ob_end_clean();
        exit;
    }
} elseif (isset($_GET["variables"])) {
    $ig = isset($_GET["status"]);
    page_header($ig ? lang(112) : lang(111));
    $sh = ($ig ? show_status() : show_variables());
    if (!$sh) {
        echo"<p class='message'>" . lang(12) . "\n";
    } else {
        echo"<table cellspacing='0'>\n";foreach (
            $sh as $z => $X
        ) {
            echo"<tr>","<th><code class='jush-" . $y . ($ig ? "status" : "set") . "'>" . h($z) . "</code>","<td>" . h($X);
        }echo"</table>\n";
    }
} elseif (isset($_GET["script"])) {
    header("Content-Type: text/javascript; charset=utf-8");
    if ($_GET["script"] == "db") {
        $rg = array("Data_length" => 0,"Index_length" => 0,"Data_free" => 0);
        foreach (table_status() as $E => $R) {
            json_row("Comment-$E", h($R["Comment"]));
            if (!is_view($R)) {
                foreach (array("Engine","Collation") as $z) {
                    json_row("$z-$E", h($R[$z]));
                }foreach ($rg + array("Auto_increment" => 0,"Rows" => 0) as $z => $X) {
                    if ($R[$z] != "") {
                        $X = format_number($R[$z]);
                        json_row("$z-$E", ($z == "Rows" && $X && $R["Engine"] == ($dg == "pgsql" ? "table" : "InnoDB") ? "~ $X" : $X));
                        if (isset($rg[$z])) {
                                $rg[$z] += ($R["Engine"] != "InnoDB" || $z != "Data_free" ? $R[$z] : 0);
                        }
                    } elseif (array_key_exists($z, $R)) {
                        json_row("$z-$E");
                    }
                }
            }
        }foreach (
            $rg as $z => $X
        ) {
            json_row("sum-$z", format_number($X));
        }
        json_row("");
    } elseif ($_GET["script"] == "kill") {
        $g->query("KILL " . number($_POST["kill"]));
    } else {
        foreach (count_tables($c->databases()) as $k => $X) {
            json_row("tables-$k", $X);
            json_row("size-$k", db_size($k));
        }json_row("");
    }exit;
} else {
    $zg = array_merge((array)$_POST["tables"], (array)$_POST["views"]);
    if ($zg && !$m && !$_POST["search"]) {
        $J = true;
        $D = "";
        if ($y == "sql" && $_POST["tables"] && count($_POST["tables"]) > 1 && ($_POST["drop"] || $_POST["truncate"] || $_POST["copy"])) {
            queries("SET foreign_key_checks = 0");
        }if ($_POST["truncate"]) {
            if ($_POST["tables"]) {
                $J = truncate_tables($_POST["tables"]);
            }$D = lang(245);
        } elseif ($_POST["move"]) {
            $J = move_tables((array)$_POST["tables"], (array)$_POST["views"], $_POST["target"]);
            $D = lang(246);
        } elseif ($_POST["copy"]) {
            $J = copy_tables((array)$_POST["tables"], (array)$_POST["views"], $_POST["target"]);
            $D = lang(247);
        } elseif ($_POST["drop"]) {
            if ($_POST["views"]) {
                $J = drop_views($_POST["views"]);
            }if ($J && $_POST["tables"]) {
                $J = drop_tables($_POST["tables"]);
            }$D = lang(248);
        } elseif ($y != "sql") {
            $J = ($y == "sqlite" ? queries("VACUUM") : apply_queries("VACUUM" . ($_POST["optimize"] ? "" : " ANALYZE"), $_POST["tables"]));
            $D = lang(249);
        } elseif (!$_POST["tables"]) {
            $D = lang(9);
        } elseif ($J = queries(($_POST["optimize"] ? "OPTIMIZE" : ($_POST["check"] ? "CHECK" : ($_POST["repair"] ? "REPAIR" : "ANALYZE"))) . " TABLE " . implode(", ", array_map('idf_escape', $_POST["tables"])))) {
            while ($L = $J->fetch_assoc()) {
                $D .= "<b>" . h($L["Table"]) . "</b>: " . h($L["Msg_text"]) . "<br>";
            }
        }queries_redirect(substr(ME, 0, -1), $D, $J);
    }page_header(($_GET["ns"] == "" ? lang(26) . ": " . h(DB) : lang(189) . ": " . h($_GET["ns"])), $m, true);
    if ($c->homepage()) {
        if ($_GET["ns"] !== "") {
            echo"<h3 id='tables-views'>" . lang(250) . "</h3>\n";
            $yg = tables_list();
            if (!$yg) {
                echo"<p class='message'>" . lang(9) . "\n";
            } else {
                echo"<form action='' method='post'>\n";
                if (support("table")) {
                    echo"<fieldset><legend>" . lang(251) . " <span id='selected2'></span></legend><div>","<input type='search' name='query' value='" . h($_POST["query"]) . "'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');", "")," <input type='submit' name='search' value='" . lang(45) . "'>\n","</div></fieldset>\n";
                    if ($_POST["search"] && $_POST["query"] != "") {
                        $_GET["where"][0]["op"] = "LIKE %%";
                        search_tables();
                    }
                }echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">' . script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);", ""),'<th>' . lang(124),'<td>' . lang(252) . doc_link(array('sql' => 'storage-engines.html')),'<td>' . lang(116) . doc_link(array('sql' => 'charset-charsets.html','mariadb' => 'supported-character-sets-and-collations/')),'<td>' . lang(253) . doc_link(array('sql' => 'show-table-status.html',)),'<td>' . lang(254) . doc_link(array('sql' => 'show-table-status.html',)),'<td>' . lang(255) . doc_link(array('sql' => 'show-table-status.html')),'<td>' . lang(40) . doc_link(array('sql' => 'example-auto-increment.html','mariadb' => 'auto_increment/')),'<td>' . lang(256) . doc_link(array('sql' => 'show-table-status.html',)),(support("comment") ? '<td>' . lang(39) . doc_link(array('sql' => 'show-table-status.html',)) : ''),"</thead>\n";
                $S = 0;foreach (
                    $yg as $E => $U
                ) {
                    $vh = ($U !== null && !preg_match('~table|sequence~i', $U));
                    $u = h("Table-" . $E);
                    echo'<tr' . odd() . '><td>' . checkbox(($vh ? "views[]" : "tables[]"), $E, in_array($E, $zg, true), "", "", "", $u),'<th>' . (support("table") || support("indexes") ? "<a href='" . h(ME) . "table=" . urlencode($E) . "' title='" . lang(31) . "' id='$u'>" . h($E) . '</a>' : h($E));
                    if ($vh) {
                        echo'<td colspan="6"><a href="' . h(ME) . "view=" . urlencode($E) . '" title="' . lang(32) . '">' . (preg_match('~materialized~i', $U) ? lang(122) : lang(123)) . '</a>','<td align="right"><a href="' . h(ME) . "select=" . urlencode($E) . '" title="' . lang(30) . '">?</a>';
                    } else {
                        foreach (array("Engine" => array(),"Collation" => array(),"Data_length" => array("create",lang(33)),"Index_length" => array("indexes",lang(126)),"Data_free" => array("edit",lang(34)),"Auto_increment" => array("auto_increment=1&create",lang(33)),"Rows" => array("select",lang(30)),) as $z => $A) {
                            $u = " id='$z-" . h($E) . "'";
                            echo($A ? "<td align='right'>" . (support("table") || $z == "Rows" || (support("indexes") && $z != "Data_length") ? "<a href='" . h(ME . "$A[0]=") . urlencode($E) . "'$u title='$A[1]'>?</a>" : "<span$u>?</span>") : "<td id='$z-" . h($E) . "'>");
                        }$S++;
                    }echo(support("comment") ? "<td id='Comment-" . h($E) . "'>" : "");
                }echo"<tr><td><th>" . lang(229, count($yg)),"<td>" . h($y == "sql" ? $g->result("SELECT @@default_storage_engine") : ""),"<td>" . h(db_collation(DB, collations()));
                foreach (array("Data_length","Index_length","Data_free") as $z) {
                    echo"<td align='right' id='sum-$z'>";
                }echo"</table>\n","</div>\n";
                if (!information_schema(DB)) {
                    echo"<div class='footer'><div>\n";
                    $qh = "<input type='submit' value='" . lang(257) . "'> " . on_help("'VACUUM'");
                    $we = "<input type='submit' name='optimize' value='" . lang(258) . "'> " . on_help($y == "sql" ? "'OPTIMIZE TABLE'" : "'VACUUM OPTIMIZE'");
                    echo"<fieldset><legend>" . lang(120) . " <span id='selected'></span></legend><div>" . ($y == "sqlite" ? $qh : ($y == "pgsql" ? $qh . $we : ($y == "sql" ? "<input type='submit' value='" . lang(259) . "'> " . on_help("'ANALYZE TABLE'") . $we . "<input type='submit' name='check' value='" . lang(260) . "'> " . on_help("'CHECK TABLE'") . "<input type='submit' name='repair' value='" . lang(261) . "'> " . on_help("'REPAIR TABLE'") : ""))) . "<input type='submit' name='truncate' value='" . lang(262) . "'> " . on_help($y == "sqlite" ? "'DELETE'" : "'TRUNCATE" . ($y == "pgsql" ? "'" : " TABLE'")) . confirm() . "<input type='submit' name='drop' value='" . lang(121) . "'>" . on_help("'DROP TABLE'") . confirm() . "\n";
                    $j = (support("scheme") ? $c->schemas() : $c->databases());
                    if (count($j) != 1 && $y != "sqlite") {
                        $k = (isset($_POST["target"]) ? $_POST["target"] : (support("scheme") ? $_GET["ns"] : DB));
                        echo"<p>" . lang(263) . ": ",($j ? html_select("target", $j, $k) : '<input name="target" value="' . h($k) . '" autocapitalize="off">')," <input type='submit' name='move' value='" . lang(264) . "'>",(support("copy") ? " <input type='submit' name='copy' value='" . lang(265) . "'> " . checkbox("overwrite", 1, $_POST["overwrite"], lang(266)) : ""),"\n";
                    }echo"<input type='hidden' name='all' value=''>";echo
                                        script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));" . (support("table") ? " selectCount('selected2', formChecked(this, /^tables\[/) || $S);" : "") . " }"),"<input type='hidden' name='token' value='$T'>\n","</div></fieldset>\n","</div></div>\n";
                }echo"</form>\n",script("tableCheck();");
            }echo'<p class="links"><a href="' . h(ME) . 'create=">' . lang(63) . "</a>\n",(support("view") ? '<a href="' . h(ME) . 'view=">' . lang(195) . "</a>\n" : "");
            if (support("routine")) {
                echo"<h3 id='routines'>" . lang(136) . "</h3>\n";
                $Hf = routines();
                if ($Hf) {
                    echo"<table cellspacing='0'>\n",'<thead><tr><th>' . lang(176) . '<td>' . lang(38) . '<td>' . lang(212) . "<td></thead>\n";
                    odd('');foreach (
                        $Hf as $L
                    ) {
                        $E = ($L["SPECIFIC_NAME"] == $L["ROUTINE_NAME"] ? "" : "&name=" . urlencode($L["ROUTINE_NAME"]));
                        echo'<tr' . odd() . '>','<th><a href="' . h(ME . ($L["ROUTINE_TYPE"] != "PROCEDURE" ? 'callf=' : 'call=') . urlencode($L["SPECIFIC_NAME"]) . $E) . '">' . h($L["ROUTINE_NAME"]) . '</a>','<td>' . h($L["ROUTINE_TYPE"]),'<td>' . h($L["DTD_IDENTIFIER"]),'<td><a href="' . h(ME . ($L["ROUTINE_TYPE"] != "PROCEDURE" ? 'function=' : 'procedure=') . urlencode($L["SPECIFIC_NAME"]) . $E) . '">' . lang(129) . "</a>";
                    }echo"</table>\n";
                }echo'<p class="links">' . (support("procedure") ? '<a href="' . h(ME) . 'procedure=">' . lang(211) . '</a>' : '') . '<a href="' . h(ME) . 'function=">' . lang(210) . "</a>\n";
            }if (support("event")) {
                echo"<h3 id='events'>" . lang(137) . "</h3>\n";
                $M = get_rows("SHOW EVENTS");
                if ($M) {
                    echo"<table cellspacing='0'>\n","<thead><tr><th>" . lang(176) . "<td>" . lang(267) . "<td>" . lang(201) . "<td>" . lang(202) . "<td></thead>\n";foreach (
                        $M as $L
                    ) {
                        echo"<tr>","<th>" . h($L["Name"]),"<td>" . ($L["Execute at"] ? lang(268) . "<td>" . $L["Execute at"] : lang(203) . " " . $L["Interval value"] . " " . $L["Interval field"] . "<td>$L[Starts]"),"<td>$L[Ends]",'<td><a href="' . h(ME) . 'event=' . urlencode($L["Name"]) . '">' . lang(129) . '</a>';
                    }echo"</table>\n";
                    $gc = $g->result("SELECT @@event_scheduler");
                    if ($gc && $gc != "ON") {
                        echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: " . h($gc) . "\n";
                    }
                }echo'<p class="links"><a href="' . h(ME) . 'event=">' . lang(200) . "</a>\n";
            }if ($yg) {
                echo
                script("ajaxSetHtml('" . js_escape(ME) . "script=db');");
            }
        }
    }
}page_footer();